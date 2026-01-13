<?php

namespace App\Http\Traits;

use App\Exports\DispatchExport;
use App\Exports\EntryExport;
use App\Exports\InventoryExport;
use App\Models\InventoryMovement;
use App\Models\Stock;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Trait InventoryMovementsTrait
 * 
 * Este trait contiene métodos para gestionar movimientos de inventario (entradas y salidas).
 * Proporciona funcionalidad para:
 * - Obtener movimientos filtrables por tipo (Entrada/Salida) y búsqueda de producto
 * - Validar stock disponible antes de procesar salidas
 * - Exportar datos a Excel
 */
trait InventoryMovementsTrait
{
    /**
     * Obtiene movimientos de inventario filtrados por tipo y búsqueda de producto
     * 
     * @param string $type Tipo de movimiento: 'Entrada' o 'Salida'
     * @param string|null $search Término de búsqueda para filtrar por nombre de producto
     * @return \Illuminate\Database\Eloquent\Builder
     * 
     * Ejemplo de uso:
     * $entries = $this->getInventoryMovements('Entrada', 'papel');
     * // Retorna todas las entradas que contienen "papel" en el nombre del producto
     */
    public function getInventoryMovements($type, $search = null)
    {
        // Obtener el ID del tipo de movimiento basado en su nombre
        $movement_type_id = $this->getMovementTypeByField('name', $type)->id;
        
        // Construir la consulta base: filtrar por tipo de movimiento
        // with(['product', 'warehouse']) carga las relaciones para evitar N+1 queries
        $query = InventoryMovement::where('movement_type_id', $movement_type_id)
            ->with(['product', 'warehouse']);
        
        // Si se proporciona un término de búsqueda, filtrar por nombre de producto
        if ($search) {
            // Normalizar el término: convertir a minúsculas, eliminar acentos
            $searchTerm = $this->normalizeString($search);
            
            // whereHas: busca movimientos que tengan un producto relacionado
            // que coincida con el término de búsqueda (sin importar mayúsculas/minúsculas)
            $query->whereHas('product', function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
            });
        }
        
        // Ordenar por fecha de creación (más recientes primero)
        return $query->orderBy('created_at', 'desc');
    }
    public function getInventoryMovement($inventory_movement_id)
    {
        return InventoryMovement::find($inventory_movement_id);
    }
    public function validarStockDisponible($movement_type,$product_id,$warehouse_id): bool
    {
        // Entradas siempre son válidas
        if ($movement_type === 'Entrada') {
            return true;
        }

        // Para salidas: verificar el stock
        $stock = Stock::where('product_id', $product_id)
            ->where('warehouse_id', $warehouse_id)
            ->first();

        if (!$stock || $this->form->quantity > $stock->quantity) {
            return false;
        }

        return true;
    }
    public function exportFileEntry()
    {
        return Excel::download(new EntryExport(), $this->getNameFileToExport('entradas'));
    }
    public function exportFileDispatch()
    {
        return Excel::download(new DispatchExport, $this->getNameFileToExport('salidas'));
    }
    public function exportInventory()
    {
        return Excel::download(new InventoryExport, $this->getNameFileToExport('inventario') );
    }
    public function dataExportMovement($id)
    {
        return InventoryMovement::join('products', 'inventory_movements.product_id', '=', 'products.id')
            ->join('warehouses', 'inventory_movements.warehouse_id', '=', 'warehouses.id')
            ->join('users', 'inventory_movements.user_id', '=', 'users.id')
            ->select(
                'products.name as product_name',
                'warehouses.name as warehouse_name',
                'inventory_movements.quantity',
                'inventory_movements.movement_date',
                'inventory_movements.reference',
                'inventory_movements.notes',
                'users.name as user_name',
            )
            ->where('movement_type_id', $id)
            ->get();
    }
    public function dataExportInventory()
    {
        return Stock::join('products', 'stocks.product_id', '=', 'products.id')
            ->join('warehouses', 'stocks.warehouse_id', '=', 'warehouses.id')
            ->select(
                'products.name as product_name',
                'warehouses.name as warehouse_name',
                'stocks.quantity',
                'stocks.created_at',
                'stocks.updated_at',
            )
            ->get();
    }
    private function normalizeString($string)
    {
        /**
         * Normaliza strings para comparación sin considerar mayúsculas/minúsculas ni acentos
         * 
         * Ejemplo:
         * 'Papél Higiénico' -> 'papel higienico'
         * 'GUANTES' -> 'guantes'
         * 'Útil' -> 'util'
         */
        
        // Convertir a minúsculas usando UTF-8 para caracteres especiales
        $string = mb_strtolower($string, 'UTF-8');

        // Eliminar acentos y caracteres especiales comunes en español
        $string = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ', 'à', 'è', 'ì', 'ò', 'ù'],
            ['a', 'e', 'i', 'o', 'u', 'u', 'n', 'a', 'e', 'i', 'o', 'u'],
            $string
        );

        // Eliminar espacios en blanco al inicio y final
        return trim($string);
    }
    private function getNameFileToExport($type)
    {
        return date('Y-m-d_His') . '_' . $type . '.xlsx';
    }

}

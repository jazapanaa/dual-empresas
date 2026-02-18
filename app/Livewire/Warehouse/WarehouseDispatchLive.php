<?php

namespace App\Livewire\Warehouse;

use App\Http\Traits\DdlTrait;
use App\Http\Traits\InventoryMovementsTrait;
use App\Http\Traits\MovementTypeTrait;
use App\Livewire\Forms\InventoryMovementsForm;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Componente Livewire: WarehouseDispatchLive
 * 
 * Gestiona la interfaz de usuario para registrar SALIDAS de productos del almacén.
 * 
 * Características:
 * - Formulario para crear/actualizar salidas de inventario
 * - Búsqueda en tiempo real de productos (filtrado por nombre)
 * - Validación de stock disponible antes de procesar salidas
 * - Exportación a Excel
 * - Paginación de resultados
 * 
 * Diferencia importante con WarehouseEntryLive:
 * - Las salidas requieren validar que existe stock suficiente
 * - Las entradas siempre son válidas (agregan stock)
 */
class WarehouseDispatchLive extends Component
{
    use InventoryMovementsTrait, MovementTypeTrait, DdlTrait, WithPagination;
    
    // Formulario reactivo para manejar las salidas
    public InventoryMovementsForm $form;
    
    // Bandera para modo edición
    public bool $isEdit = false;
    
    // ID del movimiento a editar
    public int $inventory_movement_id;
    
    /**
     * IMPORTANTE: Esta propiedad vincula el campo de búsqueda de la vista.
     * Con wire:model.live, se actualiza automáticamente en tiempo real
     * mientras el usuario escribe, sin necesidad de presionar un botón.
     */
    public string $search = '';
    
    // Tipo de movimiento: 'Salida' para este componente
    private string $movement_type = 'Salida';
    
    /**
     * Método render: se ejecuta cada vez que una propiedad pública cambia
     * 
     * Devuelve la vista con datos filtrados por búsqueda
     */
    public function render()
    {
        return view('livewire.warehouse.warehouse-dispatch-live',[
            // Obtener movimientos de tipo 'Salida', filtrados por búsqueda, paginados
            'inventoryMovements' => $this->getInventoryMovements($this->movement_type, $this->search)->paginate(50),
            
            // Listados para los select del formulario
            'products' => $this->ddlProducts(),
            'warehouses' => $this->ddlWarehouses(),
        ]);
    }
    public function saveInventoryMovement():void
    {
        if (!$this->validarStockDisponible(
            $this->movement_type,$this->form->product_id,$this->form->warehouse_id
        )) {
            $this->dispatch('alert', [
                'title' => 'Error',
                'icon' => 'error',
                'message' => 'No hay suficiente stock disponible para esta salida.',
            ]);
            return;
        }

        $this->form->movement_type_id = $this->getMovementTypeByField('name', $this->movement_type)->id;
        $this->form->user_id = auth()->user()->id;

        if($this->isEdit){
            $this->form->update($this->getInventoryMovement($this->inventory_movement_id));
            $title = 'Actualizar ingreso';
            $icon = 'success';
            $message = 'Salida actualizada correctamente';
            $this->isEdit = false;
        }else{
            $this->form->store();
            $title = 'Guardar ingreso';
            $icon = 'success';
            $message = 'Salida guardada correctamente';
        }
        $this->dispatch('alert', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ]);
    }
    public function editInventoryMovement($inventory_movement_id):void
    {
        $this->form->show($this->getInventoryMovement($inventory_movement_id));
        $this->isEdit = true;
        $this->inventory_movement_id = $inventory_movement_id;
    }
    public function deleteInventoryMovement($inventory_movement_id):void
    {
        $this->form->delete($inventory_movement_id, $this->movement_type);
    }
    public function mount()
    {
        $this->form->movement_date = now()->format('Y-m-d\TH:i');
    }
    public function exportFile()
    {
        return $this->exportFileDispatch();
    }
}

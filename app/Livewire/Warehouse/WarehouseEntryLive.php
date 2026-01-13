<?php

namespace App\Livewire\Warehouse;

use App\Http\Traits\InventoryMovementsTrait;
use App\Http\Traits\DdlTrait;
use App\Http\Traits\MovementTypeTrait;
use App\Livewire\Forms\InventoryMovementsForm;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Componente Livewire: WarehouseEntryLive
 * 
 * Gestiona la interfaz de usuario para registrar ENTRADAS de productos al almacén.
 * 
 * Características:
 * - Formulario para crear/actualizar entradas de inventario
 * - Búsqueda en tiempo real de productos (filtrado por nombre)
 * - Validación de datos
 * - Exportación a Excel
 * - Paginación de resultados
 * 
 * Flujo de datos:
 * Usuario -> Livewire Component -> Trait (InventoryMovementsTrait) -> Base de datos
 */
class WarehouseEntryLive extends Component
{
    use InventoryMovementsTrait, MovementTypeTrait, DdlTrait, WithPagination;
    
    // Formulario reactivo para manejar las entradas
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
    
    // Tipo de movimiento: 'Entrada' para este componente
    private string $movement_type = 'Entrada';
    
    /**
     * Método render: se ejecuta cada vez que una propiedad pública cambia
     * 
     * Este es el corazón del componente Livewire. Se ejecuta automáticamente cuando:
     * - La propiedad $search cambia (usuario escribe en el campo de búsqueda)
     * - Se edita un registro
     * - Se guarda/elimina un registro
     * 
     * Devuelve la vista con datos filtrados
     */
    public function render()
    {
        return view('livewire.warehouse.warehouse-entry-live',[
            // Obtener movimientos de tipo 'Entrada', filtrados por búsqueda, paginados
            'inventoryMovements' => $this->getInventoryMovements($this->movement_type, $this->search)->paginate(50),
            
            // Listados para los select del formulario
            'products' => $this->ddlProducts(),
            'warehouses' => $this->ddlWarehouses(),
        ]);
    }
    public function saveInventoryMovement():void
    {
        $this->form->movement_type_id = $this->getMovementTypeByField('name', $this->movement_type)->id;
        $this->form->user_id = auth()->user()->id;
        if($this->isEdit){
            $this->form->update($this->getInventoryMovement($this->inventory_movement_id));
            $title = 'Actualizar ingreso';
            $icon = 'success';
            $message = 'Ingreso actualizado correctamente';
            $this->isEdit = false;
        }else{
            $this->form->store();
            $title = 'Guardar ingreso';
            $icon = 'success';
            $message = 'Ingreso guardado correctamente';
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
        $this->form->delete($inventory_movement_id,$this->movement_type);
    }
    public function mount()
    {
        $this->form->movement_date = now()->format('Y-m-d\TH:i');
    }
    public function exportFile()
    {
        return $this->exportFileEntry();
    }
}

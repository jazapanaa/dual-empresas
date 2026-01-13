<?php

namespace App\Livewire\Warehouse;

use App\Http\Traits\InventoryMovementsTrait;
use App\Http\Traits\DdlTrait;
use App\Http\Traits\MovementTypeTrait;
use App\Livewire\Forms\InventoryMovementsForm;
use Livewire\Component;
use Livewire\WithPagination;

class WarehouseEntryLive extends Component
{
    use InventoryMovementsTrait,MovementTypeTrait, DdlTrait, WithPagination;
    public InventoryMovementsForm $form;
    public bool $isEdit = false;
    public int $inventory_movement_id;
    public string $search = '';
    private string $movement_type = 'Entrada';
    public function render()
    {
        return view('livewire.warehouse.warehouse-entry-live',[
            'inventoryMovements' => $this->getInventoryMovements($this->movement_type, $this->search)->paginate(50),
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

<?php

namespace App\Livewire\Warehouse;

use App\Http\Traits\WarehouseTrait;
use App\Http\Traits\DdlTrait;
use App\Livewire\Forms\WarehouseForm;
use Livewire\Component;
use Livewire\WithPagination;

class WarehouseLive extends Component
{
    use WarehouseTrait, DdlTrait, WithPagination;
    public WarehouseForm $form;
    public bool $isEdit = false;
    public int $warehouse_id;
    public function render()
    {
        return view('livewire.warehouse.warehouse-live',[
            'warehouses' => $this->getWarehouses()->paginate(50),
        ]);
    }
    public function saveWarehouse():void
    {
        if($this->isEdit){
            $this->form->update($this->getWarehouse($this->warehouse_id));
            $title = 'Categoría actualizada';
            $icon = 'success';
            $message = 'Categoría actualizada correctamente';
            $this->isEdit = false;
        }else{
            $this->form->store();
            $title = 'Categoría guardada';
            $icon = 'success';
            $message = 'Categoría guardada correctamente';
        }
        $this->dispatch('alert', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ]);
    }
    public function editWarehouse($warehouse_id):void
    {
        $this->form->show($this->getWarehouse($warehouse_id));
        $this->isEdit = true;
        $this->warehouse_id = $warehouse_id;
    }
    public function deleteWarehouse($warehouse_id):void
    {
        $this->form->delete($warehouse_id);
    }
}

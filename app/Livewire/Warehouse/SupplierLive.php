<?php

namespace App\Livewire\Warehouse;

use App\Http\Traits\DdlTrait;
use App\Http\Traits\SupplierTrait;
use App\Livewire\Forms\SupplierForm;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierLive extends Component
{
    use SupplierTrait, DdlTrait, WithPagination;
    public SupplierForm $form;
    public bool $isEdit = false;
    public int $supplier_id;
    public function render()
    {
        return view('livewire.warehouse.supplier-live',[
            'suppliers'=> $this->getSuppliers()->paginate(50),
        ]);
    }
    public function saveSupplier():void
    {
        if($this->isEdit){
            $sw1 = $this->form->update($this->getSupplier($this->supplier_id));
            $title = 'Categoría actualizada';
            $icon = 'success';
            $message = 'Categoría actualizada correctamente';
            $this->isEdit = false;
        }else{
            $sw2 = $this->form->store();
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
    public function editSupplier($supplier_id):void
    {
        $this->form->show($this->getSupplier($supplier_id));
        $this->isEdit = true;
        $this->supplier_id = $supplier_id;
    }
    public function deleteSupplier($supplier_id):void
    {
        $this->form->delete($supplier_id);
    }
}

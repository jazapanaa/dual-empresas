<?php

namespace App\Livewire\Warehouse;

use App\Http\Traits\DdlTrait;
use App\Http\Traits\UnitTrait;
use App\Livewire\Forms\UnitForm;
use Livewire\Component;
use Livewire\WithPagination;

class UnitLive extends Component
{
    use unitTrait, DdlTrait, WithPagination;
    public UnitForm $form;
    public bool $isEdit = false;
    public int $unit_id;
    public function render()
    {
        return view('livewire.warehouse.unit-live',[
            'units' => $this->getUnits()->paginate(50),
        ]);
    }
    public function saveUnit():void
    {
        if($this->isEdit){
            $sw1 = $this->form->update($this->getUnit($this->unit_id));
            $title = 'Unidad actualizada';
            $icon = 'success';
            $message = 'Unidad actualizada correctamente';
            $this->isEdit = false;
        }else{
            $sw2 = $this->form->store();
            $title = 'Unidad guardada';
            $icon = 'success';
            $message = 'Unidad guardada correctamente';
        }
        $this->dispatch('alert', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ]);
    }
    public function editUnit($unit_id):void
    {
        $this->form->show($this->getUnit($unit_id));
        $this->isEdit = true;
        $this->unit_id = $unit_id;
    }
    public function deleteUnit($unit_id):void
    {
        $this->form->delete($unit_id);
    }
}

<?php

namespace App\Livewire\Warehouse;

use App\Http\Traits\MovementTypeTrait;
use App\Http\Traits\DdlTrait;
use App\Livewire\Forms\MovementsTypeForm;
use Livewire\Component;
use Livewire\WithPagination;

class MovementsTypeLive extends Component
{
    use MovementTypeTrait, DdlTrait, WithPagination;
    public MovementsTypeForm $form;
    public bool $isEdit = false;
    public int $movement_type_id;
    public function render()
    {
        return view('livewire.warehouse.movements-type-live',[
            'movements_type' => $this->getMovementsType()->paginate(50),
        ]);
    }
    public function saveMovementType():void
    {
        if($this->isEdit){
            $sw1 = $this->form->update($this->getMovementType($this->movement_type_id));
            $title = 'Tipo de movimiento actualizado';
            $icon = 'success';
            $message = 'Tipo de movimiento actualizado correctamente';
            $this->isEdit = false;
        }else{
            $sw2 = $this->form->store();
            $title = 'Tipo de movimiento guardado';
            $icon = 'success';
            $message = 'Tipo de movimiento guardado correctamente';
        }
        $this->dispatch('alert', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ]);
    }
    public function editMovementType($movement_type_id):void
    {
        $this->form->show($this->getMovementType($movement_type_id));
        $this->isEdit = true;
        $this->movement_type_id = $movement_type_id;
    }
    public function deleteMovementType($movement_type_id):void
    {
        $this->form->delete($movement_type_id);
    }
}

<?php

namespace App\Livewire\Users;

use App\Http\Traits\DdlTrait;
use App\Http\Traits\RoleTrait;
use App\Livewire\Forms\RoleForm;
use Livewire\Component;
use Livewire\WithPagination;

class RoleLive extends Component
{
    use RoleTrait, DdlTrait, WithPagination;
    public RoleForm $form;
    public bool $isEdit = false;
    public int $role_id;
    public function render()
    {
        return view('livewire.users.role-live',[
            'roles' => $this->getRoles()->paginate(50),
        ]);
    }
    public function saveRole():void
    {
        if($this->isEdit){
            $this->form->update($this->getRole($this->role_id));
            $title = 'Role actualizado';
            $icon = 'success';
            $message = 'Role actualizado correctamente';
            $this->isEdit = false;
        }else{
            $this->form->store();
            $title = 'Role guardado';
            $icon = 'success';
            $message = 'Role guardado correctamente';
        }
        $this->dispatch('alert', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ]);
    }
    public function editRole($role_id):void
    {
        $this->form->show($this->getRole($role_id));
        $this->isEdit = true;
        $this->role_id = $role_id;
    }
    public function deleteRole($role_id):void
    {
        $this->form->delete($role_id);
    }
}

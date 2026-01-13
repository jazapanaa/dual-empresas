<?php

namespace App\Livewire\Users;

use App\Http\Traits\DdlTrait;
use App\Http\Traits\PermissionTrait;
use App\Livewire\Forms\PermissionForm;
use Livewire\Component;
use Livewire\WithPagination;

class PermissionLive extends Component
{
    use PermissionTrait, DdlTrait, WithPagination;
    public PermissionForm $form;
    public bool $isEdit = false;
    public int $permission_id;
    public function render()
    {
        return view('livewire.users.permission-live',[
            'permissions' => $this->getPermissions()->paginate(50),
        ]);
    }
    public function savePermission():void
    {
        if($this->isEdit){
            $this->form->update($this->getPermission($this->permission_id));
            $title = 'Permission actualizado';
            $icon = 'success';
            $message = 'Permission actualizado correctamente';
            $this->isEdit = false;
        }else{
            $this->form->store();
            $title = 'Permission guardado';
            $icon = 'success';
            $message = 'Permission guardado correctamente';
        }
        $this->dispatch('alert', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ]);
    }
    public function editPermission($permission_id):void
    {
        $this->form->show($this->getPermission($permission_id));
        $this->isEdit = true;
        $this->permission_id = $permission_id;
    }
    public function deletePermission($permission_id):void
    {
        $this->form->delete($permission_id);
    }
}

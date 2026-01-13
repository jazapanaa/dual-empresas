<?php

namespace App\Livewire\Users;

use App\Http\Traits\UserTrait;
use App\Http\Traits\DdlTrait;
use App\Livewire\Forms\UserForm;
use Livewire\Component;
use Livewire\WithPagination;

class UserLive extends Component
{
    use UserTrait, DdlTrait, WithPagination;
    public UserForm $form;
    public bool $isEdit = false;
    public int $user_id;

    public function render()
    {
        return view('livewire.users.user-live',[
            'users' => $this->getUsers()->paginate(10),
            'roles' => $this->ddlRoles(),
            'permissions' => $this->ddlPermissions(),
        ]);
    }
    public function saveUser():void
    {
        if($this->isEdit){
            $this->form->update($this->getUser($this->user_id));
            $title = 'Usuario actualizado';
            $icon = 'success';
            $message = 'Usuario actualizado correctamente';
            $this->isEdit = false;
        }else{
            $this->form->store();
            $title = 'Usuario guardado';
            $icon = 'success';
            $message = 'Usuario guardado correctamente';
        }
        $this->dispatch('alert', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ]);
    }
    public function editUser($user_id):void
    {
        $this->form->show($this->getUser($user_id));
        $this->isEdit = true;
        $this->user_id = $user_id;
    }
    public function deleteUser($user_id):void
    {
        $this->form->delete($user_id);
    }
}

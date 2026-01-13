<?php

namespace App\Livewire\Users;

use App\Http\Traits\DdlTrait;
use App\Http\Traits\RoleTrait;
use Livewire\Component;

class RolePermissionLive extends Component
{
    use RoleTrait,DdlTrait;
    public int $role_id;
    public $select_permission;

    public function render()
    {
        return view('livewire.users.role-permission-live',[
            'permissions' => $this->getRole($this->role_id)->permissions,
            'role' => $this->getRole($this->role_id),
            'ddl_permissions' => $this->ddlPermissions()
        ]);
    }
    public function mount($role_id)
    {
        $this->role_id = $role_id;
    }
    public function addPermission()
    {
        $this->givePermissionToRole($this->role_id, $this->select_permission);
    }
    public function removePermission($permission_id)
    {
        $this->revokePermissionToRole($this->role_id, $permission_id);
    }
}

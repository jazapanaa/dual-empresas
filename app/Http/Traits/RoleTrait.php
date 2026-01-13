<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

trait RoleTrait
{
    public function getRoles()
    {
        return Role::orderBy('name');
    }
    public function getRole($role_id)
    {
        return Role::find($role_id);
    }
    public function givePermissionToRole($role_id, $permission_id)
    {
        $role = Role::find($role_id);
        $permission = Permission::find($permission_id);

        if (!$role || !$permission) {
            Log::warning("Asignación fallida: Rol o Permiso no encontrado", [
                'role_id' => $role_id,
                'permission_id' => $permission_id,
            ]);
            return false;
        }

        if (!$role->hasPermissionTo($permission)) {
            $role->givePermissionTo($permission);
        }

        return true;
    }

    public function revokePermissionToRole($role_id, $permission_id)
    {
        $role = Role::find($role_id);
        $permission = Permission::find($permission_id);

        if (!$role || !$permission) {
            Log::warning("Revocación fallida: Rol o Permiso no encontrado", [
                'role_id' => $role_id,
                'permission_id' => $permission_id,
            ]);
            return false;
        }

        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
        }

        return true;
    }

}

<?php

namespace App\Http\Traits;

use Spatie\Permission\Models\Permission;

trait PermissionTrait
{
    public function getPermissions()
    {
        return Permission::query();
    }
    public function getPermission($permission_id)
    {
        return Permission::find($permission_id);
    }

}

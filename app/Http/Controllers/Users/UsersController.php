<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function pageUsers(Request $request)
    {
        return view('users.users');
    }

    public function pageRoles(Request $request)
    {
        return view('users.roles');
    }

    public function pagePermissions(Request $request)
    {
        return view('users.permissions');
    }
    public function pageAudits(Request $request)
    {
        return view('users.audits');
    }
    public function pageRolePermissions($role_id)
    {
        return view('users.role-permissions', [
            'role_id' => $role_id,
        ]);
    }
}

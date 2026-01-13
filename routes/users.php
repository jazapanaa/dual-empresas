<?php

use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','verified'])
    ->prefix('users')
    ->name('users.')
    ->group(function () {

        Route::get('users', [UsersController::class, 'pageUsers'])
            ->name('users');
        Route::get('roles', [UsersController::class, 'pageRoles'])
            ->middleware('role:administrator')
            ->name('roles');
        Route::get('permissions', [UsersController::class, 'pagePermissions'])
            ->middleware('role:administrator')
            ->name('permissions');
        Route::get('audits', [UsersController::class, 'pageAudits'])
            ->middleware('role:administrator')
            ->name('audits');
        Route::get('role-permissions/{role_id}', [UsersController::class, 'pageRolePermissions'])
            ->middleware('role:administrator')
            ->name('role.permissions');
    });


<?php

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','verified','role:administrator'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('settings-modules', [SettingController::class, 'pageModules'])
            ->name('settings.modules');
    });


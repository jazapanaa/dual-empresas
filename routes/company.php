<?php

use App\Http\Controllers\Company\CompanyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','verified'])
    ->prefix('company')
    ->name('company.')
    ->group(function () {

    Route::get('edit', [CompanyController::class, 'index'])
        ->name('index');
});


<?php

use App\Http\Controllers\Warehouse\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','verified'])
    ->prefix('warehouse')
    ->name('warehouse.')
    ->group(function () {

    Route::get('products', [WarehouseController::class, 'pageProducts'])
        ->name('products');
    Route::get('product/suppliers/{product_id}',[WarehouseController::class, 'pageProductSuppliers'])
        ->name('product.suppliers');
    Route::get('entries', [WarehouseController::class, 'pageEntries'])
        ->name('entries');
    Route::get('dispatches', [WarehouseController::class, 'pageDispatches'])
        ->name('dispatches');
    Route::get('movements-type', [WarehouseController::class, 'pageMovementsType'])
        ->name('movements-type');
    Route::get('suppliers', [WarehouseController::class, 'pageSuppliers'])
        ->name('suppliers');
    Route::get('categories', [WarehouseController::class, 'pageCategories'])
        ->name('categories');
    Route::get('units', [WarehouseController::class, 'pageUnits'])
        ->name('units');
    Route::get('/', [WarehouseController::class, 'index'])
        ->name('index');
    Route::get('inventory', [WarehouseController::class, 'pageInventory'])
        ->name('inventory');
});


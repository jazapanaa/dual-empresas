<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        return view('warehouse.index');
    }
    public function pageCategories()
    {
        return view('warehouse.category.index');

    }
    public function pageUnits()
    {
        return view('warehouse.unit.index');
    }
    public function pageEntries()
    {
        return view('warehouse.entry.index');
    }
    public function pageDispatches()
    {
        return view('warehouse.dispatch.index');
    }
    public function pageProducts()
    {
        return view('warehouse.product.index');
    }
    public function pageSuppliers()
    {
        return view('warehouse.supplier.index');
    }
    public function pageMovementsType()
    {
        return view('warehouse.movements-type.index');
    }
    public function pageProductSuppliers($product_id)
    {
        return view('warehouse.product.suppliers', ['product_id' => $product_id]);
    }
    public function pageInventory()
    {
        return view('warehouse.inventory.index');
    }
}

<?php

namespace App\Http\Traits;

use App\Models\Warehouse;

trait WarehouseTrait
{
    public function getWarehouses()
    {
        return Warehouse::query();
    }
    public function getWarehouse($warehouse_id)
    {
        return Warehouse::find($warehouse_id);
    }
    public function getWarehouseByField($key, $value)
    {
        return Warehouse::where($key, $value)->first();
    }

}

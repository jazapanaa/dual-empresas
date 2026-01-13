<?php

namespace App\Http\Traits;

use App\Models\Stock;

trait StockTrait
{
    public function getStocks()
    {
        return Stock::query();
    }
    public function getStock($category_id)
    {
        return Stock::find($category_id);
    }
    public function getStockInstance($product_id,$warehouse_id)
    {
        return Stock::firstOrCreate([
            'product_id' => $product_id,
            'warehouse_id' => $warehouse_id,
        ]);
    }

}

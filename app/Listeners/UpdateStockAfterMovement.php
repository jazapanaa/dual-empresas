<?php

namespace App\Listeners;

use App\Events\InventoryMovementCreated;
use App\Http\Traits\MovementTypeTrait;
use App\Http\Traits\StockTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStockAfterMovement
{
    use MovementTypeTrait,StockTrait;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InventoryMovementCreated $event): void
    {
        $movement = $event->movement;
        $type = $this->getMovementType($movement->movement_type_id)->name;
        $stock = $this->getStockInstance($movement->product_id, $movement->warehouse_id);
        $delta = $type === 'Entrada' ? $movement->quantity : -$movement->quantity;
        if ($stock->quantity + $delta < 0) {
            throw new \Exception("Stock insuficiente para salida");
        }

        $stock->quantity += $delta;
        $stock->save();
    }
}

<?php

namespace App\Http\Traits;

use App\Models\InventoryMovement;
use App\Models\MovementType;

trait MovementsTrait
{
    public function getInventoryMovements($type)
    {
        return InventoryMovement::join('movement_types', 'movement_types.id', '=', 'inventory_movements.movement_type_id')
            ->with(['product', 'user'])
            ->where('movement_types.name', $type)
            ->orderBy('created_at', 'desc');
    }
    public function getInvetoryMovement($inventory_movement_id)
    {
        return InventoryMovement::find($inventory_movement_id);
    }
    public function getMovementType($key,$value)
    {
        return MovementType::where($key, $value)->first();
    }

}

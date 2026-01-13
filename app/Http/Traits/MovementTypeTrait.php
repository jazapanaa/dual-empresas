<?php

namespace App\Http\Traits;

use App\Models\MovementType;

trait MovementTypeTrait
{
    public function getMovementsType()
    {
        return MovementType::query();
    }
    public function getMovementType($movement_type_id)
    {
        return MovementType::find($movement_type_id);
    }
    public function getMovementTypeByField($key, $value)
    {
        return MovementType::where($key, $value)->first();
    }

}

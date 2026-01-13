<?php

namespace App\Http\Traits;

use App\Models\Unit;

trait UnitTrait
{
    public function getUnits()
    {
        return Unit::query();
    }
    public function save($data)
    {
        Unit::create([
            'code' => $data['code'],
            'description' => $data['description'],
            'active' => $data['active']
        ]);
        $this->reset();

    }
    public function getUnit($unit_id)
    {
        return Unit::find($unit_id);
    }

}

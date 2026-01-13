<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = ['id'];
    protected function ActiveText(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->active ? 'Activo' : 'Inactivo',
        );
    }
}

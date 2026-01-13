<?php

namespace App\Http\Traits;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Warehouse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

trait DdlTrait
{
    public function ddlPermissions()
    {
        return $this->getDdl(Permission::class, 'id', 'name');
    }

    public function ddlRoles()
    {
        if (auth()->user()->hasRole('administrator')) {
            return $this->getDdl(Role::class, 'id', 'name');
        } else {
            return $this->getDdlWithCondition(
                Role::class,
                [['name' , '!=', 'administrator']]
            );
        }
    }

    public function ddlWarehouses()
    {
        return $this->getDdl(Warehouse::class, 'id', 'name');
    }

    public function ddlProducts()
    {
        return $this->getDdl(Product::class, 'id', 'name');
    }

    public function ddlCategories()
    {
        return $this->getDdl(Category::class, 'id', 'name');
    }

    public function ddlUnits()
    {
        return $this->getDdl(Unit::class, 'id', 'description');
    }

    public function ddlSuppliers()
    {
        return $this->getDdl(Supplier::class, 'id', 'name');
    }

    public function getDdl($model, $key = 'id', $value = 'code')
    {
        return $model::query()->pluck($value, $key);
    }

    public function getDdlWithCondition($model, $condition, $key = 'id', $value = 'name')
    {
        return $model::query()->where($condition)->pluck($value, $key);
    }

}

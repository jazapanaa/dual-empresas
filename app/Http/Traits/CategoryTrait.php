<?php

namespace App\Http\Traits;

use App\Models\Category;

trait CategoryTrait
{
    public function getCategories()
    {
        return Category::query();
    }
    public function save($data)
    {
        Category::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'active' => $data['active']
        ]);
        $this->reset();

    }
    public function getCategory($category_id)
    {
        return Category::find($category_id);
    }

}

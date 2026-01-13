<?php

namespace App\Livewire\Forms;

use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CategoryForm extends Form
{
    #[Validate('required')]
    public string $name = '';
    #[Validate('required')]
    public string $description = '';
    #[Validate('required')]
    public bool $active = true;

    public function store()
    {
        $this->validate();

        Category::create(
            $this->only(['name', 'description', 'active'])
        );
        $this->reset();
    }
    public function show(Category $category): void
    {
        $this->fill([
            'name' => $category->name,
            'description' => $category->description,
            'active' => (bool)$category->active,
        ]);
    }
    public function update(Category $category): void
    {
        $this->validate();

        $category->update(
            $this->only(['name', 'description', 'active'])
        );
        $this->reset();
    }
    public function delete($category_id): void
    {
        $category = Category::find($category_id);
        $category->delete();
    }
}

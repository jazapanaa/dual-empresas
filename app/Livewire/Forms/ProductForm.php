<?php

namespace App\Livewire\Forms;

use App\Models\Product;use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductForm extends Form
{
    public string $code = '';
    #[Validate('required')]
    public string $name = '';

    public string $description = '';
    #[Validate('required')]
    public int $category_id = 0;
    #[Validate('required')]
    public int $unit_id = 0;

    public $dataProduct = ['code', 'name', 'description', 'category_id', 'unit_id'];

    public function store()
    {
        $this->validate();

        Product::create(
            $this->only($this->dataProduct)
        );
        $this->reset();
    }
    public function show(Product $product): void
    {
        $this->fill([
            'code' => $product->code ?? '',
            'name' => $product->name ?? '',
            'description' => $product->description ?? '',
            'category_id' => $product->category_id ?? 0,
            'supplier_id' => $product->supplier_id ?? 0,
            'unit_id' => $product->unit_id ?? 0,
            'cost_price' => $product->cost_price ?? 0,
        ]);
    }
    public function update(Product $product): void
    {
        $this->validate();

        $product->update(
            $this->only($this->dataProduct)
        );
        $this->reset();
    }
    public function delete($product_id): void
    {
        $product = Product::find($product_id);
        $product->delete();
    }
}

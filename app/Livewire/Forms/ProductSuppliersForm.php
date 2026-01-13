<?php

namespace App\Livewire\Forms;

use App\Models\ProductSupplier;use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductSuppliersForm extends Form
{
    public int $product_id = 0;
    #[Validate('required')]
    public int $supplier_id = 0;

    #[Validate('required')]
    public float $cost_price = 0;

    public array $data = ['product_id', 'supplier_id', 'cost_price'];

    public function store()
    {
        $this->validate();

        ProductSupplier::create(
            $this->only($this->data)
        );
        $this->reset();
    }
    public function show(ProductSupplier $product_supplier): void
    {
        $this->fill([
            'product_id' => $product_supplier->product_id,
            'supplier_id' => $product_supplier->supplier_id,
            'cost_price' => $product_supplier->cost_price,
        ]);
    }
    public function update(ProductSupplier $product_supplier): void
    {
        $this->validate();

        $product_supplier->update(
            $this->only($this->data)
        );
        $this->reset();
    }
    public function delete($product_supplier_id): void
    {
        $product_supplier = ProductSupplier::find($product_supplier_id);
        $product_supplier->delete();
    }
}

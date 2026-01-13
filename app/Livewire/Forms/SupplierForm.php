<?php

namespace App\Livewire\Forms;

use App\Models\Supplier;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SupplierForm extends Form
{
    #[Validate('required')]
    public string $name = '';
    #[Validate('required')]
    public string $ruc = '';
    #[Validate('required')]
    public string $phone = '';
    #[Validate('required')]
    public string $email = '';
    #[Validate('required')]
    public string $address = '';

    public function store()
    {
        $this->validate();

        Supplier::create(
            $this->only(['name', 'ruc', 'phone', 'email', 'address'])
        );
        $this->reset();
    }
    public function show(Supplier $supplier): void
    {
        $this->fill([
            'name' => $supplier->name ?? '',
            'ruc' => $supplier->ruc ?? '',
            'phone' => $supplier->phone ?? '',
            'email' => $supplier->email ?? '',
            'address' => $supplier->address ?? '',
        ]);
    }
    public function update(Supplier $supplier): void
    {
        $this->validate();

        $supplier->update(
            $this->only(['name', 'ruc', 'phone', 'email', 'address'])
        );
        $this->reset();
    }
    public function delete($supplier_id): void
    {
        $supplier = Supplier::find($supplier_id);
        $supplier->delete();
    }
}

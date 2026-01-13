<?php

namespace App\Livewire\Forms;

use App\Models\Warehouse;
use Livewire\Attributes\Validate;
use Livewire\Form;

class WarehouseForm extends Form
{
    #[Validate('required')]
    public string $name = '';
    #[Validate('required')]
    public string $location = '';

    public function store()
    {
        $this->validate();

        Warehouse::create(
            $this->only(['name', 'location'])
        );
        $this->reset();
    }
    public function show(Warehouse $warehouse): void
    {
        $this->fill([
            'name' => $warehouse->name,
            'location' => $warehouse->location,
        ]);
    }
    public function update(Warehouse $warehouse): void
    {
        $this->validate();

        $warehouse->update(
            $this->only(['name', 'location'])
        );
        $this->reset();
    }
    public function delete($warehouse_id): void
    {
        $warehouse = Warehouse::find($warehouse_id);
        $warehouse->delete();
    }
}

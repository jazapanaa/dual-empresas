<?php

namespace App\Livewire\Forms;

use App\Models\MovementType;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MovementsTypeForm extends Form
{
    #[Validate('required')]
    public string $name = '';
    #[Validate('required')]
    public string $description = '';

    public function store()
    {
        $this->validate();

        MovementType::create(
            $this->only(['name', 'description'])
        );
        $this->reset();
    }
    public function show(MovementType $movement_type): void
    {
        $this->fill([
            'name' => $movement_type->name,
            'description' => $movement_type->description,
        ]);
    }
    public function update(MovementType $movement_type): void
    {
        $this->validate();

        $movement_type->update(
            $this->only(['name', 'description'])
        );
        $this->reset();
    }
    public function delete($movement_type_id): void
    {
        $movement_type = MovementType::find($movement_type_id);
        $movement_type->delete();
    }
}

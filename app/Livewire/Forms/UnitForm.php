<?php

namespace App\Livewire\Forms;

use App\Models\Unit;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UnitForm extends Form
{
    #[Validate('required')]
    public string $code = '';
    #[Validate('required')]
    public string $description = '';
    #[Validate('required')]
    public bool $active = true;

    public function store()
    {
        $this->validate();

        Unit::create(
            $this->only(['code', 'description', 'active'])
        );
        $this->reset();
    }
    public function show(Unit $unit): void
    {
        $this->fill([
            'code' => $unit->code,
            'description' => $unit->description,
            'active' => (bool)$unit->active,
        ]);
    }
    public function update(Unit $unit): void
    {
        $this->validate();

        $unit->update(
            $this->only(['code', 'description', 'active'])
        );
        $this->reset();
    }
    public function delete($unit_id): void
    {
        $unit = Unit::find($unit_id);
        $unit->delete();
    }
}

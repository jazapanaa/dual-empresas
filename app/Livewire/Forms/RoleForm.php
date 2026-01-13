<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class RoleForm extends Form
{
    #[Validate('required')]
    public string $name = '';
    public array $data = ['name'];

    public function store()
    {
        $this->validate();

        Role::create(
            $this->only($this->data)
        );
        $this->reset();
    }
    public function show(Role $role): void
    {
        $this->fill([
            'name' => $role->name,
        ]);
    }
    public function update(Role $role): void
    {
        $this->validate();

        $role->update(
            $this->only($this->data)
        );
        $this->reset();
    }
    public function delete($role_id): void
    {
        $role = Role::find($role_id);
        $role->delete();
    }
}

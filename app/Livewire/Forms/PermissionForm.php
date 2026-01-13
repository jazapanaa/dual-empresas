<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Spatie\Permission\Models\Permission;

class PermissionForm extends Form
{
    #[Validate('required')]
    public string $name = '';
    public array $data = ['name'];

    public function store()
    {
        $this->validate();

        Permission::create(
            $this->only($this->data)
        );
        $this->reset();
    }
    public function show(Permission $permission): void
    {
        $this->fill([
            'name' => $permission->name,
        ]);
    }
    public function update(Permission $permission): void
    {
        $this->validate();

        $permission->update(
            $this->only($this->data)
        );
        $this->reset();
    }
    public function delete($permission_id): void
    {
        $permission = Permission::find($permission_id);
        $permission->delete();
    }
}

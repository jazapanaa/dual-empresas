<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    #[Validate('required')]
    public string $name = '';
    #[Validate('required')]
    public string $email = '';
    #[Validate('required')]
    public string $password = '';
    #[Validate('required')]
    public bool $active = true;
    #[Validate('required')]
    public string $role = '';
    public array $data = ['name', 'email', 'password', 'active'];

    public function store()
    {
        $this->validate();

        User::create(
            $this->only($this->data)
        )->assignRole($this->role);
        $this->reset();
    }
    public function show(User $User): void
    {
        $this->fill([
            'name' => $User->name,
            'email' => $User->email,
            'password' => $User->password,
            'active' => (bool)$User->active,
            'role' => $User->getRoleNames()->first(),
        ]);
    }
    public function update(User $User): void
    {
        $this->validate();

        $User->update(
            $this->only($this->data)
        );
        $User->syncRoles($this->role);
        $this->reset();
    }
    public function delete($User_id): void
    {
        $User = User::find($User_id);
        $User->delete();
    }
}

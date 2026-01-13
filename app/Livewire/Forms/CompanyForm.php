<?php

namespace App\Livewire\Forms;

use App\Models\Company;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CompanyForm extends Form
{
    #[Validate('required')]
    public string $name = '';
    #[Validate('required')]
    public string $address = '';
    #[Validate('required')]
    public string $phone = '';
    #[Validate('required')]
    public string $email = '';
    #[Validate('required')]
    public string $website = '';
    public string $logo = '';

    public array $data = ['name', 'address', 'phone', 'email', 'website', 'logo'];

    public function store()
    {
        $this->validate();

        Company::create(
            $this->only($this->data)
        );
        $this->reset();
    }
    public function show(Company $company): void
    {
        $this->fill([
            'name' => $company->name,
            'address' => $company->address,
            'phone' => $company->phone,
            'email' => $company->email,
            'website' => $company->website,
            'logo' => $company->logo,
        ]);
    }
    public function update(Company $company): void
    {
        $this->validate();

        $company->update(
            $this->only($this->data)
        );
        $this->reset();
    }
    public function delete($company_id): void
    {
        $company = Company::find($company_id);
        $company->delete();
    }
}

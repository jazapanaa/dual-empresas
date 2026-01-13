<?php

namespace App\Livewire\Company;

use App\Http\Traits\CompanyTrait;
use App\Http\Traits\DdlTrait;
use App\Livewire\Forms\CompanyForm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CompanyLive extends Component
{
    use CompanyTrait, DdlTrait, WithPagination,WithFileUploads;
    public CompanyForm $form;
    public bool $isEdit = false;
    public int $company_id;

    #[Validate('image|max:1024')]
    public $imagen;
    public function render()
    {
        return view('livewire.company.company-live',[
            'companies' => $this->getCompanies()->paginate(50),
        ]);
    }
    public function saveCompany():void
    {
        if ($this->imagen) {
            $this->form->logo = $this->imagen->storeAs('company',$this->imagen->getClientOriginalName(),'public');
        }
        if($this->isEdit){
            $this->form->update($this->getCompany($this->company_id));
            $title = 'Empresa actualizada';
            $icon = 'success';
            $message = 'Empresa actualizada correctamente';
            $this->isEdit = false;
        }else{
            #$this->form->store();
            $title = 'Empresa guardada';
            $icon = 'success';
            $message = 'No se puede crear Empresas';

        }
        $this->dispatch('alert', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
        ]);
    }
    public function editCompany($company_id):void
    {
        $this->form->show($this->getCompany($company_id));
        $this->isEdit = true;
        $this->company_id = $company_id;
    }
    public function deleteCompany($company_id):void
    {
        $this->form->delete($company_id);
    }
}

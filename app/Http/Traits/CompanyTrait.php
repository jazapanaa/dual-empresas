<?php

namespace App\Http\Traits;

use App\Models\Company;

trait CompanyTrait
{
    public function getCompanies()
    {
        return Company::query();
    }
    public function getCompany($company_id)
    {
        return Company::find($company_id);
    }

}

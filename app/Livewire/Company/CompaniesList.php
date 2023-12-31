<?php

namespace App\Livewire\Company;

use App\Http\Queries\CompaniesQuery;
use App\Http\Queries\CompanyHoursQuery;
use App\Models\Company;
use Carbon\Carbon;
use Livewire\Component;

class CompaniesList extends Component
{
    public $companies;
    public $searchTerm;
    public $company;

    protected $listeners = ['refreshCompanies', 'closeEditBox' => 'clearCompanyId'];

    public function mount()
    {
        $this->companies = CompaniesQuery::companiesWithRates($this->searchTerm)->get();
    }

    public function refreshCompanies()
    {
        $this->companies = CompaniesQuery::companiesWithRates($this->searchTerm)->get();
    }

    public function updatedSearchTerm()
    {
        if(strlen($this->searchTerm) >= 3){
            $this->companies = CompaniesQuery::companiesWithRates($this->searchTerm)->get();
        }

        if(strlen($this->searchTerm) < 3){
            $this->companies = CompaniesQuery::companiesWithRates('')->get();
        }
    }

    public function setCompanyId($id = null)
    {
        $this->company = Company::find($id);
    }

    public function clearCompanyId()
    {
        $this->company = null;
    }

    public function render()
    {
        return view('livewire.company.companies-list');
    }
}

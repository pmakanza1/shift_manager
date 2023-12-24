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

    protected $listeners = ['refreshCompanies' => '$refresh'];

    public function mount()
    {
        $this->companies = CompaniesQuery::comapniesWithRates($this->searchTerm)->get();
        // dd($this->companyHours);

        // $this->wrapDataAsCompany();

        // DD($this->companyHours);
    }

    public function updatedSearchTerm()
    {
        if(strlen($this->searchTerm) >= 3){
            $this->companies = CompaniesQuery::comapniesWithRates($this->searchTerm)->get();
        }

        if(strlen($this->searchTerm) < 3){
            $this->companies = CompaniesQuery::comapniesWithRates('')->get();
        }
    }

    public function render()
    {
        return view('livewire.company.companies-list');
    }
}

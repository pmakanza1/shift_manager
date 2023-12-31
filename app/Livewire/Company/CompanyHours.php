<?php

namespace App\Livewire\Company;

use App\Http\Queries\CompanyHoursQuery;
use App\Models\Company;
use Carbon\Carbon;
use Livewire\Component;

class CompanyHours extends Component
{
    public $companyHours;
    public $filterStartDate;
    public $filterEndDate;
    public $searchTerm;

    protected $listeners = ['refreshCompanies' => '$refresh'];

    public function mount()
    {
        $this->filterStartDate = Carbon::today()->startOfMonth()->toDateString();
        $this->filterEndDate = Carbon::today()->endOfMonth()->toDateString();
        // $this->companyHours = CompanyHoursQuery::getCompanyHours()->get();
        // $this->companyHours = CompanyHoursQuery::groupedActualCompanyHours()->get();

        $this->companyHours = CompanyHoursQuery::groupedActualCompanyHours(
            $this->filterStartDate,
            $this->filterEndDate,
            $this->searchTerm
        )->get();
    }

    public function filter()
    {
        // $this->companyHours = CompanyHoursQuery::getFilteredCompanyHours($this->filterStartDate, $this->filterEndDate);

        $this->companyHours = CompanyHoursQuery::groupedActualCompanyHours(
            $this->filterStartDate,
            $this->filterEndDate,
            $this->searchTerm
        )->get();
    }

    public function clearFilters()
    {
        // $this->companyHours = CompanyHoursQuery::getCompanyHours()->get();
        $this->filterStartDate = Carbon::today()->startOfMonth()->toDateString();
        $this->filterEndDate = Carbon::today()->endOfMonth()->toDateString();

        $this->companyHours = CompanyHoursQuery::groupedActualCompanyHours(
            $this->filterStartDate,
            $this->filterEndDate,
            ''
        )->get();
    }

    public function updatedSearchTerm()
    {
        if(strlen($this->searchTerm) >= 3){
            $this->filter();
        }

        if(strlen($this->searchTerm) < 3){
            $this->clearFilters();
        }
    }

    public function showAllCompanies()
    {
        $this->filterStartDate = Carbon::today()->startOfYear()->toDateString();
        $this->filterEndDate = Carbon::today()->endOfYear()->toDateString();

        $this->companyHours = CompanyHoursQuery::getCompanyHours($this->filterStartDate, $this->filterEndDate)->get();
    }

    public function render()
    {
        return view('livewire.company.company-hours');
    }
}

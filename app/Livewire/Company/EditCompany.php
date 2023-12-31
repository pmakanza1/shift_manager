<?php

namespace App\Livewire\Company;

use App\Models\CompanyRate;
use Livewire\Component;

class EditCompany extends Component
{
    public $company;
    public $name;
    public $email;
    public $phone;
    public $dayRate;
    public $nightRate;
    public $weekendRate;
    public $success = false;

    protected $rules = [
        'dayRate' => 'gt:0',
        'nightRate' => 'gt:0',
        'weekendRate' => 'gt:0'
    ];

    public function mount($company)
    {
        $this->company = $company;
        $this->name = $company->name;
        $this->email = $company->email;
        $this->phone = $company->phone;
        $this->dayRate = $company->dayRate;
        $this->weekendRate = $company->weekendRate;
        $this->nightRate = $company->nightRate;
    }

    public function saveNewRate($shiftId, $rate)
    {
        $this->validate();
        
        CompanyRate::updateOrCreate(
            ['company_id' => $this->company->id, 'shift_type_id' => $shiftId],
            ['rate' => $rate, 'effective_date' => now()]
        );
    }

    public function updateCompany()
    {
        $this->company->name = $this->name;
        $this->company->email = $this->email;
        $this->company->phone = $this->phone;

        foreach ($this->company->companyRates as $companyRate) {
            if ($this->nightRate) {
                $this->saveNewRate(1, $this->nightRate);
            }

            if ($this->dayRate) {
                $this->saveNewRate(2, $this->dayRate);
            }

            if ($this->weekendRate) {
                $this->saveNewRate(3, $this->weekendRate);
            }
        }

        $this->company->save();

        $this->success = true;
        $this->dispatch('refreshCompanies');
    }

    public function render()
    {
        return view('livewire.company.edit-company');
    }
}

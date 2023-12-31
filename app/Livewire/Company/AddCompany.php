<?php

namespace App\Livewire\Company;

use App\Models\Company;
use Carbon\Carbon;
use Livewire\Component;

class AddCompany extends Component
{
    public $name;
    public $email;
    public $phone;
    public $dayRate;
    public $nightRate;
    public $weekendRate;
    public $success = false;

    protected $listeners = ['refreshCompanies' => '$refresh'];

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'dayRate' => 'required|numeric',
        'nightRate' => 'required|numeric',
        'weekendRate' => 'required|numeric',
    ];

    public function save()
    {
        try {
            $newCompany = Company::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'is_active' => 1,
            ]);

            $company = Company::find($newCompany->id);

            $company->companyRates()->createMany([
                ['shift_type_id' => 1, 'rate' => $this->nightRate, 'effective_date' => Carbon::today()],
                ['shift_type_id' => 2, 'rate' => $this->dayRate, 'effective_date' => Carbon::today()],
                ['shift_type_id' => 3, 'rate' => $this->weekendRate, 'effective_date' => Carbon::today()],
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $this->success = true;
        $this->dispatch('refreshCompanies');
    }

    public function render()
    {
        return view('livewire.company.add-company');
    }
}

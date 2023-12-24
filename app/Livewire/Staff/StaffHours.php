<?php

namespace App\Livewire\Staff;

use App\Http\Queries\StaffHoursQuery;
use App\Models\Staff;
use Carbon\Carbon;
use Livewire\Component;

class StaffHours extends Component
{
    public $staffHours;
    public $filterStartDate;
    public $filterEndDate;
    public $searchTerm;

    public function mount()
    {
        $this->filterStartDate = Carbon::today()->startOfMonth()->toDateString();
        $this->filterEndDate = Carbon::today()->endOfMonth()->toDateString();
        $this->staffHours = StaffHoursQuery::getStaffHours()->get();
    }

    public function filter()
    {
        $this->staffHours = StaffHoursQuery::getFilteredStaffHours(
            $this->filterStartDate, 
            $this->filterEndDate,
            $this->searchTerm
        );
    }

    public function clearFilters()
    {
        $this->staffHours = StaffHoursQuery::getStaffHours()->get();
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

    public function promptHours()
    {
        Staff::where('id', '>', 0)->update(['confirmed_hours' => null]);
        $this->clearFilters();
    }

    public function render()
    {
        return view('livewire.staff.staff-hours');
    }
}

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
    public $allStaff = false;

    public function mount()
    {
        $this->filterStartDate = Carbon::today()->startOfMonth()->toDateString();
        $this->filterEndDate = Carbon::today()->endOfMonth()->toDateString();
        // $this->staffHours = StaffHoursQuery::getStaffHours()->get();
        $this->allStaff = false;
        $this->filter();
    }

    public function filter()
    {
        $this->staffHours = StaffHoursQuery::getFilteredStaffHours(
            $this->filterStartDate, 
            $this->filterEndDate,
            $this->searchTerm,
            $this->allStaff
        );
    }

    public function showAllStaff()
    {
        $this->allStaff = true;
        $this->filter();
    }

    public function showHours()
    {
        $this->allStaff = false;
        $this->filter();
    }

    public function clearFilters()
    {
        $this->allStaff = false;
        $this->staffHours = StaffHoursQuery::getStaffHours(
            $this->filterStartDate, 
            $this->filterEndDate
            )->get();
        // $this->filter();
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

    public function getBackground($hoursConfirmed)
    {
        if(is_null($hoursConfirmed)){
            return 'bg-blue-200';
        }

        if($hoursConfirmed > 0){
            return 'bg-green-200';
        }

        if($hoursConfirmed == 0){
            return 'bg-red-200';
        }
    }

    public function render()
    {
        return view('livewire.staff.staff-hours');
    }
}

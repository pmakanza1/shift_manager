<?php

namespace App\Livewire\Staff;

use App\Http\Queries\StaffHoursQuery;
use App\Models\StaffCompanyTotalHours;
use Carbon\Carbon;
use Livewire\Component;

class StaffShifts extends Component
{
    public $staff;
    public $hoursConfirmed;
    public $staffHours;
    public $filterStartDate;
    public $filterEndDate;
    public $weeklyHours;

    public function mount($staff)
    {
        $this->staff = $staff;
        $this->filterStartDate = Carbon::today()->startOfWeek()->toDateString();
        $this->filterEndDate = Carbon::today()->endOfWeek()->toDateString();
        $this->setWeeklyHours();
        $this->filter();
    }

    private function setWeeklyHours()
    {
        $this->weeklyHours = StaffHoursQuery::getFilteredStaffHours(
            Carbon::today()->startOfWeek()->toDateString(),
            Carbon::today()->endOfWeek()->toDateString(),
            ''
        )
            ->where('staff_id', $this->staff->staff_id)->first();
    }

    public function filter()
    {
        $this->staffHours = StaffHoursQuery::getStaffHoursForStaffView(
            $this->staff->staff_id,
            $this->filterStartDate,
            $this->filterEndDate
        );

        $this->setWeeklyHours();
    }

    public function clearFilters()
    {
        $this->filterStartDate = Carbon::today()->startOfWeek()->toDateString();
        $this->filterEndDate = Carbon::today()->endOfWeek()->toDateString();
        $this->filter();
    }

    public function confirmHours($value)
    {
        $this->staff->confirmed_hours = $value;
        $this->staff->save();
    }

    public function cancelShift($id)
    {
        if(!auth()->user()->is_admin){
            return;
        }

        $startDate = $this->filterStartDate;
        $endDate = $this->filterEndDate;

        $shift = StaffCompanyTotalHours::find($id);

        $shift->as_planned = 0;
        $shift->note = 'cancelled';
        $shift->last_updated_by = auth()->user()->id;
        $shift->save();

        $this->filterStartDate = $startDate;
        $this->filterEndDate = $endDate;

        $this->filter();
    }

    public function render()
    {
        return view('livewire.staff.staff-shifts');
    }
}

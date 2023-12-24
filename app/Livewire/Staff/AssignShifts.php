<?php

namespace App\Livewire\Staff;

use App\Models\Company;
use App\Models\ShiftType;
use App\Models\StaffCompanyTotalHours;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AssignShifts extends Component
{
    public $staff;
    public $companies;
    public $shiftTypes;
    public $plannedHours;
    public $estimatedEarnings;
    public $startDate = null;
    public $endDate = null;
    public $startTime = null;
    public $endTime = null;
    public $startDateTime;
    public $endDateTime;
    public $rate;
    public $weekDays;
    public $showWeekDays = false;
    public $selectedDays = [];
    public $shiftOccurence;
    public $company;
    public $shiftType;
    public $clashingShift = null;
    public bool $saveSuccess = false;
    public $noteRequired;
    public $note;
    public $singleShiftHours;
    public $actualWorkingHours;
    public $breakHours = 0;
    public $shiftTooLong = false;

    protected $rules = [
        'company' => 'required',
        'shiftType' => 'required',
        'startDate' => 'required|date|after_or_equal:today',
        'endDate' => 'required|date|after_or_equal:startDate',
        'startTime' => 'required',
        'endTime' => 'required',
        'rate' => 'required',
        'breakHours' => 'required',
        // 'shiftOccurence' => 'required',
    ];

    protected $listeners = ['refresh' => '$refresh'];

    public function mount($staff)
    {
        $this->staff = $staff;
        $this->companies = Company::where('is_active', 1)->get();
        $this->shiftTypes = ShiftType::all();
        $this->weekDays = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];
    }

    public function getCarbonDates()
    {
        $this->startDateTime = Carbon::parse($this->startDate)->setTimeFromTimeString($this->startTime);
        $this->endDateTime = Carbon::parse($this->endDate)->setTimeFromTimeString($this->endTime);
        $this->singleShiftHours = $this->startDateTime->floatDiffInHours($this->endDateTime);

        if(($this->singleShiftHours - $this->breakHours) > 12){
            // $this->addError('shiftTooLong', 'Shift should not exceed 12 hours');
            $this->shiftTooLong = true;
        }
        // $this->singleShiftHours;
        $this->calculateActualWorkingHours();
    }

    private function calculateActualWorkingHours()
    {
        $this->actualWorkingHours = $this->singleShiftHours - $this->breakHours;
    }

    public function checkShiftClashes()
    {
        $from = Carbon::today();
        $to = Carbon::today()->addMonth();

        $potentialClashes = StaffCompanyTotalHours::whereBetween('start_date', [$from, $to])
            ->where('staff_id', $this->staff->staff_id)
            ->where('as_planned', 1)
            ->get();

        foreach ($potentialClashes as $potentialClash) {
            $clashStart = Carbon::parse($potentialClash->start_date);
            $clashEnd = Carbon::parse($potentialClash->end_date);

            if (
                $this->startDateTime->equalTo($clashStart)
                ||
                $this->startDateTime->isBetween($clashStart, $clashEnd)
                ||
                $this->endDateTime->isBetween($clashStart, $clashEnd)
                ||
                $clashStart->isBetween($this->startDateTime, $this->endDateTime)
            ) {
                $this->clashingShift = $potentialClash;
                return true;
            }
        }

        return false;
    }

    public function createShift()
    {
        $this->shiftTooLong = false;
        $this->validate();
        $this->getCarbonDates();
        
        if($this->shiftTooLong){
            return;
        }

        $shiftStartDay = Carbon::parse($this->startDate)->englishDayOfWeek;

        if (!in_array($shiftStartDay, $this->selectedDays)) {
            array_push($this->selectedDays, $shiftStartDay);
        }

        $singleShiftToMinutes = $this->singleShiftHours * 60;

        foreach ($this->selectedDays as $selectedDay) {
            if (Carbon::parse($selectedDay)->dayOfWeek >= Carbon::parse($this->startDate)->dayOfWeek) {
                $this->startDateTime = Carbon::parse($selectedDay)->setTimeFromTimeString($this->startTime);
                $this->endDateTime = Carbon::parse($selectedDay)->setTimeFromTimeString($this->startTime)
                    ->addMinutes(round($singleShiftToMinutes, 1));

                $this->calculateHoursAndPay();
            }
        }
    }

    private function calculateHoursAndPay()
    {
        $this->resetErrorBag();

        if ($this->startDateTime->greaterThanOrEqualTo($this->endDateTime)) {
            $this->addError('times', 'Please check your shift start and end times.');
            return;
        }

        if ($this->checkShiftClashes()) {
            return;
        }

        // $this->singleShiftHours -= $this->breakHours;
        // $this->plannedHours += $this->singleShiftHours;
        $this->plannedHours += $this->actualWorkingHours;
        $this->estimatedEarnings = $this->rate * $this->plannedHours;
        $this->save();
    }

    public function overwriteShift()
    {
        //update shift as_planned to 0
        //add note to shift - reason for cancelling
        //create new shift

        $this->plannedHours = 0;

        $this->noteRequired = true;

        $validateNote = Validator::make(
            ['note' => $this->note],
            ['note' => 'required|min:5'],
            ['required' => 'The :attribute field is required'],
        )->validate();

        $this->clashingShift->as_planned = 0;
        $this->clashingShift->save();

        $this->calculateHoursAndPay();
        $this->noteRequired = false;
        $this->clashingShift = null;
        $this->note = null;

    }

    public function clearProps()
    {
        $this->resetExcept([
            'staff',
            'companies',
            'shiftTypes',
            'weekDays',
            // 'plannedHours',
            // 'estimatedEarnings'
        ]);
    }

    public function save()
    {
        StaffCompanyTotalHours::create(
            [
                'staff_id' => $this->staff->staff_id,
                'company_id' => $this->company,
                'shift_type_id' => $this->shiftType,
                'start_date' => $this->startDateTime,
                'end_date' => $this->endDateTime,
                // 'total_hours' => $this->singleShiftHours,
                'total_hours' => $this->actualWorkingHours,
                'rate' => $this->rate,
                'as_planned' => 1,
                'note' => $this->note ?? null,
                'last_updated_by' => auth()->user()->id,
            ]
        );

        $this->saveSuccess = true;
    }

    public function render()
    {
        return view('livewire.staff.assign-shifts');
    }
}

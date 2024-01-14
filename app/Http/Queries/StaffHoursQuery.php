<?php

namespace App\Http\Queries;

use App\Models\Staff;
use App\Models\StaffCompanyTotalHours;
use Carbon\Carbon;

class StaffHoursQuery
{
    public static function getStaffHours($startDate, $endDate)
    {
        $endDate = Carbon::parse($endDate)->endOfDay()->toDateTimeString();

        $cancelled_shifts = StaffCompanyTotalHours::where('as_planned', 0)
            ->select('staff_id')
            ->selectRaw('sum(total_hours) as cancelled_hours')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->groupBy('staff_id');

        $active_shifts = StaffCompanyTotalHours::where('as_planned', 1)
            ->select('staff_id')
            ->selectRaw('sum(total_hours) as hours_worked, sum(total_hours * rate) as active_hours')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->groupBy('staff_id');

        return Staff::leftJoin('staff_company_total_hours AS scth', 'scth.staff_id', 'staff.staff_id')
            ->leftJoinSub($cancelled_shifts, 'cancelled_shifts', function ($join) {
                $join->on('cancelled_shifts.staff_id', '=', 'staff.staff_id');
            })
            ->leftJoinSub($active_shifts, 'active_shifts', function ($join) {
                $join->on('active_shifts.staff_id', '=', 'staff.staff_id');
            })
            ->select('staff.staff_id', 'staff.name', 'staff.email', 'staff.phone', 'cancelled_shifts.cancelled_hours')
            ->selectRaw('
                active_shifts.hours_worked,
                active_shifts.active_hours as total_earnings,
                sum(confirmed_hours) as confirmed'
            )
            ->groupBy('staff.staff_id', 'staff.name', 'staff.email', 'staff.phone', 'cancelled_shifts.cancelled_hours');
    }

    public static function getFilteredStaffHours($startDate, $endDate, $searchTerm, $allStaff = false)
    {
        $endDate = Carbon::parse($endDate)->endOfDay()->toDateTimeString();

        if ($allStaff) {
            return Staff::where('is_active', 1)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%');
                })
                ->get();
        }

        return self::getStaffHours($startDate, $endDate)
            ->whereBetween('start_date', [$startDate, $endDate])
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            })
            ->get();
    }

    public static function getStaffHoursForStaffView($staffId, $startDate, $endDate)
    {
        $endDate = Carbon::parse($endDate)->endOfDay()->toDateTimeString();
        
        $cancelled_shifts = StaffCompanyTotalHours::where('as_planned', 0)
            ->select('staff_id')
            ->selectRaw('sum(total_hours) as cancelled_hours')
            ->groupBy('staff_id');

        return Staff::leftJoin('staff_company_total_hours AS scth', 'scth.staff_id', 'staff.staff_id')
            ->leftJoinSub($cancelled_shifts, 'cancelled_shifts', function ($join) {
                $join->on('cancelled_shifts.staff_id', '=', 'staff.staff_id');
            })
            ->join('companies', 'companies.id', 'scth.company_id')
            ->join('shift_types', 'shift_types.id', 'scth.shift_type_id')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->where('staff.staff_id', $staffId)
            ->select(
                'scth.id as shiftId',
                'staff.id',
                'companies.name as company',
                'start_date',
                'end_date',
                'total_hours',
                'rate',
                'shift_types.name as shiftType',
                'as_planned'
            )
            ->orderByDesc('start_date')
        // ->selectRaw('sum(total_hours) as total_hours, sum(total_hours * rate) as total_earnings')
            ->get();
    }
}

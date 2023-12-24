<?php

namespace App\Http\Queries;

use App\Models\Staff;
use App\Models\StaffCompanyTotalHours;

class StaffHoursQuery
{
    public static function getStaffHours()
    {
        $cancelled_shifts = StaffCompanyTotalHours::where('as_planned', 0)
            ->select('staff_id')
            ->selectRaw('sum(total_hours) as cancelled_hours')
            ->groupBy('staff_id');
        
        $active_shifts = StaffCompanyTotalHours::where('as_planned', 1)
            ->select('staff_id')
            ->selectRaw('sum(total_hours * rate) as active_hours')
            ->groupBy('staff_id');

        return Staff::leftJoin('staff_company_total_hours AS scth', 'scth.staff_id', 'staff.staff_id')
            ->leftJoinSub($cancelled_shifts, 'cancelled_shifts', function ($join) {
                $join->on('cancelled_shifts.staff_id', '=', 'staff.staff_id');
            })
            ->leftJoinSub($active_shifts, 'active_shifts', function($join){
                $join->on('active_shifts.staff_id', '=', 'staff.staff_id');
            })
            ->select('staff.staff_id', 'staff.name', 'staff.email', 'staff.phone', 'cancelled_shifts.cancelled_hours')
            ->selectRaw('
            (sum(total_hours) - cancelled_shifts.cancelled_hours) as total_hours, 
            sum(total_hours - cancelled_shifts.cancelled_hours * rate) as total_ear,
            active_shifts.active_hours as total_earnings,
            sum(total_hours),
            sum(confirmed_hours) as confirmed'
            )
            ->groupBy('staff.staff_id', 'staff.name', 'staff.email', 'staff.phone', 'cancelled_shifts.cancelled_hours');
    }

    public static function getFilteredStaffHours($startDate, $endDate, $searchTerm)
    {
        return self::getStaffHours()
            ->whereBetween('start_date', [$startDate, $endDate])
            ->where(function($query) use ($searchTerm){
                $query->where('name', 'like', '%'.$searchTerm.'%')
                ->orWhere('name', 'like', '%'.$searchTerm.'%');
            })
            ->get();
    }

    public static function getStaffHoursForStaffView($staffId, $startDate, $endDate)
    {
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

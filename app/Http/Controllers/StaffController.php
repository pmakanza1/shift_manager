<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ShiftType;
use App\Models\Staff;
use App\Models\StaffCompanyTotalHours;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $cancelled_shifts = StaffCompanyTotalHours::where('as_planned', 0)
        //     ->select('staff_id')
        //     ->selectRaw('sum(total_hours) as cancelled_hours')
        //     ->groupBy('staff_id');

        // // $staff = Staff::where('is_active', 1)->get();

        // $staff = Staff::leftJoin('staff_company_total_hours AS scth', 'scth.staff_id', 'staff.staff_id')
        //     ->leftJoinSub($cancelled_shifts, 'cancelled_shifts', function($join){
        //         $join->on('cancelled_shifts.staff_id', '=', 'staff.staff_id');
        //     })
        //     ->select('staff.staff_id', 'staff.name', 'staff.email', 'staff.phone', 'cancelled_shifts.cancelled_hours')
        //     ->selectRaw('sum(total_hours) as total_hours, sum(total_hours * rate) as total_earnings')
        //     ->groupBy('staff.staff_id', 'staff.name', 'staff.email', 'staff.phone', 'cancelled_shifts.cancelled_hours')
        //     ->get();

        return view('staff.staff');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        $companies = Company::all();
        $shiftTypes = ShiftType::all();

        return view('staff.staff_profile')
            ->with('staff', $staff)
            ->with('companies', $companies)
            ->with('shiftTypes', $shiftTypes);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

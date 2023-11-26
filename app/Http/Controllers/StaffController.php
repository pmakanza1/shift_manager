<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ShiftType;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::where('is_active', 1)->get();

        return view('staff.staff')->with('staff', $staff);
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

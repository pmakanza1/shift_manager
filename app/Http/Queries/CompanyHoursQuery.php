<?php

namespace App\Http\Queries;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyHoursQuery
{
    public static function getCompanyHours($startDate, $endDate)
    {
        return Company::leftJoin('staff_company_total_hours AS scth', function ($join) {
            $join->on('scth.company_id', 'companies.id')
                ->where('as_planned', 1);
        })
            ->leftJoin('shift_types as st', 'st.id', 'scth.shift_type_id')
            ->leftJoin('company_rates as cr', function ($join) {
                $join->on('cr.company_id', 'scth.company_id')
                    ->on('cr.shift_type_id', 'scth.shift_type_id');
            })
            ->where('is_active', 1)
            ->whereBetween('start_date', [$startDate, $endDate])
            ->select('companies.id', 'companies.email', 'companies.name', 'cr.rate')
            ->selectRaw('sum(scth.total_hours) as totalHours, sum(scth.total_hours) * cr.rate as totalBillable')
            ->groupBy('companies.id', 'companies.email', 'companies.name', 'cr.rate')
            ->orderBy('companies.id');
    }

    public static function groupedActualCompanyHours($startDate, $endDate, $searchTerm)
    {
        // dd(self::getCompanyHours($startDate, $endDate)->get());
        return DB::connection('mysql')
            ->query()
            ->fromSub(self::getCompanyHours($startDate, $endDate), 'companyHours')
            ->select('id', 'name', 'email')
            ->selectRaw('sum(totalBillable) as totalBillable, sum(totalHours) as totalHours')
            ->where('name', 'like', '%'.$searchTerm.'%' )
            ->orWhere('email', 'like', '%'.$searchTerm.'%')
            ->groupBy('id', 'name', 'email')
            ->orderByDesc('totalBillable');
        // ->get();
    }

    // public static function getFilteredCompanyHours($startDate, $endDate)
    // {
    //     return self::groupedActualCompanyHours($startDate, $endDate)
    //         // ->whereBetween('companyHours.start_date', [$startDate, $endDate])
    //         ->get();
    //     // return self::getCompanyHours()
    //     //     ->whereBetween('start_date', [$startDate, $endDate])
    //     //     ->get();
    // }
}

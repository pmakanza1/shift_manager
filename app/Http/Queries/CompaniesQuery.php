<?php

namespace App\Http\Queries;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompaniesQuery
{
    public static function comapniesWithRates($searchTerm)
    {
        $subQuery = Company::join('company_rates as cr', 'cr.company_id', 'companies.id')
            ->select('companies.name', 'cr.company_id', 'companies.phone', 'companies.email')
            ->selectRaw(
                'case when cr.shift_type_id = 1 then cr.rate end as night,
                case when cr.shift_type_id = 2 then cr.rate end as day,
                case when cr.shift_type_id = 3 then cr.rate end as weekend'
            );

        return DB::connection('mysql')
            ->query()
            ->fromSub($subQuery, 'companyRates')
            ->select('company_id', 'name', 'phone', 'email')
            ->selectRaw('sum(night) as nightRate, sum(day) as dayRate, sum(weekend) as weekendRate')
            ->where('name', 'like', '%'.$searchTerm.'%')
            ->orWhere('email', 'like', '%'.$searchTerm.'%')
            ->groupBy('company_id', 'name', 'phone', 'email');
    }
}

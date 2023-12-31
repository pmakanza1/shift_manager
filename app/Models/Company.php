<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'is_active'];

    public function companyRates()
    {
        return $this->hasMany(CompanyRate::class, 'company_id', 'id');
    }

    public function getDayRateAttribute()
    {
        return $this->companyRates()->where('shift_type_id', 2)->first()->rate ?? null;
    }

    public function getNightRateAttribute()
    {
        return $this->companyRates()->where('shift_type_id', 1)->first()->rate ?? null;
    }

    public function getWeekendRateAttribute()
    {
        return $this->companyRates()->where('shift_type_id', 3)->first()->rate ?? null;
    }
}

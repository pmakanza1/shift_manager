<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffCompanyTotalHours extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'company_id',
        'shift_type_id',
        'start_date',
        'end_date',
        'total_hours',
        'rate',
        'as_planned',
        'note',
        'last_updated_by',
    ];

    public function staff()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'staff_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function lastUpdatedBy()
    {
        return $this->hasOne(User::class, 'staff_id', 'last_updated_by');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRate extends Model
{
    protected $fillable = ['company_id', 'shift_type_id', 'rate', 'effective_date'];
    
    use HasFactory;

    public function shiftType()
    {
        return $this->hasOne(ShiftType::class, 'id', 'shift_type_id');
    }
}

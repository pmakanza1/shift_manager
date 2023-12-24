<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $primaryKey = 'staff_id';
    protected $fillable = ['staff_id', 'name', 'email', 'phone', 'is_active', 'user_id'];
    
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

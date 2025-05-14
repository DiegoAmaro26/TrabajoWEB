<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'full_name',
        'role',
        'email',
        'phone',
        'photo',
    ];

    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['full_name'];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
    'pet_id',
    'pet_name',         
    'employee_id',
    'appointment_date',
    'appointment_time',
    'duration',
    'reason',           
    'attended',
];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

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

    /**
     * The code defines two relationships where a record belongs to either a Pet or an Employee.
     * 
     * @return In the code snippet provided, two relationships are defined using Eloquent ORM in
     * Laravel. The `pet()` method defines a "belongsTo" relationship with the `Pet` model, and the
     * `employee()` method defines a "belongsTo" relationship with the `Employee` model.
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

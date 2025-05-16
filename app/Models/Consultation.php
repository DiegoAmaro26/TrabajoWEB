<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'pet_id',
        'type',
        'reason',
        'exploration',
        'diagnosis',
        'treatment',
        'tests',
        'vet_name',
        'vet_email',
        'vet_license_number',
    ];

    protected $casts = [
        'tests' => 'array',
    ];

  /**
   * The code defines two functions in a PHP class, one to establish a relationship with a Pet model
   * and another to retrieve multiple hospitalization notes related to the current model.
   * 
   * @return The `pet()` method returns a relationship where the current model belongs to a `Pet`
   * model.
   */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function hospitalizationNotes()
    {
        return $this->hasMany(HospitalizationNote::class);
    }
}


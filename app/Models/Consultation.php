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

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function hospitalizationNotes()
    {
        return $this->hasMany(HospitalizationNote::class);
    }
}


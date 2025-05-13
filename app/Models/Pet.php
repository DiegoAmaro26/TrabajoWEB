<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'client_id', 'name', 'species', 'breed', 'sex', 'birth_date', 'microchip_number', 'photo'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

}

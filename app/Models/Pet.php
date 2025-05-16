<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'client_id', 'name', 'species', 'breed', 'sex', 'birth_date', 'microchip_number', 'photo'
    ];

    /**
     * The code defines relationships in a PHP model class for a client and their consultations.
     * 
     * @return In the provided code snippet, two functions are defined within a class. The `client()`
     * function returns a relationship where the current object belongs to a `Client` model. The
     * `consultations()` function returns a relationship where the current object has many
     * `Consultation` models.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

}

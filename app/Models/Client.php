<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'full_name', 'email', 'phone', 'address', 'photo', 'hospital_id'
    ];

    /**
     * The code defines relationships for a hospital model with users, pets, and invoices.
     * 
     * @return In the code snippet provided, three relationships are defined within a Laravel model:
     */
    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}


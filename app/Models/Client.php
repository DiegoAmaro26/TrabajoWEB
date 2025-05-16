<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'full_name', 'email', 'phone', 'address', 'photo', 'hospital_id'
    ];

    // Relación inversa: un cliente pertenece a un hospital
    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }

    // Relación con las mascotas
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}


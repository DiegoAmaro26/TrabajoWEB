<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'hospital_id', 'full_name', 'email', 'phone', 'address', 'photo'
    ];

    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}

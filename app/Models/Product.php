<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $fillable = [
        'name',
        'stock',
        'expiration_date',
        'price',
    ];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class)->withPivot('quantity', 'price');
    }

}

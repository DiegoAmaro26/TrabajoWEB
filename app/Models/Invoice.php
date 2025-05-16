<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['client_id', 'billing_date', 'total', 'payment_method'];

    /**
     * The code defines relationships between a client and their products and services in a PHP Laravel
     * model.
     * 
     * @return The code snippet provided is from a Laravel Eloquent model class.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price')->withTimestamps();
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot('price')->withTimestamps();
    }

}

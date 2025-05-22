<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'transaction_id',
        'payment_method',
        'billing_date',
    ];

    protected $casts = [
        'billing_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services ()
    {
        return $this->belongsTo(Service::class);
    }

    public function products ()
    {
        return $this->belongsTo(Product::class);
    }
}

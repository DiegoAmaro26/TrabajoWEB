<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    /**
     * The `invoices` function defines a many-to-many relationship between the current model and the
     * `Invoice` model with an additional `price` attribute in the pivot table.
     * 
     * @return The `invoices()` function is returning a many-to-many relationship between the current
     * model and the `Invoice` model. It specifies that the relationship is defined by the
     * `belongsToMany` method, and includes the `price` column from the pivot table using the
     * `withPivot` method.
     */
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class)->withPivot('price');
    }

}

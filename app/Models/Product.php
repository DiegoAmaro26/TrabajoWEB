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

   /**
    * The `invoices` function defines a many-to-many relationship between the current model and the
    * `Invoice` model with additional pivot data for quantity and price.
    * 
    * @return The `invoices()` function is returning a many-to-many relationship between the current
    * model and the `Invoice` model. It uses the `belongsToMany` method to define this relationship.
    * Additionally, the `withPivot` method is used to specify additional columns `quantity` and `price`
    * that are present in the pivot table connecting the two models.
    */
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class)->withPivot('quantity', 'price');
    }

}

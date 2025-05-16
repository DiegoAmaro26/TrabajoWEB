<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationNote extends Model
{
    use HasFactory;

    protected $fillable = ['consultation_id', 'shift', 'content'];

    /**
     * The `consultation` function defines a relationship where an object belongs to a `Consultation`
     * class in PHP.
     * 
     * @return The `consultation()` function is returning a relationship definition using Laravel's
     * Eloquent ORM. It specifies that the current model belongs to a `Consultation` model class.
     */
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}

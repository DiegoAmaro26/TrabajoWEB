<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationNote extends Model
{
    use HasFactory;

    protected $fillable = ['consultation_id', 'shift', 'content'];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}

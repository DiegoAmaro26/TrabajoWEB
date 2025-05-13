<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HospitalizationNote;

class HospitalizationNoteController extends Controller
{
    public function store(Request $request, $consultationId)
{
    $request->validate([
        'shift' => 'required|in:mañana,tarde,noche',
        'content' => 'required|string',
    ]);

    HospitalizationNote::create([
        'consultation_id' => $consultationId,
        'shift' => $request->shift,
        'content' => $request->content,
    ]);

    return back()->with('success', 'Nota de turno registrada correctamente.');
}

}

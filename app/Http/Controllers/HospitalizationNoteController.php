<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HospitalizationNote;

class HospitalizationNoteController extends Controller
{
    
    /**
     * The function stores a hospitalization note for a consultation with specified shift and content.
     * 
     * @param Request request The `` parameter in the `store` function is an instance of the
     * `Illuminate\Http\Request` class in Laravel. It represents the HTTP request that is being made to
     * the application and contains all the data that is sent with the request, such as form input,
     * headers, and files.
     * @param consultationId The `consultationId` parameter in the `store` function represents the ID
     * of the consultation for which you are storing a hospitalization note. This ID is used to
     * associate the hospitalization note with the specific consultation in your system.
     * 
     * @return The `store` function is returning a redirect back to the previous page with a success
     * message "Nota de turno registrada correctamente." stored in the session flash data.
     */
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

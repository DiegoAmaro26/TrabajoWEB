<?php
    
namespace App\Http\Controllers;

use Illuminate\Http\Request;


class TrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trabaja');
    }

    public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'cv' => 'required|file|mimes:pdf|max:2048',
        'comentario' => 'nullable|string|max:1000',
    ]);

    // Guardar archivo CV
    $cvPath = $request->file('cv')->store('cvs', 'public');

    // Aquí podrías guardar estos datos en una tabla, enviar un correo, etc.

    return back()->with('success', 'Tu solicitud ha sido enviada con éxito.');
}

}
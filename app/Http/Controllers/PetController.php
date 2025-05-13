<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Pet;

class PetController extends Controller
{
    public function create(Client $client)
{
    return view('pets.create', compact('client'));
}

public function store(Request $request, Client $client)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'species' => 'required|string|max:50',
        'breed' => 'nullable|string|max:100',
        'sex' => 'required|in:macho,hembra,otro',
        'birth_date' => 'nullable|date',
        'microchip_number' => 'nullable|string|max:50',
        'photo' => 'nullable|image|max:2048',
    ]);

    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('pet_photos', 'public');
    }

    $client->pets()->create([
        'name' => $request->name,
        'species' => $request->species,
        'breed' => $request->breed,
        'sex' => $request->sex,
        'birth_date' => $request->birth_date,
        'microchip_number' => $request->microchip_number,
        'photo' => $photoPath,
    ]);

    return redirect()->route('clients.index')->with('success', 'Mascota añadida correctamente.');
}

public function history(Pet $pet)
{
    $consultations = $pet->consultations()->latest()->get();
    return view('pets.history', compact('pet', 'consultations'));
}

}

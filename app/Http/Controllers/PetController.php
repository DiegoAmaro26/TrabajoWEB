<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function destroy(Pet $pet)
    {
        // Elimina la foto si existe
        if ($pet->photo) {
            Storage::disk('public')->delete($pet->photo);
        }

        $pet->delete();

        return back()->with('success', 'Mascota eliminada correctamente.');
    }

    public function edit(Pet $pet)
    {
        // Esto pasará la mascota específica a la vista de edición
        return view('pets.edit', compact('pet'));
    }

    public function update(Request $request, Pet $pet)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'breed' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'description' => 'nullable|string',
            'new_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Actualizar los datos de la mascota
        $pet->name = $request->input('name');
        $pet->age = $request->input('age');
        $pet->breed = $request->input('breed');
        $pet->color = $request->input('color');
        $pet->description = $request->input('description');

        // Manejar la foto
        if ($request->hasFile('new_photo')) {
            // Eliminar la foto anterior si existe
            if ($pet->photo) {
                Storage::delete('public/' . $pet->photo);
            }

            // Subir la nueva foto
            $path = $request->file('new_photo')->store('pets', 'public');
            $pet->photo = $path;
        }

        // Guardar los cambios en la base de datos
        $pet->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('pets.index')->with('success', 'Mascota actualizada correctamente.');
    }

}

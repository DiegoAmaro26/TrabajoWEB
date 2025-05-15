<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    // Mostrar los clientes asociados al hospital
    public function index()
    {
        // Obtener solo los clientes cuyo hospital_id coincide con el hospital del usuario logueado
        $clients = Client::where('hospital_id', Auth::user()->id)->get();
        
        return view('clients.index', compact('clients'));
    }

    // Mostrar la vista para crear un nuevo cliente
    public function create()
    {
        return view('clients.create');
    }

    // Guardar un nuevo cliente
    public function store(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:clients',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'photo' => 'nullable|image|max:2048',
    ]);

    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('client_photos', 'public');
    }

    /** @var \App\Models\User $user */
    $user = Auth::user();

    $client = $user->clients()->create([
        'full_name' => $request->full_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'photo' => $photoPath,
    ]);

    return redirect()->route('pets.create', $client->id)
        ->with('success', 'Cliente creado correctamente. Ahora añade su mascota.');
}


    // Mostrar la vista para editar un cliente
    public function edit(Client $client)
    {
        // Verificar si el cliente pertenece al hospital del usuario logueado
        if ($client->hospital_id !== Auth::user()->id) {
            return redirect()->route('clients.index')->with('error', 'No tienes acceso a este cliente.');
        }

        $client->load('pets'); // Cargar las mascotas asociadas
        return view('clients.edit', compact('client'));
    }

    // Actualizar los datos de un cliente
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $client->full_name = $request->full_name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->address = $request->address;

        // Subir la foto si está presente
        if ($request->hasFile('photo')) {
            $client->photo = $request->file('photo')->store('clients_photos', 'public');
        }

        $client->save();

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado correctamente.');
    }

    // Buscar clientes sin hospital asignado
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        // Buscar por email o teléfono
        $clients = Client::whereNull('hospital_id')
                         ->where(function ($query) use ($request) {
                             $query->where('email', 'like', "%{$request->query}%")
                                   ->orWhere('phone', 'like', "%{$request->query}%");
                         })
                         ->get();

        return view('clients.search', compact('clients'));
    }

    // Asignar un hospital a un cliente
    public function assignHospital(Request $request, Client $client)
    {
        $client->hospital_id = Auth::user()->id; // Asignar el hospital del usuario logueado
        $client->save();

        return redirect()->route('clients.index')->with('success', 'Cliente asignado correctamente.');
    }
}

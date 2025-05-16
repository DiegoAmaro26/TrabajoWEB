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
        
        $full_name = $clients->pluck('full_name')->toArray();

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

    
    /**
     * The function searches for clients by email or phone number based on the provided query string.
     * 
     * @param Request request The `Request ` parameter in the `search` function is an instance
     * of the Illuminate\Http\Request class. It represents an HTTP request that contains all the data
     * and information about the incoming request, such as form input, headers, cookies, and files.
     * 
     * @return The search function is returning a view called 'clients.search' with the search results
     * stored in the 'clients' variable. The search results are obtained by querying the 'Client' model
     * where the 'hospital_id' is null and filtering by email or phone number based on the search query
     * provided in the request.
     */
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

    
    /**
     * The function assigns a hospital to a client based on the currently logged-in user and then
     * redirects to the clients index page with a success message.
     * 
     * @param Request request The `` parameter in the `assignHospital` function is an instance
     * of the `Request` class, which represents an HTTP request. It contains all the data that was sent
     * as part of the request, such as form input, headers, and files.
     * @param Client client The `client` parameter in the `assignHospital` function is an instance of
     * the `Client` model. It represents a client entity in the system, which likely has attributes
     * such as `id`, `name`, `hospital_id`, etc. The function is responsible for assigning a hospital
     * to the client
     * 
     * @return The `assignHospital` function is returning a redirect response to the `clients.index`
     * route with a success message "Cliente asignado correctamente."
     */
    public function assignHospital(Request $request, Client $client)
    {
        $client->hospital_id = Auth::user()->id; // Asignar el hospital del usuario logueado
        $client->save();

        return redirect()->route('clients.index')->with('success', 'Cliente asignado correctamente.');
    }
}

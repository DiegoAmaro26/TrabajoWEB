<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::where('hospital_id', Auth::id())->with('pets')->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
{
    return view('clients.create');
}

public function store(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'nullable|email',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'photo' => 'nullable|image|max:2048',
    ]);

    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('client_photos', 'public');
    }

    Client::create([
        'hospital_id' => Auth::id(),
        'full_name' => $request->full_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'photo' => $photoPath,
    ]);

    return redirect()->route('clients.index')->with('success', 'Cliente creado correctamente.');
}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EmployeeController extends Controller
{


    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:veterinario,auxiliar,administrativo'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('employee_photos', 'public');
        }

        Employee::create([
            'hospital_id' => Auth::id(),
            'full_name' => $request->full_name,
            'role' => $request->role,
            'email' => $request->email,
            'phone' => $request->phone,
            'photo' => $photoPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Empleado creado correctamente.');
    }

    public function index()
    {
        $employees = Employee::where('hospital_id', Auth::id())->get();
        return view('employees.index', compact('employees'));
    }
    
}

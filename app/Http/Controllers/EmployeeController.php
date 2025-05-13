<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $hospitalId = Auth::id();

        $employees = Employee::where('hospital_id', $hospitalId)->get();

        $veterinarios = $employees->where('role', 'veterinario');
        $auxiliares = $employees->where('role', 'auxiliar');
        $administrativos = $employees->where('role', 'administrativo');

        return view('employees.index', compact('veterinarios', 'auxiliares', 'administrativos'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'role' => 'required|in:veterinario,auxiliar,administrativo',
            'email' => 'required|email|unique:employees',
            'phone' => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
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

        return redirect()->route('employees.index')->with('success', 'Empleado creado correctamente.');
    }
    public function edit(Employee $employee)
{
    $this->authorizeEmployee($employee); // Asegura que solo edite sus propios empleados
    return view('employees.edit', compact('employee'));
}

public function update(Request $request, Employee $employee)
{
    $this->authorizeEmployee($employee);

    $request->validate([
        'full_name' => 'required|string|max:255',
        'role' => 'required|in:veterinario,auxiliar,administrativo',
        'email' => 'required|email|unique:employees,email,' . $employee->id,
        'phone' => 'required|string|max:20',
        'photo' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        $employee->photo = $request->file('photo')->store('employee_photos', 'public');
    }

    $employee->update($request->only('full_name', 'role', 'email', 'phone', 'photo'));

    return redirect()->route('employees.index')->with('success', 'Empleado actualizado correctamente.');
}

public function destroy(Employee $employee)
{
    $this->authorizeEmployee($employee);
    $employee->delete();

    return redirect()->route('employees.index')->with('success', 'Empleado eliminado.');
}

private function authorizeEmployee(Employee $employee)
{
    if ($employee->hospital_id !== Auth::id()) {
        abort(403);
    }
}
}
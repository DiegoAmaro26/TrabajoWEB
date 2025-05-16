<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Employee;

class ConsultationController extends Controller
{
    public function create(Pet $pet)
    {
        // Obtener todos los veterinarios disponibles
        $vets = Employee::where('role', 'veterinario')->get();

        // Retornar la vista de creación de consulta
        return view('consultations.create', compact('pet', 'vets'));
    }

    public function store(Request $request, Pet $pet)
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'reason' => 'required|string',
            'exploration' => 'required|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'tests.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,mp4,mov,avi|max:10240',
            'vet_email' => 'required|email|exists:employees,email',
            'vet_license_number' => 'required|string|max:255',
        ]);

        // Obtener el veterinario a partir del email
        $employee = Employee::where('email', $validated['vet_email'])->first();

        // Manejo de archivos de pruebas
        $testFiles = [];
        if ($request->hasFile('tests')) {
            foreach ($request->file('tests') as $file) {
                // Guardar cada archivo en el almacenamiento público
                $path = $file->store('consultation_tests', 'public');
                $testFiles[] = $path; // Agregar la ruta del archivo al arreglo
            }
        }

        // Crear la consulta asociada a la mascota
        $consultation = $pet->consultations()->create([
            'type' => $validated['type'],
            'reason' => $validated['reason'],
            'exploration' => $validated['exploration'],
            'diagnosis' => $validated['diagnosis'] ?? null,
            'treatment' => $validated['treatment'] ?? null,
            'tests' => json_encode($testFiles),  // Guardar las rutas de los archivos en formato JSON
            'vet_email' => $employee->email,
            'vet_name' => $employee->full_name,
            'vet_license_number' => $validated['vet_license_number'],
        ]);

        // Redirigir al historial de la mascota con mensaje de éxito
        return redirect()->route('pets.history', $pet->id)
                         ->with('success', 'Consulta registrada correctamente.');
    }
}

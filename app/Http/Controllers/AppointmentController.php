<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Employee;
use App\Models\Appointment;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        // Obtener todos los veterinarios del hospital del usuario autenticado
        $veterinarians = Employee::where('role', 'veterinario')
                                ->where('hospital_id', Auth::id())
                                ->get();

        // Obtener las citas del día con la información relacionada
        $appointments = Appointment::with(['pet', 'employee'])
            ->whereDate('appointment_date', $selectedDate)
            ->get()
            ->map(function ($appointment) {
                // Si tiene mascota registrada, usar su nombre; si no, usar pet_name
                $appointment->pet_name = $appointment->pet?->name ?? $appointment->pet_name ?? 'Sin nombre';

                // Usar full_name del veterinario si existe
                $appointment->employee_name = $appointment->employee?->full_name ?? 'Veterinario desconocido';

                return $appointment;
            });

        return view('appointments.index', compact('appointments', 'selectedDate', 'veterinarians'));
    }




    // Mostrar formulario para registrar nuevas citas
    public function create()
    {
        // Obtener empleados con el rol 'veterinario' del hospital del usuario autenticado
        // Aseguramos que el hospital_id de los empleados coincida con el id del usuario autenticado (hospital)
        $vets = Employee::where('role', 'veterinario')
                        ->where('hospital_id', auth::id())  // Solo los veterinarios del hospital del usuario autenticado
                        ->get();

        // Obtener todas las mascotas asociadas al usuario autenticado (clientes)
        $pets = Pet::where('client_id', auth::id())  // Solo las mascotas del cliente autenticado
                ->get();

        // Pasamos los datos a la vista
        return view('appointments.create', compact('vets', 'pets'));
    }

    public function store(Request $request)
    {
        /* $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'pet_option' => 'required|in:registered,unregistered',
            'appointment_date' => 'required|date',
            'appointment_time' => 'nullable|date_format:H:i',
            'duration' => 'nullable|integer',
            'reason' => 'nullable|string|max:500',
            'pet_id' => 'required_if:pet_option,registered|exists:pets,id',
            'unregistered_pet_name' => 'required_if:pet_option,unregistered|string|max:255',
        ]); */

        $appointment = new Appointment();
        $appointment->employee_id = $request->employee_id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->duration = $request->duration;
        $appointment->attended = false;
        $appointment->reason = $request->reason;

        if ($request->pet_option === 'registered') {
            $appointment->pet_id = $request->pet_id;
            $appointment->pet_name = null;
        } else {
            $appointment->pet_id = null;
            $appointment->pet_name = $request->unregistered_pet_name;
        }

        try {
            $appointment->save();
        } catch (\Exception $e) {
            Log::error('Error al guardar la cita: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Error al guardar la cita. Consulta el log.');
        }

        return redirect()->route('appointments.index')->with('success', 'Cita registrada con éxito.');
    }


    // Marcar cita como atendida (y eliminarla)
    public function markAsAttended($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // Si la cita tiene una mascota registrada, se puede acceder a su historial
        if ($appointment->pet) {
            // Redirigir al historial de la mascota
            return redirect()->route('pets.history', $appointment->pet->id)->with('success', 'Cita atendida. Accediendo al historial de la mascota.');
        } else {
            // Si la mascota no está registrada, crear consulta directamente
            // Aquí puedes crear la consulta directamente, y luego borrar la cita
            Consultation::create([
                'pet_id' => $appointment->pet_id, // Mascota no registrada
                'employee_id' => $appointment->employee_id,
                // Otros campos necesarios para la consulta
            ]);
            // Eliminar la cita
            $appointment->delete();

            return redirect()->route('appointments.index')->with('success', 'Cita atendida y registrada como consulta.');
        }
    }

    public function markAttended($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->attended = true;
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Cita marcada como atendida.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Cita eliminada correctamente.');
    }

}

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
    /*
     * Display a listing of the appointments.
     */
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
                        ->where('hospital_id', auth::id()) 
                        ->get();

        // Obtener todas las mascotas asociadas al usuario autenticado (clientes)
        $pets = Pet::where('client_id', auth::id())  // Solo las mascotas del cliente autenticado
                ->get();

        // Pasamos los datos a la vista
        return view('appointments.create', compact('vets', 'pets'));
    }

    /**
     * Store a newly created appointment in storage.
     */

    public function store(Request $request)
    {

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

    
    /**
     * The markAttended function marks a specific appointment as attended and redirects to the
     * appointments index page with a success message.
     * 
     * @param id The `markAttended` function is used to mark an appointment as attended in the
     * database. The function takes an `` parameter, which is the unique identifier of the
     * appointment that needs to be marked as attended.
     * 
     * @return The `markAttended` function is returning a redirect response to the `appointments.index`
     * route with a success message "Cita marcada como atendida."
     */
    public function markAttended($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->attended = true;
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Cita marcada como atendida.');
    }

    /**
     * The `destroy` function deletes an appointment with the specified ID and redirects to the
     * appointments index page with a success message.
     * 
     * @param id The `destroy` function you provided is used to delete an appointment with the given
     * ID. The `` parameter represents the unique identifier of the appointment that needs to be
     * deleted from the database.
     * 
     * @return The `destroy` function is returning a redirect response to the `appointments.index`
     * route with a success message "Cita eliminada correctamente."
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Cita eliminada correctamente.');
    }

}

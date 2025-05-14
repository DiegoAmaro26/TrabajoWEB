@extends('layouts.app')

@push('styles')
<style>
    .table-container {
        overflow-x: auto;
        padding: 10px;
    }
    .appointments-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
    }
    .appointments-table th, .appointments-table td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }
    .appointments-table th {
        background-color: #f4f4f4;
    }

    @media (max-width: 1200px) { .appointments-table td { width: 25%; } }
    @media (max-width: 992px)  { .appointments-table td { width: 33.33%; } }
    @media (max-width: 768px)  { .appointments-table td { width: 50%; } }
    @media (max-width: 576px)  { .appointments-table td { width: 100%; } }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-blue-800 mb-4">Citas del Día</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4 border border-red-300">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Selección de fecha -->
    <div class="mb-6">
        <form action="{{ route('appointments.index') }}" method="GET">
            <label class="block text-gray-700 font-medium mb-1">Selecciona una fecha</label>
            <input type="date" name="date" value="{{ $selectedDate }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded mt-3">
                Ver citas
            </button>
        </form>
    </div>

    <!-- Tabla reorganizada por hora (vertical) y veterinarios (horizontal) -->
    <div class="table-container mb-6">
        <table class="appointments-table w-full">
            <thead>
                <tr>
                    <th>Hora</th>
                    @foreach ($veterinarians as $vet)
                        <th>{{ $vet->full_name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 24; $i++)
                    <tr>
                        <td>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00</td>
                        @foreach ($veterinarians as $vet)
                            <td>
                                @foreach ($appointments as $appointment)
                                    @if ($appointment->employee_id == $vet->id && \Carbon\Carbon::parse($appointment->appointment_time)->hour == $i)
                                        <div 
                                            class="bg-blue-100 p-2 rounded mb-1 cursor-pointer hover:bg-blue-200"
                                            onclick="mostrarDetalles(this)"
                                            data-id="{{ $appointment->id }}"
                                            data-pet="{{ $appointment->pet?->name ?? $appointment->pet_name }}"
                                            data-pet-id="{{ $appointment->pet_id }}"
                                            data-vet="{{ $appointment->employee?->full_name ?? 'N/A' }}"
                                            data-duration="{{ $appointment->duration ?? 'No especificada' }}"
                                            data-time="{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}"
                                            data-date="{{ $appointment->appointment_date }}"
                                            data-attended="{{ $appointment->attended }}"
                                        >
                                            <strong>{{ $appointment->pet?->name ?? $appointment->pet_name }}</strong><br>
                                            {{ $appointment->duration ?? 'N/A' }} min
                                        </div>
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>


    <!-- Panel de detalles -->
    <div id="detalles-cita" class="bg-gray-100 p-4 rounded shadow hidden">
        <h2 class="text-xl font-bold text-gray-800 mb-3">Detalles de la Cita</h2>
        <p><strong>Mascota:</strong> <span id="detalle-pet"></span></p>
        <p id="link-historial" class="mt-1 hidden">
            <a id="historial-link" href="#" class="text-blue-600 hover:underline font-medium" target="_blank">Ver historial</a>
        </p>
        <p><strong>Veterinario:</strong> <span id="detalle-vet"></span></p>
        <p><strong>Fecha:</strong> <span id="detalle-date"></span></p>
        <p><strong>Hora:</strong> <span id="detalle-time"></span></p>
        <p><strong>Duración:</strong> <span id="detalle-duration"></span> min</p>
        
        <!-- Botones de acción -->
        <div class="mt-4 flex space-x-4">
            <!-- Marcar como atendida -->
            <form id="form-marcar-atendida" method="POST" action="" class="hidden">
                @csrf
                @method('PUT')
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded shadow">
                    Marcar como atendida
                </button>
            </form>

            <!-- Eliminar cita -->
            <form id="form-eliminar-cita" method="POST" action="" class="hidden">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 rounded shadow">
                    Eliminar cita
                </button>
            </form>
        </div>
    </div>

    <!-- Botón para crear nueva cita -->
    <div class="mt-6 text-right">
        <a href="{{ route('appointments.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded shadow">
            Crear Nueva Cita
        </a>
    </div>
</div>

<script>
    function mostrarDetalles(elemento) {
        const petName = elemento.dataset.pet;
        const petId = elemento.dataset.petId;
        const appointmentId = elemento.dataset.id;
        const attended = elemento.dataset.attended;

        document.getElementById('detalle-pet').textContent = petName;

        // Mostrar enlace al historial solo si hay mascota registrada
        if (petId && petId !== "null") {
            const link = document.getElementById('historial-link');
            link.href = `/pets/${petId}/history`;
            document.getElementById('link-historial').classList.remove('hidden');
        } else {
            document.getElementById('link-historial').classList.add('hidden');
        }

        // Mostrar el resto de detalles
        document.getElementById('detalle-vet').textContent = elemento.dataset.vet;
        document.getElementById('detalle-date').textContent = elemento.dataset.date;
        document.getElementById('detalle-time').textContent = elemento.dataset.time;
        document.getElementById('detalle-duration').textContent = elemento.dataset.duration;

        // Configurar formularios de acción
        document.getElementById('form-marcar-atendida').action = `/appointments/${appointmentId}/mark-attended`;
        document.getElementById('form-eliminar-cita').action = `/appointments/${appointmentId}`;
        document.getElementById('form-eliminar-cita').classList.remove('hidden');

        document.getElementById('detalles-cita').classList.remove('hidden');
    }
</script>

@endsection

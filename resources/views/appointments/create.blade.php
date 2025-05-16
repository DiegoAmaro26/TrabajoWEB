@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-blue-800 mb-4">Registrar Nueva Cita</h1>

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        {{-- Veterinario --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Veterinario</label>
            <select name="employee_id" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                <option value="">Selecciona un veterinario</option>
                @foreach ($vets as $vet)
                    <option value="{{ $vet->id }}">{{ $vet->full_name }} ({{ $vet->role }})</option>
                @endforeach
            </select>
        </div>

        {{-- Mascota registrada o nueva --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">¿La cita es para una mascota registrada?</label>
            <select id="pet-option" name="pet_option" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                <option value="registered" selected>Sí</option>
                <option value="unregistered">No</option>
            </select>
        </div>

        {{-- Mascotas registradas --}}
        <div id="registered-pet-fields" class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Mascota registrada</label>
            <select name="pet_id" class="w-full border rounded px-3 py-2" id="pet-id-select">
            <option value="">Selecciona una mascota</option>
                @foreach ($pets as $pet)
                    <option value="{{ $pet->id }}">{{ $pet->name }} ({{ $pet->species }})</option>
                @endforeach
            </select>
        </div>

        {{-- Nombre de mascota no registrada --}}
        <div id="unregistered-pet-fields" class="mb-4" style="display: none;">
            <label class="block text-gray-700 font-medium mb-1">Nombre del animal</label>
            <input type="text" name="unregistered_pet_name" class="w-full border rounded px-3 py-2" placeholder="Nombre del animal">
        </div>

        {{-- Fecha de la cita --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Fecha</label>
            <input type="date" name="appointment_date" required class="w-full border rounded px-3 py-2">
        </div>

        {{-- Hora de la cita --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Hora (opcional)</label>
            <input type="time" name="appointment_time" class="w-full border rounded px-3 py-2">
        </div>

        {{-- Duración (opcional) --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Duración (minutos)</label>
            <input type="number" name="duration" class="w-full border rounded px-3 py-2" placeholder="Ej: 30">
        </div>

        {{-- Motivo de la consulta --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Motivo de la consulta</label>
            <textarea name="reason" class="w-full border rounded px-3 py-2" rows="3" placeholder="Describe brevemente el motivo de la cita"></textarea>
        </div>


        {{-- Botones --}}
        <div class="flex justify-between items-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow">
                Registrar Cita
            </button>
            <a href="{{ route('appointments.index') }}" class="text-blue-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>

{{-- Script para alternar campos de mascota nueva --}}
<script>
/**
 * The function `togglePetFields` dynamically toggles the display of registered and unregistered pet
 * fields based on the selected option.
 */
    const petOptionSelect = document.getElementById('pet-option');
    const registeredPetFields = document.getElementById('registered-pet-fields');
    const unregisteredPetFields = document.getElementById('unregistered-pet-fields');

    function togglePetFields() {
        if (petOptionSelect.value === 'unregistered') {
            registeredPetFields.style.display = 'none';
            unregisteredPetFields.style.display = 'block';
        } else {
            registeredPetFields.style.display = 'block';
            unregisteredPetFields.style.display = 'none';
        }
    }

    petOptionSelect.addEventListener('change', togglePetFields);
    window.addEventListener('DOMContentLoaded', togglePetFields);
</script>

@endsection

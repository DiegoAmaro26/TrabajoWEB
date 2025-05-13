@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Nueva Consulta para {{ $pet->name }}</h2>

    <form action="{{ route('consultations.store', $pet->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="type" class="block font-medium text-gray-700">Tipo de consulta:</label>
            <select name="type" id="type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
                <option value="">Seleccionar</option>
                <option>Consulta de urgencia</option>
                <option>Consulta general</option>
                <option>Consulta de revisión</option>
                <option>Consulta de especialista</option>
            </select>
        </div>

        <div>
            <label for="reason" class="block font-medium text-gray-700">Motivo:</label>
            <input type="text" name="reason" id="reason"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>

        <div>
            <label for="exploration" class="block font-medium text-gray-700">Exploración:</label>
            <textarea name="exploration" id="exploration" rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                      required></textarea>
        </div>

        <div>
            <label for="tests" class="block font-medium text-gray-700">Pruebas (PDFs):</label>
            <input type="file" name="tests[]" id="tests" multiple
                   class="mt-1 block w-full text-sm text-gray-500">
        </div>

        <div>
            <label for="diagnosis" class="block font-medium text-gray-700">Diagnóstico presuntivo:</label>
            <input type="text" name="diagnosis" id="diagnosis"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="treatment" class="block font-medium text-gray-700">Tratamiento:</label>
            <textarea name="treatment" id="treatment" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md font-semibold transition">
                Guardar Consulta
            </button>
        </div>
        {{-- Veterinario Responsable --}}
        <div>
            <label for="vet_email" class="block font-medium text-gray-700">Veterinario Responsable</label>
            <select name="vet_email" id="vet_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                <option value="">Seleccionar</option>
                @foreach($vets as $vet)
                    <option value="{{ $vet->email }}">{{ $vet->full_name }} ({{ $vet->email }})</option>
                @endforeach
            </select>
        </div>

        {{-- Número de colegiado --}}
        <div>
            <label for="vet_license_number" class="block font-medium text-gray-700">Número de colegiado</label>
            <input type="text" name="vet_license_number" id="vet_license_number"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                required>
        </div>

    </form>
</div>
@endsection

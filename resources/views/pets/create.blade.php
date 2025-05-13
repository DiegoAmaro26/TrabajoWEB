@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-bold text-blue-800 mb-6">
        Registrar mascota de {{ $client->full_name }}
    </h1>

    <form method="POST" action="{{ route('pets.store', $client->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block font-medium text-gray-700">Nombre</label>
            <input type="text" name="name" id="name"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>

        <div>
            <label for="species" class="block font-medium text-gray-700">Especie</label>
            <input type="text" name="species" id="species"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>

        <div>
            <label for="breed" class="block font-medium text-gray-700">Raza</label>
            <input type="text" name="breed" id="breed"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="sex" class="block font-medium text-gray-700">Sexo</label>
            <select name="sex" id="sex"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
                <option value="macho">Macho</option>
                <option value="hembra">Hembra</option>
                <option value="otro">Otro</option>
            </select>
        </div>

        <div>
            <label for="birth_date" class="block font-medium text-gray-700">Fecha de nacimiento</label>
            <input type="date" name="birth_date" id="birth_date"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="microchip_number" class="block font-medium text-gray-700">Nº microchip</label>
            <input type="text" name="microchip_number" id="microchip_number"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="photo" class="block font-medium text-gray-700">Foto (opcional)</label>
            <input type="file" name="photo" id="photo"
                   class="mt-1 block w-full text-sm text-gray-500">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md font-semibold transition">
                Guardar Mascota
            </button>
        </div>
    </form>
</div>
@endsection

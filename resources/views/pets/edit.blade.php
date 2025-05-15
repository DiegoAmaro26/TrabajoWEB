@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-bold text-blue-800 mb-6">Editar Mascota</h1>

    <form action="{{ route('pets.update', $pet) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name', $pet->name) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                   required>
        </div>

        {{-- Edad --}}
        <div>
            <label for="age" class="block text-sm font-medium text-gray-700">Edad</label>
            <input type="number" name="age" id="age" value="{{ old('age', $pet->age) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                   required>
        </div>

        {{-- Especie --}}
        <div>
            <label for="species" class="block text-sm font-medium text-gray-700">Especie</label>
            <input type="text" name="species" id="species" value="{{ old('species', $pet->species) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                   required>
        </div>

        {{-- Raza --}}
        <div>
            <label for="breed" class="block text-sm font-medium text-gray-700">Raza</label>
            <input type="text" name="breed" id="breed" value="{{ old('breed', $pet->breed) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
        </div>

        {{-- Color --}}
        <div>
            <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
            <input type="text" name="color" id="color" value="{{ old('color', $pet->color) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
        </div>

        {{-- Sexo --}}
        <div>
            <label for="sex" class="block text-sm font-medium text-gray-700">Sexo</label>
            <select name="sex" id="sex"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                <option value="macho" {{ old('sex', $pet->sex) === 'macho' ? 'selected' : '' }}>Macho</option>
                <option value="hembra" {{ old('sex', $pet->sex) === 'hembra' ? 'selected' : '' }}>Hembra</option>
            </select>
        </div>

        {{-- Descripción --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">{{ old('description', $pet->description) }}</textarea>
        </div>

        {{-- Foto actual --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Foto actual</label>
            @if ($pet->photo)
                <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}"
                     class="w-32 h-32 object-cover rounded mt-2 mb-4">
            @else
                <p class="text-gray-500 mt-2">No hay foto registrada.</p>
            @endif
        </div>

        {{-- Nueva foto --}}
        <div>
            <label for="new_photo" class="block text-sm font-medium text-gray-700">Actualizar foto</label>
            <input type="file" name="new_photo" id="new_photo"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
        </div>

        {{-- Botones --}}
        <div class="flex justify-between mt-6">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow font-semibold">
                Actualizar Mascota
            </button>

            <a href="{{ url()->previous() }}"
               class="text-blue-600 font-semibold hover:underline">← Volver</a>
        </div>
    </form>
</div>
@endsection

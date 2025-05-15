@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-bold text-blue-800 mb-6">Editar Cliente</h1>

    <form action="{{ route('clients.update', $client) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @include('clients.partials.form', ['client' => $client])

        <div class="flex justify-between mt-4">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow font-semibold">
                Actualizar Cliente
            </button>
            <a href="{{ route('pets.create', $client->id) }}"
               class="text-blue-600 font-semibold hover:underline">+ Añadir Mascota</a>
        </div>
    </form>
</div>
@if ($client->pets->count())
    <div class="mt-10">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Mascotas del Cliente</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($client->pets as $pet)
                <div class="bg-gray-100 p-4 rounded shadow">
                    {{-- Foto de la mascota --}}
                    @if ($pet->photo)
                        <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}"
                             class="w-full h-48 object-cover rounded mb-3">
                    @else
                        <div class="w-full h-48 flex items-center justify-center bg-gray-300 text-gray-700 rounded mb-3">
                            Sin foto
                        </div>
                    @endif

                    {{-- Info de la mascota --}}
                    <h3 class="text-lg font-semibold text-blue-800">{{ $pet->name }}</h3>
                    <p class="text-sm text-gray-700">{{ ucfirst($pet->species) }} - {{ $pet->sex }}</p>

                    {{-- Botones --}}
                    <div class="mt-4 flex justify-between items-center">
                        <a href="{{ route('pets.edit', $pet) }}"
                           class="text-blue-600 hover:underline font-medium">Editar</a>

                        <form action="{{ route('pets.destroy', $pet) }}" method="POST"
                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta mascota?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@endsection

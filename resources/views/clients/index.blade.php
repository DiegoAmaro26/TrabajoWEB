@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-blue-800 mb-6">Clientes del Hospital</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <a href="{{ route('clients.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow font-semibold">
            + Crear Cliente
        </a>

        <form action="{{ route('clients.search') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
            <input type="text" name="query" placeholder="Buscar por email o teléfono"
                   class="border border-gray-300 rounded-md px-4 py-2 w-full focus:ring-blue-300 focus:border-blue-400">
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                Buscar
            </button>
        </form>
    </div>

    <div class="overflow-x-auto shadow rounded-lg">
        <table class="min-w-full bg-white text-gray-700 border border-gray-200">
            <thead class="bg-blue-100 text-blue-800 font-medium">
                <tr>
                    <th class="px-4 py-2 text-left">Nombre</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Teléfono</th>
                    <th class="px-4 py-2 text-left">Dirección</th>
                    <th class="px-4 py-2 text-left">Mascotas</th>
                    <th class="px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $client->full_name }}</td>
                        <td class="px-4 py-2">{{ $client->email }}</td>
                        <td class="px-4 py-2">{{ $client->phone }}</td>
                        <td class="px-4 py-2">{{ $client->address }}</td>
                        <td class="px-4 py-2">
                            @forelse ($client->pets as $pet)
                                <a href="{{ route('pets.history', $pet->id) }}" class="text-blue-600 hover:underline">
                                    {{ $pet->name }}
                                </a>@if (!$loop->last), @endif
                            @empty
                                <span class="text-gray-400 text-sm">Sin mascotas</span>
                            @endforelse
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('clients.edit', $client) }}"
                               class="text-sm text-yellow-600 hover:underline font-medium">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">No hay clientes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

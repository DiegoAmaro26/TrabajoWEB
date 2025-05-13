@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-blue-800 mb-6">Gestión de Empleados</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('employees.create') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">
            + Añadir Empleado
        </a>
    </div>

    @foreach (['veterinario' => $veterinarios, 'auxiliar' => $auxiliares, 'administrativo' => $administrativos] as $rol => $grupo)
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-3">{{ ucfirst($rol) }}s</h2>
            <div class="overflow-x-auto shadow rounded-lg">
                <table class="min-w-full bg-white text-gray-700">
                    <thead class="bg-blue-100 text-blue-800 font-medium">
                        <tr>
                            <th class="text-left px-4 py-2">Nombre</th>
                            <th class="text-left px-4 py-2">Email</th>
                            <th class="text-left px-4 py-2">Teléfono</th>
                            <th class="text-left px-4 py-2">Foto</th>
                            <th class="text-left px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($grupo as $employee)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $employee->full_name }}</td>
                                <td class="px-4 py-2">{{ $employee->email }}</td>
                                <td class="px-4 py-2">{{ $employee->phone }}</td>
                                <td class="px-4 py-2">
                                    @if($employee->photo)
                                        <img src="{{ asset('storage/' . $employee->photo) }}" alt="Foto"
                                             class="h-12 w-12 object-cover rounded-full border">
                                    @else
                                        <span class="text-sm text-gray-400">Sin foto</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 flex gap-3 items-center">
                                    <!-- Botón Editar -->
                                    <a href="{{ route('employees.edit', $employee) }}"
                                    class="text-sm text-blue-600 hover:underline font-medium">Editar</a>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('employees.destroy', $employee) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este empleado?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:underline font-medium">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">No hay {{ $rol }}s registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-blue-800 mb-4">Nuevo Empleado</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4 border border-red-300">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nombre completo</label>
            <input type="text" name="full_name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Rol</label>
            <select name="role" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
                <option value="">Selecciona un rol</option>
                <option value="veterinario">Veterinario</option>
                <option value="auxiliar">Auxiliar</option>
                <option value="administrativo">Administrativo</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Teléfono</label>
            <input type="text" name="phone" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Foto (opcional)</label>
            <input type="file" name="photo" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow">
                Guardar
            </button>
            <a href="{{ route('employees.index') }}" class="text-blue-600 hover:underline font-medium">Cancelar</a>
        </div>
    </form>
</div>
@endsection

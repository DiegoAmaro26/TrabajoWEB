@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear nuevo empleado
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6">
        <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="full_name">Nombre completo</label>
                <input id="full_name" type="text" name="full_name" class="block w-full mt-1" required>
            </div>

            <div class="mb-4">
                <label for="role">Rol</label>
                <select id="role" name="role" class="block w-full mt-1" required>
                    <option value="veterinario">Veterinario</option>
                    <option value="auxiliar">Auxiliar</option>
                    <option value="administrativo">Administrativo</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" class="block w-full mt-1" required>
            </div>

            <div class="mb-4">
                <label for="phone">Teléfono</label>
                <input id="phone" type="text" name="phone" class="block w-full mt-1" required>
            </div>

            <div class="mb-4">
                <label for="photo">Foto (opcional)</label>
                <input id="photo" type="file" name="photo" class="block w-full mt-1">
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Crear empleado
                </button>
            </div>
        </form>
    </div>
@endsection


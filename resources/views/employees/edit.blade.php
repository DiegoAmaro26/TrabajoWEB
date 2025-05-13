@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-blue-800 mb-4">Editar Empleado</h1>

    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Campos reutilizables --}}
        @include('employees.partials.form', ['employee' => $employee])

        <div class="flex justify-between mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow">
                Actualizar
            </button>
            <a href="{{ route('employees.index') }}" class="text-blue-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection

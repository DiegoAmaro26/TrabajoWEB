@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Empleados del hospital
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6">
        @if($employees->isEmpty())
            <p>No tienes empleados registrados.</p>
        @else
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="p-2">Foto</th>
                        <th class="p-2">Nombre</th>
                        <th class="p-2">Rol</th>
                        <th class="p-2">Email</th>
                        <th class="p-2">Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr class="border-b">
                            <td class="p-2">
                                @if($employee->photo)
                                    <img src="{{ asset('storage/' . $employee->photo) }}" alt="Foto" class="h-12 w-12 rounded-full object-cover">
                                @else
                                    <span class="text-gray-400 italic">Sin foto</span>
                                @endif
                            </td>
                            <td class="p-2">{{ $employee->full_name }}</td>
                            <td class="p-2 capitalize">{{ $employee->role }}</td>
                            <td class="p-2">{{ $employee->email }}</td>
                            <td class="p-2">{{ $employee->phone }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

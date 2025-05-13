@extends('layouts.app')

@section('content')
    <h1>Centros veterinarios asociados</h1>
    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Dirección</th>
                <th class="px-4 py-2">Teléfono</th>
                <th class="px-4 py-2">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->address }}</td>
                    <td class="border px-4 py-2">{{ $user->phone }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

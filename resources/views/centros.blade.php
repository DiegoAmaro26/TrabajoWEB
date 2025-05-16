@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-800 mb-6">Centros veterinarios asociados</h1>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="table-auto w-full">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Dirección</th>
                    <th class="px-4 py-2">Teléfono</th>
                    <th class="px-4 py-2">Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->address }}</td>
                        <td class="border px-4 py-2">{{ $user->phone }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

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
@endsection

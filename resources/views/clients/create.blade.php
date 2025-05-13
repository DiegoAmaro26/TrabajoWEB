@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-bold text-blue-800 mb-6">Registrar Cliente</h1>

    <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        @include('clients.partials.form', ['client' => null])

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow font-semibold">
                Guardar Cliente
            </button>
        </div>
    </form>
</div>
@endsection

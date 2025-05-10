@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Registrar nuevo cliente</h1>

    <form method="POST" action="{{ route('clients.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label>Nombre completo</label>
            <input type="text" name="full_name" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label>Teléfono</label>
            <input type="text" name="phone" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label>Dirección</label>
            <input type="text" name="address" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label>Foto (opcional)</label>
            <input type="file" name="photo" class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar cliente</button>
    </form>
</div>
@endsection

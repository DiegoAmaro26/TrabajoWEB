@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Registrar mascota de {{ $client->full_name }}</h1>

    <form method="POST" action="{{ route('pets.store', $client->id) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label>Nombre</label>
            <input type="text" name="name" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label>Especie</label>
            <input type="text" name="species" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label>Raza</label>
            <input type="text" name="breed" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label>Sexo</label>
            <select name="sex" class="w-full border px-3 py-2 rounded" required>
                <option value="macho">Macho</option>
                <option value="hembra">Hembra</option>
                <option value="otro">Otro</option>
            </select>
        </div>

        <div>
            <label>Fecha de nacimiento</label>
            <input type="date" name="birth_date" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label>Nº microchip</label>
            <input type="text" name="microchip_number" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label>Foto (opcional)</label>
            <input type="file" name="photo" class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar mascota</button>
    </form>
</div>
@endsection

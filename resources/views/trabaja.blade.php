@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Trabaja con nosotros</h1>

    <form action="{{ route('trabaja.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" required class="block w-full mt-1 p-2 border border-gray-300 rounded">
        </div>

        <div class="mb-4">
            <label for="cv">Sube tu CV (PDF):</label>
            <input type="file" name="cv" accept="application/pdf" required class="block w-full mt-1">
        </div>

        <div class="mb-4">
            <label for="comentario">Carta de presentación:</label>
            <textarea name="comentario" rows="4" class="block w-full mt-1 p-2 border border-gray-300 rounded"></textarea>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Enviar</button>
    </form>
@endsection

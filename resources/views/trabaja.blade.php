@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg mt-10">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Trabaja con nosotros</h2>

    <form action="{{ route('trabaja.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Correo electrónico:</label>
            <input type="email" name="email" required
                   class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label for="cv" class="block text-gray-700 font-medium mb-1">Sube tu CV (PDF):</label>
            <input type="file" name="cv" accept="application/pdf" required
                   class="w-full border border-gray-300 rounded-md p-2 bg-white focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label for="comentario" class="block text-gray-700 font-medium mb-1">Carta de presentación:</label>
            <textarea name="comentario" rows="4"
                      class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300"></textarea>
        </div>

        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-md transition duration-200">
            Enviar
        </button>
    </form>
</div>
@endsection

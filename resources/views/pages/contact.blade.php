@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">Contacto</h1>
        <p class="text-gray-700 mb-2">Puedes contactarnos a través del siguiente formulario o por correo electrónico:</p>

        <ul class="text-gray-700 mb-4">
            <li><strong>Email:</strong> contacto@veterinariaweb.com</li>
            <li><strong>Teléfono:</strong> +34 900 123 456</li>
        </ul>

        <form action="#" method="POST" class="space-y-4">
            <div>
                <label for="name" class="block">Nombre</label>
                <input type="text" id="name" name="name" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label for="email" class="block">Email</label>
                <input type="email" id="email" name="email" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label for="message" class="block">Mensaje</label>
                <textarea id="message" name="message" rows="4" class="w-full border px-3 py-2 rounded" required></textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enviar</button>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Preguntas Frecuentes (FAQ)</h1>

        <div class="mb-4">
            <h2 class="font-semibold text-lg text-blue-700">¿Quién puede registrarse en la plataforma?</h2>
            <p class="text-gray-700">Solo clínicas y hospitales veterinarios pueden registrarse.</p>
        </div>

        <div class="mb-4">
            <h2 class="font-semibold text-lg text-blue-700">¿Qué funciones están disponibles tras iniciar sesión?</h2>
            <p class="text-gray-700">Podrás gestionar empleados, clientes, citas y facturación.</p>
        </div>

        <div class="mb-4">
            <h2 class="font-semibold text-lg text-blue-700">¿Es necesario pagar por usar el sistema?</h2>
            <p class="text-gray-700">Actualmente el sistema es gratuito mientras está en fase beta.</p>
        </div>
    </div>
@endsection

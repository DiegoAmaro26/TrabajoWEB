

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PetMedicine</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="flex flex-col min-h-screen bg-gray-50">
    {{-- NAVBAR --}}
    <header class="bg-gradient-to-r from-blue-700 to-blue-400 shadow-md relative z-10">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            {{-- Izquierda: Logo + mensaje --}}
            <div class="flex items-center space-x-4">
                {{-- Logo --}}
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto" style="width:60px; height:auto;">
                </a>
                {{-- Diagonal Divider --}}
                <div class="w-[2px] h-10 rotate-[20deg] bg-white/30"></div>

                {{-- Bienvenida --}}
                @auth
                    <span class="text-white font-medium text-lg hidden sm:inline">
                        Bienvenido a <span class="font-bold">PetMedicine</span>, <strong>{{ Auth::user()->name }}</strong>
                    </span>
                @endauth
            </div>

            {{-- Derecha: Navegación --}}
            <nav class="flex gap-6 items-center text-white font-semibold">
                @guest
                    <a href="{{ route('register') }}" class="hover:underline">Registrarse</a>
                    <a href="{{ route('login') }}" class="hover:underline">Conectarse</a>
                    <a href="{{ route('about') }}" class="hover:underline">Sobre Nosotros</a>
                    <a href="{{ route('contact') }}" class="hover:underline">Contacto</a>
                    <a href="{{ route('faq') }}" class="hover:underline">FAQ</a>
                @else
                    <a href="{{ route('clients.index') }}" class="hover:underline">Clientes</a>
                    <a href="{{ route('appointments.index') }}" class="hover:underline">Citas</a>
                    <a href="{{ route('billing.index') }}" class="hover:underline">Cobro</a>
                    <a href="{{ route('employees.index') }}" class="hover:underline">Empleados</a>
                    <a href="{{ route('invoices.index') }}" class="hover:underline">Facturas</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:underline">Logout</button>
                    </form>
                @endguest
            </nav>
        </div>
    </header>

    {{-- CONTENIDO --}}
    <main class="flex-grow px-4 py-6">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('components.footer')
</body>
</html>

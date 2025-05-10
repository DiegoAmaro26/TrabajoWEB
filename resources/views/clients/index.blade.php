@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Clientes</h1>

        @foreach ($clients as $client)
            <div class="border rounded p-4 mb-4 bg-white shadow-sm">
                <div class="flex items-center">
                    @if($client->photo)
                        <img src="{{ asset('storage/' . $client->photo) }}" class="w-16 h-16 object-cover rounded-full mr-4" alt="">
                    @endif
                    <div>
                        <h2 class="font-semibold text-lg">{{ $client->full_name }}</h2>
                        <p>{{ $client->email }} | {{ $client->phone }}</p>
                        <p>{{ $client->address }}</p>
                    </div>
                </div>

                @if ($client->pets->count())
                    <h3 class="mt-4 font-semibold">Mascotas:</h3>
                    <ul class="ml-4 list-disc">
                        @foreach ($client->pets as $pet)
                            <li>{{ $pet->name }} ({{ $pet->species }})</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <a href="{{ route('pets.create', ['client' => $client->id]) }}" class="text-sm text-blue-600 hover:underline">
                Añadir Mascota
            </a>
        @endforeach
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-blue-800 mb-6">Historial de {{ $pet->name }}</h1>

    <div class="mb-6">
        <a href="{{ route('consultations.create', $pet->id) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md font-semibold shadow">
            + Crear Consulta
        </a>
    </div>

    @forelse($consultations as $consultation)
        <div class="bg-white p-6 rounded-lg mb-6 shadow border border-gray-100 flex flex-col md:flex-row md:justify-between">
            {{-- INFORMACIÓN DE LA CONSULTA --}}
            <div class="flex-1 space-y-2">
                <p class="text-sm text-gray-500"><strong>Fecha:</strong> {{ $consultation->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Tipo:</strong> {{ $consultation->type }}</p>
                <p><strong>Motivo:</strong> {{ $consultation->reason }}</p>
                <p><strong>Exploración:</strong> {{ $consultation->exploration }}</p>
                <p><strong>Diagnóstico:</strong> {{ $consultation->diagnosis }}</p>
                <p><strong>Tratamiento:</strong> {{ $consultation->treatment }}</p>

                @if($consultation->tests)
                    <p class="mt-2"><strong>Pruebas:</strong></p>
                    <ul class="list-disc list-inside text-blue-600">
                        @foreach(json_decode($consultation->tests, true) as $file)
                            <li>
                                <a href="{{ asset('storage/'.$file) }}" target="_blank" class="underline hover:text-blue-800">
                                    Ver archivo ({{ pathinfo($file, PATHINFO_EXTENSION) }})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif


                

                {{-- HOSPITALIZACIÓN (Notas por turnos) --}}
                <div class="mt-4 border-t pt-4">
                    <form method="POST" action="{{ route('hospitalization.store', $consultation->id) }}" class="space-y-2">
                        @csrf
                        <div class="flex flex-col md:flex-row gap-4">
                            <select name="shift" class="w-full md:w-40 border rounded-md px-2 py-1" required>
                                <option value="">Turno</option>
                                <option value="mañana">Mañana</option>
                                <option value="tarde">Tarde</option>
                                <option value="noche">Noche</option>
                            </select>

                            <input type="text" name="content" placeholder="Observación del turno" class="flex-1 border rounded-md px-2 py-1" required>

                            <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded-md hover:bg-green-700">Guardar</button>
                        </div>
                    </form>

                    {{-- Mostrar notas de hospitalización --}}
                    @if($consultation->hospitalizationNotes->count())
                        <div class="mt-3 space-y-1 text-sm text-gray-700">
                            @foreach($consultation->hospitalizationNotes as $note)
                                <p><strong>{{ ucfirst($note->shift) }}:</strong> {{ $note->content }} <span class="text-gray-500 text-xs">({{ $note->created_at->format('d/m H:i') }})</span></p>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- INFORMACIÓN DEL VETERINARIO --}}
            <div class="w-full md:w-64 mt-6 md:mt-0 md:ml-6 text-center border-t pt-4 md:border-t-0 md:border-l md:pt-0 md:pl-6">
                @php
                    $vet = App\Models\Employee::where('email', $consultation->vet_email)->first();
                @endphp

                @if ($vet && $vet->photo)
                    <img src="{{ asset('storage/' . $vet->photo) }}" alt="Foto del veterinario" class="w-24 h-24 rounded-full mx-auto object-cover mb-2">
                @else
                    <img src="{{ asset('images/default-vet.png') }}" alt="Foto por defecto" class="w-24 h-24 rounded-full mx-auto object-cover mb-2">
                @endif

                <p class="font-semibold">{{ $consultation->vet_name }}</p>
                <p class="text-sm text-gray-600">{{ $consultation->vet_email }}</p>
                <p class="text-sm text-blue-600">Col. Nº {{ $consultation->vet_license_number }}</p>
                <p class="text-xs text-gray-500 mt-1">Registrado el {{ $consultation->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    @empty
        <p class="text-gray-500">No hay consultas registradas para esta mascota.</p>
    @endforelse

</div>
@endsection

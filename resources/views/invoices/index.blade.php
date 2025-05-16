@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Historial de Facturas</h2>

    <!-- Filtro -->
    <form method="GET" action="{{ route('invoices.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div>
            <label for="client_id" class="block font-medium text-gray-700 mb-1">Cliente:</label>
            <select name="client_id" id="client_id" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Todos los clientes --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="from_date" class="block font-medium text-gray-700 mb-1">Desde:</label>
            <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="to_date" class="block font-medium text-gray-700 mb-1">Hasta:</label>
            <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex items-end">
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition">
                Filtrar
            </button>
        </div>
    </form>

    <!-- Tabla de facturas -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Cliente</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Fecha</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Total (€)</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Método de Pago</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($invoices as $invoice)
                    <tr>
                        <td class="px-4 py-2">{{ $invoice->id }}</td>
                        <td class="px-4 py-2">{{ $invoice->client->name }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($invoice->billing_date)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ number_format($invoice->total, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 capitalize">{{ $invoice->payment_method }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('invoices.pdf', $invoice->id) }}" target="_blank"
                               class="text-green-600 hover:text-green-800 font-semibold text-sm">
                                Descargar PDF
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No hay facturas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('billing.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-md font-semibold transition">
            Volver a Facturar
        </a>
    </div>
</div>
@endsection

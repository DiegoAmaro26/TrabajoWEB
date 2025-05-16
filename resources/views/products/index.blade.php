@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-8 bg-white shadow-md rounded-lg mt-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-blue-800">Productos</h2>
        <a href="{{ route('products.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-md transition">
            Crear Producto
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Nombre</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Stock</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Caducidad</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Precio (€)</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($products as $product)
                    <tr>
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ $product->stock }}</td>
                        <td class="px-4 py-2">
                            {{ $product->expiration_date ? \Carbon\Carbon::parse($product->expiration_date)->format('d/m/Y') : 'No aplica' }}
                        </td>
                        <td class="px-4 py-2">{{ number_format($product->price, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('products.edit', $product) }}"
                               class="text-blue-600 hover:text-blue-800 font-semibold text-sm">Editar</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar producto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

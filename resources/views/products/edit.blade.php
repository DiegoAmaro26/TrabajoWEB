@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-8 bg-white shadow-md rounded-lg mt-10">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Editar Producto</h2>

    <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium mb-1">Nombre:</label>
            <input type="text" name="name" value="{{ $product->name }}" required
                   class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Stock:</label>
            <input type="number" name="stock" value="{{ $product->stock }}" required
                   class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Fecha de caducidad (opcional):</label>
            <input type="date" name="expiration_date" value="{{ $product->expiration_date }}"
                   class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Precio (€):</label>
            <input type="number" name="price" step="0.01" value="{{ $product->price }}" required
                   class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex justify-between">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition">
                Actualizar
            </button>
            <a href="{{ route('products.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-semibold">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection

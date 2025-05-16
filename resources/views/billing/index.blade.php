@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Facturación</h2>

    <!-- Botones de gestión -->
    <div class="flex justify-end space-x-4 mb-6">
        <a href="{{ route('products.index') }}" class="bg-blue-100 text-blue-700 px-4 py-2 rounded-md hover:bg-blue-200 font-semibold">
            Gestionar Productos
        </a>
        <a href="{{ route('services.index') }}" class="bg-blue-100 text-blue-700 px-4 py-2 rounded-md hover:bg-blue-200 font-semibold">
            Gestionar Servicios
        </a>
    </div>

    <form action="{{ route('billing.store') }}" method="POST" id="invoiceForm" class="space-y-6">
        @csrf

        <!-- Cliente -->
        <div>
            <label for="client_id" class="block font-medium text-gray-700">Cliente:</label>
            <select name="client_id" id="client_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Seleccione un cliente</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->full_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Fecha -->
        <div>
            <label for="billing_date" class="block font-medium text-gray-700">Fecha de facturación:</label>
            <input type="date" name="billing_date" id="billing_date" value="{{ date('Y-m-d') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <!-- Productos -->
        <div>
            <h4 class="text-lg font-semibold text-gray-800 mb-2">Productos</h4>
            <div id="product-list" class="space-y-2"></div>
            <button type="button" onclick="addProduct()" class="mt-2 bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">+ Añadir Producto</button>
        </div>

        <!-- Servicios -->
        <div>
            <h4 class="text-lg font-semibold text-gray-800 mb-2">Servicios</h4>
            <div id="service-list" class="space-y-2"></div>
            <button type="button" onclick="addService()" class="mt-2 bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">+ Añadir Servicio</button>
        </div>

        <!-- Total -->
        <div class="text-right text-lg font-semibold">
            Total: <span id="totalDisplay">0.00</span> €
            <input type="hidden" name="total" id="totalInput">
        </div>

        <!-- Método de pago -->
        <div>
            <label class="block font-medium text-gray-700 mb-1">Método de pago:</label>
            <div class="space-x-4">
                <label><input type="radio" name="payment_method" value="efectivo" required> Efectivo</label>
                <label><input type="radio" name="payment_method" value="tarjeta" required> Tarjeta</label>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-4 pt-4">
            <button type="button" onclick="calculateTotal()" class="bg-yellow-400 hover:bg-yellow-500 text-white px-5 py-2 rounded-md font-semibold transition">
                Finalizar Facturación
            </button>
            <button type="submit" id="submitBtn" disabled class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md font-semibold transition">
                Aceptar Cobro y Generar PDF
            </button>
        </div>
    </form>
</div>

<script>
    let products = {!! json_encode($products) !!};
    let services = {!! json_encode($services) !!};

    function addProduct() {
        let index = document.querySelectorAll('.product-row').length;
        let options = products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name} - ${p.price} €</option>`).join('');
        let html = `
            <div class="product-row flex space-x-2">
                <select name="products[${index}][id]" class="flex-1 rounded-md border-gray-300" onchange="updateTotal()">
                    <option value="">Seleccione producto</option>
                    ${options}
                </select>
                <input type="number" name="products[${index}][quantity]" value="1" min="1" class="w-24 rounded-md border-gray-300" onchange="updateTotal()">
            </div>
        `;
        document.getElementById('product-list').insertAdjacentHTML('beforeend', html);
    }

    function addService() {
        let index = document.querySelectorAll('.service-row').length;
        let options = services.map(s => `<option value="${s.id}" data-price="${s.price}">${s.name} - ${s.price} €</option>`).join('');
        let html = `
            <div class="service-row">
                <select name="services[${index}][id]" class="w-full rounded-md border-gray-300" onchange="updateTotal()">
                    <option value="">Seleccione servicio</option>
                    ${options}
                </select>
            </div>
        `;
        document.getElementById('service-list').insertAdjacentHTML('beforeend', html);
    }

    function updateTotal() {
        let total = 0;

        document.querySelectorAll('.product-row').forEach(row => {
            let select = row.querySelector('select');
            let option = select.options[select.selectedIndex];
            let price = parseFloat(option.dataset.price || 0);
            let qty = parseInt(row.querySelector('input[type="number"]').value || 1);
            total += price * qty;
        });

        document.querySelectorAll('.service-row').forEach(row => {
            let select = row.querySelector('select');
            let option = select.options[select.selectedIndex];
            let price = parseFloat(option.dataset.price || 0);
            total += price;
        });

        document.getElementById('totalDisplay').textContent = total.toFixed(2);
        document.getElementById('totalInput').value = total.toFixed(2);
    }

    function calculateTotal() {
        updateTotal();
        let total = parseFloat(document.getElementById('totalInput').value || 0);
        if (total > 0) {
            document.getElementById('submitBtn').disabled = false;
            alert("Total calculado: " + total.toFixed(2) + " €. Selecciona el método de pago y haz clic en 'Aceptar Cobro'.");
        } else {
            alert("Debes añadir al menos un producto o servicio.");
        }
    }
</script>
@endsection

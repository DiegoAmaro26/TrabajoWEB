<div>
    <label for="full_name" class="block font-medium text-gray-700">Nombre Completo</label>
    <input type="text" name="full_name" value="{{ old('full_name', $client->full_name ?? '') }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
</div>

<div>
    <label for="email" class="block font-medium text-gray-700">Email</label>
    <input type="email" name="email" value="{{ old('email', $client->email ?? '') }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
</div>

<div>
    <label for="phone" class="block font-medium text-gray-700">Teléfono</label>
    <input type="text" name="phone" value="{{ old('phone', $client->phone ?? '') }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
</div>

<div>
    <label for="address" class="block font-medium text-gray-700">Dirección</label>
    <input type="text" name="address" value="{{ old('address', $client->address ?? '') }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
</div>

<div>
    <label for="photo" class="block font-medium text-gray-700">Foto</label>
    <input type="file" name="photo" class="mt-1 block w-full text-sm text-gray-500">
    @if (!empty($client?->photo))
        <img src="{{ asset('storage/' . $client->photo) }}" alt="Foto del cliente"
             class="mt-2 h-16 w-16 object-cover rounded-full border">
    @endif
</div>

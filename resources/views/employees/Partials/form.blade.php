<div class="mb-4">
    <label class="block text-gray-700 font-medium mb-1">Nombre completo</label>
    <input type="text" name="full_name" class="w-full border rounded px-3 py-2" value="{{ old('full_name', $employee->full_name ?? '') }}" required>
</div>

<div class="mb-4">
    <label class="block text-gray-700 font-medium mb-1">Rol</label>
    <select name="role" class="w-full border rounded px-3 py-2" required>
        <option value="">Selecciona un rol</option>
        @foreach (['veterinario', 'auxiliar', 'administrativo'] as $role)
            <option value="{{ $role }}" {{ (old('role', $employee->role ?? '') === $role) ? 'selected' : '' }}>
                {{ ucfirst($role) }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block text-gray-700 font-medium mb-1">Email</label>
    <input type="email" name="email" class="w-full border rounded px-3 py-2" value="{{ old('email', $employee->email ?? '') }}" required>
</div>

<div class="mb-4">
    <label class="block text-gray-700 font-medium mb-1">Teléfono</label>
    <input type="text" name="phone" class="w-full border rounded px-3 py-2" value="{{ old('phone', $employee->phone ?? '') }}" required>
</div>

<div class="mb-4">
    <label class="block text-gray-700 font-medium mb-1">Foto</label>
    <input type="file" name="photo" class="w-full border rounded px-3 py-2">
    @if (!empty($employee->photo))
        <img src="{{ asset('storage/' . $employee->photo) }}" class="mt-2 h-16 w-16 object-cover rounded-full border">
    @endif
</div>

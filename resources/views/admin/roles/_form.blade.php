@php
    $isEdit = $role !== null;
@endphp
<form action="{{ $action }}" method="post" class="space-y-6 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
    @csrf
    @method($method)

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $role->name ?? '') }}" required maxlength="50"
            class="w-full rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div>
        <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Código</label>
        <input type="text" name="code" id="code" value="{{ old('code', $role->code ?? '') }}" required maxlength="10"
            class="w-full rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm uppercase focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div>
        <label for="isActive" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
        <select name="isActive" id="isActive" class="w-full max-w-xs rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm">
            <option value="1" @selected(old('isActive', $isEdit ? ($role->isActive ? '1' : '0') : '1') === '1')>Activo</option>
            <option value="0" @selected(old('isActive', $isEdit ? ($role->isActive ? '1' : '0') : '1') === '0')>Inactivo</option>
        </select>
    </div>

    <div>
        <span class="block text-sm font-medium text-gray-700 mb-2">Permisos asignados</span>
        <p class="text-xs text-gray-500 mb-3">Selecciona los permisos que tendrá este rol (tabla pivote <code class="bg-gray-100 px-1 rounded">rolePermissions</code>).</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-3">
            @foreach ($permissions as $permission)
                <label class="flex items-start gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}"
                        class="mt-0.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        @checked(in_array((string) $permission->id, array_map('strval', old('permission_ids', $selectedPermissionIds))))>
                    <span><span class="font-medium text-gray-800">{{ $permission->name }}</span>
                        <span class="text-gray-500 text-xs block">{{ $permission->code }}</span></span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="inline-flex justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            {{ $isEdit ? 'Guardar cambios' : 'Crear rol' }}
        </button>
        <a href="{{ route('admin.roles.index') }}" class="inline-flex justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Cancelar</a>
    </div>
</form>

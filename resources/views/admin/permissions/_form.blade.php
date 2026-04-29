@php $isEdit = $permission !== null; @endphp
<form action="{{ $action }}" method="post" class="space-y-6 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
    @csrf
    @method($method)

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $permission->name ?? '') }}" required maxlength="50"
            class="w-full rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div>
        <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Código</label>
        <input type="text" name="code" id="code" value="{{ old('code', $permission->code ?? '') }}" required maxlength="50"
            class="w-full rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="Ej. USR_CREATE">
        <p class="text-xs text-gray-500 mt-1">Se guardará en mayúsculas.</p>
    </div>

    <div>
        <label for="isActive" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
        <select name="isActive" id="isActive" class="w-full max-w-xs rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm">
            <option value="1" @selected(old('isActive', $isEdit ? ($permission->isActive ? '1' : '0') : '1') === '1')>Activo</option>
            <option value="0" @selected(old('isActive', $isEdit ? ($permission->isActive ? '1' : '0') : '1') === '0')>Inactivo</option>
        </select>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="inline-flex justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            {{ $isEdit ? 'Guardar cambios' : 'Crear permiso' }}
        </button>
        <a href="{{ route('admin.permissions.index') }}" class="inline-flex justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Cancelar</a>
    </div>
</form>

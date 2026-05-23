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

    @php
        $modulePerms = $permissions->filter(fn($p) => str_ends_with($p->code, '_MOD'));
        $actionPerms = $permissions->reject(fn($p) => str_ends_with($p->code, '_MOD'));
        $checkedIds   = array_map('strval', old('permission_ids', $selectedPermissionIds));
    @endphp

    <div>
        <span class="block text-sm font-medium text-gray-700 mb-1">Acceso a módulos</span>
        <p class="text-xs text-gray-500 mb-3">
            Controla qué secciones del menú puede ver y acceder el usuario.
            Un usuario sin ningún módulo activado no verá nada tras iniciar sesión.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 border border-blue-100 bg-blue-50 rounded-lg p-3">
            @foreach ($modulePerms as $permission)
                <label class="flex items-start gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}"
                        class="mt-0.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        @checked(in_array((string) $permission->id, $checkedIds))>
                    <span>
                        <span class="font-medium text-gray-800">{{ $permission->name }}</span>
                        <span class="text-gray-500 text-xs block">{{ $permission->code }}</span>
                    </span>
                </label>
            @endforeach
        </div>
    </div>

    @if($actionPerms->isNotEmpty())
    <div>
        <span class="block text-sm font-medium text-gray-700 mb-1">Permisos de acciones</span>
        <p class="text-xs text-gray-500 mb-3">Controla operaciones específicas dentro de cada módulo.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 border border-gray-200 rounded-lg p-3">
            @foreach ($actionPerms as $permission)
                <label class="flex items-start gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}"
                        class="mt-0.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        @checked(in_array((string) $permission->id, $checkedIds))>
                    <span>
                        <span class="font-medium text-gray-800">{{ $permission->name }}</span>
                        <span class="text-gray-500 text-xs block">{{ $permission->code }}</span>
                    </span>
                </label>
            @endforeach
        </div>
    </div>
    @endif

    <div class="flex gap-3 pt-2">
        <button type="submit" class="inline-flex justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            {{ $isEdit ? 'Guardar cambios' : 'Crear rol' }}
        </button>
        <a href="{{ route('admin.roles.index') }}" class="inline-flex justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Cancelar</a>
    </div>
</form>

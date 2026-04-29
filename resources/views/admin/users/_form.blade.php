@php $isEdit = $user !== null; @endphp
<form action="{{ $action }}" method="post" class="space-y-6 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
    @csrf
    @method($method)

    <div>
        <label for="roleId" class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
        <select name="roleId" id="roleId" required class="w-full max-w-md rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">— Seleccione un rol —</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" @selected(old('roleId', $user->roleId ?? '') == $role->id)>
                    {{ $role->name }} ({{ $role->code }}){{ $role->isActive ? '' : ' — inactivo' }}
                </option>
            @endforeach
        </select>
        <p class="text-xs text-gray-500 mt-1">Listado desde la tabla <code class="bg-gray-100 px-1 rounded">roles</code>.</p>
    </div>

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required maxlength="255"
            class="w-full rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required maxlength="255"
            class="w-full rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña @if($isEdit)<span class="text-gray-400 font-normal">(opcional al editar)</span>@endif</label>
        <input type="password" name="password" id="password" @if(!$isEdit) required @endif autocomplete="new-password"
            class="w-full rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" @if(!$isEdit) required @endif autocomplete="new-password"
            class="w-full rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div>
        <label for="isActive" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
        <select name="isActive" id="isActive" class="w-full max-w-xs rounded-md border-gray-300 shadow-sm border px-3 py-2 text-sm">
            <option value="1" @selected(old('isActive', $isEdit ? ($user->isActive ? '1' : '0') : '1') === '1')>Activo</option>
            <option value="0" @selected(old('isActive', $isEdit ? ($user->isActive ? '1' : '0') : '1') === '0')>Inactivo</option>
        </select>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="inline-flex justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            {{ $isEdit ? 'Guardar cambios' : 'Crear usuario' }}
        </button>
        <a href="{{ route('admin.users.index') }}" class="inline-flex justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Cancelar</a>
    </div>
</form>

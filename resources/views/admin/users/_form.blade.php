@php $isEdit = $user !== null; @endphp

<form action="{{ $action }}" method="post" class="space-y-5">
    @csrf
    @method($method)

    <div>
        <label for="roleId" class="block text-sm font-medium text-slate-700 mb-1.5">Rol</label>
        <select name="roleId" id="roleId" required
                class="w-full max-w-md rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <option value="">— Seleccione un rol —</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" @selected(old('roleId', $user->roleId ?? '') == $role->id)>
                    {{ $role->name }} ({{ $role->code }}){{ $role->isActive ? '' : ' — inactivo' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nombre completo</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required maxlength="255"
               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Correo electrónico</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required maxlength="255"
               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
            Contraseña
            @if($isEdit)<span class="text-slate-400 font-normal text-xs">(dejar en blanco para mantener la actual)</span>@endif
        </label>
        <input type="password" name="password" id="password" @if(!$isEdit) required @endif autocomplete="new-password"
               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" @if(!$isEdit) required @endif autocomplete="new-password"
               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
    </div>

    <div>
        <label for="isActive" class="block text-sm font-medium text-slate-700 mb-1.5">Estado</label>
        <select name="isActive" id="isActive"
                class="w-full max-w-xs rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <option value="1" @selected(old('isActive', $isEdit ? ($user->isActive ? '1' : '0') : '1') === '1')>Activo</option>
            <option value="0" @selected(old('isActive', $isEdit ? ($user->isActive ? '1' : '0') : '1') === '0')>Inactivo</option>
        </select>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
            {{ $isEdit ? 'Guardar cambios' : 'Crear usuario' }}
        </button>
        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
            Cancelar
        </a>
    </div>
</form>

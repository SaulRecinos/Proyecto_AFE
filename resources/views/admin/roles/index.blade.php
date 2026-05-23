@extends('layouts.app')
@section('title', 'Roles')

@section('header')
<div class="flex items-center justify-between w-full">
    <h1 class="text-lg font-semibold text-slate-800">Roles</h1>
    <a href="{{ route('admin.roles.create') }}"
       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nuevo rol
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Código</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Estado</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Usuarios</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Módulos</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($roles as $role)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $role->name }}</td>
                    <td class="px-4 py-3">
                        <code class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-mono">{{ $role->code }}</code>
                    </td>
                    <td class="px-4 py-3">
                        @if($role->isActive)
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Activo</span>
                        @else
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Inactivo</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-slate-600 text-xs">
                        {{ $role->users->isEmpty() ? '—' : $role->users->pluck('name')->join(', ') }}
                    </td>
                    <td class="px-4 py-3 text-slate-600 text-xs">
                        {{ $role->permissions->isEmpty() ? '—' : $role->permissions->pluck('name')->join(', ') }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.roles.edit', $role) }}"
                               class="text-indigo-600 hover:text-indigo-800 text-xs font-medium transition">Editar</a>
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="post" class="inline"
                                  onsubmit="return confirm('¿Eliminar el rol «{{ $role->name }}»?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium transition">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-slate-400 text-sm">No hay roles registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

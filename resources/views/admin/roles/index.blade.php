@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Roles</h1>
        <a href="{{ route('admin.roles.create') }}" class="inline-flex justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Nuevo rol</a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600">Nombre</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Código</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Estado</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Usuarios</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Permisos</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($roles as $role)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $role->name }}</td>
                            <td class="px-4 py-3 text-gray-600"><code class="text-xs bg-gray-100 px-1 rounded">{{ $role->code }}</code></td>
                            <td class="px-4 py-3">
                                @if ($role->isActive)
                                    <span class="text-emerald-700 text-xs font-medium">Activo</span>
                                @else
                                    <span class="text-gray-500 text-xs">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs max-w-sm align-top">
                                @if ($role->users->isEmpty())
                                    <span class="text-gray-400">—</span>
                                @else
                                    {{ $role->users->pluck('name')->join(', ') }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs max-w-sm align-top">
                                @if ($role->permissions->isEmpty())
                                    <span class="text-gray-400">—</span>
                                @else
                                    {{ $role->permissions->pluck('name')->join(', ') }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="post" class="inline" onsubmit="return confirm('¿Eliminar este rol?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">No hay roles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

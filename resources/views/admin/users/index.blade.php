@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Usuarios</h1>
        <a href="{{ route('admin.users.create') }}" class="inline-flex justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Nuevo usuario</a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600">Nombre</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Email</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Rol</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Estado</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $user->role?->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($user->isActive)
                                    <span class="text-emerald-700 text-xs font-medium">Activo</span>
                                @else
                                    <span class="text-gray-500 text-xs">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="post" class="inline" onsubmit="return confirm('¿Eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">No hay usuarios.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

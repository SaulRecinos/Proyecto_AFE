@extends('layouts.app')
@section('title', 'Categorías')

@section('header')
<div class="flex items-center justify-between w-full">
    <h1 class="text-lg font-semibold text-slate-800">Categorías</h1>
    <a href="{{ route('inventory.categories.create') }}"
       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nueva categoría
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nombre</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Estado</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($categories as $c)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 font-medium text-slate-900">{{ $c->name }}</td>
                <td class="px-4 py-3">
                    @if($c->isActive)
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Activo</span>
                    @else
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Inactivo</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('inventory.categories.edit', $c) }}" class="text-indigo-600 hover:text-indigo-800 text-xs font-medium transition">Editar</a>
                        <form action="{{ route('inventory.categories.destroy', $c) }}" method="post" class="inline"
                              onsubmit="return confirm('¿Eliminar la categoría «{{ $c->name }}»?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium transition">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="px-4 py-10 text-center text-slate-400 text-sm">No hay categorías registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

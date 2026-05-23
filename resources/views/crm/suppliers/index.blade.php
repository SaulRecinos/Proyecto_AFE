@extends('layouts.app')
@section('title', 'Proveedores')

@section('header')
<div class="flex items-center justify-between w-full">
    <h1 class="text-lg font-semibold text-slate-800">Proveedores</h1>
    <a href="{{ route('crm.suppliers.create') }}"
       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nuevo proveedor
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
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">NIT</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Contacto</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Teléfono</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Estado</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($suppliers as $supplier)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $supplier->name }}</td>
                    <td class="px-4 py-3 text-slate-600 font-mono text-xs">{{ $supplier->taxId ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $supplier->contactName ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $supplier->phoneNumber ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @if($supplier->isActive)
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Activo</span>
                        @else
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Inactivo</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('crm.suppliers.edit', $supplier) }}"
                               class="text-indigo-600 hover:text-indigo-800 text-xs font-medium transition">Editar</a>
                            <form action="{{ route('crm.suppliers.destroy', $supplier) }}" method="post" class="inline"
                                  onsubmit="return confirm('¿Eliminar al proveedor «{{ $supplier->name }}»?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium transition">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-slate-400 text-sm">No hay proveedores registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

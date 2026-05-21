@extends('layouts.app')
@section('title', 'Proveedores')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Proveedores</h1>
        <a href="{{ route('crm.suppliers.create') }}" class="inline-flex px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Nuevo proveedor</a>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b"><tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Nombre</th>
                <th class="px-4 py-3 font-semibold text-gray-600">NIT</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Contacto</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Estado</th>
                <th class="px-4 py-3 text-right font-semibold text-gray-600">Acciones</th>
            </tr></thead>
            <tbody class="divide-y">
                @forelse ($suppliers as $supplier)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $supplier->name }}</td>
                    <td class="px-4 py-3">{{ $supplier->taxId ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $supplier->contactName ?? $supplier->phoneNumber ?? '—' }}</td>
                    <td class="px-4 py-3"><span class="text-xs {{ $supplier->isActive ? 'text-emerald-700' : 'text-gray-500' }}">{{ $supplier->isActive ? 'Activo' : 'Inactivo' }}</span></td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('crm.suppliers.edit', $supplier) }}" class="text-blue-600 hover:underline">Editar</a>
                        <form action="{{ route('crm.suppliers.destroy', $supplier) }}" method="post" class="inline" onsubmit="return confirm('¿Eliminar?');">@csrf @method('DELETE')<button class="text-red-600 hover:underline">Eliminar</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Sin proveedores.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

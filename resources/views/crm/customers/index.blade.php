@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Clientes</h1>
        <a href="{{ route('crm.customers.create') }}" class="inline-flex justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Nuevo cliente</a>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600">Nombre</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tipo</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">NIT</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Contacto</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Estado</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium">{{ $customer->fullName }}</td>
                            <td class="px-4 py-3">{{ $customer->customerType?->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $customer->taxId ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $customer->email ?? $customer->phoneNumber ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-medium {{ $customer->isActive ? 'text-emerald-700' : 'text-gray-500' }}">
                                    {{ $customer->isActive ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('crm.customers.edit', $customer) }}" class="text-blue-600 hover:underline">Editar</a>
                                <form action="{{ route('crm.customers.destroy', $customer) }}" method="post" class="inline" onsubmit="return confirm('¿Eliminar este cliente?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">No hay clientes registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

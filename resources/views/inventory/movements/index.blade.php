@extends('layouts.app')
@section('title', 'Movimientos de inventario')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between"><h1 class="text-2xl font-bold">Movimientos de inventario</h1>
        <a href="{{ route('inventory.movements.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg">Registrar movimiento</a></div>
    <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr>
            <th class="px-4 py-3 text-left">Fecha</th><th class="px-4 py-3 text-left">Producto</th>
            <th class="px-4 py-3">Tipo</th><th class="px-4 py-3 text-center">Cantidad</th>
            <th class="px-4 py-3 text-left">Motivo</th><th class="px-4 py-3 text-right">Acciones</th>
        </tr></thead><tbody class="divide-y">
        @forelse($movements as $m)
        <tr>
            <td class="px-4 py-3">{{ $m->createdAt?->format('d/m/Y H:i') }}</td>
            <td class="px-4 py-3">{{ $m->product?->name }}</td>
            <td class="px-4 py-3 text-center">{{ $m->movementType?->name }}</td>
            <td class="px-4 py-3 text-center font-medium">{{ $m->quantity }}</td>
            <td class="px-4 py-3 text-gray-600">{{ $m->reason ?? '—' }}</td>
            <td class="px-4 py-3 text-right">
                <form action="{{ route('inventory.movements.destroy',$m) }}" method="post" class="inline" onsubmit="return confirm('¿Revertir movimiento?')">@csrf @method('DELETE')
                <button class="text-red-600 text-xs">Revertir</button></form>
            </td>
        </tr>
        @empty<tr><td colspan="6" class="p-8 text-center text-gray-500">Sin movimientos</td></tr>@endforelse
        </tbody></table>
    </div>
</div>
@endsection

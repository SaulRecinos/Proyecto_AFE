@extends('layouts.app')
@section('title', 'Movimientos de inventario')

@section('header')
<div class="flex items-center justify-between w-full">
    <h1 class="text-lg font-semibold text-slate-800">Movimientos de inventario</h1>
    <a href="{{ route('inventory.movements.create') }}"
       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Registrar movimiento
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Producto</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Cantidad</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Motivo</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($movements as $m)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-slate-500 text-xs">{{ $m->createdAt?->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $m->product?->name }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                            {{ $m->movementType?->name }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center font-semibold text-slate-700">{{ $m->quantity }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $m->reason ?? '—' }}</td>
                    <td class="px-4 py-3 text-right">
                        <form action="{{ route('inventory.movements.destroy', $m) }}" method="post" class="inline"
                              onsubmit="return confirm('¿Revertir este movimiento?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium transition">Revertir</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-slate-400 text-sm">No hay movimientos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

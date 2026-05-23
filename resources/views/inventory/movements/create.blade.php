@extends('layouts.app')
@section('title', 'Registrar movimiento')

@section('header')
<div class="flex items-center gap-3 w-full">
    <a href="{{ route('inventory.movements.index') }}" class="text-slate-400 hover:text-slate-600 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <h1 class="text-lg font-semibold text-slate-800">Registrar movimiento</h1>
</div>
@endsection

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-base font-semibold text-slate-800">Datos del movimiento</h2>
        </div>
        <div class="px-6 py-5">
            <form action="{{ route('inventory.movements.store') }}" method="post" class="space-y-5">
                @csrf

                <div>
                    <label for="productId" class="block text-sm font-medium text-slate-700 mb-1.5">Producto</label>
                    <select name="productId" id="productId" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">— Seleccione un producto —</option>
                        @foreach($products as $p)
                        <option value="{{ $p->id }}" @selected(old('productId', $selectedProductId ?? '') == $p->id)>
                            {{ $p->sku }} — {{ $p->name }} (stock: {{ $p->currentStock }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="movementTypeId" class="block text-sm font-medium text-slate-700 mb-1.5">Tipo de movimiento</label>
                    <select name="movementTypeId" id="movementTypeId" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @foreach($movementTypes as $t)
                        <option value="{{ $t->id }}" @selected(old('movementTypeId') == $t->id)>{{ $t->name }} ({{ $t->code }})</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-500 mt-1.5 bg-slate-50 border border-slate-200 rounded px-3 py-1.5">
                        IN / RET suman al stock &mdash; OUT resta &mdash; ADJ establece el stock al valor indicado.
                    </p>
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-slate-700 mb-1.5">Cantidad</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', 1) }}" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <div>
                    <label for="reason" class="block text-sm font-medium text-slate-700 mb-1.5">Motivo</label>
                    <input type="text" name="reason" id="reason" value="{{ old('reason') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                        Registrar movimiento
                    </button>
                    <a href="{{ route('inventory.movements.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

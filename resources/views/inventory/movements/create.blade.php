@extends('layouts.app')
@section('title', 'Nuevo movimiento')
@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold">Registrar movimiento</h1>
    <form action="{{ route('inventory.movements.store') }}" method="post" class="bg-white border rounded-xl p-6 max-w-lg space-y-4 shadow-sm">
        @csrf
        <div><label class="block text-sm font-medium mb-1">Producto</label>
            <select name="productId" required class="w-full border rounded-md px-3 py-2 text-sm">
                <option value="">— Seleccione —</option>
                @foreach($products as $p)
                <option value="{{ $p->id }}" @selected(old('productId', $selectedProductId ?? '') == $p->id)>{{ $p->sku }} — {{ $p->name }} (stock: {{ $p->currentStock }})</option>
                @endforeach
            </select></div>
        <div><label class="block text-sm font-medium mb-1">Tipo de movimiento</label>
            <select name="movementTypeId" required class="w-full border rounded-md px-3 py-2 text-sm">
                @foreach($movementTypes as $t)
                <option value="{{ $t->id }}" @selected(old('movementTypeId')==$t->id)>{{ $t->name }} ({{ $t->code }})</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">IN/RET suman stock, OUT resta, ADJ establece el stock al valor indicado.</p>
        </div>
        <div><label class="block text-sm font-medium mb-1">Cantidad</label>
            <input type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" required class="w-full border rounded-md px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Motivo</label>
            <input name="reason" value="{{ old('reason') }}" class="w-full border rounded-md px-3 py-2 text-sm"></div>
        <div class="flex gap-3">
            <button class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg">Registrar</button>
            <a href="{{ route('inventory.movements.index') }}" class="px-4 py-2 border text-sm rounded-lg">Cancelar</a>
        </div>
    </form>
</div>
@endsection

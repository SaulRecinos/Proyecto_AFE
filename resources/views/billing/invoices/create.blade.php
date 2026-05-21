@extends('layouts.app')
@section('title', 'Nueva factura')
@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold">Nueva factura</h1>
    <form action="{{ route('billing.invoices.store') }}" method="post" id="invoice-form" class="space-y-6">
        @csrf
        <div class="bg-white border rounded-xl p-6 shadow-sm grid sm:grid-cols-2 gap-4 max-w-4xl">
            <div><label class="block text-sm font-medium mb-1">Cliente</label>
                <select name="customerId" required class="w-full border rounded-md px-3 py-2 text-sm">
                    <option value="">— Seleccione —</option>
                    @foreach($customers as $c)<option value="{{ $c->id }}" @selected(old('customerId')==$c->id)>{{ $c->fullName }}</option>@endforeach
                </select></div>
            <div><label class="block text-sm font-medium mb-1">Fecha</label>
                <input type="date" name="issueDate" value="{{ old('issueDate', now()->format('Y-m-d')) }}" required class="w-full border rounded-md px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Estado de pago</label>
                <select name="paymentStatusId" required class="w-full border rounded-md px-3 py-2 text-sm">
                    @foreach($paymentStatuses as $s)<option value="{{ $s->id }}" @selected(old('paymentStatusId')==$s->id)>{{ $s->name }}</option>@endforeach
                </select></div>
            <div><label class="block text-sm font-medium mb-1">Método de pago</label>
                <select name="paymentMethodId" required class="w-full border rounded-md px-3 py-2 text-sm">
                    @foreach($paymentMethods as $m)<option value="{{ $m->id }}" @selected(old('paymentMethodId')==$m->id)>{{ $m->name }}</option>@endforeach
                </select></div>
        </div>

        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-800">Líneas de detalle</h2>
                <button type="button" id="add-line" class="text-sm text-blue-600 hover:underline">+ Agregar línea</button>
            </div>
            <div id="lines-container" class="space-y-3"></div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg">Emitir factura</button>
            <a href="{{ route('billing.invoices.index') }}" class="px-4 py-2 border text-sm rounded-lg">Cancelar</a>
        </div>
    </form>
</div>

<template id="line-template">
    <div class="line-row grid sm:grid-cols-12 gap-2 items-end border-b border-gray-100 pb-3">
        <div class="sm:col-span-5"><label class="text-xs text-gray-500">Producto</label>
            <select name="lines[__INDEX__][productId]" required class="product-select w-full border rounded-md px-2 py-2 text-sm">
                <option value="">— Producto —</option>
                @foreach($products as $p)
                <option value="{{ $p->id }}" data-price="{{ $p->salePrice }}" data-stock="{{ $p->currentStock }}">{{ $p->sku }} — {{ $p->name }} ({{ $p->currentStock }})</option>
                @endforeach
            </select></div>
        <div class="sm:col-span-2"><label class="text-xs text-gray-500">Cantidad</label>
            <input type="number" name="lines[__INDEX__][quantity]" min="1" value="1" required class="qty-input w-full border rounded-md px-2 py-2 text-sm"></div>
        <div class="sm:col-span-2"><label class="text-xs text-gray-500">Precio unit. (USD)</label>
            <input type="number" step="0.01" min="0" name="lines[__INDEX__][unitPrice]" required class="price-input w-full border rounded-md px-2 py-2 text-sm"></div>
        <div class="sm:col-span-2"><label class="text-xs text-gray-500">Subtotal</label>
            <div class="line-total text-sm font-medium py-2">$0.00</div></div>
        <div class="sm:col-span-1"><button type="button" class="remove-line text-red-600 text-xs py-2">Quitar</button></div>
    </div>
</template>

<script>
(function () {
    var container = document.getElementById('lines-container');
    var template = document.getElementById('line-template').innerHTML;
    var index = 0;

    function bindRow(row) {
        var product = row.querySelector('.product-select');
        var qty = row.querySelector('.qty-input');
        var price = row.querySelector('.price-input');
        var total = row.querySelector('.line-total');
        function recalc() {
            var t = (parseFloat(price.value) || 0) * (parseInt(qty.value, 10) || 0);
            total.textContent = '$' + t.toFixed(2);
        }
        product.addEventListener('change', function () {
            var opt = product.selectedOptions[0];
            if (opt && opt.dataset.price) price.value = opt.dataset.price;
            recalc();
        });
        qty.addEventListener('input', recalc);
        price.addEventListener('input', recalc);
        row.querySelector('.remove-line').addEventListener('click', function () {
            if (container.children.length > 1) row.remove();
        });
        recalc();
    }

    function addLine() {
        var html = template.replace(/__INDEX__/g, index++);
        var wrap = document.createElement('div');
        wrap.innerHTML = html;
        var row = wrap.firstElementChild;
        container.appendChild(row);
        bindRow(row);
    }

    document.getElementById('add-line').addEventListener('click', addLine);
    addLine();
})();
</script>
@endsection

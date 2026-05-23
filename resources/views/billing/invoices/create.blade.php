@extends('layouts.app')
@section('title', 'Nueva factura')

@section('header')
<div class="flex items-center gap-3 w-full">
    <a href="{{ route('billing.invoices.index') }}" class="text-slate-400 hover:text-slate-600 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <h1 class="text-lg font-semibold text-slate-800">Nueva factura</h1>
</div>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">
    <form action="{{ route('billing.invoices.store') }}" method="post" id="invoice-form" class="space-y-6">
        @csrf

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-slate-800">Datos de la factura</h2>
            </div>
            <div class="px-6 py-5 grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Cliente</label>
                    <select name="customerId" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">— Seleccione —</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}" @selected(old('customerId') == $c->id)>{{ $c->fullName }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Fecha</label>
                    <input type="date" name="issueDate" value="{{ old('issueDate', now()->format('Y-m-d')) }}" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Estado de pago</label>
                    <select name="paymentStatusId" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @foreach($paymentStatuses as $s)
                        <option value="{{ $s->id }}" @selected(old('paymentStatusId') == $s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Método de pago</label>
                    <select name="paymentMethodId" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @foreach($paymentMethods as $m)
                        <option value="{{ $m->id }}" @selected(old('paymentMethodId') == $m->id)>{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-base font-semibold text-slate-800">Líneas de detalle</h2>
                <button type="button" id="add-line"
                        class="inline-flex items-center gap-1.5 text-sm text-indigo-600 hover:text-indigo-800 font-medium transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Agregar línea
                </button>
            </div>
            <div class="px-6 py-5">
                <div id="lines-container" class="space-y-4"></div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                Emitir factura
            </button>
            <a href="{{ route('billing.invoices.index') }}"
               class="inline-flex items-center px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>

<template id="line-template">
    <div class="line-row grid sm:grid-cols-12 gap-3 items-end pb-4 border-b border-gray-100 last:border-0">
        <div class="sm:col-span-5">
            <label class="text-xs text-slate-500 font-medium">Producto</label>
            <select name="lines[__INDEX__][productId]" required
                    class="product-select w-full rounded-lg border border-slate-300 px-2 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">— Producto —</option>
                @foreach($products as $p)
                <option value="{{ $p->id }}" data-price="{{ $p->salePrice }}" data-stock="{{ $p->currentStock }}">{{ $p->sku }} — {{ $p->name }} ({{ $p->currentStock }})</option>
                @endforeach
            </select>
        </div>
        <div class="sm:col-span-2">
            <label class="text-xs text-slate-500 font-medium">Cantidad</label>
            <input type="number" name="lines[__INDEX__][quantity]" min="1" value="1" required
                   class="qty-input w-full rounded-lg border border-slate-300 px-2 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="sm:col-span-2">
            <label class="text-xs text-slate-500 font-medium">Precio unit. (USD)</label>
            <input type="number" step="0.01" min="0" name="lines[__INDEX__][unitPrice]" required
                   class="price-input w-full rounded-lg border border-slate-300 px-2 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="sm:col-span-2">
            <label class="text-xs text-slate-500 font-medium">Subtotal</label>
            <div class="line-total text-sm font-semibold text-slate-700 py-2 mt-1">$0.00</div>
        </div>
        <div class="sm:col-span-1 flex items-end pb-0.5">
            <button type="button" class="remove-line text-red-400 hover:text-red-600 transition" title="Quitar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
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

@extends('layouts.app')
@section('title', 'Factura '.$invoice->invoiceNumber)

@section('header')
<div class="flex items-center gap-3 w-full">
    <a href="{{ route('billing.invoices.index') }}" class="text-slate-400 hover:text-slate-600 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-lg font-semibold text-slate-800">Factura {{ $invoice->invoiceNumber }}</h1>
        <p class="text-xs text-slate-400">Emitida el {{ $invoice->issueDate?->format('d/m/Y H:i') }}</p>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-base font-semibold text-slate-800">Datos generales</h2>
        </div>
        <div class="px-6 py-5 grid sm:grid-cols-2 gap-5 text-sm">
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Cliente</p>
                <p class="font-medium text-slate-900">{{ $invoice->customer?->fullName }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Vendedor</p>
                <p class="font-medium text-slate-900">{{ $invoice->seller?->name }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Estado de pago</p>
                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                    {{ $invoice->paymentStatus?->name }}
                </span>
            </div>
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Método de pago</p>
                <p class="font-medium text-slate-900">{{ $invoice->paymentMethod?->name }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-base font-semibold text-slate-800">Líneas de detalle</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Producto</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Cant.</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Precio unit.</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total línea</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($invoice->details as $line)
                    <tr>
                        <td class="px-4 py-3 text-slate-900">{{ $line->product?->name }}</td>
                        <td class="px-4 py-3 text-center text-slate-700">{{ $line->quantity }}</td>
                        <td class="px-4 py-3 text-right text-slate-700">{{ format_usd($line->unitPrice) }}</td>
                        <td class="px-4 py-3 text-right font-medium text-slate-700">{{ format_usd($line->lineTotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 border-t border-gray-200">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-semibold text-slate-700">Total</td>
                        <td class="px-4 py-3 text-right font-bold text-lg text-slate-900">{{ format_usd($invoice->totalAmount) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div>
        <form action="{{ route('billing.invoices.destroy', $invoice) }}" method="post" class="inline"
              onsubmit="return confirm('¿Eliminar esta factura? Esta acción no se puede deshacer.');">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium transition">Eliminar factura</button>
        </form>
    </div>
</div>
@endsection

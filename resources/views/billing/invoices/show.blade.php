@extends('layouts.app')
@section('title', 'Factura '.$invoice->invoiceNumber)
@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold">Factura {{ $invoice->invoiceNumber }}</h1>
            <p class="text-sm text-gray-500 mt-1">Emitida el {{ $invoice->issueDate?->format('d/m/Y H:i') }}</p>
        </div>
        <a href="{{ route('billing.invoices.index') }}" class="text-sm text-blue-600 hover:underline">← Volver al listado</a>
    </div>

    <div class="bg-white border rounded-xl p-6 shadow-sm grid sm:grid-cols-2 gap-4 text-sm">
        <div><span class="text-gray-500">Cliente</span><p class="font-medium">{{ $invoice->customer?->fullName }}</p></div>
        <div><span class="text-gray-500">Vendedor</span><p class="font-medium">{{ $invoice->seller?->name }}</p></div>
        <div><span class="text-gray-500">Estado de pago</span><p>{{ $invoice->paymentStatus?->name }}</p></div>
        <div><span class="text-gray-500">Método de pago</span><p>{{ $invoice->paymentMethod?->name }}</p></div>
    </div>

    <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr>
            <th class="px-4 py-3 text-left">Producto</th><th class="px-4 py-3 text-center">Cant.</th>
            <th class="px-4 py-3 text-right">Precio</th><th class="px-4 py-3 text-right">Total línea</th>
        </tr></thead><tbody class="divide-y">
        @foreach($invoice->details as $line)
        <tr>
            <td class="px-4 py-3">{{ $line->product?->name }}</td>
            <td class="px-4 py-3 text-center">{{ $line->quantity }}</td>
            <td class="px-4 py-3 text-right">{{ format_usd($line->unitPrice) }}</td>
            <td class="px-4 py-3 text-right">{{ format_usd($line->lineTotal) }}</td>
        </tr>
        @endforeach
        </tbody>
        <tfoot class="bg-gray-50 border-t"><tr>
            <td colspan="3" class="px-4 py-3 text-right font-semibold">Total</td>
            <td class="px-4 py-3 text-right font-bold text-lg">{{ format_usd($invoice->totalAmount) }}</td>
        </tr></tfoot>
    </table>
    </div>
</div>
@endsection

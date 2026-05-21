@extends('layouts.app')
@section('title', 'Facturas')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between"><h1 class="text-2xl font-bold">Facturas</h1>
        <a href="{{ route('billing.invoices.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg">Nueva factura</a></div>
    <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr>
            <th class="px-4 py-3 text-left">Número</th><th class="px-4 py-3">Cliente</th>
            <th class="px-4 py-3">Fecha</th><th class="px-4 py-3">Estado pago</th>
            <th class="px-4 py-3 text-right">Total</th><th class="px-4 py-3 text-right">Acciones</th>
        </tr></thead><tbody class="divide-y">
        @forelse($invoices as $inv)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 font-mono text-xs">{{ $inv->invoiceNumber }}</td>
            <td class="px-4 py-3">{{ $inv->customer?->fullName }}</td>
            <td class="px-4 py-3">{{ $inv->issueDate?->format('d/m/Y') }}</td>
            <td class="px-4 py-3 text-center">{{ $inv->paymentStatus?->name }}</td>
            <td class="px-4 py-3 text-right font-medium">{{ format_usd($inv->totalAmount) }}</td>
            <td class="px-4 py-3 text-right"><a href="{{ route('billing.invoices.show',$inv) }}" class="text-blue-600">Ver</a></td>
        </tr>
        @empty<tr><td colspan="6" class="p-8 text-center text-gray-500">Sin facturas</td></tr>@endforelse
        </tbody></table>
    </div>
</div>
@endsection

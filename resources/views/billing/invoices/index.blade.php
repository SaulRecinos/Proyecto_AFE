@extends('layouts.app')
@section('title', 'Facturas')

@section('header')
<div class="flex items-center justify-between w-full">
    <h1 class="text-lg font-semibold text-slate-800">Facturas</h1>
    <a href="{{ route('billing.invoices.create') }}"
       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nueva factura
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Número</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Estado pago</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($invoices as $inv)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-mono text-xs text-slate-700">{{ $inv->invoiceNumber }}</td>
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $inv->customer?->fullName }}</td>
                    <td class="px-4 py-3 text-slate-500 text-xs">{{ $inv->issueDate?->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                            {{ $inv->paymentStatus?->name }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right font-semibold text-slate-700">{{ format_usd($inv->totalAmount) }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('billing.invoices.show', $inv) }}"
                           class="text-indigo-600 hover:text-indigo-800 text-xs font-medium transition">Ver</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-slate-400 text-sm">No hay facturas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

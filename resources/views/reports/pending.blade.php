@extends('layouts.app')
@section('title', 'Facturas pendientes')

@section('header')
<div class="flex items-center gap-3 w-full">
    <a href="{{ route('reports.index') }}" class="text-slate-400 hover:text-slate-600 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-lg font-semibold text-slate-800">Facturas pendientes de pago</h1>
        <p class="text-xs text-slate-400">Monto total pendiente: <strong class="text-amber-600">{{ format_usd($totalPending) }}</strong></p>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">

    @if($invoices->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm max-w-xl">
        <h2 class="text-sm font-semibold text-slate-800 mb-4">Monto por factura</h2>
        <canvas id="pendingChart" height="200"></canvas>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Número</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Estado</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($invoices as $inv)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <a href="{{ route('billing.invoices.show', $inv) }}"
                               class="text-indigo-600 hover:text-indigo-800 font-mono text-xs font-medium transition">{{ $inv->invoiceNumber }}</a>
                        </td>
                        <td class="px-4 py-3 text-slate-900">{{ $inv->customer?->fullName }}</td>
                        <td class="px-4 py-3 text-slate-500 text-xs">{{ $inv->issueDate?->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                {{ $inv->paymentStatus?->name }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-slate-700">{{ format_usd($inv->totalAmount) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-10 text-center text-slate-400 text-sm">No hay facturas con estado pendiente.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const invoices = @json($invoices);
    if (!invoices.length) return;

    const labels = invoices.map(i => i.invoiceNumber);
    const amounts = invoices.map(i => parseFloat(i.totalAmount));

    new Chart(document.getElementById('pendingChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Monto (USD)',
                data: amounts,
                backgroundColor: 'rgba(245, 158, 11, 0.75)'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false }, ticks: { maxRotation: 45, minRotation: 45, font: { size: 10 } } }
            }
        }
    });
});
</script>
@endpush

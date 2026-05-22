@extends('layouts.app')
@section('title', 'Facturas pendientes')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Facturas pendientes de pago</h1>
            <p class="text-sm text-slate-500 mt-1">Monto total pendiente: <strong class="text-amber-700">{{ format_usd($totalPending) }}</strong></p>
        </div>
        <a href="{{ route('reports.index') }}" class="text-sm text-blue-600 hover:underline">← Panel de reportes</a>
    </div>

    @if($invoices->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm max-w-xl">
        <h2 class="text-sm font-semibold text-gray-800 mb-4">Monto por factura</h2>
        <canvas id="pendingChart" height="200"></canvas>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Número</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Cliente</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Fecha</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Estado</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($invoices as $inv)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <a href="{{ route('billing.invoices.show', $inv) }}" class="text-blue-600 font-mono text-xs hover:underline">{{ $inv->invoiceNumber }}</a>
                    </td>
                    <td class="px-4 py-3">{{ $inv->customer?->fullName }}</td>
                    <td class="px-4 py-3">{{ $inv->issueDate?->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ $inv->paymentStatus?->name }}</td>
                    <td class="px-4 py-3 text-right font-medium">{{ format_usd($inv->totalAmount) }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No hay facturas con estado pendiente.</td></tr>
                @endforelse
            </tbody>
        </table>
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

@extends('layouts.app')
@section('title', 'Ventas por período')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Ventas por período</h1>
            <p class="text-sm text-slate-500 mt-1">Total histórico: <strong>{{ format_usd($totalGeneral) }}</strong></p>
        </div>
        <a href="{{ route('reports.index') }}" class="text-sm text-blue-600 hover:underline">← Panel de reportes</a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <h2 class="text-sm font-semibold text-gray-800 mb-4">Evolución de ventas</h2>
        <canvas id="salesDetailChart" height="100"></canvas>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Período</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Facturas</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Total ventas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sales->sortByDesc('period') as $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $row->period }}</td>
                    <td class="px-4 py-3 text-center">{{ $row->invoiceCount }}</td>
                    <td class="px-4 py-3 text-right">{{ format_usd($row->totalSales) }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-4 py-8 text-center text-gray-500">Sin datos de ventas. Emita facturas para generar el reporte.</td></tr>
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
    const sales = @json($sales->values());
    if (!sales.length) return;

    new Chart(document.getElementById('salesDetailChart'), {
        type: 'bar',
        data: {
            labels: sales.map(r => r.period),
            datasets: [
                {
                    label: 'Ventas (USD)',
                    data: sales.map(r => parseFloat(r.totalSales)),
                    backgroundColor: 'rgba(37, 99, 235, 0.75)',
                    yAxisID: 'y'
                },
                {
                    label: 'Nº facturas',
                    data: sales.map(r => r.invoiceCount),
                    type: 'line',
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'transparent',
                    yAxisID: 'y1',
                    tension: 0.2
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { type: 'linear', position: 'left', beginAtZero: true, grid: { color: '#f3f4f6' } },
                y1: { type: 'linear', position: 'right', beginAtZero: true, grid: { drawOnChartArea: false } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush

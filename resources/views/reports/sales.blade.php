@extends('layouts.app')
@section('title', 'Ventas por período')

@section('header')
<div class="flex items-center gap-3 w-full">
    <a href="{{ route('reports.index') }}" class="text-slate-400 hover:text-slate-600 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-lg font-semibold text-slate-800">Ventas por período</h1>
        <p class="text-xs text-slate-400">Total histórico: <strong class="text-slate-600">{{ format_usd($totalGeneral) }}</strong></p>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-800 mb-4">Evolución de ventas</h2>
        <canvas id="salesDetailChart" height="100"></canvas>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Período</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Facturas</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total ventas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sales->sortByDesc('period') as $row)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $row->period }}</td>
                        <td class="px-4 py-3 text-center text-slate-700">{{ $row->invoiceCount }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-slate-700">{{ format_usd($row->totalSales) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-4 py-10 text-center text-slate-400 text-sm">Sin datos de ventas. Emita facturas para generar el reporte.</td></tr>
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

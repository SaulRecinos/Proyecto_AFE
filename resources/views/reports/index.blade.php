@extends('layouts.app')
@section('title', 'Reportes')

@section('header')
<h1 class="text-lg font-semibold text-slate-800">Panel de reportes</h1>
@endsection

@section('content')
<div class="space-y-8">

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Ventas acumuladas</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ format_usd($kpis['totalSales']) }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $kpis['invoiceCount'] }} facturas emitidas</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Facturas pendientes</p>
            <p class="mt-2 text-2xl font-bold text-amber-600">{{ $kpis['pendingInvoices'] }}</p>
            <a href="{{ route('reports.pending') }}" class="text-xs text-indigo-600 hover:text-indigo-800 mt-1 inline-block transition">Ver detalle →</a>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Stock crítico</p>
            <p class="mt-2 text-2xl font-bold text-red-600">{{ $kpis['lowStockCount'] }}</p>
            <p class="text-xs text-slate-400 mt-1">productos con stock ≤ {{ \App\Services\ReportService::LOW_STOCK_THRESHOLD }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Clientes activos</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $kpis['customerCount'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Productos activos</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $kpis['productCount'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm flex flex-col justify-center gap-2.5">
            <a href="{{ route('reports.sales') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition">Ventas por período →</a>
            <a href="{{ route('reports.low-stock') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition">Stock bajo →</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h2 class="text-sm font-semibold text-slate-800 mb-4">Ventas mensuales (USD)</h2>
            <canvas id="salesChart" height="220"></canvas>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h2 class="text-sm font-semibold text-slate-800 mb-4">Facturas por estado de pago</h2>
            <canvas id="statusChart" height="220"></canvas>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h2 class="text-sm font-semibold text-slate-800 mb-4">Stock por categoría (unidades)</h2>
            <canvas id="stockCategoryChart" height="220"></canvas>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h2 class="text-sm font-semibold text-slate-800 mb-4">Productos más vendidos (unidades)</h2>
            <canvas id="topProductsChart" height="220"></canvas>
        </div>
    </div>

    @if($movementsByType->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-800 mb-4">Movimientos de inventario (últimos 30 días)</h2>
        <canvas id="movementsChart" height="120"></canvas>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sales = @json($salesByPeriod);
    const statuses = @json($invoicesByStatus);
    const categories = @json($stockByCategory);
    const topProducts = @json($topProducts);
    const movements = @json($movementsByType);

    const chartDefaults = {
        responsive: true,
        plugins: { legend: { position: 'top', labels: { font: { size: 11 } } } },
        scales: {
            y: { grid: { color: '#f3f4f6' }, beginAtZero: true },
            x: { grid: { display: false } }
        }
    };

    if (sales.length && document.getElementById('salesChart')) {
        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: sales.map(r => r.period),
                datasets: [{
                    label: 'Ventas (USD)',
                    data: sales.map(r => parseFloat(r.totalSales)),
                    borderColor: 'rgb(37, 99, 235)',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.2
                }]
            },
            options: chartDefaults
        });
    }

    if (statuses.length && document.getElementById('statusChart')) {
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: statuses.map(r => r.label),
                datasets: [{
                    data: statuses.map(r => r.total),
                    backgroundColor: ['#f59e0b', '#10b981', '#3b82f6', '#ef4444', '#8b5cf6']
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'right' } } }
        });
    }

    if (categories.length && document.getElementById('stockCategoryChart')) {
        new Chart(document.getElementById('stockCategoryChart'), {
            type: 'bar',
            data: {
                labels: categories.map(r => r.label),
                datasets: [{
                    label: 'Unidades en stock',
                    data: categories.map(r => r.totalStock),
                    backgroundColor: 'rgba(37, 99, 235, 0.7)'
                }]
            },
            options: chartDefaults
        });
    }

    if (topProducts.length && document.getElementById('topProductsChart')) {
        new Chart(document.getElementById('topProductsChart'), {
            type: 'bar',
            data: {
                labels: topProducts.map(r => r.label),
                datasets: [{
                    label: 'Unidades vendidas',
                    data: topProducts.map(r => r.unitsSold),
                    backgroundColor: 'rgba(16, 185, 129, 0.7)'
                }]
            },
            options: { ...chartDefaults, indexAxis: 'y' }
        });
    }

    if (movements.length && document.getElementById('movementsChart')) {
        new Chart(document.getElementById('movementsChart'), {
            type: 'bar',
            data: {
                labels: movements.map(r => r.label),
                datasets: [
                    {
                        label: 'Cantidad de movimientos',
                        data: movements.map(r => r.movementCount),
                        backgroundColor: 'rgba(99, 102, 241, 0.7)'
                    },
                    {
                        label: 'Unidades movidas',
                        data: movements.map(r => r.totalQuantity),
                        backgroundColor: 'rgba(245, 158, 11, 0.7)'
                    }
                ]
            },
            options: chartDefaults
        });
    }
});
</script>
@endpush

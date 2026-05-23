@extends('layouts.app')
@section('title', 'Stock bajo')

@section('header')
<div class="flex items-center gap-3 w-full">
    <a href="{{ route('reports.index') }}" class="text-slate-400 hover:text-slate-600 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-lg font-semibold text-slate-800">Stock bajo</h1>
        <p class="text-xs text-slate-400">Productos con stock ≤ {{ $threshold }} unidades</p>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">

    <form method="get" class="flex flex-wrap items-end gap-3 bg-white border border-gray-200 rounded-xl px-5 py-4 shadow-sm max-w-sm">
        <div>
            <label for="threshold" class="block text-xs font-medium text-slate-600 mb-1">Umbral de alerta</label>
            <input type="number" name="threshold" id="threshold" min="1" value="{{ $threshold }}"
                   class="w-24 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <button type="submit"
                class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            Aplicar
        </button>
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h2 class="text-sm font-semibold text-slate-800 mb-4">Productos en alerta</h2>
            <canvas id="lowStockChart" height="200"></canvas>
        </div>
        @if($stockByCategory->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h2 class="text-sm font-semibold text-slate-800 mb-4">Stock total por categoría</h2>
            <canvas id="categoryStockChart" height="200"></canvas>
        </div>
        @endif
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">SKU</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Producto</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Stock</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-mono text-xs text-slate-600">{{ $p->sku }}</td>
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $p->name }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $p->category?->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="font-bold {{ $p->currentStock === 0 ? 'text-red-600' : 'text-amber-600' }}">{{ $p->currentStock }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('inventory.movements.create') }}?productId={{ $p->id }}"
                               class="text-indigo-600 hover:text-indigo-800 text-xs font-medium transition">Registrar entrada</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-10 text-center text-slate-400 text-sm">No hay productos bajo el umbral indicado.</td></tr>
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
    const products = @json($products);
    const categories = @json($stockByCategory);

    if (products.length) {
        new Chart(document.getElementById('lowStockChart'), {
            type: 'bar',
            data: {
                labels: products.map(p => p.name),
                datasets: [{
                    label: 'Stock actual',
                    data: products.map(p => p.currentStock),
                    backgroundColor: products.map(p => p.currentStock === 0 ? 'rgba(239, 68, 68, 0.8)' : 'rgba(245, 158, 11, 0.8)')
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, grid: { color: '#f3f4f6' } } }
            }
        });
    }

    if (categories.length && document.getElementById('categoryStockChart')) {
        new Chart(document.getElementById('categoryStockChart'), {
            type: 'doughnut',
            data: {
                labels: categories.map(c => c.label),
                datasets: [{ data: categories.map(c => c.totalStock), backgroundColor: ['#3b82f6','#10b981','#f59e0b','#8b5cf6','#ef4444'] }]
            },
            options: { responsive: true }
        });
    }
});
</script>
@endpush

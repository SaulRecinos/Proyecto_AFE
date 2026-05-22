@extends('layouts.app')
@section('title', 'Stock bajo')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Stock bajo</h1>
            <p class="text-sm text-slate-500 mt-1">Productos con stock ≤ {{ $threshold }} unidades</p>
        </div>
        <a href="{{ route('reports.index') }}" class="text-sm text-blue-600 hover:underline">← Panel de reportes</a>
    </div>

    <form method="get" class="flex flex-wrap items-end gap-3 bg-white border border-gray-200 rounded-xl p-4 shadow-sm max-w-md">
        <div>
            <label for="threshold" class="block text-xs font-medium text-gray-600 mb-1">Umbral de alerta</label>
            <input type="number" name="threshold" id="threshold" min="1" value="{{ $threshold }}"
                class="w-24 rounded-md border border-gray-300 px-3 py-2 text-sm">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Aplicar</button>
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h2 class="text-sm font-semibold text-gray-800 mb-4">Productos en alerta</h2>
            <canvas id="lowStockChart" height="200"></canvas>
        </div>
        @if($stockByCategory->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <h2 class="text-sm font-semibold text-gray-800 mb-4">Stock total por categoría</h2>
            <canvas id="categoryStockChart" height="200"></canvas>
        </div>
        @endif
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">SKU</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Producto</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Categoría</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Stock</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono text-xs">{{ $p->sku }}</td>
                    <td class="px-4 py-3 font-medium">{{ $p->name }}</td>
                    <td class="px-4 py-3">{{ $p->category?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="font-bold {{ $p->currentStock === 0 ? 'text-red-700' : 'text-amber-600' }}">{{ $p->currentStock }}</span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('inventory.movements.create') }}?productId={{ $p->id }}" class="text-blue-600 text-xs hover:underline">Registrar entrada</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No hay productos bajo el umbral indicado.</td></tr>
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

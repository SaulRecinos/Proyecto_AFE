@extends('layouts.app')
@section('title', 'Productos')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between"><h1 class="text-2xl font-bold">Productos / Artículos</h1>
        <a href="{{ route('inventory.products.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg">Nuevo producto</a></div>
    <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr>
            <th class="px-4 py-3 text-left">SKU</th><th class="px-4 py-3 text-left">Nombre</th>
            <th class="px-4 py-3">Categoría</th><th class="px-4 py-3">Stock</th>
            <th class="px-4 py-3 text-right">Precio venta</th><th class="px-4 py-3 text-right">Acciones</th>
        </tr></thead><tbody class="divide-y">
        @forelse($products as $p)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 font-mono text-xs">{{ $p->sku }}</td>
            <td class="px-4 py-3 font-medium">{{ $p->name }}</td>
            <td class="px-4 py-3">{{ $p->category?->name }}</td>
            <td class="px-4 py-3 text-center {{ $p->currentStock <= 10 ? 'text-red-600 font-semibold' : '' }}">{{ $p->currentStock }}</td>
            <td class="px-4 py-3 text-right">{{ format_usd($p->salePrice) }}</td>
            <td class="px-4 py-3 text-right space-x-2">
                <a href="{{ route('inventory.products.edit',$p) }}" class="text-blue-600">Editar</a>
                <form action="{{ route('inventory.products.destroy',$p) }}" method="post" class="inline" onsubmit="return confirm('¿Eliminar?')">@csrf @method('DELETE')<button class="text-red-600">Eliminar</button></form>
            </td>
        </tr>
        @empty<tr><td colspan="6" class="p-8 text-center text-gray-500">Sin productos</td></tr>@endforelse
        </tbody></table>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Categorías')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center"><h1 class="text-2xl font-bold">Categorías</h1>
        <a href="{{ route('inventory.categories.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Nueva categoría</a></div>
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr>
            <th class="px-4 py-3 text-left">Nombre</th><th class="px-4 py-3">Estado</th><th class="px-4 py-3 text-right">Acciones</th>
        </tr></thead><tbody class="divide-y">
        @forelse($categories as $c)
        <tr><td class="px-4 py-3 font-medium">{{ $c->name }}</td>
            <td class="px-4 py-3 text-center">{{ $c->isActive ? 'Activo' : 'Inactivo' }}</td>
            <td class="px-4 py-3 text-right space-x-2">
                <a href="{{ route('inventory.categories.edit',$c) }}" class="text-blue-600">Editar</a>
                <form action="{{ route('inventory.categories.destroy',$c) }}" method="post" class="inline" onsubmit="return confirm('¿Eliminar?')">@csrf @method('DELETE')<button class="text-red-600">Eliminar</button></form>
            </td></tr>
        @empty<tr><td colspan="3" class="p-8 text-center text-gray-500">Sin categorías</td></tr>@endforelse
        </tbody></table>
    </div>
</div>
@endsection

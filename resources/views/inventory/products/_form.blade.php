@php $isEdit = $product !== null; @endphp

<form action="{{ $action }}" method="post" class="space-y-5">
    @csrf @method($method)

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label for="categoryId" class="block text-sm font-medium text-slate-700 mb-1.5">Categoría</label>
            <select name="categoryId" id="categoryId" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">— Seleccione —</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('categoryId', $product->categoryId ?? '') == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="supplierId" class="block text-sm font-medium text-slate-700 mb-1.5">Proveedor</label>
            <select name="supplierId" id="supplierId" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">— Seleccione —</option>
                @foreach($suppliers as $s)
                    <option value="{{ $s->id }}" @selected(old('supplierId', $product->supplierId ?? '') == $s->id)>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="sku" class="block text-sm font-medium text-slate-700 mb-1.5">SKU</label>
            <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku ?? '') }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
    </div>

    <div class="grid sm:grid-cols-3 gap-5">
        <div>
            <label for="purchasePrice" class="block text-sm font-medium text-slate-700 mb-1.5">Precio compra (USD)</label>
            <input type="number" step="0.01" min="0" name="purchasePrice" id="purchasePrice"
                   value="{{ old('purchasePrice', $product->purchasePrice ?? '0') }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
        <div>
            <label for="salePrice" class="block text-sm font-medium text-slate-700 mb-1.5">Precio venta (USD)</label>
            <input type="number" step="0.01" min="0" name="salePrice" id="salePrice"
                   value="{{ old('salePrice', $product->salePrice ?? '0') }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
        @if(!$isEdit)
        <div>
            <label for="currentStock" class="block text-sm font-medium text-slate-700 mb-1.5">Stock inicial</label>
            <input type="number" min="0" name="currentStock" id="currentStock" value="{{ old('currentStock', '0') }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
        @endif
    </div>

    @if($isEdit)
    <p class="text-xs text-slate-500 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2">
        El stock se modifica únicamente mediante movimientos de inventario.
    </p>
    @endif

    <div>
        <label for="isActive" class="block text-sm font-medium text-slate-700 mb-1.5">Estado</label>
        <select name="isActive" id="isActive"
                class="w-full max-w-xs rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <option value="1" @selected(old('isActive', $isEdit ? ($product->isActive ? '1' : '0') : '1') === '1')>Activo</option>
            <option value="0" @selected(old('isActive', $isEdit ? ($product->isActive ? '1' : '0') : '1') === '0')>Inactivo</option>
        </select>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
            {{ $isEdit ? 'Guardar cambios' : 'Crear producto' }}
        </button>
        <a href="{{ route('inventory.products.index') }}"
           class="inline-flex items-center px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
            Cancelar
        </a>
    </div>
</form>

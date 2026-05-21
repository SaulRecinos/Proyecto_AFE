@php $isEdit = $product !== null; @endphp
<form action="{{ $action }}" method="post" class="space-y-6 bg-white border rounded-xl p-6 max-w-2xl shadow-sm">
    @csrf @method($method)
    <div class="grid sm:grid-cols-2 gap-4">
        <div><label class="block text-sm font-medium mb-1">Categoría</label>
            <select name="categoryId" required class="w-full border rounded-md px-3 py-2 text-sm">
                @foreach($categories as $c)<option value="{{ $c->id }}" @selected(old('categoryId',$product->categoryId??'')==$c->id)>{{ $c->name }}</option>@endforeach
            </select></div>
        <div><label class="block text-sm font-medium mb-1">Proveedor</label>
            <select name="supplierId" required class="w-full border rounded-md px-3 py-2 text-sm">
                @foreach($suppliers as $s)<option value="{{ $s->id }}" @selected(old('supplierId',$product->supplierId??'')==$s->id)>{{ $s->name }}</option>@endforeach
            </select></div>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div><label class="block text-sm font-medium mb-1">SKU</label>
            <input name="sku" value="{{ old('sku',$product->sku??'') }}" required class="w-full border rounded-md px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Nombre</label>
            <input name="name" value="{{ old('name',$product->name??'') }}" required class="w-full border rounded-md px-3 py-2 text-sm"></div>
    </div>
    <div class="grid sm:grid-cols-3 gap-4">
        <div><label class="block text-sm font-medium mb-1">Precio compra (USD)</label>
            <input type="number" step="0.01" min="0" name="purchasePrice" value="{{ old('purchasePrice',$product->purchasePrice??'0') }}" required class="w-full border rounded-md px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Precio venta (USD)</label>
            <input type="number" step="0.01" min="0" name="salePrice" value="{{ old('salePrice',$product->salePrice??'0') }}" required class="w-full border rounded-md px-3 py-2 text-sm"></div>
        @if(!$isEdit)<div><label class="block text-sm font-medium mb-1">Stock inicial</label>
            <input type="number" min="0" name="currentStock" value="{{ old('currentStock','0') }}" required class="w-full border rounded-md px-3 py-2 text-sm"></div>@endif
    </div>
    @if($isEdit)<p class="text-xs text-gray-500">El stock se modifica mediante movimientos de inventario.</p>@endif
    <div><label class="block text-sm font-medium mb-1">Estado</label>
        <select name="isActive" class="w-full max-w-xs border rounded-md px-3 py-2 text-sm">
            <option value="1" @selected(old('isActive',$isEdit?($product->isActive?'1':'0'):'1')==='1')>Activo</option>
            <option value="0" @selected(old('isActive',$isEdit?($product->isActive?'1':'0'):'1')==='0')>Inactivo</option>
        </select></div>
    <div class="flex gap-3">
        <button class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg">{{ $isEdit?'Guardar':'Crear' }}</button>
        <a href="{{ route('inventory.products.index') }}" class="px-4 py-2 border text-sm rounded-lg">Cancelar</a>
    </div>
</form>

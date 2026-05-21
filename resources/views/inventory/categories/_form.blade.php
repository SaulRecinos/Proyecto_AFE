@php $isEdit = $category !== null; @endphp
<form action="{{ $action }}" method="post" class="space-y-6 bg-white border rounded-xl p-6 max-w-lg shadow-sm">
    @csrf @method($method)
    <div><label class="block text-sm font-medium mb-1">Nombre</label>
        <input name="name" value="{{ old('name',$category->name??'') }}" required class="w-full border rounded-md px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Estado</label>
        <select name="isActive" class="w-full border rounded-md px-3 py-2 text-sm">
            <option value="1" @selected(old('isActive',$isEdit?($category->isActive?'1':'0'):'1')==='1')>Activo</option>
            <option value="0" @selected(old('isActive',$isEdit?($category->isActive?'1':'0'):'1')==='0')>Inactivo</option>
        </select></div>
    <div class="flex gap-3">
        <button class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg">{{ $isEdit?'Guardar':'Crear' }}</button>
        <a href="{{ route('inventory.categories.index') }}" class="px-4 py-2 border text-sm rounded-lg">Cancelar</a>
    </div>
</form>

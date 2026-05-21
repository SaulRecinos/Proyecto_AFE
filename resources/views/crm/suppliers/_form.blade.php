@php $isEdit = $supplier !== null; @endphp
<form action="{{ $action }}" method="post" class="space-y-6 bg-white border border-gray-200 rounded-xl p-6 shadow-sm max-w-2xl">
    @csrf @method($method)
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
        <input type="text" name="name" value="{{ old('name', $supplier->name ?? '') }}" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium text-gray-700 mb-1">NIT</label>
        <input type="text" name="taxId" value="{{ old('taxId', $supplier->taxId ?? '') }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Persona de contacto</label>
        <input type="text" name="contactName" value="{{ old('contactName', $supplier->contactName ?? '') }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
        <input type="text" name="phoneNumber" value="{{ old('phoneNumber', $supplier->phoneNumber ?? '') }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
        <textarea name="address" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">{{ old('address', $supplier->address ?? '') }}</textarea></div>
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
        <select name="isActive" class="w-full max-w-xs rounded-md border border-gray-300 px-3 py-2 text-sm">
            <option value="1" @selected(old('isActive', $isEdit ? ($supplier->isActive ? '1' : '0') : '1') === '1')>Activo</option>
            <option value="0" @selected(old('isActive', $isEdit ? ($supplier->isActive ? '1' : '0') : '1') === '0')>Inactivo</option>
        </select></div>
    <div class="flex gap-3">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">{{ $isEdit ? 'Guardar' : 'Crear' }}</button>
        <a href="{{ route('crm.suppliers.index') }}" class="px-4 py-2 border border-gray-300 text-sm rounded-lg hover:bg-gray-50">Cancelar</a>
    </div>
</form>

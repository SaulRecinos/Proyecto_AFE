@php $isEdit = $customer !== null; @endphp
<form action="{{ $action }}" method="post" class="space-y-6 bg-white border border-gray-200 rounded-xl p-6 shadow-sm max-w-2xl">
    @csrf
    @method($method)
    <div>
        <label for="customerTypeId" class="block text-sm font-medium text-gray-700 mb-1">Tipo de cliente</label>
        <select name="customerTypeId" id="customerTypeId" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
            <option value="">— Seleccione —</option>
            @foreach ($customerTypes as $type)
                <option value="{{ $type->id }}" @selected(old('customerTypeId', $customer->customerTypeId ?? '') == $type->id)>{{ $type->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
        <input type="text" name="fullName" id="fullName" value="{{ old('fullName', $customer->fullName ?? '') }}" required maxlength="255" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
    </div>
    <div>
        <label for="taxId" class="block text-sm font-medium text-gray-700 mb-1">NIT / DPI</label>
        <input type="text" name="taxId" id="taxId" value="{{ old('taxId', $customer->taxId ?? '') }}" maxlength="50" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
    </div>
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
        <input type="email" name="email" id="email" value="{{ old('email', $customer->email ?? '') }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
    </div>
    <div>
        <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
        <input type="text" name="phoneNumber" id="phoneNumber" value="{{ old('phoneNumber', $customer->phoneNumber ?? '') }}" maxlength="20" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
    </div>
    <div>
        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
        <textarea name="address" id="address" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">{{ old('address', $customer->address ?? '') }}</textarea>
    </div>
    <div>
        <label for="isActive" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
        <select name="isActive" id="isActive" class="w-full max-w-xs rounded-md border border-gray-300 px-3 py-2 text-sm">
            <option value="1" @selected(old('isActive', $isEdit ? ($customer->isActive ? '1' : '0') : '1') === '1')>Activo</option>
            <option value="0" @selected(old('isActive', $isEdit ? ($customer->isActive ? '1' : '0') : '1') === '0')>Inactivo</option>
        </select>
    </div>
    <div class="flex gap-3">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">{{ $isEdit ? 'Guardar' : 'Crear' }}</button>
        <a href="{{ route('crm.customers.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-50">Cancelar</a>
    </div>
</form>

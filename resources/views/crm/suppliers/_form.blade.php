@php $isEdit = $supplier !== null; @endphp

<form action="{{ $action }}" method="post" class="space-y-5">
    @csrf
    @method($method)

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name', $supplier->name ?? '') }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
        <div>
            <label for="taxId" class="block text-sm font-medium text-slate-700 mb-1.5">NIT</label>
            <input type="text" name="taxId" id="taxId" value="{{ old('taxId', $supplier->taxId ?? '') }}"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
        <div>
            <label for="contactName" class="block text-sm font-medium text-slate-700 mb-1.5">Persona de contacto</label>
            <input type="text" name="contactName" id="contactName" value="{{ old('contactName', $supplier->contactName ?? '') }}"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
        <div>
            <label for="phoneNumber" class="block text-sm font-medium text-slate-700 mb-1.5">Teléfono</label>
            <input type="text" name="phoneNumber" id="phoneNumber" value="{{ old('phoneNumber', $supplier->phoneNumber ?? '') }}"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
    </div>

    <div>
        <label for="address" class="block text-sm font-medium text-slate-700 mb-1.5">Dirección</label>
        <textarea name="address" id="address" rows="2"
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('address', $supplier->address ?? '') }}</textarea>
    </div>

    <div>
        <label for="isActive" class="block text-sm font-medium text-slate-700 mb-1.5">Estado</label>
        <select name="isActive" id="isActive"
                class="w-full max-w-xs rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <option value="1" @selected(old('isActive', $isEdit ? ($supplier->isActive ? '1' : '0') : '1') === '1')>Activo</option>
            <option value="0" @selected(old('isActive', $isEdit ? ($supplier->isActive ? '1' : '0') : '1') === '0')>Inactivo</option>
        </select>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
            {{ $isEdit ? 'Guardar cambios' : 'Crear proveedor' }}
        </button>
        <a href="{{ route('crm.suppliers.index') }}"
           class="inline-flex items-center px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
            Cancelar
        </a>
    </div>
</form>

@php $isEdit = $customer !== null; @endphp

<form action="{{ $action }}" method="post" class="space-y-5">
    @csrf
    @method($method)

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label for="customerTypeId" class="block text-sm font-medium text-slate-700 mb-1.5">Tipo de cliente</label>
            <select name="customerTypeId" id="customerTypeId" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">— Seleccione —</option>
                @foreach($customerTypes as $type)
                    <option value="{{ $type->id }}" @selected(old('customerTypeId', $customer->customerTypeId ?? '') == $type->id)>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="isActive" class="block text-sm font-medium text-slate-700 mb-1.5">Estado</label>
            <select name="isActive" id="isActive"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="1" @selected(old('isActive', $isEdit ? ($customer->isActive ? '1' : '0') : '1') === '1')>Activo</option>
                <option value="0" @selected(old('isActive', $isEdit ? ($customer->isActive ? '1' : '0') : '1') === '0')>Inactivo</option>
            </select>
        </div>
    </div>

    <div>
        <label for="fullName" class="block text-sm font-medium text-slate-700 mb-1.5">Nombre completo</label>
        <input type="text" name="fullName" id="fullName" value="{{ old('fullName', $customer->fullName ?? '') }}" required maxlength="255"
               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label for="taxId" class="block text-sm font-medium text-slate-700 mb-1.5">NIT / DPI</label>
            <input type="text" name="taxId" id="taxId" value="{{ old('taxId', $customer->taxId ?? '') }}" maxlength="50"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
        <div>
            <label for="phoneNumber" class="block text-sm font-medium text-slate-700 mb-1.5">Teléfono</label>
            <input type="text" name="phoneNumber" id="phoneNumber" value="{{ old('phoneNumber', $customer->phoneNumber ?? '') }}" maxlength="20"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Correo electrónico</label>
        <input type="email" name="email" id="email" value="{{ old('email', $customer->email ?? '') }}"
               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
    </div>

    <div>
        <label for="address" class="block text-sm font-medium text-slate-700 mb-1.5">Dirección</label>
        <textarea name="address" id="address" rows="2"
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('address', $customer->address ?? '') }}</textarea>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
            {{ $isEdit ? 'Guardar cambios' : 'Crear cliente' }}
        </button>
        <a href="{{ route('crm.customers.index') }}"
           class="inline-flex items-center px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
            Cancelar
        </a>
    </div>
</form>

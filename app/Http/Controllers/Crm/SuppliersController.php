<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Concerns\ErpControllerHelpers;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuppliersController extends Controller
{
    use ErpControllerHelpers;

    public function index(): View
    {
        $suppliers = Supplier::query()->orderBy('name')->get();

        return view('crm.suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        return view('crm.suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'taxId' => ['nullable', 'string', 'max:50', 'unique:suppliers,taxId'],
            'contactName' => ['nullable', 'string', 'max:255'],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $supplier = Supplier::create($this->withAuditOnCreate([
            'name' => $validated['name'],
            'taxId' => $validated['taxId'] ?: null,
            'contactName' => $validated['contactName'] ?: null,
            'phoneNumber' => $validated['phoneNumber'] ?: null,
            'address' => $validated['address'] ?: null,
            'isActive' => (bool) (int) $validated['isActive'],
        ]));

        AuditService::logInsert($supplier, 'suppliers');

        return redirect()->route('crm.suppliers.index')->with('success', 'Proveedor creado correctamente.');
    }

    public function edit(Supplier $supplier): View
    {
        return view('crm.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'taxId' => ['nullable', 'string', 'max:50', 'unique:suppliers,taxId,'.$supplier->id],
            'contactName' => ['nullable', 'string', 'max:255'],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $old = $supplier->toArray();
        $supplier->update($this->withAuditOnUpdate([
            'name' => $validated['name'],
            'taxId' => $validated['taxId'] ?: null,
            'contactName' => $validated['contactName'] ?: null,
            'phoneNumber' => $validated['phoneNumber'] ?: null,
            'address' => $validated['address'] ?: null,
            'isActive' => (bool) (int) $validated['isActive'],
        ]));

        AuditService::logUpdate($supplier, 'suppliers', $old);

        return redirect()->route('crm.suppliers.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        if ($supplier->products()->exists()) {
            return redirect()->route('crm.suppliers.index')
                ->with('error', 'No se puede eliminar: el proveedor tiene productos asociados.');
        }

        AuditService::logDelete($supplier, 'suppliers');
        $supplier->delete();

        return redirect()->route('crm.suppliers.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}

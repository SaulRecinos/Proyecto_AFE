<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Concerns\ErpControllerHelpers;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerTypes;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomersController extends Controller
{
    use ErpControllerHelpers;

    public function index(): View
    {
        $customers = Customer::query()
            ->with('customerType')
            ->orderBy('fullName')
            ->get();

        return view('crm.customers.index', compact('customers'));
    }

    public function create(): View
    {
        $customerTypes = CustomerTypes::query()->where('isActive', true)->orderBy('name')->get();

        return view('crm.customers.create', compact('customerTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customerTypeId' => ['required', 'integer', 'exists:customerTypes,id'],
            'fullName' => ['required', 'string', 'max:255'],
            'taxId' => ['nullable', 'string', 'max:50', 'unique:customers,taxId'],
            'email' => ['nullable', 'email', 'max:255'],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $customer = Customer::create($this->withAuditOnCreate([
            'customerTypeId' => $validated['customerTypeId'],
            'fullName' => $validated['fullName'],
            'taxId' => $validated['taxId'] ?: null,
            'email' => $validated['email'] ?: null,
            'phoneNumber' => $validated['phoneNumber'] ?: null,
            'address' => $validated['address'] ?: null,
            'isActive' => (bool) (int) $validated['isActive'],
        ]));

        AuditService::logInsert($customer, 'customers');

        return redirect()->route('crm.customers.index')->with('success', 'Cliente creado correctamente.');
    }

    public function edit(Customer $customer): View
    {
        $customerTypes = CustomerTypes::query()->orderBy('name')->get();

        return view('crm.customers.edit', compact('customer', 'customerTypes'));
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'customerTypeId' => ['required', 'integer', 'exists:customerTypes,id'],
            'fullName' => ['required', 'string', 'max:255'],
            'taxId' => ['nullable', 'string', 'max:50', 'unique:customers,taxId,'.$customer->id],
            'email' => ['nullable', 'email', 'max:255'],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $old = $customer->toArray();
        $customer->update($this->withAuditOnUpdate([
            'customerTypeId' => $validated['customerTypeId'],
            'fullName' => $validated['fullName'],
            'taxId' => $validated['taxId'] ?: null,
            'email' => $validated['email'] ?: null,
            'phoneNumber' => $validated['phoneNumber'] ?: null,
            'address' => $validated['address'] ?: null,
            'isActive' => (bool) (int) $validated['isActive'],
        ]));

        AuditService::logUpdate($customer, 'customers', $old);

        return redirect()->route('crm.customers.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        if ($customer->invoices()->exists()) {
            return redirect()->route('crm.customers.index')
                ->with('error', 'No se puede eliminar: el cliente tiene facturas asociadas.');
        }

        AuditService::logDelete($customer, 'customers');
        $customer->delete();

        return redirect()->route('crm.customers.index')->with('success', 'Cliente eliminado correctamente.');
    }
}

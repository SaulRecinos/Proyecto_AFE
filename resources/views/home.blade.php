@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Bienvenido, {{ auth()->user()->name }}</h1>
        <p class="mt-2 text-slate-600 text-sm max-w-2xl">
            Panel ERP Lite. Seleccione un módulo en el menú superior o use los accesos rápidos.
        </p>
    </div>

    @if(auth()->user()->hasPermission('ADMIN_MOD'))
    <div>
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500 mb-3">Administración</h2>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('admin.roles.index') }}" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md">
                <span class="font-semibold text-gray-800 group-hover:text-blue-700">Roles</span>
                <p class="mt-1 text-sm text-slate-500">Roles y módulos del sistema.</p>
            </a>
            <a href="{{ route('admin.users.index') }}" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md">
                <span class="font-semibold text-gray-800 group-hover:text-blue-700">Usuarios</span>
                <p class="mt-1 text-sm text-slate-500">Gestión de usuarios.</p>
            </a>
        </div>
    </div>
    @endif

    @if(auth()->user()->hasPermission('CRM_MOD'))
    <div>
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500 mb-3">CRM</h2>
        <div class="grid gap-4 sm:grid-cols-2">
            <a href="{{ route('crm.customers.index') }}" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md">
                <span class="font-semibold text-gray-800 group-hover:text-blue-700">Clientes</span>
                <p class="mt-1 text-sm text-slate-500">Alta y mantenimiento de clientes.</p>
            </a>
            <a href="{{ route('crm.suppliers.index') }}" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md">
                <span class="font-semibold text-gray-800 group-hover:text-blue-700">Proveedores</span>
                <p class="mt-1 text-sm text-slate-500">Proveedores y contactos.</p>
            </a>
        </div>
    </div>
    @endif

    @if(auth()->user()->hasPermission('INV_MOD') || auth()->user()->hasPermission('BILL_MOD') || auth()->user()->hasPermission('REP_MOD'))
    <div>
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500 mb-3">Inventario y facturación</h2>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @if(auth()->user()->hasPermission('INV_MOD'))
            <a href="{{ route('inventory.products.index') }}" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md">
                <span class="font-semibold text-gray-800 group-hover:text-blue-700">Productos</span>
                <p class="mt-1 text-sm text-slate-500">Artículos y stock.</p>
            </a>
            <a href="{{ route('inventory.movements.index') }}" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md">
                <span class="font-semibold text-gray-800 group-hover:text-blue-700">Movimientos</span>
                <p class="mt-1 text-sm text-slate-500">Entradas, salidas y ajustes.</p>
            </a>
            @endif
            @if(auth()->user()->hasPermission('BILL_MOD'))
            <a href="{{ route('billing.invoices.index') }}" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md">
                <span class="font-semibold text-gray-800 group-hover:text-blue-700">Facturas</span>
                <p class="mt-1 text-sm text-slate-500">Emisión de facturas.</p>
            </a>
            @endif
            @if(auth()->user()->hasPermission('REP_MOD'))
            <a href="{{ route('reports.index') }}" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md">
                <span class="font-semibold text-gray-800 group-hover:text-blue-700">Reportes</span>
                <p class="mt-1 text-sm text-slate-500">Ventas, stock y pendientes.</p>
            </a>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

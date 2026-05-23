@extends('layouts.app')
@section('title', 'Dashboard')

@section('header')
<div class="flex items-center justify-between w-full">
    <div>
        <h1 class="text-lg font-semibold text-slate-800">Dashboard</h1>
        <p class="text-xs text-slate-400 mt-0.5">Bienvenido, {{ auth()->user()->name }}</p>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">

    @if(auth()->user()->hasPermission('ADMIN_MOD'))
    <div>
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Administración</p>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('admin.users.index') }}" class="group bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:border-indigo-300 hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 bg-indigo-50 rounded-lg flex items-center justify-center group-hover:bg-indigo-100 transition">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-800 group-hover:text-indigo-700 transition">Usuarios</span>
                </div>
                <p class="text-sm text-slate-500">Gestión de cuentas de usuario</p>
            </a>
            <a href="{{ route('admin.roles.index') }}" class="group bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:border-indigo-300 hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 bg-indigo-50 rounded-lg flex items-center justify-center group-hover:bg-indigo-100 transition">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-800 group-hover:text-indigo-700 transition">Roles</span>
                </div>
                <p class="text-sm text-slate-500">Roles y permisos de módulo</p>
            </a>
        </div>
    </div>
    @endif

    @if(auth()->user()->hasPermission('CRM_MOD'))
    <div>
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">CRM</p>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('crm.customers.index') }}" class="group bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:border-indigo-300 hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 bg-sky-50 rounded-lg flex items-center justify-center group-hover:bg-sky-100 transition">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-800 group-hover:text-sky-700 transition">Clientes</span>
                </div>
                <p class="text-sm text-slate-500">Alta y mantenimiento de clientes</p>
            </a>
            <a href="{{ route('crm.suppliers.index') }}" class="group bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:border-indigo-300 hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 bg-sky-50 rounded-lg flex items-center justify-center group-hover:bg-sky-100 transition">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-800 group-hover:text-sky-700 transition">Proveedores</span>
                </div>
                <p class="text-sm text-slate-500">Proveedores y contactos</p>
            </a>
        </div>
    </div>
    @endif

    @if(auth()->user()->hasPermission('INV_MOD') || auth()->user()->hasPermission('BILL_MOD') || auth()->user()->hasPermission('REP_MOD'))
    <div>
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Operaciones</p>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @if(auth()->user()->hasPermission('INV_MOD'))
            <a href="{{ route('inventory.products.index') }}" class="group bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:border-indigo-300 hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 bg-emerald-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-800 group-hover:text-emerald-700 transition">Productos</span>
                </div>
                <p class="text-sm text-slate-500">Artículos y stock</p>
            </a>
            <a href="{{ route('inventory.movements.index') }}" class="group bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:border-indigo-300 hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 bg-emerald-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-800 group-hover:text-emerald-700 transition">Movimientos</span>
                </div>
                <p class="text-sm text-slate-500">Entradas, salidas y ajustes</p>
            </a>
            @endif
            @if(auth()->user()->hasPermission('BILL_MOD'))
            <a href="{{ route('billing.invoices.index') }}" class="group bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:border-indigo-300 hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 bg-amber-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-800 group-hover:text-amber-700 transition">Facturas</span>
                </div>
                <p class="text-sm text-slate-500">Emisión de facturas</p>
            </a>
            @endif
            @if(auth()->user()->hasPermission('REP_MOD'))
            <a href="{{ route('reports.index') }}" class="group bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:border-indigo-300 hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 bg-violet-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-800 group-hover:text-violet-700 transition">Reportes</span>
                </div>
                <p class="text-sm text-slate-500">Ventas, stock y pendientes</p>
            </a>
            @endif
        </div>
    </div>
    @endif

</div>
@endsection

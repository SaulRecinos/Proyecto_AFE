@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Bienvenido, {{ auth()->user()->name }}</h1>
        <p class="mt-2 text-slate-600 text-sm max-w-2xl">
            Seleccione un módulo en el menú superior o acceda al mantenimiento desde los accesos siguientes.
        </p>
    </div>

    <div>
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500 mb-3">Administración</h2>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('admin.roles.index') }}"
                class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md">
                <span class="font-semibold text-gray-800 group-hover:text-blue-700">Roles</span>
                <p class="mt-1 text-sm text-slate-500">Definición de roles y permisos asignados.</p>
            </a>
            <a href="{{ route('admin.permissions.index') }}"
                class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md">
                <span class="font-semibold text-gray-800 group-hover:text-blue-700">Permisos</span>
                <p class="mt-1 text-sm text-slate-500">Catálogo de permisos del sistema.</p>
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md sm:col-span-2 lg:col-span-1">
                <span class="font-semibold text-gray-800 group-hover:text-blue-700">Usuarios</span>
                <p class="mt-1 text-sm text-slate-500">Alta, edición y asignación de roles.</p>
            </a>
        </div>
    </div>
</div>
@endsection

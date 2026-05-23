@extends('layouts.app')
@section('title', 'Nuevo rol')

@section('header')
<div class="flex items-center gap-3 w-full">
    <a href="{{ route('admin.roles.index') }}" class="text-slate-400 hover:text-slate-600 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <h1 class="text-lg font-semibold text-slate-800">Nuevo rol</h1>
</div>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-base font-semibold text-slate-800">Datos del rol</h2>
        </div>
        <div class="px-6 py-5">
            @include('admin.roles._form', [
                'action' => route('admin.roles.store'),
                'method' => 'POST',
                'role' => null,
                'permissions' => $permissions,
                'selectedPermissionIds' => [],
            ])
        </div>
    </div>
</div>
@endsection

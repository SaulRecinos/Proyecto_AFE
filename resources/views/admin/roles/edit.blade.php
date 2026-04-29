@extends('layouts.app')

@section('title', 'Editar rol')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar rol</h1>
    @include('admin.roles._form', [
        'action' => route('admin.roles.update', $role),
        'method' => 'PUT',
        'role' => $role,
        'permissions' => $permissions,
        'selectedPermissionIds' => $selectedPermissionIds,
    ])
</div>
@endsection

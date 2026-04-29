@extends('layouts.app')

@section('title', 'Nuevo rol')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nuevo rol</h1>
    @include('admin.roles._form', [
        'action' => route('admin.roles.store'),
        'method' => 'POST',
        'role' => null,
        'permissions' => $permissions,
        'selectedPermissionIds' => [],
    ])
</div>
@endsection

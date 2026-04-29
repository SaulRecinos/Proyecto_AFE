@extends('layouts.app')

@section('title', 'Editar permiso')

@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar permiso</h1>
    @include('admin.permissions._form', [
        'action' => route('admin.permissions.update', $permission),
        'method' => 'PUT',
        'permission' => $permission,
    ])
</div>
@endsection

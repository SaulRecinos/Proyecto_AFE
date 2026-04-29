@extends('layouts.app')

@section('title', 'Nuevo permiso')

@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nuevo permiso</h1>
    @include('admin.permissions._form', [
        'action' => route('admin.permissions.store'),
        'method' => 'POST',
        'permission' => null,
    ])
</div>
@endsection

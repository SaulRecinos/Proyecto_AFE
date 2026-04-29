@extends('layouts.app')

@section('title', 'Nuevo usuario')

@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nuevo usuario</h1>
    @include('admin.users._form', [
        'action' => route('admin.users.store'),
        'method' => 'POST',
        'user' => null,
        'roles' => $roles,
    ])
</div>
@endsection

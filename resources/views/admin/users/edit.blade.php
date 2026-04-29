@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar usuario</h1>
    @include('admin.users._form', [
        'action' => route('admin.users.update', $user),
        'method' => 'PUT',
        'user' => $user,
        'roles' => $roles,
    ])
</div>
@endsection

@extends('layouts.app')
@section('title', 'Nuevo proveedor')
@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Nuevo proveedor</h1>
    @include('crm.suppliers._form', ['action' => route('crm.suppliers.store'), 'method' => 'POST', 'supplier' => null])
</div>
@endsection

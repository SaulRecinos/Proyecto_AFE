@extends('layouts.app')
@section('title', 'Editar proveedor')
@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Editar proveedor</h1>
    @include('crm.suppliers._form', ['action' => route('crm.suppliers.update', $supplier), 'method' => 'PUT', 'supplier' => $supplier])
</div>
@endsection

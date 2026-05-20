@extends('layouts.app')
@section('title', 'Editar cliente')
@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Editar cliente</h1>
    @include('crm.customers._form', ['action' => route('crm.customers.update', $customer), 'method' => 'PUT', 'customer' => $customer])
</div>
@endsection

@extends('layouts.app')
@section('title', 'Nuevo cliente')
@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Nuevo cliente</h1>
    @include('crm.customers._form', ['action' => route('crm.customers.store'), 'method' => 'POST', 'customer' => null])
</div>
@endsection

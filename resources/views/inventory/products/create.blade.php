@extends('layouts.app')
@section('title', 'Nuevo producto')
@section('content')
<div class="space-y-6"><h1 class="text-2xl font-bold">Nuevo producto</h1>
@include('inventory.products._form',['action'=>route('inventory.products.store'),'method'=>'POST','product'=>null])</div>
@endsection

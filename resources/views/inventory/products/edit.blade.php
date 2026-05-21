@extends('layouts.app')
@section('title', 'Editar producto')
@section('content')
<div class="space-y-6"><h1 class="text-2xl font-bold">Editar producto</h1>
@include('inventory.products._form',['action'=>route('inventory.products.update',$product),'method'=>'PUT','product'=>$product])</div>
@endsection

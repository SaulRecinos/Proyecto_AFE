@extends('layouts.app')
@section('title', 'Editar categoría')
@section('content')
<div class="space-y-6"><h1 class="text-2xl font-bold">Editar categoría</h1>
@include('inventory.categories._form',['action'=>route('inventory.categories.update',$category),'method'=>'PUT','category'=>$category])</div>
@endsection

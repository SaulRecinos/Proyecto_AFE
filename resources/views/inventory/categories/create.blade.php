@extends('layouts.app')
@section('title', 'Nueva categoría')
@section('content')
<div class="space-y-6"><h1 class="text-2xl font-bold">Nueva categoría</h1>
@include('inventory.categories._form',['action'=>route('inventory.categories.store'),'method'=>'POST','category'=>null])</div>
@endsection

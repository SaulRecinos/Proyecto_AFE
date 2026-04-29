{{-- Definimos los props con valores por defecto --}}
@props([
    'href' => '#',
    'label' => 'Link',
    'color' => 'blue'
])

@php
    // Definimos los estilos según el prop 'color'
    $colors = [
        'blue'   => 'bg-blue-600 hover:bg-blue-700',
        'red'    => 'bg-red-600 hover:bg-red-700',
        'green'  => 'bg-green-600 hover:bg-green-700',
        'gray'   => 'bg-gray-600 hover:bg-gray-700',
    ];

    // Seleccionamos la clase o usamos la blue si el dato viene vacio
    $colorClass = $colors[$color] ?? $colors['blue'];
@endphp

{{-- Creamos nuestro estilo --}}
<a href="{{ $href }}" 
    class="{{$colorClass}} inline-flex items-center 
    justify-center px-5 py-2.5 text-white 
    font-nav font-semibold rounded-lg 
    shadow-sm transition-all 
    transition-transform hover:scale-105">
    {{ $slot->isEmpty() ? $label : $slot }}
</a>
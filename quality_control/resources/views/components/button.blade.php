{{-- Definimos los props con valores por defecto --}}
@props([
    'type' => 'button',
    'label' => 'Botón',
    'color' => 'blue',
    'onclick' => ''
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
    $colorClasses = $colors[$color] ?? $colors['blue'];
@endphp

{{-- Creamos el boton con nuestra personalizacion --}}
<button 
    type="{{ $type }}" 
    onclick="{{ $onclick }}"
    {{ $attributes->merge(
        [
            'class' => '$colorClasses inline-flex items-center 
            justify-center px-10 py-3 text-white font-nav 
            font-semibold rounded-lg shadow-sm 
            transition-all transition-transform 
            hover:scale-105'
        ])
    }}>
    {{ $slot->isEmpty() ? $label : $slot }}
</button>
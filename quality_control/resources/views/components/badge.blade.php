@props([
    'label' => 'status',
    'color' => 'green'
])

@php
    $colors = [
        'blue'   => 'bg-blue-100 text-blue-800',
        'red'    => 'bg-red-100 text-red-800',
        'green'  => 'bg-green-100 text-green-800',
        'gray'   => 'bg-gray-100 text-gray-800',
    ];

    $colorClass = $colors[$color] ?? $colors['green'];
@endphp

<span class='{{ $colorClass }} inline-flex items-center 
px-2 py-0.5 rounded-full text-xs 
font-medium'>
    {{ $slot->isEmpty() ? $label : $slot }}
</span>
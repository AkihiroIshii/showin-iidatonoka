@props([
    'type' => 'div',
    'color' => 'blue',
])

@php
    $colors = [
        'lime' => 'bg-lime-200',
        'orange' => 'bg-orange-200',
        'blue'  => 'bg-blue-200',
        'pink'  => 'bg-pink-200',
        'green' => 'bg-green-200',
        'red'   => 'bg-red-200',
        'yellow' => 'bg-yellow-200',
        'purple' => 'bg-purple-200',
    ];
@endphp

<div type="{{ $type }}" class="flex items-center text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis {{ $colors[$color] ?? $colors['blue'] }}">
    {{ $slot }}
</div>
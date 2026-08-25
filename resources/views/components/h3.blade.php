@props([
    'type' => 'h3',
    'color' => 'sky',
])

@php
    $colors = [
        'lime' => 'bg-lime-200',
        'orange' => 'bg-orange-200',
        'sky' => 'bg-sky-200',
        'blue'  => 'bg-blue-200',
        'pink'  => 'bg-pink-200',
        'green' => 'bg-green-200',
        'red'   => 'bg-red-200',
        'yellow' => 'bg-yellow-200',
        'purple' => 'bg-purple-200',
    ];
@endphp

<h3 type="{{ $type }}" class="text-center font-semibold text-xl my-2 py-2 {{ $colors[$color] ?? $colors['sky'] }} text-blue">
    {{ $slot }}
</h3>
@props(['type' => 'h4'])

<h4 type="{{ $type }}" class="text-center font-semibold text-l my-2 py-2 bg-green-200 text-blue">
    {{ $slot }}
</h4>
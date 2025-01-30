@props(['type' => 'h3'])

<h3 type="{{ $type }}" class="text-center font-semibold text-xl my-2 py-2 bg-sky-200 text-blue">
    {{ $slot }}
</h3>
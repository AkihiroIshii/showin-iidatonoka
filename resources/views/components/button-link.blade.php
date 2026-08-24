@props(['type' => 'div'])

<div type="{{ $type }}" class="flex items-center text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-blue-200">
    {{ $slot }}
</div>
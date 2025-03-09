@props(['type' => 'li'])

<li type="{{ $type }}" class="flex-auto text-center py-0 border-r border-black hover:font-bold">
    {{ $slot }}
</li>
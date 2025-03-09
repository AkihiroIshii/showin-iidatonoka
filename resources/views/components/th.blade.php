@props(['type' => 'th'])

<th type="{{ $type }}" class="sticky top-0 bg-white border border-slate-300 px-4">
    {{ $slot }}
</th>
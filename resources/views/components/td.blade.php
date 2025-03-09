@props(['type' => 'td'])

<td type="{{ $type }}" class="border border-slate-300 px-4">
    {{ $slot }}
</td>
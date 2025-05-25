@props(['class' => '', 'type' => 'td'])

<td type="{{ $type }}" {{$attributes->merge(['class' => "border border-slate-300 px-4 $class"])}}>
    {{ $slot }}
</td>
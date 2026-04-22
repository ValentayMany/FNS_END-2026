@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl bg-indigo-50 text-indigo-600 font-bold text-[0.85rem] transition-all shadow-sm ring-1 ring-indigo-100/50'
            : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-500 font-semibold text-[0.85rem] hover:bg-gray-50 hover:text-gray-900 transition-all';

$iconClasses = ($active ?? false)
            ? 'w-5 h-5 shrink-0 text-indigo-600 drop-shadow-sm'
            : 'w-5 h-5 shrink-0 text-gray-400 group-hover:text-gray-600 transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes . ' group outline-none focus:ring-2 focus:ring-indigo-500 ring-offset-1']) }}>
    @if(isset($icon))
        <div class="{{ $iconClasses }}">
            {{ $icon }}
        </div>
    @endif
    <span class="truncate block w-full">{{ $slot }}</span>
    @if($active ?? false)
        <span class="shrink-0 w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
    @endif
</a>

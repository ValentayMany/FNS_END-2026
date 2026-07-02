@props(['active', 'color' => 'indigo'])

@php
$isRose = $color === 'rose';
$isSky = $color === 'sky';

$classes = ($active ?? false)
    ? ($isRose 
        ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl bg-rose-50 text-rose-600 font-bold text-[0.85rem] transition-all shadow-sm ring-1 ring-rose-100/50'
        : ($isSky 
            ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl bg-sky-50 text-sky-600 font-bold text-[0.85rem] transition-all shadow-sm ring-1 ring-sky-100/50'
            : 'flex items-center gap-3 px-3 py-2.5 rounded-xl bg-indigo-50 text-indigo-600 font-bold text-[0.85rem] transition-all shadow-sm ring-1 ring-indigo-100/50'))
    : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-500 font-semibold text-[0.85rem] hover:bg-gray-50 hover:text-gray-900 transition-all';

$iconClasses = ($active ?? false)
    ? ($isRose 
        ? 'w-5 h-5 shrink-0 text-rose-600 drop-shadow-sm' 
        : ($isSky 
            ? 'w-5 h-5 shrink-0 text-sky-600 drop-shadow-sm' 
            : 'w-5 h-5 shrink-0 text-indigo-600 drop-shadow-sm'))
    : 'w-5 h-5 shrink-0 text-gray-400 group-hover:text-gray-600 transition-colors';

$focusRing = $isRose ? 'focus:ring-rose-500' : ($isSky ? 'focus:ring-sky-500' : 'focus:ring-indigo-500');
$dotColor = $isRose ? 'bg-rose-500' : ($isSky ? 'bg-sky-500' : 'bg-indigo-500');
@endphp

<a {{ $attributes->merge(['class' => $classes . ' group outline-none focus:ring-2 ' . $focusRing . ' ring-offset-1']) }}>
    @if(isset($icon))
        <div class="{{ $iconClasses }}">
            {{ $icon }}
        </div>
    @endif
    <span class="truncate block w-full">{{ $slot }}</span>
    @if($active ?? false)
        <span class="shrink-0 w-1.5 h-1.5 rounded-full {{ $dotColor }} animate-pulse"></span>
    @endif
</a>

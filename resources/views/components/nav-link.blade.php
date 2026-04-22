@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#f0b429] text-sm font-semibold leading-5 text-[#0f2744] focus:outline-none focus:border-[#1e3a5f] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-slate-500 hover:text-[#1e3a5f] hover:border-slate-300 focus:outline-none focus:text-[#1e3a5f] focus:border-slate-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#f0b429] text-start text-base font-semibold text-[#0f2744] bg-[#f8fafc] focus:outline-none focus:text-[#0f2744] focus:bg-[#f1f5f9] focus:border-[#1e3a5f] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-slate-600 hover:text-[#1e3a5f] hover:bg-slate-50 hover:border-slate-300 focus:outline-none focus:text-[#1e3a5f] focus:bg-slate-50 focus:border-slate-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

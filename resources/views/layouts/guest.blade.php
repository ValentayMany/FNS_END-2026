<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=noto-sans-lao:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body.bg-blur.font-sans,
        body.bg-blur.font-sans input,
        body.bg-blur.font-sans button,
        body.bg-blur.font-sans label,
        body.bg-blur.font-sans a {
            font-family: 'Noto Sans Lao', 'Figtree', ui-sans-serif, system-ui, sans-serif;
        }

        .bg-blur::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image: url('{{ asset('image/university-of-laos.jpeg') }}');
            background-size: cover;
            background-position: center;
            filter: blur(3px) brightness(0.5);
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-blur font-sans text-gray-900 antialiased overflow-x-hidden min-h-dvh">

    <div class="fixed inset-0" style="z-index: 1; background: rgba(15, 39, 68, 0.5);"></div>

    <div
        class="relative min-h-dvh flex flex-col justify-center items-stretch sm:items-center px-3 sm:px-6 py-6 sm:py-10 pb-[max(1.5rem,env(safe-area-inset-bottom))] w-full max-w-full min-w-0"
        style="z-index: 2;">
        {{ $slot }}
    </div>

</body>

</html>

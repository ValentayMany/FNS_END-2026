<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FNS-System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=noto-sans-lao:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 bg-[#f4f6fa] overflow-x-hidden selection:bg-indigo-100 selection:text-indigo-900">
        
        <!-- App wrapper with Alpine for mobile menu state -->
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden bg-[#f4f6fa]">
            
            <!-- Mobile Sidebar Overlay -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition-opacity ease-linear duration-300" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 lg:hidden" 
                 @click="sidebarOpen = false" aria-hidden="true"></div>

            <!-- Sidebar Included Here -->
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col w-full h-full min-w-0 overflow-y-auto">
                
                <!-- Mobile Header & Desktop Title Wrapper -->
                <header class="sticky top-0 z-30 shrink-0 bg-[#f4f6fa]/80 backdrop-blur-xl border-b border-white/50 shadow-[0_4px_30px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16 lg:h-20">
                        
                        <!-- Mobile Hamburger -->
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 mr-2 text-gray-500 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg transition-colors">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </button>

                        <!-- Dynamic Header Slot -->
                        <div class="flex-1 min-w-0">
                            @isset($header)
                                <div class="w-full">
                                    {{ $header }}
                                </div>
                            @endisset
                        </div>

                        <!-- Optional Top Right Utilities (Notifications, etc) if needed later -->
                        <div class="flex items-center gap-4 shrink-0 lg:hidden">
                            <!-- Mobile Profile Picture summary -->
                            <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-indigo-500 to-sky-400 flex items-center justify-center text-white text-xs font-bold shadow-sm ring-2 ring-white">
                                {{ mb_substr(Auth::user()->full_name ?? Auth::user()->username, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 w-full relative z-0">
                    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-[1400px] mx-auto w-full">
                        {{ $slot }}
                    </div>
                    
                    <!-- Subtle footer / watermark -->
                    <footer class="mt-auto py-6 text-center text-xs font-medium text-gray-400/80">
                        &copy; {{ date('Y') }} Financial Management System. All rights reserved.
                    </footer>
                </main>
            </div>
            
        </div>
    </body>
</html>

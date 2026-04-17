<nav
    x-data="{ open: false }"
    x-init="$watch('open', v => document.documentElement.classList.toggle('overflow-hidden', v))"
    class="relative z-[70] bg-gradient-to-r from-[#1e3a5f] to-[#0f2744] border-b border-white/10">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 min-w-0">
        <div class="flex justify-between items-center h-16 min-w-0 gap-2">
            <div class="flex min-w-0 flex-1 sm:flex-initial sm:min-w-0">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('image/Logo.jpg') }}" alt="{{ config('app.name', 'FNS') }}"
                            class="block h-10 md:h-14 md:w-auto w-10 bg-white rounded-lg p-1 shadow-sm ring-1 ring-white/25" />
                    </a>
                </div>

                <!-- Navigation Links ตาม Role -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">

                    @auth
                    @php $role = Auth::user()->role?->role_name; @endphp

                    {{-- Requester --}}
                    @if($role === 'requester')
                        <a href="{{ route('requests.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->routeIs(['requests.index', 'requests.show']) ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25A3.375 3.375 0 004.875 5.625v12.75A3.375 3.375 0 008.25 21.75h7.5A3.75 3.75 0 0019.5 18v-3.75z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 2.25V6a2.25 2.25 0 002.25 2.25h3.75" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.25 11.25h7.5M8.25 14.25h6" />
                            </svg>
                            <span>ຄຳຂໍຂອງຂ້ອຍ</span>
                        </a>
                        <a href="{{ route('requests.create') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->routeIs('requests.create') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            <span>ສ້າງຄຳຂໍ</span>
                        </a>
                        <a href="{{ route('clearing.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('clearing*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>ສະສາງ</span>
                        </a>
                    @endif

                    {{-- Approvers --}}
                    @if(in_array($role, ['accountant', 'head_of_finance', 'deputy_head_of_faculty', 'head_of_faculty']))
                        <a href="{{ route('approval.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('approvals*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 13.5l.5 1.75a2.25 2.25 0 001.5 1.5l1.75.5-1.75.5a2.25 2.25 0 00-1.5 1.5L18 21l-.5-1.75a2.25 2.25 0 00-1.5-1.5l-1.75-.5 1.75-.5a2.25 2.25 0 001.5-1.5L18 13.5z" />
                            </svg>
                            <span>ອະນຸມັດ</span>
                        </a>
                    @endif

                    {{-- Accountant เพิ่มเติม --}}
                    @if($role === 'accountant')
                        <a href="{{ route('clearing.pending') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('clearing/pending') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>ຢືນຢັນ Clearing</span>
                        </a>
                        <a href="{{ route('expense.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('expense*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v12m-3-9h6m-7.5 3.75h9m-10.5 3h12" />
                            </svg>
                            <span>ບັນທຶກລາຍຈ່າຍ</span>
                        </a>
                        <a href="{{ route('reports.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('reports*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3v18h18" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7.5 14.25V18m4.5-9V18m4.5-6V18" />
                            </svg>
                            <span>ລາຍງານ</span>
                        </a>
                    @endif

                    {{-- Cashier --}}
                    @if($role === 'cashier')
                        <a href="{{ route('cashier.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('cashier*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.25 8.25h19.5m-19.5 7.5h19.5M3.75 6h16.5A1.5 1.5 0 0121.75 7.5v9A1.5 1.5 0 0120.25 18H3.75A1.5 1.5 0 012.25 16.5v-9A1.5 1.5 0 013.75 6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            </svg>
                            <span>ຈ່າຍເງິນ</span>
                        </a>
                    @endif

                    {{-- Revenue Officer --}}
                    @if($role === 'revenue_officer')
                        <a href="{{ route('revenue.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('revenue*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3v18h18" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7.5 16.5V18m4.5-6V18m4.5-9V18" />
                            </svg>
                            <span>ບັນທຶກລາຍຮັບ</span>
                        </a>
                        <a href="{{ route('reports.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('reports*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25A3.375 3.375 0 004.875 5.625v12.75A3.375 3.375 0 008.25 21.75h7.5A3.75 3.75 0 0019.5 18v-3.75z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 2.25V6a2.25 2.25 0 002.25 2.25h3.75" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.25 11.25h7.5M8.25 14.25h4.5" />
                            </svg>
                            <span>ລາຍງານ</span>
                        </a>
                    @endif

                    {{-- Treasurer --}}
                    @if($role === 'treasurer')
                        <a href="{{ route('treasurer.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('treasurer*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10.5h18M4.5 10.5V19.5A1.5 1.5 0 006 21h12a1.5 1.5 0 001.5-1.5v-9M6.75 7.5h10.5a1.5 1.5 0 011.5 1.5v1.5H5.25V9a1.5 1.5 0 011.5-1.5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.25 15h.75M8.25 17.25h.75M12 15h.75M12 17.25h.75M15.75 15h.75M15.75 17.25h.75" />
                            </svg>
                            <span>ສະຖານະເງິນ</span>
                        </a>
                        <a href="{{ route('reports.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('reports*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25A3.375 3.375 0 004.875 5.625v12.75A3.375 3.375 0 008.25 21.75h7.5A3.75 3.75 0 0019.5 18v-3.75z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 2.25V6a2.25 2.25 0 002.25 2.25h3.75" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.25 11.25h7.5M8.25 14.25h4.5" />
                            </svg>
                            <span>ລາຍງານ</span>
                        </a>
                    @endif

                    {{-- Treasury Reconciliation --}}
                    @if($role === 'treasury_reconciliation_officer')
                        <a href="{{ route('treasury.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('treasury*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10.5h18M4.5 10.5V19.5A1.5 1.5 0 006 21h12a1.5 1.5 0 001.5-1.5v-9" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3l9 5.25-9 5.25-9-5.25L12 3z" />
                            </svg>
                            <span>ສະສາງຄັງເງິນ</span>
                        </a>
                    @endif

                    {{-- Head of Finance --}}
                    @if($role === 'head_of_finance')
                        <a href="{{ route('reports.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('reports*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3v18h18" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7.5 14.25V18m4.5-9V18m4.5-6V18" />
                            </svg>
                            <span>ລາຍງານ</span>
                        </a>
                    @endif

                    {{-- Admin --}}
                    @if($role === 'admin')
                        <a href="{{ route('admin.users') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('admin*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.956" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.875 6.75a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 19.5a6 6 0 0112 0v.75H3v-.75z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16.5 6.75a3 3 0 113 3 3 3 0 01-3-3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 13.5c2.485 0 4.5 1.343 4.5 3v.75H16.5" />
                            </svg>
                            <span>ຈັດການຜູ້ໃຊ້</span>
                        </a>
                        <a href="{{ route('reports.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium {{ request()->is('reports*') ? 'text-white border-b-2 border-[#f0b429]' : 'text-white/75 hover:text-white' }} pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3v18h18" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7.5 14.25V18m4.5-9V18m4.5-6V18" />
                            </svg>
                            <span>ລາຍງານ</span>
                        </a>
                    @endif

                    @endauth
                </div>
            </div>

            <!-- User Menu (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <span class="text-xs text-white/80 mr-3">
                    {{ Auth::user()->full_name }}
                    <span
                        class="bg-white/10 text-[#f0b429] px-2 py-0.5 rounded-full text-[11px] font-semibold ring-1 ring-white/15">
                        {{ Auth::user()->role?->role_name }}
                    </span>
                </span>
                @endauth

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-white bg-white/10 hover:bg-white/15 focus:outline-none transition ease-in-out duration-150 ring-1 ring-white/10">
                            <div>{{ Auth::user()->name ?? Auth::user()->full_name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-white/90" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.5 20.25a7.5 7.5 0 0115 0v.75H4.5v-.75z" />
                                </svg>
                                <span>ໂປຣໄຟລ໌</span>
                            </span>
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <span class="inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3H6.75A2.25 2.25 0 004.5 5.25v13.5A2.25 2.25 0 006.75 21h6.75a2.25 2.25 0 002.25-2.25V15" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9l3 3-3 3m3-3H8.25" />
                                    </svg>
                                    <span>ອອກຈາກລະບົບ</span>
                                </span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-white/90 hover:text-white hover:bg-white/10 focus:outline-none focus:bg-white/10 transition ring-1 ring-white/10"
                    aria-label="Toggle menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile): fixed overlay — ไม่ดันเนื้อหาหน้า (main อยู่ใต้ layer) -->
    <div
        x-show="open"
        x-cloak
        @keydown.escape.window="if (open) open = false"
        class="fixed left-0 right-0 top-16 bottom-0 z-[60] sm:hidden"
        style="display: none;"
    >
        <div
            class="absolute inset-0 z-0 bg-slate-950/50 backdrop-blur-[1px]"
            @click="open = false"
            aria-hidden="true"
        ></div>
        <div
            class="relative z-10 flex h-full min-h-0 flex-col overflow-y-auto overscroll-contain touch-pan-y border-t border-white/10 bg-gradient-to-b from-[#1e3a5f] to-[#0f2744] shadow-[0_-8px_32px_rgba(0,0,0,0.2)]"
            @click="if ($event.target.closest('a[href]')) open = false"
        >
        <div class="pt-3 pb-3 space-y-1 px-3 sm:px-4">
            @auth
                @php $role = Auth::user()->role?->role_name; @endphp

                @if($role === 'requester')
                    <a href="{{ route('requests.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->routeIs(['requests.index', 'requests.show']) ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25A3.375 3.375 0 004.875 5.625v12.75A3.375 3.375 0 008.25 21.75h7.5A3.75 3.75 0 0019.5 18v-3.75z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.5 2.25V6a2.25 2.25 0 002.25 2.25h3.75" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.25 11.25h7.5M8.25 14.25h6" />
                        </svg>
                        <span>ຄຳຂໍຂອງຂ້ອຍ</span>
                    </a>
                    <a href="{{ route('requests.create') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->routeIs('requests.create') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        <span>ສ້າງຄຳຂໍ</span>
                    </a>
                    <a href="{{ route('clearing.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('clearing*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>ສະສາງ</span>
                    </a>
                @endif

                @if(in_array($role, ['accountant', 'head_of_finance', 'deputy_head_of_faculty', 'head_of_faculty']))
                    <a href="{{ route('approval.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('approvals*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 13.5l.5 1.75a2.25 2.25 0 001.5 1.5l1.75.5-1.75.5a2.25 2.25 0 00-1.5 1.5L18 21l-.5-1.75a2.25 2.25 0 00-1.5-1.5l-1.75-.5 1.75-.5a2.25 2.25 0 001.5-1.5L18 13.5z" />
                        </svg>
                        <span>ອະນຸມັດ</span>
                    </a>
                @endif

                @if($role === 'accountant')
                    <a href="{{ route('clearing.pending') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('clearing/pending') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>ຢືນຢັນ Clearing</span>
                    </a>
                    <a href="{{ route('expense.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('expense*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v12m-3-9h6m-7.5 3.75h9m-10.5 3h12" />
                        </svg>
                        <span>ບັນທຶກລາຍຈ່າຍ</span>
                    </a>
                    <a href="{{ route('reports.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('reports*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7.5 14.25V18m4.5-9V18m4.5-6V18" />
                        </svg>
                        <span>ລາຍງານ</span>
                    </a>
                @endif

                @if($role === 'cashier')
                    <a href="{{ route('cashier.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('cashier*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.25 8.25h19.5m-19.5 7.5h19.5M3.75 6h16.5A1.5 1.5 0 0121.75 7.5v9A1.5 1.5 0 0120.25 18H3.75A1.5 1.5 0 012.25 16.5v-9A1.5 1.5 0 013.75 6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        <span>ຈ່າຍເງິນ</span>
                    </a>
                @endif

                @if($role === 'revenue_officer')
                    <a href="{{ route('revenue.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('revenue*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7.5 16.5V18m4.5-6V18m4.5-9V18" />
                        </svg>
                        <span>ບັນທຶກລາຍຮັບ</span>
                    </a>
                    <a href="{{ route('reports.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('reports*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25A3.375 3.375 0 004.875 5.625v12.75A3.375 3.375 0 008.25 21.75h7.5A3.75 3.75 0 0019.5 18v-3.75z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.5 2.25V6a2.25 2.25 0 002.25 2.25h3.75" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.25 11.25h7.5M8.25 14.25h4.5" />
                        </svg>
                        <span>ລາຍງານ</span>
                    </a>
                @endif

                @if($role === 'treasurer')
                    <a href="{{ route('treasurer.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('treasurer*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10.5h18M4.5 10.5V19.5A1.5 1.5 0 006 21h12a1.5 1.5 0 001.5-1.5v-9M6.75 7.5h10.5a1.5 1.5 0 011.5 1.5v1.5H5.25V9a1.5 1.5 0 011.5-1.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.25 15h.75M8.25 17.25h.75M12 15h.75M12 17.25h.75M15.75 15h.75M15.75 17.25h.75" />
                        </svg>
                        <span>ສະຖານະເງິນ</span>
                    </a>
                    <a href="{{ route('reports.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('reports*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25A3.375 3.375 0 004.875 5.625v12.75A3.375 3.375 0 008.25 21.75h7.5A3.75 3.75 0 0019.5 18v-3.75z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.5 2.25V6a2.25 2.25 0 002.25 2.25h3.75" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.25 11.25h7.5M8.25 14.25h4.5" />
                        </svg>
                        <span>ລາຍງານ</span>
                    </a>
                @endif

                @if($role === 'treasury_reconciliation_officer')
                    <a href="{{ route('treasury.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('treasury*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10.5h18M4.5 10.5V19.5A1.5 1.5 0 006 21h12a1.5 1.5 0 001.5-1.5v-9" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3l9 5.25-9 5.25-9-5.25L12 3z" />
                        </svg>
                        <span>ສະສາງຄັງເງິນ</span>
                    </a>
                @endif

                @if($role === 'head_of_finance')
                    <a href="{{ route('reports.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('reports*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7.5 14.25V18m4.5-9V18m4.5-6V18" />
                        </svg>
                        <span>ລາຍງານ</span>
                    </a>
                @endif

                @if($role === 'admin')
                    <a href="{{ route('admin.users') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('admin*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.956" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.875 6.75a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 19.5a6 6 0 0112 0v.75H3v-.75z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16.5 6.75a3 3 0 113 3 3 3 0 01-3-3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 13.5c2.485 0 4.5 1.343 4.5 3v.75H16.5" />
                        </svg>
                        <span>ຈັດການຜູ້ໃຊ້</span>
                    </a>
                    <a href="{{ route('reports.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('reports*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7.5 14.25V18m4.5-9V18m4.5-6V18" />
                        </svg>
                        <span>ລາຍງານ</span>
                    </a>
                @endif
            @endauth
        </div>

        <div class="pt-2 pb-[max(1rem,env(safe-area-inset-bottom))] border-t border-white/10 px-3 sm:px-4">
            @auth
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-semibold text-white">{{ Auth::user()->name ?? Auth::user()->full_name }}</div>
                        <div class="text-xs text-white/70">{{ Auth::user()->full_name }}</div>
                    </div>
                    <span
                        class="bg-white/10 text-[#f0b429] px-2 py-0.5 rounded-full text-[11px] font-semibold ring-1 ring-white/15">
                        {{ Auth::user()->role?->role_name }}
                    </span>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold text-white/80 hover:bg-white/10 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.5 20.25a7.5 7.5 0 0115 0v.75H4.5v-.75z" />
                        </svg>
                        <span>ໂປຣໄຟລ໌</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" @submit="open = false">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold text-white/80 hover:bg-white/10 hover:text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3H6.75A2.25 2.25 0 004.5 5.25v13.5A2.25 2.25 0 006.75 21h6.75a2.25 2.25 0 002.25-2.25V15" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9l3 3-3 3m3-3H8.25" />
                            </svg>
                            <span>ອອກຈາກລະບົບ</span>
                        </button>
                    </form>
                </div>
            @endauth
        </div>
        </div>
    </div>
</nav>

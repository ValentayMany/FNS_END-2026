<!-- Desktop Sidebar & Mobile Offcanvas Menu -->
<nav x-cloak 
     :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" 
     class="fixed lg:static inset-y-0 left-0 z-50 w-72 bg-white lg:bg-white border-r border-gray-100 flex flex-col shrink-0 transition-transform duration-300 ease-in-out shadow-[4px_0_24px_rgba(0,0,0,0.02)] lg:shadow-none h-full">
    
    <!-- Sidebar Header (Brand & Logo) -->
    <div class="h-16 lg:h-20 shrink-0 flex items-center justify-between px-6 border-b border-gray-50/80 bg-white/50 backdrop-blur-md">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group outline-none rounded-xl focus:ring-2 focus:ring-indigo-500 ring-offset-2">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-sky-400 flex items-center justify-center text-white shadow-md shadow-indigo-200 group-hover:scale-105 group-hover:rotate-3 transition-transform duration-300">
                <svg class="w-5 h-5 drop-shadow-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-extrabold text-gray-900 tracking-tight leading-none group-hover:text-indigo-600 transition-colors">FNS</span>
                <span class="text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Financial System</span>
            </div>
        </a>
        
        <!-- Mobile Close Button -->
        <button @click="sidebarOpen = false" class="lg:hidden p-2 -mr-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <!-- Navigation Links -->
    @php
        $role = Auth::user()->role?->role_name;
    @endphp
    <div class="flex-1 px-4 py-6 overflow-y-auto overflow-x-hidden space-y-6 scrollbar-hide touch-pan-y text-gray-500">
        


        <div>
            <p class="px-3 mb-3 text-[0.7rem] font-bold tracking-widest text-gray-400 uppercase">ເມນູຫຼັກ</p>
            <div class="space-y-1.5">

                @if($role === 'requester')
                    <x-sidebar-link :href="route('requests.create')" :active="request()->routeIs('requests.create')">
                        <x-slot name="icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        </x-slot>
                        ສ້າງຄຳຂໍໃໝ່
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('requests.index')" :active="request()->routeIs('requests.index') || request()->routeIs('requests.show') || request()->routeIs('requests.edit')">
                        <x-slot name="icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </x-slot>
                        ຕິດຕາມສະຖານะຄຳຂໍ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('clearing.index')" :active="request()->routeIs('clearing.index')">
                        <x-slot name="icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </x-slot>
                        ສະສາງເງິນ (Clearing)
                    </x-sidebar-link>
                @endif

                @if($role === 'accountant')
                    <x-sidebar-link :href="route('approvals.index')" :active="request()->routeIs('approvals.*')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></x-slot>
                        ອະນຸມັດຄຳຂໍເບີກຈ່າຍ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('expense.index')" :active="request()->routeIs('expense.*')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25A3.375 3.375 0 004.875 5.625v12.75A3.375 3.375 0 008.25 21.75h7.5A3.75 3.75 0 0019.5 18v-3.75z" /></svg></x-slot>
                        ບັນທຶກລາຍຈ່າຍທົ່ວໄປ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('clearing.pending')" :active="request()->routeIs('clearing.*')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12M8.25 17.25h12M3.75 6.75h.007v.008H3.75V6.75zm0 5.25h.007v.008H3.75V12zm0 5.25h.007v.008H3.75v-.008z" /></svg></x-slot>
                        ສະສາງເງິນ (Clearing)
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('reports.index')" :active="request()->routeIs('reports.index') || request()->routeIs('reports.export')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6zM13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg></x-slot>
                        ລາຍງານ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('reports.budget-expense')" :active="request()->routeIs('reports.budget-expense')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v4.125c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 013 17.25v-4.125zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125v-8.25zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v12.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg></x-slot>
                        ລາຍຈ່າຍງົບປະມານ
                    </x-sidebar-link>
                @endif

                @if($role === 'cashier')
                    <x-sidebar-link :href="route('cashier.index')" :active="request()->routeIs('cashier.*')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg></x-slot>
                        จ่ายเງິນ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('reports.index')" :active="request()->routeIs('reports.*') && !request()->routeIs('reports.budget_expense')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6zM13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg></x-slot>
                        ລາຍງານ
                    </x-sidebar-link>
                @endif

                @if($role === 'revenue_officer')
                    <x-sidebar-link :href="route('revenue.dashboard')" :active="request()->routeIs('revenue.dashboard')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg></x-slot>
                        Dashboard ລາຍຮັບ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('revenue.index')" :active="request()->routeIs('revenue.*') && !request()->routeIs('revenue.dashboard')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v4.125c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 013 17.25v-4.125zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125v-8.25zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v12.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg></x-slot>
                        🛡️ ບັນທຶກລາຍຮັບ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('reports.index')" :active="request()->routeIs('reports.*') && !request()->routeIs('reports.budget_expense')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6zM13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg></x-slot>
                        ລາຍງານ
                    </x-sidebar-link>
                @endif

                @if(in_array($role, ['head_of_faculty', 'deputy_head_of_faculty']))
                    <x-sidebar-link :href="route('approvals.index')" :active="request()->routeIs('approvals.*')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></x-slot>
                        ອະນຸມັດຄຳຂໍເບີກຈ່າຍ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('revenue.dashboard')" :active="request()->routeIs('revenue.dashboard')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg></x-slot>
                        Dashboard ລາຍຮັບ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('reports.index')" :active="request()->routeIs('reports.*') && !request()->routeIs('reports.budget_expense')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6zM13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg></x-slot>
                        ລາຍງານ
                    </x-sidebar-link>
                @endif

                @if($role === 'treasurer')
                    <x-sidebar-link :href="route('treasurer.index')" :active="request()->routeIs('treasurer.*')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" /></svg></x-slot>
                        ຄັງເງິນ (Treasurer)
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('revenue.dashboard')" :active="request()->routeIs('revenue.dashboard')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg></x-slot>
                        Dashboard ລາຍຮັບ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('reports.index')" :active="request()->routeIs('reports.*') && !request()->routeIs('reports.budget_expense')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6zM13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg></x-slot>
                        ລາຍງານ
                    </x-sidebar-link>
                @endif

                @if($role === 'treasury_reconciliation_officer')
                    <x-sidebar-link :href="route('treasury.index')" :active="request()->routeIs('treasury.*')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg></x-slot>
                        ສະສາງຄັງເງິນ
                    </x-sidebar-link>
                @endif

                @if($role === 'head_of_finance')
                    <x-sidebar-link :href="route('revenue.dashboard')" :active="request()->routeIs('revenue.dashboard')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg></x-slot>
                        Dashboard ລາຍຮັບ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('reports.index')" :active="request()->routeIs('reports.*') && !request()->routeIs('reports.budget_expense')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6zM13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg></x-slot>
                        ລາຍງານ
                    </x-sidebar-link>
                @endif

                @if($role === 'admin')
                    <x-sidebar-link :href="route('admin.users')" :active="request()->routeIs('admin.users*')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.956m-7.128-1.533A15.362 15.362 0 0112 18.75c-4.04 0-7.616-1.52-10.231-3.99A15.38 15.38 0 0112 14.25c2.96 0 5.67.75 8.162 2.05m-15.69-7.143a15.38 15.38 0 0113.626-3.83m-13.626 3.83c1.785-1.895 4.316-3.08 7.126-3.08 3.542 0 6.64 1.83 8.36 4.6" /></svg></x-slot>
                        ຈັດການຜູ້ໃຊ້
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('revenue.dashboard')" :active="request()->routeIs('revenue.dashboard')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg></x-slot>
                        Dashboard ລາຍຮັບ
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('reports.index')" :active="request()->routeIs('reports.*') && !request()->routeIs('reports.budget_expense')">
                        <x-slot name="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6zM13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg></x-slot>
                        ລາຍງານ
                    </x-sidebar-link>
                @endif

            </div>
        </div>

    </div>

    <!-- User Profile Footer -->
    <div class="p-4 shrink-0 border-t border-gray-100 bg-gray-50/50 mt-auto">
        <div class="relative" x-data="{ openProfile: false }">
            <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="w-full flex items-center justify-between p-2 rounded-xl hover:bg-white hover:shadow-sm ring-1 ring-transparent hover:ring-gray-200 transition-all text-left focus:outline-none">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-sky-400 flex items-center justify-center text-white text-sm font-bold shadow-sm shrink-0">
                        {{ mb_substr(Auth::user()->full_name ?? Auth::user()->username, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-800 truncate leading-none mb-1">{{ Auth::user()->full_name ?? Auth::user()->username }}</p>
                        <p class="text-[0.65rem] font-bold text-indigo-500 uppercase tracking-wider truncate leading-none">{{ Auth::user()->roleDisplay() }}</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg>
            </button>
            
            <!-- Dropup Menu -->
            <div x-show="openProfile" 
                 x-transition:enter="transition ease-out duration-100" 
                 x-transition:enter-start="transform opacity-0 scale-95" 
                 x-transition:enter-end="transform opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-75" 
                 x-transition:leave-start="transform opacity-100 scale-100" 
                 x-transition:leave-end="transform opacity-0 scale-95" 
                 class="absolute bottom-full left-0 w-full mb-2 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50 overflow-hidden transform origin-bottom">
                
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    ຈັດການໂປຣໄຟລ໌
                </a>
                
                <div class="h-px bg-gray-100 my-1"></div>
                
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors text-left cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        ອອກຈາກລະບົບ
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Desktop Sidebar Spacer (Prevents content hiding under absolute sidebar if it was absolute, but we used flex) -->

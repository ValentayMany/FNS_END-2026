<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links ตาม Role -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">

                    @auth
                    @php $role = Auth::user()->role?->role_name; @endphp

                    {{-- Requester --}}
                    @if($role === 'requester')
                        <a href="{{ route('requests.index') }}"
                           class="text-sm font-medium {{ request()->is('requests*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            📋 ຄຳຂໍຂອງຂ້ອຍ
                        </a>
                        <a href="{{ route('requests.create') }}"
                           class="text-sm font-medium {{ request()->is('requests/create') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            ➕ ສ້າງຄຳຂໍ
                        </a>
                        <a href="{{ route('clearing.index') }}"
                           class="text-sm font-medium {{ request()->is('clearing*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            🧾 ສະສາງ
                        </a>
                    @endif

                    {{-- Approvers --}}
                    @if(in_array($role, ['accountant', 'head_of_finance', 'deputy_head_of_faculty', 'head_of_faculty']))
                        <a href="{{ route('approval.index') }}"
                           class="text-sm font-medium {{ request()->is('approvals*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            ⚡ ອະນຸມັດ
                        </a>
                    @endif

                    {{-- Accountant เพิ่มเติม --}}
                    @if($role === 'accountant')
                        <a href="{{ route('clearing.pending') }}"
                           class="text-sm font-medium {{ request()->is('clearing/pending') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            🧾 ຢືນຢັນ Clearing
                        </a>
                        <a href="{{ route('expense.index') }}"
                           class="text-sm font-medium {{ request()->is('expense*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            💸 ບັນທຶກລາຍຈ່າຍ
                        </a>
                        <a href="{{ route('reports.index') }}"
                           class="text-sm font-medium {{ request()->is('reports*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            📊 ລາຍງານ
                        </a>
                    @endif

                    {{-- Cashier --}}
                    @if($role === 'cashier')
                        <a href="{{ route('cashier.index') }}"
                           class="text-sm font-medium {{ request()->is('cashier*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            💵 ຈ່າຍເງິນ
                        </a>
                    @endif

                    {{-- Revenue Officer --}}
                    @if($role === 'revenue_officer')
                        <a href="{{ route('revenue.index') }}"
                           class="text-sm font-medium {{ request()->is('revenue*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            📊 ບັນທຶກລາຍຮັບ
                        </a>
                        <a href="{{ route('reports.index') }}"
                           class="text-sm font-medium {{ request()->is('reports*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            📋 ລາຍງານ
                        </a>
                    @endif

                    {{-- Treasurer --}}
                    @if($role === 'treasurer')
                        <a href="{{ route('treasurer.index') }}"
                           class="text-sm font-medium {{ request()->is('treasurer*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            🏦 ສະຖານະເງິນ
                        </a>
                        <a href="{{ route('reports.index') }}"
                           class="text-sm font-medium {{ request()->is('reports*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            📋 ລາຍງານ
                        </a>
                    @endif

                    {{-- Treasury Reconciliation --}}
                    @if($role === 'treasury_reconciliation_officer')
                        <a href="{{ route('treasury.index') }}"
                           class="text-sm font-medium {{ request()->is('treasury*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            🏛️ ສະສາງຄັງເງິນ
                        </a>
                    @endif

                    {{-- Head of Finance --}}
                    @if($role === 'head_of_finance')
                        <a href="{{ route('reports.index') }}"
                           class="text-sm font-medium {{ request()->is('reports*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            📊 ລາຍງານ
                        </a>
                    @endif

                    {{-- Admin --}}
                    @if($role === 'admin')
                        <a href="{{ route('admin.users') }}"
                           class="text-sm font-medium {{ request()->is('admin*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            👥 ຈັດການຜູ້ໃຊ້
                        </a>
                        <a href="{{ route('reports.index') }}"
                           class="text-sm font-medium {{ request()->is('reports*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }} pb-1">
                            📊 ລາຍງານ
                        </a>
                    @endif

                    @endauth
                </div>
            </div>

            <!-- User Menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <span class="text-xs text-gray-400 mr-3">
                    {{ Auth::user()->full_name }}
                    <span class="bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded text-xs">
                        {{ Auth::user()->role?->role_name }}
                    </span>
                </span>
                @endauth

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name ?? Auth::user()->full_name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            👤 Profile
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                🚪 ອອກຈາກລະບົບ
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>

@php
    $userRole = auth()->user()->role?->role_name;
    $isRevenueOnly = $userRole === 'revenue_officer';
    $isAccountant  = $userRole === 'accountant';
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full min-w-0">
            <div class="flex flex-col gap-1 min-w-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center shrink-0 shadow-lg shadow-indigo-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H3m18 0h-2a4 4 0 00-4 4v2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                            {{ $isRevenueOnly ? 'ລາຍງານສະຫຼຸບລາຍຮັບ' : ($isAccountant ? 'ລາຍງານສະຫຼຸບລາຍຈ່າຍ' : 'ລາຍງານລາຍຮັບ-ລາຍຈ່າຍ') }}
                        </h2>
                        <p class="text-xs font-medium text-gray-400 mt-0.5">ບົດສະຫຼຸບ ແລະ ປະຫວັດການເຄື່ອນໄຫວດ້ານການເງິນ</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0 no-print">
                @if(!$isRevenueOnly)
                <a href="{{ route('reports.budget-expense', request()->only(['type', 'date', 'month', 'year'])) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold border border-gray-200 shadow-sm transition-all duration-200">
                    ຕິດຕາມງົບປະມານ
                </a>
                @endif
                <a href="{{ route('reports.export', request()->all()) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold shadow-lg shadow-emerald-500/30 transition-all duration-200 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Excel
                </a>
                <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-lg shadow-indigo-600/30 transition-all duration-200 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    ພິມລາຍງານ
                </button>
            </div>
        </div>
    </x-slot>

    <style>
        /* ── PRINT ── */
        .print-only { display: none; }

        @media print {
            /* Hide screen elements */
            .no-print, header, nav, aside, footer { display: none !important; }
            
            /* Reset all layout wrappers to block and visible to avoid squishing and truncation */
            html, body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                height: auto !important;
            }
            
            div.flex.h-screen, 
            div.flex-1.flex-col, 
            main.relative, 
            div.max-w-\[1400px\] {
                display: block !important;
                height: auto !important;
                width: 100% !important;
                max-width: none !important;
                overflow: visible !important;
                position: static !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .print-only {
                display: block !important;
                width: 100% !important;
                padding: 0 !important;
                box-sizing: border-box !important;
                font-family: 'Noto Sans Lao', 'Phetsarath OT', sans-serif !important;
            }
            .print-only * { color: #000 !important; }
            
            .p-tbl { width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 12px; }
            .p-tbl th, .p-tbl td { border: 1px solid #000 !important; padding: 6px 8px !important; text-align: left; }
            .p-tbl thead th { background: #fff !important; font-weight: bold !important; font-size: 11px; }
            .p-tbl tfoot td { background: #fff !important; font-weight: bold !important; }
        }

        /* ── SCREEN ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .rpt-card { animation: fadeUp 0.35s ease both; }
        .rpt-card:nth-child(1) { animation-delay: 0.05s; }
        .rpt-card:nth-child(2) { animation-delay: 0.12s; }
        .rpt-card:nth-child(3) { animation-delay: 0.19s; }

        /* Table row hover */
        .rpt-row { transition: background 0.15s, box-shadow 0.15s; }
        .rpt-row:hover { background: #f0f4ff; }

        /* Pill toggle active */
        .pill-active { background: #fff; color: #4f46e5; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
    </style>

    {{-- ═══════════════════ SCREEN VIEW ═══════════════════ --}}
    <div class="space-y-5 no-print">

        {{-- ── Filter Bar ── --}}
        <form method="GET" action="{{ route('reports.index') }}"
              class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            {{-- Gradient accent strip --}}
            <div class="h-1 bg-gradient-to-r from-indigo-500 via-violet-500 to-sky-500"></div>

            <div class="p-5 flex flex-wrap gap-4 items-end">

                {{-- Type pill toggle --}}
                <div class="flex flex-col gap-1.5">
                    <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">ປະເພດລາຍງານ</span>
                    <div class="flex bg-gray-100 rounded-xl p-1 gap-0.5 h-10 items-center">
                        @foreach(['daily'=>'ວັນ','monthly'=>'ເດືອນ','yearly'=>'ປີ'] as $t => $label)
                            <a href="{{ route('reports.index', array_merge(request()->except('type'), ['type'=>$t])) }}"
                               class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all duration-150 whitespace-nowrap {{ $type===$t ? 'pill-active' : 'text-gray-400 hover:text-gray-700' }}">
                               {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <input type="hidden" name="type" value="{{ $type }}">

                {{-- Transaction Type Toggle --}}
                @if(!$isRevenueOnly && !$isAccountant)
                <div class="flex flex-col gap-1.5">
                    <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">ສະແດງທຸລະກຳ</span>
                    <div class="flex bg-gray-100 rounded-xl p-1 gap-0.5 h-10 items-center">
                        @foreach(['all'=>'ທັງໝົດ','income'=>'ລາຍຮັບ','expense'=>'ລາຍຈ່າຍ'] as $tv => $tl)
                            <a href="{{ route('reports.index', array_merge(request()->all(), ['txn_type'=>$tv])) }}"
                               class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all duration-150 whitespace-nowrap {{ $txnType===$tv ? 'pill-active' : 'text-gray-400 hover:text-gray-700' }}">
                               {{ $tl }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @else
                    <input type="hidden" name="txn_type" value="{{ $isRevenueOnly ? 'income' : 'expense' }}">
                @endif

                {{-- Date filter --}}
                <div class="flex flex-col gap-1.5">
                    <label for="date_filter" class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">
                        {{ $type==='daily' ? 'ວັນທີ' : ($type==='monthly' ? 'ເດືອນ' : 'ປີ') }}
                    </label>
                    @if($type==='daily')
                        <input id="date_filter" type="date" name="date" value="{{ $date }}"
                            class="h-10 px-3 rounded-xl border border-gray-200 text-sm bg-white focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition-all shadow-sm min-w-[160px]">
                    @elseif($type==='monthly')
                        <input id="date_filter" type="month" name="month" value="{{ $month }}"
                            class="h-10 px-3 rounded-xl border border-gray-200 text-sm bg-white focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition-all shadow-sm min-w-[160px]">
                    @else
                        <select id="date_filter" name="year"
                            class="h-10 px-3 rounded-xl border border-gray-200 text-sm bg-white focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition-all shadow-sm min-w-[120px] cursor-pointer">
                            @for($y = date('Y')-5; $y <= date('Y')+2; $y++)
                                <option value="{{ $y }}" {{ $year==$y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    @endif
                </div>

                {{-- Department --}}
                <div class="flex flex-col gap-1.5 min-w-[200px]">
                    <label for="dept_filter" class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">ພາກສ່ວນ</label>
                    <select id="dept_filter" name="department_id"
                        class="h-10 px-3 rounded-xl border border-gray-200 text-sm bg-white focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition-all shadow-sm cursor-pointer">
                        <option value="">ທັງໝົດ</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department_id')==$dept->id ? 'selected' : '' }}>{{ $dept->department_name }}</option>
                        @endforeach
                    </select>
                </div>

                @if(!$isRevenueOnly && $txnType !== 'income')
                <div class="flex flex-col gap-1.5 min-w-[220px] flex-1">
                    <label for="account_filter" class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">ໝວດບັນຊີ (ພິມ)</label>
                    <select id="account_filter" name="account_id"
                        class="h-10 px-3 rounded-xl border border-gray-200 text-sm bg-white focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition-all shadow-sm cursor-pointer">
                        <option value="">ອັດຕະໂນມັດ (ຈາກລາຍການ)</option>
                        @foreach($expenseAccounts as $acc)
                            <option value="{{ $acc->id }}" {{ (string) request('account_id') === (string) $acc->id ? 'selected' : '' }}>
                                {{ $acc->account_code }} — {{ $acc->account_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                {{-- Submit --}}
                <button type="submit"
                    class="h-10 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold flex items-center gap-2 shadow-md shadow-indigo-600/25 transition-all duration-150 hover:-translate-y-0.5 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    ຄົ້ນຫາ
                </button>
            </div>
        </form>

        {{-- ── Stat Cards ── --}}
        @php
            $netBalance = $totalIncome - $totalExpense;
            $statCols   = ($txnType === 'all' && !$isRevenueOnly && !$isAccountant) ? 3 : 1;
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-{{ $statCols }} gap-4">

            {{-- Income Card --}}
            @if($txnType !== 'expense')
            <div class="rpt-card relative overflow-hidden bg-white rounded-2xl border border-emerald-100 shadow-sm p-5 flex items-center gap-4">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-emerald-400 to-teal-500 rounded-l-2xl"></div>
                <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 text-white flex items-center justify-center shrink-0 shadow-lg shadow-emerald-400/30 ml-1" style="width:52px;height:52px;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">ລາຍຮັບລວມ</p>
                    <p class="text-2xl font-extrabold text-emerald-600 leading-none tracking-tight">
                        {{ number_format($totalIncome, 0) }}
                        <span class="text-sm font-semibold text-gray-400 ml-1">₭</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Total Income</p>
                </div>
                {{-- Decorative circle --}}
                <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-emerald-50 opacity-60"></div>
            </div>
            @endif

            {{-- Expense Card --}}
            @if(!$isRevenueOnly && $txnType !== 'income')
            <div class="rpt-card relative overflow-hidden bg-white rounded-2xl border border-rose-100 shadow-sm p-5 flex items-center gap-4">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-rose-400 to-pink-500 rounded-l-2xl"></div>
                <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-rose-400 to-pink-500 text-white flex items-center justify-center shrink-0 shadow-lg shadow-rose-400/30 ml-1" style="width:52px;height:52px;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">ລາຍຈ່າຍລວມ</p>
                    <p class="text-2xl font-extrabold text-rose-600 leading-none tracking-tight">
                        {{ number_format($totalExpense, 0) }}
                        <span class="text-sm font-semibold text-gray-400 ml-1">₭</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Total Expense</p>
                </div>
                <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-rose-50 opacity-60"></div>
            </div>

            {{-- Net Balance Card --}}
            @if($txnType === 'all')
            <div class="rpt-card relative overflow-hidden bg-white rounded-2xl border {{ $netBalance>=0 ? 'border-indigo-100' : 'border-rose-100' }} shadow-sm p-5 flex items-center gap-4">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b {{ $netBalance>=0 ? 'from-indigo-400 to-violet-500' : 'from-rose-400 to-pink-500' }} rounded-l-2xl"></div>
                <div class="w-13 h-13 rounded-2xl bg-gradient-to-br {{ $netBalance>=0 ? 'from-indigo-500 to-violet-600 shadow-indigo-400/30' : 'from-rose-400 to-pink-500 shadow-rose-400/30' }} text-white flex items-center justify-center shrink-0 shadow-lg ml-1" style="width:52px;height:52px;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">ຍອດດຸ່ນດ່ຽງ</p>
                    <p class="text-2xl font-extrabold {{ $netBalance>=0 ? 'text-indigo-600' : 'text-rose-600' }} leading-none tracking-tight">
                        {{ $netBalance<0 ? '-' : '' }}{{ number_format(abs($netBalance), 0) }}
                        <span class="text-sm font-semibold text-gray-400 ml-1">₭</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Net Balance</p>
                </div>
                <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full {{ $netBalance>=0 ? 'bg-indigo-50' : 'bg-rose-50' }} opacity-60"></div>
            </div>
            @endif
            @endif
        </div>

        {{-- ── Summary Chart ── --}}
        @php
            $chartLabels = [];
            $chartIncome = [];
            $chartExpense = [];
            $grouped = collect($ledger)->groupBy(function($item) use ($type) {
                return \Carbon\Carbon::parse($item->date)->format($type === 'yearly' ? 'M Y' : 'd M Y');
            });
            foreach($grouped as $label => $items) {
                $chartLabels[] = $label;
                $chartIncome[] = $items->sum('amount_in');
                $chartExpense[] = $items->sum('amount_out');
            }
        @endphp

        @if(count($chartLabels) > 0)
        <div class="rpt-card bg-white rounded-2xl border border-gray-100 shadow-sm p-5 no-print" style="animation-delay: 0.25s;">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-gray-800">ກຣາບສະຫຼຸບການເຄື່ອນໄຫວ (Summary Chart)</h3>
                    </div>
                </div>
            </div>
            <div style="height: 220px; width: 100%;">
                <canvas id="summaryChart"></canvas>
            </div>
        </div>
        @endif

        {{-- ── Ledger Table ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            {{-- Card header --}}
            <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-50 bg-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-indigo-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800 tracking-tight">ລາຍການເຄື່ອນໄຫວ (Ledger)</h3>
                        <p class="text-xs font-semibold text-gray-400 mt-0.5">ປະຫວັດທຸລະກຳທາງການເງິນ ແລະ ຍອດດຸ່ນດ່ຽງສະສົມ</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-gray-50 text-gray-500 border border-gray-100 shrink-0">
                    {{ $ledger->count() }} ລາຍການ
                </span>
            </div>

            <div class="overflow-x-auto touch-pan-x" style="max-height: 600px;">
                <table class="w-full text-left border-collapse" style="min-width:58rem;">
                    <thead>
                        <tr>
                            <th class="sticky top-0 z-10 bg-white py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100">ວັນທີ</th>
                            <th class="sticky top-0 z-10 bg-white py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100">ເລກທີ (ໃບບິນ)</th>
                            <th class="sticky top-0 z-10 bg-white py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100">ພາກສ່ວນ</th>
                            <th class="sticky top-0 z-10 bg-white py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100">ປະເພດ</th>
                            <th class="sticky top-0 z-10 bg-white py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100">ລາຍລະອຽດ</th>
                            <th class="sticky top-0 z-10 bg-white py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100 text-center">ຊ່ອງທາງ</th>
                            <th class="sticky top-0 z-10 bg-white py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100 text-right">ຍອດ (₭)</th>
                            <th class="sticky top-0 z-10 bg-white py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100 text-right">ດຸ່ນດ່ຽງ (₭)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php $balance = 0; @endphp
                        @forelse ($ledger as $item)
                            @php
                                $balance += ($item->amount_in - $item->amount_out);
                                $isIncome = $item->amount_in > 0;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 font-mono text-sm text-gray-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                                </td>
                                <td class="py-4 px-6 font-mono text-sm font-bold text-gray-700 whitespace-nowrap">
                                    {{ $item->payment_code ?: '—' }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if($item->department)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-extrabold bg-indigo-50 text-indigo-600">
                                            {{ $item->department }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-extrabold text-gray-800 text-sm">
                                        {{ $item->item_name ?? $item->category ?? '—' }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-500 max-w-[200px]">
                                    @if($item->desc)
                                        <span class="line-clamp-2" title="{{ $item->desc }}">{{ $item->desc }}</span>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    @if($item->payment_method === 'cash')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-extrabold bg-amber-50 text-amber-600">
                                            ເງິນສົດ
                                        </span>
                                    @elseif($item->payment_method === 'transfer')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-extrabold bg-cyan-50 text-cyan-600">
                                            ໂອນເຂົ້າ
                                        </span>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    @if($item->amount_in > 0)
                                        <span class="font-extrabold text-emerald-600 text-sm">
                                            + {{ number_format($item->amount_in, 0) }}
                                        </span>
                                    @elseif($item->amount_out > 0)
                                        <span class="font-extrabold text-rose-500 text-sm">
                                            - {{ number_format($item->amount_out, 0) }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 font-bold">—</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <span class="text-sm font-extrabold {{ $balance >= 0 ? 'text-gray-800' : 'text-rose-600' }}">
                                        {{ number_format($balance, 0) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16">
                                    <div class="flex flex-col items-center justify-center text-center gap-3">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H3m18 0h-2a4 4 0 00-4 4v2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 font-bold text-sm">ບໍ່ມີຂໍ້ມູນທຸລະກຳ</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if($ledger->count() > 0)
                    <tfoot>
                        <tr class="bg-gray-50 border-t border-gray-100">
                            <td colspan="5" class="py-4 px-6 text-sm font-extrabold text-gray-500 text-right">
                                ລວມຍອດດຸ່ນດ່ຽງ (Grand Total)
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap text-sm font-extrabold text-gray-800">
                                {{ number_format($totalIncome - $totalExpense, 0) }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>{{-- end no-print --}}

    {{-- ═══════════════════ PRINT VIEW ═══════════════════ --}}
    <div class="print-only" style="font-family:'Noto Sans Lao','Phetsarath OT',sans-serif; color:#000;">
        @php
            $userRole = auth()->user()->role?->role_name ?? '';
        @endphp
        
        @if($budgetReport && ($txnType === 'expense' || (isset($isAccountant) && $isAccountant) || $userRole === 'accountant'))
            @include('reports.partials.budget-expense-print', [
                'report' => $budgetReport,
                'type' => $type,
                'date' => $date,
                'month' => $month,
                'year' => $year,
                'selectedYear' => $budgetReport['selectedYear'],
                'selectedAccountId' => $selectedAccountId ?? $budgetReport['account']?->id,
            ])
        @elseif($txnType === 'income' || $userRole === 'revenue_officer')
            @include('reports.partials.revenue-print')
        @else
            @php
                if ($txnType === 'expense' || $userRole === 'accountant') {
                    $slipTitle = 'ໃບບິນຈ່າຍເງິນ';
                    $mainTitle = 'ລາຍງານລາຍຈ່າຍ';
                } elseif ($txnType === 'income' || $userRole === 'revenue_officer') {
                    $slipTitle = 'ໃບບິນຮັບເງິນ';
                    $mainTitle = 'ລາຍງານລາຍຮັບ';
                } else {
                    $slipTitle = 'ລາຍງານລາຍຮັບ-ລາຍຈ່າຍ';
                    $mainTitle = 'ລາຍງານລາຍຮັບ-ລາຍຈ່າຍ';
                }
            @endphp
            <div style="text-align: center; font-size: 10px; font-weight: bold; margin-bottom: 12px; text-decoration: underline;">
                {{ $slipTitle }}
            </div>
            <div style="text-align: center; margin-bottom: 20px;">
                <h1 style="font-size: 14px; font-weight: 800; margin: 0;">
                    {{ $mainTitle }}
                </h1>
            </div>
            {{-- fallback ledger print for combined --}}
            @include('reports.partials.ledger-print', [
                'ledger' => $ledger,
                'txnType' => $txnType,
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
                'type' => $type,
                'date' => $date,
            ])
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const el = document.getElementById('summaryChart');
        if(!el) return;
        const ctx = el.getContext('2d');
        const labels = @json($chartLabels ?? []);
        const income = @json($chartIncome ?? []);
        const expense = @json($chartExpense ?? []);

        // Only show datasets that have data
        const datasets = [];
        if(income.some(v => v > 0)) {
            datasets.push({
                label: 'ລາຍຮັບ (Income)',
                data: income,
                backgroundColor: 'rgba(16, 185, 129, 0.8)', // Emerald
                borderRadius: 4,
                maxBarThickness: 32
            });
        }
        if(expense.some(v => v > 0)) {
            datasets.push({
                label: 'ລາຍຈ່າຍ (Expense)',
                data: expense,
                backgroundColor: 'rgba(244, 63, 94, 0.8)', // Rose
                borderRadius: 4,
                maxBarThickness: 32
            });
        }

        new Chart(ctx, {
            type: 'bar',
            data: { labels, datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 8, font: { family: "'Noto Sans Lao', sans-serif", weight: 'bold' } } },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { family: "'Noto Sans Lao', sans-serif" },
                        bodyFont: { family: "'Noto Sans Lao', sans-serif" },
                        callbacks: {
                            label: function(context) {
                                let val = context.raw || 0;
                                return context.dataset.label + ': ' + val.toLocaleString() + ' ₭';
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { 
                        border: { display: false },
                        ticks: {
                            callback: function(v) { return v >= 1000 ? (v/1000)+'K' : v; },
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    });
    </script>
</x-app-layout>
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
            body * { visibility: hidden !important; display: revert; }
            .print-only {
                display: block !important;
                visibility: visible !important;
                position: absolute !important;
                top: 0 !important; left: 0 !important;
                width: 100% !important;
                background: white !important;
                padding: 12mm 18mm !important;
                box-sizing: border-box !important;
                z-index: 99999 !important;
                font-family: 'Noto Sans Lao', 'Phetsarath OT', sans-serif !important;
            }
            .print-only * { visibility: visible !important; color: #000 !important; }
            body { background: white !important; margin: 0 !important; }
            .p-tbl { width: 100%; border-collapse: collapse; font-size: 10px; margin-top: 12px; }
            .p-tbl th, .p-tbl td { border: 1px solid #000 !important; padding: 6px 8px !important; text-align: left; }
            .p-tbl thead th { background: #f8f8f8 !important; font-weight: bold !important; font-size: 9.5px; }
            .p-tbl tfoot td { background: #f0f0f0 !important; font-weight: bold !important; }
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
                        @foreach(\App\Models\Department::all() as $dept)
                            <option value="{{ $dept->id }}" {{ request('department_id')==$dept->id ? 'selected' : '' }}>{{ $dept->department_name }}</option>
                        @endforeach
                    </select>
                </div>

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

        {{-- ── Ledger Table ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Card header --}}
            <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 bg-gray-50/40">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-indigo-600/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-gray-800">ລາຍການເຄື່ອນໄຫວ (Ledger)</h3>
                        <p class="text-xs text-gray-400 leading-none mt-0.5">ປະຫວັດທຸລະກຳທາງການເງິນ ແລະ ຍອດດຸ່ນດ່ຽງສະສົມ</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 shrink-0">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    {{ $ledger->count() }} ລາຍການ
                </span>
            </div>

            <div class="overflow-x-auto touch-pan-x">
                <table class="w-full text-left border-collapse" style="min-width:58rem;">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="py-3 px-4 text-[0.65rem] font-extrabold text-gray-400 uppercase tracking-widest text-center" style="width:48px;">#</th>
                            <th class="py-3 px-4 text-[0.65rem] font-extrabold text-gray-400 uppercase tracking-widest" style="width:200px;">ຊື່ລາຍການ</th>
                            <th class="py-3 px-4 text-[0.65rem] font-extrabold text-gray-400 uppercase tracking-widest">ລາຍລະອຽດ</th>
                            <th class="py-3 px-4 text-[0.65rem] font-extrabold text-gray-400 uppercase tracking-widest" style="width:130px;">ໝວດ</th>
                            <th class="py-3 px-4 text-[0.65rem] font-extrabold text-gray-400 uppercase tracking-widest text-center" style="width:105px;">ວັນທີ</th>
                            @if($txnType !== 'expense')
                            <th class="py-3 px-4 text-[0.65rem] font-extrabold text-gray-400 uppercase tracking-widest text-right" style="width:115px;">ລາຍຮັບ (₭)</th>
                            @endif
                            @if($txnType !== 'income')
                            <th class="py-3 px-4 text-[0.65rem] font-extrabold text-gray-400 uppercase tracking-widest text-right" style="width:115px;">ລາຍຈ່າຍ (₭)</th>
                            @endif
                            <th class="py-3 px-4 text-[0.65rem] font-extrabold text-gray-400 uppercase tracking-widest text-right" style="width:125px;">ດຸ່ນດ່ຽງ (₭)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php $balance = 0; @endphp
                        @forelse ($ledger as $i => $item)
                            @php
                                $balance += ($item->amount_in - $item->amount_out);
                                $isIncome = $item->amount_in > 0;
                            @endphp
                            <tr class="rpt-row group">
                                {{-- Row type indicator --}}
                                <td class="py-3.5 px-4 text-center relative">
                                    <div class="absolute inset-y-0 left-0 w-0.5 {{ $isIncome ? 'bg-emerald-400' : 'bg-rose-400' }} opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <span class="text-xs font-bold text-gray-300">{{ $i + 1 }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-sm font-bold text-gray-800 group-hover:text-indigo-700 transition-colors leading-tight">
                                            {{ $item->item_name ?? '—' }}
                                        </span>
                                        @if($item->department)
                                            <span class="inline-flex items-center self-start px-2 py-0.5 rounded-md text-[0.6rem] font-bold bg-violet-50 text-violet-600 border border-violet-100">
                                                {{ $item->department }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-sm text-gray-500 max-w-[180px]">
                                    <span class="line-clamp-2">{{ $item->desc ?? '—' }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($item->category)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-600">
                                            {{ $item->category }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-sm">—</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-500 bg-gray-50 border border-gray-100 px-2.5 py-1 rounded-lg">
                                        {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                                    </span>
                                </td>
                                @if($txnType !== 'expense')
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    @if($item->amount_in > 0)
                                        <span class="inline-flex items-center justify-end gap-1 font-extrabold text-sm text-emerald-600">
                                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/></svg>
                                            {{ number_format($item->amount_in, 0) }}
                                        </span>
                                    @else
                                        <span class="text-gray-200 text-sm font-bold">—</span>
                                    @endif
                                </td>
                                @endif
                                @if($txnType !== 'income')
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    @if($item->amount_out > 0)
                                        <span class="inline-flex items-center justify-end gap-1 font-extrabold text-sm text-rose-500">
                                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/></svg>
                                            {{ number_format($item->amount_out, 0) }}
                                        </span>
                                    @else
                                        <span class="text-gray-200 text-sm font-bold">—</span>
                                    @endif
                                </td>
                                @endif
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <span class="text-sm font-extrabold {{ $balance >= 0 ? 'text-indigo-600' : 'text-rose-600' }}">
                                        {{ number_format($balance, 0) }} ₭
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 5 + ($txnType !== 'expense' ? 1 : 0) + ($txnType !== 'income' ? 1 : 0) + 1 }}" class="py-16">
                                    <div class="flex flex-col items-center justify-center text-center gap-3">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-300">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2a4 4 0 00-4-4H3m18 0h-2a4 4 0 00-4 4v2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-gray-600 font-bold text-sm">ບໍ່ມີຂໍ້ມູນທຸລະກຳ</p>
                                            <p class="text-xs text-gray-400 mt-0.5">ບໍ່ພົບລາຍການໃນຊ່ວງເວລາທີ່ເລືອກ</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if($ledger->count() > 0)
                    <tfoot>
                        <tr class="bg-gradient-to-r from-indigo-50 to-violet-50 border-t-2 border-indigo-100">
                            <td colspan="5" class="py-4 px-4 text-sm font-extrabold text-indigo-700 text-center tracking-wide">
                                ລວມທັງໝົດ (Grand Total)
                            </td>
                            @if($txnType !== 'expense')
                            <td class="py-4 px-4 text-right whitespace-nowrap text-sm font-extrabold text-emerald-600">
                                {{ number_format($totalIncome, 0) }} ₭
                            </td>
                            @endif
                            @if($txnType !== 'income')
                            <td class="py-4 px-4 text-right whitespace-nowrap text-sm font-extrabold text-rose-600">
                                {{ number_format($totalExpense, 0) }} ₭
                            </td>
                            @endif
                            <td class="py-4 px-4 text-right whitespace-nowrap text-sm font-extrabold text-indigo-700">
                                {{ number_format($totalIncome - $totalExpense, 0) }} ₭
                            </td>
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
            $userRole = auth()->user()->role?->role_name;
            if ($txnType === 'income') {
                $slipTitle = 'ໃບບິນຮັບເງິນ';
            } elseif ($txnType === 'expense') {
                $slipTitle = 'ໃບບິນຈ່າຍເງິນ';
            } else {
                $slipTitle = ($userRole === 'revenue_officer') ? 'ໃບບິນຮັບເງິນ' : (($userRole === 'accountant') ? 'ໃບບິນຈ່າຍເງິນ' : 'ລາຍງານລາຍຮັບ-ລາຍຈ່າຍ');
            }
        @endphp

        <div style="text-align: center; font-size: 10px; font-weight: bold; margin-bottom: 12px; text-decoration: underline; text-underline-offset: 2px;">
            {{ $slipTitle }}
        </div>
        <div style="text-align: center; margin-bottom: 20px;">
            <h1 style="font-size: 14px; font-weight: 800; color: #000; margin: 0 0 4px; line-height: 1.4;">
                {{ $txnType === 'income' ? 'ລາຍງານສະຫຼຸບລາຍຮັບ' : ($txnType === 'expense' ? 'ລາຍງານສະຫຼຸບລາຍຈ່າຍ' : 'ລາຍງານລາຍຮັບ-ລາຍຈ່າຍ') }}
            </h1>
            <p style="font-size: 10px; color: #000; margin: 0; font-weight: 600;">
                ປະເພດລາຍງານ: {{ $type === 'daily' ? 'ປະຈຳວັນ' : ($type === 'monthly' ? 'ປະຈຳເດືອນ' : 'ປະຈຳປີ') }}
                &nbsp;•&nbsp;
                ຊ່ວງເວລາ:
                @if($type === 'daily') {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}
                @elseif($type === 'monthly') {{ \Carbon\Carbon::parse($month . '-01')->format('m-Y') }}
                @else {{ $year }}
                @endif
            </p>
        </div>

        @php
            $deptId  = request('department_id');
            $deptObj = $deptId ? \App\Models\Department::find($deptId) : null;
            $deptName = $deptObj ? $deptObj->displayName() : 'ພາກວິຊາວິທະຍາສາດຄອມພິວເຕີ';
            if ($deptName === 'Computer') { $deptName = 'ພາກວິຊາວິທະຍາສາດຄອມພິວເຕີ'; }
        @endphp

        <div style="display:flex; justify-content:space-between; align-items:flex-start; font-size:11px; color:#000; margin-bottom:14px; line-height:1.6;">
            <div style="width:35%;">
                <p style="margin:0;">ຈຳນວນລາຍການ: <b>{{ $ledger->count() }}</b></p>
                <p style="margin:4px 0 0;">ປະເພດ: <b>{{ $txnType === 'income' ? 'ລາຍຮັບ' : ($txnType === 'expense' ? 'ລາຍຈ່າຍ' : 'ທັງໝົດ') }}</b></p>
            </div>
            <div style="width:30%; text-align:center; font-weight:bold; padding-top:6px;">{{ $deptName }}</div>
            <div style="width:35%; text-align:right;">
                @if($txnType === 'expense')
                    <p style="margin:0;">ລາຍຈ່າຍລວມ: <b>{{ number_format($totalExpense, 0, ',', '.') }} ₭</b></p>
                @elseif($txnType === 'income')
                    <p style="margin:0;">ລາຍຮັບລວມ: <b>{{ number_format($totalIncome, 0, ',', '.') }} ₭</b></p>
                @else
                    <p style="margin:0;">ລາຍຮັບລວມ: <b>{{ number_format($totalIncome, 0, ',', '.') }} ₭</b></p>
                    <p style="margin:4px 0 0;">ລາຍຈ່າຍລວມ: <b>{{ number_format($totalExpense, 0, ',', '.') }} ₭</b></p>
                    <p style="margin:4px 0 0;">ຍອດຄົງເຫຼືອ: <b>{{ number_format($totalIncome - $totalExpense, 0, ',', '.') }} ₭</b></p>
                @endif
            </div>
        </div>

        <table class="p-tbl">
            <thead>
                <tr style="font-weight:bold; background:#f8f8f8;">
                    <th style="width:40px; text-align:center; border:1px solid #000;">ລຳດັບ</th>
                    <th style="text-align:left; border:1px solid #000;">ຊື່ລາຍການ</th>
                    <th style="text-align:left; border:1px solid #000;">ລາຍລະອຽດ</th>
                    <th style="width:95px; text-align:left; border:1px solid #000;">ໝວດ</th>
                    <th style="width:85px; text-align:center; border:1px solid #000;">ວັນທີ</th>
                    @if($txnType !== 'expense')
                        <th style="width:100px; text-align:right; border:1px solid #000;">ລາຍຮັບ</th>
                    @endif
                    @if($txnType !== 'income')
                        <th style="width:100px; text-align:right; border:1px solid #000;">ລາຍຈ່າຍ</th>
                    @endif
                    <th style="width:105px; text-align:right; border:1px solid #000;">ດຸ່ນດ່ຽງ</th>
                </tr>
            </thead>
            <tbody>
                @php $pb = 0; @endphp
                @foreach($ledger as $i => $item)
                    @php $pb += ($item->amount_in - $item->amount_out); @endphp
                    <tr>
                        <td style="text-align:center; border:1px solid #000;">{{ $i + 1 }}</td>
                        <td style="text-align:left; font-weight:bold; border:1px solid #000;">
                            {{ $item->item_name ?? $item->desc ?? '—' }}
                            @if($item->department)
                                <span style="font-size:8px; font-weight:bold;">({{ $item->department }})</span>
                            @endif
                        </td>
                        <td style="text-align:left; border:1px solid #000;">{{ $item->desc ?? '—' }}</td>
                        <td style="text-align:left; border:1px solid #000;">{{ $item->category ?? '—' }}</td>
                        <td style="text-align:center; border:1px solid #000;">{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                        @if($txnType !== 'expense')
                            <td style="text-align:right; font-weight:bold; border:1px solid #000;">{{ $item->amount_in > 0 ? number_format($item->amount_in, 0, ',', '.') : '' }}</td>
                        @endif
                        @if($txnType !== 'income')
                            <td style="text-align:right; font-weight:bold; border:1px solid #000;">{{ $item->amount_out > 0 ? number_format($item->amount_out, 0, ',', '.') : '' }}</td>
                        @endif
                        <td style="text-align:right; font-weight:bold; border:1px solid #000;">{{ number_format($pb, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="font-weight:bold; background:#f0f0f0;">
                    <td colspan="5" style="text-align:center; font-weight:bold; border:1px solid #000;">ລວມທັງໝົດ</td>
                    @if($txnType !== 'expense')
                        <td style="text-align:right; font-weight:bold; border:1px solid #000;">{{ number_format($totalIncome, 0, ',', '.') }}</td>
                    @endif
                    @if($txnType !== 'income')
                        <td style="text-align:right; font-weight:bold; border:1px solid #000;">{{ number_format($totalExpense, 0, ',', '.') }}</td>
                    @endif
                    <td style="text-align:right; font-weight:bold; border:1px solid #000;">{{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        {{-- Signature --}}
        @php
            $sigDate = $type === 'daily' ? \Carbon\Carbon::parse($date)->format('d-m-Y') : now()->format('d-m-Y');
        @endphp
        <div style="display:flex; justify-content:space-between; margin-top:45px; font-size:11px; line-height:1.6; page-break-inside:avoid;">
            <div style="width:45%; text-align:left; font-weight:bold; padding-left:10px;">
                ຫົວໜ້າພະແນກການເງິນ-ຊັບສິນ
            </div>
            <div style="width:45%; text-align:right; font-weight:bold; padding-right:10px; display:flex; flex-direction:column; align-items:flex-end;">
                <p style="margin:0; padding-right:15px;">ວັນທີ: {{ $sigDate }}</p>
                <p style="margin:6px 0 0; padding-right:25px;">ນາຍບັນຊີ</p>
            </div>
        </div>
    </div>
</x-app-layout>
@php
    $userRole = auth()->user()->role?->role_name;
    $isRevenueOnly = $userRole === 'revenue_officer';
    $isAccountant  = $userRole === 'accountant';
    $txnType = request()->get('txn_type', 'all');
    if ($isRevenueOnly) { $txnType = 'income'; }
    if ($isAccountant) { $txnType = 'expense'; }

    // Theme variables
    $themeColor = 'indigo-600';
    $themeBg = 'indigo-600';
    $themeShadow = 'indigo-500/30';
    $themeHover = 'indigo-700';
    $themeGrad = 'from-indigo-500 to-violet-600';

    if ($txnType === 'income' || $isRevenueOnly) {
        $themeColor = 'indigo-600';
        $themeBg = 'indigo-600';
        $themeShadow = 'indigo-500/30';
        $themeHover = 'indigo-700';
        $themeGrad = 'from-indigo-500 to-violet-600';
    } elseif ($txnType === 'expense' || $isAccountant) {
        $themeColor = 'rose-600';
        $themeBg = 'rose-600';
        $themeShadow = 'rose-500/30';
        $themeHover = 'rose-700';
        $themeGrad = 'from-rose-500 to-pink-600';
    }
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full min-w-0">
            <div class="flex flex-col gap-1 min-w-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $themeGrad }} text-white flex items-center justify-center shrink-0 shadow-lg shadow-{{ $themeShadow }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H3m18 0h-2a4 4 0 00-4 4v2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                            Dashboard {{ $isRevenueOnly ? 'ລາຍຮັບ' : ($isAccountant ? 'ລາຍຈ່າຍ' : 'ລາຍຮັບ-ລາຍຈ່າຍ') }}
                        </h2>
                        <p class="text-xs font-medium text-gray-400 mt-0.5">ບົດສະຫຼຸບ ແລະ ປະຫວັດການເຄື່ອນໄຫວດ້ານການເງິນ</p>
                    </div>
                </div>
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

        /* Bento Box Core Styles */
        .bento-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.02);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .bento-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 48px rgba(0,0,0,0.04);
        }

        /* Filter Bar */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 20px;
            padding: 16px 24px;
        }
        .filter-group { display: flex; flex-direction: column; }
        .filter-group label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .filter-input {
            background: #f8fafc;
            border: 2px solid transparent;
            border-radius: 14px;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            outline: none;
            transition: 0.2s;
            height: 44px;
            font-family: inherit;
        }
        @php
            $focusBorder = '#818cf8';
            $focusRing = 'rgba(99,102,241,0.1)';
            $searchGrad = 'linear-gradient(135deg, #6366f1, #8b5cf6)';
            $searchShadow = 'rgba(99,102,241,0.3)';
            $tabActiveBg = '#1e293b';
            $tabActiveShadow = 'rgba(0,0,0,0.15)';

            if ($txnType === 'income' || $isRevenueOnly) {
                $focusBorder = '#818cf8';
                $focusRing = 'rgba(99,102,241,0.1)';
                $searchGrad = 'linear-gradient(135deg, #6366f1, #8b5cf6)';
                $searchShadow = 'rgba(99,102,241,0.3)';
                $tabActiveBg = '#4f46e5';
                $tabActiveShadow = 'rgba(79,70,229,0.3)';
            } elseif ($txnType === 'expense' || $isAccountant) {
                $focusBorder = '#fb7185';
                $focusRing = 'rgba(244,63,94,0.1)';
                $searchGrad = 'linear-gradient(135deg, #f43f5e, #e11d48)';
                $searchShadow = 'rgba(244,63,94,0.3)';
                $tabActiveBg = '#e11d48';
                $tabActiveShadow = 'rgba(225,29,72,0.3)';
            }
        @endphp

        .filter-input:focus { border-color: {{ $focusBorder }}; background: #fff; box-shadow: 0 0 0 4px {{ $focusRing }}; }

        .btn-search {
            height: 44px;
            background: {{ $searchGrad }};
            color: #fff;
            border: none;
            border-radius: 14px;
            padding: 0 24px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px {{ $searchShadow }};
            transition: all 0.2s;
            font-family: inherit;
        }
        .btn-search:hover { opacity: 0.9; transform: translateY(-1px); }

        /* KPI Grids */
        .kpi-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            margin-top: 24px;
        }
        @media(min-width: 1024px) { .kpi-grid { grid-template-columns: repeat(3, 1fr); } }

        /* KPI Card Internals */
        .kpi-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .kpi-header-left { display: flex; align-items: center; gap: 14px; }
        .kpi-icon {
            width: 52px; height: 52px; border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .kpi-title { font-size: 20px; font-weight: 800; color: #1e293b; margin:0; line-height:1.2; }
        .kpi-subtitle { font-size: 13px; font-weight: 800; color: #64748b; text-transform: uppercase; margin:0 0 4px 0; }
        .kpi-tag { padding: 6px 14px; border-radius: 99px; font-size: 12px; font-weight: 700; }

        .kpi-amount-label { font-size: 14px; font-weight: 800; color: #64748b; margin-bottom: 8px; display: block; }
        .kpi-amount { font-size: 32px; font-weight: 900; color: #0f172a; line-height: 1; margin:0 0 24px 0; }
        .kpi-amount span { font-size: 16px; color: #64748b; font-weight: 800; margin-left: 4px; }

        .kpi-breakdown { background: #f8fafc; border-radius: 20px; padding: 16px; }
        .kpi-progress { height: 8px; background: #e2e8f0; border-radius: 99px; overflow: hidden; display: flex; margin-bottom: 14px; }
        .kpi-progress-bar { height: 100%; transition: width 1s ease; }
        .kpi-split { display: flex; justify-content: space-between; font-size: 14px; font-weight: 800; color: #475569; }
        .kpi-split-item { display: flex; align-items: center; gap: 6px; }
        .kpi-split-item strong { color: #1e293b; font-weight: 800; }
        .dot { width: 10px; height: 10px; border-radius: 50%; }

        /* Gradients & Colors */
        .grad-indigo { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .grad-rose { background: linear-gradient(135deg, #f43f5e, #e11d48); }
        .grad-amber { background: linear-gradient(135deg, #f59e0b, #f97316); }
        .grad-cyan { background: linear-gradient(135deg, #0ea5e9, #2dd4bf); }

        .tag-indigo { background: #e0e7ff; color: #4338ca; }
        .tag-rose { background: #ffe4e6; color: #9f1239; }

        .theme-dept-tag {
            background-color: {{ $txnType === 'expense' ? '#ffe4e6' : '#e0e7ff' }} !important;
            color: {{ $txnType === 'expense' ? '#9f1239' : '#4338ca' }} !important;
        }

        /* Tabs */
        .tabs-container { display: flex; justify-content: center; margin: 32px 0; }
        .tabs-wrap { display: inline-flex; background: #fff; padding: 8px; border-radius: 99px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #f3f4f6; gap: 4px; }
        .tab-btn { padding: 12px 28px; border-radius: 99px; font-size: 14px; font-weight: 700; color: #64748b; background: transparent; border: none; cursor: pointer; transition: 0.2s; font-family: inherit; }
        .tab-btn:hover { color: #1e293b; background: #f8fafc; }
        .tab-btn.active { background: {{ $tabActiveBg }}; color: #fff; box-shadow: 0 4px 12px {{ $tabActiveShadow }}; }

        /* Overview Layout */
        .overview-grid { display: grid; grid-template-columns: 1fr; gap: 24px; }
        @media(min-width: 1024px) {
            .overview-grid { grid-template-columns: repeat(3, 1fr); }
            .col-span-2 { grid-column: span 2; }
        }

        .chart-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .chart-title { font-size: 18px; font-weight: 800; color: #1e293b; margin:0 0 4px 0;}
        .chart-subtitle { font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin:0;}

        .stat-list { display: flex; flex-direction: column; gap: 16px; }
        .stat-item { display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; }
        .stat-item:last-child { border-bottom: none; padding-bottom: 0; }
        .stat-label { font-size: 14px; font-weight: 700; color: #64748b; }
        .stat-value { font-size: 16px; font-weight: 900; color: #1e293b; }
        .stat-value.amber { color: #d97706; }
        .stat-value.cyan { color: #0891b2; }
        .stat-value.indigo { color: #4f46e5; }
        .stat-value.rose { color: #e11d48; }
    </style>

    {{-- ═══════════════════ SCREEN VIEW ═══════════════════ --}}
    <div class="space-y-5 no-print">

        {{-- ── Filter Bar ── --}}
        <div class="bento-card filter-bar">
            <form method="GET" action="{{ route('reports.index') }}" style="display:flex; flex-wrap:wrap; align-items:flex-end; gap:20px; width:100%;">

                {{-- Type pill toggle --}}
                <div class="filter-group">
                    <label>ປະເພດລາຍງານ</label>
                    <div class="flex bg-gray-100 rounded-xl p-1 gap-0.5 h-11 items-center">
                        @foreach(['daily'=>'ວັນ','monthly'=>'ເດືອນ','yearly'=>'ປີ'] as $t => $label)
                            <a href="{{ route('reports.index', array_merge(request()->except('type'), ['type'=>$t])) }}"
                               class="px-4 py-2 rounded-lg text-xs font-bold transition-all duration-150 whitespace-nowrap {{ $type===$t ? 'bg-white text-' . $themeColor . ' shadow-sm' : 'text-gray-400 hover:text-gray-700' }}">
                               {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <input type="hidden" name="type" value="{{ $type }}">

                {{-- Transaction Type Toggle --}}
                @if(!$isRevenueOnly && !$isAccountant)
                <div class="filter-group">
                    <label>ສະແດງທຸລະກຳ</label>
                    <div class="flex bg-gray-100 rounded-xl p-1 gap-0.5 h-11 items-center">
                        @foreach(['all'=>'ທັງໝົດ','income'=>'ລາຍຮັບ','expense'=>'ລາຍຈ່າຍ'] as $tv => $tl)
                            <a href="{{ route('reports.index', array_merge(request()->all(), ['txn_type'=>$tv])) }}"
                               class="px-4 py-2 rounded-lg text-xs font-bold transition-all duration-150 whitespace-nowrap {{ $txnType===$tv ? 'bg-white text-' . $themeColor . ' shadow-sm' : 'text-gray-400 hover:text-gray-700' }}">
                               {{ $tl }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @else
                    <input type="hidden" name="txn_type" value="{{ $isRevenueOnly ? 'income' : 'expense' }}">
                @endif

                {{-- Date filter --}}
                <div class="filter-group">
                    <label>
                        {{ $type==='daily' ? 'ວັນທີ' : ($type==='monthly' ? 'ເດືອນ' : 'ປີ') }}
                    </label>
                    @if($type==='daily')
                        <input type="date" name="date" value="{{ $date }}" class="filter-input min-w-[160px]">
                    @elseif($type==='monthly')
                        <input type="month" name="month" value="{{ $month }}" class="filter-input min-w-[160px]">
                    @else
                        <select name="year" class="filter-input min-w-[120px] cursor-pointer">
                            @for($y = date('Y')-5; $y <= date('Y')+2; $y++)
                                <option value="{{ $y }}" {{ $year==$y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    @endif
                </div>

                {{-- Department --}}
                <div class="filter-group min-w-[200px]">
                    <label>ພາກສ່ວນ</label>
                    <select name="department_id" class="filter-input cursor-pointer">
                        <option value="">ທັງໝົດ</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department_id')==$dept->id ? 'selected' : '' }}>{{ $dept->department_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Account (if not revenue only) --}}
                @if(!$isRevenueOnly && $txnType !== 'income')
                <div class="filter-group min-w-[220px] flex-1">
                    <label>ໝວດບັນຊີ (ພิມ)</label>
                    <select name="account_id" class="filter-input cursor-pointer">
                        <option value="">ອັດຕະໂນມັດ (ຈາກລາຍການ)</option>
                        @foreach($expenseAccounts as $acc)
                            <option value="{{ $acc->id }}" {{ (string) request('account_id') === (string) $acc->id ? 'selected' : '' }}>
                                {{ $acc->account_code }} — {{ $acc->account_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <button type="submit" class="btn-search shrink-0">
                    <svg style="width:18px; height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    ຄົ້ນຫາ
                </button>
            </form>
        </div>

        {{-- ── KPI Cards ── --}}
        @php
            $netBalance = $totalIncome - $totalExpense;

            // Calculate cash/transfer split for income
            $incomeCash = $incomeTransactions->where('payment_method', 'cash')->sum('amount');
            $incomeTransfer = $incomeTransactions->where('payment_method', 'transfer')->sum('amount');
            $incomeTotal = $incomeTransactions->sum('amount');
            $incomeCashPct = $incomeTotal > 0 ? round($incomeCash / $incomeTotal * 100) : 0;

            $advanceTotal = $requests->sum('requested_amount');
            $directTotal = $expenseTransactions->sum('amount');
            $expenseTotal = $totalExpense;
            $advPct = $totalExpense > 0 ? round($advanceTotal / $totalExpense * 100) : 0;

            $balPct = $totalIncome > 0 ? ($netBalance >= 0 ? min(100, round($netBalance / $totalIncome * 100)) : 0) : 0;
        @endphp

        <div class="kpi-grid">
            @if($txnType === 'all' && !$isRevenueOnly && !$isAccountant)
                {{-- Combined View: 3 cards (Total Income, Total Expense, Net Balance) --}}

                {{-- Income KPI Card --}}
                <div class="bento-card">
                    <div class="kpi-header">
                        <div class="kpi-header-left">
                            <div class="kpi-icon grad-indigo">
                                <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                            </div>
                            <div>
                                <p class="kpi-subtitle">ລວມລາຍຮັບ</p>
                                <p class="kpi-title">ລາຍຮັບລວມ</p>
                            </div>
                        </div>
                        <span class="kpi-tag tag-indigo">Total Income</span>
                    </div>
                    <span class="kpi-amount-label">ຍອດລວມຊ່ວງນີ້</span>
                    <div class="kpi-amount" style="color: #4f46e5;">{{ number_format($totalIncome, 0) }}<span>₭</span></div>

                    @if($totalIncome > 0)
                    <div class="kpi-breakdown">
                        <div class="kpi-progress">
                            <div class="kpi-progress-bar grad-amber" style="width:{{$incomeCashPct}}%"></div>
                            <div class="kpi-progress-bar grad-cyan" style="width:{{100-$incomeCashPct}}%"></div>
                        </div>
                        <div class="kpi-split">
                            <div class="kpi-split-item">
                                <div class="dot grad-amber"></div>
                                ສົດ: <strong>{{ number_format($incomeCash,0) }}</strong>
                            </div>
                            <div class="kpi-split-item">
                                <div class="dot grad-cyan"></div>
                                ໂອນ: <strong>{{ number_format($incomeTransfer,0) }}</strong>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="kpi-breakdown" style="display:flex; align-items:center; justify-content:center; height:80px; background:#f1f5f9;">
                        <span style="font-size:13px; font-weight:800; color:#94a3b8;">ຍັງບໍ່ມີຂໍ້ມູນການຮັບເງິນ</span>
                    </div>
                    @endif
                </div>

                {{-- Expense KPI Card --}}
                <div class="bento-card">
                    <div class="kpi-header">
                        <div class="kpi-header-left">
                            <div class="kpi-icon grad-rose">
                                <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                            </div>
                            <div>
                                <p class="kpi-subtitle">ລວມລາຍຈ່າຍ</p>
                                <p class="kpi-title">ລາຍຈ່າຍລວມ</p>
                            </div>
                        </div>
                        <span class="kpi-tag tag-rose">Total Expense</span>
                    </div>
                    <span class="kpi-amount-label">ຍອດລວມຊ່ວງນີ້</span>
                    <div class="kpi-amount" style="color: #f43f5e;">{{ number_format($totalExpense, 0) }}<span>₭</span></div>

                    @if($totalExpense > 0)
                    <div class="kpi-breakdown">
                        <div class="kpi-progress">
                            <div class="kpi-progress-bar grad-indigo" style="width:{{$advPct}}%"></div>
                            <div class="kpi-progress-bar grad-rose" style="width:{{100-$advPct}}%"></div>
                        </div>
                        <div class="kpi-split">
                            <div class="kpi-split-item">
                                <div class="dot grad-indigo"></div>
                                ລ່ວງໜ້າ: <strong>{{ number_format($advanceTotal,0) }}</strong>
                            </div>
                            <div class="kpi-split-item">
                                <div class="dot grad-rose"></div>
                                ຈ່າຍຕົງ: <strong>{{ number_format($directTotal,0) }}</strong>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="kpi-breakdown" style="display:flex; align-items:center; justify-content:center; height:80px; background:#f1f5f9;">
                        <span style="font-size:13px; font-weight:800; color:#94a3b8;">ຍັງບໍ່ມີຂໍ້ມູນການຈ່າຍເງິນ</span>
                    </div>
                    @endif
                </div>

                {{-- Net Balance KPI Card --}}
                <div class="bento-card">
                    <div class="kpi-header">
                        <div class="kpi-header-left">
                            <div class="kpi-icon {{ $netBalance >= 0 ? 'grad-indigo' : 'grad-rose' }}">
                                <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            <div>
                                <p class="kpi-subtitle">ຍອດດຸ່ນດ່ຽງ</p>
                                <p class="kpi-title">ດຸ່ນດ່ຽງລວມ</p>
                            </div>
                        </div>
                        <span class="kpi-tag tag-indigo">Net Balance</span>
                    </div>
                    <span class="kpi-amount-label">ຍອດຄົງເຫຼືອສະສົມ</span>
                    <div class="kpi-amount" style="color: {{ $netBalance >= 0 ? '#6366f1' : '#f43f5e' }};">{{ $netBalance < 0 ? '-' : '' }}{{ number_format(abs($netBalance), 0) }}<span>₭</span></div>

                    @if($totalIncome > 0)
                    <div class="kpi-breakdown">
                        <div class="kpi-progress">
                            <div class="kpi-progress-bar grad-indigo" style="width:{{$balPct}}%"></div>
                        </div>
                        <div class="kpi-split">
                            <div class="kpi-split-item">
                                ອັດຕາເຫຼືອສະສົມ: <strong>{{ $balPct }}%</strong>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="kpi-breakdown" style="display:flex; align-items:center; justify-content:center; height:80px; background:#f1f5f9;">
                        <span style="font-size:13px; font-weight:800; color:#94a3b8;">ບໍ່ສາມາດໄລ່ສັດສ່ວນໄດ້</span>
                    </div>
                    @endif
                </div>
            @elseif($txnType === 'income' || $isRevenueOnly)
                {{-- Income View: 3 cards (Total Income, Cash Income, Transfer Income) --}}

                {{-- Total Income Card --}}
                <div class="bento-card">
                    <div class="kpi-header">
                        <div class="kpi-header-left">
                            <div class="kpi-icon grad-indigo">
                                <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                            </div>
                            <div>
                                <p class="kpi-subtitle">ລວມລາຍຮັບ</p>
                                <p class="kpi-title">ລາຍຮັບລວມ</p>
                            </div>
                        </div>
                        <span class="kpi-tag tag-indigo">Total Income</span>
                    </div>
                    <span class="kpi-amount-label">ຍອດລວມຊ່ວງນີ້</span>
                    <div class="kpi-amount" style="color: #4f46e5;">{{ number_format($totalIncome, 0) }}<span>₭</span></div>

                    @if($totalIncome > 0)
                    <div class="kpi-breakdown">
                        <div class="kpi-progress">
                            <div class="kpi-progress-bar grad-amber" style="width:{{$incomeCashPct}}%"></div>
                            <div class="kpi-progress-bar grad-cyan" style="width:{{100-$incomeCashPct}}%"></div>
                        </div>
                        <div class="kpi-split">
                            <div class="kpi-split-item">
                                <div class="dot grad-amber"></div>
                                ສົດ: <strong>{{ number_format($incomeCash,0) }}</strong>
                            </div>
                            <div class="kpi-split-item">
                                <div class="dot grad-cyan"></div>
                                ໂອນ: <strong>{{ number_format($incomeTransfer,0) }}</strong>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="kpi-breakdown" style="display:flex; align-items:center; justify-content:center; height:80px; background:#f1f5f9;">
                        <span style="font-size:13px; font-weight:800; color:#94a3b8;">ຍັງບໍ່ມີຂໍ້ມູນການຮັບເງິນ</span>
                    </div>
                    @endif
                </div>

                {{-- Cash Income Card --}}
                <div class="bento-card">
                    <div class="kpi-header">
                        <div class="kpi-header-left">
                            <div class="kpi-icon grad-amber">
                                <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <div>
                                <p class="kpi-subtitle">ລາຍຮັບເງິນສົດ</p>
                                <p class="kpi-title">ເງິນສົດ</p>
                            </div>
                        </div>
                        <span class="kpi-tag tag-amber">Cash Payment</span>
                    </div>
                    <span class="kpi-amount-label">ຮັບເງິນສົດທັງໝົດ</span>
                    <div class="kpi-amount" style="color: #f59e0b;">{{ number_format($incomeCash, 0) }}<span>₭</span></div>

                    <div class="kpi-breakdown">
                        <div class="kpi-progress">
                            <div class="kpi-progress-bar grad-amber" style="width:{{$incomeCashPct}}%"></div>
                        </div>
                        <div class="kpi-split">
                            <div class="kpi-split-item">
                                ສັດສ່ວນລາຍຮັບ: <strong>{{ $incomeCashPct }}%</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Transfer Income Card --}}
                <div class="bento-card">
                    <div class="kpi-header">
                        <div class="kpi-header-left">
                            <div class="kpi-icon grad-cyan">
                                <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </div>
                            <div>
                                <p class="kpi-subtitle">ລາຍຮັບເງິນໂອນ</p>
                                <p class="kpi-title">ເງິນໂອນ</p>
                            </div>
                        </div>
                        <span class="kpi-tag tag-cyan">Bank Transfer</span>
                    </div>
                    <span class="kpi-amount-label">ຮັບເງິນໂອນທັງໝົດ</span>
                    <div class="kpi-amount" style="color: #0ea5e9;">{{ number_format($incomeTransfer, 0) }}<span>₭</span></div>

                    <div class="kpi-breakdown">
                        <div class="kpi-progress">
                            <div class="kpi-progress-bar grad-cyan" style="width:{{100-$incomeCashPct}}%"></div>
                        </div>
                        <div class="kpi-split">
                            <div class="kpi-split-item">
                                ສັດສ່ວນລາຍຮັບ: <strong>{{ 100 - $incomeCashPct }}%</strong>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Expense View: 3 cards (Total Expense, Advance Payments, Direct Expenses) --}}

                {{-- Total Expense Card --}}
                <div class="bento-card">
                    <div class="kpi-header">
                        <div class="kpi-header-left">
                            <div class="kpi-icon grad-rose">
                                <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                            </div>
                            <div>
                                <p class="kpi-subtitle">ລວມລາຍຈ່າຍ</p>
                                <p class="kpi-title">ລາຍຈ່າຍລວມ</p>
                            </div>
                        </div>
                        <span class="kpi-tag tag-rose">Total Expense</span>
                    </div>
                    <span class="kpi-amount-label">ຍອດລວມຊ່ວງນີ້</span>
                    <div class="kpi-amount" style="color: #f43f5e;">{{ number_format($totalExpense, 0) }}<span>₭</span></div>

                    @if($totalExpense > 0)
                    <div class="kpi-breakdown">
                        <div class="kpi-progress">
                            <div class="kpi-progress-bar grad-indigo" style="width:{{$advPct}}%"></div>
                            <div class="kpi-progress-bar grad-rose" style="width:{{100-$advPct}}%"></div>
                        </div>
                        <div class="kpi-split">
                            <div class="kpi-split-item">
                                <div class="dot grad-indigo"></div>
                                ລ່ວງໜ້າ: <strong>{{ number_format($advanceTotal,0) }}</strong>
                            </div>
                            <div class="kpi-split-item">
                                <div class="dot grad-rose"></div>
                                ຈ່າຍຕົງ: <strong>{{ number_format($directTotal,0) }}</strong>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="kpi-breakdown" style="display:flex; align-items:center; justify-content:center; height:80px; background:#f1f5f9;">
                        <span style="font-size:13px; font-weight:800; color:#94a3b8;">ຍັງບໍ່ມີຂໍ້ມູນການຈ່າຍເງິນ</span>
                    </div>
                    @endif
                </div>

                {{-- Advance Payments Card --}}
                <div class="bento-card">
                    <div class="kpi-header">
                        <div class="kpi-header-left">
                            <div class="kpi-icon grad-indigo">
                                <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="kpi-subtitle">ລາຍຈ່າຍລ່ວງໜ້າ</p>
                                <p class="kpi-title">ເບີກລ່ວງໜ້າ</p>
                            </div>
                        </div>
                        <span class="kpi-tag tag-indigo">Advance Payment</span>
                    </div>
                    <span class="kpi-amount-label">ຈ່າຍລ່ວງໜ້າທັງໝົດ</span>
                    <div class="kpi-amount" style="color: #6366f1;">{{ number_format($advanceTotal, 0) }}<span>₭</span></div>

                    <div class="kpi-breakdown">
                        <div class="kpi-progress">
                            <div class="kpi-progress-bar grad-indigo" style="width:{{$advPct}}%"></div>
                        </div>
                        <div class="kpi-split">
                            <div class="kpi-split-item">
                                ລ່ວງໜ້າ: <strong>{{ $advPct }}%</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Direct Expenses Card --}}
                <div class="bento-card">
                    <div class="kpi-header">
                        <div class="kpi-header-left">
                            <div class="kpi-icon grad-rose">
                                <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                            <div>
                                <p class="kpi-subtitle">ລາຍຈ່າຍໂດຍກົງ</p>
                                <p class="kpi-title">ຈ່າຍຕົງ</p>
                            </div>
                        </div>
                        <span class="kpi-tag tag-rose">Direct Expense</span>
                    </div>
                    <span class="kpi-amount-label">ລາຍຈ່າຍໂດຍກົງທັງໝົດ</span>
                    <div class="kpi-amount" style="color: #f43f5e;">{{ number_format($directTotal, 0) }}<span>₭</span></div>

                    <div class="kpi-breakdown">
                        <div class="kpi-progress">
                            <div class="kpi-progress-bar grad-rose" style="width:{{100-$advPct}}%"></div>
                        </div>
                        <div class="kpi-split">
                            <div class="kpi-split-item">
                                ຈ່າຍຕົງ: <strong>{{ 100 - $advPct }}%</strong>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- ── Tabs ── --}}
        <div class="tabs-container">
            <div class="tabs-wrap">
                <button class="tab-btn active" onclick="switchTab('overview', this)">ພາບລວມ (Overview)</button>
                @if(!$isRevenueOnly && $txnType !== 'income')
                    <button class="tab-btn" onclick="switchTab('accounts', this)">ແຍກຕາມໝວດບັນຊີ (Accounts)</button>
                @endif
                <button class="tab-btn" onclick="switchTab('departments', this)">ແຍກຕາມພາກສ່ວນ (Departments)</button>
                <button class="tab-btn" onclick="switchTab('ledger', this)">ລາຍການທຸລະກຳ (Transactions)</button>
            </div>
        </div>

        {{-- ── Tab Contents ── --}}

        {{-- OVERVIEW TAB --}}
        @php
            $txnsCount = $ledger->count();
            $maxInc = $incomeTransactions->max('amount') ?? 0;
            $maxExp = $expenseTransactions->max('amount') ?? 0;
            $avgInc = $incomeTransactions->avg('amount') ?? 0;
            $avgExp = $expenseTransactions->avg('amount') ?? 0;

            // Generate chart parameters
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

        <div id="tab-overview" class="space-y-6">
            <div class="overview-grid">
                {{-- Stat Summary Bento Card --}}
                <div class="bento-card">
                    <p class="chart-subtitle" style="margin-bottom:16px;">ສະຖິຕິທຸລະກຳ</p>
                    <div class="stat-list">
                        <div class="stat-item">
                            <span class="stat-label">ຈຳນວນທຸລະກຳ</span>
                            <span class="stat-value text-slate-700">{{ $txnsCount }} ລາຍການ</span>
                        </div>
                        @if($txnType !== 'expense')
                        <div class="stat-item">
                            <span class="stat-label">ຮັບສູງສຸດ / ບິນ</span>
                            <span class="stat-value indigo font-bold">{{ number_format($maxInc, 0) }} ₭</span>
                        </div>
                        @endif
                        @if(!$isRevenueOnly && $txnType !== 'income')
                        <div class="stat-item">
                            <span class="stat-label">ຈ່າຍສູງສຸດ / ບິນ</span>
                            <span class="stat-value rose font-bold">{{ number_format($maxExp, 0) }} ₭</span>
                        </div>
                        @endif
                        @if($txnType !== 'expense' && $txnsCount > 0)
                        <div class="stat-item">
                            <span class="stat-label">ຮັບສະເລ່ຍ / ບິນ</span>
                            <span class="stat-value indigo">{{ number_format($avgInc, 0) }} ₭</span>
                        </div>
                        @endif
                        @if(!$isRevenueOnly && $txnType !== 'income' && $txnsCount > 0)
                        <div class="stat-item">
                            <span class="stat-label">ຈ່າຍສະເລ່ຍ / ບິນ</span>
                            <span class="stat-value rose">{{ number_format($avgExp, 0) }} ₭</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Main Line/Bar Chart --}}
                <div class="bento-card col-span-2 flex flex-col">
                    <div class="chart-header">
                        <div>
                            <p class="chart-subtitle">ແນວໂນ້ມ</p>
                            <h3 class="chart-title">ແນວໂນ້ມລາຍຮັບ ແລະ ລາຍຈ່າຍ</h3>
                        </div>
                    </div>
                    <div style="flex:1; min-height:260px; position:relative;">
                        @if(count($chartLabels) > 0)
                            <canvas id="summaryChart"></canvas>
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400 font-bold text-sm bg-gray-50/50 rounded-xl">
                                ບໍ່ມີຂໍ້ມູນສະແດງຜົນ
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Latest Transactions Table --}}
            <div class="bento-card" style="padding:0; overflow:hidden; border:none; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <div style="padding:24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; background:#fff;">
                    <div style="display:flex; align-items:center; gap:16px;">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $themeGrad }} text-white flex items-center justify-center shrink-0 shadow-md shadow-{{ $themeShadow }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="chart-title" style="font-size:18px; font-weight:800; color:#1e293b; margin:0;">
                                {{ $txnType === 'expense' ? 'ປະຫວັດລາຍຈ່າຍລ່າສຸດ' : ($txnType === 'income' ? 'ປະຫວັດລາຍຮັບລ່າສຸດ' : 'ປະຫວັດທຸລະກຳຫຼ້າສຸດ') }}
                            </h3>
                            <p class="chart-subtitle" style="font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase; margin:4px 0 0 0;">
                                ສະແດງລາຍການລ່າສຸດທີ່ຖືກບັນທຶກ
                            </p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-{{ $themeBg }}/10 text-{{ $themeColor }} border border-{{ $themeBg }}/20">
                        ຫຼ້າສຸດ 10 ລາຍການ
                    </span>
                </div>

                <div class="overflow-x-auto touch-pan-x">
                    <table class="w-full text-left border-collapse" style="min-width:58rem;">
                        <thead>
                            <tr>
                                <th class="py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100">ວັນທີ</th>
                                <th class="py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100">ລະຫັດ/ໃບບິນ</th>
                                <th class="py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100">ໝວດ</th>
                                <th class="py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100">ຊື່ລາຍການ</th>
                                <th class="py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100">ພາກສ່ວນ</th>
                                <th class="py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100 text-right">ຈຳນວນເງິນ (₭)</th>
                                <th class="py-4 px-6 text-xs font-extrabold text-gray-400 border-b border-gray-100 text-center">ຈັດການ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @php
                                $latestLedger = $ledger->sortByDesc(fn($item) => $item->date . '_' . ($item->id ?? ''))->take(10);
                            @endphp
                            @forelse($latestLedger as $item)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-4 px-6 font-mono text-sm text-gray-500 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                                    </td>
                                    <td class="py-4 px-6 font-mono text-sm font-bold text-gray-700 whitespace-nowrap">
                                        {{ $item->payment_code ?: '—' }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        @if($item->category)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-[11px] font-bold theme-dept-tag">
                                                {{ $item->category }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-extrabold text-gray-800 text-sm">
                                            {{ $item->item_name ?: $item->desc }}
                                        </div>
                                        @if($item->item_name && $item->desc)
                                            <div class="text-xs text-gray-400 mt-0.5">{{ $item->desc }}</div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-500 truncate max-w-[150px]" title="{{ $item->department ?: '' }}">
                                        {{ $item->department ?: '—' }}
                                    </td>
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        @if($item->amount_in > 0)
                                            <span class="font-extrabold text-indigo-600 text-sm">
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
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-1.5">
                                            @if($item->type === 'expense' && (Auth::user()->role?->role_name === 'accountant' || Auth::user()->role?->role_name === 'admin'))
                                                <a href="{{ route('expense.edit', $item->id) }}"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-100 hover:border-rose-300 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                    ແກ້ໄຂ
                                                </a>
                                                <button type="button"
                                                    onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->item_name ?: $item->desc) }}', 'expense')"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-100 hover:border-rose-300 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    ລຶບ
                                                </button>
                                            @elseif($item->type === 'income' && (Auth::user()->role?->role_name === 'revenue_officer' || Auth::user()->role?->role_name === 'admin'))
                                                <a href="{{ route('revenue.edit', $item->id) }}"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 hover:bg-indigo-100 hover:border-indigo-300 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                    ແກ້ໄຂ
                                                </a>
                                                <button type="button"
                                                    onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->item_name ?: $item->desc) }}', 'income')"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-100 hover:border-rose-300 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    ລຶບ
                                                </button>
                                            @else
                                                <span class="text-xs text-gray-400 font-bold">ບໍ່ມີສິດຈັດການ</span>
                                            @endif
                                        </div>
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
                    </table>
                </div>
            </div>
        </div>

        {{-- ACCOUNTS BREAKDOWN TAB --}}
        @php
            $accountData = [];
            $accountLabels = [];
            $accountAmounts = [];
            if (!$isRevenueOnly) {
                $groupedAccounts = $expenseTransactions->groupBy('account_id');
                foreach ($groupedAccounts as $accId => $txns) {
                    $acc = $txns->first()->chartOfAccount;
                    if ($acc) {
                        $accountData[] = [
                            'label' => $acc->account_code . ' - ' . $acc->account_name,
                            'amount' => $txns->sum('amount')
                        ];
                    }
                }
                // Sort by amount descending
                usort($accountData, fn($a, $b) => $b['amount'] <=> $a['amount']);
                foreach ($accountData as $item) {
                    $accountLabels[] = $item['label'];
                    $accountAmounts[] = $item['amount'];
                }
            }
        @endphp

        @if(!$isRevenueOnly && $txnType !== 'income')
        <div id="tab-accounts" class="overview-grid" style="display:none;">
            {{-- Account Chart --}}
            <div class="bento-card col-span-3 flex flex-col">
                <div class="chart-header">
                    <div>
                        <p class="chart-subtitle">ປຽບທຽບ</p>
                        <h3 class="chart-title">ລາຍຈ່າຍແຍກຕາມໝວດບັນຊີ</h3>
                    </div>
                </div>
                <div style="flex:1; min-height:300px; position:relative;">
                    @if(count($accountAmounts) > 0)
                        <canvas id="accountChart"></canvas>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400 font-bold text-sm bg-gray-50/50 rounded-xl">
                            ບໍ່ມີຂໍ້ມູນສະແດງຜົນ
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- DEPARTMENTS TAB --}}
        @php
            $deptLabels = [];
            $deptIncomes = [];
            $deptExpenses = [];

            // Group all departments in this report range
            $deptGroups = [];
            foreach ($incomeTransactions as $tx) {
                if ($tx->department) {
                    $deptGroups[$tx->department->id]['name'] = $tx->department->department_name;
                    $deptGroups[$tx->department->id]['income'] = ($deptGroups[$tx->department->id]['income'] ?? 0) + $tx->amount;
                }
            }
            foreach ($expenseTransactions as $tx) {
                if ($tx->department) {
                    $deptGroups[$tx->department->id]['name'] = $tx->department->department_name;
                    $deptGroups[$tx->department->id]['expense'] = ($deptGroups[$tx->department->id]['expense'] ?? 0) + $tx->amount;
                }
            }
            foreach ($requests as $req) {
                if ($req->department) {
                    $deptGroups[$req->department->id]['name'] = $req->department->department_name;
                    $deptGroups[$req->department->id]['expense'] = ($deptGroups[$req->department->id]['expense'] ?? 0) + $req->requested_amount;
                }
            }

            foreach ($deptGroups as $dId => $data) {
                $deptLabels[] = $data['name'];
                $deptIncomes[] = $data['income'] ?? 0;
                $deptExpenses[] = $data['expense'] ?? 0;
            }
        @endphp

        <div id="tab-departments" class="overview-grid" style="display:none;">
            {{-- Department Chart --}}
            <div class="bento-card col-span-3 flex flex-col">
                <div class="chart-header">
                    <div>
                        <p class="chart-subtitle">ປຽບທຽບ</p>
                        <h3 class="chart-title">ລາຍຮັບ ແລະ ລາຍຈ່າຍ ແຕ່ລະພາກສ່ວນ</h3>
                    </div>
                </div>
                <div style="flex:1; min-height:300px; position:relative;">
                    @if(count($deptLabels) > 0)
                        <canvas id="departmentChart"></canvas>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400 font-bold text-sm bg-gray-50/50 rounded-xl">
                            ບໍ່ມີຂໍ້ມູນສະແດງຜົນ
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- TRANSACTIONS LEDGER TAB --}}
        <div id="tab-ledger" style="display:none;">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                {{-- Card header --}}
                <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-50 bg-white">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $themeGrad }} text-white flex items-center justify-center shrink-0 shadow-md shadow-{{ $themeShadow }}">
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
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-extrabold theme-dept-tag">
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
                                            <span class="font-extrabold text-indigo-600 text-sm">
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
                                    <td colspan="8" class="py-16">
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
                                <td colspan="6" class="py-4 px-6 text-sm font-extrabold text-gray-500 text-right">
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
    function switchTab(name, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.getElementById('tab-overview').style.display = 'none';
        @if(!$isRevenueOnly && $txnType !== 'income')
            if (document.getElementById('tab-accounts')) {
                document.getElementById('tab-accounts').style.display = 'none';
            }
        @endif
        document.getElementById('tab-departments').style.display = 'none';
        document.getElementById('tab-ledger').style.display = 'none';

        const tabEl = document.getElementById('tab-' + name);
        if (tabEl) {
            if (name === 'ledger') {
                tabEl.style.display = 'block';
            } else {
                tabEl.style.display = 'grid';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // 1. Summary Chart
        const elSummary = document.getElementById('summaryChart');
        if (elSummary) {
            const ctx = elSummary.getContext('2d');
            const labels = @json($chartLabels ?? []);
            const income = @json($chartIncome ?? []);
            const expense = @json($chartExpense ?? []);

            const datasets = [];
            if (income.some(v => v > 0)) {
                datasets.push({
                    label: 'ລາຍຮັບ (Income)',
                    data: income,
                    backgroundColor: 'rgba(16, 185, 129, 0.8)', // Emerald
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    borderRadius: 4,
                    maxBarThickness: 24
                });
            }
            if (expense.some(v => v > 0)) {
                datasets.push({
                    label: 'ລາຍຈ່າຍ (Expense)',
                    data: expense,
                    backgroundColor: 'rgba(244, 63, 94, 0.8)', // Rose
                    borderColor: 'rgba(244, 63, 94, 1)',
                    borderWidth: 2,
                    borderRadius: 4,
                    maxBarThickness: 24
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
        }

        // 2. Account Breakdown Chart
        @if(!$isRevenueOnly && $txnType !== 'income')
        const elAccount = document.getElementById('accountChart');
        if (elAccount) {
            const ctx = elAccount.getContext('2d');
            const labels = @json($accountLabels ?? []);
            const amounts = @json($accountAmounts ?? []);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'ລາຍຈ່າຍ (Expense)',
                        data: amounts,
                        backgroundColor: '{{ $txnType === "expense" ? "rgba(244, 63, 94, 0.8)" : "rgba(99, 102, 241, 0.8)" }}',
                        borderColor: '{{ $txnType === "expense" ? "rgba(244, 63, 94, 1)" : "rgba(99, 102, 241, 1)" }}',
                        borderWidth: 2,
                        borderRadius: 6,
                        maxBarThickness: 32
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return 'ຈ່າຍລວມ: ' + (context.raw || 0).toLocaleString() + ' ₭';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                callback: function(v) { return v >= 1000 ? (v/1000)+'K' : v; }
                            }
                        },
                        y: { grid: { display: false } }
                    }
                }
            });
        }
        @endif

        // 3. Department Comparison Chart
        const elDept = document.getElementById('departmentChart');
        if (elDept) {
            const ctx = elDept.getContext('2d');
            const labels = @json($deptLabels ?? []);
            const incomes = @json($deptIncomes ?? []);
            const expenses = @json($deptExpenses ?? []);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'ລາຍຮັບ (Income)',
                            data: incomes,
                            backgroundColor: 'rgba(16, 185, 129, 0.8)', // Emerald
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 2,
                            borderRadius: 4,
                            maxBarThickness: 24
                        },
                        {
                            label: 'ລາຍຈ່າຍ (Expense)',
                            data: expenses,
                            backgroundColor: 'rgba(244, 63, 94, 0.8)', // Rose
                            borderColor: 'rgba(244, 63, 94, 1)',
                            borderWidth: 2,
                            borderRadius: 4,
                            maxBarThickness: 24
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 8 } },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + (context.raw || 0).toLocaleString() + ' ₭';
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            ticks: {
                                callback: function(v) { return v >= 1000 ? (v/1000)+'K' : v; }
                            }
                        }
                    }
                }
            });
        }
    });
    </script>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:99999;" aria-modal="true" role="dialog">
        <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);" onclick="closeDeleteModal()"></div>
        <div style="position:relative; display:flex; align-items:center; justify-content:center; width:100%; height:100%; padding:1rem;">
            <div class="bg-white rounded-2xl shadow-2xl fns-animate" style="max-width:24rem; width:100%; padding:1.5rem; position:relative; z-index:1;">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-rose-100 mx-auto mb-4">
                    <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </div>
                <h3 class="text-lg font-extrabold text-gray-900 text-center mb-1">ຢືນຢັນການລຶບ</h3>
                <p class="text-sm text-gray-500 text-center mb-1">ທ່ານຕ້ອງການລຶບລາຍການ:</p>
                <p id="deleteItemName" class="text-sm font-bold text-rose-600 text-center mb-5 truncate px-2"></p>
                <p class="text-xs text-gray-400 text-center mb-5">ການລຶບນີ້ບໍ່ສາມາດກູ້ຄືນໄດ້</p>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-4 rounded-xl transition-all duration-150 text-sm">
                            ຍົກເລີກ
                        </button>
                        <button type="submit"
                            class="flex-1 bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-lg hover:-translate-y-0.5 transition-all duration-150 text-sm">
                            ລຶບເລີຍ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function teleportModal() {
            const modal = document.getElementById('deleteModal');
            if (modal && modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', teleportModal);
        } else {
            teleportModal();
        }

        function openDeleteModal(id, name, type) {
            const form = document.getElementById('deleteForm');
            if (type === 'income') {
                form.action = '/revenue/' + id;
            } else {
                form.action = '/expense/' + id;
            }
            document.getElementById('deleteItemName').textContent = name;
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.style.display = 'block';
            }
            document.body.style.overflow = 'hidden';
        }
        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.style.display = 'none';
            }
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });
    </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full min-w-0">
            <div class="flex flex-col gap-1.5 min-w-0">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                        ຕິດຕາມລາຍຈ່າຍງົບປະມານ
                    </h2>
                </div>
                <p class="text-sm font-semibold text-gray-500 pl-10">ຕິດຕາມການນຳໃຊ້ງົບປະມານແຍກຕາມໝວດບັນຊີ</p>
            </div>
            
            <div class="flex items-center gap-2 shrink-0 no-print">
                <button onclick="window.print()" 
                    class="ui-btn bg-rose-600 text-white hover:bg-rose-700 shadow-md shadow-rose-600/20 text-xs py-2.5 px-4 flex items-center gap-1.5 font-bold transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    ພິມລາຍງານ (Print)
                </button>
                <a href="{{ route('reports.index') }}" 
                    class="ui-btn bg-white hover:bg-gray-50 text-gray-700 font-bold py-2.5 px-4 rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-150 flex items-center gap-1.5 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    ລາຍງານຫຼັກ (Main Report)
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        .print-only { display: none; }

        @media print {
            @page { size: A4 portrait; margin: 15mm 20mm; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            nav, header, .no-print { display: none !important; }
            html, body { background: #fff !important; color: #1e293b !important; font-size: 11px !important; margin: 0 !important; padding: 0 !important; width: 100% !important; font-family: 'Noto Sans Lao', 'Phetsarath OT', sans-serif !important; }
            body > div.min-h-screen { display: block !important; width: 100% !important; margin: 0 !important; padding: 0 !important; background: #fff !important; }
            main { width: 100% !important; margin: 0 !important; padding: 0 !important; }

            .budget-outer { padding: 0 !important; background: #fff !important; }
            .budget-inner { max-width: none !important; }
            .budget-filter { display: none !important; }

            .fns-card { box-shadow: none !important; border: none !important; border-radius: 0 !important; }
            .fns-card-header { display: none !important; }
            .budget-kpi-grid { display: none !important; }
            .fns-meta { display: none !important; }

            .print-only { display: block !important; visibility: visible !important; }

            .p-tbl {
                width: 100%;
                border-collapse: collapse;
                font-size: 10.5px;
                margin-top: 15px;
            }
            .p-tbl th,
            .p-tbl td {
                border: 1px solid #000 !important;
                padding: 8px 10px !important;
                text-align: left;
            }
            .p-tbl thead th {
                background: #fff !important;
                font-weight: bold !important;
                color: #000 !important;
                font-size: 10px;
                border: 1px solid #000 !important;
            }
        }
    </style>

    <div class="budget-outer py-6 sm:py-8 w-full min-w-0 no-print">
        <div class="budget-inner max-w-[1400px] mx-auto w-full px-3 sm:px-4 lg:px-6 space-y-6">

            {{-- Filter Card --}}
            <div class="fns-card bg-white shadow-md rounded-2xl border border-gray-100 overflow-hidden fns-animate">
                <div class="border-b border-gray-100 bg-gray-50/50 p-2 sm:px-5 sm:py-3 flex overflow-x-auto">
                    <div class="flex gap-1.5 p-1 bg-gray-200/60 rounded-lg inline-flex">
                        <a href="{{ route('reports.budget-expense', array_merge(request()->except('type'), ['type' => 'daily'])) }}" 
                           class="px-5 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap {{ $type === 'daily' ? 'bg-white text-rose-600 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
                           ປະຈຳວັນ
                        </a>
                        <a href="{{ route('reports.budget-expense', array_merge(request()->except('type'), ['type' => 'monthly'])) }}" 
                           class="px-5 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap {{ $type === 'monthly' ? 'bg-white text-rose-600 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
                           ປະຈຳເດືອນ
                        </a>
                        <a href="{{ route('reports.budget-expense', array_merge(request()->except('type'), ['type' => 'yearly'])) }}" 
                           class="px-5 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap {{ $type === 'yearly' ? 'bg-white text-rose-600 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
                           ປະຈຳປີ
                        </a>
                    </div>
                </div>
                <div class="p-5 bg-gray-50/30">
                    <form method="GET" action="{{ route('reports.budget-expense') }}" class="flex flex-wrap gap-4 items-end">
                        <input type="hidden" name="type" value="{{ $type }}">
                        
                        <div class="flex flex-col gap-1.5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ $type === 'daily' ? 'ວັນທີ' : ($type === 'monthly' ? 'ເດືອນ' : 'ປີງົບປະມານ') }}
                            </label>
                            @if($type === 'daily')
                                <input type="date" name="date" value="{{ $date }}" class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm h-10 min-w-[160px]">
                            @elseif($type === 'monthly')
                                <input type="month" name="month" value="{{ $month }}" class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm h-10 min-w-[160px]">
                            @else
                                <select name="year" class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm h-10 min-w-[120px] cursor-pointer">
                                    @for($y = date('Y')-5; $y <= date('Y')+2; $y++)
                                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            @endif
                        </div>
                        
                        <div class="flex flex-col gap-1.5 min-w-[240px] flex-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">ໝວດບັນຊີງົບປະມານ</label>
                            <select name="account_id" class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm h-10 cursor-pointer">
                                <option value="">-- ເລືອກໝວດບັນຊີ --</option>
                                @foreach($lineItems as $li)
                                    <option value="{{ $li->account_id }}" {{ $selectedAccountId == $li->account_id ? 'selected' : '' }}>
                                        {{ $li->chartOfAccount?->account_code }} — {{ $li->chartOfAccount?->account_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="ui-btn bg-rose-500 hover:bg-rose-600 text-white font-bold h-10 px-5 flex items-center justify-center gap-2 text-sm shadow-lg shadow-rose-500/25 transition-all duration-150 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            ສະແດງລາຍງານ
                        </button>
                    </form>
                </div>
            </div>

            {{-- Report Table Card --}}
            @if($report)
                <div class="fns-card bg-white shadow-md rounded-2xl border border-gray-100 overflow-hidden fns-animate">
                    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-base font-extrabold text-gray-800 flex items-center gap-2">
                                <span class="w-1.5 h-5 rounded-full bg-rose-500 block"></span>
                                {{ $report['account']?->account_name ?? 'ໝວດບັນຊີ' }}
                            </h3>
                            <p class="text-xs text-gray-400 mt-0.5">ເລກບັນຊີ: {{ $report['account']?->account_code ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- KPIs Widgets --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-b border-gray-100 p-5 bg-gray-50/20">
                        <div class="fns-card bg-white shadow-sm border border-gray-100 p-4 rounded-xl flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">ງົບປະມານອະນຸມັດ</span>
                                <span class="block text-lg font-extrabold text-rose-600">{{ number_format($report['budget'], 0) }} ₭</span>
                            </div>
                        </div>
                        <div class="fns-card bg-white shadow-sm border border-gray-100 p-4 rounded-xl flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">ຈ່າຍແລ້ວທັງໝົດ</span>
                                <span class="block text-lg font-extrabold text-rose-600">{{ number_format($report['totalSpent'], 0) }} ₭</span>
                            </div>
                        </div>
                        <div class="fns-card bg-white shadow-sm border border-gray-100 p-4 rounded-xl flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg {{ $report['remaining'] >= 0 ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100' }} flex items-center justify-center border shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">ງົບປະມານຄົງເຫຼືອ</span>
                                <span class="block text-lg font-extrabold {{ $report['remaining'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ number_format($report['remaining'], 0) }} ₭</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 border-b border-gray-100 flex flex-wrap gap-4 items-center justify-between text-xs text-gray-500 font-bold">
                        <span>ຊ່ວງເວລາ: <strong class="text-gray-800">{{ $type === 'daily' ? \Carbon\Carbon::parse($date)->format('d-m-Y') : ($type === 'monthly' ? \Carbon\Carbon::parse($month.'-01')->format('m-Y') : $selectedYear) }}</strong></span>
                        <span>ເລກບັນຊີ: <strong class="text-gray-800">{{ $report['account']?->account_code }}</strong></span>
                        <span>ຈຳນວນລາຍການ: <strong class="text-gray-800">{{ $report['transactions']->count() }}</strong></span>
                    </div>

                    <div class="overflow-x-auto touch-pan-x">
                        <table class="fns-table w-full text-left border-collapse" style="min-width: 50rem;">
                            <thead>
                                <tr class="bg-gray-50/80 border-y border-gray-100">
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-center whitespace-nowrap" style="width:58px;">ລຳດັບ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">ເນື້ອໃນລາຍຈ່າຍ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-center whitespace-nowrap" style="width:140px;">ວັນທີ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap" style="width:130px;">ລາຍຈ່າຍ (ກີບ)</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap" style="width:140px;">ດຸ່ນດ່ຽງ (ກີບ)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($report['transactions'] as $idx => $txn)
                                    <tr class="hover:bg-rose-50/30 transition-colors duration-150 group">
                                        <td class="py-3.5 px-4 text-center text-sm font-semibold text-gray-400">{{ $idx + 1 }}</td>
                                        <td class="py-3.5 px-4 text-sm font-bold text-gray-800 group-hover:text-rose-700 transition-colors">{{ $txn->item_name ?: $txn->description }}</td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap text-sm font-medium text-gray-500">
                                            {{ $txn->transaction_date?->format('d-m-Y') }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap font-extrabold text-rose-600 text-sm">{{ number_format($txn->amount, 0) }}</td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap font-extrabold text-sm {{ $txn->running_balance >= 0 ? ($txn->running_balance < $report['budget'] * 0.1 ? 'text-amber-600' : 'text-emerald-600') : 'text-rose-600' }}">
                                            {{ number_format($txn->running_balance, 0) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12">
                                            <div class="flex flex-col items-center justify-center text-center">
                                                <p class="text-gray-500 font-bold">ບໍ່ມີຂໍ້ມູນທຸລະກຳ</p>
                                                <p class="text-xs text-gray-400 mt-1">ບໍ່ພົບລາຍຈ່າຍໃນຊ່ວງເວລານີ້</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($report['transactions']->count() > 0)
                                <tfoot class="bg-gray-50/50">
                                    <tr class="font-extrabold border-t border-gray-200">
                                        <td colspan="3" class="py-4 px-4 text-center text-sm text-gray-600">ລວມທັງໝົດ (ໃນຊ່ວງນີ້)</td>
                                        <td class="py-4 px-4 text-right whitespace-nowrap text-sm text-rose-600">{{ number_format($report['periodSpent'], 0) }} ₭</td>
                                        <td class="py-4 px-4 text-right whitespace-nowrap text-sm {{ $report['remaining'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ number_format($report['transactions']->last()->running_balance ?? $report['remaining'], 0) }} ₭
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

            @elseif($selectedYear && !$plan)
                <div class="fns-card bg-white shadow-md rounded-2xl border border-gray-100 p-8 text-center fns-animate">
                    <p class="text-gray-500 font-bold">ບໍ່ມີຂໍ້ມູນງົບປະມານ</p>
                    <p class="text-xs text-gray-400 mt-1">ປີ {{ $selectedYear }} ຍັງບໍ່ມີແຜນງົບປະມານທີ່ Approved</p>
                </div>
            @else
                <div class="fns-card bg-white shadow-md rounded-2xl border border-gray-100 p-12 text-center fns-animate">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center mb-4 border border-rose-100 shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 font-bold">ເລືອກໝວດບັນຊີງົບປະມານ ແລະ ກົດ «ສະແດງລາຍງານ»</p>
                        <p class="text-xs text-gray-400 mt-1">ລາຍງານຈະສະແດງໃນຮູปແບບ ໃບບິນຈ່າຍເງິນ</p>
                    </div>
                </div>
            @endif

        </div>
    </div>

    @if($report)
        <div class="print-only" style="font-family:'Noto Sans Lao','Phetsarath OT',sans-serif; color:#000;">
            @include('reports.partials.budget-expense-print', [
                'report' => $report,
                'type' => $type,
                'date' => $date,
                'month' => $month,
                'year' => $year,
                'selectedYear' => $selectedYear,
                'selectedAccountId' => $selectedAccountId,
            ])
        </div>
    @endif
</x-app-layout>

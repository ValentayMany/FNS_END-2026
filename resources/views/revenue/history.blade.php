<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full min-w-0">
            <div class="flex flex-col gap-1.5 min-w-0">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                        # ປະຫວັດການຮັບເງິນ
                    </h2>
                </div>
                <p class="text-sm font-semibold text-gray-500 pl-10">ຕິດຕາມປະຫວັດການຮັບເງິນ ແລະ ສະຫຼຸບຍອດລາຍຮັບຕາມຊ່ວງເວລາ</p>
            </div>
            
            <div class="flex items-center gap-2 shrink-0 no-print">
                <a href="{{ route('revenue.dashboard') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white hover:bg-gray-50 text-indigo-600 text-xs font-bold border border-indigo-200 shadow-sm transition-all duration-200">
                    📊 Dashboard ລາຍຮັບ
                </a>
                <a href="{{ route('reports.export', array_merge(request()->all(), ['txn_type' => 'income'])) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold shadow-lg shadow-emerald-500/30 transition-all duration-200 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Excel
                </a>
                <button onclick="window.print()" class="ui-btn bg-indigo-600 text-white hover:bg-indigo-700 shadow-md shadow-indigo-600/20 text-xs py-2.5 px-4 flex items-center gap-1.5 font-bold transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    ພິມລາຍງານ
                </button>
            </div>
        </div>
    </x-slot>

    <style>
        .print-only { display: none; }

        @media print {
            @page { size: A4 portrait; margin: 15mm 20mm; }
            
            nav, header, footer, sidebar, .no-print, [x-data] > nav, aside { display: none !important; }
            
            html, body {
                background: #ffffff !important;
                background-color: #ffffff !important;
                color: #000000 !important;
                font-size: 11px !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                height: auto !important;
                overflow: visible !important;
                font-family: 'Noto Sans Lao', 'Phetsarath OT', sans-serif !important;
            }

            div, main, body * {
                background: transparent !important;
                background-color: transparent !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .print-only {
                display: block !important;
                visibility: visible !important;
                width: 100% !important;
                background: #ffffff !important;
                background-color: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .p-tbl {
                width: 100%;
                border-collapse: collapse;
                font-size: 10.5px;
                margin-top: 15px;
                background: #ffffff !important;
            }
            .p-tbl th,
            .p-tbl td {
                border: 1px solid #000000 !important;
                padding: 6px 10px !important;
                text-align: left;
                background: #ffffff !important;
                color: #000000 !important;
            }
            .p-tbl thead th {
                background: #ffffff !important;
                font-weight: bold !important;
                color: #000000 !important;
                font-size: 10px;
                border: 1px solid #000000 !important;
            }
        }
    </style>

    <div class="py-6 sm:py-8 w-full min-w-0 no-print">
        <div class="w-full min-w-0 space-y-5 sm:space-y-6">

            @if (session('success'))
                <div class="fns-alert fns-alert-success fns-animate">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="fns-alert fns-alert-error fns-animate">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- 🔍 Filter Card --}}
            <div class="fns-card bg-white shadow-sm border border-gray-100 p-5 rounded-2xl fns-animate">
                <form method="GET" action="{{ route('revenue.history') }}" class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
                        <h3 class="text-sm font-extrabold text-gray-800 uppercase tracking-wider flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                            ເລືອກຊ່ວງເວລາສັງເກດການລາຍຮັບ
                        </h3>
                        
                        <div class="inline-flex p-1 bg-gray-100/80 rounded-xl gap-1">
                            <a href="{{ route('revenue.history', ['type' => 'daily', 'date' => $date]) }}"
                                class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all {{ $type === 'daily' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                ປະຈຳວັນ
                            </a>
                            <a href="{{ route('revenue.history', ['type' => 'monthly', 'month' => $month]) }}"
                                class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all {{ $type === 'monthly' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                ປະຈຳເດືອນ
                            </a>
                            <a href="{{ route('revenue.history', ['type' => 'yearly', 'year' => $year]) }}"
                                class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all {{ $type === 'yearly' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                ປະຈຳປີ
                            </a>
                        </div>
                    </div>

                    <input type="hidden" name="type" value="{{ $type }}">

                    <div class="flex flex-wrap items-end gap-3 pt-1">
                        @if ($type === 'daily')
                            <div class="w-full sm:w-auto min-w-[200px]">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">ເລືອກວັນທີ</label>
                                <input type="date" name="date" value="{{ $date }}" class="ui-input bg-gray-50 text-sm w-full">
                            </div>
                        @elseif ($type === 'monthly')
                            <div class="w-full sm:w-auto min-w-[200px]">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">ເລືອກເດືອນ</label>
                                <input type="month" name="month" value="{{ $month }}" class="ui-input bg-gray-50 text-sm w-full">
                            </div>
                        @elseif ($type === 'yearly')
                            <div class="w-full sm:w-auto min-w-[200px]">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">ເລືອກປີ</label>
                                <select name="year" class="ui-input bg-gray-50 text-sm w-full">
                                    @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}" {{ (string)$year === (string)$y ? 'selected' : '' }}>
                                            ປີ {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        @endif

                        <button type="submit" class="ui-btn bg-indigo-600 text-white hover:bg-indigo-700 shadow-md shadow-indigo-600/20 text-xs py-2.5 px-6 font-bold flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            ດຶງຂໍ້ມູນ
                        </button>
                    </div>
                </form>
            </div>

            {{-- 📊 Summary Balance Widgets --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                {{-- Left Card: Total Revenue --}}
                <div class="fns-card bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 text-white p-6 rounded-2xl shadow-xl relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold tracking-wider text-indigo-200 uppercase">
                                ຍອດລວມລາຍຮັບປະຈຳ
                                @if($type === 'daily') ວັນທີ {{ date('d/m/Y', strtotime($date)) }}
                                @elseif($type === 'monthly') ເດືອນ {{ date('m/Y', strtotime($month.'-01')) }}
                                @else ປີ {{ $year }} @endif
                            </span>
                            <span class="p-2 bg-white/10 rounded-xl backdrop-blur-md">
                                <svg class="w-5 h-5 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-black tracking-tight mb-1">
                            {{ number_format($summaryTotal, 2) }} <span class="text-sm font-bold text-indigo-200">₭</span>
                        </h3>
                    </div>
                    <div class="pt-4 border-t border-white/10 mt-4 flex items-center justify-between text-xs text-indigo-100 font-medium">
                        <span>ສະຫຼຸບລາຍຮັບທັງໝົດ</span>
                        <span class="font-bold text-white">{{ $summaryCount }} ລາຍການ</span>
                    </div>
                </div>

                {{-- Right Card: Count & Stats --}}
                <div class="fns-card bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">ຈຳນວນລາຍການຮັບທັງໝົດ</span>
                            <span class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </span>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight mb-1">
                            {{ number_format($summaryCount) }} <span class="text-sm font-bold text-gray-400">ລາຍການ</span>
                        </h3>
                    </div>
                    <div class="pt-4 border-t border-gray-100 mt-4 flex items-center justify-between text-xs text-gray-500">
                        <span>ສະຖານະຂໍ້ມູນ</span>
                        <span class="font-bold text-indigo-600">ອັບເດດລ່າສຸດ</span>
                    </div>
                </div>
            </div>

            {{-- 📋 Transactions Table --}}
            <div class="fns-card bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden fns-animate">
                <form id="batchDeleteForm" action="{{ route('revenue.destroy-batch') }}" method="POST">
                    @csrf
                    <div class="p-5 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <h3 class="text-base font-extrabold text-gray-800 flex items-center gap-2">
                                <span class="w-1.5 h-5 rounded-full bg-indigo-600 block"></span>
                                ລາຍການລາຍຮັບ
                            </h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {{ number_format($transactions->total()) }} ລາຍການ
                            </span>
                        </div>

                        @if(auth()->user()->isRevenueOfficer() || auth()->user()->isAdmin())
                            <button type="button" id="btnBatchDelete" onclick="confirmBatchDelete()" disabled
                                class="opacity-50 cursor-not-allowed ui-btn bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-600 hover:text-white text-xs py-2 px-4 flex items-center gap-1.5 font-bold transition-all duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                ລຶບທັງໝົດ (<span id="selectedCount">0</span>)
                            </button>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm text-gray-700">
                            <thead>
                                <tr class="bg-gray-50/80 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    @if(auth()->user()->isRevenueOfficer() || auth()->user()->isAdmin())
                                        <th class="py-3.5 px-4 text-center w-10">
                                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                        </th>
                                    @endif
                                    <th class="py-3.5 px-4">ວັນທີ</th>
                                    <th class="py-3.5 px-4">ເລກທີໃບບິນ</th>
                                    <th class="py-3.5 px-4">ປະເພດລາຍຮັບ</th>
                                    <th class="py-3.5 px-4">ພາກສ່ວນ</th>
                                    <th class="py-3.5 px-4">ວິທີຮັບເງິນ</th>
                                    <th class="py-3.5 px-4 text-right">ຈຳນວນ (ກີບ)</th>
                                    <th class="py-3.5 px-4 text-center">ຈັດການ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($transactions as $txn)
                                    <tr class="hover:bg-indigo-50/30 transition-colors">
                                        @if(auth()->user()->isRevenueOfficer() || auth()->user()->isAdmin())
                                            <td class="py-3.5 px-4 text-center">
                                                <input type="checkbox" name="ids[]" value="{{ $txn->id }}" onchange="updateBatchState()" class="item-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                            </td>
                                        @endif
                                        <td class="py-3.5 px-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ date('d/m/Y', strtotime($txn->transaction_date)) }}
                                        </td>
                                        <td class="py-3.5 px-4 font-mono font-bold text-indigo-600 whitespace-nowrap">
                                            {{ $txn->payment_code ?? '-' }}
                                        </td>
                                        <td class="py-3.5 px-4 font-semibold text-gray-800">
                                            {{ $txn->category }}
                                            @if($txn->description)
                                                <p class="text-xs text-gray-400 font-normal mt-0.5">{{ Str::limit($txn->description, 40) }}</p>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                                {{ $txn->department?->department_name ?? 'ພາກສ່ວນກາງ' }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            @if($txn->payment_method === 'cash')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                    💵 ເງິນສົດ
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                    💳 ເງິນໂອນ
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-bold text-indigo-600 whitespace-nowrap">
                                            {{ number_format($txn->amount, 2) }}
                                        </td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-1.5">
                                                @if(auth()->user()->isRevenueOfficer() || auth()->user()->isAdmin())
                                                    <a href="{{ route('revenue.edit', $txn) }}" class="p-1.5 text-gray-400 hover:text-indigo-600 rounded-lg hover:bg-gray-100 transition-colors" title="ແກ້ໄຂ">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                    </a>
                                                    <button type="button" onclick="openDeleteModal('{{ $txn->id }}', '{{ addslashes($txn->category) }}')" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors" title="ລຶບ">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    </button>
                                                @else
                                                    <span class="text-xs text-gray-400 font-medium">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-8">
                                            <div class="fns-empty py-6 text-center">
                                                <p class="text-sm font-semibold text-gray-400">ບໍ່ມີປະຫວັດການຮັບເງິນໃນຊ່ວງເວລານີ້</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="bg-indigo-50/50 font-black text-gray-900 border-t-2 border-indigo-200">
                                    <td colspan="{{ (auth()->user()->isRevenueOfficer() || auth()->user()->isAdmin()) ? '6' : '5' }}" class="py-4 px-4 text-right text-xs uppercase tracking-wider text-indigo-900">
                                        ຍອດລວມລາຍຮັບທັງໝົດໃນໜ້ານີ້:
                                    </td>
                                    <td class="py-4 px-4 text-right text-base text-indigo-700 font-extrabold whitespace-nowrap">
                                        {{ number_format($transactions->sum('amount'), 2) }} ₭
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>

                @if($transactions->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- 🖨️ Printable Clean A4 Layout --}}
    <div class="print-only" style="font-family: 'Noto Sans Lao', 'Phetsarath OT', sans-serif; color: #000;">
        @include('reports.partials.revenue-print', [
            'incomeTransactions' => $transactions,
            'type' => $type,
            'date' => $date,
            'month' => $month,
            'year' => $year,
        ])
    </div>
    
    {{-- Single Delete Confirmation Modal --}}
    @if(auth()->user()->isRevenueOfficer() || auth()->user()->isAdmin())
        <div id="deleteModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:99999;" aria-modal="true" role="dialog">
            <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);" onclick="closeDeleteModal()"></div>
            <div style="position:relative; display:flex; align-items:center; justify-content:center; width:100%; height:100%; padding:1rem;">
                <div class="bg-white rounded-2xl shadow-2xl fns-animate" style="max-width:24rem; width:100%; padding:1.5rem; position:relative; z-index:1;">
                    <div class="flex items-center justify-center w-14 h-14 rounded-full bg-rose-100 mx-auto mb-4">
                        <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 text-center mb-1">ຢືນຢັນການລຶບລາຍຮັບ</h3>
                    <p class="text-sm text-gray-500 text-center mb-1">ທ່ານຕ້ອງການລຶບລາຍຮັບ: <span id="deleteItemName" class="font-bold text-gray-800"></span>?</p>
                    <p class="text-xs text-gray-400 text-center mb-5">ການລຶບນີ້ບໍ່ສາມາດກູ້ຄືນໄດ້</p>

                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="closeDeleteModal()" class="ui-btn bg-gray-100 text-gray-700 hover:bg-gray-200 flex-1 py-2.5 text-sm font-bold">
                                ຍົກເລີກ
                            </button>
                            <button type="submit" class="ui-btn bg-rose-600 text-white hover:bg-rose-700 flex-1 py-2.5 text-sm font-bold shadow-lg shadow-rose-600/30">
                                ຢືນຢັນລຶບ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Batch Delete Confirmation Modal --}}
        <div id="batchDeleteModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:99999;" aria-modal="true" role="dialog">
            <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);" onclick="closeBatchDeleteModal()"></div>
            <div style="position:relative; display:flex; align-items:center; justify-content:center; width:100%; height:100%; padding:1rem;">
                <div class="bg-white rounded-2xl shadow-2xl fns-animate" style="max-width:24rem; width:100%; padding:1.5rem; position:relative; z-index:1;">
                    <div class="flex items-center justify-center w-14 h-14 rounded-full bg-rose-100 mx-auto mb-4">
                        <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 text-center mb-1">ຢືນຢັນການລຶບທັງໝົດ</h3>
                    <p class="text-sm text-gray-500 text-center mb-1">ທ່ານຕ້ອງການລຶບ <span id="batchCountText" class="font-bold text-rose-600"></span> ລາຍການທີ່ເລືອກ?</p>
                    <p class="text-xs text-gray-400 text-center mb-5">ການລຶບນີ້ບໍ່ສາມາດກູ້ຄືນໄດ້</p>

                    <div class="flex items-center gap-3">
                        <button type="button" onclick="closeBatchDeleteModal()" class="ui-btn bg-gray-100 text-gray-700 hover:bg-gray-200 flex-1 py-2.5 text-sm font-bold">
                            ຍົກເລີກ
                        </button>
                        <button type="button" onclick="submitBatchDelete()" class="ui-btn bg-rose-600 text-white hover:bg-rose-700 flex-1 py-2.5 text-sm font-bold shadow-lg shadow-rose-600/30">
                            ຢືນຢັນລຶບ
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const delModal = document.getElementById('deleteModal');
                const batchModal = document.getElementById('batchDeleteModal');
                if (delModal) document.body.appendChild(delModal);
                if (batchModal) document.body.appendChild(batchModal);
            });

            function openDeleteModal(id, category) {
                const modal = document.getElementById('deleteModal');
                const form = document.getElementById('deleteForm');
                const nameSpan = document.getElementById('deleteItemName');
                
                form.action = `/revenue/${id}`;
                nameSpan.textContent = category;
                modal.style.display = 'block';
            }

            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                if (modal) modal.style.display = 'none';
            }

            function confirmBatchDelete() {
                const checkboxes = document.querySelectorAll('.item-checkbox:checked');
                if (checkboxes.length === 0) return;

                const countText = document.getElementById('batchCountText');
                countText.textContent = checkboxes.length;

                const modal = document.getElementById('batchDeleteModal');
                if (modal) modal.style.display = 'block';
            }

            function closeBatchDeleteModal() {
                const modal = document.getElementById('batchDeleteModal');
                if (modal) modal.style.display = 'none';
            }

            function submitBatchDelete() {
                document.getElementById('batchDeleteForm').submit();
            }

            function toggleSelectAll(master) {
                const checkboxes = document.querySelectorAll('.item-checkbox');
                checkboxes.forEach(cb => cb.checked = master.checked);
                updateBatchState();
            }

            function updateBatchState() {
                const checked = document.querySelectorAll('.item-checkbox:checked');
                const btn = document.getElementById('btnBatchDelete');
                const countSpan = document.getElementById('selectedCount');
                const master = document.getElementById('selectAllCheckbox');
                const total = document.querySelectorAll('.item-checkbox');

                if (countSpan) countSpan.textContent = checked.length;

                if (btn) {
                    if (checked.length > 0) {
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        btn.disabled = true;
                        btn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }

                if (master && total.length > 0) {
                    master.checked = (checked.length === total.length);
                }
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeDeleteModal();
                    closeBatchDeleteModal();
                }
            });
        </script>
    @endif
</x-app-layout>

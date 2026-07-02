<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full min-w-0">
            <div class="flex flex-col gap-1.5 min-w-0">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                        # ປະຫວັດ ແລະ ໃບ Balance ສຸດຍອດລາຍຈ່າຍ
                    </h2>
                </div>
                <p class="text-sm font-semibold text-gray-500 pl-10">ຕິດຕາມປະຫວັດການຈ່າຍເງິນ ແລະ ສະຫຼຸບຍອດ Balance ຕາມຊ່ວງເວລາ</p>
            </div>
            
            <div class="flex items-center gap-2 shrink-0 no-print">
                <a href="{{ route('reports.budget-expense', request()->only(['type', 'date', 'month', 'year'])) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold border border-gray-200 shadow-sm transition-all duration-200">
                    ຕິດຕາມງົບປະມານ
                </a>
                <a href="{{ route('reports.export', array_merge(request()->all(), ['txn_type' => 'expense'])) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold shadow-lg shadow-emerald-500/30 transition-all duration-200 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Excel
                </a>
                <button onclick="window.print()" class="ui-btn bg-rose-600 text-white hover:bg-rose-700 shadow-md shadow-rose-600/20 text-xs py-2.5 px-4 flex items-center gap-1.5 font-bold transition-all duration-150">
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
            
            /* Clean print resets */
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

            /* Override layout div backgrounds */
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
        <div class="max-w-5xl mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6 space-y-5 sm:space-y-6">

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
                <div class="border-b border-gray-100 pb-3 mb-4 flex items-center justify-between">
                    <div class="flex gap-1.5 p-1 bg-gray-100 rounded-xl">
                        <a href="{{ route('expense.history', ['type' => 'daily']) }}" 
                           class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all {{ $type === 'daily' ? 'bg-white text-rose-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                           ປະຈຳວັນ
                        </a>
                        <a href="{{ route('expense.history', ['type' => 'monthly']) }}" 
                           class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all {{ $type === 'monthly' ? 'bg-white text-rose-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                           ປະຈຳເດືອນ
                        </a>
                        <a href="{{ route('expense.history', ['type' => 'yearly']) }}" 
                           class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all {{ $type === 'yearly' ? 'bg-white text-rose-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                           ປະຈຳປີ
                        </a>
                    </div>
                    <span class="text-xs font-bold text-gray-400">ເລືອກຊ່ວງເວລາເພື່ອສະຫຼຸບ Balance</span>
                </div>

                <form method="GET" action="{{ route('expense.history') }}" class="flex flex-wrap items-end gap-4">
                    <input type="hidden" name="type" value="{{ $type }}">
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">
                            {{ $type === 'daily' ? 'ເລືອກວັນທີ' : ($type === 'monthly' ? 'ເລືອກເດືອນ' : 'ເລືອກປີ') }}
                        </label>
                        @if($type === 'daily')
                            <input type="date" name="date" value="{{ $date }}" class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 text-sm h-10 min-w-[160px]">
                        @elseif($type === 'monthly')
                            <input type="month" name="month" value="{{ $month }}" class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 text-sm h-10 min-w-[160px]">
                        @else
                            <select name="year" class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 text-sm h-10 min-w-[120px] cursor-pointer">
                                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                    <option value="{{ $y }}" {{ (string)$year === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        @endif
                    </div>

                    <button type="submit" class="ui-btn bg-rose-600 hover:bg-rose-700 text-white font-bold h-10 px-6 text-sm shadow-md shadow-rose-600/20 transition-all">
                        🔍 ດຶງຂໍ້ມູນ
                    </button>
                </form>
            </div>

            {{-- 📊 Screen Summary Widgets --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-rose-600 text-white p-5 rounded-2xl shadow-md shadow-rose-600/25 relative overflow-hidden">
                    <p class="text-xs font-bold uppercase tracking-wider text-rose-100">
                        {{ $type === 'daily' ? 'ຍອດລວມລາຍຈ່າຍປະຈຳວັນ' : ($type === 'monthly' ? 'ຍອດລວມລາຍຈ່າຍປະຈຳເດືອນ' : 'ຍອດລວມລາຍຈ່າຍປະຈຳປີ') }}
                    </p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold mt-1 font-mono">
                        {{ number_format($summaryTotal, 0) }} <span class="text-base font-normal opacity-90">₭</span>
                    </h3>
                    <p class="text-xs text-rose-100 mt-2 font-medium">
                        ຊ່ວງເວລາ: {{ $type === 'daily' ? \Carbon\Carbon::parse($date)->format('d/m/Y') : ($type === 'monthly' ? \Carbon\Carbon::parse($month.'-01')->format('m/Y') : $year) }}
                    </p>
                </div>

                <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm flex flex-col justify-center">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">ຈຳນວນລາຍການຈ່າຍທັງໝົດ</p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mt-1">
                        {{ number_format($summaryCount, 0) }} <span class="text-sm font-bold text-gray-500">ລາຍການ</span>
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">ສະແດງຂໍ້ມູນຕາມເງື່ອນໄຂທີ່ເລືອກ</p>
                </div>
            </div>

            {{-- 📋 Main History Table Card (Screen View Only) --}}
            <div class="fns-card shadow-sm border border-gray-100 bg-white fns-animate">
                <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-base font-extrabold text-gray-800 flex items-center gap-2">
                            <span class="w-1.5 h-5 rounded-full bg-rose-500 block"></span>
                            ລາຍການລາຍຈ່າຍ
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">ລາຍການທີ່ຖືກບັນທຶກໃນຊ່ວງເວລານີ້</p>
                    </div>
                </div>

                <div class="overflow-x-auto touch-pan-x">
                    <table class="fns-table w-full text-left border-collapse" style="min-width: 48rem;">
                        <thead>
                            <tr class="bg-gray-50/80 border-y border-gray-100">
                                <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center" style="width: 110px;">ວັນທີ</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center" style="width: 120px;">ເລກທີໃບບິນ</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center" style="width: 130px;">ພາກສ່ວນ</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">ເນື້ອໃນລາຍຈ່າຍ</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right" style="width: 150px;">ຈຳນວນ (ກີບ)</th>
                                @if(auth()->user()->isAccountant() || auth()->user()->isAdmin())
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center" style="width: 180px;">ຈັດການ</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $txn)
                                <tr class="hover:bg-gray-50/30 transition-colors border-b border-gray-50">
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="text-sm font-semibold text-gray-600">{{ $txn->transaction_date?->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="font-mono font-bold text-gray-500 text-xs">{{ $txn->payment_code }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100/50">
                                            {{ $txn->department?->expenseSectionLabel() ?? 'ພາກສ່ວນກາງ' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="font-bold text-gray-800 text-sm leading-tight">{{ $txn->item_name }}</div>
                                        @if($txn->chartOfAccount)
                                            <div class="text-[0.7rem] text-gray-400 font-mono mt-0.5">
                                                {{ $txn->chartOfAccount->account_code }} • {{ $txn->chartOfAccount->account_name }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap font-mono font-extrabold text-rose-600 text-[0.95rem] tracking-tight">
                                        - {{ number_format($txn->amount, 0) }} <span class="text-xs text-rose-400 font-normal">₭</span>
                                    </td>
                                    @if(auth()->user()->isAccountant() || auth()->user()->isAdmin())
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <a href="{{ route('expense.edit', $txn->id) }}"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-100 hover:border-rose-300 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    ແກ້ໄຂ
                                                </a>
                                                <button type="button"
                                                    onclick="openDeleteModal({{ $txn->id }}, '{{ addslashes($txn->item_name) }}')"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-red-50 text-red-600 border border-red-100 hover:bg-red-100 hover:border-red-300 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    ລຶບ
                                                </button>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8">
                                        <div class="fns-empty py-6 text-center">
                                            <p class="text-sm font-semibold text-gray-400">ບໍ່ມີປະຫວັດການຈ່າຍເງິນໃນຊ່ວງເວລານີ້</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="bg-rose-50/50 font-extrabold text-gray-800 border-t-2 border-rose-200">
                                <td colspan="4" class="py-3 px-4 text-right text-sm">... ຍອດລວມ Balance ທັງໝົດ ...</td>
                                <td class="py-3 px-4 text-right text-rose-600 font-mono text-base font-black whitespace-nowrap">
                                    {{ number_format($summaryTotal, 0) }} ₭
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if ($transactions->hasPages())
                    <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- 🖨️ Formatted Printable Document (ตรงตามแบบรูปภาพที่ส่งมาแบบเป๊ะๆ) --}}
    <div class="print-only" style="font-family: 'Noto Sans Lao', 'Phetsarath OT', sans-serif; color: #000;">
        <div style="text-align: center; font-size: 10px; font-weight: bold; margin-bottom: 15px; text-decoration: underline; text-underline-offset: 2px;">
            ໃບບິນຈ່າຍເງິນ
        </div>

        <div style="text-align: center; margin-bottom: 25px;">
            <h1 style="font-size: 14px; font-weight: bold; color: #000; margin: 0 0 4px; line-height: 1.4;">
                ຕິດຕາມລາຍຈ່າຍປະຫວັດການຈ່າຍເງິນ
            </h1>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: flex-start; font-size: 11px; color: #000; margin-bottom: 15px; line-height: 1.6;">
            <div style="width: 35%;">
                <p style="margin: 0;">ລະຫັດລາຍຈ່າຍ: <b>{{ number_format($summaryCount, 0) }}</b></p>
            </div>
            <div style="width: 30%; text-align: center; font-weight: bold; padding-top: 5px;">
                ພາກວິຊາວິທະຍາສາດຄອມພິວເຕີ
            </div>
            <div style="width: 35%; text-align: right;">
                <p style="margin: 0;">ຍອດລວມລາຍຈ່າຍ: <b>{{ number_format($summaryTotal, 0, ',', '.') }}</b></p>
            </div>
        </div>

        <table class="p-tbl">
            <thead>
                <tr style="font-weight: bold; background: #fff;">
                    <th style="width: 45px; text-align: center; font-weight: bold; border: 1px solid #000 !important;">ລຳດັບ</th>
                    <th style="text-align: left; font-weight: bold; border: 1px solid #000 !important;">ເນື້ອໃນລາຍຈ່າຍ</th>
                    <th style="width: 110px; text-align: center; font-weight: bold; border: 1px solid #000 !important;">ວັນທີ-ເດືອນ-ປີ</th>
                    <th style="width: 115px; text-align: right; font-weight: bold; border: 1px solid #000 !important;">ລາຍຈ່າຍ</th>
                    <th style="width: 115px; text-align: right; font-weight: bold; border: 1px solid #000 !important;">ດຸ່ນດ່ຽງ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $idx => $txn)
                    <tr>
                        <td style="text-align: center; border: 1px solid #000 !important;">{{ $idx + 1 }}</td>
                        <td style="text-align: left; border: 1px solid #000 !important;">
                            {{ $txn->item_name }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000 !important;">{{ $txn->transaction_date?->format('d-m-Y') }}</td>
                        <td style="text-align: right; border: 1px solid #000 !important;">{{ number_format($txn->amount, 0, ',', '.') }}</td>
                        <td style="text-align: right; border: 1px solid #000 !important;">{{ number_format(-$txn->amount, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 15px; border: 1px solid #000 !important;">ບໍ່ມີຂໍ້ມູນລາຍຈ່າຍໃນຊ່ວງເວລານີ້</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="font-weight: bold; background: #fff;">
                    <td colspan="3" style="text-align: center; font-weight: bold; border: 1px solid #000 !important;">ລວມທັງໝົດ</td>
                    <td style="text-align: right; font-weight: bold; border: 1px solid #000 !important;">{{ number_format($summaryTotal, 0, ',', '.') }}</td>
                    <td style="text-align: right; font-weight: bold; border: 1px solid #000 !important;">{{ number_format(-$summaryTotal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div style="display: flex; justify-content: space-between; margin-top: 50px; font-size: 11px; line-height: 1.6; page-break-inside: avoid;">
            <div style="width: 45%; text-align: left; font-weight: bold; padding-left: 10px;">
                ຫົວໜ້າພະແນກການເງິນ-ຊັບສິນ
            </div>
            <div style="width: 45%; text-align: right; font-weight: bold; padding-right: 10px;">
                <p style="margin: 0; padding-right: 15px;">ວັນທີ: {{ now()->format('d-m-Y') }}</p>
                <p style="margin: 6px 0 0; padding-right: 25px;">ນາຍບັນຊີ</p>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    @if(auth()->user()->isAccountant() || auth()->user()->isAdmin())
        <div id="deleteModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:99999;" aria-modal="true" role="dialog">
            <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);" onclick="closeDeleteModal()"></div>
            <div style="position:relative; display:flex; align-items:center; justify-content:center; width:100%; height:100%; padding:1rem;">
                <div class="bg-white rounded-2xl shadow-2xl fns-animate" style="max-width:24rem; width:100%; padding:1.5rem; position:relative; z-index:1;">
                    <div class="flex items-center justify-center w-14 h-14 rounded-full bg-rose-100 mx-auto mb-4">
                        <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 text-center mb-1">ຢືນຢັນການລຶບ</h3>
                    <p class="text-sm text-gray-500 text-center mb-1">ທ່ານຕ້ອງການລຶບລາຍການ:</p>
                    <p id="deleteItemName" class="text-sm font-bold text-rose-600 text-center mb-5 truncate"></p>
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

            function openDeleteModal(id, name) {
                document.getElementById('deleteForm').action = '/expense/' + id;
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
    @endif
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 min-w-0">
            <div class="flex flex-col gap-0.5 min-w-0">
                <p class="text-xs font-medium text-indigo-400 uppercase tracking-widest">ລາຍງານ</p>
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 truncate">ລົງຕາມລາຍຈ່າຍງົບປະມານ</h2>
            </div>
            <div class="flex flex-wrap items-center gap-2 shrink-0 no-print">
                <button type="button" onclick="window.print()" class="fns-btn fns-btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    ພິມລາຍງານ
                </button>
                <a href="{{ route('reports.index') }}" class="fns-btn fns-btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    ລາຍງານຫຼັກ
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        /* ── Print-only blocks ── */
        .print-header, .print-sign { display: none; }

        /* ══════════════════════════════
           PRINT — แบบระบบເກົ່າ
           ══════════════════════════════ */
        @media print {
            @page { size: A4 portrait; margin: 10mm 12mm; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            nav, header, .no-print { display: none !important; }
            html, body { background: #fff !important; color: #000 !important; font-size: 12px !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
            body > div.min-h-screen { display: block !important; width: 100% !important; margin: 0 !important; padding: 0 !important; background: #fff !important; }
            main { width: 100% !important; margin: 0 !important; padding: 0 !important; }

            .budget-outer { padding: 0 !important; background: #fff !important; }
            .budget-inner { max-width: none !important; }
            .budget-filter { display: none !important; }

            .fns-card { box-shadow: none !important; border: none !important; border-radius: 0 !important; }
            .fns-card-header { display: none !important; }
            .budget-kpi-grid { display: none !important; }
            .fns-meta { display: none !important; }

            .print-header { display: block !important; margin-bottom: 10px; }
            .print-sign { display: block !important; margin-top: 24px; }

            .print-header .ph-top {
                display: flex; justify-content: space-between; align-items: flex-start;
                font-size: 10px; color: #000; margin-bottom: 4px;
            }
            .print-header .ph-title { text-align: center; margin: 6px 0 4px; }
            .print-header .ph-title h1 { font-size: 14px; font-weight: 800; color: #000; margin: 0; }
            .print-header .ph-title .ph-sub { font-size: 12px; color: #000; margin: 2px 0 0; }
            .print-header .ph-info {
                display: flex !important; justify-content: space-between; align-items: flex-start;
                margin-top: 12px; font-size: 12px; color: #000;
            }
            .print-header .ph-info p { margin: 2px 0; }
            .print-header .ph-info-right { text-align: right; }

            .budget-table { font-size: 11px !important; border: 2px solid #000 !important; border-collapse: collapse !important; width: 100% !important; }
            .budget-table thead th { background: #f5f5f5 !important; color: #000 !important; font-size: 10px !important; padding: 6px 8px !important; border: 1px solid #000 !important; }
            .budget-table tbody td { padding: 7px 8px !important; border: 1px solid #000 !important; color: #000 !important; }
            .budget-table .amt, .budget-table .bal, .budget-table .bal.ok, .budget-table .bal.warn, .budget-table .bal.danger { color: #000 !important; }
            .budget-table tfoot td { background: #f5f5f5 !important; color: #000 !important; border: 1px solid #000 !important; border-top: 2px solid #000 !important; }

            .print-sign .ps-date { text-align: right; font-size: 12px; color: #000; margin-bottom: 8px; }
            .print-sign .row { display: flex; justify-content: space-between; gap: 20px; font-size: 11px; color: #000; }
            .print-sign .sig { text-align: center; flex: 1; }
            .print-sign .line { margin-top: 30px; border-top: 1px solid #000; padding-top: 4px; font-weight: 600; }
        }
    </style>

    <div class="budget-outer py-6 sm:py-8 w-full min-w-0">
        <div class="budget-inner max-w-[900px] mx-auto w-full px-3 sm:px-4 space-y-5">

            {{-- ══ Print-only header ══ --}}
            <div class="print-header">
                <div class="ph-top">
                    <span>{{ now()->format('n/d/Y, g:i A') }}</span>
                    <span>ໃບບັນຈາຍເງິນ</span>
                </div>
                <div class="ph-title">
                    @if($report)
                        <h1>ຕິດຕາມລາຍຈ່າຍງົບປະມານ {{ $report['account']?->account_name ?? '' }}</h1>
                        @if($report['account']?->account_code)
                            <p class="ph-sub">(ງົບປະມານ{{ $report['account']->account_name }})</p>
                        @endif
                    @else
                        <h1>ຕິດຕາມລາຍຈ່າຍງົບປະມານ</h1>
                    @endif
                </div>
                @if($report)
                    <div class="ph-info">
                        <div class="ph-info-left">
                            <p>ຈຳນວນລາຍການລາຍຈ່າຍ: {{ $report['transactions']->count() }}</p>
                            <p>ຊ້ວງງົບປະມານ:</p>
                            <p>{{ $report['account']?->account_code ?? '-' }}</p>
                        </div>
                        <div class="ph-info-right">
                            <p>ຕົວເລກອະນຸມັດ: {{ number_format($report['budget'], 0) }}</p>
                            <p>ຈ່າຍແລ້ວ: {{ number_format($report['totalSpent'], 0) }}</p>
                            <p>ຍົດເຫຼືອ: {{ number_format($report['remaining'], 0) }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Filter --}}
            <div class="fns-filter no-print fns-animate">
                <form method="GET" action="{{ route('reports.budget-expense') }}"
                      class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-end sm:gap-5">
                    <div class="sm:w-40">
                        <label class="fns-label">ປີງົບປະມານ</label>
                        <select name="fiscal_year" onchange="this.form.submit()" class="fns-select">
                            <option value="">-- ເລືອກປີ --</option>
                            @foreach($fiscalYears as $yr)
                                <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="fns-label">ໝວດບັນຊີ</label>
                        <select name="account_id" class="fns-select">
                            <option value="">-- ເລືອກໝວດ --</option>
                            @foreach($lineItems as $li)
                                <option value="{{ $li->account_id }}" {{ $selectedAccountId == $li->account_id ? 'selected' : '' }}>
                                    {{ $li->chartOfAccount?->account_code }} — {{ $li->chartOfAccount?->account_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="fns-btn fns-btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        ສະແດງ
                    </button>
                </form>
            </div>

            {{-- Report --}}
            @if($report)
                <div class="fns-card fns-animate">
                    <div class="fns-card-header">
                        <div>
                            <h3 class="fns-card-title">{{ $report['account']?->account_name ?? 'ໝວດບັນຊີ' }}</h3>
                            <p class="fns-card-subtitle">ເລກບັນຊີ: {{ $report['account']?->account_code ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="budget-kpi-grid grid grid-cols-3 border-b border-gray-200">
                        <div class="fns-kpi border-r border-gray-200">
                            <div class="fns-kpi-label">ງົບປະມານປີ</div>
                            <div class="fns-kpi-value">{{ number_format($report['budget'], 0) }}</div>
                        </div>
                        <div class="fns-kpi border-r border-gray-200">
                            <div class="fns-kpi-label">ຈ່າຍແລ້ວ</div>
                            <div class="fns-kpi-value negative">{{ number_format($report['totalSpent'], 0) }}</div>
                        </div>
                        <div class="fns-kpi">
                            <div class="fns-kpi-label">ຍົດເຫຼືອ</div>
                            <div class="fns-kpi-value {{ $report['remaining'] >= 0 ? 'positive' : 'negative' }}">
                                {{ number_format($report['remaining'], 0) }}
                            </div>
                        </div>
                    </div>

                    <div class="fns-meta">
                        <span>ປີງົບປະມານ: <strong>{{ $selectedYear }}</strong></span>
                        <span>ເລກບັນຊີ: <strong>{{ $report['account']?->account_code }}</strong></span>
                        <span>ຈຳນວນລາຍການ: <strong>{{ $report['transactions']->count() }}</strong></span>
                    </div>

                    <div style="overflow-x:auto;">
                        <table class="budget-table fns-table">
                            <thead>
                                <tr>
                                    <th style="width:58px;">ລຳດັບ</th>
                                    <th>ເນື້ອໃນລາຍຈ່າຍ</th>
                                    <th style="width:120px;">ວັນທີ-ເດືອນ-ປີ</th>
                                    <th class="th-right" style="width:130px;">ລາຍຈ່າຍ</th>
                                    <th class="th-right" style="width:140px;">ຍົດຄົງເຫຼືອ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($report['transactions'] as $idx => $txn)
                                    <tr>
                                        <td class="text-center text-gray-400 font-semibold text-sm">{{ $idx + 1 }}</td>
                                        <td class="text-gray-700 text-sm">{{ $txn->description }}</td>
                                        <td class="fns-cell-date whitespace-nowrap">
                                            {{ $txn->transaction_date?->format('d-m-Y') }}
                                        </td>
                                        <td class="amt text-right font-bold text-red-600 whitespace-nowrap">{{ number_format($txn->amount, 0) }}</td>
                                        <td class="bal text-right font-bold whitespace-nowrap {{ $txn->running_balance >= 0 ? ($txn->running_balance < $report['budget'] * 0.1 ? 'text-amber-600' : 'text-emerald-600') : 'text-red-600' }}">
                                            {{ number_format($txn->running_balance, 0) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="fns-empty"><p class="fns-empty-text">ບໍ່ມີລາຍຈ່າຍ</p></div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($report['transactions']->count() > 0)
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align:right;">ລວມທັງໝົດ</td>
                                        <td class="amt text-right font-bold">{{ number_format($report['totalSpent'], 0) }}</td>
                                        <td class="bal text-right font-bold {{ $report['remaining'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                            {{ number_format($report['remaining'], 0) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- ══ Print-only signature ══ --}}
                <div class="print-sign">
                    <div class="ps-date" style="text-align:right;">
                        ວັນທີ: {{ now()->format('d-m-Y') }}
                    </div>
                    <div class="row">
                        <div class="sig"><div class="line">ຫົວໜ້າພະແນກການເງິນ-ເງິນສົດ</div></div>
                        <div class="sig"><div class="line">ນາຍບັນຊີ</div></div>
                    </div>
                </div>

            @elseif($selectedYear && !$plan)
                <div class="fns-card fns-animate">
                    <div class="fns-empty">
                        <p class="fns-empty-text">ປີ {{ $selectedYear }} ຍັງບໍ່ມີແຜນງົບປະມານທີ່ Approved</p>
                    </div>
                </div>
            @else
                <div class="fns-card fns-animate">
                    <div class="fns-empty">
                        <div class="fns-empty-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3v18h18" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 14.25V18m4.5-9V18m4.5-6V18" /></svg>
                        </div>
                        <p class="fns-empty-text">ກະລຸນາເລືອກປີງົບປະມານ ແລະ ໝວດບັນຊີ ເພື່ອສະແດງລາຍງານ</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ໃບ Balance ຕິດຕາມລາຍຈ່າຍງົບປະມານ</title>
    <style>
        /* Google Fonts for Outfit and Lao Language (Noto Sans Lao) */
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;700&family=Outfit:wght@400;600;800&display=swap');

        /* ─── Global Reset & Variables ─── */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', 'Noto Sans Lao', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            line-height: 1.5;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ─── Screen Navigation Bar ─── */
        .no-print-header {
            background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%);
            color: #ffffff;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-left { display: flex; align-items: center; gap: 14px; }
        .header-title { font-size: 15px; font-weight: 800; margin: 0; letter-spacing: -0.3px; }
        .header-right { display: flex; align-items: center; gap: 10px; }

        .btn-back {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.2);
            padding: 7px 14px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s;
        }
        .btn-back:hover { background: rgba(255,255,255,0.25); }

        .btn-nav {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
            padding: 6px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 12px;
            transition: all 0.15s;
        }
        .btn-nav:hover { background: rgba(255,255,255,0.2); }

        .page-info {
            font-size: 12px;
            font-weight: 700;
            background: rgba(0,0,0,0.2);
            padding: 5px 12px;
            border-radius: 20px;
            min-width: 110px;
            text-align: center;
        }

        .btn-print {
            background: #ffffff;
            color: #4f46e5;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 800;
            cursor: pointer;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            transition: all 0.15s;
        }
        .btn-print:hover { background: #f3f2ff; transform: translateY(-1px); }

        /* ─── Preview Container ─── */
        .preview-container {
            max-width: 850px;
            margin: 36px auto;
            padding: 0 20px 60px;
        }

        .sheet-label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .sheet-label-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #4f46e5;
        }

        /* ─── Print Sheet Paper ─── */
        .print-sheet {
            background: #ffffff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            border-radius: 12px;
            padding: 50px 60px;
            min-height: 850px;
            box-sizing: border-box;
            margin-bottom: 36px;
            border: 1px solid #e2e8f0;
            position: relative;
        }

        /* Screen only: hide sheet */
        .hidden-screen { display: none !important; }

        /* ─── Document Header (Centered Title Block & Left-Right Metadata Row) ─── */
        .sheet-header-center {
            text-align: center;
            margin-bottom: 16px;
        }
        .sheet-top-label {
            font-size: 11px;
            font-weight: normal;
            text-decoration: underline;
            text-underline-offset: 3px;
            margin-bottom: 5px;
            display: inline-block;
        }
        .sheet-title {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 4px 0;
            line-height: 1.4;
        }
        .sheet-subtitle {
            font-size: 13px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }
        .sheet-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 12px;
            font-size: 12px;
            line-height: 1.5;
        }
        .sheet-meta-left {
            text-align: left;
        }
        .sheet-meta-right {
            text-align: right;
            font-weight: 600;
            line-height: 1.5;
        }

        /* ─── Print Table ─── */
        .p-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 10px;
            border: 1px solid #000000 !important;
        }
        .p-tbl th, .p-tbl td {
            border: 1px solid #000000 !important;
            padding: 8px 10px;
            color: #000000;
            vertical-align: middle;
            line-height: 1.5;
        }
        .p-tbl th {
            font-weight: bold;
            text-align: center;
            background-color: transparent;
        }
        .p-tbl tfoot td {
            font-weight: bold;
        }
        
        .text-center { text-align: center !important; }
        .text-right  { text-align: right !important; }
        .text-left   { text-align: left !important; }

        /* ─── Signature Section ─── */
        .signatures-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            font-size: 13px;
        }
        .sig-col-left {
            text-align: center;
            width: 40%;
        }
        .sig-col-right {
            text-align: center;
            width: 40%;
        }
        .sig-date {
            margin-bottom: 4px;
        }
        .sig-title {
            font-weight: bold;
        }

        /* ─── Screen Footer ─── */
        .no-print-footer {
            text-align: center;
            padding: 16px;
            font-size: 11px;
            color: #94a3b8;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        /* ─── Print Media ─── */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0; /* Hides browser default headers and footers */
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                background: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .no-print-header,
            .no-print-footer,
            .sheet-label {
                display: none !important;
            }

            .preview-container {
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .hidden-screen {
                display: none !important;
            }

            .print-sheet {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                padding: 10mm 15mm !important;
                min-height: auto !important;
                margin-bottom: 0 !important;
                box-sizing: border-box;
                display: none !important;
                page-break-inside: avoid !important;
            }

            .print-sheet.print-active {
                display: block !important;
            }
        }
    </style>
</head>
<body>

    <!-- Screen Navigation Header -->
    <div class="no-print-header">
        <div class="header-left">
            <a href="{{ route('expense.index') }}" class="btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                ກັບຄືນ
            </a>
            <h2 class="header-title">ໃບ Balance ຕິດຕາມລາຍຈ່າຍງົບປະມານ</h2>
        </div>
        <div class="header-right">
            <button class="btn-nav" onclick="navigateSheet(-1)">◀ ກ່ອນໜ້າ</button>
            <span id="page-indicator" class="page-info">ໃບທີ 1 / 2</span>
            <button class="btn-nav" onclick="navigateSheet(1)">ຖັດໄປ ▶</button>
            <button class="btn-print" onclick="printCurrentSheet()">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                ພິມ (Print)
            </button>
        </div>
    </div>

    <!-- Sheets Container -->
    <div class="preview-container">
        @php $sheetIndex = 0; @endphp

        @foreach($reports as $rep)
            @php
                $account = $rep['account'];
                $s1 = $rep['sheet1'];
                $s2 = $rep['sheet2'];

                $rawCode = $account?->account_code ?? '';
                $formattedCode = strlen($rawCode) === 8
                    ? substr($rawCode, 0, 2).'.'.substr($rawCode, 2, 2).'.'.substr($rawCode, 4, 2).'.'.substr($rawCode, 6, 2)
                    : $rawCode;
            @endphp

            {{-- ═══════════════════════════════════════════════════
                 SHEET 1 — ຮ່ວງ LEVEL (General Account Overview)
            ═══════════════════════════════════════════════════ --}}
            <div class="sheet-label"><span class="sheet-label-dot"></span> ໃບທີ {{ $sheetIndex + 1 }} — ຮ່ວງ: {{ $account?->account_name }}</div>
            <div id="sheet-{{ $sheetIndex }}" class="print-sheet hidden-screen">

                {{-- Document Header --}}
                <div class="sheet-header-center">
                    <div class="sheet-top-label">ໃບບິນຈ່າຍເງິນ</div>
                    <h1 class="sheet-title">ຕິດຕາມລາຍຈ່າຍງົບປະມານ {{ $account?->account_name }}</h1>
                    @if($s1['budget_label'])
                        <h2 class="sheet-subtitle">{{ $s1['budget_label'] }}</h2>
                    @endif
                </div>

                <div class="sheet-meta-row">
                    <div class="sheet-meta-left">
                        <div>ລະຫັດລາຍຈ່າຍ: {{ count($s1['transactions']) }}</div>
                        <div>ຊ່ອງງົບປະມານ:</div>
                        <div>{{ $formattedCode }}</div>
                    </div>
                    <div class="sheet-meta-right">
                        <div>ຕົວເລກອະນຸມັດ: {{ number_format($s1['budget'], 0, ',', '.') }}</div>
                        <div>ຈ່າຍແລ້ວ: {{ number_format($s1['totalSpent'], 0, ',', '.') }}</div>
                        <div class="highlight-remaining">ຍັງເຫຼືອ: {{ number_format($s1['remaining'], 0, ',', '.') }}</div>
                    </div>
                </div>

                {{-- Transactions Table --}}
                <table class="p-tbl">
                    <thead>
                        <tr>
                            <th style="width: 8%;">ລຳດັບ</th>
                            <th style="width: 45%;">ເນື້ອໃນລາຍຈ່າຍ</th>
                            <th style="width: 17%;">ວັນທີ-ເດືອນ-ປີ</th>
                            <th style="width: 15%;">ລາຍຈ່າຍ</th>
                            <th style="width: 15%;">ດຸ່ນດ່ຽງ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($s1['transactions'] as $idx => $txn)
                            @php
                                $lineText = trim((string) ($txn->item_name ?? ''));
                                if ($lineText === '') $lineText = trim((string) ($txn->description ?? ''));
                            @endphp
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td class="text-left">{{ $lineText ?: '—' }}</td>
                                <td class="text-center">{{ $txn->transaction_date?->format('d-m-Y') }}</td>
                                <td class="text-right">{{ number_format($txn->amount, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($txn->running_balance, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php 
                            $footerBal1 = $s1['transactions']->last()->running_balance ?? $s1['remaining'];
                            $lastTxnDate1 = $s1['transactions']->last()?->transaction_date?->format('d-m-Y') ?? $sigDate;
                        @endphp
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-left">ລວມທັງໝົດ</td>
                            <td class="text-center">{{ $lastTxnDate1 }}</td>
                            <td class="text-right">{{ number_format($s1['periodSpent'], 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($footerBal1, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>

                {{-- Signatures --}}
                <div class="signatures-section">
                    <div class="sig-col-left">
                        <div style="height: 24px;"></div>
                        <div class="sig-title">ຫົວໜ້າພະແນກການເງິນ-ຊັບສິນ</div>
                    </div>
                    <div class="sig-col-right">
                        <div class="sig-date">ວັນທີ: {{ $sigDate }}</div>
                        <div class="sig-title">ນາຍບັນຊີ</div>
                    </div>
                </div>
            </div>
            @php $sheetIndex++; @endphp


            {{-- ═══════════════════════════════════════════════════
                 SHEET 2 — ພາກສ່ວນ LEVEL (Per-Department Breakdown)
            ═══════════════════════════════════════════════════ --}}
            <div class="sheet-label"><span class="sheet-label-dot"></span> ໃບທີ {{ $sheetIndex + 1 }} — ຕາມພາກສ່ວນ: {{ $s2['department_name'] }}</div>
            <div id="sheet-{{ $sheetIndex }}" class="print-sheet hidden-screen">

                {{-- Document Header --}}
                <div class="sheet-header-center">
                    <div class="sheet-top-label">ໃບບິນຮັບເງິນ</div>
                    <h1 class="sheet-title">ຕິດຕາມລາຍຈ່າຍງົບປະມານ {{ $account?->account_name }}</h1>
                </div>

                <div class="sheet-meta-row" style="align-items: center;">
                    <div class="sheet-meta-left" style="width: 33%;">
                        <div>ລະຫັດລາຍຈ່າຍ: {{ count($s2['transactions']) }}</div>
                        <div>ເລກບັນຊີຈ່າຍ:</div>
                        <div>{{ $rawCode }}</div>
                    </div>
                    <div style="width: 34%; text-align: center; font-weight: 700; font-size: 13px;">
                        {{ $s2['department_name'] }}
                    </div>
                    <div class="sheet-meta-right" style="width: 33%;">
                        <div>ຕົວເລກອະນຸມັດ: {{ number_format($s2['budget'], 0, ',', '.') }}</div>
                        <div>ຈ່າຍແລ້ວ: {{ number_format($s2['totalSpent'], 0, ',', '.') }}</div>
                        <div class="highlight-remaining">ຍັງເຫຼືອ: {{ number_format($s2['remaining'], 0, ',', '.') }}</div>
                    </div>
                </div>

                {{-- Transactions Table --}}
                <table class="p-tbl">
                    <thead>
                        <tr>
                            <th style="width: 8%;">ລຳດັບ</th>
                            <th style="width: 45%;">ເນື້ອໃນລາຍຈ່າຍ</th>
                            <th style="width: 17%;">ວັນທີ-ເດືອນ-ປີ</th>
                            <th style="width: 15%;">ລາຍຈ່າຍ</th>
                            <th style="width: 15%;">ດຸ່ນດ່ຽງ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($s2['transactions'] as $idx => $txn)
                            @php
                                $lineText2 = trim((string) ($txn->item_name ?? ''));
                                if ($lineText2 === '') $lineText2 = trim((string) ($txn->description ?? ''));
                            @endphp
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td class="text-left">{{ $lineText2 ?: '—' }}</td>
                                <td class="text-center">{{ $txn->transaction_date?->format('d-m-Y') }}</td>
                                <td class="text-right">{{ number_format($txn->amount, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($txn->running_balance, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php 
                            $footerBal2 = $s2['transactions']->last()->running_balance ?? $s2['remaining'];
                            $lastTxnDate2 = $s2['transactions']->last()?->transaction_date?->format('d-m-Y') ?? $sigDate;
                        @endphp
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-left">ລວມທັງໝົດ</td>
                            <td class="text-center">{{ $lastTxnDate2 }}</td>
                            <td class="text-right">{{ number_format($s2['periodSpent'], 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($footerBal2, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>

                {{-- Signatures --}}
                <div class="signatures-section">
                    <div class="sig-col-left">
                        <div style="height: 24px;"></div>
                        <div class="sig-title">ຫົວໜ້າພະແນກການເງິນ-ຊັບສິນ</div>
                    </div>
                    <div class="sig-col-right">
                        <div class="sig-date">ວັນທີ: {{ $sigDate }}</div>
                        <div class="sig-title">นາຍບັນຊີ</div>
                    </div>
                </div>
            </div>
            @php $sheetIndex++; @endphp

        @endforeach
    </div>

    <!-- Footer hint -->
    <div class="no-print-footer">
        💡 ກົດ <b>Enter</b> ຫຼື ໃຊ້ປຸ່ມ ◀ ▶ ເພື່ອສະຫຼັບໃບບິນ &nbsp;|&nbsp; ກົດ <b>Ctrl+P</b> ເພື່ອພິມ
    </div>

    <script>
        const sheets = [...document.querySelectorAll('.print-sheet')];
        let currentIdx = 0;

        function updateIndicator() {
            const el = document.getElementById('page-indicator');
            if (el) el.textContent = `ໃບທີ ${currentIdx + 1} / ${sheets.length}`;
        }

        function showSheet(idx) {
            sheets.forEach((s, i) => {
                s.classList.toggle('hidden-screen', i !== idx);
                s.style.display = i === idx ? 'block' : 'none';
            });
            updateIndicator();
        }

        function navigateSheet(dir) {
            currentIdx = (currentIdx + dir + sheets.length) % sheets.length;
            showSheet(currentIdx);
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'ArrowRight' || e.key === 'Enter') navigateSheet(1);
            if (e.key === 'ArrowLeft')  navigateSheet(-1);
        });

        // Print only the currently displayed sheet
        function printCurrentSheet() {
            // Hide all other sheets from print dynamically using inline style with !important
            sheets.forEach((s, i) => {
                if (i !== currentIdx) {
                    s.style.setProperty('display', 'none', 'important');
                } else {
                    s.style.setProperty('display', 'block', 'important');
                }
            });
            window.print();
        }

        window.addEventListener('afterprint', () => {
            // Restore screen displays
            sheets.forEach((s, i) => {
                s.style.display = i === currentIdx ? 'block' : 'none';
            });

            // Automatically proceed to print the next sheet sequentially
            if (currentIdx < sheets.length - 1) {
                setTimeout(() => {
                    navigateSheet(1);
                    printCurrentSheet();
                }, 500);
            }
        });

        window.onload = function() {
            showSheet(0);
            setTimeout(function() {
                printCurrentSheet();
            }, 500);
        };
    </script>
</body>
</html>
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 min-w-0">
            <div class="flex flex-col gap-0.5 min-w-0">
                <p class="text-xs font-semibold text-[#1e3a5f] uppercase tracking-widest">ລາຍງານ</p>
                <h2 class="text-xl font-bold text-gray-800 truncate">ລາຍງານລາຍຮັບ-ລາຍຈ່າຍ</h2>
            </div>
            <div class="flex flex-wrap items-center gap-2 shrink-0 no-print">
                <a href="{{ route('reports.export', request()->only('type', 'date', 'month')) }}"
                    class="report-btn report-btn-export inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Excel (.xlsx)
                </a>
                <button type="button" onclick="window.print()"
                    class="report-btn report-btn-print inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 2 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    ພິມລາຍງານ
                </button>
            </div>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700;800&display=swap');

        .report-page {
            font-family: 'Noto Sans Lao', 'Lao Sangam MN', 'Phetsarath OT', 'DokChampa', sans-serif;
            text-rendering: optimizeLegibility;
            --rpt-expense-ink: #7f1d1d;
            --rpt-expense-ink-mid: #991b1b;
            --rpt-expense-on-navy: #b91c1c;
        }

        @keyframes reportFade {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .report-outer {
            min-height: calc(100vh - 80px);
            min-height: calc(100dvh - 80px);
            background: #f0f4f8;
            padding: 2rem clamp(1rem, 4vw, 2.25rem);
        }

        @media (max-width: 640px) {
            .report-outer {
                padding: 1rem 0.75rem;
            }

            .report-filter-card {
                padding: 18px 16px;
            }
        }

        .report-inner { width: 100%; }

        .report-btn {
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            font-family: 'Noto Sans Lao', 'Lao Sangam MN', 'Phetsarath OT', 'DokChampa', sans-serif;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            white-space: normal;
            text-align: center;
            justify-content: center;
        }

        @media (min-width: 640px) {
            .report-btn {
                white-space: nowrap;
            }
        }

        .report-btn-export {
            background: linear-gradient(135deg, #1e3a5f, #0f2744);
            color: #fff;
            box-shadow: 0 2px 10px rgba(30,58,95,0.25);
        }
        .report-btn-export:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(30,58,95,0.35); color: #fff; }

        .report-btn-print {
            background: #fff;
            color: #0f2744;
            border: 1.5px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .report-btn-print:hover { background: #f8fafc; border-color: #cbd5e0; }

        .report-filter-card {
            background: #fff;
            border-radius: 18px;
            padding: 24px 28px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 8px 28px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.05);
            animation: reportFade 0.4s ease both;
        }

        .report-label {
            display: block;
            font-size: 0.65rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }

        .report-select, .report-date {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            font-size: 0.875rem;
            font-family: 'Noto Sans Lao', 'Lao Sangam MN', 'Phetsarath OT', 'DokChampa', sans-serif;
            color: #0f172a;
            background: #fff;
            min-width: 0;
            width: 100%;
            max-width: 100%;
        }

        @media (min-width: 640px) {

            .report-select,
            .report-date {
                width: auto;
                min-width: 140px;
                max-width: none;
            }
        }
        .report-select:focus, .report-date:focus {
            outline: none;
            border-color: #1e3a5f;
            box-shadow: 0 0 0 3px rgba(30,58,95,0.12);
        }

        .report-search-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            font-family: 'Noto Sans Lao', 'Lao Sangam MN', 'Phetsarath OT', 'DokChampa', sans-serif;
            color: #0f2744;
            background: linear-gradient(135deg, #f0d078 0%, #f0b429 55%, #d9a008 100%);
            border: 1px solid rgba(15,39,68,0.1);
            box-shadow: 0 2px 10px rgba(240,180,41,0.3);
            cursor: pointer;
            border: none;
        }
        .report-search-btn:hover { filter: brightness(1.03); }

        .report-stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        @media (max-width: 640px) {
            .report-stat-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (min-width: 641px) and (max-width: 1024px) {
            .report-stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .report-stat {
            background: #fff;
            border-radius: 18px;
            padding: 20px 18px;
            text-align: center;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            position: relative;
            overflow: hidden;
            animation: reportFade 0.45s ease both;
        }
        .report-stat::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
        }
        .report-stat--income::before  { background: linear-gradient(90deg, #15803d, #22c55e); }
        .report-stat--expense::before { background: linear-gradient(90deg, #7f1d1d, #991b1b); }
        .report-stat--net::before     { background: linear-gradient(90deg, #1e3a5f, #f0b429); }

        .report-stat .lbl { font-size: 0.72rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
        .report-stat .val { font-size: 1.35rem; font-weight: 800; letter-spacing: -0.02em; line-height: 1.2; }
        .report-stat--income .val  { color: #15803d; }
        .report-stat--expense .val { color: var(--rpt-expense-ink); }
        .report-stat--net .val     { color: #1e3a5f; }
        .report-stat--net .val.negative { color: var(--rpt-expense-ink); }
        .report-stat .unit { font-size: 0.7rem; color: #94a3b8; margin-top: 4px; }

        .report-section {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 8px 28px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
            animation: reportFade 0.5s ease both;
            width: 100%;
            max-width: none;
        }

        .report-section-head {
            padding: 18px 26px;
            display: flex;
            align-items: center;
            gap: 16px;
            background: linear-gradient(135deg, #0f2744 0%, #1e3a5f 75%, #1a4a7a 100%);
            color: #fff;
        }
        .report-section-head .icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: rgba(240,180,41,0.16);
            border: 1px solid rgba(240,180,41,0.28);
            color: #f0b429;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .report-section-head .icon svg { width: 18px; height: 18px; stroke-width: 2.2; }
        .report-section-head h3  { margin: 0; font-size: 0.95rem; font-weight: 800; }
        .report-section-head .sub { font-size: 0.72rem; color: rgba(255,255,255,0.7); margin-top: 4px; }

        .report-table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding: 0 26px 22px;
            box-sizing: border-box;
            width: 100%;
            max-width: none;
        }

        @media (max-width: 479px) {
            .report-section-head { padding: 16px 18px; gap: 12px; }
            .report-table-wrap   { padding: 0 18px 16px; }
        }

        .report-page .rpt-table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            font-size: 0.8125rem;
            table-layout: auto;
        }
        .report-page .rpt-table thead th,
        .report-page .rpt-table tbody td,
        .report-page .rpt-table tfoot td { padding: 14px 18px; vertical-align: top; }

        .report-page .rpt-table thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        .report-page .rpt-table thead th.rpt-th-num { text-align: right; }

        .report-page .rpt-table thead th.rpt-th-num,
        .report-page .rpt-table td.amt-in,
        .report-page .rpt-table td.amt-ex,
        .report-page .rpt-table td.amt-cash { padding-right: 26px; padding-left: 14px; }

        .report-page .rpt-table thead th.text-center,
        .report-page .rpt-table tbody td.text-center { padding-left: 16px; padding-right: 16px; }

        .report-page .rpt-table tbody td  { border-bottom: 1px solid #f1f5f9; }
        .report-page .rpt-table tbody tr:hover { background: #f8faff; }
        .report-page .rpt-table tfoot td { border-bottom: none; border-top: 1px solid #e2e8f0; }

        .pill {
            display: inline-block;
            font-size: 10px; font-weight: 700;
            padding: 5px 12px;
            border-radius: 999px;
            max-width: 180px;
            overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        .pill-income  { background: #ecfdf5; color: #047857; }
        .pill-expense { background: #fef2f2; color: var(--rpt-expense-ink); }

        .amt-in   { font-weight: 700; color: #15803d;               text-align: right; white-space: nowrap; }
        .amt-ex   { font-weight: 700; color: var(--rpt-expense-ink); text-align: right; white-space: nowrap; }
        .amt-cash { font-weight: 700; color: var(--rpt-expense-ink); text-align: right; white-space: nowrap; }

        .report-page .rpt-foot td       { background: #f1f5f9; font-weight: 800; font-size: 0.8125rem; color: #0f2744; }
        .report-page .rpt-foot--in td   { background: #ecfdf5; color: #14532d; }
        .report-page .rpt-foot--ex td   { background: #fff1f2; color: var(--rpt-expense-ink); }
        .report-page .rpt-foot--cash td { background: #fef2f2; color: var(--rpt-expense-ink); }

        .status-pill { display: inline-block; font-size: 10px; font-weight: 700; padding: 6px 12px; border-radius: 999px; }
        .status-cleared { background: #d1fae5; color: #047857; }
        .status-paid    { background: #dbeafe; color: #1d4ed8; }

        .grand-total {
            border-radius: 18px;
            overflow: hidden;
            background: linear-gradient(135deg, #0f2744 0%, #1e3a5f 55%, #152a45 100%);
            color: #fff;
            padding: 26px 32px;
            box-shadow: 0 8px 32px rgba(15,39,68,0.35);
            border: 1px solid rgba(240,180,41,0.2);
            position: relative;
        }
        .grand-total::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #f0b429, #f0d078, #f0b429);
        }
        .grand-total-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            text-align: center;
            padding-top: 8px;
        }
        @media (max-width: 768px) { .grand-total-grid { grid-template-columns: 1fr; } }

        .grand-total .gl  { font-size: 0.68rem; font-weight: 700; color: rgba(255,255,255,0.65); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px; }
        .grand-total .gv  { font-size: 1.25rem; font-weight: 800; color: #f0f4f8; }
        .grand-total .gv-accent  { color: #f0d078; }
        .grand-total .gv-expense,
        .grand-total .gv-warn    { color: var(--rpt-expense-on-navy); }

        /* ── Print-only blocks hidden on screen ── */
        .report-print-header,
        .report-print-kpis,
        .report-print-sign { display: none; }

        /* ════════════════════════════════════════
           PRINT STYLES  — แก้ปัญหาพื้นที่ขาวว่าง
           ════════════════════════════════════════ */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            html {
                width: 210mm !important;
                min-width: 210mm !important;
                min-height: 297mm !important;
                overflow-x: visible !important;
            }

            body,
            body > div.min-h-screen,
            main {
                width: 100% !important;
                min-width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                box-sizing: border-box !important;
            }

            body,
            body > div.min-h-screen {
                min-height: 297mm !important;
                background: #fff !important;
            }

            body > div.min-h-screen {
                display: flex !important;
                flex-direction: column !important;
            }

            main {
                flex: 1 1 auto !important;
                display: flex !important;
                flex-direction: column !important;
                min-height: 0 !important;
            }

            #report-print-root.report-outer {
                flex: 1 1 auto !important;
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                min-width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                min-height: 297mm !important;
                padding: 5mm 4mm !important;
                box-sizing: border-box !important;
            }

            #report-print-root .report-inner {
                flex: 1 1 auto !important;
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                min-width: 100% !important;
                max-width: none !important;
                min-height: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            #report-print-root .report-section,
            #report-print-root .report-section.page-section {
                width: 100% !important;
                max-width: none !important;
                align-self: stretch !important;
                /* ให้ section ขยายเต็มพื้นที่ที่เหลือ */
                flex: 1 1 auto !important;
                display: flex !important;
                flex-direction: column !important;
            }

            /* ให้ table-wrap ขยายตาม section */
            #report-print-root .report-section .report-table-wrap {
                flex: 1 1 auto !important;
                display: flex !important;
                flex-direction: column !important;
            }

            /* ให้ตัวตารางยืดเต็มความสูง */
            #report-print-root .report-section .rpt-table {
                flex: 1 1 auto !important;
            }

            /* tbody ยืดเต็ม — เติมพื้นที่ขาว */
            #report-print-root .report-section .rpt-table tbody {
                height: 100% !important;
            }

            #report-print-root .report-table-wrap {
                width: 100% !important;
                max-width: none !important;
            }

            #report-print-root .report-print-header,
            #report-print-root .report-print-kpis,
            #report-print-root .print-footer-keep {
                width: 100% !important;
                max-width: none !important;
                align-self: stretch !important;
            }

            #report-print-root.report-page {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            #report-print-root .rpt-table {
                width: 100% !important;
                min-width: 100% !important;
                table-layout: auto;
                font-size: 11px;
            }

            .no-print { display: none !important; }

            .report-print-header,
            .report-print-sign { display: block !important; }

            .report-print-kpis { display: flex !important; }

            nav, header { display: none !important; }

            html, body {
                height: auto !important;
                min-height: 297mm !important;
                background: #fff !important;
            }

            .report-page, body { background: #fff !important; }

            /* ระยะห่างระหว่าง section — ลดลงเพื่อให้ตารางมีพื้นที่มากขึ้น */
            #report-print-root .report-inner > * ~ * {
                margin-top: 0.4rem !important;
            }

            #report-print-root .report-inner > .print-footer-keep {
                margin-top: auto !important;
            }

            .report-section,
            .grand-total,
            .report-filter-card {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
            }

            .page-section {
                page-break-inside: auto;
                break-inside: auto;
                margin-bottom: 0.3rem !important;
            }

            .print-footer-keep {
                page-break-inside: avoid;
                break-inside: avoid;
                margin-top: auto !important;
                padding-top: 0.5rem;
            }

            /* ── Section head ── */
            .report-section-head {
                background: #1e3a5f !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                padding: 8px 12px !important;
                gap: 10px !important;
                /* ไม่ให้ขยาย — ขยายแค่ tbody */
                flex: 0 0 auto !important;
            }
            .report-section-head .icon { width: 28px !important; height: 28px !important; }
            .report-section-head .icon svg { width: 14px !important; }
            .report-section-head h3   { font-size: 0.78rem !important; }
            .report-section-head .sub { font-size: 0.62rem !important; margin-top: 0 !important; }

            /* ── Grand total ── */
            .grand-total {
                background: #0f2744 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                padding: 12px 14px !important;
                border-radius: 8px !important;
            }
            .grand-total-grid { gap: 8px !important; padding-top: 2px !important; }
            .grand-total .gl  { font-size: 0.62rem !important; margin-bottom: 3px !important; }
            .grand-total .gv  { font-size: 1.05rem !important; }

            /* ── ตาราง: padding แถวขยายขึ้น เพื่อเติมพื้นที่ขาว ── */
            .report-page .rpt-table thead th,
            .report-page .rpt-table tbody td,
            .report-page .rpt-table tfoot td {
                border: 1px solid #cbd5e1 !important;
                /* เพิ่ม padding บน-ล่าง จาก 4px → 10px
                   ปรับค่านี้ถ้าต้องการขยาย/หดตาราง */
                padding: 10px 6px !important;
            }

            .report-page .rpt-table thead th.rpt-th-num,
            .report-page .rpt-table td.amt-in,
            .report-page .rpt-table td.amt-ex,
            .report-page .rpt-table td.amt-cash { padding-right: 8px !important; }

            .report-table-wrap { padding: 0 0 8px !important; }

            .report-page .rpt-table thead th {
                background: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                font-size: 8.5px !important;
                padding: 6px !important;
            }

            /* ── Print header ── */
            .report-print-header {
                text-align: center;
                border-bottom: 1px solid #0f2744;
                padding-bottom: 6px;
                margin-bottom: 6px;
            }
            .report-print-header .org   { font-size: 10px; font-weight: 700; margin: 0; color: #1e3a5f; }
            .report-print-header .title { font-size: 15px; font-weight: 800; margin: 4px 0; color: #0f172a; }
            .report-print-header .meta  { font-size: 9px; color: #475569; margin: 0; }

            /* ── Print KPIs ── */
            .report-print-kpis { display: flex; gap: 8px; margin-bottom: 8px; }
            .report-print-kpis .kpi { flex: 1; border: 1px solid #94a3b8; padding: 6px 8px; text-align: center; border-radius: 4px; }
            .report-print-kpis .kpi-l { font-size: 8px; color: #64748b; text-transform: uppercase; font-weight: 700; }
            .report-print-kpis .kpi-v { font-size: 11px; font-weight: 800; margin-top: 3px; color: #0f172a; }

            /* ── Signature ── */
            .report-print-sign { margin-top: 10px; }
            .report-print-sign .row { display: flex; justify-content: space-between; gap: 12px; font-size: 10px; color: #334155; }
            .report-print-sign .sig { text-align: center; flex: 1; min-width: 0; max-width: none; width: auto; }
            .report-print-sign .line { margin-top: 20px; border-top: 1px solid #334155; padding-top: 2px; }

            .pill { font-size: 8px !important; padding: 3px 6px !important; max-width: none !important; }
        }
    </style>

    <div id="report-print-root" class="report-outer report-page" lang="lo">
        <div class="report-inner w-full min-w-0 max-w-none mx-auto px-3 sm:px-6 space-y-5 sm:space-y-6">

            {{-- ── Print-only header ── --}}
            <div class="report-print-header">
                <p class="org">ມະຫາວິທະຍາໄລແຫ່ງຊາດ — ຄະນະ</p>
                <h1 class="title">ລາຍງານລາຍຮັບ-ລາຍຈ່າຍ</h1>
                <p class="meta">
                    @if ($type === 'daily')
                        ວັນທີ: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                    @else
                        ເດືອນ: {{ \Carbon\Carbon::parse($month . '-01')->format('m/Y') }}
                    @endif
                    &nbsp;|&nbsp; ພິມວັນທີ: {{ now()->format('d/m/Y H:i') }}
                </p>
            </div>

            {{-- ── Print-only KPIs ── --}}
            <div class="report-print-kpis">
                <div class="kpi">
                    <div class="kpi-l">ລາຍຮັບລວມ</div>
                    <div class="kpi-v" style="color:#15803d;">{{ number_format($totalIncome, 2) }} ກີບ</div>
                </div>
                <div class="kpi">
                    <div class="kpi-l">ລາຍຈ່າຍລວມ</div>
                    <div class="kpi-v" style="color:#7f1d1d;">{{ number_format($totalExpense, 2) }} ກີບ</div>
                </div>
                <div class="kpi">
                    <div class="kpi-l">ຍອດສຸດທິ</div>
                    <div class="kpi-v" style="color:{{ ($totalIncome - $totalExpense) >= 0 ? '#1e3a5f' : '#7f1d1d' }};">
                        {{ number_format($totalIncome - $totalExpense, 2) }} ກີບ
                    </div>
                </div>
            </div>

            {{-- ── Filter (screen only) ── --}}
            <div class="report-filter-card no-print page-section">
                <form method="GET" action="{{ route('reports.index') }}"
                    class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-end sm:gap-5">
                    <div>
                        <label class="report-label">ປະເພດລາຍງານ</label>
                        <select name="type" class="report-select" onchange="this.form.submit()">
                            <option value="daily"   {{ $type === 'daily'   ? 'selected' : '' }}>ປະຈຳວັນ</option>
                            <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>ປະຈຳເດືອນ</option>
                        </select>
                    </div>
                    @if ($type === 'daily')
                        <div>
                            <label class="report-label">ວັນທີ</label>
                            <input type="date" name="date" value="{{ $date }}" class="report-date">
                        </div>
                    @else
                        <div>
                            <label class="report-label">ເດືອນ</label>
                            <input type="month" name="month" value="{{ $month }}" class="report-date">
                        </div>
                    @endif
                    <button type="submit" class="report-search-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        ຄົ້ນຫາ
                    </button>
                </form>
            </div>

            {{-- ── Stat cards (screen only) ── --}}
            <div class="report-stat-grid no-print">
                <div class="report-stat report-stat--income">
                    <div class="lbl">ລາຍຮັບລວມ</div>
                    <div class="val">{{ number_format($totalIncome, 2) }}</div>
                    <div class="unit">ກີບ</div>
                </div>
                <div class="report-stat report-stat--expense">
                    <div class="lbl">ລາຍຈ່າຍລວມ</div>
                    <div class="val">{{ number_format($totalExpense, 2) }}</div>
                    <div class="unit">ກີບ</div>
                </div>
                <div class="report-stat report-stat--net">
                    <div class="lbl">ຍອດສຸດທິ</div>
                    <div class="val {{ ($totalIncome - $totalExpense) < 0 ? 'negative' : '' }}">
                        {{ number_format($totalIncome - $totalExpense, 2) }}
                    </div>
                    <div class="unit">ກີບ</div>
                </div>
            </div>

            {{-- ── ລາຍຮັບ ── --}}
            <div class="report-section page-section">
                <div class="report-section-head">
                    <div class="icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                        </svg>
                    </div>
                    <div>
                        <h3>ລາຍຮັບ</h3>
                        <div class="sub">ລາຍການລາຍຮັບຕາມຊ່ວງທີ່ເລືອກ</div>
                    </div>
                </div>
                <div class="report-table-wrap">
                    <table class="rpt-table">
                        <thead>
                            <tr>
                                <th>ວັນທີ</th>
                                <th>ປະເພດ</th>
                                <th>ລາຍລະອຽດ</th>
                                <th>ພາກສ່ວນ</th>
                                <th class="rpt-th-num">ຈຳນວນ (ກີບ)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($incomeTransactions as $txn)
                                <tr>
                                    <td class="text-slate-500 text-xs font-semibold whitespace-nowrap">
                                        {{ $txn->transaction_date?->format('d/m/Y') }}
                                    </td>
                                    <td><span class="pill pill-income" title="{{ $txn->category }}">{{ $txn->category ?? '—' }}</span></td>
                                    <td class="text-slate-700">{{ $txn->description }}</td>
                                    <td class="text-slate-600">{{ $txn->department?->displayName() }}</td>
                                    <td class="amt-in">{{ number_format($txn->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-slate-400 py-8">ບໍ່ມີລາຍຮັບ</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($incomeTransactions->count() > 0)
                            <tfoot class="rpt-foot rpt-foot--in">
                                <tr>
                                    <td colspan="4" class="text-right">ລວມລາຍຮັບ</td>
                                    <td class="amt-in">{{ number_format($totalIncome, 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            {{-- ── ລາຍຈ່າຍທົ່ວໄປ ── --}}
            <div class="report-section page-section">
                <div class="report-section-head">
                    <div class="icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3>ລາຍຈ່າຍທົ່ວໄປ</h3>
                        <div class="sub">ນັກບັນຊີບັນທຶກ</div>
                    </div>
                </div>
                <div class="report-table-wrap">
                    <table class="rpt-table">
                        <thead>
                            <tr>
                                <th>ວັນທີ</th>
                                <th>ປະເພດ</th>
                                <th>ລາຍລະອຽດ</th>
                                <th>ພາກສ່ວນ</th>
                                <th class="rpt-th-num">ຈຳນວນ (ກີບ)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenseTransactions as $txn)
                                <tr>
                                    <td class="text-slate-500 text-xs font-semibold whitespace-nowrap">
                                        {{ $txn->transaction_date?->format('d/m/Y') }}
                                    </td>
                                    <td><span class="pill pill-expense" title="{{ $txn->category }}">{{ $txn->category ?? '—' }}</span></td>
                                    <td class="text-slate-700">{{ $txn->description }}</td>
                                    <td class="text-slate-600">{{ $txn->department?->displayName() }}</td>
                                    <td class="amt-ex">{{ number_format($txn->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-slate-400 py-8">ບໍ່ມີລາຍຈ່າຍ</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($expenseTransactions->count() > 0)
                            <tfoot class="rpt-foot rpt-foot--ex">
                                <tr>
                                    <td colspan="4" class="text-right">ລວມລາຍຈ່າຍທົ່ວໄປ</td>
                                    <td class="amt-ex">{{ number_format($expenseTransactions->sum('amount'), 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            {{-- ── ລາຍຈ່າຍເງິນສົດ ── --}}
            <div class="report-section page-section">
                <div class="report-section-head">
                    <div class="icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3>ລາຍຈ່າຍເງິນສົດ</h3>
                        <div class="sub">ການເບີກຈ່າຍ / ຄຳຂໍເງິນລ່ວງໜ້າ</div>
                    </div>
                </div>
                <div class="report-table-wrap">
                    <table class="rpt-table">
                        <thead>
                            <tr>
                                <th>ວັນທີ</th>
                                <th>ຜູ້ຂໍ</th>
                                <th>ລາຍລະອຽດ</th>
                                <th>ພາກສ່ວນ</th>
                                <th class="rpt-th-num">ຈຳນວນ (ກີບ)</th>
                                <th class="text-center">ສະຖານະ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $req)
                                <tr>
                                    <td class="text-slate-500 text-xs font-semibold whitespace-nowrap">
                                        {{ $req->paymentTransaction?->transaction_date?->format('d/m/Y') }}
                                    </td>
                                    <td class="font-semibold text-slate-800">{{ $req->requester?->full_name ?? $req->requester?->username }}</td>
                                    <td class="text-slate-700">{{ $req->description }}</td>
                                    <td class="text-slate-600">{{ $req->department?->displayName() }}</td>
                                    <td class="amt-cash">{{ number_format($req->requested_amount, 2) }}</td>
                                    <td class="text-center">
                                        <span class="status-pill {{ $req->status === 'cleared' ? 'status-cleared' : 'status-paid' }}">
                                            {{ $req->status === 'cleared' ? 'ສະສາງແລ້ວ' : 'ຈ່າຍແລ້ວ' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-slate-400 py-8">ບໍ່ມີລາຍຈ່າຍ</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($requests->count() > 0)
                            <tfoot class="rpt-foot rpt-foot--cash">
                                <tr>
                                    <td colspan="4" class="text-right">ລວມລາຍຈ່າຍເງິນສົດ</td>
                                    <td class="amt-cash">{{ number_format($requests->sum('requested_amount'), 2) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            {{-- ── Grand total + Signature ── --}}
            <div class="print-footer-keep">
                <div class="grand-total page-section">
                    <div class="grand-total-grid">
                        <div>
                            <p class="gl">ລາຍຮັບລວມທັງໝົດ</p>
                            <p class="gv gv-accent">{{ number_format($totalIncome, 2) }} ກີບ</p>
                        </div>
                        <div>
                            <p class="gl">ລາຍຈ່າຍລວມທັງໝົດ</p>
                            <p class="gv gv-expense">{{ number_format($totalExpense, 2) }} ກີບ</p>
                        </div>
                        <div>
                            <p class="gl">ຍອດຄົງເຫຼືອ</p>
                            <p class="gv {{ ($totalIncome - $totalExpense) >= 0 ? 'gv-accent' : 'gv-warn' }}">
                                {{ number_format($totalIncome - $totalExpense, 2) }} ກີບ
                            </p>
                        </div>
                    </div>
                </div>

                <div class="report-print-sign">
                    <div class="row">
                        <div class="sig"><div class="line">ຜູ້ສ້າງລາຍງານ</div></div>
                        <div class="sig"><div class="line">ຫົວໜ້າການເງິນ</div></div>
                        <div class="sig"><div class="line">ຫົວໜ້າຄະນະ</div></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
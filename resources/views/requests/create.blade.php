<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="nuol-icon-wrap">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="nuol-page-title">ສ້າງຄໍາຂໍໃໝ່</h2>
                    <p class="nuol-page-sub">ກະລຸນາຕື່ມຂໍ້ມູນໃຫ້ຄົບຖ້ວນ</p>
                </div>
            </div>
            <a href="{{ route('requests.index') }}" class="nuol-btn-back">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                ກັບຄືນ
            </a>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700&display=swap');

        .nuol-page-title {
            font-family: 'Noto Sans Lao', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: #0f2744;
            line-height: 1.2;
        }

        .nuol-page-sub {
            font-family: 'Noto Sans Lao', sans-serif;
            font-size: 0.78rem;
            color: #8a94a6;
            margin-top: 1px;
        }

        .nuol-icon-wrap {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #1e3a5f, #0f2744);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f0b429;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(15, 39, 68, 0.25);
        }

        .nuol-btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: white;
            border: 1.5px solid #e2e8f0;
            color: #4a5568;
            border-radius: 10px;
            font-size: 0.82rem;
            font-family: 'Noto Sans Lao', sans-serif;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .nuol-btn-back:hover {
            background: #f8fafc;
            border-color: #cbd5e0;
            color: #1a202c;
            transform: translateX(-2px);
        }

        /* ===== Main layout ===== */
        .nuol-outer {
            min-height: calc(100vh - 80px);
            background: #f0f4f8;
            padding: 2rem 1rem;
            font-family: 'Noto Sans Lao', sans-serif;
        }

        .nuol-container {
            max-width: 780px;
            width: 100%;
            min-width: 0;
            margin: 0 auto;
        }

        /* ===== Progress bar ===== */
        .nuol-progress {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 1.8rem;
            background: white;
            border-radius: 14px;
            padding: 16px 28px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .nuol-step {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .nuol-step-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .nuol-step.active .nuol-step-num {
            background: linear-gradient(135deg, #1e3a5f, #0f2744);
            color: #f0b429;
        }

        .nuol-step.done .nuol-step-num {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .nuol-step.inactive .nuol-step-num {
            background: #f1f5f9;
            color: #94a3b8;
        }

        .nuol-step-label {
            font-size: 0.78rem;
            font-weight: 600;
        }

        .nuol-step.active .nuol-step-label {
            color: #0f2744;
        }

        .nuol-step.done .nuol-step-label {
            color: #2e7d32;
        }

        .nuol-step.inactive .nuol-step-label {
            color: #94a3b8;
        }

        .nuol-step-connector {
            width: 40px;
            height: 2px;
            background: #e2e8f0;
            flex-shrink: 0;
            margin: 0 4px;
        }

        .nuol-step-connector.done {
            background: #a5d6a7;
        }

        /* ===== Card ===== */
        .nuol-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }

        .nuol-card-header {
            background: linear-gradient(135deg, #0f2744 0%, #1e3a5f 60%, #1a4a7a 100%);
            padding: 24px 32px;
            position: relative;
            overflow: hidden;
        }

        .nuol-card-header::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: rgba(240, 180, 41, 0.08);
        }

        .nuol-card-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 40%;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
        }

        .nuol-card-header-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            margin: 0 0 4px;
            position: relative;
        }

        .nuol-card-title-row {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .nuol-card-title-icon {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(240, 180, 41, 0.14);
            border: 1px solid rgba(240, 180, 41, 0.22);
            color: #f0b429;
            flex-shrink: 0;
        }

        .nuol-card-title-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        .nuol-card-header-sub {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
            position: relative;
        }

        .nuol-gold-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(240, 180, 41, 0.15);
            border: 1px solid rgba(240, 180, 41, 0.3);
            color: #f0b429;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            margin-bottom: 10px;
        }

        /* ===== Form body ===== */
        .nuol-form-body {
            padding: 32px;
        }

        .nuol-section-title {
            font-size: 0.72rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nuol-section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #f1f5f9;
        }

        .nuol-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .nuol-field {
            margin-bottom: 20px;
        }

        .nuol-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
        }

        .nuol-label .required-dot {
            width: 5px;
            height: 5px;
            background: #e53e3e;
            border-radius: 50%;
            display: inline-block;
        }

        .nuol-input,
        .nuol-select,
        .nuol-textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.875rem;
            font-family: 'Noto Sans Lao', sans-serif;
            color: #1a202c;
            background: #fafbfc;
            transition: all 0.2s;
            outline: none;
            box-sizing: border-box;
        }

        .nuol-input:focus,
        .nuol-select:focus,
        .nuol-textarea:focus {
            border-color: #1e3a5f;
            background: white;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.08);
        }

        .nuol-input::placeholder,
        .nuol-textarea::placeholder {
            color: #b0bec5;
        }

        .nuol-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 40px;
            cursor: pointer;
        }

        .nuol-textarea {
            resize: vertical;
            min-height: 100px;
            line-height: 1.6;
        }

        /* ===== Amount field ===== */
        .nuol-amount-wrap {
            position: relative;
        }

        .nuol-amount-wrap .nuol-input {
            padding-right: 54px;
        }

        .nuol-amount-unit {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            pointer-events: none;
            background: #f1f5f9;
            padding: 3px 7px;
            border-radius: 6px;
        }

        /* ===== Error ===== */
        .nuol-errors {
            background: #fff5f5;
            border: 1.5px solid #fed7d7;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 24px;
        }

        .nuol-errors-title {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #c53030;
            margin-bottom: 8px;
        }

        .nuol-errors ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nuol-errors ul li {
            font-size: 0.8rem;
            color: #e53e3e;
            padding: 2px 0;
            padding-left: 14px;
            position: relative;
        }

        .nuol-errors ul li::before {
            content: '•';
            position: absolute;
            left: 3px;
        }

        /* ===== Divider ===== */
        .nuol-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 24px 0;
        }

        /* ===== Footer actions ===== */
        .nuol-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 32px;
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
        }

        .nuol-btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background: linear-gradient(135deg, #1e3a5f, #0f2744);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.88rem;
            font-family: 'Noto Sans Lao', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(15, 39, 68, 0.3);
            letter-spacing: 0.02em;
        }

        .nuol-btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(15, 39, 68, 0.4);
            opacity: 0.95;
        }

        .nuol-btn-submit:active {
            transform: translateY(0);
        }

        .nuol-btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 12px 20px;
            background: white;
            border: 1.5px solid #e2e8f0;
            color: #64748b;
            border-radius: 12px;
            font-size: 0.85rem;
            font-family: 'Noto Sans Lao', sans-serif;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .nuol-btn-cancel:hover {
            background: #f8fafc;
            color: #1a202c;
            border-color: #cbd5e0;
        }

        .nuol-hint {
            margin-left: auto;
            font-size: 0.75rem;
            color: #94a3b8;
        }

        /* ===== Info box ===== */
        .nuol-info-box {
            background: linear-gradient(135deg, #eff6ff, #f0f9ff);
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .nuol-info-box svg {
            flex-shrink: 0;
            color: #3b82f6;
            margin-top: 1px;
        }

        .nuol-info-box p {
            font-size: 0.78rem;
            color: #1e40af;
            line-height: 1.6;
            margin: 0;
        }

        /* ===== Responsive ===== */
        @media (max-width: 640px) {
            .nuol-outer {
                padding: 1rem 0.75rem;
            }

            .nuol-progress {
                padding: 12px 14px;
                flex-wrap: wrap;
                row-gap: 8px;
            }

            .nuol-grid-2 {
                grid-template-columns: 1fr;
            }

            .nuol-form-body {
                padding: 20px;
            }

            .nuol-actions {
                padding: 16px 20px;
                flex-wrap: wrap;
            }

            .nuol-hint {
                display: none;
            }
        }
    </style>

    <div class="nuol-outer w-full min-w-0 max-w-full overflow-x-hidden">
        <div class="nuol-container">

            {{-- Progress Steps --}}
            <div class="nuol-progress">
                <div class="nuol-step active">
                    <div class="nuol-step-num">1</div>
                    <span class="nuol-step-label">ຕື່ມຂໍ້ມູນ</span>
                </div>
                <div class="nuol-step-connector"></div>
                <div class="nuol-step inactive">
                    <div class="nuol-step-num">2</div>
                    <span class="nuol-step-label">ກວດສອບ</span>
                </div>
                <div class="nuol-step-connector"></div>
                <div class="nuol-step inactive">
                    <div class="nuol-step-num">3</div>
                    <span class="nuol-step-label">ອະນຸມັດ</span>
                </div>
            </div>

            {{-- Main card --}}
            <div class="nuol-card">

                {{-- Card header --}}
                <div class="nuol-card-header">
                    <div class="nuol-gold-badge">
                        <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        ມະຫາວິທະຍາໄລແຫ່ງຊາດ
                    </div>
                    <div class="nuol-card-title-row">
                        <div class="nuol-card-title-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25A3.375 3.375 0 004.875 5.625v12.75A3.375 3.375 0 008.25 21.75h7.5A3.75 3.75 0 0019.5 18v-3.75z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 2.25V6a2.25 2.25 0 002.25 2.25h3.75" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 11.25h7.5M8.25 14.25h7.5M8.25 17.25h4.5" />
                            </svg>
                        </div>
                        <h3 class="nuol-card-header-title" style="margin:0;">ແບບຟອມຄໍາຂໍງົບປະມານ</h3>
                    </div>
                    <p class="nuol-card-header-sub">ລະບົບລາຍຮັບ ແລະ ລາຍຈ່າຍຂອງຄະນະ — ກະລຸນາຕື່ມຂໍ້ມູນໃຫ້ຄົບຖ້ວນ</p>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('requests.store') }}">
                    @csrf

                    <div class="nuol-form-body">

                        {{-- Errors --}}
                        @if ($errors->any())
                            <div class="nuol-errors">
                                <div class="nuol-errors-title">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    ກະລຸນາກວດສອບຂໍ້ມູນຕໍ່ໄປນີ້
                                </div>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Section 1: Basic Info --}}
                        <p class="nuol-section-title">ຂໍ້ມູນພື້ນຖານ</p>

                        <div class="nuol-grid-2">
                            {{-- Department --}}
                            <div class="nuol-field">
                                <label for="department_id" class="nuol-label">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2" style="color:#1e3a5f">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    ພາກສ່ວນ <span class="required-dot"></span>
                                </label>
                                <select id="department_id" name="department_id" required class="nuol-select">
                                    <option value="">— ເລືອກພາກສ່ວນ —</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ old('department_id', Auth::user()->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->displayName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Date --}}
                            <div class="nuol-field">
                                <label for="request_date" class="nuol-label">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2" style="color:#1e3a5f">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    ວັນທີ <span class="required-dot"></span>
                                </label>
                                <input id="request_date" name="request_date" type="date" class="nuol-input"
                                    value="{{ old('request_date', today()->toDateString()) }}" required />
                            </div>
                        </div>

                        {{-- Section 2: Details --}}
                        <p class="nuol-section-title">ລາຍລະອຽດຄໍາຂໍ</p>

                        {{-- Description --}}
                        <div class="nuol-field">
                            <label for="description" class="nuol-label">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2" style="color:#1e3a5f">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                                ລາຍລະອຽດ <span class="required-dot"></span>
                            </label>
                            <textarea id="description" name="description" rows="4" required class="nuol-textarea"
                                placeholder="ອະທິບາຍຈຸດປະສົງ ແລະ ລາຍລະອຽດຂອງການຂໍງົບ...">{{ old('description') }}</textarea>
                        </div>

                        {{-- Amount --}}
                        <div class="nuol-field">
                            <label for="requested_amount" class="nuol-label">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2" style="color:#1e3a5f">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                ຈໍານວນເງິນທີ່ຂໍ <span class="required-dot"></span>
                            </label>
                            <div class="nuol-amount-wrap">
                                <input id="requested_amount" name="requested_amount" type="number"
                                    class="nuol-input" min="1" step="0.01"
                                    value="{{ old('requested_amount') }}" placeholder="0.00" required />
                                <span class="nuol-amount-unit">ກີບ</span>
                            </div>
                        </div>

                        {{-- Info note --}}
                        <div class="nuol-info-box">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>ຫຼັງຈາກສ້າງຄໍາຂໍແລ້ວ ລະບົບຈະສົ່ງໄປຫາຜູ້ກ່ຽວຂ້ອງເພື່ອກວດສອບ ແລະ ອະນຸມັດຕໍ່ໄປ.
                                ກະລຸນາກວດຄືນຂໍ້ມູນໃຫ້ຖືກຕ້ອງກ່ອນກົດ "ບັນທຶກ".</p>
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="nuol-actions">
                        <button type="submit" class="nuol-btn-submit">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            ບັນທຶກຄໍາຂໍ
                        </button>
                        <a href="{{ route('requests.index') }}" class="nuol-btn-cancel">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            ຍົກເລີກ
                        </a>
                        <span class="nuol-hint">
                            <span style="color:#e53e3e">•</span> ໝາຍຄວາມວ່າຈໍາເປັນຕ້ອງຕື່ມ
                        </span>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>

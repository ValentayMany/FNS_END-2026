<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="nuol-icon-wrap" aria-hidden="true">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25A3.375 3.375 0 004.875 5.625v12.75A3.375 3.375 0 008.25 21.75h7.5A3.75 3.75 0 0019.5 18v-3.75z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 2.25V6a2.25 2.25 0 002.25 2.25h3.75" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 11.25h7.5M8.25 14.25h4.5" />
                    </svg>
                </div>
                <div>
                    <h2 class="nuol-page-title">ລາຍລະອຽດຄຳຂໍ</h2>
                    <p class="nuol-page-sub">ຄຳຂໍເລກທີ #{{ $advanceRequest->id }}</p>
                </div>
            </div>
            <a href="{{ route('requests.index') }}" class="nuol-btn-back">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                ກັບຄືນ
            </a>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700&display=swap');

        .page-wrap {
            font-family: 'Noto Sans Lao', sans-serif;
        }

        .nuol-page-title {
            font-family: 'Noto Sans Lao', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
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
            font-weight: 600;
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

        .nuol-outer {
            min-height: calc(100vh - 80px);
            background: #f0f4f8;
            padding: 2rem 1rem;
        }

        .nuol-container {
            max-width: 860px;
            margin: 0 auto;
        }

        .nuol-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .nuol-card-header {
            background: linear-gradient(135deg, #0f2744 0%, #1e3a5f 60%, #1a4a7a 100%);
            padding: 22px 28px;
            position: relative;
            overflow: hidden;
        }

        .nuol-card-header::before {
            content: '';
            position: absolute;
            top: -44px;
            right: -44px;
            width: 170px;
            height: 170px;
            border-radius: 50%;
            background: rgba(240, 180, 41, 0.08);
        }

        .nuol-card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-size: 1rem;
            font-weight: 800;
            margin: 0;
            position: relative;
        }

        .nuol-card-title .title-icon {
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

        .nuol-card-title .title-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        .nuol-card-sub {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.8rem;
            margin-top: 4px;
            position: relative;
        }

        .nuol-card-body {
            padding: 26px 28px;
        }

        .nuol-kv {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px 20px;
            font-size: 0.9rem;
        }

        .nuol-kv .k {
            font-size: 0.72rem;
            color: #94a3b8;
            font-weight: 700;
            letter-spacing: 0.02em;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .nuol-kv .v {
            color: #0f172a;
            font-weight: 600;
        }

        .nuol-amount {
            font-size: 1.35rem;
            font-weight: 900;
            color: #1e3a5f;
            letter-spacing: -0.02em;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.75;
        }

        .badge-draft {
            background: #f1f5f9;
            color: #64748b;
        }

        .badge-pending {
            background: #fffbeb;
            color: #b45309;
        }

        .badge-review {
            background: #fff7ed;
            color: #c2410c;
        }

        .badge-deputy {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .badge-faculty {
            background: #f5f3ff;
            color: #6d28d9;
        }

        .badge-approved {
            background: #f0fdf4;
            color: #15803d;
        }

        .badge-paid {
            background: #f0fdfa;
            color: #0f766e;
        }

        .badge-clearing {
            background: #fdf2f8;
            color: #a21caf;
        }

        .badge-cleared {
            background: #ecfdf5;
            color: #047857;
        }

        .badge-rejected {
            background: #fef2f2;
            color: #b91c1c;
        }

        .nuol-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 28px;
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
            flex-wrap: wrap;
        }

        .nuol-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.88rem;
            color: white;
            background: linear-gradient(135deg, #1e3a5f, #0f2744);
            box-shadow: 0 4px 14px rgba(15, 39, 68, 0.28);
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
        }

        .nuol-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(15, 39, 68, 0.38);
            opacity: 0.95;
        }

        .nuol-btn-warn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.88rem;
            color: white;
            background: linear-gradient(135deg, #ea580c, #c2410c);
            box-shadow: 0 4px 14px rgba(194, 65, 12, 0.26);
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
        }

        .nuol-btn-warn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(194, 65, 12, 0.34);
            opacity: 0.95;
        }

        .nuol-alert {
            border-radius: 14px;
            padding: 12px 14px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.88rem;
            font-weight: 600;
            border: 1px solid transparent;
        }

        .nuol-alert svg {
            width: 18px;
            height: 18px;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .nuol-alert.success {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #166534;
        }

        .nuol-alert.error {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .timeline-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
        }

        .timeline-item:first-child {
            padding-top: 0;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-icon {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            background: #eff6ff;
            color: #1e3a5f;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(30, 58, 95, 0.12);
        }

        .timeline-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        .timeline-meta {
            color: #64748b;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .timeline-comment {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 12px;
            margin-top: 8px;
            font-size: 0.85rem;
            color: #334155;
            line-height: 1.6;
        }

        @media (max-width: 640px) {
            .nuol-kv {
                grid-template-columns: 1fr;
            }

            .nuol-card-body {
                padding: 20px;
            }

            .nuol-card-header {
                padding: 18px 20px;
            }

            .nuol-actions {
                padding: 16px 20px;
            }
        }
    </style>

    <div class="nuol-outer page-wrap">
        <div class="nuol-container space-y-5">

            @if (session('success'))
                <div class="nuol-alert success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12.75l2.25 2.25L15 9.75" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" />
                    </svg>
                    <div>{{ session('success') }}</div>
                </div>
            @endif
            @if (session('error'))
                <div class="nuol-alert error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" />
                    </svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            {{-- ລາຍລະອຽດ --}}
            <div class="nuol-card">
                <div class="nuol-card-header">
                    <h3 class="nuol-card-title">
                        <span class="title-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        ຂໍ້ມູນຄຳຂໍ
                    </h3>
                    <div class="nuol-card-sub">ລາຍລະອຽດຂອງຄຳຂໍຂອງທ່ານ</div>
                </div>
                <div class="nuol-card-body">
                    <div class="nuol-kv">
                        <div>
                            <div class="k">ຜູ້ຂໍ</div>
                            <div class="v">
                                {{ $advanceRequest->requester?->full_name ?? $advanceRequest->requester?->username }}
                            </div>
                        </div>
                        <div>
                            <div class="k">ສະຖານະ</div>
                            @php
                                $badgeMap = [
                                    'draft' => ['class' => 'badge-draft', 'label' => 'ຮ່າງ'],
                                    'pending_accountant_review' => ['class' => 'badge-pending', 'label' => 'ລໍຖ້ານັກບັນຊີ'],
                                    'pending_finance_head_review' => ['class' => 'badge-review', 'label' => 'ລໍຖ້າຫົວໜ້າການເງິນ'],
                                    'pending_deputy_head_approval' => ['class' => 'badge-deputy', 'label' => 'ລໍຖ້າຮອງຄະນະ'],
                                    'pending_faculty_head_approval' => ['class' => 'badge-faculty', 'label' => 'ລໍຖ້າຄະນະບໍດີ'],
                                    'approved' => ['class' => 'badge-approved', 'label' => 'ອະນຸມັດ'],
                                    'paid' => ['class' => 'badge-paid', 'label' => 'ຈ່າຍແລ້ວ'],
                                    'pending_clearing' => ['class' => 'badge-clearing', 'label' => 'ລໍຖ້າເຄຼຍ'],
                                    'cleared' => ['class' => 'badge-cleared', 'label' => 'ເຄຼຍແລ້ວ'],
                                    'rejected' => ['class' => 'badge-rejected', 'label' => 'ປະຕິເສດ'],
                                ];
                                $badge = $badgeMap[$advanceRequest->status] ?? ['class' => 'badge-draft', 'label' => $advanceRequest->status];
                            @endphp
                            <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                        </div>
                        <div>
                            <div class="k">ພາກສ່ວນ</div>
                            <div class="v">{{ $advanceRequest->department?->displayName() }}</div>
                        </div>
                        <div>
                            <div class="k">ວັນທີຄຳຂໍ</div>
                            <div class="v">{{ $advanceRequest->request_date?->format('d/m/Y') }}</div>
                        </div>
                        <div>
                            <div class="k">ຈຳນວນເງິນ</div>
                            <div class="nuol-amount">{{ number_format($advanceRequest->requested_amount, 2) }} ກີບ</div>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <div class="k">ລາຍລະອຽດ</div>
                            <div class="v" style="font-weight: 500; color:#334155; line-height: 1.7;">
                                {{ $advanceRequest->description }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ປຸ່ມສົ່ງຄຳຂໍ --}}
            @if ($advanceRequest->status === 'draft' && $advanceRequest->requester_id === Auth::id())
                <div class="nuol-card">
                    <div class="nuol-card-body" style="padding-bottom: 14px;">
                        <div class="k" style="margin-bottom: 10px;">ດຳເນີນການ</div>
                        <div class="v" style="font-weight: 500; color:#64748b;">
                            ກວດຄືນຂໍ້ມູນ ແລະ ສົ່ງຄຳຂໍເຂົ້າລະບົບເພື່ອໃຫ້ຜູ້ກ່ຽວຂ້ອງກວດສອບ
                        </div>
                    </div>
                    <div class="nuol-actions">
                    <form method="POST" action="{{ route('requests.submit', $advanceRequest) }}">
                        @csrf
                        <button class="nuol-btn-primary" type="submit">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 10.5l18-7.5-7.5 18-2.25-7.5L3 10.5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 12.75L21 3" />
                            </svg>
                            ສົ່ງຄຳຂໍເຂົ້າລະບົບ
                        </button>
                    </form>
                    </div>
                </div>
            @endif

            {{-- ປຸ່ມສົ່ງ Clearing --}}
            @if ($advanceRequest->status === 'paid' && $advanceRequest->requester_id === Auth::id())
                <div class="nuol-card">
                    <div class="nuol-card-body" style="padding-bottom: 14px;">
                        <div class="k" style="margin-bottom: 10px;">ສົ່ງໃບສະສາງ</div>
                        <div class="v" style="font-weight: 500; color:#64748b;">
                            ຫຼັງຈາກຮັບເງິນແລ້ວ ກະລຸນາສົ່ງໃບສະສາງເພື່ອດຳເນີນການເຄຼຍ
                        </div>
                    </div>
                    <div class="nuol-actions">
                    <form method="POST" action="{{ route('clearing.submit', $advanceRequest) }}">
                        @csrf
                        <button type="submit" class="nuol-btn-warn">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            ສົ່ງໃບສະສາງ
                        </button>
                    </form>
                    </div>
                </div>
            @endif

            {{-- Workflow Timeline --}}
            <div class="nuol-card">
                <div class="nuol-card-header">
                    <h3 class="nuol-card-title">
                        <span class="title-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6l3 3" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        ປະຫວັດການດຳເນີນການ
                    </h3>
                    <div class="nuol-card-sub">ໄທມ໌ໄລນ໌ການກວດສອບ ແລະ ອະນຸມັດ</div>
                </div>
                <div class="nuol-card-body">
                @forelse($advanceRequest->workflowLogs as $log)
                    <div class="timeline-item">
                        <div class="timeline-icon" aria-hidden="true">
                            @if (str_contains($log->action, 'approved'))
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75l2.25 2.25L15 9.75" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" />
                                </svg>
                            @elseif(str_contains($log->action, 'rejected'))
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" />
                                </svg>
                            @elseif(str_contains($log->action, 'paid'))
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 8.25h19.5m-19.5 7.5h19.5M3.75 6h16.5A1.5 1.5 0 0121.75 7.5v9A1.5 1.5 0 0120.25 18H3.75A1.5 1.5 0 012.25 16.5v-9A1.5 1.5 0 013.75 6z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                </svg>
                            @elseif(str_contains($log->action, 'clearing'))
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @elseif(str_contains($log->action, 'submitted'))
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 10.5l18-7.5-7.5 18-2.25-7.5L3 10.5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 12.75L21 3" />
                                </svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.688-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 7.125L16.875 4.5" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">
                                {{ $log->actor?->full_name ?? $log->actor?->username }}
                                <span class="timeline-meta">({{ $log->actorRoleDisplay() }})</span>
                            </p>
                            <p class="timeline-meta">
                                {{ $log->action }} ·
                                {{ $log->timestamp?->timezone(config('app.timezone'))->format('d/m/Y H:i') }}
                            </p>
                            @if ($log->comments)
                                <div class="timeline-comment">
                                    {{ $log->comments }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400 text-sm font-semibold">ຍັງບໍ່ມີການດຳເນີນການ</p>
                @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

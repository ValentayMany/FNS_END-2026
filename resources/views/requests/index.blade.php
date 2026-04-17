<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center min-w-0">
            <div class="min-w-0">
                <p class="text-xs font-medium text-indigo-400 uppercase tracking-widest mb-0.5">ລະບົບການເງິນ</p>
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 break-words">ຄຳຂໍເບີກເງິນຂອງຂ້ອຍ</h2>
            </div>
            <a href="{{ route('requests.create') }}"
                class="new-btn shrink-0 inline-flex justify-center items-center gap-2 px-4 sm:px-5 py-2.5 rounded-xl text-sm font-semibold text-white shadow-lg w-full sm:w-auto min-h-[44px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                ສ້າງຄຳຂໍໃໝ່
            </a>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700&display=swap');

        .page-wrap {
            font-family: 'Noto Sans Lao', sans-serif;
        }

        /* Header button */
        .new-btn {
            background: linear-gradient(135deg, #1e3a5f, #0f2744);
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .new-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12), transparent);
            opacity: 0;
            transition: opacity 0.25s;
        }

        .new-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 58, 95, 0.4);
        }

        .new-btn:hover::after {
            opacity: 1;
        }

        /* Stats cards */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.5s ease both;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .stat-card.c-blue::before {
            background: linear-gradient(90deg, #1e3a5f, #3b82f6);
        }

        .stat-card.c-gold::before {
            background: linear-gradient(90deg, #d97706, #fbbf24);
        }

        .stat-card.c-green::before {
            background: linear-gradient(90deg, #059669, #34d399);
        }

        .stat-card.c-red::before {
            background: linear-gradient(90deg, #dc2626, #f87171);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .stat-icon svg {
            width: 22px;
            height: 22px;
            stroke-width: 2;
        }

        .table-head-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }

        .table-head-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        /* Table card */
        .table-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06), 0 8px 32px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
            animation: slideUp 0.5s 0.15s ease both;
        }

        .table-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 100%);
            padding: 20px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        @media (max-width: 640px) {
            .table-header {
                padding: 16px 18px;
            }
        }

        /* Table */
        table {
            border-collapse: collapse;
        }

        thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
            animation: fadeRow 0.4s ease both;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #f8faff;
        }

        tbody tr:hover .row-id {
            color: #1e3a5f;
        }

        tbody td {
            padding: 16px 20px;
        }

        .row-id {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 600;
            transition: color 0.2s;
        }

        .row-dept {
            font-size: 13px;
            color: #374151;
            font-weight: 500;
        }

        .row-desc {
            font-size: 13px;
            color: #6b7280;
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .row-amount {
            font-size: 14px;
            font-weight: 700;
            color: #1e3a5f;
            letter-spacing: -0.02em;
        }

        .row-date {
            font-size: 12px;
            color: #94a3b8;
        }

        /* Status badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.7;
            animation: pulse-dot 2s ease-in-out infinite;
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

        /* Only pulse for active/pending statuses */
        .badge-approved::before,
        .badge-paid::before,
        .badge-cleared::before {
            animation: none;
            opacity: 1;
        }

        /* View button */
        .view-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            background: #f1f5f9;
            color: #475569;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .view-btn:hover {
            background: #1e3a5f;
            color: #fff;
            transform: scale(1.04);
            box-shadow: 0 4px 10px rgba(30, 58, 95, 0.25);
        }

        /* Empty state */
        .empty-state {
            padding: 72px 24px;
            text-align: center;
        }

        .empty-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #64748b;
        }

        .empty-icon svg {
            width: 34px;
            height: 34px;
            stroke-width: 2;
        }

        /* Animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeRow {
            from {
                opacity: 0;
                transform: translateX(-6px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 0.5;
                transform: scale(1);
            }

            50% {
                opacity: 1;
                transform: scale(1.3);
            }
        }

        /* Stagger rows */
        tbody tr:nth-child(1) {
            animation-delay: 0.10s;
        }

        tbody tr:nth-child(2) {
            animation-delay: 0.15s;
        }

        tbody tr:nth-child(3) {
            animation-delay: 0.20s;
        }

        tbody tr:nth-child(4) {
            animation-delay: 0.25s;
        }

        tbody tr:nth-child(5) {
            animation-delay: 0.30s;
        }

        tbody tr:nth-child(6) {
            animation-delay: 0.35s;
        }

        tbody tr:nth-child(7) {
            animation-delay: 0.40s;
        }

        tbody tr:nth-child(8) {
            animation-delay: 0.45s;
        }

        tbody tr:nth-child(9) {
            animation-delay: 0.50s;
        }

        tbody tr:nth-child(10) {
            animation-delay: 0.55s;
        }

        /* Stat cards stagger */
        .stat-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.10s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.20s;
        }
    </style>

    <div class="py-6 sm:py-8 page-wrap w-full min-w-0">
        <div class="max-w-6xl mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6 space-y-5 sm:space-y-6">

            {{-- Success alert --}}
            @if (session('success'))
                <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium"
                    style="animation: slideUp 0.4s ease both;">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Stats row --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                @php
                    $total = $requests->total() ?? count($requests);
                    $approved =
                        $requests->getCollection()->where('status', 'approved')->count() +
                        $requests->getCollection()->where('status', 'paid')->count() +
                        $requests->getCollection()->where('status', 'cleared')->count();
                    $pending = $requests
                        ->getCollection()
                        ->filter(fn($r) => str_contains($r->status, 'pending') || $r->status === 'draft')
                        ->count();
                    $rejected = $requests->getCollection()->where('status', 'rejected')->count();
                @endphp
                <div class="stat-card c-blue">
                    <div class="stat-icon" style="background:#eff6ff; color:#1d4ed8;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25A3.375 3.375 0 004.875 5.625v12.75A3.375 3.375 0 008.25 21.75h3.75" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 2.25V6a2.25 2.25 0 002.25 2.25h3.75" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 10.5h7.5M8.25 13.5h4.5" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.75a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 20.25l-1.5-1.5" />
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">{{ $total }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">ຄຳຂໍທັງໝົດ</p>
                </div>
                <div class="stat-card c-gold">
                    <div class="stat-icon" style="background:#fffbeb; color:#b45309;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6l3 3" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">{{ $pending }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">ກຳລັງດຳເນີນ</p>
                </div>
                <div class="stat-card c-green">
                    <div class="stat-icon" style="background:#f0fdf4; color:#15803d;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75l2.25 2.25L15 9.75" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" />
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">{{ $approved }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">ອະນຸມັດແລ້ວ</p>
                </div>
                <div class="stat-card c-red">
                    <div class="stat-icon" style="background:#fef2f2; color:#b91c1c;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" />
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">{{ $rejected }}</p>
                    <p class="text-xs text-gray-400 mt-1 font-medium">ຖືກປະຕິເສດ</p>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-card">

                {{-- Table header banner --}}
                <div class="table-header">
                    <div class="flex items-center gap-3">
                        <div class="table-head-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25A3.375 3.375 0 004.875 5.625v12.75A3.375 3.375 0 008.25 21.75h7.5A3.75 3.75 0 0019.5 18v-3.75z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 2.25V6a2.25 2.25 0 002.25 2.25h3.75" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 11.25h7.5M8.25 14.25h7.5M8.25 17.25h4.5" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">ລາຍການຄຳຂໍ</p>
                            <p class="text-blue-200 text-xs mt-0.5">ຄຳຂໍເບີກເງິນທັງໝົດຂອງທ່ານ</p>
                        </div>
                    </div>
                    <div style="background:rgba(255,255,255,0.1);border-radius:20px;padding:4px 12px;">
                        <span class="text-white text-xs font-semibold">{{ $requests->total() ?? count($requests) }}
                            ລາຍການ</span>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto touch-pan-x">
                    <table class="w-full min-w-[40rem] text-sm">
                        <thead>
                            <tr>
                                <th class="text-left" style="width:60px;">#</th>
                                <th class="text-left">ພາກສ່ວນ</th>
                                <th class="text-left">ລາຍລະອຽດ</th>
                                <th class="text-right">ຈຳນວນ (ກີບ)</th>
                                <th class="text-center">ສະຖານະ</th>
                                <th class="text-center">ວັນທີ</th>
                                <th class="text-center" style="width:80px;">ເບິ່ງ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $req)
                                <tr>
                                    <td><span class="row-id">#{{ $req->id }}</span></td>
                                    <td>
                                        <span class="row-dept">{{ $req->department?->displayName() }}</span>
                                    </td>
                                    <td>
                                        <span class="row-desc"
                                            title="{{ $req->description }}">{{ $req->description }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span class="row-amount">{{ number_format($req->requested_amount, 2) }}</span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $badgeMap = [
                                                'draft' => ['class' => 'badge-draft', 'label' => 'ຮ່າງ'],
                                                'pending_accountant_review' => [
                                                    'class' => 'badge-pending',
                                                    'label' => 'ລໍຖ້ານັກບັນຊີ',
                                                ],
                                                'pending_finance_head_review' => [
                                                    'class' => 'badge-review',
                                                    'label' => 'ລໍຖ້າຫົວໜ້າການເງິນ',
                                                ],
                                                'pending_deputy_head_approval' => [
                                                    'class' => 'badge-deputy',
                                                    'label' => 'ລໍຖ້າຮອງຄະນະ',
                                                ],
                                                'pending_faculty_head_approval' => [
                                                    'class' => 'badge-faculty',
                                                    'label' => 'ລໍຖ້າຄະນະບໍດີ',
                                                ],
                                                'approved' => ['class' => 'badge-approved', 'label' => 'ອະນຸມັດ'],
                                                'paid' => ['class' => 'badge-paid', 'label' => 'ຈ່າຍແລ້ວ'],
                                                'pending_clearing' => [
                                                    'class' => 'badge-clearing',
                                                    'label' => 'ລໍຖ້າເຄຼຍ',
                                                ],
                                                'cleared' => ['class' => 'badge-cleared', 'label' => 'ເຄຼຍແລ້ວ'],
                                                'rejected' => ['class' => 'badge-rejected', 'label' => 'ປະຕິເສດ'],
                                            ];
                                            $badge = $badgeMap[$req->status] ?? [
                                                'class' => 'badge-draft',
                                                'label' => $req->status,
                                            ];
                                        @endphp
                                        <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="row-date">{{ $req->request_date?->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('requests.show', $req) }}" class="view-btn">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            ເບິ່ງ
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M21.75 12.75v5.25A2.25 2.25 0 0119.5 20.25H4.5A2.25 2.25 0 012.25 18v-5.25m19.5 0v-.243a2.25 2.25 0 00-1.07-1.918l-7.5-4.615a2.25 2.25 0 00-2.36 0l-7.5 4.615A2.25 2.25 0 002.25 12.507v.243m19.5 0L13.81 14.9a2.25 2.25 0 01-3.62 0L2.25 12.75" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-semibold text-sm mb-1">ຍັງບໍ່ມີຄຳຂໍເທື່ອ</p>
                                            <p class="text-gray-400 text-xs mb-5">ເລີ່ມຕົ້ນດ້ວຍການສ້າງຄຳຂໍໃໝ່ຂອງທ່ານ</p>
                                            <a href="{{ route('requests.create') }}"
                                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white"
                                                style="background: linear-gradient(135deg, #1e3a5f, #0f2744);">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M12 4v16m8-8H4" />
                                                </svg>
                                                ສ້າງຄຳຂໍໃໝ່
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($requests->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/60">
                        {{ $requests->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-semibold text-[#1e3a5f] uppercase tracking-widest">ການອະນຸມັດ</p>
            <h2 class="text-xl font-bold text-gray-800">ລາຍການທີ່ຕ້ອງອະນຸມັດ</h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700&display=swap');

        .approval-page {
            font-family: 'Noto Sans Lao', sans-serif;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeRow {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .table-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06), 0 8px 32px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
            animation: slideUp 0.5s 0.1s ease both;
        }

        .approval-page .table-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 100%);
            padding: 20px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        @media (max-width: 640px) {
            .approval-page .table-header {
                padding: 16px 18px;
            }
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

        .approval-page table {
            border-collapse: collapse;
        }

        .approval-page thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .approval-page tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
            animation: fadeRow 0.4s ease both;
        }

        .approval-page tbody tr:last-child {
            border-bottom: none;
        }

        .approval-page tbody tr:hover {
            background: #f8faff;
        }

        .approval-page tbody tr:hover .row-id {
            color: #1e3a5f;
        }

        .approval-page tbody td {
            padding: 16px 20px;
        }

        .approval-page .action-cell {
            white-space: nowrap;
            width: 1%;
            vertical-align: middle;
        }

        .row-id {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 600;
        }

        .row-name {
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
        }

        .row-dept {
            font-size: 13px;
            color: #374151;
            font-weight: 500;
        }

        .row-desc {
            font-size: 13px;
            color: #6b7280;
            max-width: 260px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .row-amount {
            font-size: 14px;
            font-weight: 700;
            color: #1e3a5f;
        }

        .row-date {
            font-size: 12px;
            color: #94a3b8;
        }

        .view-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.2;
            white-space: nowrap;
            background: linear-gradient(135deg, #1e3a5f, #0f2744);
            color: #fff;
            transition: all 0.2s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 8px rgba(30, 58, 95, 0.2);
            text-decoration: none;
        }

        .view-btn svg {
            flex-shrink: 0;
        }

        .view-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(30, 58, 95, 0.35);
            color: #fff;
        }

        .empty-state {
            padding: 56px 24px;
            text-align: center;
            color: #94a3b8;
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            opacity: 0.5;
            color: #1e3a5f;
        }
    </style>

    <div class="py-6 sm:py-8 approval-page w-full min-w-0">
        <div class="max-w-6xl mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6 space-y-5 sm:space-y-6">

            @if (session('success'))
                <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium"
                    style="animation: slideUp 0.4s ease both;">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium"
                    style="animation: slideUp 0.4s ease both;">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-card">
                <div class="table-header">
                    <div class="flex items-center gap-3">
                        <div class="table-head-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 13.5l.5 1.75a2.25 2.25 0 001.5 1.5l1.75.5-1.75.5a2.25 2.25 0 00-1.5 1.5L18 21l-.5-1.75a2.25 2.25 0 00-1.5-1.5l-1.75-.5 1.75-.5a2.25 2.25 0 001.5-1.5L18 13.5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">ລາຍການລໍຖ້າອະນຸມັດ</p>
                            <p class="text-blue-200/90 text-xs mt-0.5">ກວດສອບ ແລະ ອະນຸມັດຄຳຂໍຕາມລຳດັບ</p>
                        </div>
                    </div>
                    <div class="rounded-full px-3 py-1 bg-white/10 ring-1 ring-white/15">
                        <span class="text-white text-xs font-semibold">
                            {{ $requests instanceof \Illuminate\Pagination\LengthAwarePaginator ? $requests->total() : count($requests) }}
                            ລາຍການ
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto touch-pan-x">
                    <table class="w-full text-sm min-w-[44rem]">
                        <thead>
                            <tr>
                                <th class="text-left" style="width:64px;">#</th>
                                <th class="text-left">ຜູ້ຂໍ</th>
                                <th class="text-left">ພາກສ່ວນ</th>
                                <th class="text-left">ລາຍລະອຽດ</th>
                                <th class="text-right">ຈຳນວນ (ກີບ)</th>
                                <th class="text-center">ວັນທີ</th>
                                <th class="text-center action-cell">ດຳເນີນການ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $req)
                                <tr>
                                    <td><span class="row-id">#{{ $req->id }}</span></td>
                                    <td>
                                        <span class="row-name">
                                            {{ $req->requester?->full_name ?? $req->requester?->username }}
                                        </span>
                                    </td>
                                    <td><span class="row-dept">{{ $req->department?->displayName() }}</span></td>
                                    <td>
                                        <span class="row-desc" title="{{ $req->description }}">{{ $req->description }}</span>
                                    </td>
                                    <td class="text-right"><span class="row-amount">{{ number_format($req->requested_amount, 2) }}</span></td>
                                    <td class="text-center"><span class="row-date">{{ $req->request_date?->format('d/m/Y') }}</span></td>
                                    <td class="text-center action-cell">
                                        <a href="{{ route('approval.show', $req->id) }}" class="view-btn">
                                            <svg class="w-3.5 h-3.5 opacity-90" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            ກວດສອບ
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-sm font-medium text-gray-500">ບໍ່ມີລາຍການທີ່ຕ້ອງດຳເນີນການ</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($requests instanceof \Illuminate\Pagination\LengthAwarePaginator && $requests->hasPages())
                    <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/80">{{ $requests->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

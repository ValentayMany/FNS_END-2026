<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-semibold text-[#1e3a5f] uppercase tracking-widest">ການຈ່າຍເງິນ</p>
            <h2 class="text-xl font-bold text-gray-800">ລາຍການທີ່ຕ້ອງຈ່າຍເງິນ</h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700&display=swap');

        .cashier-page {
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

        .cashier-page .table-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 100%);
            padding: 20px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        @media (max-width: 640px) {
            .cashier-page .table-header {
                padding: 16px 18px;
            }
        }

        .table-head-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(240, 180, 41, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f0b429;
            border: 1px solid rgba(240, 180, 41, 0.28);
        }

        .table-head-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        .cashier-page table {
            border-collapse: collapse;
        }

        .cashier-page thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .cashier-page tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
            animation: fadeRow 0.4s ease both;
        }

        .cashier-page tbody tr:last-child {
            border-bottom: none;
        }

        .cashier-page tbody tr:hover {
            background: #f8faff;
        }

        .cashier-page tbody tr:hover .row-id {
            color: #1e3a5f;
        }

        .cashier-page tbody td {
            padding: 16px 20px;
        }

        .cashier-page .action-cell {
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

        .pay-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.2;
            white-space: nowrap;
            font-family: 'Noto Sans Lao', sans-serif;
            background: linear-gradient(135deg, #f0d078 0%, #f0b429 45%, #d9a008 100%);
            color: #0f2744;
            border: 1px solid rgba(15, 39, 68, 0.12);
            box-shadow: 0 2px 10px rgba(240, 180, 41, 0.35);
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .pay-btn svg {
            flex-shrink: 0;
        }

        .pay-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(240, 180, 41, 0.45);
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

    <div class="py-6 sm:py-8 cashier-page w-full min-w-0">
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
                        <div class="table-head-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">ລາຍການລໍຖ້າຈ່າຍ</p>
                            <p class="text-blue-200/90 text-xs mt-0.5">ບັນທຶກການຈ່າຍຄຳຂໍທີ່ອະນຸມັດແລ້ວ</p>
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
                            @forelse ($requests as $req)
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
                                        <form method="POST" action="{{ route('cashier.pay', $req) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="pay-btn">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                ຈ່າຍເງິນ
                                            </button>
                                        </form>
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
                                            <p class="text-sm font-medium text-gray-500">ບໍ່ມີລາຍການທີ່ຕ້ອງຈ່າຍເງິນ</p>
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

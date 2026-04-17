<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-semibold text-[#1e3a5f] uppercase tracking-widest">ການສະສາງ</p>
            <h2 class="text-xl font-bold text-gray-800">ໃບສະສາງ (Clearing)</h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700&display=swap');

        .clearing-page {
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

        .clearing-outer {
            min-height: calc(100vh - 80px);
            min-height: calc(100dvh - 80px);
            background: #f0f4f8;
            padding: 2rem 1rem;
        }

        @media (max-width: 640px) {
            .clearing-outer {
                padding: 1rem 0.75rem;
            }

            .clearing-body {
                padding: 16px 18px;
            }

            .clearing-card-head {
                padding: 16px 18px;
            }
        }

        .clearing-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.04);
            animation: slideUp 0.45s ease both;
        }

        .clearing-card-head {
            background: linear-gradient(135deg, #0f2744 0%, #1e3a5f 60%, #1a4a7a 100%);
            padding: 18px 22px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .clearing-card-head .id-pill {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.75);
            letter-spacing: 0.04em;
        }

        .clearing-card-head .desc {
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.45;
            margin-top: 4px;
            max-width: 100%;
        }

        .clearing-card-head .amount {
            font-size: 1.1rem;
            font-weight: 800;
            color: #f0b429;
            white-space: nowrap;
        }

        .clearing-body {
            padding: 20px 22px;
        }

        .clearing-kv {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 18px;
            font-size: 0.88rem;
        }

        @media (max-width: 640px) {
            .clearing-kv {
                grid-template-columns: 1fr;
            }
        }

        .clearing-kv .k {
            font-size: 0.68rem;
            color: #94a3b8;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 3px;
        }

        .clearing-kv .v {
            color: #0f172a;
            font-weight: 600;
        }

        .clearing-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .clearing-badge-pending {
            background: #fffbeb;
            color: #b45309;
        }

        .clearing-badge-paid {
            background: #eff6ff;
            color: #1e3a5f;
        }

        .attach-zone {
            margin-top: 16px;
            padding: 14px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
        }

        .attach-zone-title {
            font-size: 0.72rem;
            font-weight: 700;
            color: #1e3a5f;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
        }

        .attach-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #0f2744;
            background: #fff;
            border: 1px solid rgba(30, 58, 95, 0.15);
            padding: 6px 12px;
            border-radius: 999px;
            text-decoration: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            margin: 0 6px 6px 0;
        }

        .attach-pill:hover {
            border-color: #f0b429;
            box-shadow: 0 2px 8px rgba(240, 180, 41, 0.25);
        }

        .clearing-footer {
            padding: 16px 22px 20px;
            border-top: 1px solid #f1f5f9;
            background: #fafbfc;
        }

        .clearing-input {
            width: 100%;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 10px 12px;
            font-size: 0.82rem;
            font-family: 'Noto Sans Lao', sans-serif;
            color: #334155;
            background: #fff;
        }

        .clearing-input:focus {
            outline: none;
            border-color: #1e3a5f;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.12);
        }

        .btn-confirm {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.86rem;
            font-family: 'Noto Sans Lao', sans-serif;
            color: #fff;
            background: linear-gradient(135deg, #16a34a, #15803d);
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.28);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-confirm:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(22, 163, 74, 0.35);
        }

        .btn-submit-clearing {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.86rem;
            font-family: 'Noto Sans Lao', sans-serif;
            color: #0f2744;
            background: linear-gradient(135deg, #f0d078 0%, #f0b429 50%, #d9a008 100%);
            border: 1px solid rgba(15, 39, 68, 0.1);
            box-shadow: 0 2px 12px rgba(240, 180, 41, 0.35);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-submit-clearing:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(240, 180, 41, 0.45);
        }

        .empty-state {
            padding: 56px 24px;
            text-align: center;
            color: #94a3b8;
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            opacity: 0.45;
            color: #1e3a5f;
        }
    </style>

    <div class="clearing-outer clearing-page w-full min-w-0 max-w-full">
        <div class="max-w-3xl mx-auto w-full min-w-0 px-3 sm:px-4 space-y-5">

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

            @forelse ($requests as $req)
                <div class="clearing-card">
                    <div class="clearing-card-head">
                        <div class="min-w-0 flex-1">
                            <div class="id-pill">#{{ $req->id }}</div>
                            <p class="desc">{{ $req->description }}</p>
                        </div>
                        <div class="amount">{{ number_format($req->requested_amount, 2) }} ກີບ</div>
                    </div>

                    <div class="clearing-body">
                        <div class="clearing-kv">
                            <div>
                                <div class="k">ຜູ້ຂໍ</div>
                                <div class="v">{{ $req->requester?->full_name ?? $req->requester?->username }}</div>
                            </div>
                            <div>
                                <div class="k">ພາກສ່ວນ</div>
                                <div class="v">{{ $req->department?->displayName() }}</div>
                            </div>
                            <div>
                                <div class="k">ວັນທີຂໍ</div>
                                <div class="v">{{ $req->request_date?->format('d/m/Y') }}</div>
                            </div>
                            <div>
                                <div class="k">ສະຖານະ</div>
                                <div class="v">
                                    <span
                                        class="clearing-badge {{ $req->status === 'pending_clearing' ? 'clearing-badge-pending' : 'clearing-badge-paid' }}">
                                        {{ $req->status === 'pending_clearing' ? 'ລໍຖ້າຢືນຢັນ' : 'ຈ່າຍແລ້ວ' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if ($req->clearingAttachments->count() > 0)
                            <div class="attach-zone">
                                <div class="attach-zone-title">
                                    ໄຟລ໌ທີ່ແນບ ({{ $req->clearingAttachments->count() }})
                                </div>
                                <div class="flex flex-wrap">
                                    @foreach ($req->clearingAttachments as $att)
                                        <a href="{{ route('clearing.attachment.download', $att) }}" class="attach-pill">
                                            <svg class="w-3.5 h-3.5 shrink-0 text-[#1e3a5f]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>{{ $att->original_name }}</span>
                                            <span class="text-slate-400 font-medium">({{ $att->file_size_for_humans }})</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="clearing-footer">
                        @if (Auth::user()->isAccountant())
                            <form method="POST" action="{{ route('clearing.confirm', $req) }}" class="inline">
                                @csrf
                                <button type="submit" class="btn-confirm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    ຢືນຢັນການສະສາງ
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('clearing.submit', $req) }}" enctype="multipart/form-data"
                                class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wide">
                                        ແນບໃບເສດ / ຫຼັກຖານ (PDF, ຮູບ, Word, Excel — ສູງສຸດ 5 ໄຟລ໌, ໄຟລ໌ລະ 5MB)
                                    </label>
                                    <input type="file" name="attachments[]" multiple
                                        accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx,.xls,.xlsx"
                                        class="clearing-input file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#1e3a5f] file:text-white hover:file:bg-[#0f2744] file:cursor-pointer">
                                    @error('attachments.*')
                                        <p class="text-red-600 text-xs mt-2 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="btn-submit-clearing">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    ສົ່ງໃບສະສາງ
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-sm font-medium text-gray-500">ບໍ່ມີລາຍການທີ່ຕ້ອງສະສາງ</p>
                </div>
            @endforelse

            @if ($requests instanceof \Illuminate\Pagination\LengthAwarePaginator && $requests->hasPages())
                <div class="pt-1 pb-4">{{ $requests->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>

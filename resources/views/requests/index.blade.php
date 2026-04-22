<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center min-w-0">
            <div class="min-w-0">
                <p class="text-xs font-medium text-indigo-400 uppercase tracking-widest mb-0.5">ລະບົບການເງິນ</p>
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 break-words">ຄຳຂໍເບີກເງິນຂອງຂ້ອຍ</h2>
            </div>
            <a href="{{ route('requests.create') }}"
                class="fns-btn fns-btn-primary shrink-0 w-full sm:w-auto justify-center min-h-[44px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                ສ້າງຄຳຂໍໃໝ່
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-6xl mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6 space-y-5 sm:space-y-6">

            {{-- Success alert --}}
            @if (session('success'))
                <div class="fns-alert fns-alert-success fns-animate">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Stats row --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                @php
                    $total = $requests->total() ?? count($requests);
                    $approved = $requests->getCollection()->where('status', 'approved')->count() + $requests->getCollection()->where('status', 'paid')->count() + $requests->getCollection()->where('status', 'cleared')->count();
                    $pending = $requests->getCollection()->filter(fn($r) => str_contains($r->status, 'pending') || $r->status === 'draft')->count();
                    $rejected = $requests->getCollection()->where('status', 'rejected')->count();
                @endphp
                <div class="fns-stat fns-stat--blue fns-animate">
                    <div class="fns-stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25" /><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 10.5h7.5M8.25 13.5h4.5" /></svg>
                    </div>
                    <p class="fns-stat-value">{{ $total }}</p>
                    <p class="fns-stat-label">ຄຳຂໍທັງໝົດ</p>
                </div>
                <div class="fns-stat fns-stat--amber fns-animate fns-animate-delay-1">
                    <div class="fns-stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3" /><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p class="fns-stat-value">{{ $pending }}</p>
                    <p class="fns-stat-label">ກຳລັງດຳເນີນ</p>
                </div>
                <div class="fns-stat fns-stat--green fns-animate fns-animate-delay-2">
                    <div class="fns-stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2.25 2.25L15 9.75" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" /></svg>
                    </div>
                    <p class="fns-stat-value">{{ $approved }}</p>
                    <p class="fns-stat-label">ອະນຸມັດແລ້ວ</p>
                </div>
                <div class="fns-stat fns-stat--red fns-animate fns-animate-delay-3">
                    <div class="fns-stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" /></svg>
                    </div>
                    <p class="fns-stat-value">{{ $rejected }}</p>
                    <p class="fns-stat-label">ຖືກປະຕິເສດ</p>
                </div>
            </div>

            {{-- Table --}}
            <div class="fns-card fns-animate">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12M8.25 17.25h12M3.75 6.75h.007v.008H3.75V6.75zm0 5.25h.007v.008H3.75V12zm0 5.25h.007v.008H3.75v-.008z" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ລາຍການຄຳຂໍ</h3>
                            <p class="fns-card-subtitle">ຄຳຂໍເບີກເງິນທັງໝົດຂອງທ່ານ</p>
                        </div>
                    </div>
                    <span class="fns-badge-count">{{ $requests->total() ?? count($requests) }} ລາຍການ</span>
                </div>

                <div class="overflow-x-auto touch-pan-x">
                    <table class="fns-table min-w-[40rem]">
                        <thead>
                            <tr>
                                <th style="width:60px;">#</th>
                                <th>ພາກສ່ວນ</th>
                                <th>ລາຍລະອຽດ</th>
                                <th class="th-right">ຈຳນວນ (ກີບ)</th>
                                <th class="th-center">ສະຖານະ</th>
                                <th class="th-center">ວັນທີ</th>
                                <th class="th-center" style="width:80px;">ເບິ່ງ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $req)
                                <tr>
                                    <td><span class="fns-cell-id">#{{ $req->id }}</span></td>
                                    <td><span class="fns-cell-dept">{{ $req->department?->displayName() }}</span></td>
                                    <td><span class="fns-cell-desc" title="{{ $req->description }}">{{ $req->description }}</span></td>
                                    <td class="text-right"><span class="fns-cell-amount">{{ number_format($req->requested_amount, 2) }}</span></td>
                                    <td class="text-center">
                                        @php
                                            $badgeMap = [
                                                'draft' => ['class' => 'fns-badge-draft', 'label' => 'ຮ່າງ'],
                                                'pending_accountant_review' => ['class' => 'fns-badge-pending', 'label' => 'ລໍຖ້ານັກບັນຊີ'],
                                                'pending_finance_head_review' => ['class' => 'fns-badge-review', 'label' => 'ລໍຖ້າຫົວໜ້າການເງິນ'],
                                                'pending_deputy_head_approval' => ['class' => 'fns-badge-deputy', 'label' => 'ລໍຖ້າຮອງຄະນະ'],
                                                'pending_faculty_head_approval' => ['class' => 'fns-badge-faculty', 'label' => 'ລໍຖ້າຄະນະບໍດີ'],
                                                'approved' => ['class' => 'fns-badge-approved', 'label' => 'ອະນຸມັດ'],
                                                'paid' => ['class' => 'fns-badge-paid', 'label' => 'ຈ່າຍແລ້ວ'],
                                                'pending_clearing' => ['class' => 'fns-badge-clearing', 'label' => 'ລໍຖ້າເຄຼຍ'],
                                                'cleared' => ['class' => 'fns-badge-cleared', 'label' => 'ເຄຼຍແລ້ວ'],
                                                'rejected' => ['class' => 'fns-badge-rejected', 'label' => 'ປະຕິເສດ'],
                                            ];
                                            $badge = $badgeMap[$req->status] ?? ['class' => 'fns-badge-draft', 'label' => $req->status];
                                        @endphp
                                        <span class="fns-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                                    </td>
                                    <td class="text-center"><span class="fns-cell-date">{{ $req->request_date?->format('d/m/Y') }}</span></td>
                                    <td class="text-center">
                                        <a href="{{ route('requests.show', $req) }}" class="fns-btn fns-btn-ghost" style="padding:6px 12px;">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            ເບິ່ງ
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="fns-empty">
                                            <div class="fns-empty-icon">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 12.75v5.25A2.25 2.25 0 0119.5 20.25H4.5A2.25 2.25 0 012.25 18v-5.25m19.5 0L13.81 14.9a2.25 2.25 0 01-3.62 0L2.25 12.75" /></svg>
                                            </div>
                                            <p class="fns-empty-text mb-4">ຍັງບໍ່ມີຄຳຂໍເທື່ອ</p>
                                            <a href="{{ route('requests.create') }}" class="fns-btn fns-btn-primary">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                                                ສ້າງຄຳຂໍໃໝ່
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($requests->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $requests->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>

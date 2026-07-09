<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-medium text-rose-400 uppercase tracking-widest">ການອະນຸມັດ</p>
            <h2 class="text-lg sm:text-xl font-bold text-gray-800">ລາຍການທີ່ຕ້ອງອະນຸມັດ</h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-6xl mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6 space-y-5 sm:space-y-6">

            @if (session('success'))
                <div class="fns-alert fns-alert-success fns-animate">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="fns-alert fns-alert-error fns-animate">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="fns-card fns-animate">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon" style="background: #fef2f2; color: #dc2626;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ລາຍການລໍຖ້າອະນຸມັດ</h3>
                            <p class="fns-card-subtitle">ກວດສອບ ແລະ ອະນຸມັດຄຳຂໍຕາມລຳດັບ</p>
                        </div>
                    </div>
                    <span class="fns-badge-count" style="background: #fef2f2; color: #dc2626;">
                        {{ $requests instanceof \Illuminate\Pagination\LengthAwarePaginator ? $requests->total() : count($requests) }} ລາຍການ
                    </span>
                </div>

                <div class="overflow-x-auto touch-pan-x">
                    <table class="fns-table min-w-[44rem]">
                        <thead>
                            <tr>
                                <th style="width:64px;">#</th>
                                <th>ຜູ້ຂໍ</th>
                                <th>ພາກສ່ວນ</th>
                                <th>ລາຍລະອຽດ</th>
                                <th class="th-right">ຈຳນວນ (ກີບ)</th>
                                <th class="th-center">ວັນທີ</th>
                                <th class="th-center" style="width:100px;">ດຳເນີນການ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $req)
                                <tr>
                                    <td><span class="fns-cell-id">#{{ $req->id }}</span></td>
                                    <td><span class="fns-cell-name">{{ $req->requester?->full_name ?? $req->requester?->username }}</span></td>
                                    <td><span class="fns-cell-dept">{{ $req->department?->displayName() }}</span></td>
                                    <td><span class="fns-cell-desc" title="{{ $req->description }}">{{ $req->description }}</span></td>
                                    <td class="text-right"><span class="fns-cell-amount">{{ number_format($req->requested_amount, 2) }}</span></td>
                                    <td class="text-center"><span class="fns-cell-date">{{ $req->request_date?->format('d/m/Y') }}</span></td>
                                    <td class="text-center">
                                        <a href="{{ route('approvals.show', $req->id) }}" class="fns-btn fns-btn-primary" style="padding:7px 14px; font-size:0.72rem;">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            ກວດສອບ
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="fns-empty">
                                            <div class="fns-empty-icon">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <p class="fns-empty-text">ບໍ່ມີລາຍການທີ່ຕ້ອງດຳເນີນການ</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($requests instanceof \Illuminate\Pagination\LengthAwarePaginator && $requests->hasPages())
                    <div class="px-4 py-3 border-t border-gray-100">{{ $requests->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

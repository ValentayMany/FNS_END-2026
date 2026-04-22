<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10.5h18M4.5 10.5V19.5A1.5 1.5 0 006 21h12a1.5 1.5 0 001.5-1.5v-9M6.75 7.5h10.5a1.5 1.5 0 011.5 1.5v1.5H5.25V9a1.5 1.5 0 011.5-1.5z" /></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-indigo-400 uppercase tracking-widest">ຄັງເງິນ</p>
                <h2 class="text-lg font-bold text-gray-800">ສະຖານະເງິນໃນຄັງ</h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-6xl mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6 space-y-5">

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                <div class="fns-stat fns-stat--green fns-animate">
                    <div class="fns-stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22" /></svg>
                    </div>
                    <p class="fns-stat-value" style="color:#059669;">{{ number_format($totalIncome, 2) }}</p>
                    <p class="fns-stat-label">ລາຍຮັບທັງໝົດ (ກີບ)</p>
                </div>
                <div class="fns-stat fns-stat--red fns-animate fns-animate-delay-1">
                    <div class="fns-stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286a11.95 11.95 0 015.834 5.518l2.74 1.22" /></svg>
                    </div>
                    <p class="fns-stat-value" style="color:#dc2626;">{{ number_format($totalExpense, 2) }}</p>
                    <p class="fns-stat-label">ລາຍຈ່າຍທັງໝົດ (ກີບ)</p>
                </div>
                <div class="fns-stat fns-stat--blue fns-animate fns-animate-delay-2">
                    <div class="fns-stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p class="fns-stat-value" style="color:#4f46e5;">{{ number_format($totalIncome - $totalExpense, 2) }}</p>
                    <p class="fns-stat-label">ຍອດຄົງເຫຼືອ (ກີບ)</p>
                </div>
            </div>

            {{-- Table --}}
            <div class="fns-card fns-animate">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 6.75h12M8.25 12h12M8.25 17.25h12M3.75 6.75h.007v.008H3.75V6.75zm0 5.25h.007v.008H3.75V12zm0 5.25h.007v.008H3.75v-.008z" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ການເຄື່ອນໄຫວເງິນລ່າສຸດ</h3>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto touch-pan-x">
                    <table class="fns-table" style="min-width:36rem;">
                        <thead>
                            <tr>
                                <th>ວັນທີ</th>
                                <th>ລາຍລະອຽດ</th>
                                <th class="th-right">ຈຳນວນ (ກີບ)</th>
                                <th>ພາກສ່ວນ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $txn)
                            <tr>
                                <td class="fns-cell-date">{{ $txn->transaction_date?->format('d/m/Y') }}</td>
                                <td class="text-gray-700 text-sm">{{ $txn->description }}</td>
                                <td class="text-right"><span class="fns-cell-amount">{{ number_format($txn->amount, 2) }}</span></td>
                                <td class="text-gray-500 text-sm">{{ $txn->department?->displayName() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
                                    <div class="fns-empty"><p class="fns-empty-text">ຍັງບໍ່ມີລາຍການ</p></div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

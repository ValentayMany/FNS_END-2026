<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-medium text-indigo-400 uppercase tracking-widest">ຄັງເງິນຊາດ</p>
            <h2 class="text-lg sm:text-xl font-bold text-gray-800">ບັນທຶກການສະສາງກັບຄັງເງິນຊາດ</h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-4xl mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6 space-y-5">

            @if(session('success'))
                <div class="fns-alert fns-alert-success fns-animate">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form --}}
            <div class="fns-card fns-animate">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon" style="background:#f5f3ff; color:#7c3aed;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ບັນທຶກການສະສາງໃໝ່</h3>
                        </div>
                    </div>
                </div>
                <div class="fns-card-body">
                    <form method="POST" action="{{ route('treasury.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="reconciliation_date" class="fns-label">ວັນທີ *</label>
                            <input id="reconciliation_date" name="reconciliation_date" type="date"
                                class="fns-input" value="{{ old('reconciliation_date', today()->toDateString()) }}" required />
                        </div>

                        <div>
                            <label for="transaction_id" class="fns-label">ລາຍການ Transaction *</label>
                            <select id="transaction_id" name="transaction_id" required class="fns-select">
                                <option value="">-- ເລືອກລາຍການ --</option>
                                @foreach($transactions as $txn)
                                <option value="{{ $txn->id }}" {{ old('transaction_id') == $txn->id ? 'selected' : '' }}>
                                    #{{ $txn->id }} | {{ $txn->transaction_date?->format('d/m/Y') }} | {{ $txn->description }} | {{ number_format($txn->amount, 2) }} ກີບ
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="fns-btn fns-btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            ບັນທຶກ
                        </button>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="fns-card fns-animate fns-animate-delay-1">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 6.75h12M8.25 12h12M8.25 17.25h12M3.75 6.75h.007v.008H3.75V6.75zm0 5.25h.007v.008H3.75V12zm0 5.25h.007v.008H3.75v-.008z" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ລາຍການສະສາງລ່າສຸດ</h3>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto touch-pan-x">
                    <table class="fns-table" style="min-width:32rem;">
                        <thead>
                            <tr>
                                <th>ວັນທີ</th>
                                <th>ລາຍການ</th>
                                <th class="th-right">ຈຳນວນ (ກີບ)</th>
                                <th>ຜູ້ບັນທຶກ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td class="fns-cell-date">{{ $item->reconciliation_date?->format('d/m/Y') }}</td>
                                <td class="text-gray-700 text-sm">{{ $item->transaction?->description }}</td>
                                <td class="text-right"><span class="fns-cell-amount">{{ number_format($item->transaction?->amount, 2) }}</span></td>
                                <td class="text-gray-500 text-sm">{{ $item->user?->full_name }}</td>
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

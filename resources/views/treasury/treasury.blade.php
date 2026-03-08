<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">🏛️ ບັນທຶກການສະສາງກັບຄັງເງິນຊາດ</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 space-y-5">

            @if(session('success'))
            <div class="p-3 bg-green-100 text-green-700 rounded-lg text-sm">✅ {{ session('success') }}</div>
            @endif

            {{-- Form --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-800 mb-4">➕ ບັນທຶກການສະສາງໃໝ່</h3>
                <form method="POST" action="{{ route('treasury.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="reconciliation_date" value="ວັນທີ *" />
                        <x-text-input id="reconciliation_date" name="reconciliation_date" type="date"
                            class="block mt-1 w-full"
                            :value="old('reconciliation_date', today()->toDateString())" required />
                    </div>

                    <div>
                        <x-input-label for="transaction_id" value="ລາຍການ Transaction *" />
                        <select id="transaction_id" name="transaction_id" required
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- ເລືອກລາຍການ --</option>
                            @foreach($transactions as $txn)
                            <option value="{{ $txn->id }}" {{ old('transaction_id') == $txn->id ? 'selected' : '' }}>
                                #{{ $txn->id }} | {{ $txn->transaction_date?->format('d/m/Y') }} | {{ $txn->description }} | {{ number_format($txn->amount, 2) }} ກີບ
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <x-primary-button>💾 ບັນທຶກ</x-primary-button>
                </form>
            </div>

            {{-- รายการล่าสุด --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-5 py-4 border-b">
                    <h3 class="font-semibold text-gray-800">📋 ລາຍການສະສາງລ່າສຸດ</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">ວັນທີ</th>
                            <th class="px-4 py-3 text-left">ລາຍການ</th>
                            <th class="px-4 py-3 text-right">ຈຳນວນ (ກີບ)</th>
                            <th class="px-4 py-3 text-left">ຜູ້ບັນທຶກ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400 text-xs">
                                {{ $item->reconciliation_date?->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">{{ $item->transaction?->description }}</td>
                            <td class="px-4 py-3 text-right font-semibold">
                                {{ number_format($item->transaction?->amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $item->user?->full_name }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                                ຍັງບໍ່ມີລາຍການ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>

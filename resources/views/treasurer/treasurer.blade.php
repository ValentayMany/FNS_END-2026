<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 break-words">🏦 ສະຖານະເງິນໃນຄັງ</h2>
    </x-slot>

    <div class="py-4 sm:py-6 w-full min-w-0">
        <div class="max-w-6xl mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6 space-y-5">

            {{-- สรุปยอด --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-gray-400 text-sm mb-1">ລາຍຮັບທັງໝົດ</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($totalIncome, 2) }}</p>
                    <p class="text-xs text-gray-400">ກີບ</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-gray-400 text-sm mb-1">ລາຍຈ່າຍທັງໝົດ</p>
                    <p class="text-2xl font-bold text-red-600">{{ number_format($totalExpense, 2) }}</p>
                    <p class="text-xs text-gray-400">ກີບ</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-gray-400 text-sm mb-1">ຍອດຄົງເຫຼືອ</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ number_format($totalIncome - $totalExpense, 2) }}</p>
                    <p class="text-xs text-gray-400">ກີບ</p>
                </div>
            </div>

            {{-- รายการ Transaction ล่าสุด --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-4 sm:px-5 py-4 border-b">
                    <h3 class="font-semibold text-gray-800">📋 ການເຄື່ອນໄຫວເງິນລ່າສຸດ</h3>
                </div>
                <div class="overflow-x-auto touch-pan-x">
                <table class="w-full text-sm min-w-[36rem]">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">ວັນທີ</th>
                            <th class="px-4 py-3 text-left">ລາຍລະອຽດ</th>
                            <th class="px-4 py-3 text-right">ຈຳນວນ (ກີບ)</th>
                            <th class="px-4 py-3 text-left">ພາກສ່ວນ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($transactions as $txn)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400 text-xs">
                                {{ $txn->transaction_date?->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">{{ $txn->description }}</td>
                            <td class="px-4 py-3 text-right font-semibold">
                                {{ number_format($txn->amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $txn->department?->displayName() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400">ຍັງບໍ່ມີລາຍການ</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

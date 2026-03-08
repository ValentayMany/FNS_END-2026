<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">📊 ລາຍງຳນລາຍຮັບ-ລາຍຈ່າຍ</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 space-y-5">

            {{-- Filter --}}
            <div class="bg-white rounded-xl shadow p-5">
                <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap gap-4 items-end">

                    <div>
                        <label class="block text-xs text-gray-500 mb-1">ປະເພດລາຍງານ</label>
                        <select name="type" onchange="this.form.submit()"
                            class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="daily"   {{ $type === 'daily'   ? 'selected' : '' }}>ປະຈຳວັນ</option>
                            <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>ປະຈຳເດືອນ</option>
                        </select>
                    </div>

                    @if($type === 'daily')
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">ວັນທີ</label>
                        <input type="date" name="date" value="{{ $date }}"
                            class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    @else
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">ເດືອນ</label>
                        <input type="month" name="month" value="{{ $month }}"
                            class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    @endif

                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm">
                        🔍 ຄົ້ນຫາ
                    </button>
                </form>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-gray-400 text-sm mb-1">ລາຍຮັບລວມ</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($totalIncome, 2) }}</p>
                    <p class="text-xs text-gray-400">ກີບ</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-gray-400 text-sm mb-1">ລາຍຈ່າຍລວມ</p>
                    <p class="text-2xl font-bold text-red-600">{{ number_format($totalExpense, 2) }}</p>
                    <p class="text-xs text-gray-400">ກີບ</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-gray-400 text-sm mb-1">ຍອດສຸດທິ</p>
                    <p class="text-2xl font-bold {{ ($totalIncome - $totalExpense) >= 0 ? 'text-indigo-600' : 'text-red-600' }}">
                        {{ number_format($totalIncome - $totalExpense, 2) }}
                    </p>
                    <p class="text-xs text-gray-400">ກີບ</p>
                </div>
            </div>

            {{-- ລາຍຮັບ --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-5 py-4 border-b bg-green-50">
                    <h3 class="font-semibold text-green-700">📥 ລາຍຮັບ</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">ວັນທີ</th>
                            <th class="px-4 py-3 text-left">ລາຍລະອຽດ</th>
                            <th class="px-4 py-3 text-left">ພາກສ່ວນ</th>
                            <th class="px-4 py-3 text-right">ຈຳນວນ (ກີບ)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($transactions as $txn)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400 text-xs">
                                {{ $txn->transaction_date?->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">{{ $txn->description }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $txn->department?->department_name }}
                            </td>
                            <td class="px-4 py-3 text-right font-semibold text-green-600">
                                {{ number_format($txn->amount, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                                ບໍ່ມີລາຍຮັບ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ລາຍຈ່າຍ --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-5 py-4 border-b bg-red-50">
                    <h3 class="font-semibold text-red-700">📤 ລາຍຈ່າຍ (ການເບີກຈ່າຍ)</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">ວັນທີ</th>
                            <th class="px-4 py-3 text-left">ຜູ້ຂໍ</th>
                            <th class="px-4 py-3 text-left">ລາຍລະອຽດ</th>
                            <th class="px-4 py-3 text-left">ພາກສ່ວນ</th>
                            <th class="px-4 py-3 text-right">ຈຳນວນ (ກີບ)</th>
                            <th class="px-4 py-3 text-center">ສະຖານະ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($requests as $req)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400 text-xs">
                                {{ $req->request_date?->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $req->requester?->full_name ?? $req->requester?->username }}
                            </td>
                            <td class="px-4 py-3">{{ $req->description }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $req->department?->department_name }}
                            </td>
                            <td class="px-4 py-3 text-right font-semibold text-red-600">
                                {{ number_format($req->requested_amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-0.5 rounded text-xs
                                    {{ $req->status === 'cleared' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $req->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                                ບໍ່ມີລາຍຈ່າຍ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>

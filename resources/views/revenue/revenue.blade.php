<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">📊 ບັນທຶກລາຍຮັບ</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 space-y-5">

            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-700 rounded-lg text-sm">✅ {{ session('success') }}</div>
            @endif

            {{-- Form บันทึกรายรับ --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-800 mb-4">➕ ບັນທຶກລາຍຮັບໃໝ່</h3>
                <form method="POST" action="{{ route('revenue.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="transaction_date" value="ວັນທີ *" />
                        <x-text-input id="transaction_date" name="transaction_date" type="date"
                            class="block mt-1 w-full" :value="old('transaction_date', today()->toDateString())" required />
                        <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="ລາຍລະອຽດ *" />
                        <textarea id="description" name="description" rows="2" required
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="amount" value="ຈຳນວນເງິນ (ກີບ) *" />
                        <x-text-input id="amount" name="amount" type="number" class="block mt-1 w-full"
                            min="1" step="0.01" :value="old('amount')" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="account_id" value="ໝວດບັນຊີ *" />
                        <select id="account_id" name="account_id" required
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- ເລືອກໝວດບັນຊີ --</option>
                            @foreach ($accounts as $acc)
                                <option value="{{ $acc->id }}"
                                    {{ old('account_id') == $acc->id ? 'selected' : '' }}>
                                    {{ $acc->account_code }} - {{ $acc->account_name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('account_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="department_id" value="ພາກສ່ວນ *" />
                        <select id="department_id" name="department_id" required
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- ເລືອກພາກສ່ວນ --</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->department_name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                    </div>

                    <x-primary-button>ບັນທຶກ</x-primary-button>
                </form>
            </div>

            {{-- รายการล่าสุด --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-5 py-4 border-b">
                    <h3 class="font-semibold text-gray-800">📋 ລາຍການລ່າສຸດ</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">ວັນທີ</th>
                            <th class="px-4 py-3 text-left">ລາຍລະອຽດ</th>
                            <th class="px-4 py-3 text-right">ຈຳນວນ</th>
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
                                <td class="px-4 py-3 text-right font-semibold text-green-600">
                                    {{ number_format($txn->amount, 2) }}
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $txn->department?->department_name }}
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
</x-app-layout>

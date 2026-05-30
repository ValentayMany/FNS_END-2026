<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1.5 min-w-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                    ບັນທຶກລາຍຈ່າຍ (Expense)
                </h2>
            </div>
            <p class="text-sm font-semibold text-gray-500 pl-10">ບ່ອນບັນທຶກການຈ່າຍເງິນທົ່ວໄປ ເຊັ່ນ ຄ່າອຸປະກອນ, ຄ່າບໍລິການ, ດັດສົມຕ່າງໆ</p>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-[1400px] mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6">

            @if (session('success'))
                <div class="fns-alert fns-alert-success fns-animate mb-6 shadow-sm border-l-4 border-l-emerald-500 rounded-lg">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-emerald-500 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="fns-alert fns-alert-error fns-animate mb-6 shadow-sm border-l-4 border-l-red-500 rounded-lg">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-red-500 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <div class="space-y-6">

                {{-- Single Card: Form + Table --}}
                <div class="fns-card border-t-4 border-t-indigo-500 shadow-lg bg-white rounded-2xl overflow-hidden fns-animate">

                    {{-- Form Section --}}
                    <div class="fns-card-header bg-transparent border-b border-gray-100 py-5 px-6">
                        <h3 class="text-base font-extrabold text-gray-800 flex items-center gap-2">
                            <span class="w-1.5 h-5 rounded-full bg-indigo-500 block"></span>
                            ຟອມເພີ່ມລາຍຈ່າຍ
                        </h3>
                    </div>

                    <div class="p-5 sm:p-6 bg-gray-50/30">
                        <form method="POST" action="{{ route('expense.store') }}" class="space-y-4">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {{-- ລະຫັດລາຍຈ່າຍ --}}
                                <div>
                                    <label for="payment_code" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລະຫັດລາຍຈ່າຍ <span class="text-red-500">*</span></label>
                                    <input id="payment_code" name="payment_code" type="text"
                                        class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                        value="{{ old('payment_code', $nextPaymentCode) }}" required readonly />
                                </div>

                                {{-- ວັນທີຈ່າຍ --}}
                                <div>
                                    <label for="transaction_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ວັນທີຈ່າຍ <span class="text-red-500">*</span></label>
                                    <input id="transaction_date" name="transaction_date" type="date"
                                        class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                        value="{{ old('transaction_date', date('Y-m-d')) }}" required />
                                </div>

                                {{-- ປີງົບປະມານ --}}
                                <div>
                                    <label for="budget_year" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ປີງົບປະມານ</label>
                                    <input id="budget_year" name="budget_year" type="text"
                                        class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                        value="{{ old('budget_year', date('Y')) }}" />
                                </div>

                                {{-- ຊື່ລາຍການຈ່າຍ --}}
                                <div class="sm:col-span-2">
                                    <label for="item_name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຊື່ລາຍການຈ່າຍ <span class="text-red-500">*</span></label>
                                    <input id="item_name" name="item_name" type="text"
                                        class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                        value="{{ old('item_name') }}" placeholder="ເຊັ່ນ: ຄ່າອຸປະກອນ, ຄ່າບໍລິການ..." required />
                                </div>

                                {{-- ຈໍານວນເງິນ --}}
                                <div>
                                    <label for="amount" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຈໍານວນເງິນ (ກີບ) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-bold sm:text-sm">₭</span>
                                        </div>
                                        <input id="amount" name="amount" type="number" min="1" step="0.01"
                                            class="ui-input bg-white pl-8 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all font-bold text-rose-700 w-full"
                                            value="{{ old('amount') }}" placeholder="0.00" required />
                                    </div>
                                </div>

                                {{-- ເລກບັນຊີ --}}
                                <div class="sm:col-span-2 lg:col-span-3">
                                    <label for="account_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ເລກບັນຊີ <span class="text-red-500">*</span></label>
                                    <select id="account_id" name="account_id" required class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                        <option value="">-- ເລືອກເລກບັນຊີ --</option>
                                        @foreach ($accounts as $acc)
                                            <option value="{{ $acc->id }}" {{ old('account_id') == $acc->id ? 'selected' : '' }}>
                                                {{ $acc->account_code }} - {{ $acc->account_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- ພາກສ່ວນຈ່າຍ --}}
                                <div>
                                    <label for="department_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ພາກສ່ວນຈ່າຍ <span class="text-red-500">*</span></label>
                                    <select id="department_id" name="department_id" required class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                        <option value="">-- ເລືອກພາກສ່ວນຈ່າຍ --</option>
                                        @foreach ($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->displayName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- ຊ່ອງລາຍຈ່າຍ --}}
                                <div>
                                    <label for="category" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຊ່ອງລາຍຈ່າຍ <span class="text-red-500">*</span></label>
                                    <select id="category" name="category" required class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                        <option value="ງົບປະມານສົ່ງເສີມວິຊາການ" {{ old('category') == 'ງົບປະມານສົ່ງເສີມວິຊາການ' ? 'selected' : '' }}>ງົບປະມານສົ່ງເສີມວິຊາການ</option>
                                        <option value="ຮັບໃຊ້ການທົດລອງ" {{ old('category') == 'ຮັບໃຊ້ການທົດລອງ' ? 'selected' : '' }}>ຮັບໃຊ້ການທົດລອງ</option>
                                        <option value="ການເຄື່ອນໄຫວນອກຫຼັກສູດ" {{ old('category') == 'ການເຄື່ອນໄຫວນອກຫຼັກສູດ' ? 'selected' : '' }}>ການເຄື່ອນໄຫວນອກຫຼັກສູດ</option>
                                    </select>
                                </div>

                                {{-- ປະເພດລາຍຈ່າຍ --}}
                                <div>
                                    <label for="expense_type" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ປະເພດລາຍຈ່າຍ</label>
                                    <select id="expense_type" name="expense_type" class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                        <option value="ງົບປະມານວິຊາການ" {{ old('expense_type') == 'ງົບປະມານວິຊາການ' ? 'selected' : '' }}>ງົບປະມານວິຊາການ</option>
                                        <option value="ງົບປະມານບໍລິຫານ" {{ old('expense_type') == 'ງົບປະມານບໍລິຫານ' ? 'selected' : '' }}>ງົບປະມານບໍລິຫານ</option>
                                    </select>
                                </div>

                                {{-- ຊ່ອງ ປຕ/ປທ --}}
                                <div>
                                    <label for="channel_type" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຊ່ອງ ປຕ/ປທ</label>
                                    <select id="channel_type" name="channel_type" class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                        <option value="ເງິນບໍລິຫານທົ່ວໄປ" {{ old('channel_type') == 'ເງິນບໍລິຫານທົ່ວໄປ' ? 'selected' : '' }}>ເງິນບໍລິຫານທົ່ວໄປ</option>
                                        <option value="ເງິນຕ່າງປະເທດ" {{ old('channel_type') == 'ເງິນຕ່າງປະເທດ' ? 'selected' : '' }}>ເງິນຕ່າງປະເທດ</option>
                                    </select>
                                </div>

                                {{-- ລາຍລະອຽດ --}}
                                <div class="sm:col-span-2 lg:col-span-3">
                                    <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລາຍລະອຽດ <span class="text-gray-400 font-normal lowercase">(ບໍ່ຈຳເປັນ)</span></label>
                                    <textarea id="description" name="description" rows="2"
                                        class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full resize-none placeholder-gray-300"
                                        placeholder="ອະທິບາຍເພິ່ມເຕີມ...">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-2 gap-3">
                                <button type="submit" class="ui-btn bg-indigo-500 text-white hover:bg-indigo-600 shadow-lg shadow-indigo-500/30 text-sm py-2.5 px-6 outline-none focus:ring-2 focus:ring-indigo-500 ring-offset-1 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                    ✓ ບັນທຶກ (Save)
                                </button>
                                <a href="{{ url()->previous() }}" class="ui-btn bg-gray-100 text-gray-600 hover:bg-gray-200 text-sm py-2.5 px-6 flex items-center gap-2">
                                    ← ຍົກເລີກ (Cancel)
                                </a>
                            </div>
                        </form>
                    </div>

                </div>

                {{-- Table Section: separate card below --}}
                <div class="fns-card shadow-sm border border-gray-100 bg-white fns-animate">
                    <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100">
                        <div>
                            <h3 class="text-base font-extrabold text-gray-800 flex items-center gap-2">
                                <span class="w-1.5 h-5 rounded-full bg-indigo-400 block"></span>
                                ປະຫວັດລາຍຈ່າຍລ່າສຸດ
                            </h3>
                            <p class="text-xs text-gray-400 mt-0.5">ສະແດງລາຍການລ່າສຸດທີ່ຖືກບັນທຶກ</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                            ທັງໝົດ {{ $transactions instanceof \Illuminate\Pagination\LengthAwarePaginator ? $transactions->total() : count($transactions) }} ລາຍການ
                        </span>
                    </div>

                    <div class="overflow-x-auto touch-pan-x">
                        <table class="fns-table w-full text-left border-collapse" style="min-width:44rem;">
                            <thead>
                                <tr class="bg-gray-50/80 border-y border-gray-100">
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider">ວັນທີ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider">ລະຫັດການຈ່າຍ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider">ໝວດ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider">ຊື່ລາຍການ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider">ພາກສ່ວນ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-right">ຈຳນວນ (ກີບ)</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-center">ຈັດການ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse ($transactions as $txn)
                                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-500 font-medium group-hover:text-indigo-700 transition-colors">
                                            {{ $txn->transaction_date?->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-[0.7rem] font-bold bg-gray-100 text-gray-600 border border-gray-200 font-mono tracking-wider">
                                                {{ $txn->payment_code ?? '—' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-[0.7rem] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 whitespace-nowrap">
                                                {{ $txn->category ?? '—' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 max-w-[220px]">
                                            <div class="text-sm font-semibold text-gray-800 truncate" title="{{ $txn->item_name ?? $txn->description }}">{{ $txn->item_name ?? $txn->description }}</div>
                                            @if($txn->item_name && $txn->description)
                                                <div class="text-xs text-gray-400 truncate mt-0.5" title="{{ $txn->description }}">{{ $txn->description }}</div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-500 truncate max-w-[120px]" title="{{ $txn->department?->displayName() }}">
                                            {{ $txn->department?->displayName() }}
                                        </td>
                                        <td class="py-3 px-4 text-right whitespace-nowrap">
                                            <span class="font-extrabold text-[#e11d48] text-[0.95rem] tracking-tight">
                                                {{ number_format($txn->amount, 2) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <a href="{{ route('expense.edit', $txn) }}"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 hover:bg-indigo-100 hover:border-indigo-300 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                    ແກ້ໄຂ
                                                </a>
                                                <button type="button"
                                                    onclick="openDeleteModal('{{ $txn->id }}', '{{ addslashes($txn->item_name ?? $txn->description) }}')"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-100 hover:border-rose-300 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    ລຶບ
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12">
                                            <div class="flex flex-col items-center justify-center text-center">
                                                <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 mb-4 border border-gray-100">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" /></svg>
                                                </div>
                                                <p class="text-gray-500 font-bold">ຍັງບໍ່ມີປະຫວັດການຈ່າຍເງິນ</p>
                                                <p class="text-xs text-gray-400 mt-1">ລາຍການທີ່ບັນທຶກຈະສະແດງໃນຕາຕະລາງນີ້</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator && $transactions->hasPages())
                        <div class="px-5 py-4 border-t border-gray-50 bg-gray-50/50">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" aria-modal="true" role="dialog">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 fns-animate">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-rose-100 mx-auto mb-4">
                <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </div>
            <h3 class="text-lg font-extrabold text-gray-900 text-center mb-1">ຢືນຢັນການລຶບ</h3>
            <p class="text-sm text-gray-500 text-center mb-1">ທ່ານຕ້ອງການລຶບລາຍການຈ່າຍ:</p>
            <p id="deleteItemName" class="text-sm font-bold text-rose-600 text-center mb-5 truncate"></p>
            <p class="text-xs text-gray-400 text-center mb-5">ການລຶບນີ້ບໍ່ສາມາດກູ້ຄືນໄດ້</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-4 rounded-xl transition-all duration-150 text-sm">
                        ຍົກເລີກ
                    </button>
                    <button type="submit"
                        class="flex-1 bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-lg hover:-translate-y-0.5 transition-all duration-150 text-sm">
                        ລຶບເລີຍ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(id, name) {
            document.getElementById('deleteForm').action = '/expense/' + id;
            document.getElementById('deleteItemName').textContent = name;
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });

        // Auto-sync budget year and payment code with transaction date
        const dateInput = document.getElementById('transaction_date');
        const budgetYearInput = document.getElementById('budget_year');
        const paymentCodeInput = document.getElementById('payment_code');
        
        if (dateInput) {
            dateInput.addEventListener('change', function() {
                if (this.value) {
                    const year = this.value.split('-')[0];
                    if (budgetYearInput) {
                        budgetYearInput.value = year;
                    }
                    
                    // Fetch next payment code for this year
                    fetch(`/expense/next-code?year=${year}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.payment_code && paymentCodeInput) {
                                paymentCodeInput.value = data.payment_code;
                            }
                        })
                        .catch(err => console.error('Error fetching next payment code:', err));
                }
            });
        }
    </script>
</x-app-layout>

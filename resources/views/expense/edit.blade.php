<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1.5 min-w-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                    ຟອມແກ້ໄຂລາຍຈ່າຍວິຊາການແລະງົບປະມານ
                </h2>
            </div>
            <p class="text-sm font-semibold text-gray-500 pl-10">ແກ້ໄຂຂໍ້ມູນລາຍຈ່າຍ #{{ $transaction->id }}</p>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-2xl mx-auto w-full px-3 sm:px-4 lg:px-6">

            @if ($errors->any())
                <div class="fns-alert fns-alert-error mb-6 shadow-sm border-l-4 border-l-red-500 rounded-lg bg-red-50 p-4">
                    <div class="flex items-center gap-2 mb-2 text-red-600 font-bold">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                        <span>ກະລຸນາກວດສອບຂໍ້ມູນ:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm font-medium text-red-600">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="fns-card border-t-4 border-t-indigo-500 shadow-lg hover:shadow-xl transition-shadow relative overflow-hidden bg-white rounded-2xl">

                <!-- Decorative gradient corner -->
                <div class="absolute -top-16 -right-16 w-32 h-32 bg-indigo-100 rounded-full blur-2xl opacity-60 pointer-events-none"></div>

                <div class="fns-card-header bg-transparent relative z-10 border-b border-gray-50 py-5 px-6">
                    <h3 class="text-lg font-extrabold text-gray-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 rounded-full bg-indigo-500 block"></span>
                        ຟອມແກ້ໄຂລາຍຈ່າຍ
                    </h3>
                </div>

                                        <div class="fns-card-body bg-gray-50/30 relative z-10 p-5 sm:p-6">
                            <form method="POST" action="{{ route('expense.update', $transaction) }}" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Row 1 -->
                                    <div>
                                        <label for="payment_code" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລະຫັດລາຍຈ່າຍ <span class="text-red-500">*</span></label>
                                        <input id="payment_code" name="payment_code" type="text"
                                            class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                            value="{{ old('payment_code', $transaction->payment_code) }}" required readonly />
                                    </div>
                                    <div>
                                        <label for="transaction_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ວັນທີຈ່າຍ <span class="text-red-500">*</span></label>
                                        <input id="transaction_date" name="transaction_date" type="date"
                                            class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                            value="{{ old('transaction_date', $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d') : '') }}" required />
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="sm:col-span-2">
                                        <label for="item_name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຊື່ລາຍການຈ່າຍ <span class="text-red-500">*</span></label>
                                        <input id="item_name" name="item_name" type="text" list="item_name_suggestions" autocomplete="off"
                                            class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                            value="{{ old('item_name', $transaction->item_name) }}" placeholder="ຊື່ລາຍການຈ່າຍ" required />
                                        <datalist id="item_name_suggestions"></datalist>
                                    </div>

                                    <!-- Row 3 -->
                                    <div>
                                        <label for="budget_year" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ປີງົບປະມານ</label>
                                        <input id="budget_year" name="budget_year" type="text"
                                            class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                            value="{{ old('budget_year', $transaction->transaction_date?->format('Y')) }}" />
                                    </div>
                                    <div>
                                        <label for="amount" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຈຳນວນເງິນຈ່າຍ <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-400 font-bold sm:text-sm">₭</span>
                                            </div>
                                            <input id="amount" name="amount" type="number" min="1" step="0.01"
                                                class="ui-input bg-white pl-8 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all font-bold text-rose-700 w-full"
                                                value="{{ old('amount', $transaction->amount) }}" placeholder="ຈຳນວນເງິນຈ່າຍ" required />
                                        </div>
                                    </div>

                                    <!-- Row 4 -->
                                    <div class="sm:col-span-2">
                                        <label for="account_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ເລກບັນຊີ <span class="text-red-500">*</span></label>
                                        <x-fns.select-wrap>
                                            <select id="account_id" name="account_id" required class="fns-select ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                                <option value="">ເລກບັນຊີ</option>
                                                @foreach ($accounts as $acc)
                                                    <option value="{{ $acc->id }}" {{ old('account_id', $transaction->account_id) == $acc->id ? 'selected' : '' }}>
                                                        {{ $acc->account_code }} - {{ $acc->account_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </x-fns.select-wrap>
                                    </div>

                                    <!-- Row 5 -->
                                    <div>
                                        <label for="department_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ພາກສ່ວນຈ່າຍ <span class="text-red-500">*</span></label>
                                        <x-fns.select-wrap>
                                            <select id="department_id" name="department_id" required class="fns-select ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                                @foreach ($departments as $dept)
                                                    <option value="{{ $dept->id }}" {{ old('department_id', $transaction->department_id) == $dept->id ? 'selected' : '' }}>
                                                        {{ $dept->expenseSectionLabel() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </x-fns.select-wrap>
                                    </div>
                                    <div>
                                        <label for="category" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຊ່ອງລາຍຈ່າຍ <span class="text-red-500">*</span></label>
                                        <x-fns.select-wrap>
                                        <select id="category" name="category" required class="fns-select ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                            <option value="ງົບປະມານສົ່ງເສີມວິຊາການ" {{ old('category', $transaction->category) == 'ງົບປະມານສົ່ງເສີມວິຊາການ' ? 'selected' : '' }}>ງົບປະມານສົ່ງເສີມວິຊາການ</option>
                                            <option value="ສົ່ງເສີມຊີວາການ" {{ old('category', $transaction->category) == 'ສົ່ງເສີມຊີວາການ' ? 'selected' : '' }}>ສົ່ງເສີມຊີວາການ</option>
                                            <option value="ຮັບໃຊ້ການທົດລອງ" {{ old('category', $transaction->category) == 'ຮັບໃຊ້ການທົດລອງ' ? 'selected' : '' }}>ຮັບໃຊ້ການທົດລອງ</option>
                                            <option value="ການເຄື່ອນໄຫວນອກຫຼັກສູດ" {{ old('category', $transaction->category) == 'ການເຄື່ອນໄຫວນອກຫຼັກສູດ' ? 'selected' : '' }}>ການເຄື່ອນໄຫວນອກຫຼັກສູດ</option>
                                        </select>
                                        </x-fns.select-wrap>
                                    </div>

                                    <!-- Row 6 -->
                                    <div>
                                        <label for="expense_type" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ປະເພດລາຍຈ່າຍ</label>
                                        <x-fns.select-wrap>
                                        <select id="expense_type" name="expense_type" class="fns-select ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                            <option value="ງົບປະມານວິຊາການ" {{ old('expense_type', $expenseType) == 'ງົບປະມານວິຊາການ' ? 'selected' : '' }}>ງົບປະມານວິຊາການ</option>
                                            <option value="ງົບປະມານບໍລິຫານ" {{ old('expense_type', $expenseType) == 'ງົບປະມານບໍລິຫານ' ? 'selected' : '' }}>ງົບປະມານບໍລິຫານ</option>
                                        </select>
                                        </x-fns.select-wrap>
                                    </div>
                                    <div>
                                        <label for="channel_type" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຊ່ວງ ປຕ/ປທ</label>
                                        <x-fns.select-wrap>
                                        <select id="channel_type" name="channel_type" class="fns-select ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                            <option value="ເງິນບໍລິຫານທົ່ວໄປ" {{ old('channel_type', $channelType) == 'ເງິນບໍລິຫານທົ່ວໄປ' ? 'selected' : '' }}>ເງິນບໍລິຫານທົ່ວໄປ</option>
                                            <option value="ເງິນຕ່າງປະເທດ" {{ old('channel_type', $channelType) == 'ເງິນຕ່າງປະເທດ' ? 'selected' : '' }}>ເງິນຕ່າງປະເທດ</option>
                                        </select>
                                        </x-fns.select-wrap>
                                    </div>

                                    <!-- Row 7 -->
                                    <div class="sm:col-span-2">
                                        <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລາຍລະອຽດ <span class="text-gray-400 font-normal lowercase">(ບໍ່ຈຳເປັນ)</span></label>
                                        <textarea id="description" name="description" rows="2" class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full resize-none placeholder-gray-300" placeholder="ອະທິບາຍເພິ່ມເຕີມ...">{{ old('description', $userDesc) }}</textarea>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="w-full ui-btn bg-indigo-500 text-white hover:bg-indigo-600 shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/40 text-sm py-2.5 outline-none focus:ring-2 focus:ring-indigo-500 ring-offset-1 flex justify-center items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                        ອັບເດດລາຍຈ່າຍ
                                    </button>
                                </div>
                            </form>
                        </div>
            </div>

        </div>
    </div>

    <script>
        // Auto-sync budget year with transaction date
        const dateInput = document.getElementById('transaction_date');
        const budgetYearInput = document.getElementById('budget_year');
        if (dateInput && budgetYearInput) {
            dateInput.addEventListener('change', function() {
                if (this.value) {
                    const year = this.value.split('-')[0];
                    budgetYearInput.value = year;
                }
            });
        }

        // Fetch suggestions for item_name
        const itemNameInput = document.getElementById('item_name');
        const datalist = document.getElementById('item_name_suggestions');
        
        if (itemNameInput && datalist) {
            const fetchSuggestions = (query = '') => {
                fetch(`/expense/item-suggestions?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        datalist.innerHTML = '';
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item;
                            datalist.appendChild(option);
                        });
                    })
                    .catch(err => console.error('Error fetching suggestions:', err));
            };

            itemNameInput.addEventListener('focus', function() {
                if (!this.value) {
                    fetchSuggestions('');
                }
            });

            let debounceTimer;
            itemNameInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const val = this.value;
                debounceTimer = setTimeout(() => {
                    fetchSuggestions(val);
                }, 300);
            });
        }
    </script>
</x-app-layout>

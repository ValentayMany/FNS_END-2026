<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 min-w-0">
            <!-- Back Button -->
            <a href="{{ route('expense.history') }}" class="p-2 -ml-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            
            <div class="flex flex-col gap-1.5 min-w-0">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                        ຟອມແກ້ໄຂລາຍຈ່າຍວິຊາການແລະງົບປະມານ
                    </h2>
                </div>
                <p class="text-sm font-semibold text-gray-500 pl-10">ແກ້ໄຂຂໍ້ມູນລາຍຈ່າຍ #{{ $transaction->id }}</p>
            </div>
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

            <div class="fns-card border-t-4 border-t-rose-500 shadow-lg hover:shadow-xl transition-shadow relative overflow-hidden bg-white rounded-2xl">

                <!-- Decorative gradient corner -->
                <div class="absolute -top-16 -right-16 w-32 h-32 bg-rose-100 rounded-full blur-2xl opacity-60 pointer-events-none"></div>

                <div class="fns-card-header bg-transparent relative z-10 border-b border-gray-50 py-5 px-6">
                    <h3 class="text-lg font-extrabold text-gray-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 rounded-full bg-rose-500 block"></span>
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
                                            class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full"
                                            value="{{ old('payment_code', $transaction->payment_code) }}" required readonly />
                                    </div>
                                    <div>
                                        <label for="transaction_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ວັນທີຈ່າຍ <span class="text-red-500">*</span></label>
                                        <input id="transaction_date" name="transaction_date" type="date"
                                            class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full"
                                            value="{{ old('transaction_date', $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d') : '') }}" required />
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="sm:col-span-2">
                                        <label for="item_name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຊື່ລາຍການຈ່າຍ <span class="text-red-500">*</span></label>
                                        <input id="item_name" name="item_name" type="text" list="item_name_suggestions" autocomplete="off"
                                            class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full"
                                            value="{{ old('item_name', $transaction->item_name) }}" placeholder="ຊື່ລາຍການຈ່າຍ" required />
                                        <datalist id="item_name_suggestions"></datalist>
                                    </div>

                                    <!-- Row 3 -->
                                    <div>
                                        <label for="budget_year" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ປີງົບປະມານ</label>
                                        <input id="budget_year" name="budget_year" type="text"
                                            class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full"
                                            value="{{ old('budget_year', $transaction->transaction_date?->format('Y')) }}" />
                                    </div>
                                    <div>
                                        <label for="amount" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຈຳນວນເງິນຈ່າຍ <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-400 font-bold sm:text-sm">₭</span>
                                            </div>
                                            <input id="amount" name="amount" type="number" min="1" step="0.01"
                                                class="ui-input bg-white pl-8 focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all font-bold text-rose-700 w-full"
                                                value="{{ old('amount', $transaction->amount) }}" placeholder="ຈຳນວນເງິນຈ່າຍ" required />
                                        </div>
                                    </div>

                                    <!-- Row 4 -->
                                    <div class="sm:col-span-2">
                                        <label for="account_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ເລກບັນຊີ <span class="text-red-500">*</span></label>
                                        <x-fns.select-wrap>
                                            <div x-data="editAccountDropdown()" class="relative w-full">
                                                <!-- Trigger Button -->
                                                <button type="button" @click="open = !open; if (open) { $nextTick(() => $refs.searchInput.focus()) }" @click.away="open = false"
                                                    class="ui-input bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10 py-2.5 px-4 rounded-xl text-left border border-gray-200 block truncate">
                                                    <span x-text="selectedText" class="truncate text-gray-700"></span>
                                                </button>

                                                <!-- Native hidden select for form submission and JS compatibility -->
                                                <select id="account_id" name="account_id" required style="display: none !important;">
                                                    <option value="">ເລກບັນຊີ</option>
                                                    @foreach ($accounts as $acc)
                                                        <option value="{{ $acc->id }}" {{ old('account_id', $transaction->account_id) == $acc->id ? 'selected' : '' }}>
                                                            {{ $acc->account_code }} - {{ $acc->account_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <!-- Dropdown List -->
                                                <div x-show="open"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                    x-transition:leave-end="transform opacity-0 scale-95"
                                                    class="absolute left-0 right-0 z-50 mt-1.5 w-full bg-white rounded-xl shadow-xl border border-gray-100 max-h-64 overflow-hidden flex flex-col">

                                                    <!-- Search Input -->
                                                    <div class="p-2 border-b border-gray-100 bg-gray-50/50">
                                                        <input type="text" x-model="search" x-ref="searchInput" @click.stop=""
                                                            placeholder="ຄົ້ນຫາເລກບັນຊີ..."
                                                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all bg-white" />
                                                    </div>

                                                    <!-- Options List -->
                                                    <ul class="overflow-y-auto max-h-48 py-1 divide-y divide-gray-50">
                                                        <template x-for="acc in filteredAccounts" :key="acc.id">
                                                            <li @click="select(acc.id, acc.code + ' - ' + acc.name)"
                                                                class="cursor-pointer px-4 py-2.5 text-sm text-gray-700 hover:bg-rose-50/60 hover:text-rose-900 transition-colors flex justify-between items-center"
                                                                :class="acc.id == selectedId ? 'bg-rose-50/80 font-semibold text-rose-900' : ''">
                                                                <span x-text="acc.code + ' - ' + acc.name" class="truncate"></span>
                                                                <svg x-show="acc.id == selectedId" class="h-4 w-4 text-rose-600 shrink-0 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                                </svg>
                                                            </li>
                                                        </template>
                                                        <div x-show="filteredAccounts.length === 0" class="px-4 py-4 text-sm text-gray-400 text-center">
                                                            ບໍ່ພົບຂໍ້ມູນ...
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                            <script>
                                                function editAccountDropdown() {
                                                    return {
                                                        open: false,
                                                        search: '',
                                                        selectedId: '{{ old('account_id', $transaction->account_id) }}',
                                                        selectedText: 'ເລກບັນຊີ',
                                                        accounts: [
                                                            @foreach ($accounts as $acc)
                                                                { id: '{{ $acc->id }}', code: '{{ $acc->account_code }}', name: {!! json_encode($acc->account_name) !!} },
                                                            @endforeach
                                                        ],
                                                        init() {
                                                            let initial = this.accounts.find(a => a.id == this.selectedId);
                                                            if (initial) {
                                                                this.selectedText = initial.code + ' - ' + initial.name;
                                                            }
                                                        },
                                                        select(id, text) {
                                                            this.selectedId = id;
                                                            this.selectedText = text;
                                                            this.open = false;
                                                            this.search = '';

                                                            const sel = document.getElementById('account_id');
                                                            if (sel) {
                                                                sel.value = id;
                                                                sel.dispatchEvent(new Event('change'));
                                                            }
                                                        },
                                                        get filteredAccounts() {
                                                            if (!this.search.trim()) return this.accounts;
                                                            const q = this.search.toLowerCase();
                                                            return this.accounts.filter(a =>
                                                                a.code.toLowerCase().includes(q) ||
                                                                a.name.toLowerCase().includes(q)
                                                            );
                                                        }
                                                    };
                                                }
                                            </script>
                                        </x-fns.select-wrap>
                                    </div>

                                    <!-- Row 5 -->
                                    <div>
                                        <label for="department_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ພາກສ່ວນຈ່າຍ <span class="text-red-500">*</span></label>
                                        <x-fns.select-wrap>
                                            <select id="department_id" name="department_id" required class="fns-select ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                                @foreach ($departments as $dept)
                                                    @if ($dept->department_type === 'central' || $dept->department_name === 'ພາກສ່ວນກາງ')
                                                        <option value="{{ $dept->id }}" {{ old('department_id', $transaction->department_id) == $dept->id ? 'selected' : '' }}>
                                                            {{ $dept->expenseSectionLabel() }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </x-fns.select-wrap>
                                    </div>
                                    <div>
                                        <label for="category" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຮ່ວງລາຍຈ່າຍ <span class="text-red-500">*</span></label>
                                        <x-fns.select-wrap>
                                        <select id="category" name="category" required class="fns-select ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
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
                                        <select id="expense_type" name="expense_type" class="fns-select ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                            <option value="ງົບປະມານວິຊາການ" {{ old('expense_type', $expenseType) == 'ງົບປະມານວິຊາການ' ? 'selected' : '' }}>ງົບປະມານວິຊາການ</option>
                                            <option value="ງົບປະມານບໍລິຫານ" {{ old('expense_type', $expenseType) == 'ງົບປະມານບໍລິຫານ' ? 'selected' : '' }}>ງົບປະມານບໍລິຫານ</option>
                                        </select>
                                        </x-fns.select-wrap>
                                    </div>
                                    <div>
                                        <label for="channel_type" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຮ່ວງ ປຕ/ປທ</label>
                                        <x-fns.select-wrap>
                                        <select id="channel_type" name="channel_type" class="fns-select ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                            <option value="ເງິນບໍລິຫານທົ່ວໄປ" {{ old('channel_type', $channelType) == 'ເງິນບໍລິຫານທົ່ວໄປ' ? 'selected' : '' }}>ເງິນບໍລິຫານທົ່ວໄປ</option>
                                            <option value="ເງິນຕ່າງປະເທດ" {{ old('channel_type', $channelType) == 'ເງິນຕ່າງປະເທດ' ? 'selected' : '' }}>ເງິນຕ່າງປະເທດ</option>
                                        </select>
                                        </x-fns.select-wrap>
                                    </div>

                                    <!-- Row 7 -->
                                    <div class="sm:col-span-2">
                                        <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລາຍລະອຽດ <span class="text-gray-400 font-normal lowercase">(ບໍ່ຈຳເປັນ)</span></label>
                                        <textarea id="description" name="description" rows="2" class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full resize-none placeholder-gray-300" placeholder="ອະທິບາຍເພິ່ມເຕີມ...">{{ old('description', $userDesc) }}</textarea>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-2 gap-3">
                                    <a href="{{ route('expense.history') }}" class="ui-btn bg-gray-100 text-gray-600 hover:bg-gray-200 text-sm py-2.5 px-6 flex justify-center items-center gap-2 flex-1">
                                        ← ຍົກເລີກ
                                    </a>
                                    <button type="submit" class="ui-btn bg-rose-500 text-white hover:bg-rose-600 shadow-lg shadow-rose-500/30 hover:shadow-rose-500/40 text-sm py-2.5 px-6 outline-none focus:ring-2 focus:ring-rose-500 ring-offset-1 flex justify-center items-center gap-2 flex-[2]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
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

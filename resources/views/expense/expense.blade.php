<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1.5 min-w-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                    # ບັນທຶກລາຍຈ່າຍ (Expense)
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

                {{-- Single Card: Form + Draft --}}
                <div class="fns-card border-t-4 border-t-rose-500 shadow-lg bg-white rounded-2xl overflow-hidden fns-animate">

                    {{-- Form Section --}}
                    <div class="fns-card-header bg-transparent border-b border-gray-100 py-5 px-6">
                        <h3 class="text-base font-extrabold text-gray-800 flex items-center gap-2">
                            <span class="w-1.5 h-5 rounded-full bg-rose-500 block"></span>
                            ຟອມເພີ່ມລາຍຈ່າຍ
                        </h3>
                    </div>

                    <div class="p-5 sm:p-6 bg-gray-50/30">
                        <form id="expenseForm" onsubmit="event.preventDefault(); addItemDraft();" class="space-y-4">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {{-- ລະຫັດລາຍຈ່າຍ --}}
                                <div>
                                    <label for="payment_code" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລະຫັດລາຍຈ່າຍ <span class="text-red-500">*</span></label>
                                    <input id="payment_code" name="payment_code" type="text"
                                        class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full"
                                        value="{{ old('payment_code', $nextPaymentCode) }}" required readonly />
                                </div>

                                {{-- ວັນທີຈ່າຍ --}}
                                <div>
                                    <label for="transaction_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ວັນທີຈ່າຍ <span class="text-red-500">*</span></label>
                                    <input id="transaction_date" name="transaction_date" type="date"
                                        class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full"
                                        value="{{ old('transaction_date', date('Y-m-d')) }}" required />
                                </div>

                                {{-- ປີງົບປະມານ --}}
                                <div>
                                    <label for="budget_year" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ປີງົບປະມານ</label>
                                    <input id="budget_year" name="budget_year" type="text"
                                        class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full"
                                        value="{{ old('budget_year', date('Y')) }}" />
                                </div>

                                {{-- ຊື່ລາຍການຈ່າຍ --}}
                                <div class="sm:col-span-2">
                                    <label for="item_name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຊື່ລາຍການຈ່າຍ <span class="text-red-500">*</span></label>
                                    <input id="item_name" name="item_name" type="text" list="item_name_suggestions" autocomplete="off"
                                        class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full"
                                        value="{{ old('item_name') }}" placeholder="ຊື່ລາຍການຈ່າຍ" required />
                                    <datalist id="item_name_suggestions"></datalist>
                                </div>

                                {{-- ຈໍານວນເງິນ --}}
                                <div>
                                    <label for="amount" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຈຳນວນເງິນຈ່າຍ <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-bold sm:text-sm">₭</span>
                                        </div>
                                        <input id="amount" name="amount" type="number" min="1" step="0.01"
                                            class="ui-input bg-white pl-8 focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all font-bold text-rose-700 w-full"
                                            value="{{ old('amount') }}" placeholder="ຈຳນວນເງິນຈ່າຍ" />
                                    </div>
                                </div>

                                @php
                                    $defaultDepartmentId = old('department_id', auth()->user()?->department_id ?? $departments->first()?->id);
                                @endphp

                                {{-- ເລກບັນຊີ --}}
                                <div class="sm:col-span-2 lg:col-span-3">
                                    <label for="account_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ເລກບັນຊີ <span class="text-red-500">*</span></label>
                                     <x-fns.select-wrap>
                                         <div x-data="expenseAccountDropdown()" class="relative w-full">
                                             <!-- Trigger Button -->
                                             <button type="button" @click="open = !open; if (open) { $nextTick(() => $refs.searchInput.focus()) }" @click.away="open = false"
                                                 class="ui-input bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10 py-2.5 px-4 rounded-xl text-left border border-gray-200 block truncate">
                                                 <span x-text="selectedText" class="truncate text-gray-700"></span>
                                             </button>

                                             <!-- Native hidden select for form submission and JS compatibility -->
                                             <select id="account_id" name="account_id" required style="display: none !important;">
                                                 <option value="">...ເລືອກເລກບັນຊີ...</option>
                                                 @foreach ($accounts as $acc)
                                                     <option value="{{ $acc->id }}" {{ old('account_id') == $acc->id ? 'selected' : '' }}>
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
                                             function expenseAccountDropdown() {
                                                 return {
                                                     open: false,
                                                     search: '',
                                                     selectedId: '{{ old('account_id') }}',
                                                     selectedText: '...ເລືອກເລກບັນຊີ...',
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

                                {{-- ພາກສ່ວນຈ່າຍ --}}
                                <div>
                                    <label for="department_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ພາກສ່ວນຈ່າຍ <span class="text-red-500">*</span></label>
                                    <x-fns.select-wrap>
                                        <select id="department_id" name="department_id" required class="fns-select ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                            @foreach ($departments as $dept)
                                                @if ($dept->department_type === 'central' || $dept->department_name === 'ພາກສ່ວນກາງ')
                                                    <option value="{{ $dept->id }}" {{ (string) $defaultDepartmentId === (string) $dept->id ? 'selected' : '' }}>
                                                        {{ $dept->expenseSectionLabel() }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </x-fns.select-wrap>
                                </div>

                                {{-- ຮ່ວງລາຍຈ່າຍ --}}
                                <div>
                                    <label for="category" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຮ່ວງລາຍຈ່າຍ <span class="text-red-500">*</span></label>
                                    <x-fns.select-wrap>
                                    <select id="category" name="category" required class="fns-select ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                        <option value="ງົບປະມານສົ່ງເສີມວິຊາການ" {{ old('category', 'ງົບປະມານສົ່ງເສີມວິຊາການ') == 'ງົບປະມານສົ່ງເສີມວິຊາການ' ? 'selected' : '' }}>ງົບປະມານສົ່ງເສີມວິຊາການ</option>
                                        <option value="ສົ່ງເສີມຊີວາການ" {{ old('category') == 'ສົ່ງເສີມຊີວາການ' ? 'selected' : '' }}>ສົ່ງເສີມຊີວາການ</option>
                                        <option value="ຮັບໃຊ້ການທົດລອງ" {{ old('category') == 'ຮັບໃຊ້ການທົດລອງ' ? 'selected' : '' }}>ຮັບໃຊ້ການທົດລອງ</option>
                                        <option value="ການເຄື່ອນໄຫວນອກຫຼັກສູດ" {{ old('category') == 'ການເຄື່ອນໄຫວນອກຫຼັກສູດ' ? 'selected' : '' }}>ການເຄື່ອນໄຫວນອກຫຼັກສູດ</option>
                                    </select>
                                    </x-fns.select-wrap>
                                </div>

                                {{-- ປະເພດລາຍຈ່າຍ --}}
                                <div>
                                    <label for="expense_type" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ປະເພດລາຍຈ່າຍ</label>
                                    <x-fns.select-wrap>
                                    <select id="expense_type" name="expense_type" class="fns-select ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                        <option value="ງົບປະມານວິຊາການ" {{ old('expense_type', 'ງົບປະມານວິຊາການ') == 'ງົບປະມານວິຊາການ' ? 'selected' : '' }}>ງົບປະມານວິຊາການ</option>
                                        <option value="ງົບປະມານບໍລິຫານ" {{ old('expense_type') == 'ງົບປະມານບໍລິຫານ' ? 'selected' : '' }}>ງົບປະມານບໍລິຫານ</option>
                                    </select>
                                    </x-fns.select-wrap>
                                </div>

                                {{-- ຊ່ອງ ປຕ/ປທ --}}
                                <div>
                                    <label for="channel_type" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຮ່ວງ ປຕ/ປທ</label>
                                    <x-fns.select-wrap>
                                    <select id="channel_type" name="channel_type" class="fns-select ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10">
                                        <option value="ເງິນບໍລິຫານທົ່ວໄປ" {{ old('channel_type', 'ເງິນບໍລິຫານທົ່ວໄປ') == 'ເງິນບໍລິຫານທົ່ວໄປ' ? 'selected' : '' }}>ເງິນບໍລິຫານທົ່ວໄປ</option>
                                        <option value="ເງິນຕ່າງປະເທດ" {{ old('channel_type') == 'ເງິນຕ່າງປະເທດ' ? 'selected' : '' }}>ເງິນຕ່າງປະເທດ</option>
                                    </select>
                                    </x-fns.select-wrap>
                                </div>

                                {{-- ລາຍລະອຽດ --}}
                                <div class="sm:col-span-2 lg:col-span-3">
                                    <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລາຍລະອຽດ <span class="text-gray-400 font-normal lowercase">(ບໍ່ຈຳເປັນ)</span></label>
                                    <textarea id="description" name="description" rows="2"
                                        class="ui-input bg-white focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all text-sm w-full resize-none placeholder-gray-300"
                                        placeholder="ອະທິບາຍເພິ່ມເຕີມ...">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-2 gap-3">
                                <button type="submit" id="btn-add-item" class="ui-btn bg-rose-500 text-white hover:bg-rose-600 shadow-lg shadow-rose-500/30 text-sm py-2.5 px-6 outline-none focus:ring-2 focus:ring-rose-500 ring-offset-1 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                    + ເພີ່ມລາຍການ
                                </button>
                                <a href="{{ url()->previous() }}" class="ui-btn bg-gray-100 text-gray-600 hover:bg-gray-200 text-sm py-2.5 px-6 flex items-center gap-2">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- Draft Items Table --}}
                    <div id="draft-container" class="hidden border-t border-gray-100 bg-gray-50/50 p-5 sm:p-6 transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-extrabold text-gray-800 flex items-center gap-2">
                                <span class="w-1.5 h-4 rounded-full bg-emerald-500 block"></span>
                                ລາຍການທີ່ກຽມບັນທຶກ (Draft List)
                            </h4>
                            <span id="draft-count-badge" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                0 ລາຍການ
                            </span>
                        </div>
                        <div class="overflow-x-auto rounded-xl border border-gray-100 bg-white shadow-sm">
                            <table class="w-full text-left border-collapse text-sm text-gray-700">
                                <thead>
                                    <tr class="bg-gray-50/70 border-b border-gray-100">
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500">ວັນທີ</th>
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500">ເລກບັນຊີ</th>
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500">ຊື່ລາຍການ</th>
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500">ພາກສ່ວນ</th>
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500 text-right">ຈຳນວນເງິນ (ກີບ)</th>
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500 text-center">ຈັດການ</th>
                                    </tr>
                                </thead>
                                <tbody id="draft-table-body" class="divide-y divide-gray-50">
                                    <!-- Dynamic rows go here -->
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50/30 border-t border-gray-100 font-extrabold">
                                        <td colspan="4" class="py-3 px-4 text-right text-gray-600">...ລວມທັງໝົດ...</td>
                                        <td id="draft-total-amount" class="py-3 px-4 text-right text-rose-700 font-mono text-[1rem]">0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" id="btn-save-all" onclick="saveAllTransactions()" class="ui-btn bg-emerald-600 text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/30 text-sm py-2.5 px-6 outline-none flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                ✓ ບັນທຶກທັງໝົດ
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:99999;" aria-modal="true" role="dialog">
        <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);" onclick="closeDeleteModal()"></div>
        <div style="position:relative; display:flex; align-items:center; justify-content:center; width:100%; height:100%; padding:1rem;">
            <div class="bg-white rounded-2xl shadow-2xl fns-animate" style="max-width:24rem; width:100%; padding:1.5rem; position:relative; z-index:1;">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-rose-100 mx-auto mb-4">
                    <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </div>
                <h3 class="text-lg font-extrabold text-gray-900 text-center mb-1">ຢືນຢັນການລຶບ</h3>
                <p class="text-sm text-gray-500 text-center mb-1">ທ່ານຕ້ອງການລຶບລາຍການຈ່າຍ:</p>
                <p id="deleteItemName" class="text-sm font-bold text-rose-600 text-center mb-5 truncate px-2"></p>
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
    </div>

    <script>
        function teleportModal() {
            const modal = document.getElementById('deleteModal');
            if (modal && modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', teleportModal);
        } else {
            teleportModal();
        }

        let draftItems = [];
        let savedTransactionIds = [];

        function openDeleteModal(id, name) {
            document.getElementById('deleteForm').action = '/expense/' + id;
            document.getElementById('deleteItemName').textContent = name;
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.style.display = 'block';
            }
            document.body.style.overflow = 'hidden';
        }
        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.style.display = 'none';
            }
            document.body.style.overflow = '';
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

        function addItemDraft() {
            const dateInput = document.getElementById('transaction_date');
            const accountSelect = document.getElementById('account_id');
            const itemNameInput = document.getElementById('item_name');
            const amountInput = document.getElementById('amount');
            const departmentSelect = document.getElementById('department_id');
            const categorySelect = document.getElementById('category');
            const expenseTypeSelect = document.getElementById('expense_type');
            const channelTypeSelect = document.getElementById('channel_type');
            const descInput = document.getElementById('description');

            if (!dateInput.value || !accountSelect.value || !itemNameInput.value.trim() || !amountInput.value || !departmentSelect.value || !categorySelect.value) {
                alert('ກະລຸນາກອກຂໍ້ມູນໃຫ້ຄົບຖ້ວນ');
                return;
            }

            const item = {
                transaction_date: dateInput.value,
                account_id: accountSelect.value,
                account_text: accountSelect.options[accountSelect.selectedIndex].text,
                item_name: itemNameInput.value.trim(),
                amount: parseFloat(amountInput.value),
                department_id: departmentSelect.value,
                department_text: departmentSelect.options[departmentSelect.selectedIndex].text,
                category: categorySelect.value,
                expense_type: expenseTypeSelect.value,
                channel_type: channelTypeSelect.value,
                description: descInput.value.trim(),
                id_temp: Date.now() + Math.random().toString(36).substr(2, 9)
            };

            draftItems.push(item);
            renderDraftTable();

            // Clear item-specific fields but keep header details
            itemNameInput.value = '';
            amountInput.value = '';
            descInput.value = '';

            itemNameInput.focus();
        }

        function removeDraftItem(tempId) {
            draftItems = draftItems.filter(item => item.id_temp !== tempId);
            renderDraftTable();
        }

        function renderDraftTable() {
            const container = document.getElementById('draft-container');
            const tbody = document.getElementById('draft-table-body');
            const countBadge = document.getElementById('draft-count-badge');
            const totalAmountEl = document.getElementById('draft-total-amount');

            if (draftItems.length === 0) {
                container.classList.add('hidden');
                tbody.innerHTML = '';
                countBadge.textContent = '0 ລາຍການ';
                totalAmountEl.textContent = '0.00';
                return;
            }

            container.classList.remove('hidden');
            countBadge.textContent = `${draftItems.length} ລາຍການ`;

            let total = 0;
            tbody.innerHTML = '';

            draftItems.forEach((item, index) => {
                total += item.amount;

                // Format amount
                const formattedAmt = new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(item.amount);

                // Date format dd/mm/yyyy
                const dateParts = item.transaction_date.split('-');
                const formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;

                const tr = document.createElement('tr');
                tr.className = 'hover:bg-emerald-50/20 transition-colors border-b border-gray-100';
                tr.innerHTML = `
                    <td class="py-2 px-4 whitespace-nowrap text-sm text-gray-500">${formattedDate}</td>
                    <td class="py-2 px-4 text-xs font-semibold text-gray-700">${item.account_text.split(' - ')[0]}</td>
                    <td class="py-2 px-4 text-sm font-medium text-gray-800">
                        <div>${item.item_name}</div>
                        ${item.description ? `<div class="text-xs text-gray-400">${item.description}</div>` : ''}
                    </td>
                    <td class="py-2 px-4 text-sm text-gray-500">${item.department_text}</td>
                    <td class="py-2 px-4 text-right whitespace-nowrap font-bold text-rose-700 font-mono">${formattedAmt}</td>
                    <td class="py-2 px-4 text-center">
                        <button type="button" onclick="removeDraftItem('${item.id_temp}')" class="text-rose-500 hover:text-rose-700 p-1 font-bold text-xs bg-rose-50 hover:bg-rose-100 rounded transition-all">
                            ລຶບ
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            totalAmountEl.textContent = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(total);
        }

        function saveAllTransactions() {
            if (draftItems.length === 0) return;

            const btnSave = document.getElementById('btn-save-all');
            const originalHtml = btnSave.innerHTML;
            btnSave.disabled = true;
            btnSave.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                ກຳລັງບັນທຶກ...
            `;

            fetch('{{ route("expense.store-batch") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ transactions: draftItems })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.ids) {
                    savedTransactionIds = data.ids;
                    // Redirect directly to the print balance page in the same window
                    window.location.href = '{{ route("expense.print-balance") }}?ids=' + savedTransactionIds.join(',');
                } else {
                    alert('ເກີດຂໍ້ຜິດພາດ: ' + (data.message || 'ບໍ່ສາມາດບັນທຶກໄດ້'));
                    btnSave.disabled = false;
                    btnSave.innerHTML = originalHtml;
                }
            })
            .catch(err => {
                console.error(err);
                alert('ເກີດຂໍ້ຜິດພາດໃນການເຊື່ອມຕໍ່');
                btnSave.disabled = false;
                btnSave.innerHTML = originalHtml;
            });
        }
    </script>

</x-app-layout>

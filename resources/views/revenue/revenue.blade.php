<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 min-w-0">
            <div class="flex flex-col gap-0.5 min-w-0">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                        ບັນທືກລາຍຮັບ
                    </h2>
                </div>
                <p class="text-sm font-semibold text-gray-400 pl-10">
                    {{ today()->format('d/m/Y') }}
                    &nbsp;—&nbsp;
                    ລວມມື້ນີ້:
                    <span class="text-indigo-600 font-extrabold">
                        ₭ {{ number_format(collect($departments)->sum(fn($d) => $dailyStats[$d->id]['total'] ?? 0)) }}
                    </span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">

                {{-- Alert Notifications --}}
                @if (session('success'))
                    <div class="fns-alert fns-alert-success fns-animate shadow-sm">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="fns-alert fns-alert-error fns-animate shadow-sm">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="font-bold">{{ session('error') }}</span>
                    </div>
                @endif


                {{-- Main Card --}}

                <div class="fns-card border-t-4 border-t-indigo-500 shadow-lg bg-white rounded-2xl overflow-hidden fns-animate">

                    <div class="fns-card-header bg-transparent border-b border-gray-100 py-5 px-6">
                        <h3 class="text-base font-extrabold text-gray-800 flex items-center gap-2">
                            <span class="w-1.5 h-5 rounded-full bg-indigo-500 block"></span>
                            ແບບຟອມບັນທຶກລາຍຮັບ
                        </h3>
                    </div>

                    <div class="p-5 sm:p-6 bg-gray-50/30">
                        <form method="POST" action="{{ route('revenue.store') }}" class="space-y-4" id="revenue-form">
                            @csrf

                            {{-- Section 1: ຂໍ້ມູນຫຼັກ (4 columns on large screens) --}}
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                                {{-- 1. ເລກທີໃບບິນ --}}
                                <div>
                                    <label for="payment_code" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                        ເລກທີໃບບິນ <span class="text-indigo-500">*</span>
                                    </label>
                                    <div class="relative overflow-hidden rounded-xl">
                                        <input id="payment_code" name="payment_code" type="text" required
                                            class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm font-bold w-full pr-24 h-11 rounded-xl border border-gray-200"
                                            value="{{ old('payment_code', $nextCode ?? '') }}"
                                            placeholder="ເຊັ່ນ: 16864"
                                            autocomplete="off" />
                                        @if($nextCode ?? false)
                                        <span id="auto-badge"
                                            class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-600 pointer-events-none select-none whitespace-nowrap">ອັດຕະໂນມັດ</span>
                                        @endif
                                    </div>
                                    <x-input-error :messages="$errors->get('payment_code')" class="mt-1" />
                                </div>

                                {{-- 2. ວັນທີຮັບ --}}
                                <div>
                                    <label for="transaction_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                        ວັນທີຮັບ <span class="text-indigo-500">*</span>
                                    </label>
                                    <input id="transaction_date" name="transaction_date" type="date"
                                        class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full h-11 rounded-xl border border-gray-200"
                                        value="{{ old('transaction_date', today()->toDateString()) }}" required />
                                    <x-input-error :messages="$errors->get('transaction_date')" class="mt-1" />
                                </div>

                                {{-- 3. ຊ່ອງລາຍຮັບ --}}
                                <div>
                                    <label for="department_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                        ຊ່ອງລາຍຮັບ <span class="text-indigo-500">*</span>
                                    </label>
                                    <x-fns.select-wrap>
                                        <select id="department_id" name="department_id" required class="fns-select ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10 h-11 rounded-xl border border-gray-200">
                                            <option value="">-- ເລືອກຊ່ອງລາຍຮັບ --</option>
                                            @foreach ($departments as $dept)
                                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                                    {{ $dept->displayName() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </x-fns.select-wrap>
                                    <x-input-error :messages="$errors->get('department_id')" class="mt-1" />
                                </div>

                                {{-- 4. ຮ່ວງລາຍຮັບ --}}
                                <div>
                                    <label for="revenue_channel" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                        ຮ່ວງລາຍຮັບ
                                    </label>
                                    <x-fns.select-wrap>
                                        <select id="revenue_channel" name="revenue_channel"
                                            class="fns-select ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10 h-11 rounded-xl border border-gray-200">
                                            <option value="">-- ຮ່ວງລາຍຮັບ --</option>
                                            <option value="ເງີນບໍລິຫານທົ່ວໄປ" {{ old('revenue_channel') === 'ເງີນບໍລິຫານທົ່ວໄປ' ? 'selected' : '' }}>ເງີນບໍລິຫານທົ່ວໄປ</option>
                                        </select>
                                    </x-fns.select-wrap>
                                </div>

                            </div>{{-- /Section 1 --}}

                            {{-- Section 2: ລະຫັດນັກສຶກສາ  (full width) --}}
                            <div id="student-search-wrapper">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                        ລະຫັດນັກສຶກສາ
                                    </label>
                                    <input type="hidden" name="student_id" id="student_id" value="" />

                                    <div class="relative">
                                        {{-- Trigger button (shown when no student selected) --}}
                                        <button type="button" id="student-trigger-btn"
                                            class="ui-input bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10 py-2.5 px-4 rounded-xl text-left border border-gray-200 relative text-gray-500">
                                            ...ຄົ້ນຫາລະຫັດ ຫຼື ຊື່ນັກສຶກສາ...
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </div>
                                        </button>

                                        {{-- Selected student display (shown after selection) --}}
                                        <div id="student-info-card" class="hidden ui-input bg-white border border-indigo-200 shadow-sm text-sm w-full rounded-xl flex items-center justify-between gap-3 pr-3 pl-4 py-2">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0">&#127891;</div>
                                                <div>
                                                    <p id="student-info-name" class="font-extrabold text-gray-900 text-sm leading-tight"></p>
                                                    <p id="student-info-detail" class="text-xs text-gray-500 mt-0.5"></p>
                                                </div>
                                            </div>
                                            <button type="button" id="clear-student-btn"
                                                class="text-xs bg-gray-100 hover:bg-red-50 hover:text-red-600 text-gray-500 border border-gray-200 px-2.5 py-1 rounded-lg font-bold shrink-0 flex items-center gap-1 transition-all">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                ລ້າງ
                                            </button>
                                        </div>

                                        {{-- Dropdown panel --}}
                                        <div id="student-dropdown-panel"
                                            class="hidden absolute left-0 right-0 z-50 mt-1.5 w-full bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                                            {{-- Search input inside panel --}}
                                            <div class="p-2 border-b border-gray-100 bg-gray-50/50">
                                                <div class="relative">
                                                    <input type="text" id="student-search-input"
                                                        placeholder="ຄົ້ນຫາລະຫັດ ຫຼື ຊື່ນັກສຶກສາ..."
                                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-white"
                                                        autocomplete="off" />
                                                    <div id="search-spinner" class="hidden absolute inset-y-0 right-2 items-center">
                                                        <svg class="animate-spin w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Results list --}}
                                            <div id="student-dropdown" class="divide-y divide-gray-50 py-1" style="max-height:16rem; overflow-y:auto;"></div>
                                        </div>
                                    </div>
                            </div>{{-- /Section 2 --}}

                            {{-- Section 3: ຄ່າທຳນຽມ + ວິທີຮັບ (3 columns) --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                {{-- 5. ຄ່າລົງທະບຽນ --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຄ່າລົງທະບຽນ</label>
                                    <input type="hidden" name="fees[0][label]" value="ຄ່າລົງທະບຽນ" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-bold text-sm">₭</span>
                                        </div>
                                        <input type="text" inputmode="numeric" id="fee-display-0"
                                            class="ui-input bg-white pl-8 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all font-bold text-indigo-700 text-sm w-full"
                                            placeholder="0" autocomplete="off" />
                                        <input type="hidden" name="fees[0][amount]" id="fee-amount-0" value="0" />
                                    </div>
                                </div>

                                {{-- 6. ຄ່າໜ່ວຍກິດ --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຄ່າໜ່ວຍກິດ</label>
                                    <input type="hidden" name="fees[1][label]" value="ຄ່າໜ່ວຍກິດ" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-bold text-sm">₭</span>
                                        </div>
                                        <input type="text" inputmode="numeric" id="fee-display-1"
                                            class="ui-input bg-white pl-8 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all font-bold text-indigo-700 text-sm w-full"
                                            placeholder="0" autocomplete="off" />
                                        <input type="hidden" name="fees[1][amount]" id="fee-amount-1" value="0" />
                                    </div>
                                </div>

                                {{-- 7. ຄ່າບູລະນະ ຫທລ --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຄ່າບູລະນະ ຫທລ</label>
                                    <input type="hidden" name="fees[2][label]" value="ຄ່າບູລະນະ ຫທລ" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-bold text-sm">₭</span>
                                        </div>
                                        <input type="text" inputmode="numeric" id="fee-display-2"
                                            class="ui-input bg-white pl-8 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all font-bold text-indigo-700 text-sm w-full"
                                            placeholder="0" autocomplete="off" />
                                        <input type="hidden" name="fees[2][amount]" id="fee-amount-2" value="0" />
                                    </div>
                                </div>

                                {{-- 8. ຄ່າໜ່ວຍກິດ ທສ --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຄ່າໜ່ວຍກິດ ທສ</label>
                                    <input type="hidden" name="fees[3][label]" value="ຄ່າໜ່ວຍກິດ ທສ" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-bold text-sm">₭</span>
                                        </div>
                                        <input type="text" inputmode="numeric" id="fee-display-3"
                                            class="ui-input bg-white pl-8 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all font-bold text-indigo-700 text-sm w-full"
                                            placeholder="0" autocomplete="off" />
                                        <input type="hidden" name="fees[3][amount]" id="fee-amount-3" value="0" />
                                    </div>
                                </div>

                                {{-- 9. ຄ່າບໍລິການອື່ນໆ --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຄ່າບໍລິການອື່ນໆ</label>
                                    <input type="hidden" name="fees[4][label]" value="ຄ່າບໍລິການອື່ນໆ" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-bold text-sm">₭</span>
                                        </div>
                                        <input type="text" inputmode="numeric" id="fee-display-4"
                                            class="ui-input bg-white pl-8 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all font-bold text-indigo-700 text-sm w-full"
                                            placeholder="0" autocomplete="off" />
                                        <input type="hidden" name="fees[4][amount]" id="fee-amount-4" value="0" />
                                    </div>
                                </div>

                                {{-- 10. ປະເພດລາຍຮັບ --}}
                                <div>
                                    <label for="payment_method" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                        ປະເພດລາຍຮັບ <span class="text-indigo-500">*</span>
                                    </label>
                                    <x-fns.select-wrap>
                                        <select id="payment_method" name="payment_method" required class="fns-select ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer pr-10 h-11 rounded-xl border border-gray-200">
                                            <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>🏦 ເງິນທະນາຄານ / ໂອນເຂົ້າ</option>
                                            <option value="cash" {{ old('payment_method', 'cash') == 'cash' ? 'selected' : '' }}>💵 ເງິນສົດ</option>
                                        </select>
                                    </x-fns.select-wrap>
                                    <x-input-error :messages="$errors->get('payment_method')" class="mt-1" />
                                </div>

                                {{-- ລາຍລະອຽດ is moved outside this grid --}}

                            </div>{{-- /Section 3 --}}

                            {{-- ລາຍລະອຽດ full width --}}
                            <div>
                                <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລາຍລະອຽດ (ບໍ່ຈຳເປັນ)</label>
                                <textarea id="description" name="description" rows="1"
                                    class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full resize-none placeholder-gray-300 h-11 py-2.5 rounded-xl border border-gray-200"
                                    placeholder="ອະທິບາຍເພິ່ມເຕີມ..." maxlength="500">{{ old('description') }}</textarea>
                            </div>
                            {{-- ລວມທັງໝົດ --}}
                            <div class="flex items-center justify-between p-4 bg-indigo-50/40 border border-indigo-100/50 rounded-xl">
                                <span class="text-sm font-bold text-indigo-900">ລວມທັງໝົດ</span>
                                <span id="fee-total-display" class="text-2xl font-extrabold text-indigo-700">₭ 0</span>
                            </div>

                            {{-- Form Actions --}}
                            <div class="flex items-center justify-end pt-3 gap-3 border-t border-gray-100">
                                <a href="{{ url()->previous() }}"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 text-sm font-bold transition-all">
                                    ← ຍົກເລີກ (Cancel)
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold shadow-lg shadow-indigo-500/30 hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500 ring-offset-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    ✓ ບັນທຶກ (Save)
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Table Card --}}
                <div class="fns-card shadow-sm border border-gray-100 bg-white fns-animate">
                    <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100">
                        <div>
                            <h3 class="text-base font-extrabold text-gray-800 flex items-center gap-2">
                                <span class="w-1.5 h-5 rounded-full bg-indigo-500 block"></span>
                                ປະຫວັດລາຍຮັບລ່າສຸດ
                            </h3>
                            <p class="text-xs text-gray-400 mt-0.5">ສະແດງລາຍການລ່າສຸດທີ່ຖືກບັນທຶກ</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" id="batchDeleteBtn" onclick="openBatchDeleteModal()" style="display:none;"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-sm transition-all duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                ລຶບທັງໝົດ (<span id="selectedCount">0</span>)
                            </button>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                ທັງໝົດ {{ $transactions->total() }} ລາຍການ
                            </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto touch-pan-x">
                        <table class="fns-table w-full text-left border-collapse" style="min-width:40rem;">
                            <thead>
                                <tr class="bg-gray-50/80 border-y border-gray-100">
                                    <th class="py-3 px-3 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-center whitespace-nowrap" style="width:40px;">
                                        <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll(this)" class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300 cursor-pointer" />
                                    </th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">ວັນທີ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">ເລກທີໃບບິນ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">ປະເພດລາຍຮັບ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">ພາກສ່ວນ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">ວິທີຮັບເງິນ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap">ຈຳນວນ (ກີບ)</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-center whitespace-nowrap">ຈັດການ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($transactions as $txn)
                                    <tr class="hover:bg-indigo-50/40 transition-colors duration-150 group">
                                        <td class="py-3.5 px-3 text-center whitespace-nowrap">
                                            <input type="checkbox" class="item-checkbox w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300 cursor-pointer" value="{{ $txn->id }}" onchange="updateBatchDeleteBtn()" />
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span class="text-sm font-semibold text-gray-600 group-hover:text-indigo-700 transition-colors">
                                                {{ $txn->transaction_date?->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span class="text-sm font-bold text-gray-800 whitespace-nowrap">
                                                {{ $txn->payment_code ?? '—' }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[0.68rem] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 whitespace-nowrap">
                                                {{ $txn->category ?? '—' }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100 whitespace-nowrap">
                                                {{ $txn->department?->displayName() ?? '—' }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            @if($txn->payment_method === 'cash')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[0.68rem] font-bold bg-amber-50 text-amber-700 border border-amber-100 whitespace-nowrap">
                                                    💵 ເງິນສົດ
                                                </span>
                                            @elseif($txn->payment_method === 'transfer')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[0.68rem] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 whitespace-nowrap">
                                                    🏦 ໂອນເຂົ້າ
                                                </span>
                                            @else
                                                <span class="text-gray-400 font-medium">—</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <span class="font-extrabold text-indigo-600 text-[0.95rem] tracking-tight">
                                                {{ number_format($txn->amount, 0) }}
                                            </span>
                                            <span class="text-xs text-gray-400 ml-0.5">₭</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <a href="{{ route('revenue.edit', $txn) }}"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 hover:bg-indigo-100 hover:border-indigo-300 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                    ແກ້ໄຂ
                                                </a>
                                                <button type="button"
                                                    onclick="openDeleteModal('{{ $txn->id }}', '{{ addslashes($txn->category) }}')"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-purple-50 text-purple-600 border border-purple-100 hover:bg-purple-100 hover:border-purple-300 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    ລຶບ
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-12">
                                            <div class="flex flex-col items-center justify-center text-center">
                                                <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 mb-4 border border-gray-100">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v4.125c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 013 17.25v-4.125zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125v-8.25zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v12.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                                                </div>
                                                <p class="text-gray-500 font-bold">ຍັງບໍ່ມີປະຫວັດການຮັບເງິນ</p>
                                                <p class="text-xs text-gray-400 mt-1">ລາຍການທີ່ບັນທຶກຈະສະແດງໃນຕາຕະລາງນີ້</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($transactions->hasPages())
                        <div class="px-5 py-4 border-t border-gray-50 bg-gray-50/50">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:99999;" aria-modal="true" role="dialog">
        <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);" onclick="closeDeleteModal()"></div>
        <div style="position:relative; display:flex; align-items:center; justify-content:center; width:100%; height:100%; padding:1rem;">
            <div class="bg-white rounded-2xl shadow-2xl fns-animate" style="max-width:24rem; width:100%; padding:1.5rem; position:relative; z-index:1;">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-purple-100 mx-auto mb-4">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </div>
                <h3 class="text-lg font-extrabold text-gray-900 text-center mb-1">ຢືນຢັນການລຶບ</h3>
                <p class="text-sm text-gray-500 text-center mb-1">ທ່ານຕ້ອງການລຶບລາຍການຮັບ:</p>
                <p id="deleteItemName" class="text-sm font-bold text-indigo-600 text-center mb-5 truncate px-2"></p>
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
                            class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-lg hover:-translate-y-0.5 transition-all duration-150 text-sm">
                            ລຶບເລີຍ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Batch Delete Confirmation Modal --}}
    <div id="batchDeleteModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:99999;" aria-modal="true" role="dialog">
        <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);" onclick="closeBatchDeleteModal()"></div>
        <div style="position:relative; display:flex; align-items:center; justify-content:center; width:100%; height:100%; padding:1rem;">
            <div class="bg-white rounded-2xl shadow-2xl fns-animate" style="max-width:24rem; width:100%; padding:1.5rem; position:relative; z-index:1;">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-purple-100 mx-auto mb-4">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </div>
                <h3 class="text-lg font-extrabold text-gray-900 text-center mb-1">ຢືນຢັນການລຶບທັງໝົດ</h3>
                <p class="text-sm text-gray-500 text-center mb-1">ທ່ານຕ້ອງການລຶບ <span id="batchCountText" class="font-bold text-purple-600"></span> ລາຍການທີ່ເລືອກ?</p>
                <p class="text-xs text-gray-400 text-center mb-5">ການລຶບນີ້ບໍ່ສາມາດກູ້ຄືນໄດ້</p>
                <form id="batchDeleteForm" action="{{ route('revenue.destroy-batch') }}" method="POST">
                    @csrf
                    <div id="batchDeleteInputs"></div>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeBatchDeleteModal()"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-4 rounded-xl transition-all duration-150 text-sm">
                            ຍົກເລີກ
                        </button>
                        <button type="submit"
                            class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-lg hover:-translate-y-0.5 transition-all duration-150 text-sm">
                            ລຶບເລີຍ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== JavaScript ===== --}}
    <script>
    (function () {
        const SEARCH_URL = '{{ route('revenue.students.search') }}';
        const FEES_URL   = '{{ url('/api/students') }}';

        const searchInput    = document.getElementById('student-search-input');
        const dropdown       = document.getElementById('student-dropdown');
        const dropdownPanel  = document.getElementById('student-dropdown-panel');
        const triggerBtn     = document.getElementById('student-trigger-btn');
        const spinner        = document.getElementById('search-spinner');
        const studentIdInp   = document.getElementById('student_id');
        const infoCard       = document.getElementById('student-info-card');
        const infoName       = document.getElementById('student-info-name');
        const infoDetail     = document.getElementById('student-info-detail');
        const clearBtn       = document.getElementById('clear-student-btn');
        const feeTotalEl     = document.getElementById('fee-total-display');
        const wrapper        = document.getElementById('student-search-wrapper');

        const feeCount = 5;
        let searchTimer = null;

        // ---- Open/close dropdown panel ----
        function openPanel() {
            dropdownPanel.classList.remove('hidden');
            searchInput.focus();
        }
        function closePanel() {
            dropdownPanel.classList.add('hidden');
        }

        triggerBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            openPanel();
        });

        // ---- Student autocomplete search ----
        searchInput.addEventListener('input', function () {
            const q = this.value.trim();
            clearTimeout(searchTimer);
            if (q.length < 2) { dropdown.innerHTML = ''; return; }
            searchTimer = setTimeout(() => doSearch(q), 300);
        });

        async function doSearch(q) {
            spinner.classList.remove('hidden');
            try {
                const res  = await fetch(SEARCH_URL + '?q=' + encodeURIComponent(q), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                renderDropdown(data);
            } catch (e) { dropdown.innerHTML = ''; }
            spinner.classList.add('hidden');
        }

        function renderDropdown(items) {
            if (!items.length) {
                dropdown.innerHTML = '<div class="px-4 py-3 text-sm text-gray-400">ບໍ່ພົບນັກສຶກສາ</div>';
            } else {
                dropdown.innerHTML = items.map(s => `
                    <div class="student-option px-4 py-2.5 hover:bg-indigo-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors"
                        data-id="${s.id}">
                        <div class="font-bold text-sm text-gray-800">${s.student_code}</div>
                        <div class="text-xs text-gray-500">${s.name_prefix || ''} ${s.full_name} &mdash; ${s.program_name} ປີ ${s.study_year ?? '?'}</div>
                    </div>`).join('');
                dropdown.querySelectorAll('.student-option').forEach(el => {
                    el.addEventListener('click', () => {
                        const sid = el.dataset.id;
                        selectStudent(sid, items.find(s => s.id == sid));
                    });
                });
            }
        }

        async function selectStudent(id, info) {
            closePanel();
            spinner.classList.remove('hidden');
            studentIdInp.value = id;

            // Show info card, hide trigger button
            triggerBtn.classList.add('hidden');
            infoName.textContent   = (info.name_prefix || '') + ' ' + info.full_name;
            infoDetail.textContent = info.student_code + ' — ' + info.program_name + ' ປີ ' + (info.study_year ?? '?');
            infoCard.classList.remove('hidden');

            // Fetch student fees
            try {
                const res  = await fetch(FEES_URL + '/' + id + '/fees', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                fillFees(data.fees);
            } catch (e) { console.error(e); }
            spinner.classList.add('hidden');
        }

        function fillFees(fees) {
            fees.forEach((fee, idx) => {
                if (idx < feeCount) {
                    const displayInp = document.getElementById(`fee-display-${idx}`);
                    const amountInp  = document.getElementById(`fee-amount-${idx}`);
                    if (displayInp && amountInp) {
                        amountInp.value  = fee.amount || 0;
                        displayInp.value = fee.amount ? parseInt(fee.amount).toLocaleString() : '';
                    }
                }
            });
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            for (let i = 0; i < feeCount; i++) {
                const a = document.getElementById(`fee-amount-${i}`);
                if (a) total += parseFloat(a.value) || 0;
            }
            feeTotalEl.textContent = '₭ ' + total.toLocaleString();
        }

        // ---- Live comma-format for 5 fee inputs ----
        for (let i = 0; i < feeCount; i++) {
            const displayInp = document.getElementById(`fee-display-${i}`);
            const amountInp  = document.getElementById(`fee-amount-${i}`);
            if (displayInp && amountInp) {
                displayInp.addEventListener('input', function() {
                    const raw = this.value.replace(/[^0-9]/g, '');
                    this.value = raw ? parseInt(raw).toLocaleString() : '';
                    amountInp.value = raw || 0;
                    updateTotal();
                });
            }
        }

        // ---- Clear student ----
        clearBtn.addEventListener('click', function () {
            studentIdInp.value = '';
            searchInput.value  = '';
            infoCard.classList.add('hidden');
            triggerBtn.classList.remove('hidden');
            for (let i = 0; i < feeCount; i++) {
                const d = document.getElementById(`fee-display-${i}`);
                const a = document.getElementById(`fee-amount-${i}`);
                if (d && a) { a.value = 0; d.value = ''; }
            }
            updateTotal();
        });

        // ---- Close dropdown panel on outside click ----
        document.addEventListener('click', function (e) {
            if (wrapper && !wrapper.contains(e.target)) closePanel();
        });

        // ---- Auto-badge on payment_code change ----
        const pcInput = document.getElementById('payment_code');
        const badge   = document.getElementById('auto-badge');
        if (pcInput && badge) {
            pcInput.addEventListener('input', function () {
                badge.style.opacity = (this.value === '{{ $nextCode ?? '' }}') ? '1' : '0';
            });
        }

        // Reset student state on page load to prevent stale browser-restored state
        if (studentIdInp) studentIdInp.value = '';
        if (searchInput) searchInput.value = '';
        if (infoCard) infoCard.classList.add('hidden');
        if (triggerBtn) triggerBtn.classList.remove('hidden');
        for (let i = 0; i < feeCount; i++) {
            const d = document.getElementById(`fee-display-${i}`);
            const a = document.getElementById(`fee-amount-${i}`);
            if (d && a) { a.value = 0; d.value = ''; }
        }
        updateTotal();
    })();

    // ---- Modal functions ----
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        updateBatchDeleteBtn();
    }

    function updateBatchDeleteBtn() {
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        const btn = document.getElementById('batchDeleteBtn');
        const countSpan = document.getElementById('selectedCount');
        if (checkboxes.length > 0) {
            btn.style.display = 'inline-flex';
            countSpan.innerText = checkboxes.length;
        } else {
            btn.style.display = 'none';
            countSpan.innerText = '0';
            const master = document.getElementById('selectAllCheckbox');
            if (master) master.checked = false;
        }
    }

    function openBatchDeleteModal() {
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkboxes.length === 0) return;
        const container = document.getElementById('batchDeleteInputs');
        container.innerHTML = '';
        checkboxes.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });
        document.getElementById('batchCountText').innerText = checkboxes.length + ' ';
        const modal = document.getElementById('batchDeleteModal');
        modal.style.display = 'block';
        if (modal.parentElement !== document.body) document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';
    }

    function closeBatchDeleteModal() {
        const modal = document.getElementById('batchDeleteModal');
        if (modal) modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    function openDeleteModal(id, name) {
        document.getElementById('deleteItemName').textContent = name;
        const form = document.getElementById('deleteForm');
        form.action = '{{ url('/revenue') }}/' + id;
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'block';
        if (modal.parentElement !== document.body) document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        if (modal) modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    function teleportModal() {
        const modal = document.getElementById('deleteModal');
        if (modal && modal.parentElement !== document.body) document.body.appendChild(modal);
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', teleportModal);
    } else {
        teleportModal();
    }
    </script>
</x-app-layout>

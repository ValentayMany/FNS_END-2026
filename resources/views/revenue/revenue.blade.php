<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1.5 min-w-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                    ບັນທຶກລາຍຮັບ (Revenue)
                </h2>
            </div>
            <p class="text-sm font-semibold text-gray-500 pl-10">ບ່ອນບັນທຶກລາຍຮັບຕ່າງໆ ເຊັ່ນ ຄ່າຮັກສາສະຖານະພາບ, ຄ່າໜ່ວຍກິດ ເປັນຕົ້ນ</p>
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

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 lg:gap-8 items-start">
                
                {{-- Left Column: Form (4 cols) --}}
                <div class="xl:col-span-4 fns-animate space-y-6 relative">
                    <div class="fns-card border-t-4 border-t-emerald-500 shadow-md hover:shadow-lg transition-shadow relative overflow-hidden bg-white">
                        
                        <!-- Decorative gradient corner -->
                        <div class="absolute -top-16 -right-16 w-32 h-32 bg-emerald-100 rounded-full blur-2xl opacity-60 pointer-events-none"></div>

                        <div class="fns-card-header bg-transparent relative z-10 border-b border-gray-50 py-5">
                            <h3 class="text-lg font-extrabold text-gray-800 flex items-center gap-2">
                                <span class="w-1.5 h-6 rounded-full bg-emerald-500 block"></span>
                                ແບບຟອມບັນທຶກລາຍຮັບ
                            </h3>
                        </div>
                        
                        <div class="fns-card-body bg-gray-50/30 relative z-10 p-5 sm:p-6">
                            <form method="POST" action="{{ route('revenue.store') }}" class="space-y-4">
                                @csrf

                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="transaction_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ວັນທີ <span class="text-red-500">*</span></label>
                                        <input id="transaction_date" name="transaction_date" type="date"
                                            class="ui-input bg-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all" value="{{ old('transaction_date', today()->toDateString()) }}" required />
                                        <x-input-error :messages="$errors->get('transaction_date')" class="mt-1" />
                                    </div>

                                    <div>
                                        <label for="category" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ປະເພດລາຍຮັບ <span class="text-red-500">*</span></label>
                                        <select id="category" name="category" required class="ui-input bg-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all appearance-none cursor-pointer text-sm">
                                            <option value="">-- ເລືອກປະເພດລາຍຮັບ --</option>
                                            <option value="ຄ່າບຳລຸງຫ້ອງທົດລອງ" {{ old('category') == 'ຄ່າບຳລຸງຫ້ອງທົດລອງ' ? 'selected' : '' }}>ຄ່າບຳລຸງຫ້ອງທົດລອງ</option>
                                            <option value="ຄ່າລົງທະບຽນປະລິນຍາຕີ" {{ old('category') == 'ຄ່າລົງທະບຽນປະລິນຍາຕີ' ? 'selected' : '' }}>ຄ່າລົງທະບຽນປະລິນຍາຕີ</option>
                                            <option value="ຄ່າຮັກສາສະຖານະພາບ" {{ old('category') == 'ຄ່າຮັກສາສະຖານະພາບ' ? 'selected' : '' }}>ຄ່າຮັກສາສະຖານະພາບ</option>
                                            <option value="ຄ່າໜ່ວຍກິດປະລິນຍາຕີ" {{ old('category') == 'ຄ່າໜ່ວຍກິດປະລິນຍາຕີ' ? 'selected' : '' }}>ຄ່າໜ່ວຍກິດປະລິນຍາຕີ</option>
                                            <option value="ຄ່າໜ່ວຍກິດປະລິນຍາໂທ" {{ old('category') == 'ຄ່າໜ່ວຍກິດປະລິນຍາໂທ' ? 'selected' : '' }}>ຄ່າໜ່ວຍກິດປະລິນຍາໂທ</option>
                                            <option value="ຄ່າລົງທະບຽນອັບເກຣດ" {{ old('category') == 'ຄ່າລົງທະບຽນອັບເກຣດ' ? 'selected' : '' }}>ຄ່າລົງທະບຽນອັບເກຣດ</option>
                                            <option value="ຄ່າບໍລິການວິຊາການ" {{ old('category') == 'ຄ່າບໍລິການວິຊາການ' ? 'selected' : '' }}>ຄ່າບໍລິການວິຊາການ</option>
                                            <option value="ແຫຼ່ງລາຍຮັບອື່ນໆ" {{ old('category') == 'ແຫຼ່ງລາຍຮັບອື່ນໆ' ? 'selected' : '' }}>ແຫຼ່ງລາຍຮັບອື່ນໆ (ຖ້າມີ)</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('category')" class="mt-1" />
                                    </div>

                                    <div>
                                        <label for="amount" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຈຳນວນເງິນ (ກີບ) <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-400 font-bold sm:text-sm">₭</span>
                                            </div>
                                            <input id="amount" name="amount" type="number" class="ui-input bg-white pl-8 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all font-bold text-emerald-700" min="1" step="0.01" value="{{ old('amount') }}" placeholder="0.00" required />
                                        </div>
                                        <x-input-error :messages="$errors->get('amount')" class="mt-1" />
                                    </div>

                                    <div>
                                        <label for="account_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ໝວດບັນຊີ <span class="text-red-500">*</span></label>
                                        <select id="account_id" name="account_id" required class="ui-input bg-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all text-sm">
                                            <option value="">-- ເລືອກໝວດບັນຊີ --</option>
                                            @foreach ($accounts as $acc)
                                                <option value="{{ $acc->id }}" {{ old('account_id') == $acc->id ? 'selected' : '' }}>
                                                    {{ $acc->account_code }} - {{ $acc->account_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('account_id')" class="mt-1" />
                                    </div>

                                    <div>
                                        <label for="department_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ພາກສ່ວນ <span class="text-red-500">*</span></label>
                                        <select id="department_id" name="department_id" required class="ui-input bg-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all text-sm">
                                            <option value="">-- ເລືອກພາກສ່ວນ --</option>
                                            @foreach ($departments as $dept)
                                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                                    {{ $dept->displayName() }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('department_id')" class="mt-1" />
                                    </div>

                                    <div>
                                        <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລາຍລະອຽດ <span class="text-red-500">*</span></label>
                                        <textarea id="description" name="description" rows="3" required class="ui-input bg-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all text-sm resize-none placeholder-gray-300" placeholder="ອະທິບາຍລາຍລະອຽດແຫຼ່ງທີ່ມາຂອງລາຍຮັບແພີ່ມເຕີມ">{{ old('description') }}</textarea>
                                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                                    </div>

                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="w-full ui-btn ui-btn-success shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 text-sm py-2.5">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                        ບັນທຶກລາຍຮັບເຂົ້າລະບົບ
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Table (8 cols) --}}
                <div class="xl:col-span-8 fns-animate fns-animate-delay-1">
                    <div class="fns-card shadow-sm border border-gray-100 bg-white">
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-50">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">ປະຫວັດລາຍຮັບລ່າສຸດ</h3>
                                <p class="text-sm text-gray-500 mt-1">ສະແດງລາຍການລາຍຮັບທີ່ຖືກບັນທຶກລ่าສຸດ</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                ທັງໝົດ {{ $transactions->total() }} ລາຍການ
                            </span>
                        </div>

                        <div class="overflow-x-auto touch-pan-x">
                            <table class="fns-table w-full text-left border-collapse" style="min-width:44rem;">
                                <thead>
                                    <tr class="bg-gray-50/80 border-y border-gray-100">
                                        <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider">ວັນທີ</th>
                                        <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider">ປະເພດລາຍຮັບ</th>
                                        <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider max-w-[200px]">ລາຍລະອຽດ</th>
                                        <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider">ພາກສ່ວນ</th>
                                        <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-right">ຈຳນວນ (ກີບ)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse ($transactions as $txn)
                                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                                            <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-500 font-medium group-hover:text-emerald-700 transition-colors">
                                                {{ $txn->transaction_date?->format('d/m/Y') }}
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-[0.7rem] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 whitespace-nowrap" title="{{ $txn->category }}">
                                                    {{ $txn->category ?? '—' }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-700 max-w-[200px] truncate" title="{{ $txn->description }}">
                                                {{ $txn->description }}
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-500 truncate max-w-[120px]" title="{{ $txn->department?->displayName() }}">
                                                {{ $txn->department?->displayName() }}
                                            </td>
                                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                                <span class="font-extrabold text-[#059669] text-[0.95rem] tracking-tight">
                                                    {{ number_format($txn->amount, 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-12">
                                                <div class="flex flex-col items-center justify-center text-center">
                                                    <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 mb-4 border border-gray-100 rotate-3">
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
    </div>
</x-app-layout>

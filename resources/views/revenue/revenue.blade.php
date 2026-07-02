<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 min-w-0">
            <div class="flex flex-col gap-1.5 min-w-0">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                        ບັນທຶກລາຍຮັບ (Revenue)
                    </h2>
                </div>
                <p class="text-sm font-semibold text-gray-500 pl-10">ບ່ອນບັນທຶກລາຍຮັບ: ຄ່າລົງທະບຽນ ແລະ ຄ່າໜ່ວຍກິດ</p>
            </div>
            <a href="{{ route('revenue.dashboard') }}" 
               class="inline-flex items-center justify-center gap-2 px-4 py-2 text-xs sm:text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl transition-all duration-150 shadow-md shadow-indigo-100 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
                📊 ເບິ່ງ Dashboard ລາຍຮັບ
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-[1400px] mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6">

            @if (session('success'))
                <div class="fns-alert fns-alert-success fns-animate mb-6 shadow-sm border-l-4 border-l-indigo-500 rounded-lg">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-indigo-500 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
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


                {{-- Form Card --}}
                <div class="fns-card border-t-4 border-t-indigo-500 shadow-lg bg-white rounded-2xl overflow-hidden fns-animate">

                    <div class="fns-card-header bg-transparent border-b border-gray-100 py-5 px-6">
                        <h3 class="text-base font-extrabold text-gray-800 flex items-center gap-2">
                            <span class="w-1.5 h-5 rounded-full bg-indigo-500 block"></span>
                            ແບບຟອມບັນທຶກລາຍຮັບ
                        </h3>
                    </div>

                    <div class="p-5 sm:p-6 bg-gray-50/30">
                        <form method="POST" action="{{ route('revenue.store') }}" class="space-y-4">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                                {{-- ເລກບັນຊີ / ເລກທີ --}}
                                <div>
                                    <label for="payment_code" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ເລກທີ (ໃບບິນ) <span class="text-indigo-500">*</span></label>
                                    <input id="payment_code" name="payment_code" type="text" required
                                        class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm font-bold w-full"
                                        value="{{ old('payment_code') }}" placeholder="ເຊັ່ນ: 103906" />
                                    <x-input-error :messages="$errors->get('payment_code')" class="mt-1" />
                                </div>

                                {{-- ວັນທີ --}}
                                <div>
                                    <label for="transaction_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ວັນທີ <span class="text-indigo-500">*</span></label>
                                    <input id="transaction_date" name="transaction_date" type="date"
                                        class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                        value="{{ old('transaction_date', today()->toDateString()) }}" required />
                                    <x-input-error :messages="$errors->get('transaction_date')" class="mt-1" />
                                </div>

                                {{-- ປະເພດລາຍຮັບ --}}
                                <div class="space-y-2">
                                    <div>
                                        <label for="category" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ປະເພດລາຍຮັບ <span class="text-indigo-500">*</span></label>
                                        <select id="category" name="category" required class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                            <option value="">-- ເລືອກປະເພດລາຍຮັບ --</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                            @endforeach
                                            <option value="__custom__" {{ old('category') == '__custom__' ? 'selected' : '' }}>+ ເພີ່ມລາຍການອື່ນໆ...</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('category')" class="mt-1" />
                                    </div>
                                    <div id="custom_category_wrapper" class="{{ old('category') == '__custom__' ? '' : 'hidden' }}">
                                        <label for="custom_category" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລະບຸປະເພດລາຍຮັບອື່ນໆ <span class="text-indigo-500">*</span></label>
                                        <input id="custom_category" name="custom_category" type="text"
                                            class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full font-bold"
                                            value="{{ old('custom_category') }}" placeholder="ປ້ອນປະເພດລາຍຮັບອື່ນໆ..." />
                                        <x-input-error :messages="$errors->get('custom_category')" class="mt-1" />
                                    </div>
                                </div>

                                {{-- ພາກສ່ວນ --}}
                                <div>
                                    <label for="department_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ພາກສ່ວນ <span class="text-indigo-500">*</span></label>
                                    <select id="department_id" name="department_id" required class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                        <option value="">-- ເລືອກພາກສ່ວນ --</option>
                                        @foreach ($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->displayName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('department_id')" class="mt-1" />
                                </div>

                                {{-- ວິທີຮັບເງິນ --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">ວິທີຮັບເງິນ <span class="text-indigo-500">*</span></label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <input type="radio" name="payment_method" id="pay_cash" value="cash" required {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }} class="sr-only peer" />
                                            <label for="pay_cash" class="flex items-center justify-center gap-1 px-2 py-2 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-all text-xs font-bold text-gray-600 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 peer-checked:ring-1 peer-checked:ring-indigo-500 h-[38px] text-center">
                                                💵 ເງິນສົດ
                                            </label>
                                        </div>
                                        <div>
                                            <input type="radio" name="payment_method" id="pay_transfer" value="transfer" required {{ old('payment_method') == 'transfer' ? 'checked' : '' }} class="sr-only peer" />
                                            <label for="pay_transfer" class="flex items-center justify-center gap-1 px-2 py-2 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-all text-xs font-bold text-gray-600 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 peer-checked:ring-1 peer-checked:ring-indigo-500 h-[38px] text-center">
                                                🏦 ໂອນເຂົ້າ
                                            </label>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('payment_method')" class="mt-1" />
                                </div>

                                {{-- ຈຳນວນເງິນ --}}
                                <div>
                                    <label for="amount" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຈຳນວນເງິນ (ກີບ) <span class="text-indigo-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-bold sm:text-sm">₭</span>
                                        </div>
                                        <input id="amount" name="amount" type="number" min="1" step="0.01"
                                            class="ui-input bg-white pl-8 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all font-bold text-indigo-700 w-full"
                                            value="{{ old('amount') }}" placeholder="0.00" required />
                                    </div>
                                    <x-input-error :messages="$errors->get('amount')" class="mt-1" />
                                </div>

                                {{-- ລາຍລະອຽດ --}}
                                <div class="sm:col-span-2 lg:col-span-5">
                                    <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລາຍລະອຽດ <span class="text-gray-400 font-normal lowercase">(ບໍ່ຈຳເປັນ)</span></label>
                                    <textarea id="description" name="description" rows="2"
                                        class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full resize-none placeholder-gray-300"
                                        placeholder="ອະທິບາຍເພິ່ມເຕີມ..." maxlength="500">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end pt-2 gap-3">
                                <a href="{{ url()->previous() }}" class="ui-btn bg-gray-100 text-gray-600 hover:bg-gray-200 text-sm py-2.5 px-6 flex items-center gap-2">
                                    ← ຍົກເລີກ (Cancel)
                                </a>
                                <button type="submit" class="ui-btn bg-indigo-600 text-white hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 text-sm py-2.5 px-6 outline-none focus:ring-2 focus:ring-indigo-500 ring-offset-1 flex items-center gap-2 font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
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
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                            ທັງໝົດ {{ $transactions->total() }} ລາຍການ
                        </span>
                    </div>

                    <div class="overflow-x-auto touch-pan-x">
                        <table class="fns-table w-full text-left border-collapse" style="min-width:40rem;">
                            <thead>
                                <tr class="bg-gray-50/80 border-y border-gray-100">
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">ວັນທີ</th>
                                    <th class="py-3 px-4 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">ເລກທີ (ໃບບິນ)</th>
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
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-100 hover:border-rose-300 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    ລຶບ
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12">
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
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-rose-100 mx-auto mb-4">
                    <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
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

        function openDeleteModal(id, name) {
            document.getElementById('deleteForm').action = '/revenue/' + id;
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

        // Toggle custom category input
        document.getElementById('category').addEventListener('change', function() {
            const wrapper = document.getElementById('custom_category_wrapper');
            const customInput = document.getElementById('custom_category');
            if (this.value === '__custom__') {
                wrapper.classList.remove('hidden');
                customInput.setAttribute('required', 'required');
                customInput.focus();
            } else {
                wrapper.classList.add('hidden');
                customInput.removeAttribute('required');
                customInput.value = '';
            }
        });
    </script>
</x-app-layout>

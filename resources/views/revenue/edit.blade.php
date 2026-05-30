<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1.5 min-w-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                    ແກ້ໄຂລາຍຮັບ
                </h2>
            </div>
            <p class="text-sm font-semibold text-gray-500 pl-10">ແກ້ໄຂຂໍ້ມູນລາຍຮັບ #{{ $transaction->id }}</p>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-2xl mx-auto w-full px-3 sm:px-4 lg:px-6">

            @if ($errors->any())
                <div class="fns-alert fns-alert-error fns-animate mb-6 shadow-sm border-l-4 border-l-red-500 rounded-lg">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-red-500 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                    <ul class="list-disc list-inside text-sm font-medium">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="fns-card border-t-4 border-t-indigo-500 shadow-md bg-white relative overflow-hidden">
                <div class="absolute -top-16 -right-16 w-32 h-32 bg-indigo-100 rounded-full blur-2xl opacity-60 pointer-events-none"></div>

                <div class="fns-card-header bg-transparent relative z-10 border-b border-gray-50 py-5">
                    <h3 class="text-lg font-extrabold text-gray-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 rounded-full bg-indigo-500 block"></span>
                        ແກ້ໄຂຂໍ້ມູນລາຍຮັບ
                    </h3>
                </div>

                <div class="fns-card-body bg-gray-50/30 relative z-10 p-5 sm:p-6">
                    <form method="POST" action="{{ route('revenue.update', $transaction) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="transaction_date" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">ວັນທີ <span class="text-rose-500">*</span></label>
                                <input id="transaction_date" name="transaction_date" type="date"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 text-gray-800 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all duration-200 outline-none text-sm font-medium"
                                    value="{{ old('transaction_date', $transaction->transaction_date->toDateString()) }}" required />
                                <x-input-error :messages="$errors->get('transaction_date')" class="mt-1" />
                            </div>

                            <div class="space-y-2">
                                <div>
                                    <label for="category" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">ປະເພດລາຍຮັບ <span class="text-rose-500">*</span></label>
                                    @php
                                        $isCustom = !in_array($transaction->category, $categories);
                                    @endphp
                                    <select id="category" name="category" required class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 text-gray-800 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all duration-200 outline-none text-sm font-medium appearance-none cursor-pointer">
                                        <option value="">-- ເລືອກປະເພດ --</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat }}" {{ old('category', $isCustom ? '__custom__' : $transaction->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                        <option value="__custom__" {{ old('category', $isCustom ? '__custom__' : $transaction->category) == '__custom__' ? 'selected' : '' }}>+ ເພີ່ມລາຍການອື່ນໆ...</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('category')" class="mt-1" />
                                </div>
                                <div id="custom_category_wrapper" class="{{ old('category', $isCustom ? '__custom__' : $transaction->category) == '__custom__' ? '' : 'hidden' }}">
                                    <label for="custom_category" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">ລະບຸປະເພດລາຍຮັບອື່ນໆ <span class="text-rose-500">*</span></label>
                                    <input id="custom_category" name="custom_category" type="text"
                                        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 text-gray-800 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all duration-200 outline-none text-sm font-bold"
                                        value="{{ old('custom_category', $isCustom ? $transaction->category : '') }}" placeholder="ປ້ອນປະເພດລາຍຮັບອື່ນໆ..." />
                                    <x-input-error :messages="$errors->get('custom_category')" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="department_id" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">ພາກສ່ວນ <span class="text-rose-500">*</span></label>
                                <select id="department_id" name="department_id" required class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 text-gray-800 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all duration-200 outline-none text-sm font-medium">
                                    <option value="">-- ເລືອກພາກສ່ວນ --</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id', $transaction->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->displayName() }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('department_id')" class="mt-1" />
                            </div>

                            <div>
                                <label for="amount" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">ຈຳນວນເງິນ (ກີບ) <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-400 font-bold sm:text-sm">&#x20AD;</span>
                                    </div>
                                    <input id="amount" name="amount" type="number"
                                        class="w-full pl-9 pr-4 py-2.5 bg-gray-50/50 border border-gray-200 text-indigo-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all duration-200 outline-none font-bold text-lg"
                                        min="1" step="0.01" value="{{ old('amount', $transaction->amount) }}" placeholder="0.00" required />
                                </div>
                                <x-input-error :messages="$errors->get('amount')" class="mt-1" />
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">ລາຍລະອຽດ <span class="text-gray-400 font-normal text-[10px] normal-case tracking-normal">(ເບິ່ມເຕີມ)</span></label>
                            <textarea id="description" name="description" rows="3"
                                class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 text-gray-800 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all duration-200 outline-none text-sm font-medium resize-none placeholder-gray-400"
                                placeholder="ອະທິບາຍເພິ່ມເຕີມ (ບໍ່ຈຳເປັນ)..." maxlength="500">{{ old('description', $transaction->getRawOriginal('description')) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-1" />
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button type="submit"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-[0_4px_14px_0_rgba(99,102,241,0.39)] hover:shadow-[0_6px_20px_rgba(99,102,241,0.23)] hover:-translate-y-0.5 transition-all duration-200 outline-none flex items-center justify-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                ບັນທຶກການແກ້ໄຂ
                            </button>
                            <a href="{{ route('revenue.index') }}"
                                class="flex-1 bg-white hover:bg-gray-50 text-gray-700 font-bold py-3 px-4 rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                ຍົກເລີກ
                            </a>
                        </div>
                    </form>
                </div>
            </div>

    <script>
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

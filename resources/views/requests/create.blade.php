<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div class="min-w-0">
                    <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight truncate">
                        ສ້າງຄຳຂໍໃໝ່ (New Request)
                    </h2>
                </div>
            </div>
            <a href="{{ route('requests.index') }}" class="ui-btn ui-btn-secondary shrink-0 text-sm py-1.5 focus:ring-2 focus:ring-sky-500 ring-offset-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                ກັບຄືນ
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0 flex-1">
        <div class="max-w-4xl mx-auto w-full min-w-0 px-3 sm:px-4 space-y-6">

            {{-- Progress Steps --}}
            <div class="flex items-center justify-between bg-white border border-gray-100 p-4 sm:px-8 sm:py-5 rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.02)] fns-animate">
                <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-3 text-center sm:text-left flex-1">
                    <div class="w-8 h-8 rounded-full bg-sky-500 shadow-md shadow-sky-500/30 text-white flex items-center justify-center font-bold text-sm shrink-0">1</div>
                    <span class="font-extrabold text-sky-900 text-sm hidden sm:inline">ຕື່ມຂໍ້ມູນຄຳຂໍ</span>
                </div>
                <div class="h-1 flex-1 bg-gray-100 mx-2 sm:mx-4 rounded-full"></div>
                <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-3 text-center sm:text-left flex-1 justify-center opacity-40">
                    <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-sm shrink-0">2</div>
                    <span class="font-bold text-gray-500 text-sm hidden sm:inline">ລໍຖ້າກວດສອບ</span>
                </div>
                <div class="h-1 flex-1 bg-gray-100 mx-2 sm:mx-4 rounded-full"></div>
                <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-3 text-center sm:text-left flex-1 justify-end opacity-40">
                    <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-sm shrink-0">3</div>
                    <span class="font-bold text-gray-500 text-sm hidden sm:inline">ລໍຖ້າອະນຸມັດ</span>
                </div>
            </div>

            {{-- Main card --}}
            <div class="relative w-full rounded-2xl bg-white shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden fns-animate fns-animate-delay-1">
                
                {{-- Decorative Header background --}}
                <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r from-sky-500 to-indigo-600"></div>

                {{-- Form Content Wrapper --}}
                <div class="relative pt-6 px-6 sm:px-10 pb-10">
                    
                    {{-- Form Header --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5 flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-gray-900">ແບບຟອມຄຳຂໍງົບປະມານ</h3>
                            <p class="text-sm font-medium text-gray-500 mt-0.5">ຕື່ມຂໍ້ມູນຄຳຂໍເບີກຈ่ายລ່ວງໜ້າ ເພື່ອສົ່ງໃຫ້ການເງິນ</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('requests.store') }}">
                        @csrf
                        <div class="space-y-6">

                            {{-- Errors --}}
                            @if ($errors->any())
                                <div class="bg-red-50 border-l-4 border-l-red-500 p-4 rounded-lg shadow-sm">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-red-800">ກະລຸນາກວດສອບຂໍ້ມູນຕໍ່ໄປນີ້:</h3>
                                            <div class="mt-2 text-sm text-red-700">
                                                <ul role="list" class="list-disc pl-5 space-y-1">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="border-b border-gray-100 pb-2 mb-4">
                                <h4 class="text-xs font-extrabold text-sky-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500 block"></span>
                                    ຂໍ້ມູນພື້ນຖານ
                                </h4>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50/50 p-4 rounded-xl border border-gray-50">
                                {{-- Department --}}
                                <div>
                                    <label for="department_id" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                                        ພາກສ່ວນ <span class="text-red-500">*</span>
                                    </label>
                                    <select id="department_id" name="department_id" required class="ui-input bg-white focus:ring-sky-500 focus:border-sky-500 shadow-sm transition-all text-sm">
                                        <option value="">— ເລືອກພາກສ່ວນ —</option>
                                        @foreach ($departments as $dept)
                                            <option value="{{ $dept->id }}"
                                                {{ old('department_id', Auth::user()->department_id) == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->displayName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Date --}}
                                <div>
                                    <label for="request_date" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                                        ວັນທີ <span class="text-red-500">*</span>
                                    </label>
                                    <input id="request_date" name="request_date" type="date" class="ui-input bg-white focus:ring-sky-500 focus:border-sky-500 shadow-sm transition-all"
                                        value="{{ old('request_date', today()->toDateString()) }}" required />
                                </div>
                            </div>

                            <div class="border-b border-gray-100 pb-2 pt-4 mb-4">
                                <h4 class="text-xs font-extrabold text-sky-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500 block"></span>
                                    ລາຍລະອຽດຄຳຂໍ
                                </h4>
                            </div>

                            <div class="space-y-6">
                                {{-- Description --}}
                                <div>
                                    <label for="description" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                                        ລາຍລະອຽດຈຸດປະສົງ <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="description" name="description" rows="4" required class="ui-input bg-white focus:ring-sky-500 focus:border-sky-500 shadow-sm transition-all text-sm resize-none placeholder-gray-300"
                                        placeholder="ອະທິບາຍໃຫ້ຄົບຖ້ວນວ່າต้องการເບີກຈ່າຍเพื่อไปใช้จ่ายสิ่งใด...">{{ old('description') }}</textarea>
                                </div>

                                {{-- Amount --}}
                                <div class="bg-sky-50/40 p-5 rounded-xl border border-sky-100/50">
                                    <label for="requested_amount" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">
                                        ຈຳນວນເງິນທີ່ຂໍ (ກີບ) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-bold sm:text-lg">₭</span>
                                        </div>
                                        <input id="requested_amount" name="requested_amount" type="number"
                                            class="ui-input w-full pl-10 py-3 bg-white focus:ring-sky-500 focus:border-sky-500 shadow-sm transition-all text-lg font-extrabold text-sky-700" min="1" step="0.01"
                                            value="{{ old('requested_amount') }}" placeholder="0.00" required />
                                    </div>
                                </div>
                            </div>

                            {{-- Info note --}}
                            <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-100 flex gap-4 mt-6 items-start">
                                <svg class="w-6 h-6 text-yellow-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <div>
                                    <h5 class="text-sm font-bold text-yellow-800 mb-0.5">ໝາຍເຫດສຳຄັນ</h5>
                                    <p class="text-xs font-medium text-yellow-700/80 leading-relaxed">
                                        ຫຼັງຈາກສ້າງຄໍາຂໍແລ້ວ ລະບົບຈະສົ່ງໄປຫາຜູ້ກ່ຽວຂ້ອງເພື່ອກວດສອບ ແລະ ອະນຸມັດຕາມຂັ້ນຕອນ.<br>
                                        ກະລຸນາກວດສອບຄວາມຖືກຕ້ອງຂອງຂໍ້ມູນກ່ອນກົດ "ຢືນຢັນການສ້າງຄໍາຂໍ".
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-8 pt-6 border-t border-gray-100 flex flex-wrap items-center gap-3">
                            <button type="submit" class="ui-btn bg-gradient-to-r from-sky-500 to-indigo-600 text-white hover:from-sky-600 hover:to-indigo-700 shadow-md shadow-indigo-500/30 px-6 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500 ring-offset-2">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                                ຢືນຢັນການສ້າງຄໍາຂໍ
                            </button>
                            <a href="{{ route('requests.index') }}" class="ui-btn ui-btn-secondary px-6 py-2.5 hover:bg-gray-50">
                                ຍົກເລີກ
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

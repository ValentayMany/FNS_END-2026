<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <div class="fns-card-header-icon shrink-0" aria-hidden="true" style="background:#fff7ed; color:#ea580c;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.688-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L16.875 4.5" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 truncate">ແກ້ໄຂຄຳຂໍ</h2>
                    <p class="text-xs font-semibold text-gray-400 mt-0.5">ຄຳຂໍເລກທີ #{{ $advanceRequest->id }}</p>
                </div>
            </div>
            <a href="{{ route('requests.show', $advanceRequest) }}" class="fns-btn fns-btn-secondary shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                ກັບຄືນ
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0 flex-1">
        <div class="max-w-3xl mx-auto w-full min-w-0 px-3 sm:px-4 space-y-6">

            {{-- Main card --}}
            <div class="fns-card fns-animate">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon" style="background:#fff7ed; color:#ea580c;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ແກ້ໄຂແບບຟອມຄໍາຂໍງົບປະມານ</h3>
                            <p class="fns-card-subtitle">ແກ້ໄຂຂໍ້ມູນແລ້ວກົດ "ບັນທຶກ" ເພື່ອອັບເດດ</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('requests.update', $advanceRequest) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="fns-card-body space-y-6">

                        {{-- Errors --}}
                        @if ($errors->any())
                            <div class="fns-alert fns-alert-error mb-6">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <div>
                                    <p class="font-bold mb-1">ກະລຸນາກວດສອບຂໍ້ມູນຕໍ່ໄປນີ້:</p>
                                    <ul class="list-disc pl-5 space-y-0.5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="border-b border-gray-100 pb-2">
                            <h4 class="text-xs font-bold text-indigo-500 uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                ຂໍ້ມູນພື້ນຖານ
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            {{-- Department --}}
                            <div>
                                <label for="department_id" class="fns-label">
                                    ພາກສ່ວນ <span class="text-red-500">*</span>
                                </label>
                                <select id="department_id" name="department_id" required class="fns-select">
                                    <option value="">— ເລືອກພາກສ່ວນ —</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ old('department_id', $advanceRequest->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->displayName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Date --}}
                            <div>
                                <label for="request_date" class="fns-label">
                                    ວັນທີ <span class="text-red-500">*</span>
                                </label>
                                <input id="request_date" name="request_date" type="date" class="fns-input"
                                    value="{{ old('request_date', $advanceRequest->request_date->toDateString()) }}" required />
                            </div>
                        </div>

                        <div class="border-b border-gray-100 pb-2 pt-4">
                            <h4 class="text-xs font-bold text-indigo-500 uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                ລາຍລະອຽດຄຳຂໍ
                            </h4>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description" class="fns-label">
                                ລາຍລະອຽດ <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description" name="description" rows="4" required class="fns-textarea"
                                placeholder="ອະທິບາຍຈຸດປະສົງ ແລະ ລາຍລະອຽດຂອງການຂໍງົບ...">{{ old('description', $advanceRequest->getRawOriginal('description')) }}</textarea>
                        </div>

                        {{-- Amount --}}
                        <div>
                            <label for="requested_amount" class="fns-label">
                                ຈຳນວນເງິນທີ່ຂໍ (ກີບ)<span class="text-red-500">*</span>
                            </label>
                            <input id="requested_amount" name="requested_amount" type="number"
                                class="fns-input text-lg font-bold text-indigo-600" min="1" step="0.01"
                                value="{{ old('requested_amount', $advanceRequest->requested_amount) }}" placeholder="0" required />
                        </div>

                        {{-- Info note --}}
                        <div class="p-4 bg-amber-50 rounded-xl border border-amber-100 flex gap-3 mt-4">
                            <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.008v.008H12v-.008z" /></svg>
                            <p class="text-sm font-medium text-amber-800 leading-relaxed">
                                ທ່ານກຳລັງແກ້ໄຂຄຳຂໍທີ່ຍັງເປັນ "ຮ່າງ" — ກະລຸນາກວດຄືນແລ້ວກົດ "ບັນທຶກສະບັບແກ້ໄຂ".
                            </p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-100 bg-gray-50/50">
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <button type="submit" class="fns-btn fns-btn-primary flex-1 sm:flex-none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                ບັນທຶກສະບັບແກ້ໄຂ
                            </button>
                            <a href="{{ route('requests.show', $advanceRequest) }}" class="fns-btn fns-btn-secondary flex-1 sm:flex-none text-center justify-center">
                                ຍົກເລີກ
                            </a>
                        </div>
                </form>
                        
                        <form method="POST" action="{{ route('requests.destroy', $advanceRequest) }}"
                            onsubmit="return confirm('ທ່ານແນ່ໃຈບໍ່ວ່າຕ້ອງການລຶບຄຳຂໍນີ້?');" class="w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="fns-btn fns-btn-danger w-full sm:w-auto">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                ລຶບຄໍາຂໍ
                            </button>
                        </form>
                    </div>

            </div>
        </div>
    </div>

</x-app-layout>

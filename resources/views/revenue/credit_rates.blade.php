<x-app-layout>
    @php
        $totalCourses = $courses->count();
        $bachelorCount = $courses->filter(fn($c) => strtolower($c->LEVEL) === 'bachelor')->count();
        $postgradCount = $courses->filter(fn($c) => in_array(strtolower($c->LEVEL), ['master', 'phd']))->count();
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4 w-full">
            <div class="flex flex-col gap-0.5">
                <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest">ການຈັດການ</p>
                <h2 class="text-xl font-bold text-slate-800">ຈັດການອັດຕາໜ່ວຍກິດ</h2>
            </div>
            
            <button type="button" onclick="openCreateModal()" 
                class="inline-flex items-center gap-1 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                ເພີ່ມຫຼັກສູດໃໝ່
            </button>
        </div>
    </x-slot>

    <div class="py-6 w-full bg-slate-50/50">
        <div class="w-full px-4 space-y-6" x-data="{ activeTab: 'credits', editFeeItem: { id: null, name: '' } }">
            
            {{-- Alerts --}}
            @if (session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-bold flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-800 text-xs font-bold flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            {{-- 3 Summary Cards (Matching native theme) --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                {{-- Card 1 --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-sm hover:shadow transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-3xl font-black text-slate-800 font-mono leading-none">{{ $totalCourses }}</p>
                        <p class="text-xs font-bold text-slate-400">ຫຼັກສູດທັງໝົດ</p>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-sm hover:shadow transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.263 15.541A1 1 0 013 14.547V7.384a1 1 0 01.34-.753l7-5.999a1 1 0 011.32 0l7 5.999a1 1 0 01.34.753v7.163a1 1 0 01-1.263.953L12 14.58l-7.737.96z" />
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-3xl font-black text-slate-800 font-mono leading-none">{{ $bachelorCount }}</p>
                        <p class="text-xs font-bold text-slate-400">ລະດັບປະລິນຍາຕີ</p>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-sm hover:shadow transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-3xl font-black text-slate-800 font-mono leading-none">{{ $postgradCount }}</p>
                        <p class="text-xs font-bold text-slate-400">ປະລິນຍາໂທ - ເອກ</p>
                    </div>
                </div>
            </div>

            {{-- Tabs Navigation --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 w-full">
                <!-- Tab 1 Card -->
                <button type="button" @click="activeTab = 'credits'" 
                    :class="activeTab === 'credits' ? 'bg-gradient-to-br from-indigo-500/10 via-indigo-600/5 to-transparent border-indigo-500/80 shadow-md ring-2 ring-indigo-500/20' : 'bg-white border-slate-200/60 hover:border-indigo-200 hover:shadow-md hover:-translate-y-0.5'"
                    class="w-full text-left rounded-3xl border p-5 flex items-center gap-4 transition-all duration-300 cursor-pointer focus:outline-none focus:ring-0 group">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 transition-all duration-300 group-hover:scale-110"
                        :class="activeTab === 'credits' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'bg-indigo-50 text-indigo-600'">
                        📚
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-black transition-colors duration-300"
                            :class="activeTab === 'credits' ? 'text-indigo-950' : 'text-slate-700 group-hover:text-indigo-950'">
                            ອັດຕາໜ່ວຍກິດຫຼັກສູດ
                        </h4>
                        <p class="text-[10px] text-slate-400 font-bold leading-normal">
                            ກຳນົດຄ່າຮຽນຕໍ່ໜ່ວຍກິດ ໂດຍແຍກຕາມລະດັບ ແລະ ແຕ່ລະຫຼັກສູດ
                        </p>
                    </div>
                </button>

                <!-- Tab 2 Card -->
                <button type="button" @click="activeTab = 'fees'" 
                    :class="activeTab === 'fees' ? 'bg-gradient-to-br from-emerald-500/10 via-emerald-600/5 to-transparent border-emerald-500/80 shadow-md ring-2 ring-emerald-500/20' : 'bg-white border-slate-200/60 hover:border-emerald-200 hover:shadow-md hover:-translate-y-0.5'"
                    class="w-full text-left rounded-3xl border p-5 flex items-center gap-4 transition-all duration-300 cursor-pointer focus:outline-none focus:ring-0 group">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 transition-all duration-300 group-hover:scale-110"
                        :class="activeTab === 'fees' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'bg-emerald-50 text-emerald-600'">
                        💳
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-black transition-colors duration-300"
                            :class="activeTab === 'fees' ? 'text-slate-950' : 'text-slate-700 group-hover:text-emerald-950'">
                            ຄ່າທຳນຽມ ແລະ ຄ່າລົງທະບຽນ
                        </h4>
                        <p class="text-[10px] text-slate-400 font-bold leading-normal">
                            ກຳນົດຄ່າລົງທະບຽນ ແລະ ຄ່າບຳລຸງຫ້ອງສະໝຸດ/ຫ້ອງທົດລອງຕາມຊັ້ນປີ
                        </p>
                    </div>
                </button>
            </div>

            {{-- Tab 1: Course Credit Rates --}}
            <div x-show="activeTab === 'credits'" class="space-y-6">
                <form method="POST" action="{{ route('revenue.credit-rates.update') }}">
                    @csrf
                
                {{-- Main Table Card --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <span class="w-1 h-4 rounded bg-indigo-600"></span>
                            ອັດຕາໜ່ວຍກິດແຕ່ລະຫຼັກສູດ
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-indigo-50/40 border-b border-indigo-100/50 text-indigo-950 font-bold">
                                    <th class="py-3 px-5 w-[120px]">ລະຫັດຫຼັກສູດ</th>
                                    <th class="py-3 px-5">ຊື່ຫຼັກສູດ</th>
                                    <th class="py-3 px-5 w-[100px]">ລະດັບ</th>
                                    <th class="py-3 px-5 text-center w-[120px]">ປີ 1 (ກີບ)</th>
                                    <th class="py-3 px-5 text-center w-[120px]">ປີ 2 (ກີບ)</th>
                                    <th class="py-3 px-5 text-center w-[120px]">ປີ 3 (ກີບ)</th>
                                    <th class="py-3 px-5 text-center w-[120px]">ປີ 4 (ກີບ)</th>
                                    <th class="py-3 px-5 text-center w-[120px]">ຈັດການ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($courses as $course)
                                    @php
                                        // หาราคามาตรฐานตามระดับหลักสูตร (กรณีค่ายังว่าง)
                                        $fallbackRate = $defaultRates[strtolower($course->LEVEL)] ?? 35000;
                                    @endphp
                                    <tr class="hover:bg-indigo-50/10 transition-colors">
                                        <td class="py-3.5 px-5 font-mono font-bold">
                                            <span class="bg-indigo-50 text-indigo-700 px-2.5 py-0.5 rounded-lg border border-indigo-100/30 text-[10px] font-bold font-mono">{{ $course->COURSEID }}</span>
                                        </td>
                                        <td class="py-3.5 px-5 font-bold text-slate-800">
                                            {{ $course->COURSENAME }}
                                        </td>
                                        <td class="py-3.5 px-5">
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold 
                                                {{ strtolower($course->LEVEL) === 'master' ? 'bg-purple-50 text-purple-700 border border-purple-100/30' : 
                                                   (strtolower($course->LEVEL) === 'phd' ? 'bg-amber-50 text-amber-700 border border-amber-100/30' : 'bg-blue-50 text-blue-700 border border-blue-100/30') }}">
                                                {{ strtoupper($course->LEVEL) }}
                                            </span>
                                        </td>
                                        
                                        @for($year = 1; $year <= 4; $year++)
                                            @php
                                                $rateValue = $rates[$course->COURSEID][$year] ?? null;
                                                $displayValue = $rateValue !== null ? number_format($rateValue) : '';
                                                $placeholder = number_format($fallbackRate);
                                                // ปริญญาโท และเอก ไม่จำเป็นต้องใส่ปี 3 และ 4 (สำหรับหลักสูตร 2 ปี)
                                                $isDisabled = in_array(strtolower($course->LEVEL), ['master', 'phd']) && $year > 2;
                                            @endphp
                                            <td class="py-2 px-3 text-center">
                                                @if($isDisabled)
                                                    <span class="text-slate-300 font-bold">—</span>
                                                @else
                                                    <input 
                                                        type="text" 
                                                        name="rates[{{ $course->COURSEID }}][{{ $year }}]" 
                                                        value="{{ $displayValue }}"
                                                        placeholder="{{ $placeholder }}"
                                                        class="rate-input w-full px-2 py-1.5 text-center text-xs font-bold text-indigo-700 bg-slate-50/50 border border-slate-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-300"
                                                        autocomplete="off"
                                                        data-fallback="{{ $fallbackRate }}"
                                                    />
                                                @endif
                                            </td>
                                        @endfor
                                        
                                        {{-- Actions --}}
                                        <td class="py-3 px-5 text-center space-x-3.5 whitespace-nowrap">
                                            <button type="button" 
                                                onclick="openEditModal('{{ $course->COURSEID }}', '{{ addslashes($course->COURSENAME) }}', '{{ $course->LEVEL }}', '{{ $course->DEPTID }}')"
                                                class="inline-flex items-center justify-center text-amber-500 hover:text-amber-600 transition-colors p-1 cursor-pointer" title="ແກ້ໄຂ">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <button type="button" 
                                                onclick="confirmDelete('{{ $course->COURSEID }}')"
                                                class="inline-flex items-center justify-center text-slate-400 hover:text-rose-600 transition-colors p-1 cursor-pointer" title="ລຶບ">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-12 text-center text-slate-400 font-bold">
                                            <div class="flex flex-col items-center justify-center gap-2">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span>⚠️ ບໍ່ພົບຂໍ້ມູນຫຼັກສູດໃນລະບົບ</span>
                                                <p class="text-[10px] text-slate-400 font-medium">ກະລຸນາຄລິກປຸ່ມ "ເພີ່ມຫຼັກສູດໃໝ່" ເພື່ອເລີ່ມຕົ້ນກຳນົດຄ່າ</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($courses->isNotEmpty())
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-start gap-2">
                            <span class="text-sm">💡</span>
                            <span class="text-[11px] font-bold text-slate-400 max-w-2xl leading-relaxed">
                                ໝາຍເຫດ: ຫາກຊ່ອງໃດຫວ່າງໄວ້ ລະບົບຈະດຶງອັດຕາຕາມລະດັບການສຶກສາ (ປະລິນຍາຕີ: 35,000 / ໂທ: 240,000 / ເອກ: 600,000) ມາຄຳນວນໃຫ້ອັດຕະໂນມັດ
                            </span>
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center gap-1 px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            ບັນທຶກອັດຕາໜ່ວຍກິດ
                        </button>
                    </div>
                @endif
                </form>
            </div>

            {{-- Tab 2: Registration & Other Fees --}}
            <div x-show="activeTab === 'fees'" class="space-y-8" x-cloak>
                <form method="POST" action="{{ route('revenue.registration-fees.update') }}" class="space-y-8">
                    @csrf

                    {{-- Main Table Card --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden w-full">
                        <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                <span class="w-1 h-4 rounded bg-indigo-600"></span>
                                ກຳນົດອັດຕາຄ່າທຳນຽມ ແລະ ຄ່າລົງທະບຽນແຕ່ລະຊັ້ນປີ
                            </h3>
                            <button type="button" onclick="openCreateFeeModal()"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs shadow-sm transition-all duration-300 cursor-pointer shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                ເພີ່ມປະເພດຄ່າທຳນຽມ
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-indigo-50/40 border-b border-indigo-100/50 text-indigo-950 font-bold">
                                        <th class="py-3 px-6">ປະເພດຄ່າທຳນຽມ</th>
                                        <th class="py-3 px-5 text-center w-[200px]">ປີ 1 (ນັກສຶກສາໃໝ່) / ກີບ</th>
                                        <th class="py-3 px-5 text-center w-[200px]">ປີ 2 - 4 (ນັກສຶກສາເກົ່າ) / ກີບ</th>
                                        <th class="py-3 px-5 text-center w-[120px]">ຈັດການ</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium">
                                    @forelse($pairedRegItems as $index => $row)
                                        <tr class="hover:bg-indigo-50/10 transition-colors">
                                            <td class="py-4 px-6">
                                                <div class="flex items-center gap-3">
                                                    <span class="text-lg">💳</span>
                                                    <div class="space-y-0.5">
                                                        <p class="font-bold text-slate-800 text-xs">{{ $row['name'] }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            {{-- Year 1 amount (New Student Item) --}}
                                            <td class="py-2 px-3 text-center">
                                                @if($row['new_id'])
                                                    <input 
                                                        type="text" 
                                                        name="amounts[{{ $row['new_id'] }}]" 
                                                        value="{{ number_format($row['new_amount']) }}"
                                                        class="fee-input w-full px-3 py-2 text-center text-xs font-bold text-indigo-700 bg-slate-50/50 border border-slate-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-300"
                                                        autocomplete="off"
                                                    />
                                                @else
                                                    <span class="text-slate-300 font-bold select-none">-</span>
                                                @endif
                                            </td>

                                            {{-- Years 2-4 amount (Existing Student Item) --}}
                                            <td class="py-2 px-3 text-center">
                                                @if($row['old_id'])
                                                    <input 
                                                        type="text" 
                                                        name="amounts[{{ $row['old_id'] }}]" 
                                                        value="{{ number_format($row['old_amount']) }}"
                                                        class="fee-input w-full px-3 py-2 text-center text-xs font-bold text-emerald-700 bg-slate-50/50 border border-slate-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all placeholder:text-slate-300"
                                                        autocomplete="off"
                                                    />
                                                @else
                                                    <span class="text-slate-300 font-bold select-none">-</span>
                                                @endif
                                            </td>

                                            {{-- Actions --}}
                                            <td class="py-3 px-5 text-center whitespace-nowrap space-x-2">
                                                <button type="button" 
                                                    @click="editFeeItem = { id: {{ $row['new_id'] ?? $row['old_id'] ?? 'null' }}, name: '{{ addslashes($row['name']) }}' }; document.getElementById('edit-fee-name-input').value = '{{ addslashes($row['name']) }}'; document.getElementById('edit-fee-form').action = '/revenue/registration-fee-items/' + ({{ $row['new_id'] ?? $row['old_id'] ?? 'null' }}); document.getElementById('edit-fee-modal').classList.remove('hidden');"
                                                    class="inline-flex items-center justify-center text-indigo-500 hover:text-indigo-600 transition-colors p-1 cursor-pointer" title="ແກ້ໄຂ">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <button type="button" 
                                                    onclick="confirmDeleteFee({{ $row['new_id'] ?? $row['old_id'] ?? 'null' }})"
                                                    class="inline-flex items-center justify-center text-slate-400 hover:text-rose-600 transition-colors p-1 cursor-pointer" title="ລຶບ">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-12 text-center text-slate-400 font-bold">
                                                <div class="flex flex-col items-center justify-center gap-2">
                                                    <span class="text-2xl">⚠️</span>
                                                    <span>ບໍ່ພົບຂໍ້ມູນປະເພດຄ່າທຳນຽມໃນລະບົບ</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Submit button --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-slate-100 rounded-2xl p-5 shadow-sm w-full">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                💡
                            </div>
                            <div class="space-y-0.5">
                                <p class="text-xs font-bold text-slate-800">ໝາຍເຫດການໃຊ້ງານ</p>
                                <p class="text-[10px] text-slate-400 leading-normal max-w-2xl">
                                    ຄ່າທຳນຽມເຫຼົ່ານີ້ຈະຖືກນຳໄປໃຊ້ເປັນຄ່າເລີ່ມຕົ້ນ (Default) ໃນຕອນອອກບິນລາຍຮັບໃຫ້ນັກສຶກສາໂດຍອ້າງອີງຕາມຊັ້ນປີຮຽນ.
                                </p>
                            </div>
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs shadow-lg hover:shadow-indigo-500/20 hover:-translate-y-0.5 transition-all duration-300 cursor-pointer shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            ບັນທຶກຄ່າທຳນຽມ
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    @push('modals')

    {{-- ==================== MODAL: ເພີ່ມຫຼັກສູດ ==================== --}}
    <div id="create-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeCreateModal()"></div>
        
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all w-full max-w-lg border border-slate-100 flex flex-col">
                <form method="POST" action="{{ route('revenue.courses.store') }}">
                    @csrf
                    
                    {{-- Header --}}
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-800">ເພີ່ມຫຼັກສູດໃໝ່</h3>
                        </div>
                        <button type="button" onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Form body --}}
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5" for="COURSEID">ລະຫັດຫຼັກສູດ *</label>
                            <input id="COURSEID" name="COURSEID" type="text" required placeholder="B-CS"
                                class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all uppercase">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5" for="COURSENAME">ຊື່ຫຼັກສູດ *</label>
                            <input id="COURSENAME" name="COURSENAME" type="text" required placeholder="ວິທະຍາສາດຄອມພິວເຕີ"
                                class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="LEVEL">ລະດັບ *</label>
                                <select id="LEVEL" name="LEVEL" required
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                                    <option value="bachelor">Bachelor (ຕີ)</option>
                                    <option value="master">Master (ໂທ)</option>
                                    <option value="phd">PhD (ເອກ)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="DEPTID">ພາກວິຊາ *</label>
                                <select id="DEPTID" name="DEPTID" required
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="p-5 border-t border-slate-50 bg-slate-50/50 flex justify-end gap-2 shrink-0">
                        <button type="button" onclick="closeCreateModal()"
                            class="rounded-xl bg-white border border-slate-200 text-slate-500 transition-all hover:bg-slate-50 inline-flex items-center justify-center font-bold text-xs px-6 py-2 cursor-pointer"
                            style="height: 38px;">
                            ຍົກເລີກ
                        </button>
                        <button type="submit"
                            class="rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white transition-all shadow-md shadow-indigo-100 hover:shadow-lg inline-flex items-center justify-center font-bold text-xs px-6 py-2 cursor-pointer"
                            style="height: 38px;">
                            ບັນທຶກ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ==================== MODAL: ແກ້ໄຂຫຼັກສູດ ==================== --}}
    <div id="edit-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
        
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all w-full max-w-lg border border-slate-100 flex flex-col">
                <form id="edit-form" method="POST" action="">
                    @csrf
                    @method('PUT')
                    
                    {{-- Header --}}
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-800">ແກ້ໄຂຂໍ້ມູນຫຼັກສູດ</h3>
                        </div>
                        <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Form body --}}
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 mb-1.5">ລະຫັດຫຼັກສູດ (ແກ້ໄຂບໍ່ໄດ້)</label>
                            <input type="text" id="edit_COURSEID_display" disabled
                                class="w-full rounded-xl border border-slate-100 px-3.5 py-2.5 text-sm font-bold bg-slate-50 text-slate-400 select-none cursor-not-allowed font-mono">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_COURSENAME">ຊື່ຫຼັກສູດ *</label>
                            <input id="edit_COURSENAME" name="COURSENAME" type="text" required
                                class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_LEVEL">ລະດັບ *</label>
                                <select id="edit_LEVEL" name="LEVEL" required
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                                    <option value="bachelor">Bachelor (ຕີ)</option>
                                    <option value="master">Master (ໂທ)</option>
                                    <option value="phd">PhD (ເອກ)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_DEPTID">ພាកວິຊາ *</label>
                                <select id="edit_DEPTID" name="DEPTID" required
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="p-5 border-t border-slate-50 bg-slate-50/50 flex justify-end gap-2 shrink-0">
                        <button type="button" onclick="closeEditModal()"
                            class="rounded-xl bg-white border border-slate-200 text-slate-500 transition-all hover:bg-slate-50 inline-flex items-center justify-center font-bold text-xs px-6 py-2 cursor-pointer"
                            style="height: 38px;">
                            ຍົກເລີກ
                        </button>
                        <button type="submit"
                            class="rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white transition-all shadow-md shadow-indigo-100 hover:shadow-lg inline-flex items-center justify-center font-bold text-xs px-6 py-2 cursor-pointer"
                            style="height: 38px;">
                            ອັບເດດ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Form ສໍາລັບລົບ --}}
    <form id="delete-form" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    {{-- Form ສໍາລັບລົບປະເພດຄ່າທຳນຽມ --}}
    <form id="delete-fee-form" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    {{-- ==================== MODAL: ເພີ່ມປະເພດຄ່າທຳນຽມ ==================== --}}
    <div id="create-fee-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeCreateFeeModal()"></div>
        
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all w-full max-w-lg border border-slate-100 flex flex-col">
                <form method="POST" action="{{ route('revenue.registration-fee-items.store') }}">
                    @csrf
                    
                    {{-- Header --}}
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                💳
                            </div>
                            <h3 class="text-base font-extrabold text-slate-800">ເພີ່ມປະເພດຄ່າທຳນຽມໃໝ່</h3>
                        </div>
                        <button type="button" onclick="closeCreateFeeModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    {{-- Body --}}
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-2">ຊື່ປະເພດຄ່າທຳນຽມ</label>
                            <input type="text" name="name" required placeholder="ຕົວຢ່າງ: ຄ່າກິລາ, ຄ່າບັດປະຈຳຕົວ..."
                                class="w-full px-4 py-2.5 text-xs font-semibold border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-400" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-2">ອັດຕາ ປີ 1 (ກີບ)</label>
                                <input type="text" name="new_amount" required placeholder="0"
                                    class="fee-input w-full px-4 py-2.5 text-xs font-bold border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-400" />
                            </div>
                            <div>
                                <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-2">ອັດຕາ ປີ 2-4 (ກີບ)</label>
                                <input type="text" name="old_amount" required placeholder="0"
                                    class="fee-input w-full px-4 py-2.5 text-xs font-bold border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-400" />
                            </div>
                        </div>
                    </div>
                    
                    {{-- Footer --}}
                    <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-end gap-3 rounded-b-3xl">
                        <button type="button" onclick="closeCreateFeeModal()"
                            class="rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-750 font-bold text-xs px-5 py-2.5 transition-all cursor-pointer">
                            ຍົກເລີກ
                        </button>
                        <button type="submit"
                            class="rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-5 py-2.5 shadow-md hover:shadow-lg transition-all cursor-pointer">
                            ເພີ່ມລາຍການ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ==================== MODAL: ແກ้ໄຂປະເພດຄ່າທຳນຽມ ==================== --}}
    <div id="edit-fee-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeEditFeeModal()"></div>
        
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all w-full max-w-lg border border-slate-100 flex flex-col">
                <form id="edit-fee-form" method="POST" action="">
                    @csrf
                    @method('PUT')
                    
                    {{-- Header --}}
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                ⚙️
                            </div>
                            <h3 class="text-base font-extrabold text-slate-800">ແກ້ໄຂປະເພດຄ່າທຳນຽມ</h3>
                        </div>
                        <button type="button" onclick="closeEditFeeModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    {{-- Body --}}
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-2">ຊື່ປະເພດຄ່າທຳນຽມ</label>
                            <input type="text" id="edit-fee-name-input" name="name" required
                                class="w-full px-4 py-2.5 text-xs font-semibold border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-400" />
                        </div>
                    </div>
                    
                    {{-- Footer --}}
                    <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-end gap-3 rounded-b-3xl">
                        <button type="button" onclick="closeEditFeeModal()"
                            class="rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-750 font-bold text-xs px-5 py-2.5 transition-all cursor-pointer">
                            ຍົກເລີກ
                        </button>
                        <button type="submit"
                            class="rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-5 py-2.5 shadow-md hover:shadow-lg transition-all cursor-pointer">
                            ບັນທຶກການແກ້ໄຂ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal Handlers
        function openCreateFeeModal() {
            document.getElementById('create-fee-modal').classList.remove('hidden');
        }
        function closeCreateFeeModal() {
            document.getElementById('create-fee-modal').classList.add('hidden');
        }
        function closeEditFeeModal() {
            document.getElementById('edit-fee-modal').classList.add('hidden');
        }
        function confirmDeleteFee(id) {
            if (confirm('ທ່ານແນ່ໃຈບໍ່ວ່າຕ້ອງການລົບປະເພດຄ່າທຳນຽມນີ້? (ຂໍ້ມູນອັດຕາທັງໝົດໃນລະບົບຈະຖືກລົບໄປພ້ອມກັນ)')) {
                const form = document.getElementById('delete-fee-form');
                form.action = `/revenue/registration-fee-items/${id}`;
                form.submit();
            }
        }

        function openCreateModal() {
            document.getElementById('create-modal').classList.remove('hidden');
        }
        function closeCreateModal() {
            document.getElementById('create-modal').classList.add('hidden');
        }

        function openEditModal(id, name, level, deptId) {
            const form = document.getElementById('edit-form');
            form.action = `/revenue/courses/${id}`;

            document.getElementById('edit_COURSEID_display').value = id;
            document.getElementById('edit_COURSENAME').value = name;
            document.getElementById('edit_LEVEL').value = level;
            document.getElementById('edit_DEPTID').value = deptId;

            document.getElementById('edit-modal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        function confirmDelete(id) {
            if (confirm('ທ່ານແນ່ໃຈບໍ່ວ່າຕ້ອງການລົບຫຼັກສູດນີ້? (ອັດຕาໜ່ວຍກິດທີ່ກ່ຽວຂ້ອງຈະຖືກລົບໄປພ້ອມກັນ)')) {
                const form = document.getElementById('delete-form');
                form.action = `/revenue/courses/${id}`;
                form.submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const inputs = document.querySelectorAll('.rate-input, .fee-input');

            // จัดรูปแบบตัวเลขตอนป้อนข้อมูล (ใส่ลูกน้ำอัตโนมัติ)
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const raw = this.value.replace(/[^0-9]/g, '');
                    this.value = raw ? parseInt(raw).toLocaleString() : '';
                });

                // ตอนออกจากกล่องข้อความ ถ้ากรอกไว้ให้ลบอักษรที่ไม่ใช่ตัวเลข
                input.addEventListener('blur', function() {
                    if (this.value) {
                        const raw = this.value.replace(/[^0-9]/g, '');
                        this.value = raw ? parseInt(raw).toLocaleString() : '';
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 w-full">
            <div class="flex flex-col gap-0.5">
                <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest">ການຈັດການ</p>
                <h2 class="text-xl font-bold text-slate-800">ຈັດການຂໍ້ມູນນັກສຶກສາ</h2>
            </div>
            
            <div class="flex items-center gap-2 shrink-0">
                {{-- Import Button --}}
                <button type="button" onclick="openImportModal()" 
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-sm shadow-sm hover:bg-slate-50 transition-all duration-300 cursor-pointer">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    ນຳເຂົ້າ Excel
                </button>
                
                {{-- Add Button --}}
                <button type="button" onclick="openCreateModal()" 
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    ເພີ່ມນັກສຶກສາໃໝ່
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6 w-full bg-slate-50/50">
        <div class="w-full px-4 space-y-6">
            
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

            {{-- 3 Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                {{-- Total --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-sm hover:shadow transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-3xl font-black text-slate-800 font-mono leading-none">{{ number_format($totalStudents) }}</p>
                        <p class="text-xs font-bold text-slate-400">ນັກສຶກສາທັງໝົດ</p>
                    </div>
                </div>

                {{-- Active --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-sm hover:shadow transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-3xl font-black text-slate-800 font-mono leading-none">{{ number_format($activeStudents) }}</p>
                        <p class="text-xs font-bold text-slate-400">ກຳລັງສຶກສາ (Active)</p>
                    </div>
                </div>

                {{-- Inactive --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-sm hover:shadow transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-3xl font-black text-slate-800 font-mono leading-none">{{ number_format($inactiveStudents) }}</p>
                        <p class="text-xs font-bold text-slate-400">ພັກຮຽນ / ຈົບແລ້ວ (Inactive)</p>
                    </div>
                </div>
            </div>

            {{-- Filter and Table Section --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                {{-- Filters Card header --}}
                <div class="p-5 border-b border-slate-100 bg-slate-50/20">
                    <form method="GET" action="{{ route('revenue.students.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4" id="filter-form">
                        {{-- Search Input --}}
                        <div class="col-span-1 md:col-span-2 relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search }}" 
                                placeholder="ຄົ້ນຫາ ລະຫັດ ຫຼື ຊື່ນັກສຶກສາ..." 
                                class="w-full pl-10 pr-4 py-2 text-sm font-semibold border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-400"
                            />
                        </div>

                        {{-- Course Select --}}
                        <div>
                            <select name="course" onchange="document.getElementById('filter-form').submit()"
                                class="w-full px-3.5 py-2 text-sm font-semibold border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all cursor-pointer">
                                <option value="">--- ທຸກຫຼັກສູດ ---</option>
                                @foreach($courses as $c)
                                    <option value="{{ $c->COURSEID }}" {{ $courseFilter === $c->COURSEID ? 'selected' : '' }}>
                                        {{ $c->COURSEID }} - {{ $c->COURSENAME }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Year Select --}}
                        <div>
                            <select name="year" onchange="document.getElementById('filter-form').submit()"
                                class="w-full px-3.5 py-2 text-sm font-semibold border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all cursor-pointer">
                                <option value="">--- ທຸກປີຮຽນ ---</option>
                                <option value="1" {{ $yearFilter == '1' ? 'selected' : '' }}>ປີ 1</option>
                                <option value="2" {{ $yearFilter == '2' ? 'selected' : '' }}>ປີ 2</option>
                                <option value="3" {{ $yearFilter == '3' ? 'selected' : '' }}>ປີ 3</option>
                                <option value="4" {{ $yearFilter == '4' ? 'selected' : '' }}>ປີ 4</option>
                            </select>
                        </div>
                    </form>
                </div>

                {{-- Table list --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-indigo-50/40 border-b border-indigo-100/50 text-indigo-950 font-bold">
                                <th class="py-3 px-5 w-[140px]">ລະຫັດນັກສຶກສາ</th>
                                <th class="py-3 px-5">ຊື່ ແລະ ນາມສະກຸນ</th>
                                <th class="py-3 px-5 w-[80px] text-center">ເພດ</th>
                                <th class="py-3 px-5 w-[120px]">ຫຼັກສູດ</th>
                                <th class="py-3 px-5 w-[100px] text-center">ປີຮຽນ</th>
                                <th class="py-3 px-5">ເບີໂທ / ອີເມວ</th>
                                <th class="py-3 px-5 w-[110px] text-center">ສະຖານະ</th>
                                <th class="py-3 px-5 w-[110px] text-center">ຈັດການ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($students as $student)
                                <tr class="hover:bg-indigo-50/10 transition-colors">
                                    <td class="py-3 px-5 font-mono font-bold">
                                        <span class="bg-indigo-50 text-indigo-700 px-2.5 py-0.5 rounded-lg border border-indigo-100/30 text-[10px] font-bold font-mono">{{ $student->STDID }}</span>
                                    </td>
                                    <td class="py-3 px-5 font-bold text-slate-800">
                                        {{ $student->TITLE }} {{ $student->full_name }}
                                    </td>
                                    <td class="py-3 px-5 text-center font-bold">
                                        @if($student->gender === 'F')
                                            <span class="text-pink-600 bg-pink-50 px-2 py-0.5 rounded-full text-[10px]">ຍິງ</span>
                                        @else
                                            <span class="text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full text-[10px]">ຊາຍ</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-5 font-semibold text-slate-600">
                                        {{ $student->COURSEID }}
                                    </td>
                                    <td class="py-3 px-5 text-center font-bold text-indigo-700">
                                        ປີ {{ $student->study_year }}
                                    </td>
                                    <td class="py-3 px-5 text-slate-500 font-medium">
                                        <div>{{ $student->PHONE ?: '—' }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">{{ $student->EMAIL }}</div>
                                    </td>
                                    <td class="py-3 px-5 text-center">
                                        <form method="POST" action="{{ route('revenue.students.toggle-status', $student->id) }}" id="status-form-{{ $student->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center cursor-pointer">
                                                @if($student->is_active)
                                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/30">Active</span>
                                                @else
                                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-50 text-slate-400 border border-slate-100/30">Inactive</span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    
                                    {{-- Actions --}}
                                    <td class="py-3 px-5 text-center space-x-3 whitespace-nowrap">
                                        <button type="button" 
                                            onclick="openEditModal('{{ $student->id }}', '{{ $student->STDID }}', '{{ $student->TITLE }}', '{{ addslashes($student->FRTNAME) }}', '{{ addslashes($student->LSTNAME) }}', '{{ $student->gender }}', '{{ $student->COURSEID }}', '{{ $student->study_year }}', '{{ $student->EMAIL }}', '{{ $student->PHONE }}')"
                                            class="inline-flex items-center justify-center text-amber-500 hover:text-amber-600 transition-colors p-1 cursor-pointer" title="ແກ້ໄຂ">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                        <button type="button" 
                                            onclick="confirmDelete('{{ $student->id }}')"
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
                                            <span>⚠️ ບໍ່ພົບຂໍ້ມູນນັກສຶກສາ</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                @if($students->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/10">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    @push('modals')
    {{-- ==================== MODAL: ເພີ່ມນັກສຶກສາ ==================== --}}
    <div id="create-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeCreateModal()"></div>
        
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all w-full max-w-lg border border-slate-100 flex flex-col">
                <form method="POST" action="{{ route('revenue.students.store') }}">
                    @csrf
                    
                    {{-- Header --}}
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-800">ເພີ່ມຂໍ້ມູນນັກສຶກສາໃໝ່</h3>
                        </div>
                        <button type="button" onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Form body --}}
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-1">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="TITLE">ຄຳນຳໜ້າ</label>
                                <input id="TITLE" name="TITLE" type="text" placeholder="ທ້າວ / ນາງ"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="STDID">ລະຫັດນັກສຶກສາ *</label>
                                <input id="STDID" name="STDID" type="text" required placeholder="FNS-001"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all uppercase">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="FRTNAME">ຊື່ *</label>
                                <input id="FRTNAME" name="FRTNAME" type="text" required placeholder="ສົມບັດ"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="LSTNAME">ນາມສະກຸນ</label>
                                <input id="LSTNAME" name="LSTNAME" type="text" placeholder="ມີໄຊ"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="gender">ເພດ *</label>
                                <select id="gender" name="gender" required
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                                    <option value="M">ຊາຍ (M)</option>
                                    <option value="F">ຍິງ (F)</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="COURSEID">ຫຼັກສູດ *</label>
                                <select id="COURSEID" name="COURSEID" required
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                                    @foreach($courses as $c)
                                        <option value="{{ $c->COURSEID }}">{{ $c->COURSEID }} - {{ $c->COURSENAME }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="study_year">ປີຮຽນ *</label>
                                <select id="study_year" name="study_year" required
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                                    <option value="1">ປີ 1</option>
                                    <option value="2">ປີ 2</option>
                                    <option value="3">ປີ 3</option>
                                    <option value="4">ປີ 4</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="PHONE">ເບີໂທລະສັບ</label>
                                <input id="PHONE" name="PHONE" type="text" placeholder="020 99998888"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5" for="EMAIL">ອີເມວ</label>
                            <input id="EMAIL" name="EMAIL" type="email" placeholder="student@nuol.edu.la"
                                class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
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

    {{-- ==================== MODAL: ແກ້ໄຂນັກສຶກສາ ==================== --}}
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
                            <h3 class="text-base font-extrabold text-slate-800">ແກ້ໄຂຂໍ້ມູນນັກສຶກສາ</h3>
                        </div>
                        <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Form body --}}
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-1">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_TITLE">ຄຳນຳໜ້າ</label>
                                <input id="edit_TITLE" name="TITLE" type="text" placeholder="ທ້າວ / ນາງ"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_STDID">ລະຫັດນັກສຶກສາ *</label>
                                <input id="edit_STDID" name="STDID" type="text" required placeholder="FNS-001"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all uppercase">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_FRTNAME">ຊື່ *</label>
                                <input id="edit_FRTNAME" name="FRTNAME" type="text" required placeholder="ສົມບັດ"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_LSTNAME">ນາມສະກຸນ</label>
                                <input id="edit_LSTNAME" name="LSTNAME" type="text" placeholder="ມີໄຊ"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_gender">ເພດ *</label>
                                <select id="edit_gender" name="gender" required
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                                    <option value="M">ຊາຍ (M)</option>
                                    <option value="F">ຍິງ (F)</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_COURSEID">ຫຼັກສູດ *</label>
                                <select id="edit_COURSEID" name="COURSEID" required
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                                    @foreach($courses as $c)
                                        <option value="{{ $c->COURSEID }}">{{ $c->COURSEID }} - {{ $c->COURSENAME }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_study_year">ປີຮຽນ *</label>
                                <select id="edit_study_year" name="study_year" required
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                                    <option value="1">ປີ 1</option>
                                    <option value="2">ປີ 2</option>
                                    <option value="3">ປີ 3</option>
                                    <option value="4">ປີ 4</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_PHONE">ເບີໂທລະສັບ</label>
                                <input id="edit_PHONE" name="PHONE" type="text" placeholder="020 99998888"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_EMAIL">ອີເມວ</label>
                            <input id="edit_EMAIL" name="EMAIL" type="email" placeholder="student@nuol.edu.la"
                                class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
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

    {{-- ==================== MODAL: ນຳເຂົ້າ EXCEL ==================== --}}
    <div id="import-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeImportModal()"></div>
        
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all w-full max-w-md border border-slate-100 flex flex-col">
                <form method="POST" action="{{ route('revenue.students.import') }}" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- Header --}}
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-800">ນຳເຂົ້າຂໍ້ມູນ Excel / CSV</h3>
                        </div>
                        <button type="button" onclick="closeImportModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Form body --}}
                    <div class="p-6 space-y-4">
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-2 text-[11px] text-slate-500 font-medium">
                            <div class="flex items-center justify-between border-b border-slate-200/60 pb-2 mb-2">
                                <span class="font-bold text-slate-700 text-xs">💡 ຂໍ້ແນະນຳໃນການນຳເຂົ້າ:</span>
                                <a href="{{ route('revenue.students.download-template') }}" 
                                    class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors flex items-center gap-1 underline">
                                    📥 ດາວໂຫລດ Template
                                </a>
                            </div>
                            <p>• ໄຟລ໌ຕ້ອງມີຫົວຂໍ້ຖັນໃນແຖວທຳອິດ (Row 1)</p>
                            <p>• ຖັນທີ່ຈຳເປັນ: <strong class="text-slate-700">"ລະຫັດນັກສຶກສາ" (Student ID)</strong> ແລະ <strong class="text-slate-700">"ຊື່" (First Name)</strong></p>
                            <p>• ຖັນອື່ນໆ (ຖ້າມີ): "ຄຳນຳໜ້າ" (Title), "ນາມສະກຸນ" (Last Name), "ເພດ" (Gender: ຊາຍ/ຍິງ), "ຫຼັກສູດ" (Course Code), "ປີຮຽນ" (Study Year: 1-4), "ອີເມວ" (Email), "ເບີໂທ" (Phone)</p>
                            <p>• ຫາກມີລະຫັດນັກສຶກສາຢູ່ແລ້ວ ລະບົບຈະອັບເດດຂໍ້ມູນເກົ່າໃຫ້ໂດຍອັດຕະໂນມັດ</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5" for="import_file">ເລືອກໄຟລ໌ Excel / CSV *</label>
                            <input id="import_file" name="file" type="file" required accept=".xlsx,.xls,.csv"
                                class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:outline-none focus:border-indigo-500 transition-all cursor-pointer">
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="p-5 border-t border-slate-50 bg-slate-50/50 flex justify-end gap-2 shrink-0">
                        <button type="button" onclick="closeImportModal()"
                            class="rounded-xl bg-white border border-slate-200 text-slate-500 transition-all hover:bg-slate-50 inline-flex items-center justify-center font-bold text-xs px-6 py-2 cursor-pointer"
                            style="height: 38px;">
                            ຍົກເລີກ
                        </button>
                        <button type="submit"
                            class="rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white transition-all shadow-md shadow-indigo-100 hover:shadow-lg inline-flex items-center justify-center font-bold text-xs px-6 py-2 cursor-pointer"
                            style="height: 38px;">
                            ນຳເຂົ້າຂໍ້ມູນ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete form --}}
    <form id="delete-form" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>
    @endpush

    <script>
        // Create Modal
        function openCreateModal() {
            document.getElementById('create-modal').classList.remove('hidden');
        }
        defineOpenCreate = openCreateModal; // global alias if needed
        function closeCreateModal() {
            document.getElementById('create-modal').classList.add('hidden');
        }

        // Edit Modal
        function openEditModal(id, stdid, title, frtname, lstname, gender, courseid, study_year, email, phone) {
            const form = document.getElementById('edit-form');
            form.action = `/revenue/students/${id}`;

            document.getElementById('edit_STDID').value = stdid;
            document.getElementById('edit_TITLE').value = title;
            document.getElementById('edit_FRTNAME').value = frtname;
            document.getElementById('edit_LSTNAME').value = lstname;
            document.getElementById('edit_gender').value = gender;
            document.getElementById('edit_COURSEID').value = courseid;
            document.getElementById('edit_study_year').value = study_year;
            document.getElementById('edit_EMAIL').value = email;
            document.getElementById('edit_PHONE').value = phone;

            document.getElementById('edit-modal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        // Import Modal
        function openImportModal() {
            document.getElementById('import-modal').classList.remove('hidden');
        }
        function closeImportModal() {
            document.getElementById('import-modal').classList.add('hidden');
        }

        // Confirm Delete
        function confirmDelete(id) {
            if (confirm('ທ່ານແນ່ໃຈບໍ່ວ່າຕ້ອງການລົບຂໍ້ມູນນັກສຶກສາຄົນນີ້?')) {
                const form = document.getElementById('delete-form');
                form.action = `/revenue/students/${id}`;
                form.submit();
            }
        }
    </script>
</x-app-layout>

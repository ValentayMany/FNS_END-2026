<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4 w-full">
            <div class="flex flex-col gap-0.5">
                <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest">ການຈັດການ</p>
                <h2 class="text-xl font-bold text-slate-800">ຈັດການຂໍ້ມູນພາກ/ສ່ວນ ແລະ ງົບປະມານ</h2>
            </div>

            {{-- Add button matching the top right "+ ເພີ່ມຂາອອກ" button style --}}
            <button type="button" onclick="openAddModal()"
                class="inline-flex items-center gap-1 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                ເພີ່ມພາກ/ສ່ວນ
            </button>
        </div>
    </x-slot>

    <div class="py-6 w-full bg-slate-50/50">
        <div class="w-full px-4 space-y-6">

            {{-- Flash Alert Messages --}}
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-bold flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4" />
                    </svg>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-800 text-xs font-bold flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01" />
                    </svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            {{-- ── 4 Summary Cards (Matching example layout) ── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Card 1: Total Departments --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-sm hover:shadow transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-3xl font-black text-slate-800 font-mono leading-none">{{ $departments->count() }}</p>
                        <p class="text-xs font-bold text-slate-400">ພາກ/ສ່ວນທັງໝົດ</p>
                    </div>
                </div>

                {{-- Card 2: Total Budget --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-sm hover:shadow transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-2xl font-black text-slate-800 font-mono leading-none">
                            {{ number_format($departments->sum('_initial'), 0) }}
                        </p>
                        <p class="text-xs font-bold text-slate-400">ງົບປະມານຕັ້ງຕົ້ນທັງໝົດ</p>
                    </div>
                </div>

                {{-- Card 3: Spent Budget --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-sm hover:shadow transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-2xl font-black text-slate-800 font-mono leading-none">
                            {{ number_format($departments->sum('_spent'), 0) }}
                        </p>
                        <p class="text-xs font-bold text-slate-400">ງົບປະມານທີ່ໃຊ້ໄປແລ້ວ</p>
                    </div>
                </div>

                {{-- Card 4: Remaining Budget --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-sm hover:shadow transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        @php
                            $totalRemaining = $departments->sum('_initial') - $departments->sum('_spent');
                        @endphp
                        <p class="text-2xl font-black font-mono leading-none {{ $totalRemaining < 0 ? 'text-rose-600' : 'text-slate-800' }}">
                            {{ number_format($totalRemaining, 0) }}
                        </p>
                        <p class="text-xs font-bold text-slate-400">ງົບປະມານຄົງເຫຼືອທັງໝົດ</p>
                    </div>
                </div>

            </div>

            {{-- ── Main Table Card (Full Width) ── --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-1 h-4 rounded bg-indigo-600"></span>
                        ລາຍລະອຽດງົບປະມານແຕ່ລະພາກ/ສ່ວນ
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-indigo-50/40 border-b border-indigo-100/50 text-indigo-950 font-bold">
                                <th class="py-3 px-5 w-[100px]">ລະຫັດ</th>
                                <th class="py-3 px-5">ຊື່ພາກ/ສ່ວນ</th>
                                <th class="py-3 px-5">ປະເພດ</th>
                                <th class="py-3 px-5 text-right w-[150px]">ງົບຕັ້ງຕົ້ນ</th>
                                <th class="py-3 px-5 text-right w-[150px]">ໃຊ້ໄປແລ້ວ</th>
                                <th class="py-3 px-5 text-right w-[150px]">ງົບຄົງເຫຼືອ</th>
                                <th class="py-3 px-5 text-center w-[120px]">ຈັດການ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($departments as $dept)
                                <tr class="hover:bg-indigo-50/10 transition-colors">
                                    <td class="py-3.5 px-5 font-mono font-bold">
                                        @if($dept->dept_code)
                                            <span class="bg-indigo-50 text-indigo-700 px-2.5 py-0.5 rounded-lg border border-indigo-100/30 text-[10px] font-bold font-mono">{{ $dept->dept_code }}</span>
                                        @else
                                            <span class="text-slate-300">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-5 font-bold text-slate-800">
                                        {{ $dept->displayName() }}
                                    </td>
                                    <td class="py-3.5 px-5">
                                        @if($dept->department_type)
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $dept->department_type === 'income' ? 'bg-amber-50 text-amber-700 border border-amber-100/50' : 'bg-indigo-50 text-indigo-700 border border-indigo-100/30' }}">
                                                {{ $dept->department_type }}
                                            </span>
                                        @else
                                            <span class="text-slate-300">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-5 text-right font-mono font-bold text-slate-700">
                                        {{ number_format($dept->_initial, 2) }}
                                    </td>
                                    <td class="py-3.5 px-5 text-right font-mono font-bold text-rose-600">
                                        {{ number_format($dept->_spent, 2) }}
                                    </td>
                                    <td class="py-3.5 px-5 text-right font-mono font-extrabold {{ $dept->budget_amount < 0 ? 'text-red-600' : 'text-emerald-700' }}">
                                        {{ number_format($dept->budget_amount, 2) }}
                                        @if($dept->budget_amount < 0)
                                            <span class="text-[9px] font-bold bg-red-50 text-red-600 px-1 py-0.5 rounded ml-1 block md:inline-block">ເກີນງົບ!</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-5 text-center space-x-3.5 whitespace-nowrap">
                                        {{-- Edit pencil icon matching example screen --}}
                                        <button type="button" onclick="openEditModal({{ $dept->id }})"
                                            class="inline-flex items-center justify-center text-amber-500 hover:text-amber-600 transition-colors p-1" title="ແກ້ໄຂ">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                        {{-- Delete trash icon matching example screen --}}
                                        <form method="POST" action="{{ route('department-setup.destroy', $dept) }}" class="inline-block"
                                            onsubmit="return confirm('ລຶບພາກສ່ວນ {{ addslashes($dept->displayName()) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center text-slate-400 hover:text-rose-600 transition-colors p-1" title="ລຶບ">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-10 text-center text-slate-400 font-bold">
                                        ຍັງບໍ່ມີຂໍ້ມູນພາກ/ສ່ວນ
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('modals')
    {{-- ──────────────────────────────────────────────
         ADD MODAL (Matching Example Modal Layout)
    ────────────────────────────────────────────────── --}}
    <div id="add-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeAddModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all w-full max-w-lg border border-slate-100 flex flex-col">

                {{-- Header --}}
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-800">ເພີ່ມພາກ/ສ່ວນໃໝ່</h3>
                    </div>
                    <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('department-setup.store') }}">
                    @csrf

                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-1">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="add_dept_code">ລະຫັດ</label>
                                <input id="add_dept_code" name="dept_code" type="text" maxlength="20" placeholder="01"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-mono">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="add_department_name">ຊື່ພາກ/ສ່ວນ *</label>
                                <input id="add_department_name" name="department_name" type="text" required placeholder="ພາກເຄມີ, ສ່ວນກາງ..."
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5" for="add_department_type">ປະເພດ</label>
                            <input id="add_department_type" name="department_type" type="text" placeholder="Faculty, Section, Major..."
                                class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5" for="add_budget_amount">ງົບປະມານ (ກີບ)</label>
                            <div style="position: relative; display: block;">
                                <input id="add_budget_amount" name="budget_amount" type="text" placeholder="0.00"
                                    class="w-full rounded-xl border border-slate-200 pl-4 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-mono text-right budget-input-format"
                                    style="padding-right: 48px;">
                                <div style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); pointer-events: none; display: flex; align-items: center;">
                                    <span style="font-size: 11px; font-weight: 700; color: #94a3b8;">ກີບ</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="p-5 border-t border-slate-50 bg-slate-50/50 flex justify-end gap-2 shrink-0">
                        <button type="button" onclick="closeAddModal()"
                            class="rounded-xl bg-white border border-slate-200 text-slate-500 transition-all hover:bg-slate-50 inline-flex items-center justify-center"
                            style="padding: 8px 24px; font-size: 13px; font-weight: 700; min-width: 90px; height: 38px;">
                            ຍົກເລີກ
                        </button>
                        <button type="submit"
                            class="rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white transition-all shadow-md shadow-indigo-100 hover:shadow-lg inline-flex items-center justify-center"
                            style="padding: 8px 24px; font-size: 13px; font-weight: 700; min-width: 90px; height: 38px;">
                            ບັນທຶກ
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- ──────────────────────────────────────────────
         EDIT MODAL (Matching Example Modal Layout)
    ────────────────────────────────────────────────── --}}
    <div id="edit-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all w-full max-w-lg border border-slate-100 flex flex-col">

                {{-- Header --}}
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-800">ແກ້ໄຂຂໍ້ມູນພາກ/ສ່ວນ</h3>
                    </div>
                    <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Form --}}
                <form id="edit-form-action" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-1">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_dept_code">ລະຫັດ</label>
                                <input id="edit_dept_code" name="dept_code" type="text" maxlength="20" placeholder="01"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-mono">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_department_name">ຊື່ພາກ/ສ່ວນ *</label>
                                <input id="edit_department_name" name="department_name" type="text" required placeholder="ຊື່ພາກສ່ວນ..."
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_department_type">ປະເພດ</label>
                            <input id="edit_department_type" name="department_type" type="text" placeholder="Faculty, Section, Major..."
                                class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5" for="edit_budget_amount">ງົບປະມານ (ກີບ)</label>
                            <div style="position: relative; display: block;">
                                <input id="edit_budget_amount" name="budget_amount" type="text" placeholder="0.00"
                                    class="w-full rounded-xl border border-slate-200 pl-4 py-2.5 text-sm font-semibold bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-mono text-right budget-input-format"
                                    style="padding-right: 48px;">
                                <div style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); pointer-events: none; display: flex; align-items: center;">
                                    <span style="font-size: 11px; font-weight: 700; color: #94a3b8;">ກີບ</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <label class="inline-flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" name="reset_budget" value="1"
                                    class="w-4 h-4 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500 bg-white">
                                <span class="text-xs font-bold text-slate-700">ຣີເຊັດງົບປະມານຕັ້ງຕົ້ນ (Reset Initial Budget)</span>
                            </label>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="p-5 border-t border-slate-50 bg-slate-50/50 flex justify-end gap-2 shrink-0">
                        <button type="button" onclick="closeEditModal()"
                            class="rounded-xl bg-white border border-slate-200 text-slate-500 transition-all hover:bg-slate-50 inline-flex items-center justify-center"
                            style="padding: 8px 24px; font-size: 13px; font-weight: 700; min-width: 90px; height: 38px;">
                            ຍົກເລີກ
                        </button>
                        <button type="submit"
                            class="rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white transition-all shadow-md shadow-indigo-100 hover:shadow-lg inline-flex items-center justify-center"
                            style="padding: 8px 24px; font-size: 13px; font-weight: 700; min-width: 90px; height: 38px;">
                            ບັນທຶກ
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @endpush

    {{-- Hide input spin buttons globally on this page --}}
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <script>
        const departments = @json($departments);

        // --- Currency Input Formatting with Commas ---
        function formatNumberWithCommas(value) {
            value = value.replace(/[^0-9.]/g, '');
            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }
            if (parts[0]) {
                const formattedInt = parseInt(parts[0], 10).toLocaleString('en-US');
                value = formattedInt + (parts[1] !== undefined ? '.' + parts[1] : '');
            }
            return value;
        }

        // Attach event listener to all formatted inputs
        function initFormatting() {
            const inputs = document.querySelectorAll('.budget-input-format');
            inputs.forEach(input => {
                if (input.value) {
                    input.value = formatNumberWithCommas(input.value);
                }

                input.addEventListener('input', (e) => {
                    const originalLength = e.target.value.length;
                    let cursorPosition = e.target.selectionStart;

                    e.target.value = formatNumberWithCommas(e.target.value);

                    const newLength = e.target.value.length;
                    cursorPosition = cursorPosition + (newLength - originalLength);
                    e.target.setSelectionRange(cursorPosition, cursorPosition);
                });
            });

            // Strip commas before submitting any form
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const budgetInputs = this.querySelectorAll('.budget-input-format');
                    budgetInputs.forEach(input => {
                        input.value = input.value.replace(/,/g, '');
                    });
                });
            });
        }

        // --- Add Modal Controls ---
        function openAddModal() {
            document.getElementById('add-modal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('add-modal').classList.add('hidden');
        }

        // --- Edit Modal Controls ---
        function openEditModal(id) {
            const dept = departments.find(d => d.id === id);
            if (!dept) return;

            // Fill inputs with department values
            document.getElementById('edit_dept_code').value = dept.dept_code || '';
            document.getElementById('edit_department_name').value = dept.department_name;
            document.getElementById('edit_department_type').value = dept.department_type || '';

            // Format budget for display
            const budgetInput = document.getElementById('edit_budget_amount');
            budgetInput.value = formatNumberWithCommas((dept._initial || 0).toString());

            // Set form action dynamically
            document.getElementById('edit-form-action').action = '/department-setup/' + id;

            // Show modal
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            initFormatting();
        });
    </script>
</x-app-layout>

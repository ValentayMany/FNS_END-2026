<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1.5 min-w-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                    Dashboard ງົບປະມານພາກ/ສ່ວນ
                </h2>
            </div>
            <p class="text-sm font-semibold text-gray-500 pl-10">ສະຫຼຸບງົບປະມານ, ຍອດຈ່າຍ ແລະ ຍອດຄົງເຫຼືອຂອງແຕ່ລະພາກ/ສ່ວນ</p>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-[1300px] mx-auto w-full px-3 sm:px-4 lg:px-6 space-y-6">

            {{-- Year Filter --}}
            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('department-setup.budget-dashboard') }}" class="flex items-center gap-2">
                    <label class="text-sm font-bold text-gray-600">ສະແດງປີ:</label>
                    <select name="year" onchange="this.form.submit()"
                        class="border border-gray-200 rounded-xl px-3 py-2 text-sm font-bold bg-white shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all">
                        @foreach($availableYears as $yr)
                            <option value="{{ $yr }}" {{ $yr == $year ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                        @if($availableYears->doesntContain((int)$year))
                            <option value="{{ $year }}" selected>{{ $year }}</option>
                        @endif
                    </select>
                </form>
                <a href="{{ route('department-setup.index') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    ຈັດການພາກ/ສ່ວນ
                </a>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @php
                    $totalPct = $totalInitial > 0 ? min(100, round(($totalSpent / $totalInitial) * 100, 1)) : 0;
                @endphp

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">ງົບປະມານທັງໝົດ</p>
                            <p class="text-xl font-extrabold text-indigo-700">{{ number_format($totalInitial, 0, '.', ',') }} ກີບ</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">ຈ່າຍໄປແລ້ວ (ປີ {{ $year }})</p>
                            <p class="text-xl font-extrabold text-rose-600">{{ number_format($totalSpent, 0, '.', ',') }} ກີບ</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">ຍັງເຫຼືອທັງໝົດ</p>
                            <p class="text-xl font-extrabold {{ $totalRemaining >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ number_format($totalRemaining, 0, '.', ',') }} ກີບ
                            </p>
                        </div>
                    </div>
                    {{-- Overall Progress --}}
                    <div class="mt-1">
                        <div class="flex justify-between text-xs text-gray-400 mb-1">
                            <span>ໃຊ້ໄປ {{ $totalPct }}%</span>
                            <span>ຍັງເຫຼືອ {{ 100 - $totalPct }}%</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 {{ $totalPct >= 90 ? 'bg-red-500' : ($totalPct >= 70 ? 'bg-amber-400' : 'bg-emerald-500') }}"
                                style="width: {{ $totalPct }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Department Table --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-800 flex items-center gap-2">
                        <span class="w-1.5 h-5 rounded-full bg-indigo-500 block"></span>
                        ງົບປະມານຂອງແຕ່ລະພາກ/ສ່ວນ — ປີ {{ $year }}
                    </h3>
                    <span class="text-xs font-bold bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full">
                        {{ $departments->count() }} ພາກ/ສ່ວນ
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-gray-50/80 border-b border-gray-100">
                                <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wide">#</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wide">ພາກ/ສ່ວນ</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wide text-right">ງົບຕັ້ງຕົ້ນ</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wide text-right">ຈ່າຍໄປແລ້ວ</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wide text-right">ຍັງເຫຼືອ</th>
                                <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wide">ຄວາມຄືບໜ້າ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($departments as $index => $dept)
                                @php
                                    $pct = $dept->_pct;
                                    $colorClass = $pct >= 90 ? 'bg-red-500' : ($pct >= 70 ? 'bg-amber-400' : 'bg-emerald-500');
                                    $textColor  = $pct >= 90 ? 'text-red-600' : ($pct >= 70 ? 'text-amber-600' : 'text-emerald-600');
                                    $remainColor = $dept->_remaining < 0 ? 'text-red-600 font-extrabold' : 'text-emerald-700 font-bold';
                                @endphp
                                <tr class="hover:bg-indigo-50/20 transition-colors">
                                    <td class="py-3 px-4 text-gray-400 font-bold text-xs">
                                        @if($dept->dept_code)
                                            <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-lg text-xs font-mono">{{ $dept->dept_code }}</span>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-bold text-gray-800">{{ $dept->displayName() }}</div>
                                        @if($dept->department_type && $dept->department_type !== $dept->department_name)
                                            <div class="text-xs text-gray-400">{{ $dept->department_type }}</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-right font-mono text-indigo-700 font-bold">
                                        {{ $dept->_initial > 0 ? number_format($dept->_initial, 0, '.', ',') : '—' }}
                                    </td>
                                    <td class="py-3 px-4 text-right font-mono text-rose-600 font-bold">
                                        {{ $dept->_spent > 0 ? number_format($dept->_spent, 0, '.', ',') : '0' }}
                                    </td>
                                    <td class="py-3 px-4 text-right font-mono {{ $remainColor }}">
                                        {{ number_format($dept->_remaining, 0, '.', ',') }}
                                        @if($dept->_remaining < 0)
                                            <span class="text-xs ml-1">(ເກີນງົບ!)</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6">
                                        @if($dept->_initial > 0)
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                                    <div class="h-full rounded-full transition-all duration-700 {{ $colorClass }}"
                                                        style="width: {{ $pct }}%"></div>
                                                </div>
                                                <span class="text-xs font-bold {{ $textColor }} min-w-[40px] text-right">{{ $pct }}%</span>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-300">ບໍ່ໄດ້ຕັ້ງງົບ</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-400 text-sm">ບໍ່ມີຂໍ້ມູນພາກ/ສ່ວນ</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="bg-indigo-50/60 border-t-2 border-indigo-100 font-extrabold">
                                <td colspan="2" class="py-3 px-4 text-indigo-700 text-sm">ລວມທັງໝົດ</td>
                                <td class="py-3 px-4 text-right font-mono text-indigo-700">{{ number_format($totalInitial, 0, '.', ',') }}</td>
                                <td class="py-3 px-4 text-right font-mono text-rose-600">{{ number_format($totalSpent, 0, '.', ',') }}</td>
                                <td class="py-3 px-4 text-right font-mono {{ $totalRemaining >= 0 ? 'text-emerald-700' : 'text-red-600' }}">
                                    {{ number_format($totalRemaining, 0, '.', ',') }}
                                </td>
                                <td class="py-3 px-6">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-2.5 bg-indigo-100 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full {{ $totalPct >= 90 ? 'bg-red-500' : ($totalPct >= 70 ? 'bg-amber-400' : 'bg-emerald-500') }}"
                                                style="width: {{ $totalPct }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-indigo-600 min-w-[40px] text-right">{{ $totalPct }}%</span>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Legend --}}
            <div class="flex flex-wrap gap-4 text-xs text-gray-500">
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500 block"></span> ປົກກະຕິ (ໃຊ້ < 70%)</div>
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-amber-400 block"></span> ໃກ້ໝົດ (70–89%)</div>
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-500 block"></span> ສຸ່ມສ່ຽງ / ເກີນງົບ (≥ 90%)</div>
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none min-w-0">
            🏠 ໜ້າຫຼັກ (Dashboard) — {{ Auth::user()->full_name ?? Auth::user()->username }}
            <span class="block sm:inline text-sm font-semibold text-indigo-500 mt-1 sm:mt-0 sm:ml-2 tracking-wider uppercase">({{ Auth::user()->roleDisplay() }})</span>
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6">
        <div class="max-w-6xl mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6 space-y-6">

            {{-- Action List สำหรับ Approver --}}
            @if($actionList && $actionList->count() > 0)
            <div class="fns-card fns-animate border-l-4 border-l-indigo-500">
                <div class="fns-card-header flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between min-w-0 bg-indigo-50/50">
                    <h3 class="fns-card-title flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        ລາຍການທີ່ຕ້ອງດຳເນີນການ
                    </h3>
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                        {{ $actionList->total() }} ລາຍການ
                    </span>
                </div>
                <div class="fns-card-body p-0 divide-y divide-gray-100">
                    @foreach($actionList as $req)
                    <div class="px-5 py-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between hover:bg-gray-50 transition-colors min-w-0 group">
                        <div class="min-w-0">
                            <p class="font-bold text-gray-800 break-words group-hover:text-indigo-700 transition-colors">#{{ $req->id }} — {{ $req->description }}</p>
                            <p class="text-sm font-medium text-gray-500 break-words flex items-center gap-2 mt-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                {{ $req->requester?->full_name }} 
                                <span class="text-gray-300">|</span> 
                                {{ $req->department?->displayName() }}
                            </p>
                        </div>
                        <div class="text-left sm:text-right shrink-0 flex flex-col sm:items-end">
                            <p class="font-extrabold text-gray-900 text-lg">{{ number_format($req->requested_amount, 2) }} <span class="text-sm text-gray-400">ກີບ</span></p>
                            <a href="{{ route('approvals.show', $req) }}" class="inline-flex items-center gap-1 text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors mt-1 bg-indigo-50 px-3 py-1 rounded-lg hover:bg-indigo-100">
                                ດຳເນີນການ 
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- My Requests สำหรับ Requester --}}
            @if($myRequests && $myRequests->count() > 0)
            <div class="fns-card fns-animate fns-animate-delay-1 border-l-4 border-l-sky-500">
                <div class="fns-card-header flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between min-w-0 bg-sky-50/50">
                    <h3 class="fns-card-title flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        ຄຳຂໍລ່າສຸດຂອງຂ້ອຍ
                    </h3>
                    <a href="{{ route('requests.index') }}" class="text-sm font-bold text-sky-600 hover:text-sky-800 transition-colors bg-white px-3 py-1 rounded-full shadow-sm ring-1 ring-sky-100">
                        ເບິ່ງທັງໝົດ →
                    </a>
                </div>
                <div class="fns-card-body p-0 divide-y divide-gray-100">
                    @foreach($myRequests as $req)
                    @php
                        $colors = ['draft'=>'bg-gray-100 text-gray-600','approved'=>'bg-emerald-100 text-emerald-700','rejected'=>'bg-red-100 text-red-700','paid'=>'bg-indigo-100 text-indigo-700'];
                        $color = $colors[$req->status] ?? 'bg-amber-100 text-amber-700';
                    @endphp
                    <div class="px-5 py-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between hover:bg-gray-50 transition-colors min-w-0 group">
                        <div class="min-w-0">
                            <p class="font-bold text-gray-800 break-words group-hover:text-sky-700 transition-colors">#{{ $req->id }} — {{ Str::limit($req->description, 60) }}</p>
                            <p class="text-sm font-medium text-gray-500 break-words mt-1">{{ $req->department?->displayName() }}</p>
                        </div>
                        <div class="text-left sm:text-right shrink-0 flex flex-col sm:items-end">
                            <span class="px-3 py-1 rounded-md text-[0.7rem] font-extrabold uppercase tracking-widest {{ $color }}">
                                {{ $statusLabels[$req->status] ?? $req->status }}
                            </span>
                            <p class="font-extrabold text-gray-900 mt-2">{{ number_format($req->requested_amount, 2) }} <span class="text-xs text-gray-400">ກີບ</span></p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(!$actionList?->count() && !$myRequests?->count())
            <div class="text-center py-20 px-4 bg-white/50 backdrop-blur border border-white rounded-3xl shadow-sm fns-animate">
                <div class="w-20 h-20 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4 ring-8 ring-gray-50/50">
                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">ບໍ່ມີລາຍການທີ່ต้องดຳເນີນการ</h3>
                <p class="text-sm font-medium text-gray-500">ระบบปกติดี ไม่มีงานค้างในกล่องจดหมายของคุณ</p>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>

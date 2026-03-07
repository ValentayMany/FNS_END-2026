<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            🏠 Dashboard — {{ Auth::user()->full_name ?? Auth::user()->username }}
            <span class="text-sm font-normal text-gray-500">({{ Auth::user()->role?->role_name }})</span>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4">

            {{-- Action List สำหรับ Approver --}}
            @if($actionList && $actionList->count() > 0)
            <div class="bg-white rounded-xl shadow mb-6">
                <div class="px-5 py-4 border-b flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">⚡ ລາຍການທີ່ຕ້ອງດຳເນີນການ</h3>
                    <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ $actionList->total() }} ລາຍການ
                    </span>
                </div>
                <div class="divide-y">
                    @foreach($actionList as $req)
                    <div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50">
                        <div>
                            <p class="font-medium">#{{ $req->id }} — {{ $req->description }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $req->requester?->full_name }} · {{ $req->department?->department_name }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold">{{ number_format($req->requested_amount, 2) }} ກີບ</p>
                            <a href="{{ route('approval.index') }}"
                               class="text-xs text-indigo-600 hover:underline">ດຳເນີນການ →</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- My Requests สำหรับ Requester --}}
            @if($myRequests && $myRequests->count() > 0)
            <div class="bg-white rounded-xl shadow">
                <div class="px-5 py-4 border-b flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">📋 ຄຳຂໍລ່າສຸດຂອງຂ້ອຍ</h3>
                    <a href="{{ route('requests.index') }}" class="text-sm text-indigo-600 hover:underline">
                        ເບິ່ງທັງໝົດ
                    </a>
                </div>
                <div class="divide-y">
                    @foreach($myRequests as $req)
                    @php
                        $colors = ['draft'=>'bg-gray-100 text-gray-600','approved'=>'bg-green-100 text-green-700','rejected'=>'bg-red-100 text-red-700','paid'=>'bg-teal-100 text-teal-700'];
                        $color = $colors[$req->status] ?? 'bg-yellow-100 text-yellow-700';
                    @endphp
                    <div class="px-5 py-3 flex items-center justify-between">
                        <div>
                            <p class="font-medium">#{{ $req->id }} — {{ Str::limit($req->description, 40) }}</p>
                            <p class="text-sm text-gray-500">{{ $req->department?->department_name }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                {{ $statusLabels[$req->status] ?? $req->status }}
                            </span>
                            <p class="text-sm font-semibold mt-1">{{ number_format($req->requested_amount, 2) }} ກີບ</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(!$actionList?->count() && !$myRequests?->count())
            <div class="text-center py-16 text-gray-400">
                <div class="text-5xl mb-3">✅</div>
                <p>ບໍ່ມີລາຍການທີ່ຕ້ອງດຳເນີນການ</p>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">📄 ລາຍລະອຽດຄຳຂໍ #{{ $advanceRequest->id }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 space-y-5">

            @if(session('success'))
            <div class="p-3 bg-green-100 text-green-700 rounded-lg text-sm">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="p-3 bg-red-100 text-red-700 rounded-lg text-sm">❌ {{ session('error') }}</div>
            @endif

            {{-- Detail --}}
            <div class="bg-white rounded-xl shadow p-6 grid grid-cols-2 gap-4 text-sm">
                @php
                    $colors = ['draft'=>'bg-gray-100 text-gray-600','approved'=>'bg-green-100 text-green-700','rejected'=>'bg-red-100 text-red-700','paid'=>'bg-teal-100 text-teal-700','cleared'=>'bg-indigo-100 text-indigo-700'];
                    $color = $colors[$advanceRequest->status] ?? 'bg-yellow-100 text-yellow-700';
                @endphp
                <div>
                    <p class="text-gray-400 text-xs mb-0.5">ສະຖານະ</p>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $color }}">
                        {{ \App\Models\AdvanceRequest::statusLabels()[$advanceRequest->status] ?? $advanceRequest->status }}
                    </span>
                </div>
                <div>
                    <p class="text-gray-400 text-xs mb-0.5">ຈຳນວນເງິນ</p>
                    <p class="font-bold text-lg">{{ number_format($advanceRequest->requested_amount, 2) }} ກີບ</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs mb-0.5">ພາກສ່ວນ</p>
                    <p>{{ $advanceRequest->department?->department_name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs mb-0.5">ວັນທີຄຳຂໍ</p>
                    <p>{{ $advanceRequest->request_date?->format('d/m/Y') }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-gray-400 text-xs mb-0.5">ລາຍລະອຽດ</p>
                    <p>{{ $advanceRequest->description }}</p>
                </div>
            </div>

            {{-- ปุ่ม Submit (draft เท่านั้น) --}}
            @if($advanceRequest->status === 'draft')
            <form method="POST" action="{{ route('requests.submit', $advanceRequest) }}">
                @csrf
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold text-sm">
                    📤 ສົ່ງຄຳຂໍເພື່ອອະນຸມັດ
                </button>
            </form>
            @endif

            {{-- Workflow Timeline --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-800 mb-4">📜 ປະຫວັດການດຳເນີນການ</h3>
                @forelse($advanceRequest->workflowLogs as $log)
                <div class="flex gap-3 mb-3 last:mb-0">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-sm shrink-0">
                        @if(str_contains($log->action, 'approved')) ✅
                        @elseif(str_contains($log->action, 'rejected')) ❌
                        @elseif(str_contains($log->action, 'paid')) 💵
                        @else 📤 @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium">
                            {{ $log->actor?->full_name ?? $log->actor?->username }}
                            <span class="text-gray-400 text-xs">({{ $log->actor?->role?->role_name }})</span>
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $log->action }} · {{ $log->timestamp?->format('d/m/Y H:i') }}
                        </p>
                        @if($log->comments)
                        <p class="text-xs bg-gray-50 border rounded px-2 py-1 mt-1">💬 {{ $log->comments }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-sm">ຍັງບໍ່ມີການດຳເນີນການ</p>
                @endforelse
            </div>

            <a href="{{ route('requests.index') }}" class="text-sm text-indigo-600 hover:underline">← ກັບຄືນ</a>
        </div>
    </div>
</x-app-layout>

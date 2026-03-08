<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">📄 ກວດສອບຄຳຂໍ #{{ $advanceRequest->id }}</h2>
            <a href="{{ route('approval.index') }}" class="text-sm text-indigo-600 hover:underline">← ກັບຄືນ</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 space-y-5">

            @if(session('success'))
            <div class="p-3 bg-green-100 text-green-700 rounded-lg text-sm">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="p-3 bg-red-100 text-red-700 rounded-lg text-sm">❌ {{ session('error') }}</div>
            @endif

            {{-- ລາຍລະອຽດ --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-4 pb-2 border-b">ຂໍ້ມູນຄຳຂໍ</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs mb-0.5">ຜູ້ຂໍ</p>
                        <p class="font-medium">{{ $advanceRequest->requester?->full_name ?? $advanceRequest->requester?->username }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-0.5">ສະຖານະ</p>
                        <span class="px-2 py-0.5 rounded text-xs bg-yellow-100 text-yellow-700">
                            {{ $advanceRequest->status }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-0.5">ພາກສ່ວນ</p>
                        <p>{{ $advanceRequest->department?->department_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-0.5">ວັນທີຄຳຂໍ</p>
                        <p>{{ $advanceRequest->request_date?->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-0.5">ຈຳນວນເງິນ</p>
                        <p class="font-bold text-lg">{{ number_format($advanceRequest->requested_amount, 2) }} ກີບ</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-400 text-xs mb-0.5">ລາຍລະອຽດ</p>
                        <p>{{ $advanceRequest->description }}</p>
                    </div>
                </div>
            </div>

            {{-- ປຸ່ມອະນຸມັດ/ປະຕິເສດ --}}
            @if($advanceRequest->canBeActedBy(Auth::user()))
            <div class="bg-white rounded-xl shadow p-6 space-y-4">
                <h3 class="font-semibold text-gray-700">ດຳເນີນການ</h3>

                {{-- ອະນຸມັດ --}}
                <form method="POST" action="{{ route('approval.approve', $advanceRequest) }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="comment" placeholder="ໝາຍເຫດ (ຖ້າມີ)"
                        class="flex-1 border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm font-semibold">
                        ✅ ອະນຸມັດ
                    </button>
                </form>

                {{-- ປະຕິເສດ --}}
                <form method="POST" action="{{ route('approval.reject', $advanceRequest) }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="comment" placeholder="ເຫດຜົນການປະຕິເສດ *" required
                        class="flex-1 border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-semibold">
                        ❌ ປະຕິເສດ
                    </button>
                </form>
            </div>
            @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-700">
                ⚠️ ທ່ານບໍ່ມີສິດດຳເນີນການໃນຂັ້ນຕອນນີ້
            </div>
            @endif

            {{-- Workflow Timeline --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-4">📜 ປະຫວັດການດຳເນີນການ</h3>
                @forelse($advanceRequest->workflowLogs as $log)
                <div class="flex gap-3 mb-3 last:mb-0">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-sm shrink-0">
                        @if(str_contains($log->action, 'approved')) ✅
                        @elseif(str_contains($log->action, 'rejected')) ❌
                        @elseif(str_contains($log->action, 'paid')) 💵
                        @elseif(str_contains($log->action, 'clearing')) 🧾
                        @elseif(str_contains($log->action, 'submitted')) 📤
                        @else 📝 @endif
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

        </div>
    </div>
</x-app-layout>

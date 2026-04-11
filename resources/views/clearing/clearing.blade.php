<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">🧾 ສົ່ງໃບສະສາງ (Clearing)</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 space-y-4">

            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-700 rounded-lg text-sm">✅ {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="p-3 bg-red-100 text-red-700 rounded-lg text-sm">❌ {{ session('error') }}</div>
            @endif

            @forelse($requests as $req)
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    {{-- Header --}}
                    <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
                        <div>
                            <span class="text-gray-400 text-xs">#{{ $req->id }}</span>
                            <span class="ml-2 font-semibold text-gray-800">{{ $req->description }}</span>
                        </div>
                        <span class="text-lg font-bold text-orange-600">
                            {{ number_format($req->requested_amount, 2) }} ກີບ
                        </span>
                    </div>

                    <div class="px-5 py-4 grid grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>👤 ຜູ້ຂໍ: <strong>{{ $req->requester?->full_name ?? $req->requester?->username }}</strong></div>
                        <div>🏢 ພາກສ່ວນ: <strong>{{ $req->department?->department_name }}</strong></div>
                        <div>📅 ວັນທີຂໍ: <strong>{{ $req->request_date?->format('d/m/Y') }}</strong></div>
                        <div>📌 ສະຖານະ:
                            <span class="px-2 py-0.5 rounded text-xs
                                {{ $req->status === 'pending_clearing' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $req->status === 'pending_clearing' ? 'ລໍຖ້າຢືນຢັນ' : 'ຈ່າຍແລ້ວ' }}
                            </span>
                        </div>
                    </div>

                    {{-- ไฟล์แนบที่มีอยู่แล้ว --}}
                    @if($req->clearingAttachments->count() > 0)
                        <div class="px-5 py-3 border-t bg-blue-50">
                            <p class="text-xs text-blue-700 font-semibold mb-2">📎 ໄຟລ໌ທີ່ແນບໄວ້ ({{ $req->clearingAttachments->count() }} ໄຟລ໌)</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($req->clearingAttachments as $att)
                                    <a href="{{ route('clearing.attachment.download', $att) }}"
                                        class="inline-flex items-center gap-1 text-xs bg-white border border-blue-200 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-100 transition">
                                        📄 {{ $att->original_name }}
                                        <span class="text-gray-400">({{ $att->file_size_for_humans }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Action --}}
                    <div class="px-5 py-4 border-t">
                        @if (Auth::user()->isAccountant())
                            {{-- Accountant: ยืนยัน --}}
                            <form method="POST" action="{{ route('clearing.confirm', $req) }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-lg transition">
                                    ✅ ຢືນຢັນການສະສາງ
                                </button>
                            </form>
                        @else
                            {{-- Requester: ส่ง + แนบไฟล์ --}}
                            <form method="POST" action="{{ route('clearing.submit', $req) }}"
                                enctype="multipart/form-data" class="space-y-3">
                                @csrf

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">
                                        📎 ແນບໃບເສດ / ຫຼັກຖານ (PDF, รูปภาพ, Word, Excel — ສູງສຸດ 5 ໄຟລ໌, ໄຟລ໌ລະ 5MB)
                                    </label>
                                    <input type="file" name="attachments[]" multiple accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx,.xls,.xlsx"
                                        class="block w-full text-sm text-gray-600
                                               file:mr-3 file:py-1.5 file:px-3
                                               file:rounded-lg file:border-0
                                               file:text-xs file:font-semibold
                                               file:bg-orange-50 file:text-orange-700
                                               hover:file:bg-orange-100 transition">
                                    @error('attachments.*')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition">
                                    🧾 ສົ່ງໃບສະສາງ
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow px-5 py-12 text-center text-gray-400">
                    ✅ ບໍ່ມີລາຍການທີ່ຕ້ອງສະສາງ
                </div>
            @endforelse

            {{-- Pagination --}}
            @if($requests->hasPages())
                <div class="mt-4">{{ $requests->links() }}</div>
            @endif

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-medium text-rose-400 uppercase tracking-widest">ການສະສາງ</p>
            <h2 class="text-lg sm:text-xl font-bold text-gray-800">ໃບສະສາງ (Clearing)</h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-3xl mx-auto w-full min-w-0 px-3 sm:px-4 space-y-5">

            @if (session('success'))
                <div class="fns-alert fns-alert-success fns-animate">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="fns-alert fns-alert-error fns-animate">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                    {{ session('error') }}
                </div>
            @endif

            @forelse ($requests as $req)
                <div class="fns-card fns-animate">
                    {{-- Card header --}}
                    <div class="fns-card-header" style="border-bottom: none; padding-bottom: 0;">
                        <div class="min-w-0 flex-1">
                            <span class="text-xs font-semibold text-gray-400">#{{ $req->id }}</span>
                            <p class="font-bold text-gray-800 text-sm mt-1 break-words">{{ $req->description }}</p>
                        </div>
                        <span class="text-lg font-extrabold text-rose-600 whitespace-nowrap">{{ number_format($req->requested_amount, 2) }} ກີບ</span>
                    </div>

                    {{-- Details --}}
                    <div class="fns-card-body" style="padding-top: 12px;">
                        <div class="grid grid-cols-2 gap-4 sm:gap-5 text-sm">
                            <div>
                                <div class="fns-label" style="margin-bottom:3px;">ຜູ້ຂໍ</div>
                                <div class="font-semibold text-gray-800">{{ $req->requester?->full_name ?? $req->requester?->username }}</div>
                            </div>
                            <div>
                                <div class="fns-label" style="margin-bottom:3px;">ພາກສ່ວນ</div>
                                <div class="font-semibold text-gray-800">{{ $req->department?->displayName() }}</div>
                            </div>
                            <div>
                                <div class="fns-label" style="margin-bottom:3px;">ວັນທີຂໍ</div>
                                <div class="font-semibold text-gray-800">{{ $req->request_date?->format('d/m/Y') }}</div>
                            </div>
                            <div>
                                <div class="fns-label" style="margin-bottom:3px;">ສະຖານະ</div>
                                <div>
                                    <span class="fns-badge {{ $req->status === 'pending_clearing' ? 'fns-badge-clearing' : 'fns-badge-paid' }}">
                                        {{ $req->status === 'pending_clearing' ? 'ລໍຖ້າຢືນຢັນ' : 'ຈ່າຍແລ້ວ' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if ($req->clearingAttachments->count() > 0)
                            <div class="mt-4 p-4 bg-gray-50 border border-gray-100 rounded-xl">
                                <div class="fns-label" style="color:#f43f5e; margin-bottom:10px;">
                                    ໄຟລ໌ທີ່ແນບ ({{ $req->clearingAttachments->count() }})
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($req->clearingAttachments as $att)
                                        <a href="{{ route('clearing.download', $att) }}"
                                           class="inline-flex items-center gap-2 text-xs font-semibold text-gray-700 bg-white border border-gray-200 px-3 py-1.5 rounded-full hover:border-rose-300 hover:shadow-sm transition">
                                            <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            {{ $att->original_name }}
                                            <span class="text-gray-400">({{ $att->file_size_for_humans }})</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Footer/Actions --}}
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        @if (Auth::user()->isAccountant())
                            <form method="POST" action="{{ route('clearing.confirm', $req) }}" class="inline">
                                @csrf
                                <button type="submit" class="fns-btn fns-btn-success">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    ຢືນຢັນການສະສາງ
                                </button>
                            </form>
                        @elseif ($req->status === 'paid')
                            <form method="POST" action="{{ route('clearing.submit', $req) }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="fns-label">
                                        ແນບໃບເສດ / ຫຼັກຖານ (PDF, ຮູບ, Word, Excel — ສູງສຸດ 5 ໄຟລ໌, ໄຟລ໌ລະ 5MB)
                                    </label>
                                    <input type="file" name="attachments[]" multiple
                                        accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx,.xls,.xlsx"
                                        class="fns-input file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-rose-500 file:text-white hover:file:bg-rose-600 file:cursor-pointer">
                                    @error('attachments.*')
                                        <p class="text-red-600 text-xs mt-2 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="fns-btn fns-btn-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                    ສົ່ງໃບສະສາງ
                                </button>
                            </form>
                        @else
                            <p class="text-sm text-gray-500 font-medium">ສົ່ງໃບສະສາງແລ້ວ — ລໍຖ້ານາຍບັນຊີຢືນຢັນ</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="fns-card fns-animate">
                    <div class="fns-empty">
                        <div class="fns-empty-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <p class="fns-empty-text">ບໍ່ມີລາຍການທີ່ຕ້ອງສະສາງ</p>
                    </div>
                </div>
            @endforelse

            @if ($requests instanceof \Illuminate\Pagination\LengthAwarePaginator && $requests->hasPages())
                <div class="pt-1 pb-4">{{ $requests->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>

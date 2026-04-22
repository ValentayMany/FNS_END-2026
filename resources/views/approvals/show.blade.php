<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <div class="fns-card-header-icon shrink-0" style="background:#f5f3ff; color:#7c3aed;" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 13.5l.5 1.75a2.25 2.25 0 001.5 1.5l1.75.5-1.75.5a2.25 2.25 0 00-1.5 1.5L18 21l-.5-1.75a2.25 2.25 0 00-1.5-1.5l-1.75-.5 1.75-.5a2.25 2.25 0 001.5-1.5L18 13.5z" /></svg>
                </div>
                <div class="min-w-0">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 truncate">ກວດສອບຄຳຂໍ</h2>
                    <p class="text-xs font-semibold text-gray-400 mt-0.5">ເລກທີ #{{ $advanceRequest->id }}</p>
                </div>
            </div>
            <a href="{{ route('approvals.index') }}" class="fns-btn fns-btn-secondary shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                ກັບຄືນ
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0 flex-1">
        <div class="max-w-4xl mx-auto w-full min-w-0 px-3 sm:px-4 space-y-5">

            @if (session('success'))
                <div class="fns-alert fns-alert-success fns-animate">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75l2.25 2.25L15 9.75" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" /></svg>
                    <div>{{ session('success') }}</div>
                </div>
            @endif
            @if (session('error'))
                <div class="fns-alert fns-alert-error fns-animate">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" /></svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <div class="fns-card fns-animate">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ຂໍ້ມູນຄຳຂໍ</h3>
                            <p class="fns-card-subtitle">ລາຍລະອຽດສຳລັບການກວດສອບ ແລະ ອະນຸມັດ</p>
                        </div>
                    </div>
                </div>
                <div class="fns-card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-sm">
                        <div>
                            <div class="fns-label mb-1">ຜູ້ຂໍ</div>
                            <div class="font-semibold text-gray-800">{{ $advanceRequest->requester?->full_name ?? $advanceRequest->requester?->username }}</div>
                        </div>
                        <div>
                            <div class="fns-label mb-1">ສະຖານະ</div>
                            <div>
                                @php
                                    $badgeMap = [
                                        'draft' => ['class' => 'fns-badge-draft', 'label' => 'ຮ່າງ'],
                                        'pending_accountant_review' => ['class' => 'fns-badge-pending', 'label' => 'ລໍຖ້ານັກບັນຊີ'],
                                        'pending_finance_head_review' => ['class' => 'fns-badge-review', 'label' => 'ລໍຖ້າຫົວໜ້າການເງິນ'],
                                        'pending_deputy_head_approval' => ['class' => 'fns-badge-deputy', 'label' => 'ລໍຖ້າຮອງຄະນະ'],
                                        'pending_faculty_head_approval' => ['class' => 'fns-badge-faculty', 'label' => 'ລໍຖ້າຄະນະບໍດີ'],
                                        'approved' => ['class' => 'fns-badge-approved', 'label' => 'ອະນຸມັດ'],
                                        'paid' => ['class' => 'fns-badge-paid', 'label' => 'ຈ່າຍແລ້ວ'],
                                        'pending_clearing' => ['class' => 'fns-badge-clearing', 'label' => 'ລໍຖ້າເຄຼຍ'],
                                        'cleared' => ['class' => 'fns-badge-cleared', 'label' => 'ເຄຼຍແລ້ວ'],
                                        'rejected' => ['class' => 'fns-badge-rejected', 'label' => 'ປະຕິເສດ'],
                                    ];
                                    $badge = $badgeMap[$advanceRequest->status] ?? ['class' => 'fns-badge-draft', 'label' => $advanceRequest->status];
                                @endphp
                                <span class="fns-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="fns-label mb-1">ພາກສ່ວນ</div>
                            <div class="font-semibold text-gray-800">{{ $advanceRequest->department?->displayName() }}</div>
                        </div>
                        <div>
                            <div class="fns-label mb-1">ວັນທີຄຳຂໍ</div>
                            <div class="font-semibold text-gray-800">{{ $advanceRequest->request_date?->format('d/m/Y') }}</div>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="fns-label mb-1">ຈຳນວນເງິນ</div>
                            <div class="text-xl sm:text-2xl font-extrabold text-indigo-600 tracking-tight">{{ number_format($advanceRequest->requested_amount, 2) }} ກີບ</div>
                        </div>
                        <div class="sm:col-span-2 bg-gray-50 border border-gray-100 rounded-xl p-4">
                            <div class="fns-label mb-1">ລາຍລະອຽດ</div>
                            <div class="font-medium text-gray-700 leading-relaxed">{{ $advanceRequest->description }}</div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($advanceRequest->canBeActedBy(Auth::user()))
                <div class="fns-card fns-animate fns-animate-delay-1">
                    <div class="fns-card-header bg-indigo-50/50">
                        <div class="flex items-center gap-3">
                            <div class="fns-card-header-icon" style="background:#6366f1; color:white;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <h3 class="fns-card-title text-indigo-900">ດຳເນີນການ</h3>
                                <p class="fns-card-subtitle text-indigo-600/70">ອະນຸມັດ ຫຼື ປະຕິເສດຄຳຂໍນີ້</p>
                            </div>
                        </div>
                    </div>
                    <div class="fns-card-body space-y-5">
                        <form method="POST" action="{{ route('approval.approve', $advanceRequest) }}">
                            @csrf
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="text" name="comment" placeholder="ໝາຍເຫດການອະນຸມັດ (ຖ້າມີ)" class="fns-input flex-1">
                                <button type="submit" class="fns-btn fns-btn-success shrink-0 whitespace-nowrap">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2.25 2.25L15 9.75" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" /></svg>
                                    ອະນຸມັດ
                                </button>
                            </div>
                        </form>
                        <div class="h-px bg-gray-100"></div>
                        <form method="POST" action="{{ route('approval.reject', $advanceRequest) }}">
                            @csrf
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="text" name="comment" placeholder="ເຫດຜົນການປະຕິເສດ *" required class="fns-input flex-1">
                                <button type="submit" class="fns-btn fns-btn-danger shrink-0 whitespace-nowrap">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 21.75a9.75 9.75 0 100-19.5 9.75 9.75 0 000 19.5z" /></svg>
                                    ປະຕິເສດ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-3 text-sm font-medium text-amber-800 fns-animate fns-animate-delay-1">
                    <svg class="w-5 h-5 shrink-0 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.008v.008H12v-.008z" /></svg>
                    ທ່ານບໍ່ມີສິດດຳເນີນການໃນຂັ້ນຕອນນີ້
                </div>
            @endif

            <div class="fns-card fns-animate fns-animate-delay-2">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon" style="background:#f8fafc; color:#64748b;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ປະຫວັດການດຳເນີນການ</h3>
                            <p class="fns-card-subtitle">ໄທມ໌ໄລນ໌ການກວດສອບ ແລະ ອະນຸມັດ</p>
                        </div>
                    </div>
                </div>
                <div class="fns-card-body p-6">
                    <div class="relative border-l border-gray-200 pl-4 ml-3 space-y-6">
                        @forelse ($advanceRequest->workflowLogs as $log)
                            <div class="relative">
                                <div class="absolute -left-[26px] top-1 w-[20px] h-[20px] rounded-full flex items-center justify-center bg-white border border-gray-200 shadow-sm" aria-hidden="true">
                                    <div class="w-2.5 h-2.5 rounded-full {{ str_contains($log->action, 'approved') ? 'bg-emerald-500' : (str_contains($log->action, 'rejected') ? 'bg-red-500' : 'bg-indigo-500') }}"></div>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">
                                        {{ $log->actor?->full_name ?? $log->actor?->username }}
                                        <span class="text-gray-400 font-semibold ml-1">({{ $log->actorRoleDisplay() }})</span>
                                    </p>
                                    <p class="text-xs font-semibold text-gray-400 mt-0.5">
                                        {{ $log->action }} <span class="mx-1">&middot;</span> {{ $log->timestamp?->timezone(config('app.timezone'))->format('d/m/Y H:i') }}
                                    </p>
                                    @if ($log->comments)
                                        <div class="mt-2 p-3 bg-gray-50 border border-gray-100 rounded-lg text-sm text-gray-700 font-medium leading-relaxed">
                                            {{ $log->comments }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm font-semibold">ຍັງບໍ່ມີການດຳເນີນການ</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

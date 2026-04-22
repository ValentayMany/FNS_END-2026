<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1.5 min-w-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-none">
                    ລາຍການຈ່າຍເງິນ (Cashier)
                </h2>
            </div>
            <p class="text-sm font-semibold text-gray-500 pl-10">ໜ້າທີ່ຂອງຜູ້ເບີກຈ່າຍເງິນ - ອະນຸມັດແລ້ວລໍຖ້າຈ່າຍເງິນ</p>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-[1400px] mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6 space-y-6">

            @if (session('success'))
                <div class="fns-alert fns-alert-success fns-animate mb-2 shadow-sm border-l-4 border-l-emerald-500 bg-white">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-emerald-500 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="fns-alert fns-alert-error fns-animate mb-2 shadow-sm border-l-4 border-l-red-500 bg-white">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-red-500 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <div class="fns-card border-t-4 border-t-teal-500 shadow-md fns-animate overflow-hidden bg-white">
                
                {{-- Premium Header --}}
                <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white relative">
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center shadow-sm border border-teal-200/50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">ລາຍການລໍຖ້າຈ່າຍເງິນ້ນ</h3>
                            <p class="text-sm font-medium text-gray-500 mt-0.5">ບັນທຶກການຈ່າຍໃຫ້ກັບຄຳຂໍທີ່ອະນຸມັດແລ້ວ</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-extrabold bg-teal-50 text-teal-700 border border-teal-200">
                        ຕ້ອງຈ່າຍ {{ $requests instanceof \Illuminate\Pagination\LengthAwarePaginator ? $requests->total() : count($requests) }} ລາຍການ
                    </span>
                </div>

                <div class="overflow-x-auto touch-pan-x bg-white">
                    <table class="fns-table w-full text-left border-collapse" style="min-width: 50rem;">
                        <thead>
                            <tr class="bg-gray-50/80 border-y border-gray-100">
                                <th class="py-3.5 px-5 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider" style="width:70px;">ID</th>
                                <th class="py-3.5 px-5 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider">ວັນທີ</th>
                                <th class="py-3.5 px-5 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider">ຜູ້ຂໍ / ພາກສ່ວນ</th>
                                <th class="py-3.5 px-5 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider max-w-[240px]">ລາຍລະອຽດ</th>
                                <th class="py-3.5 px-5 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-right">ຈຳນວນ (ກີບ)</th>
                                <th class="py-3.5 px-5 text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider text-center" style="width:140px;">ການປະຕິບັດ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($requests as $req)
                                <tr class="hover:bg-teal-50/30 transition-colors group">
                                    <td class="py-4 px-5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[0.75rem] font-bold bg-gray-100 text-gray-600">#{{ $req->id }}</span>
                                    </td>
                                    <td class="py-4 px-5 whitespace-nowrap text-sm text-gray-500 font-medium group-hover:text-teal-700 transition-colors">
                                        {{ $req->request_date?->format('d/m/Y') }}
                                    </td>
                                    <td class="py-4 px-5">
                                        <p class="text-sm font-bold text-gray-800">{{ $req->requester?->full_name ?? $req->requester?->username }}</p>
                                        <p class="text-xs font-semibold text-gray-400 mt-0.5">{{ $req->department?->displayName() }}</p>
                                    </td>
                                    <td class="py-4 px-5">
                                        <p class="text-sm text-gray-600 truncate max-w-[240px]" title="{{ $req->description }}">{{ $req->description }}</p>
                                    </td>
                                    <td class="py-4 px-5 text-right whitespace-nowrap">
                                        <span class="font-extrabold text-[#059669] text-base tracking-tight">
                                            {{ number_format($req->requested_amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-5 text-center">
                                        <form method="POST" action="{{ route('cashier.pay', $req) }}" class="inline-block" onsubmit="return confirm('ຍືນຍັນການຈ່າຍເງິນແລ້ວແມ່ນບໍ່?');">
                                            @csrf
                                            <button type="submit" class="ui-btn bg-teal-500 text-white hover:bg-teal-600 shadow-sm shadow-teal-500/30 py-1.5 px-4 rounded-lg text-xs font-bold outline-none focus:ring-2 focus:ring-teal-500 ring-offset-1">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                                ໝາຍວ່າຈ່າຍແລ້ວ
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-16">
                                        <div class="flex flex-col items-center justify-center text-center">
                                            <div class="w-20 h-20 rounded-3xl bg-gray-50 flex items-center justify-center text-gray-400 mb-5 border border-gray-100 rotate-6 shadow-sm">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <p class="text-lg text-gray-600 font-extrabold mb-1">ສຳເລັດພາລະກິດ! 🎉</p>
                                            <p class="text-sm font-medium text-gray-500">ບໍ່ມີລາຍການຄຳຂໍທີ່ຕ້ອງຈ່າຍເງິນໃນຂະນະນີ້</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($requests instanceof \Illuminate\Pagination\LengthAwarePaginator && $requests->hasPages())
                    <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $requests->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

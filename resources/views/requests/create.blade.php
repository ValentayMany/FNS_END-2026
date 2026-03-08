<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">📋 ຄຳຂໍເບີກເງິນຂອງຂ້ອຍ</h2>
            <a href="{{ route('requests.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                ➕ ສ້າງຄຳຂໍໃໝ່
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4">

            @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">✅ {{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">ພາກສ່ວນ</th>
                            <th class="px-4 py-3 text-left">ລາຍລະອຽດ</th>
                            <th class="px-4 py-3 text-right">ຈຳນວນ (ກີບ)</th>
                            <th class="px-4 py-3 text-center">ສະຖານະ</th>
                            <th class="px-4 py-3 text-center">ວັນທີ</th>
                            <th class="px-4 py-3 text-center">ລາຍລະອຽດ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($requests as $req)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400">#{{ $req->id }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $req->department?->department_name }}
                            </td>
                            <td class="px-4 py-3 max-w-xs truncate">{{ $req->description }}</td>
                            <td class="px-4 py-3 text-right font-semibold">
                                {{ number_format($req->requested_amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                $colors = [
                                    'draft'                          => 'bg-gray-100 text-gray-600',
                                    'pending_accountant_review'      => 'bg-yellow-100 text-yellow-700',
                                    'pending_finance_head_review'    => 'bg-orange-100 text-orange-700',
                                    'pending_deputy_head_approval'   => 'bg-blue-100 text-blue-700',
                                    'pending_faculty_head_approval'  => 'bg-purple-100 text-purple-700',
                                    'approved'                       => 'bg-green-100 text-green-700',
                                    'paid'                           => 'bg-teal-100 text-teal-700',
                                    'pending_clearing'               => 'bg-pink-100 text-pink-700',
                                    'cleared'                        => 'bg-emerald-100 text-emerald-700',
                                    'rejected'                       => 'bg-red-100 text-red-700',
                                ];
                                $color = $colors[$req->status] ?? 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="px-2 py-0.5 rounded text-xs {{ $color }}">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-400 text-xs">
                                {{ $req->request_date?->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('requests.show', $req) }}"
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs">
                                    ເບິ່ງ
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-400">
                                ຍັງບໍ່ມີຄຳຂໍ —
                                <a href="{{ route('requests.create') }}" class="text-indigo-600 hover:underline">
                                    ສ້າງຄຳຂໍໃໝ່
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($requests->hasPages())
                <div class="px-4 py-3 border-t">{{ $requests->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

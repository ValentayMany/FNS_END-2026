<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            ⚡ ລາຍການທີ່ຕ້ອງອະນຸມັດ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4">

            @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">❌ {{ session('error') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">ຜູ້ຂໍ</th>
                            <th class="px-4 py-3 text-left">ພາກສ່ວນ</th>
                            <th class="px-4 py-3 text-left">ລາຍລະອຽດ</th>
                            <th class="px-4 py-3 text-right">ຈຳນວນ (ກີບ)</th>
                            <th class="px-4 py-3 text-center">ວັນທີ</th>
                            <th class="px-4 py-3 text-center">ດຳເນີນການ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($requests as $req)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400">#{{ $req->id }}</td>
                            <td class="px-4 py-3 font-medium">
                                {{ $req->requester?->full_name ?? $req->requester?->username }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $req->department?->department_name }}
                            </td>
                            <td class="px-4 py-3 max-w-xs truncate">{{ $req->description }}</td>
                            <td class="px-4 py-3 text-right font-semibold">
                                {{ number_format($req->requested_amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-center text-gray-400 text-xs">
                                {{ $req->request_date?->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('approval.show', $req) }}"
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs">
                                    ກວດສອບ
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                ✅ ບໍ່ມີລາຍການທີ່ຕ້ອງດຳເນີນການ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($requests instanceof \Illuminate\Pagination\LengthAwarePaginator && $requests->hasPages())
                <div class="px-4 py-3 border-t">{{ $requests->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

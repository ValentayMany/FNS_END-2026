<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">🧾 ສົ່ງໃບສະສາງ (Clearing)</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">✅ {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">❌ {{ session('error') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-5 py-4 border-b">
                    <h3 class="font-semibold text-gray-800">📋 ລາຍການທີ່ຕ້ອງສະສາງ</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">ຜູ້ຂໍ</th>
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
                                <td class="px-4 py-3">{{ $req->description }}</td>
                                <td class="px-4 py-3 text-right font-semibold">
                                    {{ number_format($req->requested_amount, 2) }}
                                </td>
                                <td class="px-4 py-3 text-center text-gray-400 text-xs">
                                    {{ $req->request_date?->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if (Auth::user()->isAccountant())
                                        {{-- Accountant ยืนยัน Clearing --}}
                                        <form method="POST" action="{{ route('clearing.confirm', $req) }}">
                                            @csrf
                                            <button type="submit"
                                                style="background:#0891b2;color:white;padding:4px 12px;border-radius:4px;font-size:12px;border:none;cursor:pointer;">
                                                ✅ ຢືນຢັນ
                                            </button>
                                        </form>
                                    @else
                                        {{-- Requester ส่ง Clearing --}}
                                        <form method="POST" action="{{ route('clearing.submit', $req) }}">
                                            @csrf
                                            <button type="submit"
                                                style="background:#ea580c;color:white;padding:4px 12px;border-radius:4px;font-size:12px;border:none;cursor:pointer;">
                                                🧾 ສົ່ງສະສາງ
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                    ✅ ບໍ່ມີລາຍການທີ່ຕ້ອງສະສາງ
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

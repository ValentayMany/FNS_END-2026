<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">📊 ລາຍງານລາຍຮັບ-ລາຍຈ່າຍ</h2>
            <div class="flex items-center gap-2 no-print">
                <a href="{{ route('reports.export', request()->only('type','date','month')) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition">
                    📥 Export CSV
                </a>
                <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition">
                    🖨️ ພິມລາຍງານ
                </button>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            nav, header { display: none !important; }
            body { background: white !important; }
            table { border-collapse: collapse; width: 100%; font-size: 11px; }
            th, td { border: 1px solid #d1d5db; padding: 5px 8px; }
            thead { background-color: #f3f4f6 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .page-section { page-break-inside: avoid; margin-bottom: 20px; }
            .grand-total { border: 2px solid #374151; padding: 12px; margin-top: 16px; }
        }
        @media screen {
            .print-only { display: none; }
        }
    </style>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 space-y-5">

            {{-- หัวรายงาน (เฉพาะพิมพ์) --}}
            <div class="print-only">
                <div style="text-align:center; border-bottom:2px solid #1f2937; padding-bottom:12px; margin-bottom:16px;">
                    <p style="font-size:13px; font-weight:600; margin:0;">ມະຫາວິທະຍາໄລແຫ່ງຊາດ — ຄະນະ</p>
                    <h1 style="font-size:17px; font-weight:700; margin:6px 0;">ລາຍງານລາຍຮັບ-ລາຍຈ່າຍ</h1>
                    <p style="font-size:11px; color:#6b7280; margin:0;">
                        @if($type === 'daily')
                            ວັນທີ: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                        @else
                            ເດືອນ: {{ \Carbon\Carbon::parse($month . '-01')->format('m/Y') }}
                        @endif
                        &nbsp;|&nbsp; ພິມວັນທີ: {{ now()->format('d/m/Y H:i') }}
                    </p>
                </div>
                <div style="display:flex; gap:12px; margin-bottom:16px;">
                    <div style="flex:1; border:1px solid #d1d5db; padding:8px; text-align:center;">
                        <div style="font-size:10px; color:#6b7280;">ລາຍຮັບລວມ</div>
                        <div style="font-size:15px; font-weight:700; color:#16a34a;">{{ number_format($totalIncome, 2) }} ກີບ</div>
                    </div>
                    <div style="flex:1; border:1px solid #d1d5db; padding:8px; text-align:center;">
                        <div style="font-size:10px; color:#6b7280;">ລາຍຈ່າຍລວມ</div>
                        <div style="font-size:15px; font-weight:700; color:#dc2626;">{{ number_format($totalExpense, 2) }} ກີບ</div>
                    </div>
                    <div style="flex:1; border:1px solid #d1d5db; padding:8px; text-align:center;">
                        <div style="font-size:10px; color:#6b7280;">ຍອດສຸດທິ</div>
                        <div style="font-size:15px; font-weight:700; color:{{ ($totalIncome - $totalExpense) >= 0 ? '#4f46e5' : '#dc2626' }};">
                            {{ number_format($totalIncome - $totalExpense, 2) }} ກີບ
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter (ซ่อนตอนพิมพ์) --}}
            <div class="bg-white rounded-xl shadow p-5 no-print">
                <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">ປະເພດລາຍງານ</label>
                        <select name="type" onchange="this.form.submit()"
                            class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="daily"   {{ $type === 'daily'   ? 'selected' : '' }}>ປະຈຳວັນ</option>
                            <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>ປະຈຳເດືອນ</option>
                        </select>
                    </div>
                    @if($type === 'daily')
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">ວັນທີ</label>
                        <input type="date" name="date" value="{{ $date }}"
                            class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    @else
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">ເດືອນ</label>
                        <input type="month" name="month" value="{{ $month }}"
                            class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    @endif
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm">
                        🔍 ຄົ້ນຫາ
                    </button>
                </form>
            </div>

            {{-- Summary Cards (ซ่อนตอนพิมพ์) --}}
            <div class="grid grid-cols-3 gap-4 no-print">
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-gray-400 text-sm mb-1">ລາຍຮັບລວມ</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($totalIncome, 2) }}</p>
                    <p class="text-xs text-gray-400">ກີບ</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-gray-400 text-sm mb-1">ລາຍຈ່າຍລວມ</p>
                    <p class="text-2xl font-bold text-red-600">{{ number_format($totalExpense, 2) }}</p>
                    <p class="text-xs text-gray-400">ກີບ</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5 text-center">
                    <p class="text-gray-400 text-sm mb-1">ຍອດສຸດທິ</p>
                    <p class="text-2xl font-bold {{ ($totalIncome - $totalExpense) >= 0 ? 'text-indigo-600' : 'text-red-600' }}">
                        {{ number_format($totalIncome - $totalExpense, 2) }}
                    </p>
                    <p class="text-xs text-gray-400">ກີບ</p>
                </div>
            </div>

            {{-- ລາຍຮັບ --}}
            <div class="bg-white rounded-xl shadow overflow-hidden page-section">
                <div class="px-5 py-4 border-b bg-green-50">
                    <h3 class="font-semibold text-green-700">📥 ລາຍຮັບ</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">ວັນທີ</th>
                            <th class="px-4 py-3 text-left">ປະເພດ</th>
                            <th class="px-4 py-3 text-left">ລາຍລະອຽດ</th>
                            <th class="px-4 py-3 text-left">ພາກສ່ວນ</th>
                            <th class="px-4 py-3 text-right">ຈຳນວນ (ກີບ)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($incomeTransactions as $txn)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">
                                {{ $txn->transaction_date?->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block bg-indigo-50 text-indigo-700 text-xs px-2 py-0.5 rounded-full">
                                    {{ $txn->category ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $txn->description }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $txn->department?->department_name }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-green-600">
                                {{ number_format($txn->amount, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-400">ບໍ່ມີລາຍຮັບ</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($incomeTransactions->count() > 0)
                    <tfoot class="bg-green-50 font-semibold text-sm">
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-right text-green-700">ລວມລາຍຮັບ</td>
                            <td class="px-4 py-3 text-right text-green-700">{{ number_format($totalIncome, 2) }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            {{-- ລາຍຈ່າຍທົ່ວໄປ --}}
            <div class="bg-white rounded-xl shadow overflow-hidden page-section">
                <div class="px-5 py-4 border-b bg-orange-50">
                    <h3 class="font-semibold text-orange-700">📝 ລາຍຈ່າຍທົ່ວໄປ (ນັກບັນຊີບັນທຶກ)</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">ວັນທີ</th>
                            <th class="px-4 py-3 text-left">ປະເພດ</th>
                            <th class="px-4 py-3 text-left">ລາຍລະອຽດ</th>
                            <th class="px-4 py-3 text-left">ພາກສ່ວນ</th>
                            <th class="px-4 py-3 text-right">ຈຳນວນ (ກີບ)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($expenseTransactions as $txn)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">
                                {{ $txn->transaction_date?->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block bg-red-50 text-red-700 text-xs px-2 py-0.5 rounded-full">
                                    {{ $txn->category ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $txn->description }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $txn->department?->department_name }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-orange-600">
                                {{ number_format($txn->amount, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-400">ບໍ່ມີລາຍຈ່າຍ</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($expenseTransactions->count() > 0)
                    <tfoot class="bg-orange-50 font-semibold text-sm">
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-right text-orange-700">ລວມລາຍຈ່າຍທົ່ວໄປ</td>
                            <td class="px-4 py-3 text-right text-orange-700">
                                {{ number_format($expenseTransactions->sum('amount'), 2) }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            {{-- ລາຍຈ່າຍເງິນສົດ --}}
            <div class="bg-white rounded-xl shadow overflow-hidden page-section">
                <div class="px-5 py-4 border-b bg-red-50">
                    <h3 class="font-semibold text-red-700">💵 ລາຍຈ່າຍເງິນສົດ (ການເບີກຈ່າຍ)</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">ວັນທີ</th>
                            <th class="px-4 py-3 text-left">ຜູ້ຂໍ</th>
                            <th class="px-4 py-3 text-left">ລາຍລະອຽດ</th>
                            <th class="px-4 py-3 text-left">ພາກສ່ວນ</th>
                            <th class="px-4 py-3 text-right">ຈຳນວນ (ກີບ)</th>
                            <th class="px-4 py-3 text-center">ສະຖານະ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($requests as $req)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">
                                {{ $req->request_date?->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $req->requester?->full_name ?? $req->requester?->username }}
                            </td>
                            <td class="px-4 py-3">{{ $req->description }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $req->department?->department_name }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-red-600">
                                {{ number_format($req->requested_amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-0.5 rounded text-xs
                                    {{ $req->status === 'cleared' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $req->status === 'cleared' ? 'ສະສາງແລ້ວ' : 'ຈ່າຍແລ້ວ' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400">ບໍ່ມີລາຍຈ່າຍ</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($requests->count() > 0)
                    <tfoot class="bg-red-50 font-semibold text-sm">
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-right text-red-700">ລວມລາຍຈ່າຍເງິນສົດ</td>
                            <td class="px-4 py-3 text-right text-red-700">
                                {{ number_format($requests->sum('requested_amount'), 2) }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            {{-- Grand Total --}}
            <div class="bg-gray-800 text-white rounded-xl shadow p-5 page-section grand-total">
                <div class="grid grid-cols-3 gap-6 text-center">
                    <div>
                        <p class="text-gray-400 text-xs mb-1">ລາຍຮັບລວມທັງໝົດ</p>
                        <p class="text-xl font-bold text-green-400">{{ number_format($totalIncome, 2) }} ກີບ</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">ລາຍຈ່າຍລວມທັງໝົດ</p>
                        <p class="text-xl font-bold text-red-400">{{ number_format($totalExpense, 2) }} ກີບ</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">ຍອດຄົງເຫຼືອ</p>
                        <p class="text-xl font-bold {{ ($totalIncome - $totalExpense) >= 0 ? 'text-indigo-400' : 'text-red-400' }}">
                            {{ number_format($totalIncome - $totalExpense, 2) }} ກີບ
                        </p>
                    </div>
                </div>
            </div>

            {{-- ลายเซ็น (เฉพาะพิมพ์) --}}
            <div class="print-only" style="margin-top:48px;">
                <div style="display:flex; justify-content:space-between; font-size:12px;">
                    <div style="text-align:center; width:180px;">
                        <div style="margin-top:48px; border-top:1px solid #374151; padding-top:4px;">ຜູ້ສ້າງລາຍງານ</div>
                    </div>
                    <div style="text-align:center; width:180px;">
                        <div style="margin-top:48px; border-top:1px solid #374151; padding-top:4px;">ຫົວໜ້າການເງິນ</div>
                    </div>
                    <div style="text-align:center; width:180px;">
                        <div style="margin-top:48px; border-top:1px solid #374151; padding-top:4px;">ຫົວໜ້າຄະນະ</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

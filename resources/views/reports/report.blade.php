<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;700&display=swap');
        
        body { font-family: 'Noto Sans Lao', sans-serif; }

        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white !important; margin: 0; padding: 0; }
            .report-card { border: none !important; box-shadow: none !important; }
            .rpt-table { width: 100% !important; border-collapse: collapse !important; border: 1px solid black !important; }
            .rpt-table th, .rpt-table td { border: 1px solid black !important; padding: 5px 8px !important; color: black !important; font-size: 12px !important; }
            .rpt-table thead th { background: #f3f4f6 !important; -webkit-print-color-adjust: exact; }
            
            .print-header { text-align: center; margin-bottom: 20px; }
            .print-header .doc-type { font-size: 11px; margin-bottom: 4px; }
            .print-header .title { font-size: 18px; font-weight: bold; margin: 0 0 4px 0; }
            .print-header .dept { font-size: 14px; margin-top: 0; }
            
            .meta-grid { display: flex; justify-content: space-between; margin-top: 20px; margin-bottom: 20px; font-size: 13px; }
            .meta-left p, .meta-right p { margin: 2px 0; }
            
            .print-footer { margin-top: 40px; }
            .sig-row { display: flex; justify-content: space-between; text-align: center; font-size: 13px; margin-top: 30px; }
            .sig-box { width: 40%; }
        }

        /* Screen only */
        .print-only { display: none; }
    </style>

    <div class="py-8 no-print bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <div>
                    <p class="text-[#6366f1] text-sm font-medium mb-1">ລາຍງານ</p>
                    <h1 class="text-2xl font-bold text-slate-800">ລາຍງານສະຫຼຸບລາຍຮັບ - ລายຈ่าย</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('reports.export', request()->all()) }}" class="inline-flex items-center justify-center px-4 py-2 bg-[#6366f1] text-white text-sm font-medium rounded-lg hover:bg-indigo-600 transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Export Excel
                    </a>
                    <button onclick="window.print()" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        ພິມລາຍງານ
                    </button>
                </div>
            </div>

            {{-- Filter Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-6">
                <form method="GET" action="{{ route('reports.index') }}">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[13px] font-medium text-slate-500 mb-1.5">ປະເພດລາຍງານ</label>
                            <select name="type" class="w-full rounded-lg border-slate-200 text-sm py-2.5 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" onchange="this.form.submit()">
                                <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>ປະຈຳວັນ</option>
                                <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>ປະຈຳເດືອນ</option>
                                <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>ປະຈຳປີ</option>
                            </select>
                        </div>

                        <div>
                            @if($type === 'daily')
                                <label class="block text-[13px] font-medium text-slate-500 mb-1.5">ວັນທີ</label>
                                <input type="date" name="date" value="{{ $date }}" class="w-full rounded-lg border-slate-200 text-sm py-2.5 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                            @elseif($type === 'monthly')
                                <label class="block text-[13px] font-medium text-slate-500 mb-1.5">ເດືອນ</label>
                                <input type="month" name="month" value="{{ $month }}" class="w-full rounded-lg border-slate-200 text-sm py-2.5 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                            @else
                                <label class="block text-[13px] font-medium text-slate-500 mb-1.5">ປີ</label>
                                <select name="year" class="w-full rounded-lg border-slate-200 text-sm py-2.5 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                    @for($y = date('Y') - 5; $y <= date('Y') + 2; $y++)
                                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            @endif
                        </div>

                        <div>
                            <label class="block text-[13px] font-medium text-slate-500 mb-1.5">ພາກສ່ວນ</label>
                            <select name="department_id" class="w-full rounded-lg border-slate-200 text-sm py-2.5 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                <option value="">-- ທັງໝົດ --</option>
                                @foreach(\App\Models\Department::all() as $dept)
                                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->department_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[13px] font-medium text-slate-500 mb-1.5">ແນວບັນຊີ</label>
                            <select name="account_id" class="w-full rounded-lg border-slate-200 text-sm py-2.5 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                <option value="">-- ທັງໝົດ --</option>
                                @foreach(\App\Models\ChartOfAccount::all() as $acc)
                                    <option value="{{ $acc->id }}" {{ request('account_id') == $acc->id ? 'selected' : '' }}>{{ $acc->account_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-[#6366f1] text-white font-medium rounded-lg py-2.5 mt-2 hover:bg-indigo-600 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            ສະແດງ
                        </button>
                    </div>
                </form>
            </div>

            {{-- Table Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800 text-sm">ລາຍການເຄື່ອນໄຫວ (Ledger)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="py-4 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider text-center w-16">ລຳດັບ</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">ເນື້ອໃນລາຍຮັບ-ລາຍຈ່າຍ</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider text-center w-36">ວັນທີ-ເດືອນ-ປີ</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider text-center w-36">ລາຍຮັບ</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider text-center w-36">ລາຍຈ່າຍ</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider text-center w-36">ດຸ່ນດ່ຽງ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @php $balance = 0; @endphp
                            @forelse($ledger as $index => $item)
                                @php $balance += ($item->amount_in - $item->amount_out); @endphp
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 text-center text-sm text-slate-500">{{ $index + 1 }}</td>
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-slate-800 text-sm mb-1">{{ $item->desc }}</div>
                                        <div class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-[#ecfdf5] text-[#059669]">
                                            {{ $item->department ?? 'ທົ່ວໄປ' }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center text-sm text-slate-600">{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                    <td class="py-4 px-6 text-center font-bold text-[#059669] text-sm">{{ $item->amount_in > 0 ? number_format($item->amount_in, 0) : '' }}</td>
                                    <td class="py-4 px-6 text-center font-bold text-slate-800 text-sm">{{ $item->amount_out > 0 ? number_format($item->amount_out, 0) : '' }}</td>
                                    <td class="py-4 px-6 text-center font-bold text-[#6366f1] text-sm">{{ number_format($balance, 0) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400 text-sm">ບໍ່ພົບຂໍ້ມູນລາຍການເຄື່ອນໄຫວ</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($ledger->count() > 0)
                            <tfoot class="border-t border-slate-100">
                                <tr>
                                    <td colspan="3" class="py-5 px-6 text-center font-bold text-slate-800 text-sm">ລວມທັງໝົດ</td>
                                    <td class="py-5 px-6 text-center font-bold text-[#059669] text-sm">{{ number_format($totalIncome, 0) }}</td>
                                    <td class="py-5 px-6 text-center font-bold text-slate-800 text-sm">{{ number_format($totalExpense, 0) }}</td>
                                    <td class="py-5 px-6 text-center font-bold text-[#6366f1] text-sm">{{ number_format($totalIncome - $totalExpense, 0) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col items-center justify-center text-center">
                    <p class="text-[13px] font-medium text-slate-400 mb-2">ລາຍຮັບລວມທັງໝົດ</p>
                    <p class="text-xl font-bold text-[#059669]">{{ number_format($totalIncome, 0) }} ກີບ</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col items-center justify-center text-center">
                    <p class="text-[13px] font-medium text-slate-400 mb-2">ລາຍຈ່າຍລວມທັງໝົດ</p>
                    <p class="text-xl font-bold text-[#dc2626]">{{ number_format($totalExpense, 0) }} ກີບ</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col items-center justify-center text-center">
                    <p class="text-[13px] font-medium text-slate-400 mb-2">ຍອດເຫຼືອ (ສຸດທິ)</p>
                    <p class="text-xl font-bold text-[#059669]">{{ number_format($totalIncome - $totalExpense, 0) }} ກີບ</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Print View ── --}}
    <div class="print-only p-8">
        <div class="print-header">
            <p class="doc-type">ໃບບິນຈ່າຍເງິນ</p>
            <h1 class="title">ລາຍງານສະຫຼຸບລາຍຮັບ - ລາຍຈ່າຍລວມ</h1>
            <p class="dept">
                @php
                    $deptObj = \App\Models\Department::find(request('department_id'));
                @endphp
                (ພາກສ່ວນ: {{ $deptObj ? $deptObj->department_name : 'ທັງໝົດ' }})
            </p>
        </div>

        <div class="meta-grid">
            <div class="meta-left">
                <p>ປະເພດລາຍງານ:&nbsp; {{ $type === 'daily' ? 'ປະຈຳວັນ' : ($type === 'monthly' ? 'ປະຈຳເດືອນ' : 'ປະຈຳປີ') }}</p>
                <p>ຊ່ວງເວລາ:&nbsp;
                    @if($type === 'daily') {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}
                    @elseif($type === 'monthly') {{ \Carbon\Carbon::parse($month . '-01')->format('m-Y') }}
                    @else {{ $year }}
                    @endif
                </p>
            </div>
            <div class="meta-right" style="text-align: right;">
                <p>ລາຍຮັບລວມ: &nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($totalIncome, 0) }}</p>
                <p>ລາຍຈ່າຍລວມ: &nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($totalExpense, 0) }}</p>
                <p>ຍອດຄົງເຫຼືອ: &nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($totalIncome - $totalExpense, 0) }}</p>
            </div>
        </div>

        <table class="rpt-table">
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center;">ລຳດັບ</th>
                    <th>ເນື້ອໃນລາຍຮັບ-ລາຍຈ່າຍ</th>
                    <th style="width: 100px; text-align: center;">ວັນທີ-ເດືອນ-ປີ</th>
                    <th style="width: 100px; text-align: right;">ລາຍຮັບ</th>
                    <th style="width: 100px; text-align: right;">ລາຍຈ່າຍ</th>
                    <th style="width: 100px; text-align: right;">ດຸ່ນດ່ຽງ</th>
                </tr>
            </thead>
            <tbody>
                @php $p_bal = 0; @endphp
                @foreach($ledger as $idx => $item)
                    @php $p_bal += ($item->amount_in - $item->amount_out); @endphp
                    <tr>
                        <td style="text-align: center;">{{ $idx + 1 }}</td>
                        <td>
                            <div>{{ $item->desc }}</div>
                            <div style="font-size: 10px;">({{ $item->department ?? 'ທົ່ວໄປ' }})</div>
                        </td>
                        <td style="text-align: center;">{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                        <td style="text-align: right;">{{ $item->amount_in > 0 ? number_format($item->amount_in, 0) : '' }}</td>
                        <td style="text-align: right;">{{ $item->amount_out > 0 ? number_format($item->amount_out, 0) : '' }}</td>
                        <td style="text-align: right;">{{ number_format($p_bal, 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="font-weight: bold; background: #f3f4f6;">
                    <td colspan="3" style="text-align: center;">ລວມທັງໝົດ</td>
                    <td style="text-align: right;">{{ number_format($totalIncome, 0) }}</td>
                    <td style="text-align: right;">{{ number_format($totalExpense, 0) }}</td>
                    <td style="text-align: right;">{{ number_format($totalIncome - $totalExpense, 0) }}</td>
                </tr>
            </tfoot>
        </table>

        <div style="text-align: right; font-size: 11px; margin-top: 10px;">
            ວັນທີ: {{ now()->format('d-m-Y') }}
        </div>

        <div class="sig-row">
            <div class="sig-box">
                <p style="font-weight: bold;">ຫົວໜ້າພະແนກການເງິນ-ຊັບສິນ</p>
                <div style="margin-top: 60px;">..........................................</div>
            </div>
            <div class="sig-box">
                <p style="font-weight: bold;">ນາຍບັນຊີ</p>
                <div style="margin-top: 60px;">..........................................</div>
            </div>
        </div>
    </div>
</x-app-layout>
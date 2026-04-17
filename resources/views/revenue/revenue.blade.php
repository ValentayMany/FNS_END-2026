<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-semibold text-[#1e3a5f] uppercase tracking-widest">ລາຍຮັບ</p>
            <h2 class="text-xl font-bold text-gray-800">ບັນທຶກລາຍຮັບ</h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700&display=swap');

        .revenue-page {
            font-family: 'Noto Sans Lao', sans-serif;
        }

        @keyframes revSlideUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes revFadeRow {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .revenue-outer {
            min-height: calc(100vh - 80px);
            background: #f0f4f8;
            padding: 2rem 1rem;
        }

        .revenue-page .rev-form-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.04);
            animation: revSlideUp 0.45s ease both;
        }

        .revenue-page .rev-form-head {
            background: linear-gradient(135deg, #0f2744 0%, #1e3a5f 60%, #1a4a7a 100%);
            padding: 20px 24px;
            position: relative;
            overflow: hidden;
        }

        .revenue-page .rev-form-head::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(240, 180, 41, 0.08);
        }

        .revenue-page .rev-form-head h3 {
            position: relative;
            margin: 0;
            color: #fff;
            font-size: 1rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .revenue-page .rev-form-head .head-icon {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: rgba(240, 180, 41, 0.14);
            border: 1px solid rgba(240, 180, 41, 0.22);
            color: #f0b429;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .revenue-page .rev-form-head .head-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        .revenue-page .rev-form-head .sub {
            position: relative;
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.78rem;
            margin-top: 6px;
        }

        .revenue-page .rev-form-body {
            padding: 24px;
        }

        .revenue-page .rev-field-label {
            display: block;
            font-size: 0.68rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .revenue-page .rev-input,
        .revenue-page select.rev-select,
        .revenue-page textarea.rev-textarea {
            width: 100%;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            font-size: 0.88rem;
            font-family: 'Noto Sans Lao', sans-serif;
            color: #0f172a;
            background: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .revenue-page select.rev-select {
            appearance: auto;
        }

        .revenue-page .rev-input:focus,
        .revenue-page select.rev-select:focus,
        .revenue-page textarea.rev-textarea:focus {
            outline: none;
            border-color: #1e3a5f;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.12);
        }

        .revenue-page .rev-btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.88rem;
            font-family: 'Noto Sans Lao', sans-serif;
            color: #0f2744;
            background: linear-gradient(135deg, #f0d078 0%, #f0b429 50%, #d9a008 100%);
            border: 1px solid rgba(15, 39, 68, 0.1);
            box-shadow: 0 2px 12px rgba(240, 180, 41, 0.35);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .revenue-page .rev-btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(240, 180, 41, 0.45);
        }

        .revenue-page .rev-table-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06), 0 8px 32px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
            animation: revSlideUp 0.5s 0.08s ease both;
        }

        .revenue-page .rev-table-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 100%);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .revenue-page .rev-table-head-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .revenue-page .rev-table-head-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        .revenue-page .rev-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 0.875rem;
        }

        .revenue-page .rev-table thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        .revenue-page .rev-table thead th.th-amt {
            text-align: right;
        }

        .revenue-page .rev-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }

        .revenue-page .rev-table tbody tr {
            animation: revFadeRow 0.35s ease both;
        }

        .revenue-page .rev-table tbody tr:hover {
            background: #f8faff;
        }

        .revenue-page .rev-table tbody tr:last-child td {
            border-bottom: none;
        }

        .revenue-page .rev-cat-pill {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(30, 58, 95, 0.08);
            color: #1e3a5f;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .revenue-page .rev-amt-cell {
            font-weight: 700;
            color: #15803d;
            text-align: right;
            white-space: nowrap;
        }

        .revenue-page .rev-empty {
            padding: 48px 24px;
            text-align: center;
            color: #94a3b8;
        }

        .revenue-page .rev-empty svg {
            width: 44px;
            height: 44px;
            margin: 0 auto 10px;
            opacity: 0.45;
            color: #1e3a5f;
        }

        @media (max-width: 640px) {
            .revenue-outer {
                padding: 1rem 0.75rem;
            }

            .revenue-page .rev-form-body {
                padding: 18px 16px;
            }

            .revenue-page .rev-form-head {
                padding: 16px 18px;
            }

            .revenue-page .rev-table-header {
                padding: 14px 16px;
            }

            .revenue-page .rev-table {
                min-width: 36rem;
            }

            .revenue-page .rev-table thead th,
            .revenue-page .rev-table tbody td {
                padding: 12px 12px;
            }
        }

        @media (min-width: 641px) and (max-width: 1024px) {
            .revenue-outer {
                padding: 1.5rem 1.25rem;
            }
        }
    </style>

    <div class="revenue-outer revenue-page w-full min-w-0 max-w-full">
        <div class="max-w-3xl mx-auto w-full min-w-0 px-3 sm:px-4 space-y-5 sm:space-y-6">

            @if (session('success'))
                <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium"
                    style="animation: revSlideUp 0.4s ease both;">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="rev-form-card">
                <div class="rev-form-head">
                    <h3>
                        <span class="head-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v4.125c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 013 17.25v-4.125zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125v-8.25zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v12.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </span>
                        ບັນທຶກລາຍຮັບໃໝ່
                    </h3>
                    <p class="sub">ກອກຂໍ້ມູນລາຍຮັບ ແລະ ບັນທຶກລົງລະບົບ</p>
                </div>
                <div class="rev-form-body">
                    <form method="POST" action="{{ route('revenue.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <x-input-label for="transaction_date" value="ວັນທີ *"
                                class="rev-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <x-text-input id="transaction_date" name="transaction_date" type="date"
                                class="rev-input mt-1 block w-full border-gray-200" :value="old('transaction_date', today()->toDateString())" required />
                            <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="category" value="ປະເພດລາຍຮັບ *"
                                class="rev-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <select id="category" name="category" required class="rev-select mt-1">
                                <option value="">-- ເລືອກປະເພດລາຍຮັບ --</option>
                                <option value="ຄ່າບຳລຸງຫ້ອງທົດລອງ"
                                    {{ old('category') == 'ຄ່າບຳລຸງຫ້ອງທົດລອງ' ? 'selected' : '' }}>
                                    ຄ່າບຳລຸງຫ້ອງທົດລອງ
                                </option>
                                <option value="ຄ່າລົງທະບຽນປະລິນຍາຕີ"
                                    {{ old('category') == 'ຄ່າລົງທະບຽນປະລິນຍາຕີ' ? 'selected' : '' }}>
                                    ຄ່າລົງທະບຽນປະລິນຍາຕີ
                                </option>
                                <option value="ຄ່າຮັກສາສະຖານະພາບ"
                                    {{ old('category') == 'ຄ່າຮັກສາສະຖານະພາບ' ? 'selected' : '' }}>
                                    ຄ່າຮັກສາສະຖານະພາບ
                                </option>
                                <option value="ຄ່າໜ່ວຍກິດປະລິນຍາຕີ"
                                    {{ old('category') == 'ຄ່າໜ່ວຍກິດປະລິນຍາຕີ' ? 'selected' : '' }}>
                                    ຄ່າໜ່ວຍກິດປະລິນຍາຕີ
                                </option>
                                <option value="ຄ່າໜ່ວຍກິດປະລິນຍາໂທ"
                                    {{ old('category') == 'ຄ່າໜ່ວຍກິດປະລິນຍາໂທ' ? 'selected' : '' }}>
                                    ຄ່າໜ່ວຍກິດປະລິນຍາໂທ
                                </option>
                                <option value="ຄ່າລົງທະບຽນອັບເກຣດ"
                                    {{ old('category') == 'ຄ່າລົງທະບຽນອັບເກຣດ' ? 'selected' : '' }}>
                                    ຄ່າລົງທະບຽນອັບເກຣດ
                                </option>
                                <option value="ຄ່າບໍລິການວິຊາການ"
                                    {{ old('category') == 'ຄ່າບໍລິການວິຊາການ' ? 'selected' : '' }}>
                                    ຄ່າບໍລິການວິຊາການ
                                </option>
                                <option value="ແຫຼ່ງລາຍຮັບອື່ນໆ"
                                    {{ old('category') == 'ແຫຼ່ງລາຍຮັບອື່ນໆ' ? 'selected' : '' }}>
                                    ແຫຼ່ງລາຍຮັບອື່ນໆ (ຖ້າມີ)
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" value="ລາຍລະອຽດ *"
                                class="rev-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <textarea id="description" name="description" rows="3" required
                                class="rev-textarea mt-1">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="amount" value="ຈຳນວນເງິນ (ກີບ) *"
                                class="rev-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <x-text-input id="amount" name="amount" type="number" class="rev-input mt-1 block w-full"
                                min="1" step="0.01" :value="old('amount')" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="account_id" value="ໝວດບັນຊີ *"
                                class="rev-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <select id="account_id" name="account_id" required class="rev-select mt-1">
                                <option value="">-- ເລືອກໝວດບັນຊີ --</option>
                                @foreach ($accounts as $acc)
                                    <option value="{{ $acc->id }}"
                                        {{ old('account_id') == $acc->id ? 'selected' : '' }}>
                                        {{ $acc->account_code }} - {{ $acc->account_name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('account_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="department_id" value="ພາກສ່ວນ *"
                                class="rev-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <select id="department_id" name="department_id" required class="rev-select mt-1">
                                <option value="">-- ເລືອກພາກສ່ວນ --</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->displayName() }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                        </div>

                        <button type="submit" class="rev-btn-save w-full sm:w-auto min-h-[44px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l3 3m0 0l3-3m-3 3V4" />
                            </svg>
                            ບັນທຶກລາຍຮັບ
                        </button>
                    </form>
                </div>
            </div>

            <div class="rev-table-card">
                <div class="rev-table-header">
                    <div class="flex items-center gap-3">
                        <div class="rev-table-head-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">ລາຍການລ່າສຸດ</p>
                            <p class="text-blue-200/90 text-xs mt-0.5">ປະຫວັດລາຍຮັບທີ່ບັນທຶກແລ້ວ</p>
                        </div>
                    </div>
                    <div class="rounded-full px-3 py-1 bg-white/10 ring-1 ring-white/15">
                        <span class="text-white text-xs font-semibold">
                            {{ $transactions->total() }}
                            ລາຍການ
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto -mx-px touch-pan-x">
                    <table class="rev-table">
                        <thead>
                            <tr>
                                <th>ວັນທີ</th>
                                <th>ປະເພດລາຍຮັບ</th>
                                <th>ລາຍລະອຽດ</th>
                                <th class="th-amt">ຈຳນວນ (ກີບ)</th>
                                <th>ພາກສ່ວນ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $txn)
                                <tr>
                                    <td class="text-slate-500 text-xs font-semibold whitespace-nowrap">
                                        {{ $txn->transaction_date?->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <span class="rev-cat-pill" title="{{ $txn->category }}">{{ $txn->category ?? '—' }}</span>
                                    </td>
                                    <td class="text-slate-700">{{ $txn->description }}</td>
                                    <td class="rev-amt-cell">{{ number_format($txn->amount, 2) }}</td>
                                    <td class="text-slate-600">{{ $txn->department?->displayName() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="rev-empty">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v4.125c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 013 17.25v-4.125zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125v-8.25zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v12.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                            </svg>
                                            <p class="text-sm font-medium text-gray-500">ຍັງບໍ່ມີລາຍການ</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($transactions->hasPages())
                    <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/80">{{ $transactions->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

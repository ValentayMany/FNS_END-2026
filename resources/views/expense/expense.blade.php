<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-semibold text-[#1e3a5f] uppercase tracking-widest">ລາຍຈ່າຍ</p>
            <h2 class="text-xl font-bold text-gray-800">ບັນທຶກລາຍຈ່າຍ</h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;500;600;700&display=swap');

        .expense-page {
            font-family: 'Noto Sans Lao', sans-serif;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeRow {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .expense-outer {
            min-height: calc(100vh - 80px);
            background: #f0f4f8;
            padding: 2rem 1rem;
        }

        .exp-form-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.04);
            animation: slideUp 0.45s ease both;
        }

        .exp-form-head {
            background: linear-gradient(135deg, #0f2744 0%, #1e3a5f 60%, #1a4a7a 100%);
            padding: 20px 24px;
            position: relative;
            overflow: hidden;
        }

        .exp-form-head::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(240, 180, 41, 0.08);
        }

        .exp-form-head h3 {
            position: relative;
            margin: 0;
            color: #fff;
            font-size: 1rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .exp-form-head .head-icon {
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

        .exp-form-head .head-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        .exp-form-head .sub {
            position: relative;
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.78rem;
            margin-top: 6px;
        }

        .exp-form-body {
            padding: 24px;
        }

        .exp-field-label {
            display: block;
            font-size: 0.68rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .exp-input,
        .expense-page select.exp-select,
        .expense-page textarea.exp-textarea {
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

        .expense-page select.exp-select {
            appearance: auto;
        }

        .exp-input:focus,
        .expense-page select.exp-select:focus,
        .expense-page textarea.exp-textarea:focus {
            outline: none;
            border-color: #1e3a5f;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.12);
        }

        .exp-btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 12px;
            border: none;
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

        .exp-btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(240, 180, 41, 0.45);
        }

        .table-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06), 0 8px 32px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
            animation: slideUp 0.5s 0.08s ease both;
        }

        .table-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 100%);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            row-gap: 10px;
        }

        .table-head-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .table-head-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        .expense-page .exp-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 0.875rem;
        }

        .expense-page .exp-table thead th {
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

        .expense-page .exp-table thead th.th-amt {
            text-align: right;
        }

        .expense-page .exp-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }

        .expense-page .exp-table tbody tr {
            animation: fadeRow 0.35s ease both;
        }

        .expense-page .exp-table tbody tr:hover {
            background: #f8faff;
        }

        .expense-page .exp-table tbody tr:last-child td {
            border-bottom: none;
        }

        .cat-pill {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
            background: #fff7ed;
            color: #c2410c;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .amt-cell {
            font-weight: 700;
            color: #1e3a5f;
            text-align: right;
            white-space: nowrap;
        }

        .empty-state {
            padding: 48px 24px;
            text-align: center;
            color: #94a3b8;
        }

        .empty-state svg {
            width: 44px;
            height: 44px;
            margin: 0 auto 10px;
            opacity: 0.45;
            color: #1e3a5f;
        }

        @media (max-width: 640px) {
            .expense-outer {
                padding: 1rem 0.75rem;
            }

            .exp-form-body {
                padding: 18px 16px;
            }

            .exp-form-head {
                padding: 16px 18px;
            }

            .table-header {
                padding: 14px 16px;
                flex-wrap: wrap;
                gap: 12px;
            }

            .exp-table {
                min-width: 36rem;
            }

            .exp-table thead th,
            .exp-table tbody td {
                padding: 12px 12px;
            }
        }

        @media (min-width: 641px) and (max-width: 1024px) {
            .expense-outer {
                padding: 1.5rem 1.25rem;
            }
        }
    </style>

    <div class="expense-outer expense-page w-full min-w-0 max-w-full">
        <div class="max-w-3xl mx-auto w-full min-w-0 px-3 sm:px-4 space-y-5 sm:space-y-6">

            @if (session('success'))
                <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium"
                    style="animation: slideUp 0.4s ease both;">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium"
                    style="animation: slideUp 0.4s ease both;">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="exp-form-card">
                <div class="exp-form-head">
                    <h3>
                        <span class="head-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </span>
                        ບັນທຶກລາຍຈ່າຍໃໝ່
                    </h3>
                    <p class="sub">ກອກຂໍ້ມູນ ແລະ ບັນທຶກລົງລະບົບ</p>
                </div>
                <div class="exp-form-body">
                    <form method="POST" action="{{ route('expense.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <x-input-label for="transaction_date" value="ວັນທີ *" class="exp-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <x-text-input id="transaction_date" name="transaction_date" type="date"
                                class="exp-input mt-1 block w-full border-gray-200" :value="old('transaction_date', today()->toDateString())" required />
                            <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="category" value="ປະເພດລາຍຈ່າຍ *" class="exp-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <select id="category" name="category" required class="exp-select mt-1">
                                <option value="">-- ເລືອກປະເພດລາຍຈ່າຍ --</option>
                                <option value="ເງິນອຸດໜູນ ແລະ ນະໂຍບາຍ"
                                    {{ old('category') == 'ເງິນອຸດໜູນ ແລະ ນະໂຍບາຍ' ? 'selected' : '' }}>
                                    ເງິນອຸດໜູນ ແລະ ນະໂຍບາຍ
                                </option>
                                <option value="ການຊື້ ແລະ ການຊົມໃຊ້"
                                    {{ old('category') == 'ການຊື້ ແລະ ການຊົມໃຊ້' ? 'selected' : '' }}>
                                    ການຊື້ ແລະ ການຊົມໃຊ້
                                </option>
                                <option value="ການບໍລິການຈາກທາງນອກ"
                                    {{ old('category') == 'ການບໍລິການຈາກທາງນອກ' ? 'selected' : '' }}>
                                    ການບໍລິການຈາກທາງນອກ
                                </option>
                                <option value="ລາຍຈ່າຍກອງປະຊຸມ ສຳມະນາ ແລະ ຝຶກອົບຮົມ"
                                    {{ old('category') == 'ລາຍຈ່າຍກອງປະຊຸມ ສຳມະນາ ແລະ ຝຶກອົບຮົມ' ? 'selected' : '' }}>
                                    ລາຍຈ່າຍກອງປະຊຸມ ສຳມະນາ ແລະ ຝຶກອົບຮົມ
                                </option>
                                <option value="ດັດສົມ ແລະ ສົ່ງເສີມວັດທະນະທຳ - ສັງຄົມ"
                                    {{ old('category') == 'ດັດສົມ ແລະ ສົ່ງເສີມວັດທະນະທຳ - ສັງຄົມ' ? 'selected' : '' }}>
                                    ດັດສົມ ແລະ ສົ່ງເສີມວັດທະນະທຳ - ສັງຄົມ
                                </option>
                                <option value="ລາຍຈ່າຍບໍລິຫານປົກກະຕິອື່ນໆ"
                                    {{ old('category') == 'ລາຍຈ່າຍບໍລິຫານປົກກະຕິອື່ນໆ' ? 'selected' : '' }}>
                                    ລາຍຈ່າຍບໍລິຫານປົກກະຕິອື່ນໆ
                                </option>
                                <option value="ຊື້ຊັບສົມບັດຄົງທີ່"
                                    {{ old('category') == 'ຊື້ຊັບສົມບັດຄົງທີ່' ? 'selected' : '' }}>
                                    ຊື້ຊັບສົມບັດຄົງທີ່
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" value="ລາຍລະອຽດ *" class="exp-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <textarea id="description" name="description" rows="3" required
                                class="exp-textarea mt-1">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="amount" value="ຈຳນວນເງິນ (ກີບ) *" class="exp-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <x-text-input id="amount" name="amount" type="number" class="exp-input mt-1 block w-full"
                                min="1" step="0.01" :value="old('amount')" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="account_id" value="ໝວດບັນຊີ *" class="exp-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <select id="account_id" name="account_id" required class="exp-select mt-1">
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
                            <x-input-label for="department_id" value="ພາກສ່ວນ *" class="exp-field-label !text-[0.68rem] !font-bold !text-slate-500 !uppercase !tracking-wider" />
                            <select id="department_id" name="department_id" required class="exp-select mt-1">
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

                        <button type="submit" class="exp-btn-save w-full sm:w-auto min-h-[44px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l3 3m0 0l3-3m-3 3V4" />
                            </svg>
                            ບັນທຶກລາຍຈ່າຍ
                        </button>
                    </form>
                </div>
            </div>

            <div class="table-card">
                <div class="table-header">
                    <div class="flex items-center gap-3">
                        <div class="table-head-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">ລາຍການລ່າສຸດ</p>
                            <p class="text-blue-200/90 text-xs mt-0.5">ປະຫວັດລາຍຈ່າຍທີ່ບັນທຶກແລ້ວ</p>
                        </div>
                    </div>
                    <div class="rounded-full px-3 py-1 bg-white/10 ring-1 ring-white/15">
                        <span class="text-white text-xs font-semibold">
                            {{ $transactions instanceof \Illuminate\Pagination\LengthAwarePaginator ? $transactions->total() : count($transactions) }}
                            ລາຍການ
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto touch-pan-x">
                    <table class="exp-table">
                        <thead>
                            <tr>
                                <th>ວັນທີ</th>
                                <th>ປະເພດລາຍຈ່າຍ</th>
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
                                        <span class="cat-pill" title="{{ $txn->category }}">{{ $txn->category ?? '—' }}</span>
                                    </td>
                                    <td class="text-slate-700">{{ $txn->description }}</td>
                                    <td class="amt-cell">{{ number_format($txn->amount, 2) }}</td>
                                    <td class="text-slate-600">{{ $txn->department?->displayName() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-sm font-medium text-gray-500">ຍັງບໍ່ມີລາຍການ</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator && $transactions->hasPages())
                    <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/80">{{ $transactions->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

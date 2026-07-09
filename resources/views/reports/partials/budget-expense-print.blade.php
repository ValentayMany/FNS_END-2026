{{-- ໃບບິນຈ່າຍເງິນ / ຕິດຕາມລາຍຈ່າຍງົບປະມານ (ຮູปแบบເກົ່າ) --}}
@php
    $userRole = auth()->user()->role?->role_name;
    $slipTitle = ($userRole === 'revenue_officer') ? 'ໃບບິນຮັບເງິນ' : 'ໃບບິນຈ່າຍເງິນ';
    $accountId = $selectedAccountId ?? $report['account']?->id;
    $budgetTypeLabel = $accountId
        ? app(\App\Services\BudgetExpenseReportBuilder::class)->budgetTypeLabel($report['selectedYear'] ?? $selectedYear, (int) $accountId)
        : '';
    $rawCode = $report['account']?->account_code ?? '';
    $formattedCode = strlen($rawCode) === 8
        ? substr($rawCode, 0, 2).'.'.substr($rawCode, 2, 2).'.'.substr($rawCode, 4, 2).'.'.substr($rawCode, 6, 2)
        : $rawCode;

    // ---- Department: ໃຊ້ຂອງ report ກ່อน ຖ້າບໍ່ມີຈຶ່ງໃຊ້ $selectedDeptId ----
    $deptObj = ($report['department'] ?? null) ?: ($selectedDeptId ? \App\Models\Department::find($selectedDeptId) : null);
    $deptName  = $deptObj ? $deptObj->displayName() : '—';
    $deptCode  = $deptObj?->dept_code ?? '';
    $deptBudget = $deptObj?->budget_amount ?? null;

    $sigDate = $type === 'daily'
        ? \Carbon\Carbon::parse($date)->format('d-m-Y')
        : ($type === 'monthly'
            ? \Carbon\Carbon::parse($month.'-01')->format('d-m-Y')
            : now()->format('d-m-Y'));
@endphp


<div style="text-align: center; font-size: 10px; font-weight: bold; margin-bottom: 15px; text-decoration: underline; text-underline-offset: 2px;">
    {{ $slipTitle }}
</div>

<div style="text-align: center; margin-bottom: 25px;">
    <h1 style="font-size: 15px; font-weight: 800; color: #000; margin: 0 0 4px; line-height: 1.4;">
        ຕິດຕາມລາຍຈ່າຍງົບປະມານ {{ $report['account']?->account_name ?? '' }}
    </h1>
    @if($budgetTypeLabel)
        <p style="font-size: 11px; font-weight: bold; color: #000; margin: 0;">{{ $budgetTypeLabel }}</p>
    @endif
</div>

<div style="display: flex; justify-content: space-between; align-items: flex-start; font-size: 11px; color: #000; margin-bottom: 15px; line-height: 1.6;">
    <div style="width: 35%;">
        <p style="margin: 0;">ລະຫັດພາກ/ສ່ວນ: <b>{{ $deptCode ?: '—' }}</b></p>
        <p style="margin: 4px 0 0;">
            @if($userRole === 'revenue_officer')
                ເລກບັນຊີຈ່າຍ: <b>{{ $rawCode }}</b>
            @else
                ຊ່ອງງົບປະມານ: <b>{{ $formattedCode }}</b>
            @endif
        </p>
    </div>
    <div style="width: 30%; text-align: center; font-weight: bold; padding-top: 15px;">
        @if($deptCode)
            <span style="display:inline-block;background:#1e3a5f;color:#f0b429;font-size:9px;font-weight:800;padding:1px 7px;border-radius:4px;letter-spacing:0.05em;margin-right:4px;">{{ $deptCode }}</span>
        @endif
        {{ $deptName }}
        @if($deptBudget !== null)
            <br><span style="font-size:9px;font-weight:600;color:#555;">ງົບ: {{ number_format($deptBudget, 0, ',', '.') }} ₭</span>
        @endif
    </div>
    <div style="width: 35%; text-align: right;">
        <p style="margin: 0;">ຕົວເລກອະນຸມັດ: <b>{{ number_format($report['budget'], 0, ',', '.') }}</b></p>
        <p style="margin: 4px 0 0;">ຈ່າຍແລ້ວ: <b>{{ number_format($report['totalSpent'], 0, ',', '.') }}</b></p>
        <p style="margin: 4px 0 0;">ຍັງເຫຼືອ: <b>{{ number_format($report['remaining'], 0, ',', '.') }}</b></p>
    </div>
</div>

<table class="p-tbl">

    <thead>
        <tr style="font-weight: bold; background: #fff;">
            <th style="width: 45px; text-align: center; font-weight: bold; border: 1px solid #000 !important;">ລຳດັບ</th>
            <th style="text-align: left; font-weight: bold; border: 1px solid #000 !important;">ເນື້ອໃນລາຍຈ່າຍ</th>
            <th style="width: 110px; text-align: center; font-weight: bold; border: 1px solid #000 !important;">ວັນທີ-ເດືອນ-ປີ</th>
            <th style="width: 110px; text-align: right; font-weight: bold; border: 1px solid #000 !important;">ລາຍຈ່າຍ</th>
            <th style="width: 120px; text-align: right; font-weight: bold; border: 1px solid #000 !important;">ດຸ່ນດ່ຽງ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($report['transactions'] as $idx => $txn)
            @php
                $lineText = trim((string) ($txn->item_name ?? ''));
                if ($lineText === '') {
                    $lineText = trim((string) ($txn->description ?? ''));
                }
                $rowBalance = $txn->running_balance ?? 0;
                $txnDeptCode = $txn->department?->dept_code ?? '';
            @endphp
            <tr>
                <td style="text-align: center; border: 1px solid #000 !important;">{{ $idx + 1 }}</td>
                <td style="text-align: left; border: 1px solid #000 !important;">
                    @if($txnDeptCode)
                        <span style="font-weight:bold; color:#1e3a5f;">[{{ $txnDeptCode }}]</span>
                    @endif
                    {{ $lineText ?: '—' }}
                </td>
                <td style="text-align: center; border: 1px solid #000 !important;">{{ $txn->transaction_date?->format('d-m-Y') }}</td>
                <td style="text-align: right; border: 1px solid #000 !important;">{{ number_format($txn->amount, 0, ',', '.') }}</td>
                <td style="text-align: right; border: 1px solid #000 !important;">{{ number_format($rowBalance, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        @php
            $footerBalance = $report['transactions']->last()->running_balance ?? $report['remaining'];
        @endphp
        <tr style="font-weight: bold; background: #fff;">
            <td colspan="3" style="text-align: center; font-weight: bold; border: 1px solid #000 !important;">ລວມທັງໝົດ</td>
            <td style="text-align: right; font-weight: bold; border: 1px solid #000 !important;">{{ number_format($report['periodSpent'], 0, ',', '.') }}</td>
            <td style="text-align: right; font-weight: bold; border: 1px solid #000 !important;">{{ number_format($footerBalance, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>

<div style="display: flex; justify-content: space-between; margin-top: 50px; font-size: 11px; line-height: 1.6; page-break-inside: avoid;">
    <div style="width: 45%; text-align: left; font-weight: bold; padding-left: 10px;">
        ຫົວໜ້າພະແນກການເງິນ-ຊັບສິນ
    </div>
    <div style="width: 45%; text-align: right; font-weight: bold; padding-right: 10px;">
        <p style="margin: 0; padding-right: 15px;">ວັນທີ: {{ $sigDate }}</p>
        <p style="margin: 6px 0 0; padding-right: 25px;">ນາຍບັນຊີ</p>
    </div>
</div>

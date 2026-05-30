@php
    $deptId = request('department_id');
    $deptObj = $deptId ? \App\Models\Department::find($deptId) : null;
    $deptName = $deptObj ? $deptObj->displayName() : 'ພາກວິຊາວິທະຍາສາດຄອມພິວເຕີ';
    $sigDate = $type === 'daily' ? \Carbon\Carbon::parse($date)->format('d-m-Y') : now()->format('d-m-Y');
@endphp

<div style="display:flex; justify-content:space-between; font-size:11px; margin-bottom:14px;">
    <div>ຈຳນວນລາຍການ: <b>{{ $ledger->count() }}</b></div>
    <div style="font-weight:bold;">{{ $deptName }}</div>
    <div style="text-align:right;">
        @if($txnType !== 'expense')
            ລາຍຮັບລວມ: <b>{{ number_format($totalIncome, 0, ',', '.') }}</b>
        @endif
        @if($txnType !== 'income')
            ລາຍຈ່າຍລວມ: <b>{{ number_format($totalExpense, 0, ',', '.') }}</b>
        @endif
    </div>
</div>

<table class="p-tbl">
    <thead>
        <tr>
            <th style="width:40px; text-align:center; border:1px solid #000;">ລຳດັບ</th>
            <th style="border:1px solid #000;">ຊື່ລາຍການ</th>
            <th style="border:1px solid #000;">ລາຍລະອຽດ</th>
            <th style="width:85px; text-align:center; border:1px solid #000;">ວັນທີ</th>
            @if($txnType !== 'expense')
                <th style="width:100px; text-align:right; border:1px solid #000;">ລາຍຮັບ</th>
            @endif
            @if($txnType !== 'income')
                <th style="width:100px; text-align:right; border:1px solid #000;">ລາຍຈ່າຍ</th>
            @endif
            <th style="width:105px; text-align:right; border:1px solid #000;">ດຸ່ນດ່ຽງ</th>
        </tr>
    </thead>
    <tbody>
        @php $pb = 0; @endphp
        @foreach($ledger as $i => $item)
            @php $pb += ($item->amount_in - $item->amount_out); @endphp
            <tr>
                <td style="text-align:center; border:1px solid #000;">{{ $i + 1 }}</td>
                <td style="border:1px solid #000;">{{ $item->item_name ?? $item->desc ?? '—' }}</td>
                <td style="border:1px solid #000;">{{ $item->desc ?? '—' }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                @if($txnType !== 'expense')
                    <td style="text-align:right; border:1px solid #000;">{{ $item->amount_in > 0 ? number_format($item->amount_in, 0, ',', '.') : '' }}</td>
                @endif
                @if($txnType !== 'income')
                    <td style="text-align:right; border:1px solid #000;">{{ $item->amount_out > 0 ? number_format($item->amount_out, 0, ',', '.') : '' }}</td>
                @endif
                <td style="text-align:right; border:1px solid #000;">{{ number_format($pb, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="display:flex; justify-content:space-between; margin-top:45px; font-size:11px;">
    <div style="font-weight:bold;">ຫົວໜ້າພະແນກການເງິນ-ຊັບສິນ</div>
    <div style="text-align:right; font-weight:bold;">
        <p style="margin:0;">ວັນທີ: {{ $sigDate }}</p>
        <p style="margin:6px 0 0;">ນາຍບັນຊີ</p>
    </div>
</div>

@php
    // Define fixed categories in the exact order requested
    $categories = [
        'ຄ່າລົງທະບຽນ',
        'ຄ່າໜ່ວຍກິດ',
        'ປັບປຸງຫ້ອງແລັບ',
        'ຄ່າເທີມສາມ',
        'ຄ່າບໍລິການຕ່າງໆ',
    ];
    
    // Determine the title suffix
    $titleSuffix = $type === 'daily' ? 'ວັນທີ ' . \Carbon\Carbon::parse($date)->format('d-m-Y') : 
                   ($type === 'monthly' ? 'ເດືອນ ' . \Carbon\Carbon::parse($month.'-01')->format('m-Y') : 
                   'ປີ ' . $year);
                   
    // Calculate totals for footer
    $cashTotal = $incomeTransactions->where('payment_method', 'cash')->sum('amount');
    $transferTotal = $incomeTransactions->where('payment_method', 'transfer')->sum('amount');
    
    // Sum for Master's Degree program
    $mastersTotal = $incomeTransactions->filter(function($t) {
        return str_contains($t->department?->department_name ?? '', 'ປະລິນຍາໂທ');
    })->sum('amount');
    
    $totalAmount = $incomeTransactions->sum('amount');
    $txnCounts = $incomeTransactions->count();
@endphp

<div style="text-align: center; margin-bottom: 20px; font-family: 'Noto Sans Lao', 'Phetsarath OT', sans-serif;">
    <h1 style="font-size: 16px; font-weight: bold; color: #000; margin: 0; line-height: 1.2;">
        ສະຫຼຸບລາຍຮັບວິຊາການປະຈຳ {{ $titleSuffix }}
    </h1>
</div>

<div style="font-size: 11px; margin-bottom: 6px; color: #000; text-align: left; font-family: 'Noto Sans Lao', 'Phetsarath OT', sans-serif;">
    ວັນທີ: {{ now()->format('d-m-Y') }}
</div>

<table class="p-tbl" style="width: 100%; color: #000; border-collapse: collapse; font-size: 11px; table-layout: fixed; font-family: 'Noto Sans Lao', 'Phetsarath OT', sans-serif; border: 1px solid #000 !important;">
    <thead>
        <tr style="background: #fff;">
            <th style="width: 90px; text-align: center; border: 1px solid #000 !important; font-weight: bold; padding: 4px 6px; font-size: 11px; color: #000 !important;">ເລກບັນຊີ</th>
            @foreach($categories as $category)
                <th style="text-align: center; border: 1px solid #000 !important; font-weight: bold; padding: 4px 6px; font-size: 11px; color: #000 !important;">{{ $category }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse($incomeTransactions as $txn)
            <tr>
                <td style="text-align: center; border: 1px solid #000 !important; padding: 4px 6px; font-weight: normal;">
                    {{ $txn->payment_code ?: sprintf('%06d', $txn->id) }}
                </td>
                @foreach($categories as $cat)
                    @php
                        $amount = 0;
                        $isMatch = false;
                        
                        if ($cat === 'ຄ່າລົງທະບຽນ' && $txn->category === 'ຄ່າລົງທະບຽນ') {
                            $isMatch = true;
                        } elseif ($cat === 'ຄ່າໜ່ວຍກິດ' && $txn->category === 'ຄ່າໜ່ວຍກິດ') {
                            $isMatch = true;
                        } elseif ($cat === 'ປັບປຸງຫ້ອງແລັບ' && $txn->category === 'ປັບປຸງຫ້ອງແລັບ') {
                            $isMatch = true;
                        } elseif ($cat === 'ຄ່າເທີມສາມ' && ($txn->category === 'ຄ່າເທີມສາມ' || $txn->category === 'ຄ່າໜ່ວຍກິດເທີມ 3')) {
                            $isMatch = true;
                        } elseif ($cat === 'ຄ່າບໍລິການຕ່າງໆ' && ($txn->category === 'ຄ່າບໍລິການຕ່າງໆ' || $txn->category === 'ຄ່າບໍລິການວິຊາການ')) {
                            $isMatch = true;
                        }
                        
                        if ($isMatch) {
                            $amount = $txn->amount;
                        }
                    @endphp
                    @if($amount > 0)
                        <td style="border: 1px solid #000 !important; padding: 4px 6px; text-align: right;">
                            {{ number_format($amount, 0, ',', '.') }}
                        </td>
                    @else
                        <td style="border: 1px solid #000 !important; padding: 4px 6px; text-align: center;">
                            0
                        </td>
                    @endif
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center; border: 1px solid #000 !important; padding: 12px; color: #000;">
                    ບໍ່ມີຂໍ້ມູນລາຍຮັບ
                </td>
            </tr>
        @endforelse
    </tbody>
    @if($incomeTransactions->count() > 0)
    <tfoot>
        <tr style="font-weight: bold; background: #fff;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000 !important; padding: 4px 6px;">ລວມ</td>
            @foreach($categories as $cat)
                @php
                    $sum = 0;
                    if ($cat === 'ຄ່າລົງທະບຽນ') {
                        $sum = $incomeTransactions->where('category', 'ຄ່າລົງທະບຽນ')->sum('amount');
                    } elseif ($cat === 'ຄ່າໜ່ວຍກິດ') {
                        $sum = $incomeTransactions->where('category', 'ຄ່າໜ່ວຍກິດ')->sum('amount');
                    } elseif ($cat === 'ປັບປຸງຫ້ອງແລັບ') {
                        $sum = $incomeTransactions->where('category', 'ປັບປຸງຫ້ອງແລັບ')->sum('amount');
                    } elseif ($cat === 'ຄ່າເທີມສາມ') {
                        $sum = $incomeTransactions->whereIn('category', ['ຄ່າເທີມສາມ', 'ຄ່າໜ່ວຍກິດເທີມ 3'])->sum('amount');
                    } elseif ($cat === 'ຄ່າບໍລິການຕ່າງໆ') {
                        $sum = $incomeTransactions->whereIn('category', ['ຄ່າບໍລິການຕ່າງໆ', 'ຄ່າບໍລິການວິຊາການ'])->sum('amount');
                    }
                @endphp
                @if($sum > 0)
                    <td style="text-align: right; border: 1px solid #000 !important; font-weight: bold; padding: 4px 6px;">
                        {{ number_format($sum, 0, ',', '.') }}
                    </td>
                @else
                    <td style="text-align: center; border: 1px solid #000 !important; font-weight: bold; padding: 4px 6px;">
                        0
                    </td>
                @endif
            @endforeach
        </tr>
    </tfoot>
    @endif
</table>

@if($incomeTransactions->count() > 0)
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; font-size: 11px; font-weight: bold; color: #000; width: 100%; font-family: 'Noto Sans Lao', 'Phetsarath OT', sans-serif;">
    <div>
        ເລກທີ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span contenteditable="true" style="min-width: 40px; border-bottom: 1px solid #000; display: inline-block; text-align: center; outline: none;">{{ $txnCounts }}</span>
        &nbsp;&nbsp;=&nbsp;&nbsp;{{ number_format($totalAmount, 0, ',', '.') }}
    </div>
    <div>
        ເງິນສົດ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;{{ number_format($cashTotal, 0, ',', '.') }}
    </div>
    <div>
        ທະນາຄານ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;{{ number_format($transferTotal, 0, ',', '.') }}
    </div>
    <div>
        ເງິນປໍໂທ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;{{ number_format($mastersTotal, 0, ',', '.') }}
    </div>
</div>
@endif

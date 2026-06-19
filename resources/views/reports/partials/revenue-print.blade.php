@php
    // Extract unique categories for columns
    $categories = $incomeTransactions->pluck('category')->filter()->unique()->values();
    
    // Determine the title period
    $titleSuffix = $type === 'daily' ? 'ວັນທີ ' . \Carbon\Carbon::parse($date)->format('d-m-Y') : 
                   ($type === 'monthly' ? 'ເດືອນ ' . \Carbon\Carbon::parse($month.'-01')->format('m-Y') : 
                   'ປີ ' . $year);
                   
    // Calculate totals for footer
    $cashTotal = $incomeTransactions->where('payment_method', 'cash')->sum('amount');
    $transferTotal = $incomeTransactions->where('payment_method', 'transfer')->sum('amount');
    $totalAmount = $incomeTransactions->sum('amount');
    $txnCounts = $incomeTransactions->count();
@endphp

<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="font-size: 20px; font-weight: 800; color: #000; margin: 0 0 10px; line-height: 1.4;">
        ສະຫຼຸບລາຍຮັບວິຊາການປະຈຳ {{ $titleSuffix }}
    </h1>
</div>

<div style="font-size: 14px; margin-bottom: 12px; font-weight: bold; color: #000;">
    ວັນທີ: {{ now()->format('d-m-Y') }}
</div>

<table class="p-tbl" style="width: 100%; text-align: right; color: #000; border-collapse: collapse; font-size: 13px; table-layout: fixed;">
    <thead>
        <tr style="background: #fff;">
            <th style="width: 110px; text-align: center; border: 1px solid #000 !important; font-weight: bold; padding: 10px 6px; font-size: 13px;">ເລກທີ (ໃບບິນ)</th>
            @foreach($categories as $category)
                <th style="text-align: right; border: 1px solid #000 !important; font-weight: bold; padding: 10px 6px; font-size: 13px; line-height: 1.4;">{{ $category }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse($incomeTransactions as $txn)
            <tr>
                <td style="text-align: center; border: 1px solid #000 !important; padding: 8px 10px;">
                    {{ $txn->payment_code ?: sprintf('%06d', $txn->id) }}
                </td>
                @foreach($categories as $category)
                    <td style="border: 1px solid #000 !important; padding: 8px 10px;">
                        @if($txn->category === $category && $txn->amount > 0)
                            {{ number_format($txn->amount, 0, ',', '.') }}
                        @else
                            0
                        @endif
                    </td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($categories) + 1 }}" style="text-align: center; border: 1px solid #000 !important; padding: 20px;">
                    ບໍ່ມີຂໍ້ມູນລາຍຮັບ
                </td>
            </tr>
        @endforelse
    </tbody>
    @if($incomeTransactions->count() > 0)
    <tfoot>
        <tr style="font-weight: bold; background: #fff;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000 !important; padding: 10px;">ລວມ</td>
            @foreach($categories as $category)
                <td style="text-align: right; border: 1px solid #000 !important; font-weight: bold; padding: 10px;">
                    {{ number_format($incomeTransactions->where('category', $category)->sum('amount'), 0, ',', '.') }}
                </td>
            @endforeach
        </tr>
    </tfoot>
    @endif
</table>

@if($incomeTransactions->count() > 0)
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px; font-size: 14px; font-weight: bold; color: #000; width: 100%;">
    <div style="display: flex; align-items: baseline; gap: 4px;">
        ເລກທີ 
        <span contenteditable="true" style="min-width: 30px; border-bottom: 1px solid #000; text-align: center; outline: none; padding: 0 4px; font-weight: bold;">{{ $txnCounts }}</span>
        = {{ number_format($totalAmount, 0, ',', '.') }}
    </div>
    <div>
        ເງິນສົດ = {{ number_format($cashTotal, 0, ',', '.') }}
    </div>
    <div>
        ທະນາຄານ = {{ number_format($transferTotal, 0, ',', '.') }}
    </div>
    <div>
        ເງິນປັດໂຕ = 0
    </div>
</div>
@endif

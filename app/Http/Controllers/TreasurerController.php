<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TreasurerController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', today()->format('Y'));

        $transactions = Transaction::with('department', 'chartOfAccount')
            ->whereYear('transaction_date', $year)
            ->latest('transaction_date')
            ->paginate(20);

        $totalIncome  = Transaction::where('type', 'income')->whereYear('transaction_date', $year)->sum('amount');

        // ดึงยอด advance requests ที่จ่ายแล้ว
        $advanceRequests = \App\Models\AdvanceRequest::whereIn('status', ['paid', 'cleared'])
            ->whereHas('paymentTransaction', fn($q) => $q->whereYear('transaction_date', $year))
            ->get();
        $advanceTotalAmount = $advanceRequests->sum('requested_amount');

        // กรอง expense transactions ที่เกิดจาก advance payment ออก (ป้องกันนับซ้ำ)
        $advancePaymentTxnIds = $advanceRequests->pluck('payment_transaction_id')->filter()->toArray();
        $generalExpenseTotal = Transaction::where('type', 'expense')
            ->whereYear('transaction_date', $year)
            ->when(!empty($advancePaymentTxnIds), fn($q) => $q->whereNotIn('id', $advancePaymentTxnIds))
            ->sum('amount');

        $totalExpense = $generalExpenseTotal + $advanceTotalAmount;

        return view('treasurer.treasurer', compact('transactions', 'totalIncome', 'totalExpense', 'year'));
    }
}

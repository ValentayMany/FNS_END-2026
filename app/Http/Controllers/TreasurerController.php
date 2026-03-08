<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class TreasurerController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('department', 'chartOfAccount')
            ->latest('transaction_date')
            ->paginate(20);

        $totalIncome  = Transaction::sum('amount');
        $totalExpense = \App\Models\AdvanceRequest::whereIn('status', ['paid', 'cleared'])
            ->sum('requested_amount');

        return view('treasurer.treasurer', compact('transactions', 'totalIncome', 'totalExpense'));
    }
}

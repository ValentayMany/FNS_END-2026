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

        $totalIncome  = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');

        return view('treasurer.treasurer', compact('transactions', 'totalIncome', 'totalExpense'));
    }
}

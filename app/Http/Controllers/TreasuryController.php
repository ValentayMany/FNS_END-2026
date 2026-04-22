<?php

namespace App\Http\Controllers;

use App\Models\TreasuryReconciliationItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreasuryController extends Controller
{
    public function index()
    {
        $items = TreasuryReconciliationItem::with('transaction', 'user')
            ->latest('reconciliation_date')
            ->paginate(15);

        // Only show transactions that haven't been reconciled yet
        $reconciledIds = TreasuryReconciliationItem::pluck('transaction_id')->toArray();
        $transactions  = Transaction::whereNotIn('id', $reconciledIds)
            ->orderBy('transaction_date', 'desc')
            ->get();

        return view('treasury.treasury', compact('items', 'transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id'      => [
                'required',
                'exists:transactions,id',
                // Prevent duplicate reconciliation
                'unique:treasury_reconciliation_items,transaction_id',
            ],
            'reconciliation_date' => 'required|date',
        ]);

        TreasuryReconciliationItem::create([
            'transaction_id'      => $request->transaction_id,
            'reconciliation_date' => $request->reconciliation_date,
            'user_id'             => Auth::id(),
        ]);

        return back()->with('success', 'ບັນທຶກສຳເລັດ');
    }
}

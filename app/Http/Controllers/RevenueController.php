<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Department;
use App\Models\Transaction;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('department', 'chartOfAccount')
            ->latest('transaction_date')
            ->paginate(15);

        $accounts = ChartOfAccount::orderBy('account_code')->get();
        $departments = Department::all();

        return view('revenue.revenue', compact('transactions', 'accounts', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:500',
            'amount' => 'required|numeric|min:1',
            'account_id' => 'required|exists:chart_of_accounts,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        Transaction::create($request->only([
            'transaction_date', 'description',
            'amount', 'account_id', 'department_id',
        ]));

        return back()->with('success', 'ບັນທຶກລາຍຮັບສຳເລັດ');
    }
}

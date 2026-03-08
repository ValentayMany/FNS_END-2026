<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\AdvanceRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type  = $request->get('type', 'daily');
        $date  = $request->get('date', today()->toDateString());
        $month = $request->get('month', today()->format('Y-m'));

        if ($type === 'daily') {
            $transactions = Transaction::with('department', 'chartOfAccount')
                ->whereDate('transaction_date', $date)
                ->get();

            $requests = AdvanceRequest::with('requester', 'department')
                ->whereDate('request_date', $date)
                ->whereIn('status', ['paid', 'cleared'])
                ->get();

            $totalIncome  = $transactions->sum('amount');
            $totalExpense = $requests->sum('requested_amount');

        } else {
            [$year, $mon] = explode('-', $month);

            $transactions = Transaction::with('department', 'chartOfAccount')
                ->whereYear('transaction_date', $year)
                ->whereMonth('transaction_date', $mon)
                ->get();

            $requests = AdvanceRequest::with('requester', 'department')
                ->whereYear('request_date', $year)
                ->whereMonth('request_date', $mon)
                ->whereIn('status', ['paid', 'cleared'])
                ->get();

            $totalIncome  = $transactions->sum('amount');
            $totalExpense = $requests->sum('requested_amount');
        }

        return view('reports.report', compact(
            'transactions', 'requests',
            'totalIncome', 'totalExpense',
            'type', 'date', 'month'
        ));
    }
}

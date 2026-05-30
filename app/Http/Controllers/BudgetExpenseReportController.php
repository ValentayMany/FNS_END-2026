<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Transaction;
use App\Services\BudgetExpenseReportBuilder;
use Illuminate\Http\Request;

class BudgetExpenseReportController extends Controller
{
    public function index(Request $request, BudgetExpenseReportBuilder $builder)
    {
        $type  = $request->get('type', 'yearly');
        $date  = $request->get('date', today()->toDateString());
        $month = $request->get('month', today()->format('Y-m'));
        $year  = $request->get('year', today()->format('Y'));

        $selectedAccountId = $request->get('account_id');

        if ($type === 'daily') {
            $selectedYear = \Carbon\Carbon::parse($date)->format('Y');
        } elseif ($type === 'monthly') {
            $selectedYear = explode('-', $month)[0];
        } else {
            $selectedYear = $year;
        }

        $lineItems = ChartOfAccount::whereHas('transactions', function ($q) use ($selectedYear) {
            $q->where('type', 'expense');
            if ($selectedYear) {
                $q->whereYear('transaction_date', $selectedYear);
            }
        })
            ->orderBy('account_code')
            ->get();

        $plan   = null;
        $report = null;

        if ($selectedYear && $selectedAccountId) {
            $accountIds = ChartOfAccount::descendantIds((int) $selectedAccountId);

            $yearlyTransactions = Transaction::query()
                ->where('type', 'expense')
                ->whereIn('account_id', $accountIds)
                ->whereYear('transaction_date', $selectedYear)
                ->orderBy('transaction_date')
                ->get();

            if ($type === 'daily') {
                $periodTransactions = $yearlyTransactions->filter(
                    fn ($t) => $t->transaction_date->toDateString() === $date
                )->values();
            } elseif ($type === 'monthly') {
                $periodTransactions = $yearlyTransactions->filter(
                    fn ($t) => $t->transaction_date->format('Y-m') === $month
                )->values();
            } else {
                $periodTransactions = $yearlyTransactions;
            }

            $report = $builder->build(
                $type,
                $date,
                $month,
                $year,
                (int) $selectedAccountId,
                null,
                $periodTransactions,
            );
        }

        return view('reports.budget-expense-report', compact(
            'type', 'date', 'month', 'year',
            'lineItems',
            'selectedYear',
            'selectedAccountId',
            'plan',
            'report',
        ));
    }
}

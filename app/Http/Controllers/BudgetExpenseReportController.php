<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BudgetExpenseReportController extends Controller
{
    public function index(Request $request)
    {
        $type  = $request->get('type', 'yearly');
        $date  = $request->get('date', today()->toDateString());
        $month = $request->get('month', today()->format('Y-m'));
        $year  = $request->get('year', today()->format('Y'));
        
        $selectedAccountId = $request->get('account_id');

        // Determine the fiscal year based on selected filter
        if ($type === 'daily') {
            $selectedYear = \Carbon\Carbon::parse($date)->format('Y');
        } elseif ($type === 'monthly') {
            $selectedYear = explode('-', $month)[0];
        } else {
            $selectedYear = $year;
        }

        // หมวดบัญชีที่มี Transaction จริงในปีนั้น
        $lineItems = ChartOfAccount::whereHas('transactions', function ($q) use ($selectedYear) {
                $q->where('type', 'expense');
                if ($selectedYear) {
                    $q->whereYear('transaction_date', $selectedYear);
                }
            })
            ->with('transactions')
            ->orderBy('account_code')
            ->get();

        $plan   = null; // ยังไม่มีระบบ BudgetPlan จริง → ใช้ยอด Transaction แทน
        $report = null;

        if ($selectedYear && $selectedAccountId) {
            $account = ChartOfAccount::find($selectedAccountId);

            if ($account) {
                // ดึง descendant account IDs (รองรับ hierarchy)
                $accountIds = ChartOfAccount::descendantIds((int) $selectedAccountId);

                // ดึงรายการของทั้งปี เพื่อคำนวณ running_balance ที่ถูกต้อง
                $yearlyTransactions = Transaction::with('department')
                    ->where('type', 'expense')
                    ->whereIn('account_id', $accountIds)
                    ->whereYear('transaction_date', $selectedYear)
                    ->orderBy('transaction_date')
                    ->get();

                // คำนวณ budget ຈາກ budget_plans ແລະ budget_line_items
                $budgetPlan = \App\Models\BudgetPlan::where('fiscal_year', $selectedYear)->first();
                $budget = 0;
                if ($budgetPlan) {
                    $lineItem = \App\Models\BudgetLineItem::where('budget_plan_id', $budgetPlan->id)
                        ->where('account_id', $selectedAccountId)
                        ->first();
                    if ($lineItem) {
                        $budget = (float)($lineItem->amount_academic + $lineItem->amount_regular);
                    }
                }

                $totalSpent = $yearlyTransactions->sum('amount');

                // เพิ่ม running_balance ให้แต่ละ row
                $running = $budget;
                $yearlyTransactions = $yearlyTransactions->map(function ($txn) use (&$running) {
                    $running -= $txn->amount;
                    $txn->running_balance = $running;
                    return $txn;
                });

                // กรองเฉพาะรายการที่จะแสดงตาม Type
                if ($type === 'daily') {
                    $transactions = $yearlyTransactions->filter(fn($t) => $t->transaction_date->toDateString() === $date)->values();
                } elseif ($type === 'monthly') {
                    $transactions = $yearlyTransactions->filter(fn($t) => $t->transaction_date->format('Y-m') === $month)->values();
                } else {
                    $transactions = $yearlyTransactions;
                }

                $periodSpent = $transactions->sum('amount');

                $report = [
                    'account'      => $account,
                    'transactions' => $transactions,
                    'budget'       => $budget,
                    'totalSpent'   => $totalSpent, // Total for the year
                    'periodSpent'  => $periodSpent, // Total for the selected period
                    'remaining'    => $budget - $totalSpent,
                ];
            }
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

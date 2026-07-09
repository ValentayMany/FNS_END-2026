<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Department;
use App\Models\Transaction;
use App\Models\BudgetPlan;
use App\Services\BudgetExpenseReportBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // 1. ดึงแผนงบประมาณ (ของเราก่อน หรือของอีกทีม)
        $plan = BudgetPlan::where('fiscal_year', $selectedYear)->first();
        if (!$plan) {
            $plan = DB::table('planning_years')->where('year', (int) $selectedYear)->first();
        }

        // 2. ดึงหมวดบัญชีที่มีการจัดสรรงบประมาณไว้ หรือเคยทำธุรกรรม
        if ($plan && $plan instanceof BudgetPlan) {
            $lineItems = ChartOfAccount::whereHas('budgetLineItems', function ($q) use ($plan) {
                $q->where('budget_plan_id', $plan->id);
            })
                ->orderBy('account_code')
                ->get();
        } elseif ($plan) { // Fallback planning_year ของอีกทีม
            $planningYearId = $plan->id;
            $lineItems = ChartOfAccount::where(function ($query) use ($planningYearId) {
                $query->whereHas('transactions', function ($q) {
                    $q->where('type', 'expense');
                })
                ->orWhereIn('id', function ($q) use ($planningYearId) {
                    $q->select('chart_of_account_id')
                        ->from('expense_plans')
                        ->where('planning_year_id', $planningYearId);
                })
                ->orWhereIn('id', function ($q) use ($planningYearId) {
                    $q->select('chart_of_account_id')
                        ->from('salary_entries')
                        ->join('salary_plans', 'salary_plans.id', '=', 'salary_entries.plan_id')
                        ->where('salary_plans.planning_year_id', $planningYearId);
                });
            })
                ->orderBy('account_code')
                ->get();
        } else {
            // Fallback เผื่อไม่มีแผนเลย
            $lineItems = ChartOfAccount::whereHas('transactions', function ($q) use ($selectedYear) {
                $q->where('type', 'expense');
                if ($selectedYear) {
                    $q->whereYear('transaction_date', $selectedYear);
                }
            })
                ->orderBy('account_code')
                ->get();
        }

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

        // ---- Departments for print header ----
        $departments = Department::orderBy('dept_code')->orderBy('department_name')->get();
        $selectedDeptId = $request->get('department_id');

        // Auto-pick: if none selected, default to first dept that has a dept_code
        if (!$selectedDeptId) {
            $defaultDept = $departments->firstWhere('dept_code', '!=', null);
            $selectedDeptId = $defaultDept?->id;
        }

        return view('reports.budget-expense-report', compact(
            'type', 'date', 'month', 'year',
            'lineItems',
            'selectedYear',
            'selectedAccountId',
            'plan',
            'report',
            'departments',
            'selectedDeptId',
        ));
    }
}

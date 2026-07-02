<?php

namespace App\Services;

use App\Models\BudgetLineItem;
use App\Models\BudgetPlan;
use App\Models\ChartOfAccount;
use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BudgetExpenseReportBuilder
{
    /**
     * @param  Collection<int, Transaction>  $periodTransactions  ລາຍຈ່າຍໃນຊ່ວງທີ່ເລືອກ (ກັ່ນຕົວກອງແລ້ວ)
     * @return array<string, mixed>|null
     */
    public function build(
        string $type,
        string $date,
        string $month,
        string $year,
        ?int $accountId,
        ?int $departmentId,
        Collection $periodTransactions,
    ): ?array {
        if ($periodTransactions->isEmpty() && ! $accountId) {
            return null;
        }

        $selectedYear = match ($type) {
            'daily'   => \Carbon\Carbon::parse($date)->format('Y'),
            'monthly' => explode('-', $month)[0],
            default   => $year,
        };

        if (! $accountId) {
            $accountId = $periodTransactions->first()?->account_id;
        }

        if (! $accountId) {
            return null;
        }

        $account = ChartOfAccount::find($accountId);
        if (! $account) {
            return null;
        }

        $accountIds = ChartOfAccount::descendantIds((int) $accountId);

        $yearlyQuery = Transaction::query()
            ->where('type', 'expense')
            ->whereIn('account_id', $accountIds)
            ->whereYear('transaction_date', $selectedYear)
            ->orderBy('transaction_date');

        if ($departmentId) {
            $yearlyQuery->where('department_id', $departmentId);
        }

        $yearlyTransactions = $yearlyQuery->get();
        $budgetData = $this->resolveBudgetAmount($selectedYear, (int) $accountId);
        $budget = $budgetData['total'];
        $totalSpent = (float) $yearlyTransactions->sum('amount');

        $running = $budget;
        $yearlyTransactions = $yearlyTransactions->map(function ($txn) use (&$running) {
            $running -= $txn->amount;
            $txn->running_balance = $running;

            return $txn;
        });

        if ($periodTransactions->isEmpty()) {
            $transactions = collect();
        } else {
            $periodIds = $periodTransactions->pluck('id')->all();
            $transactions = $yearlyTransactions
                ->filter(fn ($t) => in_array($t->id, $periodIds, true))
                ->values();
        }

        $periodSpent = (float) $transactions->sum('amount');

        return [
            'account'      => $account,
            'transactions' => $transactions,
            'budget'       => $budget,
            'stateAmount'  => $budgetData['state'],
            'facultyAmount'=> $budgetData['faculty'],
            'totalSpent'   => $totalSpent,
            'periodSpent'  => $periodSpent,
            'remaining'    => $budget - $totalSpent,
            'selectedYear' => $selectedYear,
        ];
    }

    /**
     * ดึง label ประเภทงบประมาณ
     * - ถ้ามีเฉพาะ state (ເງິນເດືອນ) → ງົບປະມານປົກກະຕິ
     * - ถ้ามีเฉพาะ faculty (ວິຊາການ) → ງົບປະມານວິຊາການ
     * - ถ้ามีทั้ง 2 → ງົບລວມ
     */
    public function budgetTypeLabel(int $selectedYear, int $accountId): string
    {
        // ลองดึงจาก budget_plans (ของเรา) ก่อน
        $budgetPlan = BudgetPlan::where('fiscal_year', $selectedYear)->first();
        if ($budgetPlan) {
            $lineItem = BudgetLineItem::where('budget_plan_id', $budgetPlan->id)
                ->where('account_id', $accountId)
                ->first();

            if ($lineItem) {
                if ($lineItem->amount_academic > 0 && $lineItem->amount_regular == 0) {
                    return '(ງົບປະມານວິຊາການ)';
                }

                if ($lineItem->amount_regular > 0 && $lineItem->amount_academic == 0) {
                    return '(ງົບປະມານປົກກະຕິ)';
                }
            }
        }

        // Fallback: ดึงจาก expense_plans + salary_entries (ของอีกทีม)
        $budgetData = $this->resolveBudgetAmount($selectedYear, $accountId);

        if ($budgetData['state'] > 0 && $budgetData['faculty'] == 0) {
            return '(ງົບປະມານປົກກະຕິ)';
        }
        if ($budgetData['faculty'] > 0 && $budgetData['state'] == 0) {
            return '(ງົບປະມານວິຊາການ)';
        }
        if ($budgetData['state'] > 0 && $budgetData['faculty'] > 0) {
            return '(ງົບລວມ)';
        }

        return '';
    }

    /**
     * ดึงยอดงบประมาณอนุมัติ
     * ตาม SQL ของอีกทีม: งบรวม = state_amount (ລັດຈັດ/เงินเดือน) + faculty_amount (ວິຊາການ/รายจ่าย)
     *
     * ลำดับ:
     *   1. budget_plans + budget_line_items (ตารางของเรา) ถ้ามี
     *   2. salary_entries + expense_plans (ตารางของอีกทีม) — roll up ตาม account tree
     *
     * @return array{total: float, state: float, faculty: float}
     */
    private function resolveBudgetAmount(string|int $fiscalYear, int $accountId): array
    {
        // === 1. ลองจาก budget_plans ของเราก่อน ===
        $budgetPlan = BudgetPlan::where('fiscal_year', $fiscalYear)->first();
        if ($budgetPlan) {
            $lineItem = BudgetLineItem::where('budget_plan_id', $budgetPlan->id)
                ->where('account_id', $accountId)
                ->first();

            if ($lineItem) {
                $state = (float) $lineItem->amount_regular;
                $faculty = (float) $lineItem->amount_academic;
                return [
                    'total'   => $state + $faculty,
                    'state'   => $state,
                    'faculty' => $faculty,
                ];
            }
        }

        // === 2. Fallback: ดึงจาก salary_entries + expense_plans (ตามSQL ของอีกทีม) ===
        $accountIds = ChartOfAccount::descendantIds($accountId);

        // หา planning_year_id จากปี
        $planningYear = DB::table('planning_years')
            ->where('year', (int) $fiscalYear)
            ->first();

        $stateAmount = 0.0;
        $facultyAmount = 0.0;

        if ($planningYear) {
            // --- State Amount: จาก salary_entries ---
            $stateAmount = (float) DB::table('salary_entries')
                ->join('salary_plans', 'salary_plans.id', '=', 'salary_entries.plan_id')
                ->where('salary_plans.planning_year_id', $planningYear->id)
                ->whereIn('salary_entries.chart_of_account_id', $accountIds)
                ->sum('salary_entries.annual_amount');

            // --- Faculty Amount: จาก expense_plans ---
            $plans = DB::table('expense_plans')
                ->where('planning_year_id', $planningYear->id)
                ->whereIn('chart_of_account_id', $accountIds)
                ->select('calculation_values')
                ->get();

            foreach ($plans as $p) {
                $calcValues = json_decode($p->calculation_values, true);
                $facultyAmount += (float) ($calcValues['yearly_total'] ?? 0);
            }
        }

        return [
            'total'   => $stateAmount + $facultyAmount,
            'state'   => $stateAmount,
            'faculty' => $facultyAmount,
        ];
    }
}

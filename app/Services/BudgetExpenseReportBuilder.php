<?php

namespace App\Services;

use App\Models\BudgetLineItem;
use App\Models\BudgetPlan;
use App\Models\ChartOfAccount;
use App\Models\Transaction;
use Illuminate\Support\Collection;

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
        $budget = $this->resolveBudgetAmount($selectedYear, (int) $accountId);
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
            'totalSpent'   => $totalSpent,
            'periodSpent'  => $periodSpent,
            'remaining'    => $budget - $totalSpent,
            'selectedYear' => $selectedYear,
        ];
    }

    public function budgetTypeLabel(int $selectedYear, int $accountId): string
    {
        $budgetPlan = BudgetPlan::where('fiscal_year', $selectedYear)->first();
        if (! $budgetPlan) {
            return '';
        }

        $lineItem = BudgetLineItem::where('budget_plan_id', $budgetPlan->id)
            ->where('account_id', $accountId)
            ->first();

        if (! $lineItem) {
            return '';
        }

        if ($lineItem->amount_academic > 0 && $lineItem->amount_regular == 0) {
            return '(ງົບປະມານວິຊາການ)';
        }

        if ($lineItem->amount_regular > 0 && $lineItem->amount_academic == 0) {
            return '(ງົບປະມານປົກກະຕິ)';
        }

        return '';
    }

    private function resolveBudgetAmount(string|int $fiscalYear, int $accountId): float
    {
        $budgetPlan = BudgetPlan::where('fiscal_year', $fiscalYear)->first();
        if (! $budgetPlan) {
            return 0.0;
        }

        $lineItem = BudgetLineItem::where('budget_plan_id', $budgetPlan->id)
            ->where('account_id', $accountId)
            ->first();

        if (! $lineItem) {
            return 0.0;
        }

        return (float) ($lineItem->amount_academic + $lineItem->amount_regular);
    }
}

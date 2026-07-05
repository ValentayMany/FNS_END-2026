<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Transaction;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    private const ADVANCE_PAYMENT_MSG = 'ບໍ່ສາມາດແກ້ໄຂລາຍຈ່າຍເບີກລ່ວງໜ້າໄດ້';

    private array $expenseCategories = [
        'ສົ່ງເສີມຊີວາການ',
        'ງົບປະມານສົ່ງເສີມວິຊາການ',
        'ຮັບໃຊ້ການທົດລອງ',
        'ການເຄື່ອນໄຫວນອກຫຼັກສູດ',
    ];

    public function index()
    {
        $transactions = Transaction::with(['department', 'chartOfAccount'])
            ->where('type', 'expense')
            ->whereDoesntHave('advanceRequest')
            ->latest('transaction_date')
            ->paginate(15);

        $departments = Department::orderedForSelect();
        $accounts = ChartOfAccount::orderBy('account_code')->get();

        $defaultYear = (int) date('Y');
        $nextPaymentCode = $this->calculateNextPaymentCode($defaultYear);

        return view('expense.expense', compact('transactions', 'departments', 'accounts', 'nextPaymentCode'));
    }

    public function getNextCode(Request $request)
    {
        $year = $request->query('year', date('Y'));
        
        if (!preg_match('/^\d{4}$/', $year)) {
            return response()->json(['error' => 'Invalid year format'], 400);
        }

        $nextCode = $this->calculateNextPaymentCode((int)$year);

        return response()->json(['payment_code' => $nextCode]);
    }

    private function calculateNextPaymentCode(int $year): string
    {
        $latest = Transaction::where('type', 'expense')
            ->where('payment_code', 'like', "%.$year")
            ->orderBy('payment_code', 'desc')
            ->first();

        $nextSeq = 1;
        if ($latest && preg_match('/^(\d{5})\.(\d{4})$/', $latest->payment_code, $matches)) {
            $nextSeq = ((int) $matches[1]) + 1;
        }

        return sprintf('%05d.%d', $nextSeq, $year);
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'category'         => ['required', Rule::in($this->expenseCategories)],
            'payment_code'     => 'required|string|max:50',
            'item_name'        => 'required|string|max:255',
            'description'      => 'nullable|string|max:500',
            'amount'           => 'required|numeric|min:1',
            'department_id'    => 'required|exists:departments,id',
            'account_id'       => 'required|exists:chart_of_accounts,id',
            'expense_type'     => 'nullable|string|max:100',
            'channel_type'     => 'nullable|string|max:100',
        ]);

        $expenseType = $request->input('expense_type', 'ງົບປະມານວິຊາການ');
        $channelType = $request->input('channel_type', 'ເງິນບໍລິຫານທົ່ວໄປ');
        $userDesc = $request->input('description');

        $metadata = "[ປະເພດລາຍຈ່າຍ: {$expenseType}] [ຊ່ອງ ປຕ/ປທ: {$channelType}]";
        $finalDescription = $userDesc ? "{$metadata} {$userDesc}" : $metadata;

        Transaction::create([
            ...$request->only(['transaction_date', 'category', 'payment_code', 'item_name', 'amount', 'department_id', 'account_id']),
            'description' => $finalDescription,
            'type'        => 'expense',
        ]);

        return back()->with('success', 'ບັນທຶກລາຍຈ່າຍສຳເລັດ');
    }

    public function edit(Transaction $transaction)
    {
        $this->ensureEditableExpense($transaction);

        $departments = Department::orderedForSelect();
        $accounts = ChartOfAccount::orderBy('account_code')->get();

        // Parse metadata from description
        $desc = $transaction->getRawOriginal('description') ?? '';
        $expenseType = 'ງົບປະມານວິຊາການ';
        $channelType = 'ເງິນບໍລິຫານທົ່ວໄປ';
        
        if (preg_match('/\[ປະເພດລາຍຈ່າຍ:\s*(.*?)\]/', $desc, $matches)) {
            $expenseType = $matches[1];
            $desc = str_replace($matches[0], '', $desc);
        }
        if (preg_match('/\[ຊ່ອງ ປຕ\/ປທ:\s*(.*?)\]/', $desc, $matches)) {
            $channelType = $matches[1];
            $desc = str_replace($matches[0], '', $desc);
        }
        $userDesc = trim($desc);

        return view('expense.edit', compact('transaction', 'departments', 'accounts', 'expenseType', 'channelType', 'userDesc'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->ensureEditableExpense($transaction);

        $request->validate([
            'transaction_date' => 'required|date',
            'category'         => ['required', Rule::in($this->expenseCategories)],
            'payment_code'     => 'required|string|max:50',
            'item_name'        => 'required|string|max:255',
            'description'      => 'nullable|string|max:500',
            'amount'           => 'required|numeric|min:1',
            'department_id'    => 'required|exists:departments,id',
            'account_id'       => 'required|exists:chart_of_accounts,id',
            'expense_type'     => 'nullable|string|max:100',
            'channel_type'     => 'nullable|string|max:100',
        ]);

        $expenseType = $request->input('expense_type', 'ງົບປະມານວິຊາການ');
        $channelType = $request->input('channel_type', 'ເງິນບໍລິຫານທົ່ວໄປ');
        $userDesc = $request->input('description');

        $metadata = "[ປະເພດລາຍຈ່າຍ: {$expenseType}] [ຊ່ອງ ປຕ/ປທ: {$channelType}]";
        $finalDescription = $userDesc ? "{$metadata} {$userDesc}" : $metadata;

        $transaction->update([
            ...$request->only(['transaction_date', 'category', 'payment_code', 'item_name', 'amount', 'department_id', 'account_id']),
            'description' => $finalDescription,
        ]);

        return redirect()->route('expense.index')->with('success', 'ແກ້ໄຂລາຍຈ່າຍສຳເລັດ');
    }

    public function destroy(Transaction $transaction)
    {
        $this->ensureEditableExpense($transaction);

        $transaction->delete();

        return back()->with('success', 'ລຶບລາຍຈ່າຍສຳເລັດ');
    }

    public function destroyBatch(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $txns = Transaction::where('type', 'expense')
                ->whereIn('id', $ids)
                ->whereDoesntHave('advanceRequest')
                ->get();

            $count = 0;
            foreach ($txns as $txn) {
                $txn->delete();
                $count++;
            }

            return back()->with('success', 'ລຶບລາຍການທີ່ເລືອກສຳເລັດແລ້ວ (' . $count . ' ລາຍການ)');
        }
        return back()->with('error', 'ກະລຸນາເລືອກລາຍການທີ່ຕ້ອງການລຶບ');
    }

    public function itemSuggestions(Request $request)
    {
        $q = $request->query('q', '');
        
        $query = Transaction::where('type', 'expense')
            ->whereNotNull('item_name')
            ->where('item_name', '!=', '');
            
        if ($q !== '') {
            $query->where('item_name', 'like', "%{$q}%");
        }
        
        $suggestions = $query->select('item_name')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('item_name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->pluck('item_name');
            
        $defaults = ['Cash', 'Fuel', 'Office Supplies', 'Electricity', 'Water Bill'];
        
        $result = $suggestions->toArray();
        if (empty($q)) {
            $result = array_values(array_unique(array_merge($result, $defaults)));
        } else {
            $matchedDefaults = array_filter($defaults, function($item) use ($q) {
                return stripos($item, $q) !== false;
            });
            $result = array_values(array_unique(array_merge($result, $matchedDefaults)));
        }
        
        return response()->json(array_slice($result, 0, 10));
    }

    private function ensureEditableExpense(Transaction $transaction): void
    {
        abort_if($transaction->type !== 'expense', 403);
        abort_if($transaction->advanceRequest()->exists(), 403, self::ADVANCE_PAYMENT_MSG);
    }

    public function storeBatch(Request $request)
    {
        $request->validate([
            'transactions' => 'required|array|min:1',
            'transactions.*.transaction_date' => 'required|date',
            'transactions.*.category'         => ['required', Rule::in($this->expenseCategories)],
            'transactions.*.item_name'        => 'required|string|max:255',
            'transactions.*.amount'           => 'required|numeric|min:1',
            'transactions.*.department_id'    => 'required|exists:departments,id',
            'transactions.*.account_id'       => 'required|exists:chart_of_accounts,id',
            'transactions.*.expense_type'     => 'nullable|string|max:100',
            'transactions.*.channel_type'     => 'nullable|string|max:100',
            'transactions.*.description'      => 'nullable|string|max:500',
        ]);

        $transactionIds = [];

        \DB::transaction(function () use ($request, &$transactionIds) {
            $firstTxn = $request->input('transactions')[0];
            $year = (int) date('Y', strtotime($firstTxn['transaction_date']));
            $paymentCode = $this->calculateNextPaymentCode($year);

            foreach ($request->input('transactions') as $txnData) {
                $expenseType = $txnData['expense_type'] ?? 'ງົບປະມານວິຊາການ';
                $channelType = $txnData['channel_type'] ?? 'ເງິນບໍລິຫານທົ່ວໄປ';
                $userDesc = $txnData['description'] ?? null;

                $metadata = "[ປະເພດລາຍຈ່າຍ: {$expenseType}] [ຊ່ອງ ປຕ/ປທ: {$channelType}]";
                $finalDescription = $userDesc ? "{$metadata} {$userDesc}" : $metadata;

                $txn = Transaction::create([
                    'transaction_date' => $txnData['transaction_date'],
                    'category'         => $txnData['category'],
                    'payment_code'     => $paymentCode,
                    'item_name'        => $txnData['item_name'],
                    'amount'           => $txnData['amount'],
                    'department_id'    => $txnData['department_id'],
                    'account_id'       => $txnData['account_id'],
                    'description'      => $finalDescription,
                    'type'             => 'expense',
                ]);

                $transactionIds[] = $txn->id;
            }
        });

        return response()->json([
            'success' => true,
            'ids'     => $transactionIds,
            'message' => 'ບັນທຶກລາຍຈ່າຍສຳເລັດ',
        ]);
    }

    public function printBalance(Request $request)
    {
        $idsStr = $request->query('ids', '');
        $ids = array_filter(explode(',', $idsStr), 'is_numeric');

        if (empty($ids)) {
            abort(404, 'No transactions selected');
        }

        $transactions = Transaction::with(['department', 'chartOfAccount'])
            ->whereIn('id', $ids)
            ->where('type', 'expense')
            ->get();

        if ($transactions->isEmpty()) {
            abort(404, 'Transactions not found');
        }

        // Group by both account and department to keep them logically separated per sheet
        $grouped = $transactions->groupBy(function ($txn) {
            return $txn->account_id . '_' . $txn->department_id;
        });

        $reports = [];
        $builder = app(\App\Services\BudgetExpenseReportBuilder::class);

        foreach ($grouped as $key => $txns) {
            $firstTxn = $txns->first();
            $accountId = $firstTxn->account_id;
            $departmentId = $firstTxn->department_id;
            $year = $firstTxn->transaction_date->format('Y');
            $account = ChartOfAccount::find($accountId);

            // Fetch ALL transactions of the year for this account and department to display the full history
            $allDeptTxns = Transaction::where('type', 'expense')
                ->whereIn('account_id', ChartOfAccount::descendantIds((int) $accountId))
                ->where('department_id', $departmentId)
                ->whereYear('transaction_date', $year)
                ->orderBy('transaction_date')
                ->get();

            // Build the single combined report to get budget & running balances
            $reportData = $builder->build(
                'yearly',
                '',
                '',
                $year,
                (int) $accountId,
                (int) $departmentId,
                $allDeptTxns
            );

            $budgetLabel = $builder->budgetTypeLabel($year, (int) $accountId);

            $deptObj = $firstTxn->department;
            $deptCode = $deptObj?->dept_code ?? '';

            // Sheet 1: ຮ່ວງ level (formatted code, with budget, no department name, shows budget type label)
            $sheet1Data = [
                'account'         => $account,
                'transactions'    => $reportData['transactions'] ?? collect(),
                'budget'          => $reportData['budget'] ?? 0.0,
                'totalSpent'      => $reportData['totalSpent'] ?? 0.0,
                'periodSpent'     => $reportData['periodSpent'] ?? 0.0,
                'remaining'       => $reportData['remaining'] ?? 0.0,
                'selectedYear'    => $year,
                'budget_label'    => $budgetLabel,
                'dept_code'       => $deptCode,
                'department'      => $deptObj,
            ];

            // Sheet 2: Department/ພາກສ່ວນ level (raw code, with department budget, department name)
            // Running balance starts at department's budget_amount and decreases for each transaction
            $deptBudget = (float) ($deptObj?->budget_amount ?? 0.0);
            $deptSpent  = (float) $allDeptTxns->sum('amount');
            $deptRemaining = $deptBudget - $deptSpent;

            $deptRunning = $deptBudget;
            $deptTxns = $allDeptTxns->map(function ($t) use (&$deptRunning) {
                $clone = clone $t;
                $deptRunning -= (float) $t->amount;
                $clone->running_balance = $deptRunning;
                return $clone;
            });

            $sheet2Data = [
                'account'         => $account,
                'transactions'    => $deptTxns,
                'budget'          => $deptBudget,
                'totalSpent'      => $deptSpent,
                'periodSpent'     => $deptSpent,
                'remaining'       => $deptRemaining,
                'selectedYear'    => $year,
                'department_name' => $deptObj?->displayName() ?? ($firstTxn->department?->expenseSectionLabel() ?? 'ພາກສ່ວນກາງ'),
                'dept_code'       => $deptCode,
                'department'      => $deptObj,
            ];

            $reports[] = [
                'account' => $account,
                'sheet1'  => $sheet1Data,
                'sheet2'  => $sheet2Data,
            ];
        }

        $sigDate = now()->format('d-m-Y');

        return view('expense.expense-balance-print', compact('reports', 'sigDate'));
    }

    public function paymentHistory(Request $request)
    {
        $type = $request->query('type', 'daily');
        $date = $request->query('date', date('Y-m-d'));
        $month = $request->query('month', date('Y-m'));
        $year = $request->query('year', date('Y'));

        $query = Transaction::with(['department', 'chartOfAccount'])
            ->where('type', 'expense')
            ->whereDoesntHave('advanceRequest');

        if ($type === 'daily' && $date) {
            $query->whereDate('transaction_date', $date);
        } elseif ($type === 'monthly' && $month) {
            $parts = explode('-', $month);
            if (count($parts) === 2) {
                $query->whereYear('transaction_date', $parts[0])
                    ->whereMonth('transaction_date', $parts[1]);
            }
        } elseif ($type === 'yearly' && $year) {
            $query->whereYear('transaction_date', $year);
        }

        $summaryTotal = (float) $query->sum('amount');
        $summaryCount = (int) $query->count();

        $transactions = $query->latest('transaction_date')->paginate(10)->withQueryString();

        return view('expense.history', compact(
            'transactions',
            'type',
            'date',
            'month',
            'year',
            'summaryTotal',
            'summaryCount'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AdvanceRequest;
use App\Models\ChartOfAccount;
use App\Models\Transaction;
use App\Services\BudgetExpenseReportBuilder;
use App\Services\ReportExcelExportService;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        [$type, $date, $month, $year] = $this->validatedReportFilters($request);
        $txnType = $request->get('txn_type', 'all'); // all | income | expense

        if ($type === 'daily') {
            $incomeTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'income')->whereDate('transaction_date', $date)->get();
            $expenseTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'expense')->whereDate('transaction_date', $date)->get();
            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', fn($q) => $q->whereDate('transaction_date', $date))
                ->get();
            $year = \Carbon\Carbon::parse($date)->format('Y');

        } elseif ($type === 'yearly') {
            $incomeTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'income')->whereYear('transaction_date', $year)->get();
            $expenseTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'expense')->whereYear('transaction_date', $year)->get();
            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', fn($q) => $q->whereYear('transaction_date', $year))
                ->get();

        } else {
            // monthly
            [$year, $mon] = explode('-', $month);
            $incomeTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'income')->whereYear('transaction_date', $year)->whereMonth('transaction_date', $mon)->get();
            $expenseTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'expense')->whereYear('transaction_date', $year)->whereMonth('transaction_date', $mon)->get();
            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', fn($q) => $q->whereYear('transaction_date', $year)->whereMonth('transaction_date', $mon))
                ->get();
        }

        $deptId    = $request->get('department_id');
        $accountId = $request->get('account_id');

        if ($deptId) {
            $incomeTransactions  = $incomeTransactions->filter(fn($t) => $t->department_id == $deptId)->values();
            $expenseTransactions = $expenseTransactions->filter(fn($t) => $t->department_id == $deptId)->values();
            $requests            = $requests->filter(fn($r) => $r->department_id == $deptId)->values();
        }

        if ($accountId) {
            $incomeTransactions  = $incomeTransactions->filter(fn($t) => $t->account_id == $accountId)->values();
            $expenseTransactions = $expenseTransactions->filter(fn($t) => $t->account_id == $accountId)->values();
        }

        // Revenue Officer เห็นแค่รายรับ — ไม่แสดง Expense หรือ Advance
        $userRole = auth()->user()->role?->role_name;
        if ($userRole === 'revenue_officer') {
            $expenseTransactions = collect();
            $requests            = collect();
            $txnType = 'income'; // force income-only view
        }

        // Accountant เห็นแค่รายจ่าย — ไม่แสดง Income
        if ($userRole === 'accountant') {
            $incomeTransactions = collect();
            $txnType = 'expense'; // force expense-only view
        }

        // txn_type filter: income-only or expense-only
        if ($txnType === 'income') {
            $expenseTransactions = collect();
            $requests            = collect();
        } elseif ($txnType === 'expense') {
            $incomeTransactions = collect();
        }

        // กรอง expense transactions ที่เกิดจาก advance payment ออก (ป้องกันนับซ้ำ)
        $advancePaymentTxnIds = $requests->pluck('payment_transaction_id')->filter()->toArray();
        $expenseTransactions = $expenseTransactions->filter(
            fn($t) => !in_array($t->id, $advancePaymentTxnIds)
        )->values();

        $totalIncome  = $incomeTransactions->sum('amount');
        $totalExpense = $expenseTransactions->sum('amount') + $requests->sum('requested_amount');


        $ledger = collect();
        foreach ($incomeTransactions as $tx) {
            $ledger->push((object)[
                'id'           => $tx->id,
                'type'         => 'income',
                'date'         => $tx->transaction_date,
                'item_name'    => $tx->item_name,
                'desc'         => $tx->description,
                'payment_code' => $tx->payment_code,
                'category'     => $tx->category,
                'amount_in'    => $tx->amount,
                'amount_out'   => 0,
                'department'   => $tx->department?->department_name,
                'payment_method' => $tx->payment_method,
            ]);
        }
        foreach ($expenseTransactions as $tx) {
            $ledger->push((object)[
                'id'           => $tx->id,
                'type'         => 'expense',
                'date'         => $tx->transaction_date,
                'item_name'    => $tx->item_name,
                'desc'         => $tx->description,
                'payment_code' => $tx->payment_code,
                'category'     => $tx->category,
                'amount_in'    => 0,
                'amount_out'   => $tx->amount,
                'department'   => $tx->department?->department_name,
                'payment_method' => null,
            ]);
        }
        foreach ($requests as $req) {
            $d = $req->paymentTransaction ? $req->paymentTransaction->transaction_date : $req->request_date;
            $ledger->push((object)[
                'id'           => $req->id,
                'type'         => 'request',
                'date'         => $d,
                'item_name'    => null,
                'desc'         => $req->description . ' (ເບີກຈ່າຍລ່ວງໜ້າ)',
                'payment_code' => null,
                'category'     => null,
                'amount_in'    => 0,
                'amount_out'   => $req->requested_amount,
                'department'   => $req->department?->department_name,
                'payment_method' => null,
            ]);
        }
        $ledger = $ledger->sortBy('date')->values();

        $selectedAccountId = $accountId ? (int) $accountId : null;
        $selectedDeptId = $deptId ? (int) $deptId : null;
        $budgetReport = null;
        if ($txnType === 'expense' || $userRole === 'accountant') {
            $budgetReport = app(BudgetExpenseReportBuilder::class)->build(
                $type,
                $date,
                $month,
                $year,
                $selectedAccountId,
                $selectedDeptId,
                $expenseTransactions,
            );
        }

        $expenseAccounts = ChartOfAccount::query()
            ->whereHas('transactions', fn ($q) => $q->where('type', 'expense'))
            ->orderBy('account_code')
            ->get();

        $departments = ($txnType === 'income' || $userRole === 'revenue_officer')
            ? \App\Models\Department::whereIn('department_name', ['ປະລິນຍາໂທ', 'ປະລິນຍາຕີ', 'ປະລິນຍาເອກ'])->get()
            : \App\Models\Department::orderedForSelect();

        return view('reports.report', compact(
            'incomeTransactions', 'expenseTransactions', 'requests', 'ledger',
            'totalIncome', 'totalExpense', 'type', 'date', 'month', 'year', 'txnType',
            'budgetReport', 'selectedAccountId', 'selectedDeptId', 'expenseAccounts', 'departments',
        ));
    }

    /**
     * Download report as a real Excel workbook (.xlsx).
     */
    public function export(Request $request, ReportExcelExportService $excel): StreamedResponse
    {
        [$type, $date, $month, $year] = $this->validatedReportFilters($request);

        if ($type === 'daily') {
            $incomeTransactions  = Transaction::with('department')->where('type', 'income')->whereDate('transaction_date', $date)->get();
            $expenseTransactions = Transaction::with('department')->where('type', 'expense')->whereDate('transaction_date', $date)->get();
            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', fn ($q) => $q->whereDate('transaction_date', $date))
                ->get();
            $fileLabel = $date;

        } elseif ($type === 'yearly') {
            $incomeTransactions  = Transaction::with('department')->where('type', 'income')->whereYear('transaction_date', $year)->get();
            $expenseTransactions = Transaction::with('department')->where('type', 'expense')->whereYear('transaction_date', $year)->get();
            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', fn ($q) => $q->whereYear('transaction_date', $year))
                ->get();
            $fileLabel = $year;

        } else {
            // monthly
            [$yr, $mon] = explode('-', $month);
            $incomeTransactions  = Transaction::with('department')->where('type', 'income')->whereYear('transaction_date', $yr)->whereMonth('transaction_date', $mon)->get();
            $expenseTransactions = Transaction::with('department')->where('type', 'expense')->whereYear('transaction_date', $yr)->whereMonth('transaction_date', $mon)->get();
            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', fn ($q) => $q->whereYear('transaction_date', $yr)->whereMonth('transaction_date', $mon))
                ->get();
            $fileLabel = str_replace('-', '_', $month);
        }

        // Apply same filters as index()
        $deptId    = $request->get('department_id');
        $accountId = $request->get('account_id');
        if ($deptId) {
            $incomeTransactions  = $incomeTransactions->filter(fn($t) => $t->department_id == $deptId)->values();
            $expenseTransactions = $expenseTransactions->filter(fn($t) => $t->department_id == $deptId)->values();
            $requests            = $requests->filter(fn($r) => $r->department_id == $deptId)->values();
        }
        if ($accountId) {
            $incomeTransactions  = $incomeTransactions->filter(fn($t) => $t->account_id == $accountId)->values();
            $expenseTransactions = $expenseTransactions->filter(fn($t) => $t->account_id == $accountId)->values();
        }

        // Revenue Officer เห็นแค่รายรับ — ไม่แสดง Expense หรือ Advance
        $userRole = auth()->user()->role?->role_name;
        if ($userRole === 'revenue_officer') {
            $expenseTransactions = collect();
            $requests            = collect();
        }

        // Accountant เห็นแค่รายจ่าย — ไม่แสดง Income
        if ($userRole === 'accountant') {
            $incomeTransactions = collect();
        }

        // txn_type filter from request (only applies to roles that can see both)
        if ($userRole !== 'revenue_officer' && $userRole !== 'accountant') {
            $txnType = $request->get('txn_type', 'all');
            if ($txnType === 'income') {
                $expenseTransactions = collect();
                $requests            = collect();
            } elseif ($txnType === 'expense') {
                $incomeTransactions = collect();
            }
        }

        // กรอง expense transactions ที่เกิดจาก advance payment ออก (ป้องกันนับซ้ำ)
        $advancePaymentTxnIds = $requests->pluck('payment_transaction_id')->filter()->toArray();
        $expenseTransactions = $expenseTransactions->filter(
            fn($t) => !in_array($t->id, $advancePaymentTxnIds)
        )->values();

        $totalIncome  = $incomeTransactions->sum('amount');
        $totalExpense = $expenseTransactions->sum('amount') + $requests->sum('requested_amount');

        $spreadsheet = $excel->build([
            'incomeTransactions'  => $incomeTransactions,
            'expenseTransactions' => $expenseTransactions,
            'requests'            => $requests,
            'totalIncome'         => $totalIncome,
            'totalExpense'        => $totalExpense,
        ]);

        $filename = 'report_' . $fileLabel . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * @return array{0: string, 1: string, 2: string, 3: string}
     */
    private function validatedReportFilters(Request $request): array
    {
        $validated = $request->validate([
            'type'  => 'nullable|in:daily,monthly,yearly',
            'date'  => 'nullable|date_format:Y-m-d',
            'month' => ['nullable', 'regex:/^\d{4}-\d{2}$/'],
            'year'  => ['nullable', 'regex:/^\d{4}$/'],
        ]);

        $type  = $validated['type'] ?? 'daily';
        $date  = $validated['date'] ?? today()->toDateString();
        $month = $validated['month'] ?? today()->format('Y-m');
        $year  = $validated['year'] ?? today()->format('Y');

        return [$type, $date, $month, $year];
    }
}

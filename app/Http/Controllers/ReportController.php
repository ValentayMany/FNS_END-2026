<?php

namespace App\Http\Controllers;

use App\Models\AdvanceRequest;
use App\Models\Transaction;
use App\Services\ReportExcelExportService;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'daily');
        $date = $request->get('date', today()->toDateString());
        $month = $request->get('month', today()->format('Y-m'));
        $year = $request->get('year', today()->format('Y'));
        $departmentId = $request->get('department_id');
        $accountId = $request->get('account_id');

        $incomeQuery = Transaction::with('department', 'chartOfAccount')->where('type', 'income');
        $expenseQuery = Transaction::with('department', 'chartOfAccount')->where('type', 'expense');
        $requestQuery = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
            ->whereIn('status', ['paid', 'cleared']);

        if ($type === 'daily') {
            $incomeQuery->whereDate('transaction_date', $date);
            $expenseQuery->whereDate('transaction_date', $date);
            $requestQuery->whereHas('paymentTransaction', fn($q) => $q->whereDate('transaction_date', $date));
        } elseif ($type === 'monthly') {
            [$y, $m] = explode('-', $month);
            $incomeQuery->whereYear('transaction_date', $y)->whereMonth('transaction_date', $m);
            $expenseQuery->whereYear('transaction_date', $y)->whereMonth('transaction_date', $m);
            $requestQuery->whereHas('paymentTransaction', fn($q) => $q->whereYear('transaction_date', $y)->whereMonth('transaction_date', $m));
        } else {
            // yearly
            $incomeQuery->whereYear('transaction_date', $year);
            $expenseQuery->whereYear('transaction_date', $year);
            $requestQuery->whereHas('paymentTransaction', fn($q) => $q->whereYear('transaction_date', $year));
        }

        if ($departmentId) {
            $incomeQuery->where('department_id', $departmentId);
            $expenseQuery->where('department_id', $departmentId);
            $requestQuery->where('department_id', $departmentId);
        }

        if ($accountId) {
            $incomeQuery->where('chart_of_account_id', $accountId);
            $expenseQuery->where('chart_of_account_id', $accountId);
        }

        $incomeTransactions = $incomeQuery->get();
        $expenseTransactions = $expenseQuery->get();
        $requests = $requestQuery->get();

        $totalIncome = $incomeTransactions->sum('amount');
        $totalExpense = $expenseTransactions->sum('amount') + $requests->sum('requested_amount');

        $ledger = collect();
        foreach ($incomeTransactions as $tx) {
            $ledger->push((object)[
                'date'       => $tx->transaction_date,
                'desc'       => $tx->description,
                'amount_in'  => $tx->amount,
                'amount_out' => 0,
                'account'    => $tx->chartOfAccount?->account_name,
                'department' => $tx->department?->department_name,
            ]);
        }
        foreach ($expenseTransactions as $tx) {
            $ledger->push((object)[
                'date'       => $tx->transaction_date,
                'desc'       => $tx->description,
                'amount_in'  => 0,
                'amount_out' => $tx->amount,
                'account'    => $tx->chartOfAccount?->account_name,
                'department' => $tx->department?->department_name,
            ]);
        }
        foreach ($requests as $req) {
            $date_val = $req->paymentTransaction ? $req->paymentTransaction->transaction_date : $req->request_date;
            $ledger->push((object)[
                'date'       => $date_val,
                'desc'       => $req->description . ' (ເບີກຈ່າຍລ່ວງໜ້າ)',
                'amount_in'  => 0,
                'amount_out' => $req->requested_amount,
                'account'    => 'Advance Request',
                'department' => $req->department?->department_name,
            ]);
        }
        $ledger = $ledger->sortBy('date')->values();

        return view('reports.report', compact(
            'incomeTransactions', 'expenseTransactions', 'requests', 'ledger',
            'totalIncome', 'totalExpense',
            'type', 'date', 'month', 'year'
        ));
    }

    /**
     * Download report as a real Excel workbook (.xlsx).
     */
    public function export(Request $request, ReportExcelExportService $excel): StreamedResponse
    {
        $type = $request->get('type', 'daily');
        $date = $request->get('date', today()->toDateString());
        $month = $request->get('month', today()->format('Y-m'));
        $year = $request->get('year', today()->format('Y'));
        $departmentId = $request->get('department_id');

        $incomeQuery = Transaction::with('department')->where('type', 'income');
        $expenseQuery = Transaction::with('department')->where('type', 'expense');
        $requestQuery = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
            ->whereIn('status', ['paid', 'cleared']);

        if ($type === 'daily') {
            $incomeQuery->whereDate('transaction_date', $date);
            $expenseQuery->whereDate('transaction_date', $date);
            $requestQuery->whereHas('paymentTransaction', fn($q) => $q->whereDate('transaction_date', $date));
        } elseif ($type === 'monthly') {
            [$y, $m] = explode('-', $month);
            $incomeQuery->whereYear('transaction_date', $y)->whereMonth('transaction_date', $m);
            $expenseQuery->whereYear('transaction_date', $y)->whereMonth('transaction_date', $m);
            $requestQuery->whereHas('paymentTransaction', fn($q) => $q->whereYear('transaction_date', $y)->whereMonth('transaction_date', $m));
        } else {
            $incomeQuery->whereYear('transaction_date', $year);
            $expenseQuery->whereYear('transaction_date', $year);
            $requestQuery->whereHas('paymentTransaction', fn($q) => $q->whereYear('transaction_date', $year));
        }

        if ($departmentId) {
            $incomeQuery->where('department_id', $departmentId);
            $expenseQuery->where('department_id', $departmentId);
            $requestQuery->where('department_id', $departmentId);
        }

        $incomeTransactions = $incomeQuery->get();
        $expenseTransactions = $expenseQuery->get();
        $requests = $requestQuery->get();

        $totalIncome = $incomeTransactions->sum('amount');
        $totalExpense = $expenseTransactions->sum('amount') + $requests->sum('requested_amount');

        $spreadsheet = $excel->build([
            'incomeTransactions'  => $incomeTransactions,
            'expenseTransactions' => $expenseTransactions,
            'requests'            => $requests,
            'totalIncome'         => $totalIncome,
            'totalExpense'        => $totalExpense,
        ]);

        $suffix = $type === 'daily' ? $date : ($type === 'monthly' ? str_replace('-', '_', $month) : $year);
        $filename = 'report_' . $suffix . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}

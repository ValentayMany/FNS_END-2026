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

        if ($type === 'daily') {
            $incomeTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'income')
                ->whereDate('transaction_date', $date)
                ->get();

            $expenseTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'expense')
                ->whereDate('transaction_date', $date)
                ->get();

            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', function ($q) use ($date) {
                    $q->whereDate('transaction_date', $date);
                })
                ->get();

        } else {
            [$year, $mon] = explode('-', $month);

            $incomeTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'income')
                ->whereYear('transaction_date', $year)
                ->whereMonth('transaction_date', $mon)
                ->get();

            $expenseTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'expense')
                ->whereYear('transaction_date', $year)
                ->whereMonth('transaction_date', $mon)
                ->get();

            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', function ($q) use ($year, $mon) {
                    $q->whereYear('transaction_date', $year)
                        ->whereMonth('transaction_date', $mon);
                })
                ->get();
        }

        $totalIncome = $incomeTransactions->sum('amount');
        $totalExpense = $expenseTransactions->sum('amount');

        return view('reports.report', compact(
            'incomeTransactions', 'expenseTransactions', 'requests',
            'totalIncome', 'totalExpense',
            'type', 'date', 'month'
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

        if ($type === 'daily') {
            $incomeTransactions = Transaction::with('department')->where('type', 'income')->whereDate('transaction_date', $date)->get();
            $expenseTransactions = Transaction::with('department')->where('type', 'expense')->whereDate('transaction_date', $date)->get();
            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', fn ($q) => $q->whereDate('transaction_date', $date))
                ->get();
        } else {
            [$year, $mon] = explode('-', $month);
            $incomeTransactions = Transaction::with('department')->where('type', 'income')->whereYear('transaction_date', $year)->whereMonth('transaction_date', $mon)->get();
            $expenseTransactions = Transaction::with('department')->where('type', 'expense')->whereYear('transaction_date', $year)->whereMonth('transaction_date', $mon)->get();
            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', fn ($q) => $q->whereYear('transaction_date', $year)->whereMonth('transaction_date', $mon))
                ->get();
        }

        $totalIncome = $incomeTransactions->sum('amount');
        $totalExpense = $expenseTransactions->sum('amount');

        $spreadsheet = $excel->build([
            'incomeTransactions' => $incomeTransactions,
            'expenseTransactions' => $expenseTransactions,
            'requests' => $requests,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
        ]);

        $ascii = 'report_'.($type === 'daily' ? $date : str_replace('-', '_', $month)).'.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $ascii, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}

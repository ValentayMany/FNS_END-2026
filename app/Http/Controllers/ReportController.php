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
            $incomeTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'income')
                ->whereDate('transaction_date', $date)
                ->get();

            // expenseTransactions รวม transaction ที่ accountant บันทึก
            // และ transaction ที่ cashier สร้างตอนจ่ายเงิน (type=expense) อยู่แล้ว
            $expenseTransactions = Transaction::with('department', 'chartOfAccount')
                ->where('type', 'expense')
                ->whereDate('transaction_date', $date)
                ->get();

            // แสดง advance request เพื่อ reference — กรองด้วยวันที่จ่ายเงินจริง
            // (payment_transaction.transaction_date) ไม่ใช่ request_date
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

        $totalIncome  = $incomeTransactions->sum('amount');

        // ไม่รวม $requests->sum('requested_amount') อีกต่อไป
        // เพราะ WorkflowService::pay() สร้าง Transaction type=expense ไว้แล้ว
        // → มันอยู่ใน $expenseTransactions แล้ว รวมซ้ำจะทำให้ตัวเลขพองเกินจริง
        $totalExpense = $expenseTransactions->sum('amount');

        return view('reports.report', compact(
            'incomeTransactions', 'expenseTransactions', 'requests',
            'totalIncome', 'totalExpense',
            'type', 'date', 'month'
        ));
    }

    public function exportCsv(Request $request)
    {
        $type  = $request->get('type', 'daily');
        $date  = $request->get('date', today()->toDateString());
        $month = $request->get('month', today()->format('Y-m'));

        if ($type === 'daily') {
            $label = 'ວັນທີ_' . $date;
            $incomeTransactions = Transaction::with('department')->where('type', 'income')->whereDate('transaction_date', $date)->get();
            $expenseTransactions = Transaction::with('department')->where('type', 'expense')->whereDate('transaction_date', $date)->get();
            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', fn($q) => $q->whereDate('transaction_date', $date))
                ->get();
        } else {
            [$year, $mon] = explode('-', $month);
            $label = 'ເດືອນ_' . $month;
            $incomeTransactions = Transaction::with('department')->where('type', 'income')->whereYear('transaction_date', $year)->whereMonth('transaction_date', $mon)->get();
            $expenseTransactions = Transaction::with('department')->where('type', 'expense')->whereYear('transaction_date', $year)->whereMonth('transaction_date', $mon)->get();
            $requests = AdvanceRequest::with('requester', 'department', 'paymentTransaction')
                ->whereIn('status', ['paid', 'cleared'])
                ->whereHas('paymentTransaction', fn($q) => $q->whereYear('transaction_date', $year)->whereMonth('transaction_date', $mon))
                ->get();
        }

        $filename = 'ລາຍງານ_' . $label . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($incomeTransactions, $expenseTransactions, $requests) {
            $out = fopen('php://output', 'w');

            // BOM สำหรับ Excel เปิดภาษาลาวได้ถูกต้อง
            fputs($out, "\xEF\xBB\xBF");

            // === ລາຍຮັບ ===
            fputcsv($out, ['=== ລາຍຮັບ ===']);
            fputcsv($out, ['ວັນທີ', 'ປະເພດ', 'ລາຍລະອຽດ', 'ພາກສ່ວນ', 'ຈຳນວນ (ກີບ)']);
            foreach ($incomeTransactions as $t) {
                fputcsv($out, [
                    $t->transaction_date?->format('d/m/Y'),
                    $t->category ?? '-',
                    $t->description,
                    $t->department?->department_name,
                    number_format($t->amount, 2),
                ]);
            }
            fputcsv($out, ['', '', '', 'ລວມ', number_format($incomeTransactions->sum('amount'), 2)]);
            fputcsv($out, []);

            // === ລາຍຈ່າຍທົ່ວໄປ ===
            fputcsv($out, ['=== ລາຍຈ່າຍທົ່ວໄປ ===']);
            fputcsv($out, ['ວັນທີ', 'ປະເພດ', 'ລາຍລະອຽດ', 'ພາກສ່ວນ', 'ຈຳນວນ (ກີບ)']);
            foreach ($expenseTransactions as $t) {
                fputcsv($out, [
                    $t->transaction_date?->format('d/m/Y'),
                    $t->category ?? '-',
                    $t->description,
                    $t->department?->department_name,
                    number_format($t->amount, 2),
                ]);
            }
            fputcsv($out, ['', '', '', 'ລວມ', number_format($expenseTransactions->sum('amount'), 2)]);
            fputcsv($out, []);

            // === ລາຍຈ່າຍເງິນສົດ ===
            fputcsv($out, ['=== ລາຍຈ່າຍເງິນສົດ ===']);
            fputcsv($out, ['ວັນທີ', 'ຜູ້ຂໍ', 'ລາຍລະອຽດ', 'ພາກສ່ວນ', 'ຈຳນວນ (ກີບ)', 'ສະຖານະ']);
            foreach ($requests as $r) {
                fputcsv($out, [
                    $r->paymentTransaction?->transaction_date?->format('d/m/Y'),
                    $r->requester?->full_name ?? $r->requester?->username,
                    $r->description,
                    $r->department?->department_name,
                    number_format($r->requested_amount, 2),
                    $r->status === 'cleared' ? 'ສະສາງແລ້ວ' : 'ຈ່າຍແລ້ວ',
                ]);
            }
            fputcsv($out, ['', '', '', 'ລວມ', number_format($requests->sum('requested_amount'), 2)]);
            fputcsv($out, []);

            // === ສະຫຼຸບ ===
            $totalIncome  = $incomeTransactions->sum('amount');
            $totalExpense = $expenseTransactions->sum('amount');
            fputcsv($out, ['=== ສະຫຼຸບ ===']);
            fputcsv($out, ['ລາຍຮັບລວມ', number_format($totalIncome, 2)]);
            fputcsv($out, ['ລາຍຈ່າຍລວມ', number_format($totalExpense, 2)]);
            fputcsv($out, ['ຍອດຄົງເຫຼືອ', number_format($totalIncome - $totalExpense, 2)]);

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}

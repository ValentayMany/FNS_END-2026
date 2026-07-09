<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Department;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RevenueController extends Controller
{
    private array $incomeCategories = [
        'ຄ່າລົງທະບຽນ',
        'ຄ່າໜ່ວຍກິດ',
        'ຄ່າໜ່ວຍກິດເທີມ 3',
        'ຄ່າບໍລິການວິຊາການ',
    ];

    public function dashboard(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $departments = Department::where('department_type', 'income')
            ->orWhere('department_name', 'like', '%ປະລິນ%')
            ->orderBy('id')
            ->get();
        $deptIds = $departments->pluck('id')->toArray();

        // 1. Selected Period Stats
        $periodTransactions = Transaction::where('type', 'income')
            ->whereDate('transaction_date', '>=', $startDate)
            ->whereDate('transaction_date', '<=', $endDate)
            ->whereIn('department_id', $deptIds)
            ->get();

        $dailyStats = [];
        foreach ($departments as $dept) {
            $deptTxns = $periodTransactions->where('department_id', $dept->id);
            $st = [
                'total' => $deptTxns->sum('amount'),
                'cash' => $deptTxns->where('payment_method', 'cash')->sum('amount'),
                'transfer' => $deptTxns->where('payment_method', 'transfer')->sum('amount'),
            ];
            $dailyStats[$dept->id] = $st;
            $dailyStats[$dept->department_name] = $st;
            $dailyStats[str_replace(['ຢ', 'ມ'], ['ຍ', 'ນ'], $dept->department_name)] = $st;
        }

        // 2. Overall Stats (All-time Grand Total)
        $allTransactions = Transaction::where('type', 'income')
            ->whereIn('department_id', $deptIds)
            ->get();

        $overallStats = [];
        foreach ($departments as $dept) {
            $deptTxns = $allTransactions->where('department_id', $dept->id);
            $st = [
                'total' => $deptTxns->sum('amount'),
                'cash' => $deptTxns->where('payment_method', 'cash')->sum('amount'),
                'transfer' => $deptTxns->where('payment_method', 'transfer')->sum('amount'),
            ];
            $overallStats[$dept->id] = $st;
            $overallStats[$dept->department_name] = $st;
            $overallStats[str_replace(['ຢ', 'ມ'], ['ຍ', 'ນ'], $dept->department_name)] = $st;
        }

        // 3. Daily Trend Data (Line Chart)
        $dailyTrendsRaw = Transaction::where('type', 'income')
            ->whereDate('transaction_date', '>=', $startDate)
            ->whereDate('transaction_date', '<=', $endDate)
            ->whereIn('department_id', $deptIds)
            ->selectRaw('transaction_date, 
                SUM(amount) as total,
                SUM(CASE WHEN payment_method = "cash" THEN amount ELSE 0 END) as cash,
                SUM(CASE WHEN payment_method = "transfer" THEN amount ELSE 0 END) as transfer')
            ->groupBy('transaction_date')
            ->orderBy('transaction_date')
            ->get()
            ->keyBy(function($item) {
                return \Carbon\Carbon::parse($item->transaction_date)->toDateString();
            });

        $dailyTrends = collect();
        $currentDate = \Carbon\Carbon::parse($startDate);
        $endDateObj = \Carbon\Carbon::parse($endDate);
        
        while ($currentDate <= $endDateObj) {
            $dateStr = $currentDate->toDateString();
            if ($dailyTrendsRaw->has($dateStr)) {
                $dailyTrends->push($dailyTrendsRaw->get($dateStr));
            } else {
                $dailyTrends->push((object)[
                    'transaction_date' => $dateStr,
                    'total' => 0,
                    'cash' => 0,
                    'transfer' => 0
                ]);
            }
            $currentDate->addDay();
        }

        // 4. Payment Method Proportion (Doughnut Chart)
        $paymentBreakdown = [
            'cash' => $periodTransactions->where('payment_method', 'cash')->sum('amount'),
            'transfer' => $periodTransactions->where('payment_method', 'transfer')->sum('amount'),
        ];

        // 5. Recent Transactions in this period (take 10)
        $recentTransactions = Transaction::with('department')
            ->where('type', 'income')
            ->whereDate('transaction_date', '>=', $startDate)
            ->whereDate('transaction_date', '<=', $endDate)
            ->whereIn('department_id', $deptIds)
            ->latest('transaction_date')
            ->latest('id')
            ->take(10)
            ->get();

        $sumTotal = $periodTransactions->sum('amount');

        return view('revenue.dashboard', compact(
            'departments',
            'dailyStats',
            'overallStats',
            'startDate',
            'endDate',
            'dailyTrends',
            'paymentBreakdown',
            'recentTransactions',
            'sumTotal'
        ));
    }

    public function index()
    {
        $transactions = Transaction::with('department', 'chartOfAccount')
            ->where('type', 'income')
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(15);

        $departments = Department::where('department_type', 'income')
            ->orWhere('department_name', 'like', '%ປະລິນ%')
            ->orderBy('id')
            ->get();
        $deptIds = $departments->pluck('id')->toArray();
        $categories = $this->incomeCategories;

        // Daily Stats (Today)
        $today = today()->toDateString();
        $todayTransactions = Transaction::where('type', 'income')
            ->whereDate('transaction_date', $today)
            ->whereIn('department_id', $deptIds)
            ->get();

        $dailyStats = [];
        foreach ($departments as $dept) {
            $deptTxns = $todayTransactions->where('department_id', $dept->id);
            $st = [
                'total' => $deptTxns->sum('amount'),
                'cash' => $deptTxns->where('payment_method', 'cash')->sum('amount'),
                'transfer' => $deptTxns->where('payment_method', 'transfer')->sum('amount'),
            ];
            $dailyStats[$dept->id] = $st;
            $dailyStats[$dept->department_name] = $st;
            $dailyStats[str_replace(['ຢ', 'ມ'], ['ຍ', 'ນ'], $dept->department_name)] = $st;
        }

        // Overall Stats (All-time)
        $allTransactions = Transaction::where('type', 'income')
            ->whereIn('department_id', $deptIds)
            ->get();

        $overallStats = [];
        foreach ($departments as $dept) {
            $deptTxns = $allTransactions->where('department_id', $dept->id);
            $st = [
                'total' => $deptTxns->sum('amount'),
                'cash' => $deptTxns->where('payment_method', 'cash')->sum('amount'),
                'transfer' => $deptTxns->where('payment_method', 'transfer')->sum('amount'),
            ];
            $overallStats[$dept->id] = $st;
            $overallStats[$dept->department_name] = $st;
            $overallStats[str_replace(['ຢ', 'ມ'], ['ຍ', 'ນ'], $dept->department_name)] = $st;
        }

        // Next payment_code (auto-suggest)
        $lastCode = Transaction::where('type', 'income')
            ->whereNotNull('payment_code')
            ->orderByDesc('id')
            ->value('payment_code');
        $nextCode = null;
        if ($lastCode && preg_match('/\d+$/', $lastCode, $m)) {
            $num    = intval($m[0]) + 1;
            $prefix = substr($lastCode, 0, strlen($lastCode) - strlen($m[0]));
            $nextCode = $prefix . str_pad($num, strlen($m[0]), '0', STR_PAD_LEFT);
        } elseif ($lastCode) {
            $nextCode = $lastCode; // can't parse, just show same
        }

        return view('revenue.revenue', compact('transactions', 'departments', 'categories', 'dailyStats', 'overallStats', 'nextCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'category'         => 'required|string',
            'custom_category'  => 'required_if:category,__custom__|nullable|string|max:100',
            'description'      => 'nullable|string|max:500',
            'amount'           => 'required|numeric|min:1',
            'department_id'    => 'required|exists:departments,id',
            'payment_method'   => 'required|in:cash,transfer',
            'payment_code'     => 'nullable|string|max:50',
        ]);

        $category = $request->input('category');
        if ($category === '__custom__') {
            $category = $request->input('custom_category');
        }

        Transaction::create([
            'transaction_date' => $request->input('transaction_date'),
            'category'         => $category,
            'description'      => $request->input('description'),
            'amount'           => $request->input('amount'),
            'department_id'    => $request->input('department_id'),
            'payment_method'   => $request->input('payment_method'),
            'payment_code'     => $request->input('payment_code'),
            'type'             => 'income',
        ]);

        return back()->with('success', 'ບັນທຶກລາຍຮັບສຳເລັດ');
    }

    public function edit(Transaction $transaction)
    {
        abort_if($transaction->type !== 'income', 403);

        $departments = Department::where('department_type', 'income')
            ->orWhere('department_name', 'like', '%ປະລິນ%')
            ->orderBy('id')
            ->get();
        $categories = $this->incomeCategories;

        return view('revenue.edit', compact('transaction', 'departments', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        abort_if($transaction->type !== 'income', 403);

        $request->validate([
            'transaction_date' => 'required|date',
            'category'         => 'required|string',
            'custom_category'  => 'required_if:category,__custom__|nullable|string|max:100',
            'description'      => 'nullable|string|max:500',
            'amount'           => 'required|numeric|min:1',
            'department_id'    => 'required|exists:departments,id',
            'payment_method'   => 'required|in:cash,transfer',
            'payment_code'     => 'nullable|string|max:50',
        ]);

        $category = $request->input('category');
        if ($category === '__custom__') {
            $category = $request->input('custom_category');
        }

        $transaction->update([
            'transaction_date' => $request->input('transaction_date'),
            'category'         => $category,
            'description'      => $request->input('description'),
            'amount'           => $request->input('amount'),
            'department_id'    => $request->input('department_id'),
            'payment_method'   => $request->input('payment_method'),
            'payment_code'     => $request->input('payment_code'),
        ]);

        return redirect()->route('revenue.index')->with('success', 'ແກ້ໄຂລາຍຮັບສຳເລັດ');
    }

    public function destroy(Transaction $transaction)
    {
        abort_if($transaction->type !== 'income', 403);

        $transaction->delete();

        return back()->with('success', 'ລຶບລາຍຮັບສຳເລັດ');
    }

    public function destroyBatch(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $count = Transaction::where('type', 'income')
                ->whereIn('id', $ids)
                ->delete();
            return back()->with('success', 'ລຶບລາຍການທີ່ເລືອກສຳເລັດແລ້ວ (' . $count . ' ລາຍການ)');
        }
        return back()->with('error', 'ກະລຸນາເລືອກລາຍການທີ່ຕ້ອງການລຶບ');
    }

    public function history(Request $request)
    {
        $type = $request->query('type', 'daily');
        $date = $request->query('date', date('Y-m-d'));
        $month = $request->query('month', date('Y-m'));
        $year = $request->query('year', date('Y'));

        $query = Transaction::with('department')
            ->where('type', 'income');

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

        return view('revenue.history', compact(
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

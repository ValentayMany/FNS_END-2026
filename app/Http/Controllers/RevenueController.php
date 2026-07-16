<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Department;
use App\Models\Student;
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
            'department_id'    => 'required|exists:departments,id',
            'payment_method'   => 'required|in:cash,transfer',
            'payment_code'     => 'nullable|string|max:50',
            'description'      => 'nullable|string|max:500',
            'student_id'       => 'nullable|exists:student,id',
            // fee items — ถ้าเลือกนักศึกษา
            'fees'             => 'nullable|array',
            'fees.*.label'     => 'required_with:fees|string',
            'fees.*.amount'    => 'required_with:fees|numeric|min:0',
            // fallback single amount (กรณีไม่เลือกนักศึกษา)
            'amount'           => 'nullable|numeric|min:0',
            'revenue_channel'  => 'nullable|string|max:100',
        ]);

        $receiptNo      = $request->input('payment_code');
        $studentId      = $request->input('student_id') ?: null;
        $date           = $request->input('transaction_date');
        $deptId         = $request->input('department_id');
        $method         = $request->input('payment_method');
        $desc           = $request->input('description');
        $fees           = $request->input('fees', []);
        $revenueChannel = $request->input('revenue_channel');

        if (!empty($fees)) {
            // รวม fees ทั้งหมดเป็น 1 transaction
            $totalAmount = 0;
            $feeBreakdown = []; // เก็บ breakdown เพื่อ print
            $firstLabel  = null;
            foreach ($fees as $fee) {
                $amt = floatval($fee['amount'] ?? 0);
                $label = $fee['label'] ?? '';
                if ($amt <= 0) continue;
                $totalAmount += $amt;
                $feeBreakdown[$label] = $amt;
                if (!$firstLabel) $firstLabel = $label ?: 'ລາຍຮັບ';
            }

            if ($totalAmount > 0) {
                // เก็บ breakdown เป็น JSON ใน description (ถ้าผู้ใช้ไม่พิมพ์ description เอง)
                $autoDesc = $desc ?: json_encode($feeBreakdown, JSON_UNESCAPED_UNICODE);
                Transaction::create([
                    'transaction_date' => $date,
                    'category'         => $firstLabel ?? 'ລາຍຮັບ',
                    'description'      => $autoDesc,
                    'amount'           => $totalAmount,
                    'department_id'    => $deptId,
                    'payment_method'   => $method,
                    'payment_code'     => $receiptNo,
                    'receipt_no'       => $receiptNo,
                    'student_id'       => $studentId,
                    'revenue_channel'  => $revenueChannel ?: null,
                    'type'             => 'income',
                    'item_name'        => $firstLabel ?? 'ລາຍຮັບ',
                ]);
            }
        } else {
            // บันทึกรายการเดียว (แบบเดิม)
            $category = $request->input('category', 'ລາຍຮັບທົ່ວໄປ');
            if ($category === '__custom__') {
                $category = $request->input('custom_category');
            }
            Transaction::create([
                'transaction_date' => $date,
                'category'         => $category,
                'description'      => $desc,
                'amount'           => $request->input('amount', 0),
                'department_id'    => $deptId,
                'payment_method'   => $method,
                'payment_code'     => $receiptNo,
                'receipt_no'       => $receiptNo,
                'student_id'       => $studentId,
                'revenue_channel'  => $revenueChannel ?: null,
                'type'             => 'income',
            ]);
        }

        return back()->with('success', 'ບັນທຶກລາຍຮັບສຳເລັດ (1 ລາຍການ)');

    }

    /**
     * AJAX: ค้นหานักศึกษาจากรหัสหรือชื่อ
     */
    public function searchStudents(Request $request)
    {
        $keyword = $request->input('q', '');
        if (strlen($keyword) < 2) {
            return response()->json([]);
        }

        $students = Student::with('degreeProgram')
            ->search($keyword)
            ->limit(15)
            ->get()
            ->map(function ($s) {
                return [
                    'id'           => $s->id,
                    'student_code' => $s->student_code,
                    'full_name'    => $s->full_name,
                    'name_prefix'  => $s->name_prefix,
                    'display'      => $s->student_code . ' - ' . $s->name_prefix . ' ' . $s->full_name,
                    'program_name' => $s->degreeProgram?->name ?? '-',
                    'study_year'   => $s->study_year,
                    'program_id'   => $s->degree_program_id,
                    'level'        => $s->degreeProgram?->level ?? 'bachelor',
                ];
            });

        return response()->json($students);
    }

    /**
     * AJAX: ดึงค่าธรรมเนียมของนักศึกษาตาม program + year
     */
    public function getStudentFees(Student $student)
    {
        $student->load('degreeProgram');
        $level     = $student->degreeProgram?->level ?? 'bachelor';
        $studyYear = $student->study_year ?? 1;

        // ดึงราคาต่อหน่วยกิต: ดึงตามหลักสูตรและชั้นปีของอาจารย์ก่อน (creditrate)
        $creditPrice = 0;
        if (!empty($student->COURSEID)) {
            $creditPrice = \DB::table('creditrate')
                ->where('COURSEID', $student->COURSEID)
                ->where('YEARLEVEL', $studyYear)
                ->value('CREDITRATE') ?? 0;
        }

        // หากไม่พบข้อมูลในตารางอาจารย์ ให้ใช้ระบบตั้งราคาเดิม (Fallback)
        if (!$creditPrice) {
            $creditPrice = \DB::table('credit_unit_price_settings')
                ->where('level', $level)
                ->orderByDesc('start_year')
                ->value('credit_unit_price') ?? 0;
        }

        // ดึงจำนวนหน่วยกิต
        $creditUnit = 0;
        if ($student->degree_program_id) {
            $creditUnit = \DB::table('course_credit_settings')
                ->where('degree_program_id', $student->degree_program_id)
                ->orderByDesc('start_year')
                ->value('course_credit_unit') ?? 0;
        }

        // Fallback default credits if not found (e.g. for custom courses like SCB or missing mappings)
        if ($creditUnit <= 0) {
            $creditUnit = match(strtolower($level)) {
                'master', 'phd' => 100,
                default => 33, // Default Bachelor credits
            };
        }

        // ดึงค่าลงทะเบียนตามชั้นปีเรียน (ปี 1 = นศ.ใหม่ ID 27, ปี 2-4 = นศ.เก่า ID 26)
        $targetSettingId = ($studyYear == 1) ? 27 : 26;

        $regSetting = \DB::table('registration_fee_settings')
            ->where('id', $targetSettingId)
            ->first();

        // Fallback ถ้าไม่พบไอดี ให้ดึงล่าสุด
        if (!$regSetting) {
            $regSetting = \DB::table('registration_fee_settings')
                ->orderByDesc('start_year')
                ->first();
        }

        $regItems = [];
        if ($regSetting) {
            $regItems = \DB::table('registration_fee_items')
                ->where('fee_setting_id', $regSetting->id)
                ->orderBy('sort_order')
                ->get();
        }

        // สร้างรายการค่าธรรมเนียม
        $fees = [];

        // แยกค่าบำรุงหอสมุดและห้องแล็บ (ຫທລ) ออกมา
        $totalReg = collect($regItems)->sum('amount');
        $maintenanceNames = ['ບຳລຸງຫ້ອງອ່ານ', 'ບຳລຸງຫ້ອງທົດລອງ'];
        $maintenanceSum = collect($regItems)->whereIn('name', $maintenanceNames)->sum('amount');
        
        // ค่าลงทะเบียนหลัก (หักค่าบำรุงหอสมุดและแล็บออก)
        $baseReg = $totalReg - $maintenanceSum;

        $fees[] = [
            'label'    => 'ຄ່າລົງທະບຽນ',
            'amount'   => (float) $baseReg,
            'editable' => true, // ทำให้ผู้ใช้แก้ไขได้ถ้าต้องการ
        ];

        // ค่าหน่วยกิต
        $fees[] = [
            'label'    => 'ຄ່າໜ່ວຍກິດ',
            'amount'   => (float) ($creditUnit * $creditPrice),
            'editable' => true,
        ];

        // ค่าบูรณะ หทล
        $fees[] = [
            'label'    => 'ຄ່າບູລະນະ ຫທລ',
            'amount'   => (float) $maintenanceSum,
            'editable' => true,
        ];

        // ค่าหน่วยกิต ทส (เทอม 3)
        $fees[] = [
            'label'    => 'ຄ່າໜ່ວຍກິດ ທສ',
            'amount'   => 0.0,
            'editable' => true,
        ];

        // ค่าบริการอื่นๆ
        $fees[] = [
            'label'    => 'ຄ່າບໍລິການອື່ນໆ',
            'amount'   => 0.0,
            'editable' => true,
        ];

        // สร้างรายละเอียดรายการย่อยส่งกลับไปด้วย
        $registrationBreakdown = [];
        $maintenanceBreakdown = [];
        foreach ($regItems as $item) {
            if (in_array($item->name, $maintenanceNames)) {
                $maintenanceBreakdown[] = [
                    'name' => $item->name,
                    'amount' => (float) $item->amount,
                ];
            } else {
                $registrationBreakdown[] = [
                    'name' => $item->name,
                    'amount' => (float) $item->amount,
                ];
            }
        }

        return response()->json([
            'student' => [
                'id'           => $student->id,
                'student_code' => $student->student_code,
                'full_name'    => $student->full_name,
                'name_prefix'  => $student->name_prefix,
                'program_name' => $student->degreeProgram?->name ?? '-',
                'study_year'   => $studyYear,
                'level'        => $level,
            ],
            'fees' => $fees,
            'breakdown' => [
                'registration' => $registrationBreakdown,
                'maintenance' => $maintenanceBreakdown,
            ],
        ]);
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
            'revenue_channel'  => 'nullable|string|max:100',
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
            'revenue_channel'  => $request->input('revenue_channel') ?: null,
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

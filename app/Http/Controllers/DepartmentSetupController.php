<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentSetupController extends Controller
{
    /**
     * ສະແດງໜ້າຈັດການພາກ/ສ່ວນ (ສະເພາະ head_of_finance)
     */
    public function index()
    {
        $year = date('Y');
        $departments = Department::orderBy('dept_code')
            ->orderBy('department_name')
            ->get()
            ->map(function ($dept) use ($year) {
                // Calculate spent amount for current year
                $spent = (float) Transaction::where('type', 'expense')
                    ->where('department_id', $dept->id)
                    ->whereYear('transaction_date', $year)
                    ->sum('amount');

                $initial = (float) ($dept->initial_budget ?? 0);
                $remaining = (float) ($dept->budget_amount ?? 0);

                if ($initial == 0 && ($remaining + $spent) > 0) {
                    $initial = $remaining + $spent;
                }

                $pct = ($initial > 0) ? min(100, round(($spent / $initial) * 100, 1)) : 0;

                $dept->_initial = $initial;
                $dept->_spent = $spent;
                $dept->_pct = $pct;

                return $dept;
            });

        return view('department-setup.index', compact('departments'));
    }

    /**
     * ເພີ່ມພາກ/ສ່ວນໃໝ່
     */
    public function store(Request $request)
    {
        $request->validate([
            'dept_code'       => 'nullable|string|max:20',
            'department_name' => 'required|string|max:255|unique:departments,department_name',
            'department_type' => 'nullable|string|max:255',
            'budget_amount'   => 'nullable|numeric|min:0',
        ], [
            'department_name.required' => 'ກະລຸນາໃສ່ຊື່ພາກ/ສ່ວນ',
            'department_name.unique'   => 'ຊື່ພາກ/ສ່ວນນີ້ມີຢູ່ໃນລະບົບແລ້ວ',
        ]);

        $budget = (float) ($request->budget_amount ?? 0);

        Department::create([
            'dept_code'       => trim($request->dept_code ?? ''),
            'department_name' => trim($request->department_name),
            'department_type' => trim($request->department_type ?? ''),
            'budget_amount'   => $budget,
            'initial_budget'  => $budget,  // ບັນທຶກງົບຕັ້ງຕົ້ນ
        ]);

        return back()->with('success', 'ເພີ່ມພາກ/ສ່ວນສຳເລັດ!');
    }

    /**
     * ອັບເດດພາກ/ສ່ວນ
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'dept_code'       => 'nullable|string|max:20',
            'department_name' => [
                'required', 'string', 'max:255',
                Rule::unique('departments', 'department_name')->ignore($department->id),
            ],
            'department_type' => 'nullable|string|max:255',
            'budget_amount'   => 'nullable|numeric|min:0',
        ], [
            'department_name.required' => 'ກະລຸນາໃສ່ຊື່ພາກ/ສ່ວນ',
            'department_name.unique'   => 'ຊື່ພາກ/ສ່ວນນີ້ມີຢູ່ໃນລະບົບແລ້ວ',
        ]);

        $newBudget = (float) ($request->budget_amount ?? 0);

        // Calculate spent amount for the current year
        $year = date('Y');
        $spent = (float) Transaction::where('type', 'expense')
            ->where('department_id', $department->id)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $department->update([
            'dept_code'       => trim($request->dept_code ?? ''),
            'department_name' => trim($request->department_name),
            'department_type' => trim($request->department_type ?? ''),
            'budget_amount'   => $newBudget - $spent,
            'initial_budget'  => $newBudget,
        ]);

        return back()->with('success', 'ແກ້ໄຂຂໍ້ມູນພາກ/ສ່ວນສຳເລັດ!');
    }

    /**
     * ລຶບພາກ/ສ່ວນ
     */
    public function destroy(Department $department)
    {
        // 1. ຫາພາກສ່ວນກາງເພື່ອເປັນບ່ອນຮອງຮັບຂໍ້ມູນ (Fallback Department)
        $fallbackDept = Department::where('department_type', 'central')
            ->orWhere('department_name', 'ພາກສ່ວນກາງ')
            ->orWhere('department_name', 'ສ່ວນກາງ')
            ->first();

        // ຖ້າບໍ່ມີພາກສ່ວນກາງ ໃຫ້ໃຊ້ພາກສ່ວນທຳອິດທີ່ບໍ່ແມ່ນຕົວທີ່ຈະລຶບ
        if (!$fallbackDept) {
            $fallbackDept = Department::where('id', '!=', $department->id)->first();
        }

        // ຖ້າບໍ່ມີພາກສ່ວນອື່ນເລີຍ ຫຼື ພາກສ່ວນທີ່ຈະລຶບແມ່ນພາກສ່ວນກາງຫຼັກ ບໍ່ໃຫ້ລຶບ
        if (!$fallbackDept || $department->id === $fallbackDept->id) {
            return back()->with('error', 'ບໍ່ສາມາດລຶບພາກສ່ວນກາງຫຼັກໄດ້ — ຕ້ອງມີຢ່າງໜ້ອຍໜຶ່ງພາກສ່ວນໄວ້ຮອງຮັບຂໍ້ມູນໃນລະບົບ');
        }

        // 2. ຍ້າຍຂໍ້ມູນທີ່ກ່ຽວຂ້ອງທັງໝົດໄປຫາພາກສ່ວນກາງ (Fallback)
        $userCount = $department->users()->count();
        if ($userCount > 0) {
            $department->users()->update(['department_id' => $fallbackDept->id]);
        }

        $requestCount = $department->advanceRequests()->count();
        if ($requestCount > 0) {
            $department->advanceRequests()->update(['department_id' => $fallbackDept->id]);
        }

        $txnCount = $department->transactions()->count();
        if ($txnCount > 0) {
            $department->transactions()->update(['department_id' => $fallbackDept->id]);
        }

        // 3. ລຶບພາກສ່ວນ
        $name = $department->displayName();
        $department->delete();

        // ສ້າງຂໍ້ຄວາມແຈ້ງເຕືອນໃຫ້ລະອຽດ
        $msg = 'ລຶບ "' . $name . '" ສຳເລັດ!';
        $transferred = [];
        if ($userCount > 0) {
            $transferred[] = "ຜູ້ໃຊ້ງານ {$userCount} ຄົນ";
        }
        if ($requestCount > 0) {
            $transferred[] = "ຄຳຂໍເບີກ {$requestCount} ລາຍການ";
        }
        if ($txnCount > 0) {
            $transferred[] = "ລາຍການລາຍຮັບ-ລາຍຈ່າຍ {$txnCount} ລາຍການ";
        }

        if (!empty($transferred)) {
            $msg .= ' (ໄດ້ຍ້າຍ ' . implode(', ', $transferred) . ' ໄປຫາ "' . $fallbackDept->displayName() . '" ແລ້ວ)';
        }

        return back()->with('success', $msg);
    }

    /**
     * ໜ້າ Dashboard ງົບປະມານຂອງແຕ່ລະພາກ/ສ່ວນ
     */
    public function budgetDashboard()
    {
        $year = request()->query('year', date('Y'));

        $departments = Department::orderBy('dept_code')
            ->orderBy('department_name')
            ->get()
            ->map(function ($dept) use ($year) {
                // ຍອດລາຍຈ່າຍຈິງທັງໝົດຂອງພາກສ່ວນນີ້ (ໃນປີທີ່ເລືອກ)
                $spent = (float) Transaction::where('type', 'expense')
                    ->where('department_id', $dept->id)
                    ->whereYear('transaction_date', $year)
                    ->sum('amount');

                $initial   = (float) ($dept->initial_budget ?? 0);
                $remaining = (float) ($dept->budget_amount ?? 0);

                // ຖ້າ initial ຍັງ = 0 ໃຫ້ໃຊ້ remaining + spent ເປັນຕົວຄາດຄະເນ
                if ($initial == 0 && ($remaining + $spent) > 0) {
                    $initial = $remaining + $spent;
                }

                $pct = ($initial > 0) ? min(100, round(($spent / $initial) * 100, 1)) : 0;

                $dept->_initial   = $initial;
                $dept->_spent     = $spent;
                $dept->_remaining = $remaining;
                $dept->_pct       = $pct;

                return $dept;
            });

        // ສະຫຼຸບລວມທຸກພາກ
        $totalInitial   = $departments->sum('_initial');
        $totalSpent     = $departments->sum('_spent');
        $totalRemaining = $departments->sum('_remaining');

        // ດຶງລາຍການປີທີ່ມີຂໍ້ມູນຢູ່
        $availableYears = Transaction::where('type', 'expense')
            ->selectRaw('YEAR(transaction_date) as yr')
            ->groupBy('yr')
            ->orderByDesc('yr')
            ->pluck('yr');

        return view('department-setup.budget-dashboard', compact(
            'departments',
            'year',
            'totalInitial',
            'totalSpent',
            'totalRemaining',
            'availableYears'
        ));
    }
}

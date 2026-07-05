<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentSetupController extends Controller
{
    /**
     * ສະແດງໜ້າຈັດການພາກ/ສ່ວນ (ສະເພາະ head_of_finance)
     */
    public function index()
    {
        $departments = Department::orderBy('dept_code')->orderBy('department_name')->get();
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

        Department::create([
            'dept_code'       => trim($request->dept_code ?? ''),
            'department_name' => trim($request->department_name),
            'department_type' => trim($request->department_type ?? ''),
            'budget_amount'   => $request->budget_amount ?? 0,
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

        $department->update([
            'dept_code'       => trim($request->dept_code ?? ''),
            'department_name' => trim($request->department_name),
            'department_type' => trim($request->department_type ?? ''),
            'budget_amount'   => $request->budget_amount ?? 0,
        ]);

        return back()->with('success', 'ແກ້ໄຂຂໍ້ມູນພາກ/ສ່ວນສຳເລັດ!');
    }

    /**
     * ລຶບພາກ/ສ່ວນ
     */
    public function destroy(Department $department)
    {
        $blockers = [];

        $userCount = $department->users()->count();
        if ($userCount > 0) {
            $blockers[] = "ຜູ້ໃຊ້ງານ {$userCount} ຄົນ";
        }

        $requestCount = $department->advanceRequests()->count();
        if ($requestCount > 0) {
            $blockers[] = "ຄຳຂໍເບີກຈ່າຍ {$requestCount} ລາຍການ";
        }

        $txnCount = $department->transactions()->count();
        if ($txnCount > 0) {
            $blockers[] = "ລາຍການລາຍຈ່າຍ/ລາຍຮັບ {$txnCount} ລາຍການ";
        }

        if (!empty($blockers)) {
            return back()->with('error',
                'ບໍ່ສາມາດລຶບ "' . $department->displayName() . '" ໄດ້ — ' .
                'ຍັງມີຂໍ້ມູນທີ່ອ້າງອີງຢູ່: ' . implode(', ', $blockers)
            );
        }

        $department->delete();

        return back()->with('success', 'ລຶບ "' . $department->displayName() . '" ສຳເລັດ!');
    }
}

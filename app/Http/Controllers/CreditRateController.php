<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CreditRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditRateController extends Controller
{
    /**
     * Display a listing of courses and their credit rates for years 1-4.
     */
    public function index()
    {
        // 1. ดึงหลักสูตรทั้งหมด
        $courses = Course::orderBy('COURSEID')->get();

        // 2. ดึงอัตราหน่วยกิตทั้งหมดที่มีการระบุไว้
        $ratesRaw = DB::table('creditrate')->get();

        // จัดรูปอาร์เรย์ให้เป็น $rates[COURSEID][YEARLEVEL] = CREDITRATE เพื่อความสะดวกในการแสดงผล
        $rates = [];
        foreach ($ratesRaw as $r) {
            $rates[$r->COURSEID][$r->YEARLEVEL] = $r->CREDITRATE;
        }

        // คาดการณ์ระดับการเรียน (bachelor, master, phd) เพื่อแสดงอัตรามาตรฐานหากเป็นค่าว่าง
        $defaultRates = [
            'bachelor' => 35000,
            'master' => 240000,
            'phd' => 600000
        ];

        // ดึงแผนก/สาขาวิชาเพื่อป้อนให้กับเมนูเพิ่มหลักสูตร
        $departments = DB::table('departments')
            ->orderBy('id')
            ->get();

        // ดึงค่าธรรมเนียมການລົງທະບຽນສໍາລັບນັກສຶກສາເກົ່າ (ID 26) ແລະ ນັກສຶກສາໃໝ່ (ID 27)
        $oldRegItems = DB::table('registration_fee_items')
            ->where('fee_setting_id', 26)
            ->orderBy('sort_order')
            ->get();
            
        $newRegItems = DB::table('registration_fee_items')
            ->where('fee_setting_id', 27)
            ->orderBy('sort_order')
            ->get();

        // Pair items to display side-by-side in rows
        $pairedRegItems = [];
        $matchedOldIds = [];

        foreach ($newRegItems as $newItem) {
            $matchName = $newItem->name;
            if ($matchName === 'ຄ່າທຳນຽມລົງທະບຽນປະຈໍາປີ' || $matchName === 'ຄ່າທຳນຽມລົງທະບຽນປະຈຳປີ') {
                $matchName = 'ຄ່າທຳນຽມນັກສຶກສາລົງທະບຽນ';
            }
            
            $oldItem = collect($oldRegItems)->first(function($item) use ($matchName, $matchedOldIds) {
                return $item->name === $matchName && !in_array($item->id, $matchedOldIds);
            });
            
            if ($oldItem) {
                $matchedOldIds[] = $oldItem->id;
            }
            
            $pairedRegItems[] = [
                'name' => $newItem->name,
                'new_id' => $newItem->id,
                'new_amount' => $newItem->amount,
                'old_id' => $oldItem ? $oldItem->id : null,
                'old_amount' => $oldItem ? $oldItem->amount : 0,
            ];
        }

        foreach ($oldRegItems as $oldItem) {
            if (!in_array($oldItem->id, $matchedOldIds)) {
                $pairedRegItems[] = [
                    'name' => $oldItem->name,
                    'new_id' => null,
                    'new_amount' => 0,
                    'old_id' => $oldItem->id,
                    'old_amount' => $oldItem->amount,
                ];
            }
        }

        return view('revenue.credit_rates', compact(
            'courses', 
            'rates', 
            'defaultRates', 
            'departments', 
            'oldRegItems', 
            'newRegItems',
            'pairedRegItems'
        ));
    }

    /**
     * Batch update credit rates for courses.
     */
    public function update(Request $request)
    {
        $request->validate([
            'rates' => 'required|array',
        ]);

        $ratesData = $request->input('rates', []);

        DB::beginTransaction();
        try {
            foreach ($ratesData as $courseId => $years) {
                foreach ($years as $yearLevel => $rateValue) {
                    // หากค่าเป็นว่าง ให้บันทึกเป็น 0 หรือปล่อยข้ามไป
                    $rateValue = $rateValue !== null ? floatval(str_replace(',', '', $rateValue)) : 0;

                    DB::table('creditrate')->updateOrInsert(
                        [
                            'COURSEID' => $courseId,
                            'YEARLEVEL' => intval($yearLevel)
                        ],
                        [
                            'CREDITRATE' => $rateValue
                        ]
                    );
                }
            }
            DB::commit();
            return redirect()->route('revenue.credit-rates.index')->with('success', 'ບັນທຶກອັດຕາໜ່ວຍກິດສຳເລັດແລ້ວ');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'ເກີດຂໍ້ຜິດພາດ: ' . $e->getMessage());
        }
    }

    public function updateRegistrationFees(Request $request)
    {
        $request->validate([
            'amounts' => 'required|array',
        ]);

        $amounts = $request->input('amounts', []);

        DB::beginTransaction();
        try {
            foreach ($amounts as $itemId => $amountVal) {
                $amountVal = $amountVal !== null ? floatval(str_replace(',', '', $amountVal)) : 0;
                DB::table('registration_fee_items')
                    ->where('id', $itemId)
                    ->update([
                        'amount' => $amountVal,
                        'updated_at' => now(),
                    ]);
            }
            DB::commit();
            return redirect()->route('revenue.credit-rates.index')->with('success', 'ບັນທຶກຄ່າທຳນຽມສຳເລັດແລ້ວ');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'ເກີດຂໍ້ຜິດພາດ: ' . $e->getMessage());
        }
    }

    /**
     * Store a new registration fee item.
     */
    public function storeRegistrationFeeItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'new_amount' => 'required|string',
            'old_amount' => 'required|string',
        ]);

        $name = $request->input('name');
        $newAmount = floatval(str_replace(',', '', $request->input('new_amount')));
        $oldAmount = floatval(str_replace(',', '', $request->input('old_amount')));

        DB::beginTransaction();
        try {
            $maxSortNew = DB::table('registration_fee_items')->where('fee_setting_id', 27)->max('sort_order') ?? 0;
            $maxSortOld = DB::table('registration_fee_items')->where('fee_setting_id', 26)->max('sort_order') ?? 0;

            // Insert for New Students (Setting 27)
            DB::table('registration_fee_items')->insert([
                'fee_setting_id' => 27,
                'name' => $name,
                'amount' => $newAmount,
                'sort_order' => $maxSortNew + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert for Existing Students (Setting 26)
            DB::table('registration_fee_items')->insert([
                'fee_setting_id' => 26,
                'name' => $name,
                'amount' => $oldAmount,
                'sort_order' => $maxSortOld + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('revenue.credit-rates.index')->with('success', 'ເພີ່ມປະເພດຄ່າທຳນຽມສຳເລັດແລ້ວ');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'ເກີດຂໍ້ຜິດພາດ: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing registration fee item name.
     */
    public function updateRegistrationFeeItem(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $newName = $request->input('name');

        DB::beginTransaction();
        try {
            $item = DB::table('registration_fee_items')->where('id', $id)->first();
            if (!$item) {
                return redirect()->back()->with('error', 'ບໍ່ພົບລາຍການຄ່າທຳນຽມ');
            }

            // Update name in both settings
            DB::table('registration_fee_items')
                ->where('name', $item->name)
                ->update([
                    'name' => $newName,
                    'updated_at' => now(),
                ]);

            DB::commit();
            return redirect()->route('revenue.credit-rates.index')->with('success', 'ອັບເດດປະເພດຄ່າທຳນຽມສຳເລັດແລ້ວ');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'ເກີດຂໍ້ຜິດພາດ: ' . $e->getMessage());
        }
    }

    /**
     * Delete a registration fee item.
     */
    public function destroyRegistrationFeeItem(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $item = DB::table('registration_fee_items')->where('id', $id)->first();
            if (!$item) {
                return redirect()->back()->with('error', 'ບໍ່ພົບລາຍການຄ່າທຳນຽມ');
            }

            // Delete from both settings
            DB::table('registration_fee_items')
                ->where('name', $item->name)
                ->delete();

            DB::commit();
            return redirect()->route('revenue.credit-rates.index')->with('success', 'ລຶບປະເພດຄ່າທຳນຽມສຳເລັດແລ້ວ');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'ເກີດຂໍ້ຜິດພາດ: ' . $e->getMessage());
        }
    }

    /**
     * Store a new course.
     */
    public function storeCourse(Request $request)
    {
        $request->validate([
            'COURSEID'   => 'required|string|max:10|unique:course,COURSEID',
            'COURSENAME' => 'required|string|max:100',
            'LEVEL'      => 'required|string|max:32',
            'DEPTID'     => 'required|integer',
        ]);

        Course::create($request->all());

        return redirect()->route('revenue.credit-rates.index')->with('success', 'ເພີ່ມຫຼັກສູດສຳເລັດແລ້ວ');
    }

    /**
     * Update an existing course.
     */
    public function updateCourse(Request $request, $id)
    {
        $request->validate([
            'COURSENAME' => 'required|string|max:100',
            'LEVEL'      => 'required|string|max:32',
            'DEPTID'     => 'required|integer',
        ]);

        $course = Course::findOrFail($id);
        $course->update($request->only(['COURSENAME', 'LEVEL', 'DEPTID']));

        return redirect()->route('revenue.credit-rates.index')->with('success', 'ອັບເດດຫຼັກສູດສຳເລັດແລ້ວ');
    }

    /**
     * Delete a course.
     */
    public function destroyCourse($id)
    {
        $course = Course::findOrFail($id);
        
        DB::beginTransaction();
        try {
            // ลบอัตราหน่วยกิตที่เชื่อมโยงก่อน
            DB::table('creditrate')->where('COURSEID', $id)->delete();
            // ลบหลักสูตร
            $course->delete();
            DB::commit();
            return redirect()->route('revenue.credit-rates.index')->with('success', 'ລົບຫຼັກສູດສຳເລັດແລ້ວ');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'ເກີດຂໍ้ຜິດພາດ: ' . $e->getMessage());
        }
    }
}

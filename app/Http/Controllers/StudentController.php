<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\DegreeProgram;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StudentController extends Controller
{
    /**
     * Display a listing of students with filters.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $courseFilter = $request->input('course');
        $yearFilter = $request->input('year');

        $query = Student::with('course', 'degreeProgram');

        // Text Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('STDID', 'like', "%{$search}%")
                  ->orWhere('FRTNAME', 'like', "%{$search}%")
                  ->orWhere('LSTNAME', 'like', "%{$search}%")
                  ->orWhere(\DB::raw("CONCAT(FRTNAME, ' ', LSTNAME)"), 'like', "%{$search}%");
            });
        }

        // Course filter
        if ($courseFilter) {
            $query->where('COURSEID', $courseFilter);
        }

        // Year filter
        if ($yearFilter) {
            $query->where('study_year', $yearFilter);
        }

        $students = $query->orderBy('STDID', 'asc')->paginate(20)->withQueryString();

        // Get dropdown data
        $courses = Course::orderBy('COURSEID', 'asc')->get();

        // Calculate summary metrics
        $totalStudents = Student::count();
        $activeStudents = Student::where('is_active', true)->count();
        $inactiveStudents = Student::where('is_active', false)->count();

        return view('revenue.students', compact(
            'students',
            'courses',
            'totalStudents',
            'activeStudents',
            'inactiveStudents',
            'search',
            'courseFilter',
            'yearFilter'
        ));
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $request->validate([
            'STDID' => [
                'required',
                'string',
                'max:50',
                Rule::unique('student', 'STDID')
            ],
            'TITLE' => 'nullable|string|max:50',
            'FRTNAME' => 'required|string|max:100',
            'LSTNAME' => 'nullable|string|max:100',
            'gender' => 'required|in:M,F',
            'COURSEID' => 'required|string|exists:course,COURSEID',
            'study_year' => 'required|integer|min:1|max:4',
            'EMAIL' => 'nullable|email|max:100',
            'PHONE' => 'nullable|string|max:50',
        ]);

        $courseId = $request->input('COURSEID');
        $year = $request->input('study_year');
        $degreeProgramId = $this->resolveDegreeProgramId($courseId, $year);

        Student::create([
            'STDID' => trim($request->input('STDID')),
            'TITLE' => $request->input('TITLE') ?: ($request->input('gender') === 'F' ? 'ນາງ' : 'ທ້າວ'),
            'FRTNAME' => trim($request->input('FRTNAME')),
            'LSTNAME' => trim($request->input('LSTNAME', '')),
            'gender' => $request->input('gender'),
            'COURSEID' => $courseId,
            'study_year' => $request->input('study_year'),
            'degree_program_id' => $degreeProgramId,
            'EMAIL' => trim($request->input('EMAIL', '')),
            'PHONE' => trim($request->input('PHONE', '')),
            'is_active' => true,
        ]);

        return back()->with('success', 'ເພີ່ມຂໍ້ມູນນັກສຶກສາສຳເລັດ');
    }

    /**
     * Update student details.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'STDID' => [
                'required',
                'string',
                'max:50',
                Rule::unique('student', 'STDID')->ignore($student->id)
            ],
            'TITLE' => 'nullable|string|max:50',
            'FRTNAME' => 'required|string|max:100',
            'LSTNAME' => 'nullable|string|max:100',
            'gender' => 'required|in:M,F',
            'COURSEID' => 'required|string|exists:course,COURSEID',
            'study_year' => 'required|integer|min:1|max:4',
            'EMAIL' => 'nullable|email|max:100',
            'PHONE' => 'nullable|string|max:50',
        ]);

        $courseId = $request->input('COURSEID');
        $year = $request->input('study_year');
        $degreeProgramId = $this->resolveDegreeProgramId($courseId, $year);

        $student->update([
            'STDID' => trim($request->input('STDID')),
            'TITLE' => $request->input('TITLE') ?: ($request->input('gender') === 'F' ? 'ນາງ' : 'ທ້າວ'),
            'FRTNAME' => trim($request->input('FRTNAME')),
            'LSTNAME' => trim($request->input('LSTNAME', '')),
            'gender' => $request->input('gender'),
            'COURSEID' => $courseId,
            'study_year' => $request->input('study_year'),
            'degree_program_id' => $degreeProgramId,
            'EMAIL' => trim($request->input('EMAIL', '')),
            'PHONE' => trim($request->input('PHONE', '')),
        ]);

        return back()->with('success', 'ອັບເດດຂໍ້ມູນນັກສຶກສາສຳເລັດ');
    }

    /**
     * Toggle student active status.
     */
    public function toggleStatus(Student $student)
    {
        $student->update([
            'is_active' => !$student->is_active
        ]);

        return back()->with('success', 'ປ່ຽນແປງສະຖານະນັກສຶກສາສຳເລັດ');
    }

    /**
     * Delete student.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return back()->with('success', 'ລົບຂໍ້ມູນນັກສຶກສາສຳເລັດ');
    }

    /**
     * Download Student Import Template (Excel).
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $headers = [
            'ລະຫັດນັກສຶກສາ', // Student ID
            'ຄຳນຳໜ້າ',     // Title
            'ຊື່',          // First Name
            'ນາມສະກຸນ',     // Last Name
            'ເພດ',         // Gender (ชาย/หญิง หรือ M/F)
            'ຫຼັກສູດ',       // Course Code
            'ປີຮຽນ',        // Study Year (1-4)
            'ເບີໂທ',        // Phone
            'ອີເມວ'         // Email
        ];
        
        foreach ($headers as $colIndex => $header) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
            $sheet->setCellValue($colLetter . '1', $header);
            $sheet->getStyle($colLetter . '1')->getFont()->setBold(true);
        }
        
        // Add sample row
        $mockData = [
            ['FNS-001', 'ທ້າວ', 'ສົມພອນ', 'ໄຊຍະວົງ', 'ຊາຍ', 'B-CS', 1, '020 99998888', 'somphone@nuol.edu.la'],
            ['FNS-002', 'ນາງ', 'ມາໄລວັນ', 'ແກ້ວມະນີ', 'ຍິງ', 'B-CS', 2, '020 55554444', 'malaivan@nuol.edu.la']
        ];
        
        foreach ($mockData as $rowIndex => $rowData) {
            $rowNum = $rowIndex + 2;
            foreach ($rowData as $colIndex => $value) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
                $sheet->setCellValue($colLetter . $rowNum, $value);
            }
        }
        
        // Auto width
        foreach (range(1, count($headers)) as $colIndex) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        
        // Output headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="student_import_template.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Bulk Import from Excel / CSV.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        try {
            $spreadsheet = IOFactory::load($path);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            if (count($rows) <= 1) {
                return back()->with('error', 'ໄຟລ໌ Excel ຫວ່າງເປົ່າ ຫຼື ບໍ່ມີຂໍ້ມູນ');
            }

            // Find column indexes
            $header = array_map(fn($h) => strtolower(trim($h)), $rows[0]);
            
            $idxId = -1;
            $idxTitle = -1;
            $idxFirstName = -1;
            $idxLastName = -1;
            $idxCourse = -1;
            $idxYear = -1;
            $idxGender = -1;
            $idxEmail = -1;
            $idxPhone = -1;

            foreach ($header as $index => $colName) {
                if (in_array($colName, ['student id', 'student_code', 'stdid', 'ລະຫັດນັກສຶກສາ', 'รหัสประจำตัว', 'รหัสนักศึกษา'])) {
                    $idxId = $index;
                } elseif (in_array($colName, ['title', 'prefix', 'ຄຳນຳໜ້າ', 'คำนำหน้า'])) {
                    $idxTitle = $index;
                } elseif (in_array($colName, ['first name', 'firstname', 'frtname', 'ຊື່', 'ชื่อ'])) {
                    $idxFirstName = $index;
                } elseif (in_array($colName, ['last name', 'lastname', 'lstname', 'ນາມສະກຸນ', 'นามสกุล'])) {
                    $idxLastName = $index;
                } elseif (in_array($colName, ['course', 'courseid', 'course code', 'ຫຼັກສູດ', 'หลักสูตร'])) {
                    $idxCourse = $index;
                } elseif (in_array($colName, ['year', 'study_year', 'yearlevel', 'ປີຮຽນ', 'ชั้นปี'])) {
                    $idxYear = $index;
                } elseif (in_array($colName, ['gender', 'ເພດ', 'เพศ'])) {
                    $idxGender = $index;
                } elseif (in_array($colName, ['email', 'ອີເມວ', 'อีเมล'])) {
                    $idxEmail = $index;
                } elseif (in_array($colName, ['phone', '\ufeffphone', 'ເບີໂທ', 'เบอร์โทร'])) {
                    $idxPhone = $index;
                }
            }

            if ($idxId === -1 || $idxFirstName === -1) {
                return back()->with('error', 'ບໍ່ພົບຫົວຂໍ້ຖັນ "ລະຫັດນັກສຶກສາ" (Student ID) ຫຼື "ຊື່" (First Name) ໃນໄຟລ໌');
            }

            $imported = 0;
            $updated = 0;

            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                
                $stdid = trim($row[$idxId] ?? '');
                if (empty($stdid)) continue;

                $firstName = trim($row[$idxFirstName] ?? '');
                $lastName = $idxLastName !== -1 ? trim($row[$idxLastName] ?? '') : '';
                $title = $idxTitle !== -1 ? trim($row[$idxTitle] ?? '') : '';
                $courseId = $idxCourse !== -1 ? strtoupper(trim($row[$idxCourse] ?? '')) : '';
                $year = $idxYear !== -1 ? intval($row[$idxYear] ?? 1) : 1;
                $genderVal = $idxGender !== -1 ? strtoupper(trim($row[$idxGender] ?? '')) : '';
                $email = $idxEmail !== -1 ? trim($row[$idxEmail] ?? '') : '';
                $phone = $idxPhone !== -1 ? trim($row[$idxPhone] ?? '') : '';

                // Normalize gender to M or F
                $gender = 'M';
                if (in_array($genderVal, ['F', 'FEMALE', 'ນາງ', 'หญิง'])) {
                    $gender = 'F';
                }

                // Normalize title if empty
                if (empty($title)) {
                    $title = ($gender === 'F') ? 'ນາງ' : 'ທ້າວ';
                }

                // Auto-create course ID if it doesn't exist in the course table to prevent foreign key errors
                if (!empty($courseId)) {
                    $courseExists = \DB::table('course')->where('COURSEID', $courseId)->exists();
                    if (!$courseExists) {
                        $courseLevel = 'bachelor';
                        if (str_starts_with($courseId, 'M-') || str_starts_with($courseId, 'MR-')) {
                            $courseLevel = 'master';
                        } elseif (str_starts_with($courseId, 'D-')) {
                            $courseLevel = 'phd';
                        }

                        $deptId = 11; // Central
                        if (preg_match('/(CS|PD|WD|AI)/i', $courseId)) {
                            $deptId = 16;
                        } elseif (preg_match('/(CHEM|ECHE)/i', $courseId)) {
                            $deptId = 17;
                        } elseif (preg_match('/(BIO|BT)/i', $courseId)) {
                            $deptId = 18;
                        } elseif (preg_match('/(MAA|MAE|STAT|MATH)/i', $courseId)) {
                            $deptId = 20;
                        } elseif (preg_match('/(PHYS|GPHY|MATS|NPHY)/i', $courseId)) {
                            $deptId = 21;
                        }

                        \DB::table('course')->insert([
                            'COURSEID' => $courseId,
                            'COURSENAME' => $courseId,
                            'LEVEL' => $courseLevel,
                            'DEPTID' => $deptId
                        ]);
                    }
                }

                // Look up degree program id
                $degreeProgramId = $this->resolveDegreeProgramId($courseId, $year);

                // Check if student exists
                $existing = \DB::table('student')->where('STDID', $stdid)->first();

                $data = [
                    'STDID' => $stdid,
                    'TITLE' => $title,
                    'FRTNAME' => $firstName,
                    'LSTNAME' => $lastName,
                    'COURSEID' => $courseId,
                    'study_year' => $year,
                    'gender' => $gender,
                    'EMAIL' => $email,
                    'PHONE' => $phone,
                    'degree_program_id' => $degreeProgramId,
                    'is_active' => true,
                    'updated_at' => now(),
                ];

                if ($existing) {
                    \DB::table('student')->where('id', $existing->id)->update($data);
                    $updated++;
                } else {
                    $data['created_at'] = now();
                    \DB::table('student')->insert($data);
                    $imported++;
                }
            }

            return back()->with('success', "ນຳເຂົ້າຂໍ້ມູນສຳເລັດ: ເພີ່ມໃໝ່ $imported ຄົນ, ອັບເດດ $updated ຄົນ");

        } catch (\Exception $e) {
            return back()->with('error', 'ເກີດຂໍ້ຜິດພາດໃນການອ່ານໄຟລ໌: ' . $e->getMessage());
        }
    }

    /**
     * Helper to resolve degree_program_id from course code and study year.
     */
    private function resolveDegreeProgramId($courseId, $year)
    {
        if (empty($courseId)) {
            return null;
        }

        // 1. Try exact match first (e.g. M-CS or D-PHYS)
        $id = DegreeProgram::where('code', $courseId)->value('id');
        if ($id) {
            return $id;
        }

        // 2. Try with year suffix (e.g. B-CS-Y4)
        $codeWithYear = $courseId . '-Y' . $year;
        $id = DegreeProgram::where('code', $codeWithYear)->value('id');
        if ($id) {
            return $id;
        }

        // 3. Try matching prefix (e.g. B-CS-EVE-Y4)
        if (str_starts_with($courseId, 'B-')) {
            $id = DegreeProgram::where('code', 'like', $courseId . '%Y' . $year)->value('id');
            if ($id) {
                return $id;
            }
        }

        return null;
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\DateConverter;
use App\Helpers\FormatPhoneNumber;
use App\Helpers\NumberConverter;
use App\Http\Controllers\Controller;
use App\Models\Cadre;
use App\Models\Faculty;
use App\Models\Level;
use App\Models\Major;
use App\Models\Plan;
use App\Models\Province;
use App\Models\Reference;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $major = $request->get('major', 'all');
        $year = $request->get('year', 'all');
        $month = $request->get('month', 'all');
        $day = $request->get('day', 'all');

        $studentsQuery = Student::query()
            ->where('plan_id', '!=', 1)
            ->orderByDesc('register_date')
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where(function ($subQuery) use ($query) {
                    $subQuery
                        ->where('name_kh', 'like', '%' . $query . '%')
                        ->orWhere('name_en', 'like', '%' . $query . '%');
                });
            })
            ->when($major !== 'all', function ($queryBuilder) use ($major) {
                return $queryBuilder->where('major_id', $major);
            })
            ->when($year !== 'all', function ($queryBuilder) use ($year) {
                return $queryBuilder->whereYear('register_date', $year);
            })
            ->when($month !== 'all', function ($queryBuilder) use ($month) {
                return $queryBuilder->whereMonth('register_date', $month);
            })
            ->when($day !== 'all', function ($queryBuilder) use ($day) {
                return $queryBuilder->whereDay('register_date', $day);
            });
        $students = $studentsQuery->paginate(10);
        $majors = Major::all();
        $faculties = Faculty::all();
        return view('student.index', compact('students', 'majors', 'faculties'));
    }

    public function create()
    {
        $provinces = Province::all();
        $majors = Major::all();
        $high_schools = DB::table('high_schools')->get();
        $levels = Level::all();
        $plans = Plan::all();
        $references = Reference::all();
        $cadres = Cadre::all();
        $faculties = Faculty::all();

        return view('student.create', compact('provinces', 'majors', 'levels', 'plans', 'cadres', 'faculties', 'references', 'high_schools'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $data = $request->validate([
            'student_id' => 'nullable|string|max:50|unique:students,student_id',
            'register_date' => 'required|date',
            'name_kh' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'gender' => 'required|integer',
            'dob' => 'nullable|date',
            'study_shift' => 'nullable|string|max:1',
            'course' => 'nullable|string|max:1',
            'cadre' => 'required|exists:cadres,id',
            'level' => 'required|exists:levels,id',
            'province' => 'required|exists:provinces,id',
            'high_school' => 'nullable|string|max:255',
            'personal_phone' => 'nullable|string|max:15',
            'parents_phone' => 'nullable|string|max:15',
            'study_year' => 'required|integer',
            'major' => 'required|exists:majors,id',
            'faculty' => 'required|exists:faculties,id',
            'scholarship' => 'nullable|string|max:50',
            'plan' => 'required|exists:plans,id',
            'reference' => 'required|exists:references,id',
            'refer_by_name' => 'nullable|string|max:255',
            'refer_by_phone' => 'nullable|string|max:255',
            'diploma_year' => 'required|integer',
            'diploma_number' => 'nullable|string|max:255',
            'diploma_grade' => 'nullable|string|max:1',
            'dkg' => 'nullable|string|max:1',
            'dmg' => 'nullable|string|max:1',
            'dpg' => 'nullable|string|max:1',
            'dchg' => 'nullable|string|max:1',
            'dbg' => 'nullable|string|max:1',
            'dhg' => 'nullable|string|max:1',
            'dgg' => 'nullable|string|max:1',
            'dcg' => 'nullable|string|max:1',
            'desg' => 'nullable|string|max:1',
            'dflg' => 'nullable|string|max:1',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if high_school exists, if not create it
        if (!empty($data['high_school'])) {
            $highSchool = DB::table('high_schools')
                ->where('name_kh', $data['high_school'])
                ->first();

            if (!$highSchool) {
                DB::table('high_schools')->insert([
                    'name_kh' => $data['high_school'],
                    'name_en' => '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User is not authenticated.']);
        }

        // Determine if the authenticated user is from 'users' or 'admins' table
        $userField = null;
        $userId = null;

        if ($user instanceof \App\Models\User) {  // If logged-in user is from 'users' table
            $userField = 'user_id';
            $userId = $user->id;
        } elseif ($user instanceof \App\Models\Admin) {  // If logged-in user is from 'admins' table
            $userField = 'admin_id';
            $userId = $user->id;
        } else {
            return redirect()->back()->withErrors(['error' => 'Unauthorized user.']);
        }

        // Create a new student record
        Student::create([
            'student_id' => $data['student_id'],
            'register_date' => $data['register_date'],
            'name_kh' => $data['name_kh'],
            'name_en' => $data['name_en'],
            'gender_id' => $data['gender'],
            'dob' => $data['dob'],
            'study_shift_id' => $data['study_shift'],
            'course_id' => $data['course'],
            'cadre_id' => $data['cadre'],
            'level_id' => $data['level'],
            'province_id' => $data['province'],
            'high_school' => $data['high_school'],
            'p_phone' => $data['personal_phone'],
            'par_phone' => $data['parents_phone'],
            'study_year' => $data['study_year'],
            'major_id' => $data['major'],
            'faculty_id' => $data['faculty'],
            'scholarship' => $data['scholarship'],
            'plan_id' => $data['plan'],
            'reference_id' => $data['reference'],
            'refer_by_name' => $data['refer_by_name'],
            'refer_by_phone' => $data['refer_by_phone'],
            'yde' => $data['diploma_year'],
            'diploma_number' => $data['diploma_number'],
            'diploma_grade' => $data['diploma_grade'],
            'dkg' => $data['dkg'],
            'dmg' => $data['dmg'],
            'dpg' => $data['dpg'],
            'dchg' => $data['dchg'],
            'dbg' => $data['dbg'],
            'dhg' => $data['dhg'],
            'dgg' => $data['dgg'],
            'dcg' => $data['dcg'],
            'desg' => $data['desg'],
            'dflg' => $data['dflg'],
            $userField => $userId,
        ]);

        // Redirect back with success message
        return redirect()->route('students.index')->with('success', 'បន្ថែមនិស្សិតដោយជោគជ័យ!');
    }

    public function view($id)
    {
        // Retrieve the student by ID, including necessary relationships
        $student = Student::with(['level', 'major', 'province', 'cadre', 'plan', 'faculty', 'reference'])->findOrFail($id);

        // Return the view with the student data
        return view('student.view', compact('student'));
    }

    public function edit($id)
    {
        // Fetch the existing student record
        $student = Student::findOrFail($id);

        // Fetch all necessary data for the form
        $provinces = Province::all();
        $majors = Major::all();
        $high_schools = DB::table('high_schools')->get();
        $levels = Level::all();
        $plans = Plan::all();
        $references = Reference::all();
        $cadres = Cadre::all();
        $faculties = Faculty::all();

        return view('student.edit', compact('student', 'provinces', 'majors', 'levels', 'plans', 'cadres', 'faculties', 'references', 'high_schools'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $data = $request->validate([
            'student_id' => 'nullable|string|max:50|unique:students,student_id,' . $id,
            'register_date' => 'required|date',
            'name_kh' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'gender' => 'required|integer',
            'dob' => 'nullable|date',
            'study_shift' => 'nullable|string|max:1',
            'course' => 'nullable|string|max:1',
            'cadre' => 'required|exists:cadres,id',
            'level' => 'required|exists:levels,id',
            'province' => 'required|exists:provinces,id',
            'high_school' => 'nullable|string|max:255',
            'personal_phone' => 'nullable|string|max:15',
            'parents_phone' => 'nullable|string|max:15',
            'study_year' => 'required|integer',
            'major' => 'required|exists:majors,id',
            'faculty' => 'required|exists:faculties,id',
            'scholarship' => 'nullable|string|max:255',
            'plan' => 'required|exists:plans,id',
            'reference' => 'required|exists:references,id',
            'refer_by_name' => 'nullable|string|max:255',
            'refer_by_phone' => 'nullable|string|max:255',
            'diploma_year' => 'required|integer',
            'diploma_number' => 'nullable|string|max:255',
            'diploma_grade' => 'nullable|string|max:1',
            'dkg' => 'nullable|string|max:1',
            'dmg' => 'nullable|string|max:1',
            'dpg' => 'nullable|string|max:1',
            'dchg' => 'nullable|string|max:1',
            'dbg' => 'nullable|string|max:1',
            'dhg' => 'nullable|string|max:1',
            'dgg' => 'nullable|string|max:1',
            'dcg' => 'nullable|string|max:1',
            'desg' => 'nullable|string|max:1',
            'dflg' => 'nullable|string|max:1',
            // 'user_id' => 'required|exists:users,id',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if high_school exists, if not create it
        if (!empty($data['high_school'])) {
            $highSchool = DB::table('high_schools')
                ->where('name_kh', $data['high_school'])
                ->first();

            if (!$highSchool) {
                DB::table('high_schools')->insert([
                    'name_kh' => $data['high_school'],
                    'name_en' => '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User is not authenticated.']);
        }

        // Determine if the authenticated user is from 'users' or 'admins' table
        $userField = null;
        $userId = null;

        if ($user instanceof \App\Models\User) {  // If logged-in user is from 'users' table
            $userField = 'user_id';
            $userId = $user->id;
        } elseif ($user instanceof \App\Models\Admin) {  // If logged-in user is from 'admins' table
            $userField = 'admin_id';
            $userId = $user->id;
        } else {
            return redirect()->back()->withErrors(['error' => 'Unauthorized user.']);
        }

        $student->update([
            'student_id' => $data['student_id'],
            'register_date' => $data['register_date'],
            'name_kh' => $data['name_kh'],
            'name_en' => $data['name_en'],
            'gender_id' => $data['gender'],
            'dob' => $data['dob'],
            'study_shift_id' => $data['study_shift'],
            'course_id' => $data['course'],
            'cadre_id' => $data['cadre'],
            'level_id' => $data['level'],
            'province_id' => $data['province'],
            'high_school' => $data['high_school'],
            'p_phone' => $data['personal_phone'],
            'par_phone' => $data['parents_phone'],
            'study_year' => $data['study_year'],
            'major_id' => $data['major'],
            'faculty_id' => $data['faculty'],
            'scholarship' => $data['scholarship'],
            'plan_id' => $data['plan'],
            'reference_id' => $data['reference'],
            'refer_by_name' => $data['refer_by_name'],
            'refer_by_phone' => $data['refer_by_phone'],
            'yde' => $data['diploma_year'],
            'diploma_number' => $data['diploma_number'],
            'diploma_grade' => $data['diploma_grade'],
            'dkg' => $data['dkg'],
            'dmg' => $data['dmg'],
            'dpg' => $data['dpg'],
            'dchg' => $data['dchg'],
            'dbg' => $data['dbg'],
            'dhg' => $data['dhg'],
            'dgg' => $data['dgg'],
            'dcg' => $data['dcg'],
            'desg' => $data['desg'],
            'dflg' => $data['dflg'],
            // 'user_id' => Auth::id(),
            // 'admin_id' => Auth::id(),
            $userField => $userId,
        ]);
        // dd('update');

        return redirect()->route('students.index')->with('success', 'ការធ្វើបច្ចុប្បន្នភាពបានដោយជោគជ័យ');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'ការលុបនិស្សិតបានដោយជោគជ័យ។');
    }

    public function exportToExcel(Request $request)
    {
        // Query students with filters
        $studentsQuery = DB::table('students')
            ->where('plan_id', '!=', 1)
            ->join('levels', 'students.level_id', '=', 'levels.id')
            ->join('cadres', 'students.cadre_id', '=', 'cadres.id')
            ->join('faculties', 'students.faculty_id', '=', 'faculties.id')
            ->join('majors', 'students.major_id', '=', 'majors.id')
            ->join('provinces', 'students.province_id', '=', 'provinces.id')
            ->join('plans', 'students.plan_id', '=', 'plans.id')
            ->select(
                'students.*',
                'levels.name_kh as level_name',
                'cadres.name_kh as cadre_name',
                'faculties.name_kh as faculty_name',
                'majors.name_kh as major_name',
                'provinces.name_kh as province_name',
                'plans.name_kh as plan_name'
            );

        // Apply filters
        $major = $request->get('major', 'all');
        $year = $request->get('year', 'all');
        $month = $request->get('month', 'all');
        $day = $request->get('day', 'all');

        if ($year !== 'all') {
            $studentsQuery->whereYear('students.register_date', $year);
        }
        if ($month !== 'all') {
            $studentsQuery->whereMonth('students.register_date', $month);
        }
        if ($day !== 'all') {
            $studentsQuery->whereDay('students.register_date', $day);
        }
        if ($major !== 'all') {
            $studentsQuery->where('major_id', $major);
        }

        $students = $studentsQuery->get();

        // Redirect if no data found
        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'No data found for the selected filters.');
        }

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set sheet title
        $title = 'បញ្ជីឈ្មោះនិស្សិតដាក់ពាក្យ';
        if (mb_strlen($title) > 31) {
            $sheet->setTitle(mb_substr($title, 0, 31));
        } else {
            $sheet->setTitle($title);
        }

        // Merge cells for the title
        $sheet->mergeCells('A1:AF1');  // Adjusted for 31 columns
        $sheet->setCellValue('A1', $title);

        // Title style
        $titleStyleArray = [
            'font' => [
                'name' => 'Khmer OS Muol',
                'size' => 16,
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:AF1')->applyFromArray($titleStyleArray);
        $sheet->getRowDimension(1)->setRowHeight(100);

        // Default style
        $defaultStyle = [
            'font' => [
                'name' => 'Khmer OS Siemreap',
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $spreadsheet->getDefaultStyle()->applyFromArray($defaultStyle);

        // Headers
        $headers = [
            'ល.រ',
            'កាលបរិច្ឆេទ',
            'លេខសម្គាល់និស្សិត',
            'អក្សរខ្មែរ',
            'អក្សរឡាតាំង',
            'ភេទ',
            'ថ្ងៃខែឆ្នាំកំណើត',
            'ពេលសិក្សា',
            'វគ្គ',
            'ជំនាញ',
            'កម្រិតសិក្សា',
            'វិទ្យាល័យ',
            'ខេត្តកំណើត',
            'លេខទូរសព្ទ័ផ្ទាល់ខ្លួន',
            'លេខទូរសព្ទ័អាណាព្យាបាល',
            'ប្រឡងអាហារូបករណ៍',
            'សមាជិកទីផ្សារ',
            'សាលាកបត្រឯកត្តជន',
            'រូបថត',
            'ឆ្នាំប្រឡង',
            'លេខសញ្ញាបត្រ',
            'និទ្ទេស',
            'ភាសាបរទេស',
            'ខ្មែរ',
            'គណិត',
            'ជីវៈ',
            'គីមី',
            'ប្រវត្ត',
            'រូប',
            'ភូមិ',
            'សីលធម៌',
            'ផែនដី'
        ];

        // Helper function to generate column letters
        function getColumnLetter($index)
        {
            $letters = '';
            while ($index >= 0) {
                $letters = chr(65 + ($index % 26)) . $letters;
                $index = floor($index / 26) - 1;
            }
            return $letters;
        }

        // Write headers
        foreach ($headers as $index => $header) {
            $columnLetter = getColumnLetter($index);
            $sheet->setCellValue($columnLetter . '2', $header);
        }

        // Header style
        $lastHeaderColumn = getColumnLetter(count($headers) - 1);  // Get the last column letter
        $headerStyle = [
            'font' => [
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFF00'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A2:' . $lastHeaderColumn . '2')->applyFromArray($headerStyle);

        // Write student data
        $startRow = 3;
        foreach ($students as $index => $student) {
            $row = $index + $startRow;

            // Write data for each column
            // $sheet->setCellValue('A' . $row, '[$-km-KH];@' . $index + 1);  // ល.រ
            // $sheet->getStyle('A' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
            $cell = 'A' . $row;  // Target cell

            // Set the value as a normal number
            $sheet->setCellValue($cell, $index + 1);
            $sheet->getStyle($cell)
                ->getFont()
                ->setName('Times New Roman');

            // Apply Khmer number format (only affects display, not actual value)
            $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('[$-km-KH]0');
            $cell = 'B' . $row;  // កាលបរិច្ឆេទ

            if (!empty($student->register_date) && strtotime($student->register_date) !== false) {
                // Now you can just write:
                $excelDate = Date::PHPToExcel($student->register_date);
                $sheet->setCellValue('B' . $row, $excelDate);
                $sheet->getStyle('B' . $row)
                    ->getNumberFormat()
                    ->setFormatCode('[$-km-KH]d mmmm yyyy;@');
            } else {
                // Set cell to be empty (null)
                $sheet->setCellValue($cell, null);
            }

            $sheet->setCellValue('C' . $row, $student->student_id ?? '');  // លេខសម្គាល់និស្សិត
            $sheet->getStyle('C' . $row)
                ->getFont()
                ->setName('Times New Roman');
            $sheet->setCellValue('D' . $row, $student->name_kh ?? '');  // អក្សរខ្មែរ
            $sheet->setCellValue('E' . $row, $student->name_en ?? '');  // អក្សរឡាតាំង
            $sheet->getStyle('E' . $row)
                ->getFont()
                ->setName('Times New Roman');
            $sheet->setCellValue('F' . $row, $student->gender_id == 1 ? 'ប្រុស' : ($student->gender_id == 2 ? 'ស្រី' : 'ផ្សេង'));  // ភេទ
            $cell = 'G' . $row;  // ថ្ងៃខែឆ្នាំកំណើត

            if (!empty($student->dob) && strtotime($student->dob) !== false) {
                $excelDate = Date::PHPToExcel($student->dob);
                $sheet->setCellValue($cell, $excelDate);
                $sheet->getStyle($cell)
                    ->getNumberFormat()
                    ->setFormatCode('[$-km-KH]d mmmm yyyy;@');
            } else {
                // Set cell to be empty (null) for no value
                $sheet->setCellValue($cell, '');
            }

            $sheet->setCellValue('H' . $row, $student->study_shift_id == 1 ? 'ព្រឹក' : ($student->study_shift_id == 2 ? 'រសៀល' : 'យប់'));  // ពេលសិក្សា
            $sheet->setCellValue('I' . $row, $student->course_id ?? '');
            $sheet->getStyle('I' . $row)
                ->getFont()
                ->setName('Times New Roman');
            $sheet->setCellValue('J' . $row, $student->faculty_name == 'គ្មានទិន្នន័យ' ? '' : $student->faculty_name);  // មុខជំនាញ
            $sheet->setCellValue('K' . $row, $student->level_name ?? '');  // កម្រិតសិក្សា
            $sheet->setCellValue('L' . $row, $student->high_school ?? '');  // វិទ្យាល័យ
            $sheet->setCellValue('M' . $row, $student->province_name ?? '');  // ខេត្តកំណើត
            $sheet->setCellValueExplicit('N' . $row, FormatPhoneNumber::format($student->p_phone ?? ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->getStyle('N' . $row)
                ->getNumberFormat()
                ->setFormatCode('0### ### ###');
            $sheet->getStyle('N' . $row)
                ->getFont()
                ->setName('Times New Roman');

            $sheet->setCellValueExplicit('O' . $row, FormatPhoneNumber::format($student->par_phone ?? ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->getStyle('O' . $row)
                ->getNumberFormat()
                ->setFormatCode('0### ### ###');
            $sheet->getStyle('O' . $row)
                ->getFont()
                ->setName('Times New Roman');

            // $sheet->setCellValue('O' . $row, FormatPhoneNumber::format($student->par_phone ?? ''));
            $sheet->setCellValue('P' . $row, $student->scholarship ?? '');  // ប្រឡងអាហារូបករណ៍
            $sheet->setCellValue('Q' . $row, $student->market_member ?? '');  // សមាជិកទីផ្សារ
            $sheet->setCellValue('R' . $row, $student->certificate_school ?? '');  // សាលាកបត្រឯកត្តជន
            $sheet->setCellValue('S' . $row, $student->photo_url ?? '');  // រូបថត
            $sheet->setCellValue('T' . $row, $student->yde ?? $student->yde);
            $sheet->getStyle('T' . $row)
                ->getFont()
                ->setName('Times New Roman');  // ឆ្នាំប្រឡង
            $sheet->setCellValue('U' . $row, $student->diploma_number ?? '');
            $sheet->getStyle('U' . $row)
                ->getFont()
                ->setName('Times New Roman');  // លេខសញ្ញាបត្រ
            $sheet->setCellValue('V' . $row, $student->diploma_grade ?? '');  // និទ្ទេស

            $sheet->setCellValue('W' . $row, $student->dflg ?? '');  // ភាសាបរទេស
            $sheet->getStyle('W' . $row)
                ->getFont()
                ->setName('Times New Roman');

            $sheet->setCellValue('X' . $row, $student->dkg ?? '');  // ខ្មែរ
            $sheet->getStyle('X' . $row)
                ->getFont()
                ->setName('Times New Roman');

            $sheet->setCellValue('Y' . $row, $student->dmg ?? '');  // គណិត
            $sheet->getStyle('Y' . $row)
                ->getFont()
                ->setName('Times New Roman');

            $sheet->setCellValue('Z' . $row, $student->dbg ?? '');  // ជីវៈ
            $sheet->getStyle('Z' . $row)
                ->getFont()
                ->setName('Times New Roman');

            $sheet->setCellValue('AA' . $row, $student->dchg ?? '');  // គីមី
            $sheet->getStyle('AA' . $row)
                ->getFont()
                ->setName('Times New Roman');

            $sheet->setCellValue('AB' . $row, $student->dhg ?? '');  // ប្រវត្ត
            $sheet->getStyle('AB' . $row)
                ->getFont()
                ->setName('Times New Roman');

            $sheet->setCellValue('AC' . $row, $student->dpg ?? '');  // រូប
            $sheet->getStyle('AC' . $row)
                ->getFont()
                ->setName('Times New Roman');

            $sheet->setCellValue('AD' . $row, $student->dgg ?? '');  // ភូមិ
            $sheet->getStyle('AD' . $row)
                ->getFont()
                ->setName('Times New Roman');

            $sheet->setCellValue('AE' . $row, $student->dcg ?? '');  // សីលធម៌
            $sheet->getStyle('AE' . $row)
                ->getFont()
                ->setName('Times New Roman');

            $sheet->setCellValue('AF' . $row, $student->desg ?? '');  // ផែនដី
            $sheet->getStyle('AF' . $row)
                ->getFont()
                ->setName('Times New Roman');
        }

        // Data style
        $lastDataRow = $students->count() + $startRow - 1;  // Last row with data
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],  // Black color for borders
                ],
            ],
        ];
        $sheet->getStyle('A3:' . $lastHeaderColumn . $lastDataRow)->applyFromArray($dataStyle);

        // Auto-size all columns
        foreach (range(0, count($headers) - 1) as $index) {
            $columnLetter = getColumnLetter($index);
            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
        }

        // Generate and download the Excel file
        $fileName = 'students_data.xlsx';
        if (ob_get_level()) {
            ob_end_clean();
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}

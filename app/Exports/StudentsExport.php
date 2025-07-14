<?php

namespace App\Exports;

use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Plan;
use App\Models\Student;
use DB;

class StudentsExport implements WithMultipleSheets, ShouldAutoSize
{
    protected $students;

    // Constructor to accept the students data
    public function __construct($students)
    {
        $this->students = $students;
    }

    // This method returns multiple sheets based on the plan_id
    public function sheets(): array
    {
        $sheets = [];

        // Group students by plan_id
        $studentsByPlan = $this->students->groupBy('plan_id');

        // Loop through each group and create a sheet for each plan_id
        foreach ($studentsByPlan as $planId => $students) {
            $sheets[] = new StudentsSheet($planId, $students);
        }

        return $sheets;
    }

    public function view(): View
    {
        $data = DB::table('students')
            ->join('majors', 'students.major_id', '=', 'majors.id')
            ->join('levels', 'majors.level_id', '=', 'levels.id')
            ->select(
                'students.plan_id',
                'levels.name_kh as level_name',
                'majors.name_kh as major_name',
                DB::raw('COUNT(students.id) as total_students')
            )
            ->groupBy('students.plan_id', 'levels.name_kh', 'majors.name_kh')
            ->get();

        $groupedData = $data->groupBy('plan_id')->map(function ($planData) {
            return $planData->groupBy('level_name');
        });

        return redirect()->view('reports.student_report', compact('groupedData'));
    }
}

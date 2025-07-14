<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Semester;
use App\Models\StudentCourse;
use Illuminate\Http\Request;

class TranscriptController extends Controller
{
    public function create($student_id)
    {
        $student = Student::findOrFail($student_id);
        $courses = Course::all();
        $semesters = Semester::all();
        return view('transcripts.create', compact('student', 'courses', 'semesters'));
    }

    public function store(Request $request, $student_id)
    {
        foreach ($request->courses as $index => $course_id) {
            StudentCourse::create([
                'student_id' => $student_id,
                'course_id' => $course_id,
                'semester_id' => $request->semesters[$index],
                'grade_point' => $request->grade_points[$index],
                'total_point' => $request->credits[$index] * $request->grade_points[$index],
            ]);
        }

        return redirect()->route('students.show', $student_id)->with('success', 'Transcript added successfully.');
    }
}

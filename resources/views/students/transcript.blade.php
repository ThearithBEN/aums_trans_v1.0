<!-- resources/views/students/transcript.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center fw-bold mb-4">ព្រឹត្តបត្រពិន្ទុ</h2>
    <div class="row mb-3">
        <div class="col-md-6">
            <p><strong>Student ID:</strong> {{ $student->student_id }}</p>
            <p><strong>ឈ្មោះ:</strong> {{ $student->name_kh }} / {{ $student->name_en }}</p>
            <p><strong>ភេទ:</strong> {{ $student->gender_id == 1 ? 'ប្រុស' : 'ស្រី' }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>ថ្ងៃខែឆ្នាំកំណើត:</strong> {{ $student->dob }}</p>
            <p><strong>ជំនាញ:</strong> {{ $student->major->name_kh }}</p>
            <p><strong>ថ្នាក់សិក្សា:</strong> {{ $student->level->name_kh }}</p>
        </div>
    </div>

    @foreach($transcripts as $semesterName => $courses)
        <h5 class="mt-4">{{ $semesterName }}</h5>
        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>Course Title</th>
                    <th>Credit</th>
                    <th>Grade Point</th>
                    <th>Total Point</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalCredits = 0;
                    $totalPoints = 0;
                @endphp
                @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->credit }}</td>
                        <td>{{ $course->grade_point }}</td>
                        <td>{{ $course->total_point }}</td>
                    </tr>
                    @php
                        $totalCredits += $course->credit;
                        $totalPoints += $course->total_point;
                    @endphp
                @endforeach
            </tbody>
        </table>
        <p><strong>Total Credits:</strong> {{ $totalCredits }} | <strong>GPA:</strong> {{ number_format($totalPoints / $totalCredits, 2) }}</p>
    @endforeach
</div>
@endsection

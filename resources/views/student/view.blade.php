@extends('layouts.app')

@section('main')
    <div class="pagetitle">
        <h1 style="font-family: 'Khmer OS Muol'">និសិ្សតទិញ ឬដាក់ពាក្យ</h1>
        <nav>
            <ol class="mt-3 breadcrumb">
                <li class="breadcrumb-item active" style="font-family: 'Khmer OS Siemreap'"><a
                        href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
                <li class="breadcrumb-item active" style="font-family: 'Khmer OS Siemreap'"><a
                        href="{{ route('students.index') }}">បញ្ជីឈ្មោះនិសិ្សត</a></li>
                <li class="breadcrumb-item active" style="font-family: 'Khmer OS Siemreap'">ព័ត៌មានលម្អិតរបស់និសិ្សត</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="font-family: 'Khmer OS Muol', sans-serif;">ព័ត៌មានលម្អិត</h5>
                        <hr>
                        <div class="row g-3">
                            @php
                                use Carbon\Carbon;
                                use App\Helpers\FormatPhoneNumber;

                                $khmerMonths = [
                                    '01' => 'មករា',
                                    '02' => 'កុម្ភៈ',
                                    '03' => 'មីនា',
                                    '04' => 'មេសា',
                                    '05' => 'ឧសភា',
                                    '06' => 'មិថុនា',
                                    '07' => 'កក្កដា',
                                    '08' => 'សីហា',
                                    '09' => 'កញ្ញា',
                                    '10' => 'តុលា',
                                    '11' => 'វិច្ឆិកា',
                                    '12' => 'ធ្នូ',
                                ];

                                $date = Carbon::parse($student->register_date);
                                $formattedDate =
                                    $date->format('d') .
                                    ' ' .
                                    $khmerMonths[$date->format('m')] .
                                    ' ' .
                                    $date->format('Y');

                                $dob = $student->dob ? Carbon::parse($student->dob) : null;
                                $formattedDob = $dob
                                    ? $dob->format('d') .
                                        ' ' .
                                        $khmerMonths[$dob->format('m')] .
                                        ' ' .
                                        $dob->format('Y')
                                    : 'គ្មានទិន្នន័យ';
                            @endphp
                            {{-- Left Side --}}
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">អត្តលេខ</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->student_id ? App\Helpers\NumberConverter::formatStudentCode($student->student_id) : 'គ្មានទិន្នន័យ​' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ឈ្មោះខ្មែរ</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->name_kh ? $student->name_kh : 'គ្មានទិន្នន័យ​' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ឈ្មោះឡាតាំង</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->name_en ? $student->name_en : 'គ្មានទិន្នន័យ​​' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ភេទ</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->gender_id === 1 ? 'ប្រុស' : ($student->gender_id === 2 ? 'ស្រី' : 'ផ្សេង') }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ពេលសិក្សា</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->study_shift_id === 1 ? 'ព្រឹក' : 'រសៀល' }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">វគ្គសិក្សា</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->course_id ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">កម្រិតសិក្សា</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->level->name_kh ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ខេត្ត/ក្រុង</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->province->name_kh ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">វិទ្យាល័យ</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->high_school ? $student->high_school : 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">
                                    ថ្ងៃខែឆ្នាំកំណើត
                                </label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $formattedDob }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ក្របខណ្ឌ</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->cadre->name_kh ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">អាហារូបករណ៍</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->scholarship ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">លេខទូរស័ព្ទផ្ទាល់ខ្លួន</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->p_phone ? FormatPhoneNumber::formatView($student->p_phone) : 'គ្មានទិន្នន័យ' }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">លេខទូរស័ព្ទអាណាព្យាបាល</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->par_phone ? FormatPhoneNumber::formatView($student->par_phone) : 'គ្មានទិន្នន័យ​​' }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ឆ្នាំសិក្សា</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->study_year == 6 ? 'គ្មានទិន្នន័យ' : 'ឆ្នាំទី ' . $student->study_year }}
                                </>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">មុខជំនាញ</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->major->name_kh ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">មហាវិទ្យាល័យ</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->faculty->name_kh ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">គោលបំណង</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->plan->name_kh ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ទទួលបានដំណឹងតាមរយៈ</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->reference->name_kh }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ឈ្មោះអ្នកណែនាំ</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    {{ $student->refer_by_name ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">លេខទូរស័ព្ទអ្នកណែនាំ</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ FormatPhoneNumber::formatView($student->refer_by_phone) ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">កាលបរិច្ឆេទ</label>
                                <p style="font-family: 'Khmer OS Siemreap', sans-serif;">{{ $formattedDate }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Right Side --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="font-family: 'Khmer OS Muol', sans-serif;">ព័ត៌មាន /
                            លទ្ធិផលប្រឡងបាក់ឌុប
                        </h5>
                        <hr>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="diploma_year" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ឆ្នាំប្រឡងបាក់ឌុប</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->yde }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="diploma_number" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">លេខសញ្ញាបត្រ</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->diploma_number ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="diploma_grade" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">និទ្ទេស</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->diploma_grade ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="dkg" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ភាសាខ្មែរ</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->dkg ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="dmg" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">គណិតវិទ្យា</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->dmg ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="dbg" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ជីវៈវិទ្យា</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->dbg ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="dchg" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">គីមីវិទ្យា</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->dchg ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="dhg" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ប្រវត្តវិទ្យា</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->dhg ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="dpg" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">រូបវិទ្យា</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->dpg ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="dgg" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ភូមិវិទ្យា</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->dgg ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="dcg" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">សីលធម៌</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->dcg ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="desg" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ផែនដីវិទ្យា</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->desg ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="dflg" class="form-label"
                                    style="font-family: 'Khmer OS Muol', sans-serif; color:rgb(90, 90, 90);">ភាសាបរទេស</label>
                                <p style="font-family: 'Times New Roman', sans-serif;">
                                    {{ $student->dflg ?? 'គ្មានទិន្នន័យ' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Button --}}
                <div class="col-12 text-end" style="font-family: 'Khmer OS Siemreap'">
                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">កែប្រែ</a>
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                        style="display:inline;"
                        onsubmit="return confirm('Are you sure you want to delete this student?');">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" title="Delete"
                            onclick="confirmDeletion('{{ route('students.destroy', $student->id) }}')">លុប</button>
                    </form>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">ថយក្រោយ</a>
                </div>
            </div>
        </div>
    </section>
@endsection

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
            <li class="breadcrumb-item active" style="font-family: 'Khmer OS Siemreap'">បន្ថែមនិសិ្សតថ្មី</li>
        </ol>
    </nav>
</div>

<section class="section">
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <!-- CSRF Protection -->
        <div class="row g-3">
            {{-- Left Side --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="font-family: 'Khmer OS Muol', sans-serif;">ព័ត៌មានលម្អិត</h5>
                        <hr>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label for="student_id" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">អត្តលេខ</label>
                                <input type="text" class="form-control" id="student_id" name="student_id"
                                    placeholder="AU12345" style="font-family: 'Times New Roman', sans-serif;">
                            </div>
                            <div class="col-md-4">
                                <label for="name_kh" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ឈ្មោះខ្មែរ</label>
                                <input type="text" class="form-control" id="name_kh" name="name_kh"
                                    placeholder="សុខ ដារា" style="font-family: 'Khmer OS Siemreap', sans-serif;">
                            </div>
                            <div class="col-md-4">
                                <label for="name_en" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ឈ្មោះឡាតាំង</label>
                                <input type="text" class="form-control" id="name_en" name="name_en" style="font-family: 'Times New Roman', sans-serif;"
                                    placeholder="Sok Dara">
                            </div>
                            <div class="col-md-2">
                                <label for="gender" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ភេទ</label>
                                <select id="gender" name="gender" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option disabled>ជ្រើសរើស...
                                    </option>
                                    <option value="1">ប្រុស
                                    </option>
                                    <option value="2">ស្រី
                                    </option>
                                    <option value="3" selected>ផ្សេង
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="study_shift" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ពេលសិក្សា</label>
                                <select id="study_shift" name="study_shift" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option disabled>ជ្រើសរើស...</option>
                                    <option value="1">ព្រឹក
                                    </option>
                                    <option value="2">រសៀល
                                    </option>
                                    <option value="3">យប់
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="course" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">វគ្គសិក្សា</label>
                                <input type="text" class="form-control" id="course" name="course" style="font-family: 'Times New Roman', sans-serif;" placeholder="1-7">
                            </div>
                            <div class="col-md-4">
                                <label for="level" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">កម្រិតសិក្សា</label>
                                <select id="level" name="level" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option disabled>ជ្រើសរើស...</option>
                                    @foreach ($levels as $l)
                                    <option value="{{ $l->id }}" {{ $l->id == 3 ? 'selected' : '' }}>
                                        {{ $l->name_kh }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="province" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ខេត្ត/ក្រុង</label>
                                <select id="province" name="province" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option disabled>ជ្រើសរើស...</option>
                                    @foreach ($provinces as $p)
                                    <option value="{{ $p->id }}" {{ $p->id == 18 ? 'selected' : '' }}>
                                        {{ $p->name_kh }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="high_school" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">វិទ្យាល័យ</label>
                                <input type="text" class="form-control" id="high_school" name="high_school"
                                    list="high_school_list" placeholder="វិទ្យាល័យអង្គរ"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                <datalist id="high_school_list" style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    @foreach($high_schools as $hs)
                                    <option value="{{ $hs->name_kh }}">{{ $hs->name_kh }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3">
                                <label for="dob" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ថ្ងៃខែឆ្នាំកំណើត</label>
                                <input type="date" class="form-control" id="dob" name="dob" placeholder="--/--/----" style="font-family: 'Times New Roman', sans-serif;"
                                    onfocus="this.showPicker()">
                            </div>
                            <div class="col-md-3">
                                <label for="cadre" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ក្របខណ្ឌ</label>
                                <select id="cadre" class="form-select" name="cadre"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option disabled>ជ្រើសរើស...</option>
                                    @foreach ($cadres as $cadre)
                                    <option value="{{ $cadre->id }}">
                                        {{ $cadre->name_kh }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="scholarship" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">អាហារូបករណ៍</label>
                                <input type="text" class="form-control" id="scholarship" name="scholarship"
                                    placeholder="ជាប់/ធ្លាក់" style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                <datalist id="scholarship" style="font-family: 'Khmer OS Siemreap', sans-serif;" class="mt-2">
                                    <option value="ជាប់">ជាប់</option>
                                    <option value="ធ្លាក់">ធ្លាក់</option>
                                </datalist>
                            </div>
                            <div class="col-md-4">
                                <label for="personal_phone" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">លេខទូរស័ព្ទផ្ទាល់ខ្លួន</label>
                                <input type="text" class="form-control" id="personal_phone" name="personal_phone" style="font-family: 'Times New Roman', sans-serif;"
                                    placeholder="012 xxx xxx">
                            </div>
                            <div class="col-md-4">
                                <label for="parents_phone" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">លេខទូរស័ព្ទអាណាព្យាបាល</label>
                                <input type="text" class="form-control" id="parents_phone" name="parents_phone" style="font-family: 'Times New Roman', sans-serif;"
                                    placeholder="012 xxx xxx">
                            </div>
                            <div class="col-md-4">
                                <label for="study_year" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ឆ្នាំសិក្សា</label>
                                <select id="study_year" name="study_year" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option disabled>ជ្រើសរើស...</option>
                                    <option value="1">
                                        ឆ្នាំទី ១
                                    </option>
                                    <option value="2">
                                        ឆ្នាំទី ២
                                    </option>
                                    <option value="3">
                                        ឆ្នាំទី ៣
                                    </option>
                                    <option value="4">
                                        ឆ្នាំទី ៤
                                    </option>
                                    <option value="5">
                                        ឆ្នាំទី ៥
                                    </option>
                                    <option value="6" selected>
                                        គ្មានទិន្នន័យ
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="faculty" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">មហាវិទ្យាល័យ</label>
                                <select id="faculty" name="faculty" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" disabled>ជ្រើសរើស...</option>
                                    @foreach ($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ $faculty->id == 8 ? 'selected' : '' }}>
                                        {{ $faculty->name_kh }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="major" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">មុខជំនាញ</label>
                                <select id="major" name="major" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option disabled>ជ្រើសរើស...</option>

                                    @foreach ($faculties as $faculty)
                                    <optgroup label="{{ $faculty->name_kh }}"
                                        style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                        @foreach ($majors->where('faculty_id', $faculty->id)->sortByDesc(fn($major) =>
                                        $major->id == 29 ? 1 : 0)->sortBy(fn($major) => $major->id) as $major)
                                        <option value="{{ $major->id }}" {{ $major->id == 29 ? 'selected' : '' }}>
                                            {{ $major->name_kh }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="plan" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">គោលបំណង</label>
                                <select id="plan" name="plan" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="">ជ្រើសរើស...</option> <!-- Disabled default option -->

                                    <?php
    // Group the plans into categories
    $categories = [
        'ទិញពាក្យ' => [],
        'ដាក់ពាក្យ' => [],
        'ស្នើសុំ' => [],
    ];

    foreach ($plans as $plan) {
        if (strpos($plan->name_kh, 'ទិញពាក្យ') === 0) {
            $categories['ទិញពាក្យ'][] = $plan;
        } elseif (strpos($plan->name_kh, 'ដាក់ពាក្យ') === 0) {
            $categories['ដាក់ពាក្យ'][] = $plan;
        } elseif (strpos($plan->name_kh, 'ស្នើសុំ') === 0) {
            $categories['ស្នើសុំ'][] = $plan;
        }
    }

    // Render the options in the desired order
    foreach ($categories as $category => $groupedPlans) {
        echo '<optgroup label="' . htmlspecialchars($category) . '">'; // Add a label for each category
        foreach ($groupedPlans as $plan) {
            echo '<option value="' . $plan->id . '" ' . ($plan->id == 1 ? 'disabled' : '') . '>' . htmlspecialchars($plan->name_kh) . '</option>';
        }
        echo '</optgroup>';
    }
                                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="reference" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ស្គាល់សាកលវិទ្យាល័យតាមរយៈ</label>
                                <select id="reference" name="reference" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option disabled>ជ្រើសរើស...</option>
                                    @foreach ($references as $reference)
                                    <option value="{{ $reference->id }}">
                                        {{ $reference->name_kh }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="refer_by_name" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ឈ្មោះអ្នកណែនាំ</label>
                                <input type="text" class="form-control" id="refer_by_name"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;" name="refer_by_name"
                                    placeholder="សុខ ដារា">
                            </div>
                            <div class="col-md-4">
                                <label for="refer_by_phone" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">លេខទូរស័ព្ទអ្នកណែនាំ</label>
                                <input type="text" class="form-control" id="refer_by_phone" name="refer_by_phone"
                                    placeholder="012 xxx xxx" style="font-family: 'Times New Roman', sans-serif;">
                            </div>
                            <div class="col-md-4">
                                <label for="register_date" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">កាលបរិច្ឆេទ</label>
                                <input type="date" class="form-control" id="register_date" name="register_date"
                                    placeholder="--/--/----" value="{{ date('Y-m-d') }}" style="font-family: 'Times New Roman', sans-serif;">
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
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ឆ្នាំប្រឡងបាក់ឌុប</label>
                                <select id="diploma_year" name="diploma_year" class="form-select"
                                    style="font-family: 'Times New Roman', sans-serif;">
                                    <option disabled>ជ្រើសរើស...</option>
                                    @foreach (range(date('Y'), 2000) as $year)
                                    <option value="{{ $year }}">{{ $year }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="diploma_number" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">លេខសញ្ញាបត្រ</label>
                                <input type="text" class="form-control" id="diploma_number" name="diploma_number"
                                    placeholder="12345" style="font-family: 'Times New Roman', sans-serif;">
                            </div>
                            <div class="col-md-6">
                                <label for="diploma_grade" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">និទ្ទេស</label>
                                <select id="diploma_grade" name="diploma_grade" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" selected>ជ្រើសរើស...</option>
                                    <span style="font-family: 'Times New Roman', sans-serif;">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    </span>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dkg" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ភាសាខ្មែរ</label>
                                <select id="dkg" name="dkg" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" selected>ជ្រើសរើស...</option>
                                    <span style="font-family: 'Times New Roman', sans-serif;">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    </span>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dmg" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">គណិតវិទ្យា</label>
                                <select id="dmg" name="dmg" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" selected>ជ្រើសរើស...</option>
                                    <span style="font-family: 'Times New Roman', sans-serif;">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    </span>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dbg" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ជីវៈវិទ្យា</label>
                                <select id="dbg" name="dbg" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" selected>ជ្រើសរើស...</option>
                                    <span style="font-family: 'Times New Roman', sans-serif;">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    </span>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dchg" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">គីមីវិទ្យា</label>
                                <select id="dchg" name="dchg" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" selected>ជ្រើសរើស...</option>
                                    <span style="font-family: 'Times New Roman', sans-serif;">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    </span>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dhg" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ប្រវត្តវិទ្យា</label>
                                <select id="dhg" name="dhg" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" selected>ជ្រើសរើស...</option>
                                    <span style="font-family: 'Times New Roman', sans-serif;">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    </span>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dpg" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">រូបវិទ្យា</label>
                                <select id="dpg" name="dpg" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" selected>ជ្រើសរើស...</option>
                                    <span style="font-family: 'Times New Roman', sans-serif;">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    </span>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dgg" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ភូមិវិទ្យា</label>
                                <select id="dgg" name="dgg" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" selected>ជ្រើសរើស...</option>
                                    <span style="font-family: 'Times New Roman', sans-serif;">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    </span>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dcg" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">សីលធម៌</label>
                                <select id="dcg" name="dcg" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" selected>ជ្រើសរើស...</option>
                                    <span style="font-family: 'Times New Roman', sans-serif;">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    </span>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="desg" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ផែនដីវិទ្យា</label>
                                <select id="desg" name="desg" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" selected>ជ្រើសរើស...</option>
                                    <span style="font-family: 'Times New Roman', sans-serif;">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    </span>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dflg" class="form-label"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">ភាសាបរទេស</label>
                                <select id="dflg" name="dflg" class="form-select"
                                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                    <option value="" selected>ជ្រើសរើស...</option>
                                    <span style="font-family: 'Times New Roman', sans-serif;">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    </span>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Button --}}
                <div class="col-12 text-end" style="font-family: 'Khmer OS Siemreap'">
                    <button type="submit" class="btn btn-primary" id="submitButton">រក្សាទុក</button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-back">ថយក្រោយ</a>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

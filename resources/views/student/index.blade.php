@extends('layouts.app')

@section('main')
    <div class="pagetitle">
        <h1 style="font-family: 'Khmer OS Muol'">និសិ្សតទិញ ឬដាក់ពាក្យ</h1>
        <nav>
            <ol class="mt-3 breadcrumb">
                <li class="breadcrumb-item active" style="font-family: 'Khmer OS Siemreap'"><a
                        href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
                <li class="breadcrumb-item active" style="font-family: 'Khmer OS Siemreap'">បញ្ជីឈ្មោះនិសិ្សត</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <h5 class="card-title" style="font-family: 'Khmer OS Muol', sans-serif;">បញ្ជីឈ្មោះនិស្សិត</h5>
                        </div>
                        <div class="mt-3 col-12 col-md-8 d-flex justify-content-end align-items-start">
                            <div class="input-group d-flex justify-content-end">
                                <form class="mb-2 d-flex align-items-start" method="GET"
                                    action="{{ route('students.index') }}">
                                    <input type="text" class="form-control me-1" name="query"
                                        placeholder="ស្វែងរកឈ្មោះនិស្សិត" title="ស្វែងរកឈ្មោះនិស្សិត"
                                        value="{{ request('query') }}">
                                    <button type="submit" class="btn btn-outline-secondary" title="ស្វែងរក"><i
                                            class="bi bi-search"></i></button>
                                </form>
                                <div class=" d-flex justify-content-end align-items-start">
                                    <a href="{{ route('students.create') }}" class="mx-2 btn btn-outline-secondary"
                                        title="Add Customer">
                                        <i class="bi bi-person-plus"></i> <!-- Bootstrap Icons for View -->
                                    </a>

                                    <a href="{{ route('students.export', ['major' => request('major', 'all'), 'year' => request('year', 'all'), 'month' => request('month', 'all'), 'day' => request('day', 'all')]) }}"
                                        class="btn btn-outline-secondary"> <i class="bi bi-file-earmark-arrow-down"></i>
                                    </a>
                                </div>
                                <!-- Dropdown for Mobile and Tablet -->
                                <div class="mx-2 mb-2 dropdown">
                                    <!-- Dropdown Toggle -->
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-filter-right me-2"></i>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                        <!-- Filter Section -->
                                        <li class="dropdown-header text-start">
                                            <h6 style="font-family: 'Khmer OS Muol', sans-serif;">សម្រង់និស្សិត</h6>
                                        </li>
                                        <li>
                                            <form action="{{ route('students.index') }}" method="GET" class="px-3 pb-3"
                                                style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                                <div class="mb-2">
                                                    <select name="major" class="form-select custom-select"
                                                        style="width: 100%;">
                                                        <option value="" disabled>ជ្រើសរើស...</option>
                                                        <option value="all"
                                                            {{ request('major') === 'all' ? 'selected' : '' }}>គ្រប់មុខជំនាញ
                                                        </option>
                                                        @foreach ($faculties as $faculty)
                                                            <optgroup label="{{ $faculty->name_kh }}"
                                                                style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                                                @foreach ($majors->where('faculty_id', $faculty->id)->sortByDesc(fn($major) => $major->id == 31 ? 1 : 0)->sortBy(fn($major) => $major->id) as $major)
                                                                    <option value="{{ $major->id }}">
                                                                        {{ $major->name_kh }}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <select name="year" class="form-select custom-select">
                                                        <option value="all"
                                                            {{ request('year') === 'all' ? 'selected' : '' }}>គ្រប់ឆ្នាំ
                                                        </option>
                                                        @php
                                                            $currentYear = date('Y');
                                                            $yearsInKhmer = range($currentYear - 10, $currentYear + 10);
                                                        @endphp
                                                        @foreach ($yearsInKhmer as $year)
                                                            <option value="{{ $year }}"
                                                                {{ request('year') == $year ? 'selected' : '' }}>
                                                                {{ \App\Helpers\NumberConverter::toKhmer($year) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <select name="month" class="form-select custom-select">
                                                        <option value="all"
                                                            {{ request('month') === 'all' ? 'selected' : '' }}>គ្រប់ខែ
                                                        </option>
                                                        @php
                                                            $monthsInKhmer = [
                                                                'មករា',
                                                                'កុម្ភៈ',
                                                                'មីនា',
                                                                'មេសា',
                                                                'ឧសភា',
                                                                'មិថុនា',
                                                                'កក្កដា',
                                                                'សីហា',
                                                                'កញ្ញា',
                                                                'តុលា',
                                                                'វិច្ឆិកា',
                                                                'ធ្នូ',
                                                            ];
                                                        @endphp
                                                        @for ($m = 1; $m <= 12; $m++)
                                                            <option value="{{ $m }}"
                                                                {{ request('month') == $m ? 'selected' : '' }}>
                                                                {{ $monthsInKhmer[$m - 1] }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <select name="day" class="form-select custom-select">
                                                        <option value="all"
                                                            {{ request('day') === 'all' ? 'selected' : '' }}>គ្រប់ថ្ងៃ
                                                        </option>
                                                        @php
                                                            $daysInKhmer = [
                                                                '១',
                                                                '២',
                                                                '៣',
                                                                '៤',
                                                                '៥',
                                                                '៦',
                                                                '៧',
                                                                '៨',
                                                                '៩',
                                                                '១០',
                                                                '១១',
                                                                '១២',
                                                                '១៣',
                                                                '១៤',
                                                                '១៥',
                                                                '១៦',
                                                                '១៧',
                                                                '១៨',
                                                                '១៩',
                                                                '២០',
                                                                '២១',
                                                                '២២',
                                                                '២៣',
                                                                '២៤',
                                                                '២៥',
                                                                '២៦',
                                                                '២៧',
                                                                '២៨',
                                                                '២៩',
                                                                '៣០',
                                                                '៣១',
                                                            ];
                                                        @endphp
                                                        @for ($d = 1; $d <= 31; $d++)
                                                            <option value="{{ $d }}"
                                                                {{ request('day') == $d ? 'selected' : '' }}>
                                                                {{ $daysInKhmer[$d - 1] }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Primary Color Bordered Table -->
                    <table class="table text-center table-hover table-striped">
                        <thead class="table-bordered border-primary"
                            style="font-family: 'Khmer OS Muol', sans-serif; font-size: 12px; font-weight: normal;">
                            <tr>
                                <th rowspan="2" scope="col">ល.រ</th>
                                <th rowspan="2" scope="col">កាលបរិច្ឆេទ</th>
                                <th rowspan="2" scope="col">ឈ្មោះ</th>
                                <th rowspan="2" scope="col">ភេទ</th>
                                <th rowspan="2" scope="col">កម្រិតសិក្សា</th>
                                <th rowspan="2" scope="col">វិទ្យាល័យ</th>
                                <th rowspan="2" scope="col">មុខជំនាញ</th>
                                <th rowspan="2" scope="col">លេខទូរស័ព្ទផ្ទាល់ខ្លួន</th>
                                <th rowspan="2" scope="col">សកម្មភាព</th>
                            </tr>
                        </thead>
                        @php
                            use App\Helpers\FormatPhoneNumber;

                            // Define Khmer months array
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
                        @endphp
                        <tbody>
                            @foreach ($students as $key => $student)
                                @php
                                    $date = \Carbon\Carbon::parse($student->register_date);
                                    $formattedDate =
                                        $date->format('d') .
                                        ' ' .
                                        $khmerMonths[$date->format('m')] .
                                        ' ' .
                                        $date->format('Y');
                                @endphp
                                <tr>
                                    <td>{{ ($students->currentPage() - 1) * $students->perPage() + $key + 1 }}</td>
                                    <td style="font-family: 'Khmer OS Siemreap', sans-serif;">{{ $formattedDate }}</td>
                                    <td style="font-family: 'Khmer OS Siemreap', sans-serif;" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        title="{{ optional($student->user)->name ?: optional($student->admin)->name ?: 'គ្មានទិន្នន័យ' }}">
                                        {{ $student->name_kh ?? 'គ្មានទិន្នន័យ' }}
                                    </td>
                                    <td style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                        {{ $student->gender_id == 1 ? 'ប្រុស' : ($student->gender_id == 2 ? 'ស្រី' : 'ផ្សេង') }}
                                    </td>
                                    <td style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                        {{ $student->level->name_kh ?? 'គ្មានទិន្នន័យ' }}
                                    </td>
                                    <td style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                        {{ $student->high_school ?? 'គ្មានទិន្នន័យ' }}
                                    </td>
                                    <td style="font-family: 'Khmer OS Siemreap', sans-serif;">
                                        {{ $student->major->name_kh ?? 'គ្មានទិន្នន័យ' }}
                                    </td>
                                    <td style="font-family: 'Times New Roman', sans-serif;">
                                        {{ FormatPhoneNumber::formatView($student->p_phone) ?? 'គ្មានទិន្នន័យ' }}</td>
                                    <td>
                                        <a href="{{ route('students.view', $student->id) }}"
                                            class="btn btn-info btn-sm" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('students.edit', $student->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" title="Delete"
                                                onclick="confirmDeletion('{{ route('students.destroy', $student->id) }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    @if ($students->isEmpty())
                        <p class="text-center" style="'Khmer OS Siemreap'">គ្មានទិន្នន័យ</p>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                <p>Showing <b>{{ $students->firstItem() }}</b> to <b>{{ $students->lastItem() }}</b> of
                                    <b>{{ $students->total() }}</b> students
                                </p>
                            </div>
                            <div class="col-md-6">
                                <!-- Pagination with icons -->
                                @if ($students->hasPages())
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <!-- Previous Page Link -->
                                            @if ($students->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">&laquo;</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $students->previousPageUrl() }}"
                                                        aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                            @endif

                                            <!-- Pagination Elements -->
                                            @foreach ($students->links()->elements as $element)
                                                <!-- Make three dots when current page is too far from first or last page -->
                                                @if (is_string($element))
                                                    <li class="page-item disabled"><span
                                                            class="page-link">{{ $element }}</span>
                                                    </li>
                                                @endif

                                                <!-- Array Of Links -->
                                                @if (is_array($element))
                                                    @foreach ($element as $page => $url)
                                                        @if ($page == $students->currentPage())
                                                            <li class="page-item active"><span
                                                                    class="page-link">{{ $page }}</span></li>
                                                        @else
                                                            <li class="page-item"><a class="page-link"
                                                                    href="{{ $url }}">{{ $page }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach

                                            <!-- Next Page Link -->
                                            @if ($students->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $students->nextPageUrl() }}"
                                                        aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">&raquo;</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                @endif
                            </div>
                        </div>
                    @endif
                    <!-- End Primary Color Bordered Table -->
                </div>
            </div>

        </div>
    </section>
@endsection

@php
    if (!function_exists('convertToKhmerNumber')) {
        function convertToKhmerNumber($number)
        {
            $khmerNumbers = [
                '0' => '០',
                '1' => '១',
                '2' => '២',
                '3' => '៣',
                '4' => '៤',
                '5' => '៥',
                '6' => '៦',
                '7' => '៧',
                '8' => '៨',
                '9' => '៩',
            ];
            return strtr($number, $khmerNumbers);
        }
    }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Angkor University</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    {{--
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}"> --}}

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    {{-- <div class="preloader flex-column justify-content-center align-items-center" style="height: 0px;">
        <img class="animation__bobble" src="{{ asset('assets/img/logo.png') }}" alt="AngkorUniversity" height="120"
            width="120" style="display: none;">

        <p id="preloader-text"
            style="color: #333; font-size: 18px; margin-top: 20px; display: none; font-family: 'Khmer OS Moul', sans-serif;">
            កំពុងដំណើរការ​​... សូមរងចាំ!
        </p>
    </div> --}}

    {{-- <div class="preloader flex-column justify-content-center align-items-center" style="height: 0px;">
        <img class="animation__spin" src="assets/img/logo.png" alt="AngkorUniversity" height="120" width="120"
            style="display: none;">
    </div> --}}

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: '<span style="font-family: \'Khmer OS Muol\', sans-serif;">ជោគជ័យ!</span>',
                    html: '<span style="font-family: \'Khmer OS Siemreap\', sans-serif;">{{ session('success') }}</span>',
                    confirmButtonText: '<span style="font-family: \'Khmer OS Siemreap\', sans-serif;">បាទ/ចាស</span>',
                    timer: 3000
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: '@foreach ($errors->all() as $error) <br> {{ $error }} @endforeach',
                    confirmButtonText: 'សូមព្យាយាមម្ដងទៀត',
                });
            });
        </script>
    @endif

    <!-- ======= Header ======= -->
    @include('layouts.header')

    <!-- ======= Sidebar ======= -->
    @include('layouts.sideBar')

    <main id="main" class="main">
        @yield('main')
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('layouts.footer')


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        function confirmDeletion(deleteUrl) {
            Swal.fire({
                title: '<span style="font-family: \'Khmer OS Muol\', sans-serif;">តើអ្នកប្រាកដទេ?</span>',
                html: '<span style="font-family: \'Khmer OS Siemreap\', sans-serif;">អ្នកមិនអាចទាញយកទិន្នន័យនេះ ត្រឡប់មកវិញបានទេ!</span>',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: '<span style="font-family: \'Khmer OS Siemreap\', sans-serif;">បាទ/ចាស៎</span>',
                cancelButtonText: '<span style="font-family: \'Khmer OS Siemreap\', sans-serif;">ទេ</span>'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form dynamically and submit it
                    const form = document.createElement('form');
                    form.action = deleteUrl;
                    form.method = 'POST';

                    // Add CSRF token and method field
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        const togglePassword = document.getElementById('togglePassword');
        if (togglePassword) {
            togglePassword.addEventListener('click', function () {
                const passwordField = document.getElementById('password');
                const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', passwordFieldType);
                this.querySelector('i').classList.toggle('bi-eye');
                this.querySelector('i').classList.toggle('bi-eye-slash');
            });
        }

        const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
        if (togglePasswordConfirmation) {
            togglePasswordConfirmation.addEventListener('click', function () {
                const passwordConfirmationField = document.getElementById('password_confirmation');
                const passwordConfirmationFieldType = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmationField.setAttribute('type', passwordConfirmationFieldType);
                this.querySelector('i').classList.toggle('bi-eye');
                this.querySelector('i').classList.toggle('bi-eye-slash');
            });
        }

        $(document).ready(function () {
            // Listen for clicks on buttons with data-bs-target="#adminDetailModal"
            $('button[data-bs-target="#adminDetailModal"]').on('click', function () {
                // Get the admin ID from the button's data-admin-id attribute
                const adminId = $(this).data('admin-id');

                // Fetch admin details via AJAX (or preloaded data)
                $.ajax({
                    url: '/get-admin-details/' + adminId, // Replace with your endpoint
                    method: 'GET',
                    success: function (response) {
                        // Populate the modal with the admin's details
                        $('#admin-name-kh').text(response.name_kh || 'គ្មានទិន្នន័យ');
                        $('#admin-gender').text(response.gender_id === 1 ? 'ប្រុស' : (response.gender_id === 2 ? 'ស្រី' : 'ផ្សេង'));
                        $('#admin-phone').text(response.p_phone || 'គ្មានទិន្នន័យ');
                        $('#admin-email').text(response.email || 'គ្មានទិន្នន័យ');
                    },
                    error: function () {
                        alert('Failed to load admin details.');
                    }
                });
            });
        });
    </script>
</body>

</html>

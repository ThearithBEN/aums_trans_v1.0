<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
            <img src="{{ asset('assets/img/logo.png') }}" class="rounded shadow-sm rounded-circle" style="height: 48px" alt="">
            <div class="pl-2 col">
                <span class="d-none d-lg-block pe-3" style="font-family: 'Ang Taso'; font-weight: 800; font-size: 12px; margin-bottom: -5px;">សាកលវិទ្យាល័យ អង្គរ</span>
                <span class="d-none d-lg-block pe-3" style="font-family: 'Times New Roman'; font-size: 16px; letter-spacing: 1.3px;">Angkor University</span>
            </div>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        @if (Auth::user()->info && Auth::user()->info->real_name_kh)
                            <span style="font-family: 'Khmer OS Siemreap';">{{ Auth::user()->info->real_name_kh }}</span>
                        @else
                            <span>{{ Auth::user()->info->real_name_en ?? Auth::user()->name }}</span>
                        @endif
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Profile" style="height: 80px" class="pb-1 rounded-circle">
                        @if (Auth::user()->info && Auth::user()->info->real_name_kh)
                            <h6 style="font-family: 'Khmer OS Siemreap';">{{ Auth::user()->info->real_name_kh }}</h6>
                        @else
                            <h6>{{ Auth::user()->info->real_name_en ?? Auth::user()->name }}</h6>
                        @endif

                        @if (Auth::user()->role && Auth::user()->role->real_name_kh)
                            <span class="mt-2" style="font-family: 'Khmer OS Siemreap';">{{ Auth::user()->role->real_name_kh }}</span>
                        @elseif (Auth::user()->role)
                            <span>{{ Auth::user()->role->real_name_en }}</span>
                        @endif
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                    </form>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" style="font-family:'Khmer OS Siemreap';" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>ចាកចេញ</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

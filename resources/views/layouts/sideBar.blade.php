<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-heading">Admin Dashboard</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}"
                href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span style="font-family: 'Khmer OS Siemreap'">ទំព័រដើម</span>
            </a>
        </li>

        <li class="nav-heading">Students</li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('students.index') ? '' : 'collapsed' }}"
                href="{{ route('students.index') }}">
                <i class="bi bi-grid"></i>
                <span style="font-family: 'Khmer OS Siemreap'">និស្សិត</span>
            </a>
        </li>
    </ul>
</aside>

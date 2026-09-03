<nav class="sidebar d-flex flex-column justify-content-between p-3" style="position: relative;">
    <!-- Tombol Close untuk Mobile -->
    <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup menu">
        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
    </button>

    <div class="sidebar-top-section d-flex flex-column flex-grow-1 overflow-auto">
        <div class="sidebar-header mb-4 mt-2 px-3" data-tour="sidebar-header">
            <h4 class="text-primary m-0 fw-bold d-flex align-items-center gap-2">
                <i class="fa-solid fa-graduation-cap" aria-hidden="true"></i>
                <span>Basa<span class="text-accent" style="font-size: 0.85em;">Kula</span></span>
            </h4>
        </div>

        <ul class="nav flex-column mb-auto">

        
        @auth
            @if(auth()->user()->isAdmin())
                {{-- Menu Khusus Super Admin --}}
                <li class="nav-item mb-1" data-tour="sidebar-dashboard-admin">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                        <i class="fa-solid fa-shield-halved text-primary"></i> Dashboard Admin
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-kelola-pengajar">
                    <a href="{{ route('admin.users.teachers.index') }}" class="nav-link {{ request()->routeIs('admin.users.teachers*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chalkboard-user text-primary"></i> Kelola Pengajar
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-kelola-pelajar">
                    <a href="{{ route('admin.users.students.index') }}" class="nav-link {{ request()->routeIs('admin.users.students*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-graduate text-info"></i> Kelola Pelajar
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-log-aktivitas">
                    <a href="{{ route('admin.activities.index') }}" class="nav-link {{ request()->routeIs('admin.activities*') ? 'active' : '' }}">
                        <i class="fa-solid fa-clock-rotate-left text-warning"></i> Log Aktivitas
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-kelola-kelas">
                    <a href="{{ route('teacher.classroom.index') }}" class="nav-link {{ request()->routeIs('teacher.classroom*') ? 'active' : '' }}">
                        <i class="fa-solid fa-school text-success"></i> Kelola Ruang Kelas
                    </a>
                </li>
                <hr class="my-2 text-muted">
                <li class="nav-item mb-1" data-tour="sidebar-aksara">
                    <a href="{{ route('teacher.javanese-script.index') }}" class="nav-link {{ request()->is('*teacher/javanese-script*') || request()->is('*aksara-jawa*') ? 'active' : '' }}">
                        <i class="fa-solid fa-font"></i> Aksara Jawa
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-macapat">
                    <a href="{{ route('teacher.macapat.index') }}" class="nav-link {{ request()->is('*macapat*') ? 'active' : '' }}">
                        <i class="fa-solid fa-music"></i> Tembang Macapat
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-wayang">
                    <a href="{{ route('wayang.index') }}" class="nav-link {{ request()->is('*wayang*') ? 'active' : '' }}">
                        <i class="fa-solid fa-masks-theater"></i> Pewayangan
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-kamus">
                    <a href="/ui/kosakata" class="nav-link {{ request()->is('*kosakata*') ? 'active' : '' }}">
                        <i class="fa-solid fa-book-journal-whills"></i> Kamus Kosakata
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-translator">
                    <a href="/ui/translator" class="nav-link {{ request()->is('*translator*') ? 'active' : '' }}">
                        <i class="fa-solid fa-language"></i> Translator Jawa
                    </a>
                </li>

            @elseif(auth()->user()->isTeacher())
                {{-- Menu Khusus Pengajar --}}
                <li class="nav-item mb-1" data-tour="sidebar-kelola-kelas">
                    <a href="{{ route('teacher.classroom.index') }}" class="nav-link {{ request()->routeIs('teacher.classroom.index') || request()->routeIs('teacher.classroom.show') ? 'active' : '' }}">
                        <i class="fa-solid fa-chalkboard-user"></i> Kelola Kelas
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-buat-kelas">
                    <a href="{{ route('teacher.classroom.create') }}" class="nav-link {{ request()->routeIs('teacher.classroom.create') ? 'active' : '' }}">
                        <i class="fa-solid fa-plus-circle"></i> Buat Kelas Baru
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-kalender">
                    <a href="{{ route('calendar.index') }}" class="nav-link {{ request()->routeIs('calendar.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days"></i> Kalender Pembelajaran
                    </a>
                </li>
                <hr class="my-2 text-muted">
                <li class="nav-item mb-1" data-tour="sidebar-aksara">
                    <a href="{{ route('teacher.javanese-script.index') }}" class="nav-link {{ request()->is('*teacher/javanese-script*') || request()->is('*aksara-jawa*') ? 'active' : '' }}">
                        <i class="fa-solid fa-font"></i> Aksara Jawa
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-macapat">
                    <a href="{{ route('teacher.macapat.index') }}" class="nav-link {{ request()->is('*macapat*') ? 'active' : '' }}">
                        <i class="fa-solid fa-music"></i> Tembang Macapat
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-wayang">
                    <a href="{{ route('wayang.index') }}" class="nav-link {{ request()->is('*wayang*') ? 'active' : '' }}">
                        <i class="fa-solid fa-masks-theater"></i> Pewayangan
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-kamus">
                    <a href="/ui/kosakata" class="nav-link {{ request()->is('*kosakata*') ? 'active' : '' }}">
                        <i class="fa-solid fa-book-journal-whills"></i> Kamus Kosakata
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-translator">
                    <a href="/ui/translator" class="nav-link {{ request()->is('*translator*') ? 'active' : '' }}">
                        <i class="fa-solid fa-language"></i> Translator Jawa
                    </a>
                </li>
            @else
                <li class="nav-item mb-1" data-tour="sidebar-dashboard-siswa">
                    <a href="{{ route('student.classroom.index') }}" class="nav-link {{ request()->routeIs('student.classroom.*') || request()->is('*classroom*') || request()->is('*kelas*') || request()->is('ui/student*') ? 'active' : '' }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i> Dashboard & Kelas Saya
                    </a>
                </li>

                <li class="nav-item mb-1" data-tour="sidebar-kalender">
                    <a href="{{ route('calendar.index') }}" class="nav-link {{ request()->routeIs('calendar.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days"></i> Kalender Pembelajaran
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-aksara">
                    <a href="{{ route('javanese-script.index') }}" class="nav-link {{ request()->is('*aksara-jawa*') ? 'active' : '' }}">
                        <i class="fa-solid fa-font"></i> Aksara Jawa
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-macapat">
                    <a href="{{ route('macapat.index') }}" class="nav-link {{ request()->is('*macapat*') ? 'active' : '' }}">
                        <i class="fa-solid fa-music"></i> Tembang Macapat
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-wayang">
                    <a href="{{ route('wayang.index') }}" class="nav-link {{ request()->is('*wayang*') ? 'active' : '' }}">
                        <i class="fa-solid fa-masks-theater"></i> Pewayangan
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-kamus">
                    <a href="/ui/kosakata" class="nav-link {{ request()->is('*kosakata*') ? 'active' : '' }}">
                        <i class="fa-solid fa-book-journal-whills"></i> Kamus Kosakata
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-translator">
                    <a href="/ui/translator" class="nav-link {{ request()->is('*translator*') ? 'active' : '' }}">
                        <i class="fa-solid fa-language"></i> Translator Jawa
                    </a>
                </li>
                <li class="nav-item mb-1" data-tour="sidebar-bookmark">
                    <a href="{{ route('student.bookmarks.index') }}" class="nav-link {{ request()->routeIs('student.bookmarks.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bookmark text-warning"></i> Bookmark Saya
                    </a>
                </li>
            @endif
        @else
            {{-- Menu untuk Tamu yang Belum Login --}}
            <li class="nav-item mb-1">
                <a href="{{ route('login') }}" class="nav-link active">
                    <i class="fa-solid fa-right-to-bracket"></i> Silakan Login
                </a>
            </li>
        @endauth
        
        <hr class="my-3 text-muted">
    </ul>
    </div>

    <div class="dropdown pt-2 border-top border-light-subtle">

        @auth
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle px-3 py-2 text-main" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=C9A66B&color=fff" alt="" width="32" height="32" class="rounded-circle me-2">
            <div class="lh-1 text-truncate">
                <strong class="d-block text-truncate" style="max-width:120px;">{{ auth()->user()->name }}</strong>
                <small class="text-muted" style="font-size:0.65rem;">
                    @if(auth()->user()->isAdmin())
                        Administrator
                    @elseif(auth()->user()->isTeacher())
                        Pengajar ({{ auth()->user()->user_code ?? 'Guru' }})
                    @else
                        Pelajar ({{ auth()->user()->user_code ?? 'Siswa' }})
                    @endif
                </small>
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user me-2"></i> Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
        @else
        <div class="px-2">
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill w-100 fw-bold">
                <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk Akun
            </a>
        </div>
        @endauth
    </div>
</nav>

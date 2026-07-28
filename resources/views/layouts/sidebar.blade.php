<nav class="sidebar d-flex flex-column p-3">
    <div class="sidebar-header mb-4 mt-2 px-3">
        <h4 class="text-primary m-0 fw-bold">
            <i class="fa-solid fa-graduation-cap me-2"></i>SinauBasa
        </h4>
    </div>

    <ul class="nav flex-column mb-auto">
        
        <!-- Pengalih Peran (Role Switcher untuk Testing) -->
        <li class="nav-item mb-3 px-2">
            <div class="p-2 bg-light rounded-4 border">
                <small class="text-muted d-block mb-1 text-center fw-bold" style="font-size:0.7rem;">MODE NAVIGASI</small>
                <div class="btn-group w-100" role="group">
                    <a href="/ui/student" class="btn btn-xs btn-sm rounded-pill {{ request()->is('ui/student*') || request()->is('ui/materi*') || request()->is('ui/kosakata*') || request()->is('ui/translator*') || request()->is('ui/quiz*') ? 'btn-primary' : 'btn-light' }}">
                        <i class="fa-solid fa-user-graduate me-1"></i>Pelajar
                    </a>
                    <a href="/ui/teacher/kelas" class="btn btn-xs btn-sm rounded-pill {{ request()->is('ui/teacher*') ? 'btn-primary' : 'btn-light' }}">
                        <i class="fa-solid fa-chalkboard-user me-1"></i>Pengajar
                    </a>
                </div>
            </div>
        </li>

        {{-- Navigasi Menu Pelajar --}}
        @if(!request()->is('ui/teacher*'))
        <li class="nav-item mb-1">
            <a href="/ui/student" class="nav-link {{ request()->is('ui/student') || request()->is('/') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i> Dashboard Siswa
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/ui/student/kelas" class="nav-link {{ request()->is('ui/student/kelas*') ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user"></i> Ruang Kelas
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/ui/materi" class="nav-link {{ request()->is('*materi*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-open"></i> Materi Belajar
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/ui/kosakata" class="nav-link {{ request()->is('*kosakata*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-journal-whills"></i> Kamus Kosakata
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/ui/translator" class="nav-link {{ request()->is('*translator*') ? 'active' : '' }}">
                <i class="fa-solid fa-language"></i> Translator Jawa
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/ui/quiz" class="nav-link {{ request()->is('*quiz*') ? 'active' : '' }}">
                <i class="fa-solid fa-pen-to-square"></i> Evaluasi / Quiz
            </a>
        </li>
        @else
        {{-- Navigasi Menu Pengajar --}}
        <li class="nav-item mb-1">
            <a href="/ui/teacher/kelas" class="nav-link {{ request()->is('ui/teacher/kelas') ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user"></i> Kelola Kelas
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/ui/teacher/kelas/create" class="nav-link {{ request()->is('ui/teacher/kelas/create') ? 'active' : '' }}">
                <i class="fa-solid fa-plus-circle"></i> Buat Kelas Baru
            </a>
        </li>
        @endif
        
        <hr class="my-3 text-muted">
    </ul>

    <hr class="text-muted my-2">
    
    <div class="dropdown">
        @auth
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle px-3 py-2 text-main" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=C9A66B&color=fff" alt="" width="32" height="32" class="rounded-circle me-2">
            <div class="lh-1 text-truncate">
                <strong class="d-block text-truncate" style="max-width:120px;">{{ auth()->user()->name }}</strong>
                <small class="text-muted" style="font-size:0.65rem;">{{ auth()->user()->email }}</small>
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
            <small class="text-muted d-block mb-2 text-center" style="font-size:0.75rem;">Akses Akun Testing:</small>
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill w-50">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill w-50">Daftar</a>
            </div>
        </div>
        @endauth
    </div>
</nav>

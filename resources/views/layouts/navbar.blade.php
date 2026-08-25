<nav class="navbar navbar-expand-lg navbar-modern">
    <div class="container-fluid">
        <!-- Sidebar Toggle Button (Mobile/Tablet) -->
        <button type="button" id="sidebarCollapse" class="btn btn-light d-lg-none me-3">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Breadcrumb / Page Title -->
        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active text-main fw-semibold" aria-current="page">@yield('title', 'Dashboard')</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center ms-auto">
            @auth
                @php
                    $appNotifications = \App\Services\NotificationService::getForUser(auth()->user());
                    $unreadCount = $appNotifications->count();
                @endphp

                <!-- Notifications -->
                <div class="dropdown me-3">
                    <button class="btn btn-light position-relative border-0 rounded-circle shadow-xs d-flex align-items-center justify-content-center" 
                            type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" 
                            style="width: 42px; height: 42px; background: #F8FAFC;">
                        <i class="fa-regular fa-bell text-secondary fs-5"></i>
                        @if($unreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-2 border-white" style="font-size: 0.65rem; padding: 0.35em 0.55em;">
                            {{ $unreadCount }}
                        </span>
                        @endif
                    </button>
                    
                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-0 mt-2 overflow-hidden" 
                         aria-labelledby="notificationDropdown" style="width: 360px; max-width: 90vw; border: 1px solid #E2E8F0 !important;">
                        
                        {{-- Header --}}
                        <div class="p-3 bg-light border-bottom d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="fw-bold text-dark mb-0 fs-6">Notifikasi</h6>
                                @if($unreadCount > 0)
                                <span class="badge bg-primary text-white rounded-pill px-2 py-0.5" style="font-size: 0.7rem;">
                                    {{ $unreadCount }} Terbaru
                                </span>
                                @endif
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                @if(auth()->user()->isAdmin())
                                    Panel Admin
                                @elseif(auth()->user()->isTeacher())
                                    Ruang Pengajar
                                @else
                                    Ruang Pelajar
                                @endif
                            </small>
                        </div>

                        {{-- List Notifikasi --}}
                        <div class="overflow-auto custom-scroll" style="max-height: 380px;">
                            @forelse($appNotifications as $notif)
                            <a href="{{ $notif['url'] }}" class="dropdown-item p-3 border-bottom d-flex align-items-start gap-3 text-wrap" style="transition: background .15s ease;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                                     style="width: 38px; height: 38px; background: {{ $notif['icon_bg'] }}; font-size: 1rem;">
                                    <i class="{{ $notif['icon'] }}"></i>
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex align-items-center justify-content-between gap-1 mb-1">
                                        <span class="fw-bold text-dark" style="font-size: 0.86rem;">{{ $notif['title'] }}</span>
                                        <span class="badge {{ $notif['badge_class'] }} rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">
                                            {{ $notif['badge'] }}
                                        </span>
                                    </div>
                                    <p class="text-muted mb-1" style="font-size: 0.8rem; line-height: 1.35;">{{ $notif['message'] }}</p>
                                    <small class="text-muted d-flex align-items-center gap-1" style="font-size: 0.72rem;">
                                        <i class="fa-regular fa-clock text-muted"></i> {{ $notif['time'] }}
                                    </small>
                                </div>
                            </a>
                            @empty
                            <div class="p-4 text-center text-muted">
                                <div class="rounded-circle bg-light d-inline-flex p-3 mb-2 text-secondary opacity-50">
                                    <i class="fa-regular fa-bell-slash fs-4"></i>
                                </div>
                                <div class="fw-bold text-dark small">Tidak ada notifikasi baru</div>
                                <small class="text-muted">Aktivitas pembelajaran dan pembaruan akan tampil di sini.</small>
                            </div>
                            @endforelse
                        </div>

                        {{-- Footer --}}
                        <div class="p-2.5 bg-light border-top text-center">
                            <a href="{{ route('calendar.index') }}" class="btn btn-link btn-sm text-primary fw-bold text-decoration-none py-1" style="font-size: 0.82rem;">
                                <i class="fa-solid fa-calendar-days me-1"></i> Buka Kalender Agenda Pembelajaran
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User Dropdown (Mobile visible) -->
                <div class="dropdown d-lg-none">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownMobileUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=C9A66B&color=fff" alt="User" width="35" height="35" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow rounded-4 border-0" aria-labelledby="dropdownMobileUser">
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
                </div>
            @endauth
        </div>
    </div>
</nav>

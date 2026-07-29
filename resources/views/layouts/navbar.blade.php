<nav class="navbar navbar-expand-lg navbar-modern">
    <div class="container-fluid">
        <!-- Sidebar Toggle Button (Mobile/Tablet) -->
        <button type="button" id="sidebarCollapse" class="btn btn-light d-lg-none me-3">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Breadcrumb / Page Title -->
        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active text-main fw-semibold" aria-current="page">@yield('title', 'Dashboard')</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center ms-auto">
            


            <!-- Notifications -->
            <div class="dropdown me-3">
                <button class="btn btn-light position-relative border-0 rounded-circle" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px;">
                    <i class="fa-regular fa-bell text-muted"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 p-2 mt-2" aria-labelledby="notificationDropdown" style="width: 300px;">
                    <li><h6 class="dropdown-header fw-bold text-main">Notifikasi</h6></li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-start rounded-3" href="#">
                            <div class="icon-box bg-soft-blue text-primary rounded-circle p-2 me-3">
                                <i class="fa-solid fa-book"></i>
                            </div>
                            <div>
                                <p class="mb-0 fw-semibold text-main" style="font-size: 0.9rem;">Materi Baru: Aksara Jawa</p>
                                <small class="text-muted">Ditambahkan oleh Pak Guru 2 jam lalu</small>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-start rounded-3" href="#">
                            <div class="icon-box bg-secondary text-accent rounded-circle p-2 me-3">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div>
                                <p class="mb-0 fw-semibold text-main" style="font-size: 0.9rem;">Nilai Quiz Keluar</p>
                                <small class="text-muted">Kamu dapat 90 di Quiz Unggah-Ungguh!</small>
                            </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-center text-primary fw-semibold" href="#" style="font-size: 0.9rem;">Lihat Semua</a></li>
                </ul>
            </div>

            <!-- User Dropdown (Mobile visible, Desktop managed in sidebar but good to have here too as alternative) -->
            <div class="dropdown d-lg-none">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownMobileUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name=Siswa+SD&background=C9A66B&color=fff" alt="User" width="35" height="35" class="rounded-circle">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMobileUser">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                </ul>
            </div>
            
        </div>
    </div>
</nav>

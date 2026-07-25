@extends('layouts.app')

@section('title', 'Manajemen Ruang Kelas')

@section('content')
<!-- Header Kelas -->
<div class="card card-modern border-0 overflow-hidden mb-4 animate__animated animate__fadeInDown">
    <div class="bg-primary p-5 position-relative text-white" style="border-radius: var(--radius-md);">
        <i class="fa-solid fa-graduation-cap position-absolute opacity-25" style="font-size: 15rem; right: 5%; bottom: -50px;"></i>
        <div class="position-relative z-2">
            <h1 class="fw-bold display-5 mb-2">Bahasa Jawa - Kelas 5A</h1>
            <p class="fs-5 mb-0 text-white-50">Tahun Ajaran 2026/2027</p>
            <div class="mt-4">
                <span class="badge bg-white text-primary rounded-pill px-3 py-2 fs-6 shadow-sm">
                    Kode Kelas: <strong class="ms-1" style="letter-spacing: 2px;">JW5A-26</strong>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Navigasi Tab Modern -->
<ul class="nav nav-pills mb-4 gap-2 animate__animated animate__fadeInUp" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-pill px-4 fw-semibold" id="pills-stream-tab" data-bs-toggle="pill" data-bs-target="#pills-stream" type="button" role="tab" aria-selected="true"><i class="fa-solid fa-comment-dots me-2"></i> Stream</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill px-4 fw-semibold" id="pills-classwork-tab" data-bs-toggle="pill" data-bs-target="#pills-classwork" type="button" role="tab" aria-selected="false"><i class="fa-solid fa-book-open me-2"></i> Tugas Kelas</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill px-4 fw-semibold" id="pills-people-tab" data-bs-toggle="pill" data-bs-target="#pills-people" type="button" role="tab" aria-selected="false"><i class="fa-solid fa-users me-2"></i> Anggota</button>
    </li>
</ul>

<!-- Konten Tabs -->
<div class="tab-content animate__animated animate__fadeInUp" id="pills-tabContent">
    
    <!-- STREAM TAB -->
    <div class="tab-pane fade show active" id="pills-stream" role="tabpanel" aria-labelledby="pills-stream-tab">
        <div class="row g-4">
            <!-- Form Pengumuman -->
            <div class="col-lg-8">
                <div class="card card-modern p-4 mb-4 shadow-sm gamified border-0">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=Pak+Guru" class="rounded-circle me-3" width="40">
                        <textarea class="form-control bg-light border-0 rounded-4 p-3" rows="2" placeholder="Umumkan sesuatu ke kelas ini..."></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button class="btn btn-light rounded-circle text-muted me-2" title="Attach File"><i class="fa-solid fa-paperclip"></i></button>
                            <button class="btn btn-light rounded-circle text-muted" title="Upload Video"><i class="fa-solid fa-video"></i></button>
                        </div>
                        <button class="btn btn-primary rounded-pill px-4 btn-bouncy">Posting</button>
                    </div>
                </div>

                <!-- Feed Pengumuman -->
                <div class="card card-modern p-4 mb-3 border-0">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 45px; height: 45px;">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-main mb-0">Pak Guru memposting tugas baru: Mengarang Bebas</h6>
                                <small class="text-muted">Kemarin, 08:30 AM</small>
                            </div>
                        </div>
                        <button class="btn btn-light btn-sm rounded-circle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    </div>
                    <div class="bg-soft-blue p-3 rounded-4 cursor-pointer btn-bouncy d-block text-decoration-none">
                        <h6 class="fw-semibold text-primary mb-1">Tugas: Mengarang Bebas menggunakan Aksara Jawa</h6>
                        <span class="text-muted small">Tenggat Waktu: 28 Juli 2026</span>
                    </div>
                    <!-- Area Komentar -->
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted fw-semibold mb-2 d-block">1 Komentar Kelas</small>
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=Budi" class="rounded-circle me-3" width="30">
                            <div class="bg-light p-2 px-3 rounded-4 w-100">
                                <small class="fw-bold d-block text-main">Budi Santoso</small>
                                <small class="text-muted">Pak, apakah boleh diketik lalu di-PDF kan?</small>
                            </div>
                        </div>
                        <div class="d-flex mt-3 align-items-center">
                            <img src="https://ui-avatars.com/api/?name=Pak+Guru" class="rounded-circle me-3" width="30">
                            <input type="text" class="form-control rounded-pill border-0 bg-light" placeholder="Tambahkan komentar kelas...">
                            <button class="btn btn-light text-primary rounded-circle ms-2"><i class="fa-solid fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card card-modern p-4 mb-4 border-0">
                    <h6 class="fw-bold text-main mb-3">Mendatang</h6>
                    <p class="text-muted small">Hore, tidak ada tugas yang perlu segera dinilai!</p>
                    <a href="#" class="fw-semibold small text-primary text-decoration-none">Lihat Semua Tugas</a>
                </div>
            </div>
        </div>
    </div>

    <!-- CLASSWORK TAB -->
    <div class="tab-pane fade" id="pills-classwork" role="tabpanel" aria-labelledby="pills-classwork-tab">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <button class="btn btn-primary rounded-pill px-4 btn-bouncy shadow-sm">
                <i class="fa-solid fa-plus me-2"></i> Buat Topik / Tugas
            </button>
        </div>
        
        <h4 class="fw-bold text-main text-primary border-bottom pb-2 mb-3">Topik 1: Unggah-Ungguh Basa</h4>
        
        <div class="list-group list-group-flush mb-5">
            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 rounded-4 mb-2 bg-white shadow-sm btn-bouncy" style="transition: all 0.2s;">
                <div class="bg-soft-blue text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fa-solid fa-book"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-0 fw-bold text-main">Materi: Ngoko Lugu lan Alus</h6>
                    <small class="text-muted">Diposting 22 Jul</small>
                </div>
                <button class="btn btn-light rounded-circle text-muted"><i class="fa-solid fa-ellipsis-vertical"></i></button>
            </a>
            
            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 rounded-4 mb-2 bg-white shadow-sm btn-bouncy" style="transition: all 0.2s;">
                <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-0 fw-bold text-main">Tugas: Mengarang Bebas</h6>
                    <small class="text-danger fw-semibold">Tenggat Waktu: 28 Jul, 23:59</small>
                </div>
                <div class="text-end me-3 d-none d-sm-block">
                    <h5 class="fw-bold text-main mb-0">12 / 32</h5>
                    <small class="text-muted">Telah Menyerahkan</small>
                </div>
                <button class="btn btn-light rounded-circle text-muted"><i class="fa-solid fa-ellipsis-vertical"></i></button>
            </a>
        </div>
    </div>

    <!-- PEOPLE TAB -->
    <div class="tab-pane fade" id="pills-people" role="tabpanel" aria-labelledby="pills-people-tab">
        <!-- Pengajar -->
        <div class="d-flex justify-content-between align-items-center border-bottom border-primary pb-2 mb-3">
            <h4 class="fw-bold text-primary m-0">Pengajar & Admin Kelas</h4>
            <button class="btn btn-light rounded-circle text-primary shadow-sm"><i class="fa-solid fa-user-plus"></i></button>
        </div>
        <div class="d-flex align-items-center mb-5 p-3 rounded-4 bg-white shadow-sm">
            <img src="https://ui-avatars.com/api/?name=Pak+Guru" class="rounded-circle me-3" width="45">
            <h6 class="fw-bold text-main m-0">Pak Guru (Anda)</h6>
        </div>

        <!-- Siswa -->
        <div class="d-flex justify-content-between align-items-center border-bottom border-primary pb-2 mb-3">
            <h4 class="fw-bold text-primary m-0">Siswa</h4>
            <div class="d-flex align-items-center">
                <span class="text-muted fw-semibold me-3">32 Siswa</span>
                <button class="btn btn-light rounded-circle text-primary shadow-sm"><i class="fa-solid fa-user-plus"></i></button>
            </div>
        </div>
        <div class="bg-white rounded-4 shadow-sm">
            <ul class="list-group list-group-flush rounded-4">
                <li class="list-group-item d-flex align-items-center justify-content-between py-3 border-0">
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=Agus+Setiawan" class="rounded-circle me-3" width="40">
                        <h6 class="fw-semibold text-main m-0">Agus Setiawan</h6>
                    </div>
                    <button class="btn btn-light btn-sm rounded-circle text-muted"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between py-3 border-0 border-top">
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso" class="rounded-circle me-3" width="40">
                        <h6 class="fw-semibold text-main m-0">Budi Santoso</h6>
                    </div>
                    <button class="btn btn-light btn-sm rounded-circle text-muted"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

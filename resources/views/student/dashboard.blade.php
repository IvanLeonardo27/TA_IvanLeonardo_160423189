@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="row mb-4 align-items-center animate__animated animate__fadeInDown">
    <div class="col-md-8 d-flex align-items-center">
        <!-- Lottie Mascot -->
        <div class="me-3 animate-float d-none d-sm-block" style="width: 100px; height: 100px;">
            <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_jcikwtux.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
        </div>
        <div>
            <h3 class="fw-bold text-main mb-1">Sugeng Enjing, Budi! <i class="fa-solid fa-hand-wave text-warning ms-2"></i></h3>
            <p class="text-muted">Ayo terusake sinau basa Jawa dina iki.</p>
        </div>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <span class="badge bg-soft-blue text-primary p-2 px-3 rounded-pill fw-semibold shadow-sm animate-pulse-glow">
            <i class="fa-solid fa-fire text-danger me-1"></i> 5 Hari Beruntun!
        </span>
    </div>
</div>

<!-- Statistic Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4 animate__animated animate__zoomIn" style="animation-delay: 0.1s;">
        <div class="card card-modern gamified p-4 text-center h-100">
            <div class="d-inline-block bg-soft-blue text-primary rounded-circle p-3 mb-3 mx-auto" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-book-open fs-4"></i>
            </div>
            <h5 class="fw-bold text-main mb-1">12</h5>
            <p class="text-muted mb-0 small">Materi Selesai</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-modern p-4 text-center h-100">
            <div class="d-inline-block bg-secondary text-accent rounded-circle p-3 mb-3 mx-auto" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-star fs-4"></i>
            </div>
            <h5 class="fw-bold text-main mb-1">85</h5>
            <p class="text-muted mb-0 small">Rata-rata Nilai Quiz</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-modern p-4 text-center h-100">
            <div class="d-inline-block bg-primary text-white rounded-circle p-3 mb-3 mx-auto" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-book-journal-whills fs-4"></i>
            </div>
            <h5 class="fw-bold text-main mb-1">45</h5>
            <p class="text-muted mb-0 small">Kosakata Dipelajari</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Progress Belajar Saat Ini -->
    <div class="col-lg-8 animate__animated animate__fadeInLeft" style="animation-delay: 0.4s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-main m-0">Lanjutkan Belajar</h5>
            <a href="#" class="text-primary fw-semibold text-decoration-none small btn-bouncy d-inline-block">Lihat Semua Materi <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>
        
        <div class="card card-modern gamified p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="bg-secondary rounded-4 d-flex align-items-center justify-content-center" style="height: 120px;">
                        <i class="fa-solid fa-video text-accent" style="font-size: 3rem;"></i>
                    </div>
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <span class="badge bg-soft-blue text-primary mb-2 rounded-pill">Unggah-Ungguh Basa</span>
                    <h5 class="fw-bold text-main">Ngoko Lugu lan Ngoko Alus</h5>
                    <p class="text-muted small mb-3">Memahami perbedaan dan penggunaan Ngoko Lugu dan Ngoko Alus dalam kehidupan sehari-hari.</p>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small class="text-muted fw-semibold">60% Selesai</small>
                        <small class="text-muted">3 dari 5 Section</small>
                    </div>
                </div>
                <div class="col-md-3 text-md-end">
                    <button class="btn btn-primary rounded-4 w-100 btn-bouncy py-3">Lanjutkan <i class="fa-solid fa-play ms-1"></i></button>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
            <h5 class="fw-bold text-main m-0">Kosakata Terbaru</h5>
            <a href="#" class="text-primary fw-semibold text-decoration-none small">Ke Kamus <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card card-modern p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="fw-bold text-main mb-0">Mangan</h5>
                            <small class="text-muted d-block mb-2">Ngoko Lugu</small>
                            <span class="text-primary fw-semibold">Makan</span>
                        </div>
                        <button class="btn btn-light rounded-circle text-accent shadow-sm" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-volume-high"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-modern p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="fw-bold text-main mb-0">Dahar</h5>
                            <small class="text-muted d-block mb-2">Krama Inggil</small>
                            <span class="text-primary fw-semibold">Makan</span>
                        </div>
                        <button class="btn btn-light rounded-circle text-accent shadow-sm" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-volume-high"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Right (Jadwal & Quiz) -->
    <div class="col-lg-4 animate__animated animate__fadeInRight" style="animation-delay: 0.5s;">
        <div class="card card-modern gamified p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold text-main m-0">Quiz Mendatang</h6>
            </div>
            
            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                <div class="bg-soft-blue text-primary rounded-3 p-2 me-3 text-center" style="min-width: 55px;">
                    <small class="d-block fw-bold" style="font-size: 0.7rem;">OKT</small>
                    <span class="fs-5 fw-bold">12</span>
                </div>
                <div>
                    <h6 class="fw-bold text-main mb-1" style="font-size: 0.95rem;">Quiz Aksara Jawa Dasar</h6>
                    <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> 08:00 - 09:30</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="bg-secondary text-accent rounded-3 p-2 me-3 text-center" style="min-width: 55px;">
                    <small class="d-block fw-bold" style="font-size: 0.7rem;">OKT</small>
                    <span class="fs-5 fw-bold">15</span>
                </div>
                <div>
                    <h6 class="fw-bold text-main mb-1" style="font-size: 0.95rem;">Ujian Unggah-Ungguh</h6>
                    <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> 10:00 - 11:30</small>
                </div>
            </div>
            
            <button class="btn btn-outline-primary w-100 mt-4 rounded-4 fw-semibold btn-bouncy">Lihat Kalender Penuh</button>
        </div>

        <div class="card card-modern gamified p-4">
            <h6 class="fw-bold text-main mb-3">Aktivitas Terakhir</h6>
            <ul class="list-unstyled m-0">
                <li class="mb-3 d-flex align-items-start">
                    <span class="text-primary me-3 mt-1"><i class="fa-solid fa-circle-check"></i></span>
                    <div>
                        <p class="mb-0 fw-semibold" style="font-size: 0.9rem;">Menyelesaikan Section 2</p>
                        <small class="text-muted">Materi: Aksara Swara</small>
                    </div>
                </li>
                <li class="d-flex align-items-start">
                    <span class="text-accent me-3 mt-1"><i class="fa-solid fa-bookmark"></i></span>
                    <div>
                        <p class="mb-0 fw-semibold" style="font-size: 0.9rem;">Menyimpan Kosakata Baru</p>
                        <small class="text-muted">"Sare", "Mlampah"</small>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

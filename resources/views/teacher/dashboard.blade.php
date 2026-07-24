@extends('layouts.app')

@section('title', 'Dashboard Pengajar')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h3 class="fw-bold text-main mb-1">Sugeng Rawuh, Pak Guru! <i class="fa-solid fa-chalkboard-user text-primary ms-2"></i></h3>
        <p class="text-muted">Pantau perkembangan belajar siswa dan kelola materi dengan mudah.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <button class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Tambah Materi Baru
        </button>
    </div>
</div>

<!-- Statistic Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-modern p-4 d-flex flex-row align-items-center h-100">
            <div class="bg-soft-blue text-primary rounded-3 p-3 me-3">
                <i class="fa-solid fa-users fs-4"></i>
            </div>
            <div>
                <p class="text-muted mb-0 small fw-semibold">Total Siswa</p>
                <h4 class="fw-bold text-main mb-0">124</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-modern p-4 d-flex flex-row align-items-center h-100">
            <div class="bg-secondary text-accent rounded-3 p-3 me-3">
                <i class="fa-solid fa-book-open fs-4"></i>
            </div>
            <div>
                <p class="text-muted mb-0 small fw-semibold">Total Materi</p>
                <h4 class="fw-bold text-main mb-0">32</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-modern p-4 d-flex flex-row align-items-center h-100">
            <div class="bg-primary text-white rounded-3 p-3 me-3">
                <i class="fa-solid fa-clipboard-question fs-4"></i>
            </div>
            <div>
                <p class="text-muted mb-0 small fw-semibold">Total Quiz</p>
                <h4 class="fw-bold text-main mb-0">15</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-modern p-4 d-flex flex-row align-items-center h-100 border-start border-4 border-warning">
            <div>
                <p class="text-muted mb-0 small fw-semibold">Rata-rata Nilai Kelas</p>
                <h3 class="fw-bold text-main mb-0">78.5</h3>
                <small class="text-success"><i class="fa-solid fa-arrow-trend-up me-1"></i> +2.5% dari bulan lalu</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-modern p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-main m-0">Aktivitas Siswa Terbaru</h5>
                <a href="#" class="text-primary fw-semibold text-decoration-none small">Lihat Detail</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border-bottom">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="fw-semibold">Nama Siswa</th>
                            <th class="fw-semibold">Aktivitas</th>
                            <th class="fw-semibold">Materi/Quiz</th>
                            <th class="fw-semibold text-end">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Budi&background=random" class="rounded-circle me-2" width="30">
                                    <span class="fw-semibold">Budi Santoso</span>
                                </div>
                            </td>
                            <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Selesai Quiz</span></td>
                            <td>Unggah-Ungguh Basa</td>
                            <td class="text-end text-muted small">10 menit lalu</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Siti&background=random" class="rounded-circle me-2" width="30">
                                    <span class="fw-semibold">Siti Aminah</span>
                                </div>
                            </td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Mulai Belajar</span></td>
                            <td>Aksara Jawa Dasar</td>
                            <td class="text-end text-muted small">1 jam lalu</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Agus&background=random" class="rounded-circle me-2" width="30">
                                    <span class="fw-semibold">Agus Setiawan</span>
                                </div>
                            </td>
                            <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Gagal Quiz</span></td>
                            <td>Kosakata Krama Alus</td>
                            <td class="text-end text-muted small">2 jam lalu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Kalender Mini -->
        <div class="card card-modern p-4 mb-4">
            <h6 class="fw-bold text-main mb-3 d-flex justify-content-between align-items-center">
                Kalender Akademik
                <i class="fa-brands fa-google text-muted"></i>
            </h6>
            <!-- Integrasi Google Calendar Placeholder -->
            <div class="bg-light rounded-4 d-flex flex-column align-items-center justify-content-center border" style="height: 200px;">
                <i class="fa-regular fa-calendar-days text-muted mb-2" style="font-size: 2.5rem;"></i>
                <p class="text-muted small m-0 text-center px-3">Integrasi Google Calendar API<br>menampilkan jadwal kelas.</p>
            </div>
            
            <div class="mt-3">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-primary rounded-circle p-1 me-2" style="width: 10px; height: 10px;"><span class="visually-hidden">dot</span></span>
                    <small class="fw-semibold">Pertemuan Tatap Muka - Besok, 08:00</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

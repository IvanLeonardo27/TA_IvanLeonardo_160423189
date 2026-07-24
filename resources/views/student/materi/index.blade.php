@extends('layouts.app')

@section('title', 'Daftar Materi')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h3 class="fw-bold text-main mb-1">Daftar Materi Basa Jawa</h3>
        <p class="text-muted">Pilih materi yang ingin kamu pelajari hari ini.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <div class="btn-group shadow-sm rounded-4" role="group">
            <button type="button" class="btn btn-primary px-4">Semua</button>
            <button type="button" class="btn btn-light text-muted px-4">Belum Mulai</button>
            <button type="button" class="btn btn-light text-muted px-4">Selesai</button>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Card Materi 1 -->
    <div class="col-lg-4 col-md-6">
        <div class="card card-modern h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 z-3">
                <button class="btn btn-light rounded-circle shadow-sm text-accent" style="width: 40px; height: 40px;">
                    <i class="fa-regular fa-bookmark"></i>
                </button>
            </div>
            
            <div class="bg-primary d-flex align-items-center justify-content-center" style="height: 180px; position: relative;">
                <i class="fa-solid fa-users text-white opacity-25" style="font-size: 6rem; position: absolute; right: -20px; bottom: -20px;"></i>
                <h2 class="text-white fw-bold mb-0 z-2 position-relative">Aksara Jawa</h2>
            </div>
            
            <div class="card-body p-4">
                <span class="badge bg-soft-blue text-primary rounded-pill mb-2 px-3">Menulis & Membaca</span>
                <h5 class="fw-bold text-main">Aksara Jawa Dasar (Carakan)</h5>
                <p class="text-muted small mb-3">Belajar mengenal, membaca, dan menulis 20 aksara dasar bahasa Jawa.</p>
                
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name=Pak+Guru" class="rounded-circle me-2" width="24">
                    <small class="text-muted fw-semibold">Oleh: Pak Sudarso</small>
                </div>
                
                <div class="d-flex justify-content-between text-muted small mb-3">
                    <span><i class="fa-regular fa-clock me-1"></i> 45 Menit</span>
                    <span><i class="fa-solid fa-list me-1"></i> 4 Section</span>
                </div>
                
                <div class="progress mb-2" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-success fw-bold d-block text-end mb-4">100% Selesai</small>
                
                <button class="btn btn-outline-primary w-100 rounded-4">Ulangi Materi</button>
            </div>
        </div>
    </div>
    
    <!-- Card Materi 2 -->
    <div class="col-lg-4 col-md-6">
        <div class="card card-modern h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 z-3">
                <button class="btn btn-light rounded-circle shadow-sm text-accent" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-bookmark"></i>
                </button>
            </div>
            
            <div class="bg-accent d-flex align-items-center justify-content-center" style="height: 180px; position: relative;">
                <i class="fa-solid fa-people-arrows text-white opacity-25" style="font-size: 6rem; position: absolute; right: -20px; bottom: -20px;"></i>
                <h2 class="text-white fw-bold mb-0 z-2 position-relative">Unggah-Ungguh</h2>
            </div>
            
            <div class="card-body p-4">
                <span class="badge bg-soft-blue text-primary rounded-pill mb-2 px-3">Tata Krama</span>
                <h5 class="fw-bold text-main">Ngoko Lugu lan Ngoko Alus</h5>
                <p class="text-muted small mb-3">Memahami perbedaan dan penggunaan tingkatan bahasa dalam keseharian.</p>
                
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name=Bu+Guru" class="rounded-circle me-2" width="24">
                    <small class="text-muted fw-semibold">Oleh: Bu Retno</small>
                </div>
                
                <div class="d-flex justify-content-between text-muted small mb-3">
                    <span><i class="fa-regular fa-clock me-1"></i> 60 Menit</span>
                    <span><i class="fa-solid fa-list me-1"></i> 5 Section</span>
                </div>
                
                <div class="progress mb-2" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-primary fw-bold d-block text-end mb-4">60% Selesai</small>
                
                <button class="btn btn-primary w-100 rounded-4">Lanjutkan Belajar <i class="fa-solid fa-arrow-right ms-2"></i></button>
            </div>
        </div>
    </div>
    
    <!-- Card Materi 3 -->
    <div class="col-lg-4 col-md-6">
        <div class="card card-modern h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 z-3">
                <button class="btn btn-light rounded-circle shadow-sm text-accent" style="width: 40px; height: 40px;">
                    <i class="fa-regular fa-bookmark"></i>
                </button>
            </div>
            
            <div class="bg-secondary d-flex align-items-center justify-content-center border-bottom" style="height: 180px; position: relative;">
                <i class="fa-solid fa-music text-accent opacity-25" style="font-size: 6rem; position: absolute; right: -20px; bottom: -20px;"></i>
                <h2 class="text-primary fw-bold mb-0 z-2 position-relative">Tembang Macapat</h2>
            </div>
            
            <div class="card-body p-4">
                <span class="badge bg-soft-blue text-primary rounded-pill mb-2 px-3">Sastra</span>
                <h5 class="fw-bold text-main">Mengenal Tembang Pocung</h5>
                <p class="text-muted small mb-3">Belajar menyanyikan dan memaknai lirik dari Tembang Macapat Pocung.</p>
                
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name=Pak+Guru" class="rounded-circle me-2" width="24">
                    <small class="text-muted fw-semibold">Oleh: Pak Sudarso</small>
                </div>
                
                <div class="d-flex justify-content-between text-muted small mb-3">
                    <span><i class="fa-regular fa-clock me-1"></i> 30 Menit</span>
                    <span><i class="fa-solid fa-list me-1"></i> 3 Section</span>
                </div>
                
                <div class="progress mb-2" style="height: 8px;">
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted fw-bold d-block text-end mb-4">Belum Dimulai</small>
                
                <button class="btn btn-outline-primary w-100 rounded-4">Mulai Belajar</button>
            </div>
        </div>
    </div>
</div>
@endsection

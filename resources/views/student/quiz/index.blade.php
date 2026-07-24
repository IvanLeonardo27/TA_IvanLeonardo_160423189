@extends('layouts.app')

@section('title', 'Daftar Quiz')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h3 class="fw-bold text-main mb-1">Evaluasi & Quiz</h3>
        <p class="text-muted">Uji pemahamanmu tentang materi bahasa Jawa.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Quiz Card 1 (Active) -->
    <div class="col-lg-6">
        <div class="card card-modern p-4 border-start border-4 border-primary h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="badge bg-soft-blue text-primary rounded-pill mb-2 px-3">Tersedia</span>
                    <h5 class="fw-bold text-main">Quiz Unggah-Ungguh Basa</h5>
                    <p class="text-muted small">Evaluasi materi Ngoko Lugu dan Ngoko Alus.</p>
                </div>
                <div class="bg-light rounded-circle p-3 text-primary">
                    <i class="fa-solid fa-clipboard-question fs-4"></i>
                </div>
            </div>
            
            <div class="d-flex gap-4 mb-4">
                <div class="text-muted small">
                    <i class="fa-solid fa-list me-1"></i> 10 Soal
                </div>
                <div class="text-muted small">
                    <i class="fa-regular fa-clock me-1"></i> 15 Menit
                </div>
                <div class="text-muted small">
                    <i class="fa-solid fa-star text-warning me-1"></i> KKM: 75
                </div>
            </div>
            
            <button class="btn btn-primary w-100 rounded-4">Mulai Quiz <i class="fa-solid fa-play ms-1"></i></button>
        </div>
    </div>
    
    <!-- Quiz Card 2 (Completed) -->
    <div class="col-lg-6">
        <div class="card card-modern p-4 border-start border-4 border-success h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill mb-2 px-3"><i class="fa-solid fa-check me-1"></i> Selesai</span>
                    <h5 class="fw-bold text-main">Quiz Aksara Jawa Dasar</h5>
                    <p class="text-muted small">Evaluasi pengenalan 20 aksara Jawa carakan.</p>
                </div>
                <div class="text-end">
                    <h3 class="fw-bold text-success m-0">90</h3>
                    <small class="text-muted">Nilai</small>
                </div>
            </div>
            
            <div class="d-flex gap-4 mb-4">
                <div class="text-muted small">
                    <i class="fa-solid fa-calendar-check me-1"></i> Dikerjakan: 12 Okt 2026
                </div>
            </div>
            
            <button class="btn btn-outline-success w-100 rounded-4">Lihat Hasil & Pembahasan</button>
        </div>
    </div>
    
    <!-- Quiz Card 3 (Locked) -->
    <div class="col-lg-6">
        <div class="card card-modern p-4 bg-light h-100" style="opacity: 0.8;">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="badge bg-secondary text-muted rounded-pill mb-2 px-3"><i class="fa-solid fa-lock me-1"></i> Terkunci</span>
                    <h5 class="fw-bold text-muted">Quiz Tembang Macapat</h5>
                    <p class="text-muted small">Selesaikan materi Tembang Macapat terlebih dahulu.</p>
                </div>
                <div class="bg-white rounded-circle p-3 text-muted border">
                    <i class="fa-solid fa-lock fs-4"></i>
                </div>
            </div>
            <button class="btn btn-secondary w-100 rounded-4 mt-auto" disabled>Mulai Quiz</button>
        </div>
    </div>
</div>
@endsection

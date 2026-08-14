@extends('layouts.app')

@section('title', 'Tembang ' . $category->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('student.macapat.index') }}" class="text-decoration-none text-muted fw-semibold">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Koleksi Macapat
    </a>
</div>

<!-- Header Banner -->
<div class="card card-modern border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="p-5 text-white text-center position-relative" style="background: linear-gradient(135deg, #1F4D3A 0%, #2b6c51 100%);">
        <span class="badge bg-white text-primary rounded-pill px-3 py-2 mb-3 shadow-sm">
            {{ $category->guru_gatra }} Gatra (Baris)
        </span>
        <h2 class="fw-bold mb-2">Tembang {{ $category->name }}</h2>
        @if($category->watak)
        <p class="mb-0 opacity-75 fst-italic">"{{ $category->watak }}"</p>
        @endif
    </div>

    <!-- Info Paugeran Grid -->
    <div class="card-body p-4 p-md-5">
        <h5 class="fw-bold text-main border-bottom pb-2 mb-4">Paugeran Tembang {{ $category->name }}</h5>
        
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-4 border text-center h-100">
                    <div class="avatar-sm bg-soft-blue text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-bars-staggered fs-5"></i>
                    </div>
                    <h6 class="text-muted fw-semibold mb-1">Guru Gatra</h6>
                    <h4 class="fw-bold text-primary mb-1">{{ $category->guru_gatra }} Gatra</h4>
                    <small class="text-muted">Cacahing gatra/larik saben sapada (jumlah baris per bait)</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-light rounded-4 border text-center h-100">
                    <div class="avatar-sm bg-soft-blue text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-calculator fs-5"></i>
                    </div>
                    <h6 class="text-muted fw-semibold mb-1">Guru Wilangan</h6>
                    <h4 class="fw-bold text-primary mb-1">{{ $category->guru_wilangan }}</h4>
                    <small class="text-muted">Cacahing wanda saben sagatra (jumlah suku kata tiap baris)</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-light rounded-4 border text-center h-100">
                    <div class="avatar-sm bg-soft-blue text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-font fs-5"></i>
                    </div>
                    <h6 class="text-muted fw-semibold mb-1">Guru Lagu</h6>
                    <h4 class="fw-bold text-primary mb-1">{{ $category->guru_lagu }}</h4>
                    <small class="text-muted">Tibaning swara ing pungkasaning gatra (vokal akhir tiap baris)</small>
                </div>
            </div>
        </div>

        @if($category->description)
        <div class="p-4 bg-light rounded-4 border mb-5">
            <h6 class="fw-bold text-primary mb-2"><i class="fa-solid fa-book-open me-2"></i> Filosofi & Makna:</h6>
            <p class="mb-0 text-muted" style="line-height: 1.8;">{{ $category->description }}</p>
        </div>
        @endif

        <!-- Daftar Cakepan / Bait -->
        <h5 class="fw-bold text-main border-bottom pb-2 mb-4">Cakepan & Lirik Tembang</h5>

        <div class="row g-4">
            @forelse($category->details as $index => $detail)
            <div class="col-lg-6">
                <div class="card border rounded-4 shadow-sm h-100 overflow-hidden">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center py-3 px-4">
                        <span class="badge bg-primary rounded-pill px-3 py-2">Bait ke-{{ $index + 1 }}</span>
                        @if($detail->audio_path)
                        <span class="text-success small fw-semibold"><i class="fa-solid fa-volume-high me-1"></i> Tersedia Audio</span>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <!-- Lirik Teks Jawa -->
                        <div class="p-3 bg-light rounded-3 text-center mb-3">
                            <p class="mb-0 fw-bold text-dark" style="white-space: pre-line; font-family: 'Georgia', serif; line-height: 2; font-size: 1.1rem;">
                                {{ $detail->verse }}
                            </p>
                        </div>

                        <!-- Makna Bahasa Indonesia -->
                        @if($detail->meaning)
                        <div class="mb-3">
                            <small class="fw-bold text-muted d-block mb-1"><i class="fa-solid fa-language me-1"></i> Terjemahan / Makna:</small>
                            <p class="mb-0 text-muted small" style="white-space: pre-line; line-height: 1.6;">
                                {{ $detail->meaning }}
                            </p>
                        </div>
                        @endif

                        <!-- Audio Player -->
                        @if($detail->audio_path)
                        <div class="pt-3 border-top mt-3">
                            <small class="fw-bold text-muted d-block mb-2"><i class="fa-solid fa-headphones me-1"></i> Dengarkan Pelafalan:</small>
                            <audio controls class="w-100 rounded-pill shadow-sm" style="height: 38px;">
                                <source src="{{ asset('storage/' . $detail->audio_path) }}">
                                Browser Anda tidak mendukung audio player.
                            </audio>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">
                <p>Belum ada bait/cakepan contoh yang ditambahkan untuk tembang ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Koleksi Tembang Macapat')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h3 class="fw-bold text-main mb-1">Koleksi Tembang Macapat <i class="fa-solid fa-music text-primary ms-2"></i></h3>
        <p class="text-muted">Pelajari 11 Tembang Macapat Jawa, aturan paugeran, filosofi watak, dan lantunan suaranya.</p>
    </div>
</div>

<div class="row g-4">
    @forelse($categories as $item)
    <div class="col-md-4 col-sm-6">
        <a href="{{ route('student.macapat.show', $item) }}" class="text-decoration-none text-dark">
            <div class="card card-modern h-100 border-0 shadow-sm rounded-4 hover-lift">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-soft-blue text-primary px-3 py-2 rounded-pill">
                            {{ $item->guru_gatra }} Gatra
                        </span>
                        <span class="badge bg-light text-muted border rounded-pill px-3 py-2">
                            {{ $item->details_count }} Bait
                        </span>
                    </div>

                    <h4 class="fw-bold text-primary mb-2">{{ $item->name }}</h4>
                    <p class="text-muted small flex-grow-1 mb-3">
                        {{ Str::limit($item->watak ?? $item->description ?? 'Tembang Macapat klasik warisan budaya Jawa.', 90) }}
                    </p>

                    <div class="p-3 bg-light rounded-3 mb-3">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Guru Wilangan:</span>
                            <strong class="text-dark">{{ $item->guru_wilangan }}</strong>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Guru Lagu:</span>
                            <strong class="text-dark">{{ $item->guru_lagu }}</strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between text-primary fw-semibold pt-2 border-top">
                        <small>Pelajari Tembang</small>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fa-solid fa-music fs-1 text-muted mb-3 opacity-50"></i>
        <h5 class="text-muted fw-bold">Belum ada tembang macapat</h5>
        <p class="text-muted">Materi tembang macapat akan segera ditambahkan oleh pengajar.</p>
    </div>
    @endforelse
</div>
@endsection

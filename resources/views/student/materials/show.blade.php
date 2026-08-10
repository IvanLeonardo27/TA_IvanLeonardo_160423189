@extends('layouts.app')

@section('title', $material->title)

@section('content')
<div class="mb-4">
    <a href="{{ route('student.materials.index') }}" class="text-decoration-none text-muted fw-semibold">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Katalog
    </a>
</div>

<div class="card card-modern border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="bg-primary text-white p-5 text-center position-relative" style="background: linear-gradient(135deg, #1F4D3A 0%, #2b6c51 100%);">
        <span class="badge bg-white text-primary rounded-pill px-3 py-2 mb-3 shadow-sm">
            {{ ucfirst(str_replace('_', ' ', $material->type)) }}
        </span>
        <h2 class="fw-bold mb-3">{{ $material->title }}</h2>
        <p class="mb-0 opacity-75">{{ $material->category->name ?? 'Kategori Umum' }} &bull; Oleh {{ $material->teacher->name ?? 'Pengajar' }}</p>
    </div>
    
    <div class="card-body p-4 p-md-5">
        @if($material->description)
        <div class="mb-5">
            <h5 class="fw-bold text-main border-bottom pb-2 mb-3">Deskripsi</h5>
            <p class="text-muted" style="line-height: 1.8;">{{ $material->description }}</p>
        </div>
        @endif

        @if($material->type === 'unggah_ungguh' && $material->unggahUngguhBasas->count() > 0)
            <h5 class="fw-bold text-main border-bottom pb-2 mb-4">Detail Unggah-Ungguh Basa</h5>
            @foreach($material->unggahUngguhBasas as $uub)
            <div class="bg-light rounded-4 p-4 mb-4 border">
                @if($uub->context_scenario)
                <div class="mb-3">
                    <span class="badge bg-secondary mb-2">Konteks / Skenario</span>
                    <p class="mb-0 fw-semibold">{{ $uub->context_scenario }}</p>
                </div>
                @endif
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-comments me-2"></i> Ngoko</h6>
                                <p class="mb-0 text-muted">{{ $uub->ngoko_text }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-bold text-success mb-3"><i class="fa-solid fa-comments me-2"></i> Krama</h6>
                                <p class="mb-0 text-muted">{{ $uub->krama_text }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-bold text-info mb-3"><i class="fa-solid fa-language me-2"></i> Terjemahan</h6>
                                <p class="mb-0 text-muted">{{ $uub->indonesian_text }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif

        @if($material->type === 'sastra_jawa' && $material->sastraJawas->count() > 0)
            <h5 class="fw-bold text-main border-bottom pb-2 mb-4">Detail Sastra Jawa</h5>
            @foreach($material->sastraJawas as $sastra)
            <div class="bg-light rounded-4 p-4 mb-4 border text-center">
                <h4 class="fw-bold text-primary mb-2">{{ $material->title }}</h4>
                <p class="text-muted small mb-4">
                    Karya: <strong>{{ $sastra->author ?? 'Anonim' }}</strong> | Genre: <span class="badge bg-secondary">{{ $sastra->genre }}</span>
                </p>
                <div class="d-inline-block text-start p-4 bg-white rounded-4 shadow-sm" style="min-width: 50%; max-width: 100%;">
                    <p class="mb-0 text-dark" style="white-space: pre-line; line-height: 2; font-size: 1.1rem; font-family: 'Georgia', serif;">
                        {{ $sastra->content }}
                    </p>
                </div>
            </div>
            @endforeach
        @endif

    </div>
</div>
@endsection

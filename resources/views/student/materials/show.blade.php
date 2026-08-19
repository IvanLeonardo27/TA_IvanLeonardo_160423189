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

        @if($material->attachments->count() > 0)
        <div>
            <h5 class="fw-bold text-main border-bottom pb-2 mb-4">Lampiran & Berkas</h5>
            <div class="row g-3">
                @foreach($material->attachments as $att)
                <div class="col-md-6">
                    <div class="d-flex align-items-center p-3 border rounded-4 bg-light">
                        <div class="me-3 fs-3 text-primary">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-bold text-truncate">{{ $att->file_name }}</div>
                            <small class="text-muted">{{ number_format($att->file_size / 1024, 1) }} KB</small>
                        </div>
                        <a href="{{ asset('storage/' . $att->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="fa-solid fa-download me-1"></i> Unduh
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

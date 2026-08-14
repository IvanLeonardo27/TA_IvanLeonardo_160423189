@extends('layouts.app')

@section('title', 'Detail Macapat: ' . $category->name)

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('teacher.macapat.index') }}" class="text-decoration-none text-muted fw-semibold">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar Macapat
    </a>
    <div>
        <a href="{{ route('teacher.macapat.edit', $category) }}" class="btn btn-warning btn-sm text-white rounded-pill px-3">
            <i class="fa-solid fa-pen me-1"></i> Edit Kategori
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 border-0 mb-4">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
    </div>
@endif

<!-- Info Paugeran Card -->
<div class="card card-modern border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
    <div class="p-4 bg-primary text-white" style="background: linear-gradient(135deg, #1F4D3A 0%, #2b6c51 100%);">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-white text-primary rounded-pill px-3 py-1 mb-2">Tembang Macapat</span>
                <h3 class="fw-bold mb-1">{{ $category->name }}</h3>
                <p class="mb-0 opacity-75">{{ $category->watak ?? 'Tidak ada watak tercatat' }}</p>
            </div>
            <i class="fa-solid fa-music fs-1 opacity-50"></i>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 text-center">
                    <small class="text-muted d-block fw-semibold">Guru Gatra (Baris/Bait)</small>
                    <span class="fs-5 fw-bold text-primary">{{ $category->guru_gatra }} Gatra</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 text-center">
                    <small class="text-muted d-block fw-semibold">Guru Wilangan (Suku Kata)</small>
                    <span class="fs-5 fw-bold text-primary">{{ $category->guru_wilangan }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 text-center">
                    <small class="text-muted d-block fw-semibold">Guru Lagu (Vokal Akhir)</small>
                    <span class="fs-5 fw-bold text-primary">{{ $category->guru_lagu }}</span>
                </div>
            </div>
        </div>
        @if($category->description)
        <div class="mt-3 pt-3 border-top">
            <h6 class="fw-bold text-muted mb-1">Deskripsi / Filosofi:</h6>
            <p class="text-muted mb-0">{{ $category->description }}</p>
        </div>
        @endif
    </div>
</div>

<!-- Daftar Bait & Form Tambah -->
<div class="row g-4">
    <!-- Kolom Kiri: Daftar Bait / Cakepan -->
    <div class="col-lg-7">
        <div class="card card-modern border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 text-main d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-scroll me-2 text-primary"></i> Daftar Bait (Cakepan)</span>
                    <span class="badge bg-soft-blue text-primary">{{ $category->details->count() }} Bait</span>
                </h5>

                @forelse($category->details as $index => $detail)
                <div class="p-4 bg-light rounded-4 border mb-3 position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-secondary">Bait ke-{{ $index + 1 }}</span>
                        <form action="{{ route('teacher.macapat.details.destroy', $detail) }}" method="POST" onsubmit="return confirm('Hapus bait ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle" title="Hapus Bait">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Teks Bait Macapat -->
                    <div class="p-3 bg-white rounded-3 shadow-sm mb-3">
                        <p class="mb-0 fw-semibold text-dark" style="white-space: pre-line; font-family: 'Georgia', serif; line-height: 1.8; font-size: 1.05rem;">
                            {{ $detail->verse }}
                        </p>
                    </div>

                    <!-- Makna / Arti -->
                    @if($detail->meaning)
                    <div class="mb-3">
                        <small class="fw-bold text-muted d-block mb-1"><i class="fa-solid fa-language me-1"></i> Makna / Terjemahan:</small>
                        <p class="mb-0 text-muted small" style="white-space: pre-line;">{{ $detail->meaning }}</p>
                    </div>
                    @endif

                    <!-- Audio Pelafalan -->
                    @if($detail->audio_path)
                    <div class="pt-2 border-top">
                        <small class="fw-bold text-muted d-block mb-2"><i class="fa-solid fa-headphones me-1"></i> Audio Tembang:</small>
                        <audio controls class="w-100 rounded-pill shadow-sm" style="height: 38px;">
                            <source src="{{ asset('storage/' . $detail->audio_path) }}">
                            Browser Anda tidak mendukung audio player.
                        </audio>
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-lines-leaning fs-1 mb-3 opacity-50"></i>
                    <p class="mb-0">Belum ada bait/cakepan untuk tembang ini.</p>
                    <small>Gunakan form di samping untuk menambahkan bait pertama.</small>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Form Tambah Bait Baru -->
    <div class="col-lg-5">
        <div class="card card-modern border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3 text-main"><i class="fa-solid fa-plus-circle me-2 text-primary"></i> Tambah Bait Baru</h5>
                <p class="text-muted small mb-4">Masukkan teks lirik (cakepan) sesuai paugeran {{ $category->guru_gatra }} gatra.</p>

                <form action="{{ route('teacher.macapat.details.store', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Teks Bait / Cakepan ({{ $category->guru_gatra }} Baris)</label>
                        <textarea name="verse" class="form-control rounded-3" rows="5" placeholder="Tuliskan lirik per baris..." required>{{ old('verse') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Makna / Terjemahan Bahasa Indonesia</label>
                        <textarea name="meaning" class="form-control rounded-3" rows="3" placeholder="Arti dari bait di atas...">{{ old('meaning') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Upload Rekaman Audio (Opsional)</label>
                        <input type="file" name="audio" class="form-control rounded-3" accept="audio/*">
                        <small class="text-muted">Format: MP3, WAV, M4A (Maksimal 10MB)</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm">
                        <i class="fa-solid fa-paper-plane me-2"></i> Tambahkan Bait
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

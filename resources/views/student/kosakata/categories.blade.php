@extends('layouts.app')

@section('title', 'Kategori Kosakata Basa Jawa')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h3 class="fw-bold text-main mb-1">
            <i class="fa-solid fa-shapes text-primary me-2"></i>Semua Kategori Kosakata
        </h3>
        <p class="text-muted mb-0">Pilih topik atau kategori di bawah ini untuk menjelajahi perbendaharaan kata Bahasa Jawa.</p>
    </div>
    <div class="col-md-6 mt-3 mt-md-0 text-md-end">
        <div class="d-flex flex-column flex-sm-row justify-content-md-end gap-2">
            <form action="{{ route('kosakata.categories') }}" method="GET" class="flex-grow-1" style="max-width: 320px;">
                <div class="input-group shadow-sm rounded-4">
                    <span class="input-group-text bg-white border-end-0 rounded-start-4">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 rounded-end-4"
                           placeholder="Cari nama kategori..." value="{{ request('search') }}">
                </div>
            </form>
            <a href="{{ route('kosakata.index') }}" class="btn btn-outline-primary rounded-4 px-3 py-2 d-inline-flex align-items-center justify-content-center gap-2 fw-semibold">
                <i class="fa-solid fa-list-ul"></i> Lihat Semua Kosakata
            </a>
        </div>
    </div>
</div>

{{-- Mapping icon tematik --}}
@php
    $iconMap = [
        'Kata Benda' => 'fa-box',
        'Kata Sifat' => 'fa-sparkles',
        'Kata Kerja' => 'fa-person-running',
        'Anggota Tubuh' => 'fa-child',
        'Keluarga' => 'fa-people-group',
        'Makanan' => 'fa-utensils',
        'Minuman' => 'fa-glass-water',
        'Hewan' => 'fa-paw',
        'Tumbuhan' => 'fa-seedling',
        'Alam' => 'fa-mountain-sun',
        'Pendidikan' => 'fa-graduation-cap',
        'Sekolah' => 'fa-school',
        'Pekerjaan' => 'fa-briefcase',
        'Profesi' => 'fa-user-tie',
        'Kesehatan' => 'fa-heart-pulse',
        'Teknologi' => 'fa-laptop-code',
        'Transportasi' => 'fa-car-side',
        'Olahraga' => 'fa-volleyball',
        'Perasaan' => 'fa-face-smile',
        'Budaya' => 'fa-masks-theater',
        'Agama' => 'fa-mosque',
        'Waktu' => 'fa-clock',
        'Warna' => 'fa-palette',
        'Dapur' => 'fa-kitchen-set',
        'Aksesori' => 'fa-gem',
        'Bunga' => 'fa-flower-tulip',
        'Pohon' => 'fa-tree',
        'Rumah' => 'fa-house',
        'Tempat Umum' => 'fa-building-columns',
        'Bangunan' => 'fa-building',
        'Seni' => 'fa-paint-brush',
        'Musik' => 'fa-music',
    ];
@endphp

<div class="row g-4">
    @forelse($categories as $category)
        @php
            $iconClass = $iconMap[$category->name] ?? 'fa-tag';
        @endphp
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{{ route('kosakata.category.show', $category->id) }}" class="text-decoration-none">
                <div class="card h-100 border-0 rounded-4 p-4 text-center shadow-sm category-card transition-all">
                    <div class="icon-wrapper mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle bg-soft-blue text-primary shadow-sm" style="width: 60px; height: 60px;">
                        <i class="fa-solid {{ $iconClass }} fs-4"></i>
                    </div>
                    <span class="badge bg-warning bg-opacity-20 text-dark rounded-pill small mb-2 fw-semibold px-3">
                        {{ $category->vocabularies_count }} kata
                    </span>
                    <h6 class="fw-bold text-main mb-0 text-truncate" title="{{ $category->name }}" style="font-size: 0.95rem;">
                        {{ $category->name }}
                    </h6>
                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                        Buka Kategori <i class="fa-solid fa-arrow-right ms-1"></i>
                    </small>
                </div>
            </a>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <h5 class="fw-bold text-main">Kategori Tidak Ditemukan</h5>
            <p class="text-muted">Coba ketik kata kunci kategori yang lain.</p>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if(method_exists($categories, 'links'))
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-5 mb-4 p-3 bg-white rounded-4 shadow-sm border border-light gap-3">
    <div class="text-muted small fw-semibold">
        Menampilkan <span class="text-dark fw-bold">{{ $categories->firstItem() ?? 0 }}</span> - <span class="text-dark fw-bold">{{ $categories->lastItem() ?? 0 }}</span> dari <span class="text-primary fw-bold">{{ $categories->total() }}</span> kategori
    </div>
    <div class="pagination-custom">
        {{ $categories->appends(request()->query())->onEachSide(1)->links() }}
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
.category-card {
    background: #ffffff;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(0, 0, 0, 0.05) !important;
}
.category-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(31, 77, 58, 0.12) !important;
    background: linear-gradient(180deg, #FFFFFF 0%, #F8F4EA 100%);
}
.category-card:hover .icon-wrapper {
    background-color: var(--primary) !important;
    color: #ffffff !important;
    transform: scale(1.08);
}
</style>
@endpush

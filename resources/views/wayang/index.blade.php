@extends('layouts.app')

@section('title', 'Materi Pembelajaran Pewayangan - BasaKula')

@section('content')
<div class="container-fluid py-4" style="max-width: 1300px;">
    {{-- Hero Section --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" 
         style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%); color: #ffffff;">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="badge rounded-pill px-3 py-1.5 mb-3 fw-bold shadow-xs" 
                          style="background: rgba(255,255,255,0.2); color: #ffffff; border: 1px solid rgba(255,255,255,0.3);">
                        <i class="fa-solid fa-masks-theater me-1.5"></i> Ensiklopedia Pewayangan Jawa
                    </span>
                    <h2 class="fw-bold text-white mb-2" style="letter-spacing: -0.5px;">Tokoh & Kisah Pewayangan</h2>
                    <p class="text-white-50 mb-4" style="font-size: 1.05rem; max-width: 650px;">
                        Pelajari ragam tokoh pewayangan Nusantara, watak ksatria, silsilah keluarga, senjata pusaka, serta kisah keteladanan budi pekerti dalam epos agung Mahabharata dan Bharatayuda.
                    </p>

                    {{-- Form Pencarian Terpadu --}}
                    <form action="{{ route('wayang.index') }}" method="GET" class="d-flex gap-2 flex-wrap" style="max-width: 600px;">
                        @if($categoryId)
                            <input type="hidden" name="category" value="{{ $categoryId }}">
                        @endif
                        @if($allegiance)
                            <input type="hidden" name="allegiance" value="{{ $allegiance }}">
                        @endif
                        <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden bg-white p-1 flex-grow-1">
                            <span class="input-group-text bg-transparent border-0 ps-3 text-muted">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-0 bg-transparent py-2.5 text-dark fw-semibold" 
                                   placeholder="Cari tokoh wayang (contoh: Arjuna, Bima, Gatotkaca)..." 
                                   value="{{ $search }}" style="font-size: 0.95rem;">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold btn-bouncy" style="background:#C9A66B; border:none; color:#16402E;">
                                Cari
                            </button>
                        </div>
                        @if($search || $categoryId || $allegiance)
                        <a href="{{ route('wayang.index') }}" class="btn btn-outline-light rounded-pill px-3 py-2 d-flex align-items-center gap-1.5 shadow-xs" style="font-size: 0.88rem;">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </a>
                        @endif
                    </form>
                </div>

                <div class="col-lg-4 text-center d-none d-lg-block">
                    <div class="d-inline-flex p-4 rounded-circle shadow-lg" 
                         style="background: rgba(255,255,255,0.08); border: 2px dashed rgba(255,255,255,0.25);">
                        <i class="fa-solid fa-masks-theater text-white" style="font-size: 6.5rem; opacity: 0.9;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kategori Filter Pills --}}
    <div class="d-flex align-items-center gap-2 overflow-auto pb-3 mb-4 custom-scroll flex-nowrap">
        <a href="{{ route('wayang.index', array_filter(['search' => $search, 'allegiance' => $allegiance])) }}" 
           class="btn rounded-pill px-3.5 py-2 btn-sm fw-bold flex-shrink-0 {{ !$categoryId ? 'btn-primary text-white shadow-sm' : 'btn-light border text-muted' }}" 
           style="{{ !$categoryId ? 'background: #16402E; border-color: #16402E;' : '' }}">
            <i class="fa-solid fa-border-all me-1"></i> Semua Kategori ({{ $totalCharacters }})
        </a>

        @foreach($categories as $cat)
        <a href="{{ route('wayang.index', array_filter(['category' => $cat->id, 'search' => $search, 'allegiance' => $allegiance])) }}" 
           class="btn rounded-pill px-3.5 py-2 btn-sm fw-bold flex-shrink-0 {{ $categoryId == $cat->id ? 'btn-primary text-white shadow-sm' : 'btn-light border text-muted' }}"
           style="{{ $categoryId == $cat->id ? 'background: #16402E; border-color: #16402E;' : '' }}">
            {{ $cat->name }} <span class="badge rounded-pill ms-1 {{ $categoryId == $cat->id ? 'bg-white text-dark' : 'bg-secondary bg-opacity-10 text-muted' }}">{{ $cat->characters_count }}</span>
        </a>
        @endforeach
    </div>

    {{-- Sub-Filter & Info Bar --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h5 class="fw-bold text-dark mb-0">
                @if($selectedCategory)
                    Kategori: <span class="text-primary">{{ $selectedCategory->name }}</span>
                @else
                    Daftar Semua Tokoh
                @endif
                <small class="text-muted fw-normal fs-6">({{ $characters->total() }} tokoh ditemukan)</small>
            </h5>
        </div>

        {{-- Filter Allegiance --}}
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="small fw-bold text-muted"><i class="fa-solid fa-flag me-1"></i> Pihak:</span>
            <a href="{{ route('wayang.index', array_filter(['category' => $categoryId, 'search' => $search])) }}" 
               class="badge rounded-pill px-3 py-1.5 text-decoration-none {{ !$allegiance ? 'bg-dark text-white' : 'bg-light text-muted border' }}">
                Semua
            </a>
            @foreach($allegiances as $alg)
            <a href="{{ route('wayang.index', array_filter(['allegiance' => $alg, 'category' => $categoryId, 'search' => $search])) }}" 
               class="badge rounded-pill px-3 py-1.5 text-decoration-none {{ $allegiance == $alg ? 'bg-primary text-white shadow-xs' : 'bg-light text-muted border' }}">
                {{ $alg }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Grid Tokoh Wayang --}}
    @if($characters->isEmpty())
    <div class="card border-0 shadow-sm rounded-4 text-center p-5 my-4" style="background: #ffffff; border: 1px solid #E2E8F0 !important;">
        <div class="rounded-circle bg-light d-inline-flex p-4 mb-3 text-secondary opacity-50 mx-auto" style="width: 80px; height: 80px;">
            <i class="fa-solid fa-masks-theater fs-2"></i>
        </div>
        <h5 class="fw-bold text-dark">Tokoh wayang tidak ditemukan</h5>
        <p class="text-muted small mb-3">Tidak ada karakter wayang yang cocok dengan kata kunci atau filter yang Anda pilih.</p>
        <div>
            <a href="{{ route('wayang.index') }}" class="btn btn-primary rounded-pill px-4 py-2 btn-sm fw-bold">
                <i class="fa-solid fa-rotate-left me-1"></i> Tampilkan Semua Tokoh
            </a>
        </div>
    </div>
    @else
    <div class="row g-4 mb-4">
        @foreach($characters as $char)
        @php
            // Badge color based on category/allegiance
            $badgeColor = match($char->category_id) {
                1 => 'bg-success-subtle text-success border-success',
                2 => 'bg-danger-subtle text-danger border-danger',
                3 => 'bg-warning-subtle text-warning-emphasis border-warning',
                4 => 'bg-primary-subtle text-primary border-primary',
                5 => 'bg-danger-subtle text-danger border-danger',
                6 => 'bg-purple-subtle text-purple border',
                7 => 'bg-info-subtle text-info-emphasis border-info',
                default => 'bg-secondary-subtle text-secondary border-secondary',
            };
        @endphp
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden wayang-card" 
                 style="background: #ffffff; border: 1px solid #E2E8F0 !important; transition: all 0.25s ease;">
                
                {{-- Character Header & Avatar --}}
                <div class="p-4 text-center position-relative" style="background: linear-gradient(180deg, #F8FAFC 0%, #F1F5F9 100%);">
                    <span class="badge rounded-pill px-2.5 py-1 position-absolute top-0 start-0 m-3 border {{ $badgeColor }}" style="font-size: 0.72rem;">
                        {{ $char->category->name }}
                    </span>
                    <span class="badge bg-white text-muted border rounded-pill px-2 py-0.5 position-absolute top-0 end-0 m-3 font-monospace" style="font-size: 0.68rem;">
                        #{{ $char->id }}
                    </span>

                    {{-- Image Silhouette / Avatar --}}
                    <div class="my-3 d-inline-block position-relative">
                        <img src="{{ asset('storage/' . $char->image_path) }}" 
                             alt="{{ $char->name }}" 
                             class="rounded-4 shadow-sm" 
                             style="width: 130px; height: 130px; object-fit: cover; border: 3px solid #ffffff;"
                             onerror="this.onerror=null; this.src='{{ asset('storage/wayang/default.svg') }}';">
                    </div>

                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1.15rem;">{{ $char->name }}</h5>
                    @if($char->other_names && $char->other_names !== 'Tidak ada nama lain yang umum')
                    <small class="text-muted d-block text-truncate px-2" title="{{ $char->other_names }}" style="font-size: 0.78rem;">
                        Alias: {{ Str::limit($char->other_names, 30) }}
                    </small>
                    @else
                    <small class="text-muted d-block" style="font-size: 0.78rem;">
                        {{ $char->gender }}
                    </small>
                    @endif
                </div>

                {{-- Character Body Details --}}
                <div class="card-body p-3.5 d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-2">
                            <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1 fw-semibold" style="font-size: 0.72rem;">
                                <i class="fa-solid fa-flag text-primary me-1"></i> {{ $char->allegiance }}
                            </span>
                        </div>

                        <p class="text-muted small mb-3" style="font-size: 0.82rem; line-height: 1.4; min-height: 48px;">
                            {{ Str::limit($char->role ?? $char->description, 75) }}
                        </p>

                        @if($char->weapon && $char->weapon !== 'Tidak memiliki senjata khusus' && $char->weapon !== 'Tidak disebutkan secara khusus')
                        <div class="p-2 rounded-3 bg-light border small mb-3 text-truncate" style="font-size: 0.75rem;" title="{{ $char->weapon }}">
                            <strong class="text-dark"><i class="fa-solid fa-shield-halved text-secondary me-1"></i> Senjata:</strong> 
                            <span class="text-muted">{{ $char->weapon }}</span>
                        </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-light border btn-sm rounded-pill flex-grow-1 fw-semibold text-muted shadow-xs" 
                                data-bs-toggle="modal" data-bs-target="#quickModal{{ $char->id }}">
                            <i class="fa-regular fa-eye me-1"></i> Intip
                        </button>
                        <a href="{{ route('wayang.show', $char) }}" class="btn btn-primary btn-sm rounded-pill flex-grow-1 fw-bold btn-bouncy shadow-xs" style="background: #16402E; border-color: #16402E;">
                            Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick View Modal --}}
        <div class="modal fade" id="quickModal{{ $char->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header p-4 text-white" style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%);">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('storage/' . $char->image_path) }}" 
                                 class="rounded-circle border border-2 border-white shadow-sm" 
                                 width="50" height="50" style="object-fit: cover;"
                                 onerror="this.src='{{ asset('storage/wayang/default.svg') }}';">
                            <div>
                                <h5 class="modal-title fw-bold text-white mb-0">{{ $char->name }}</h5>
                                <small class="text-white-50">{{ $char->category->name }} • {{ $char->allegiance }}</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4 bg-white">
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-4 border">
                                    <small class="text-muted fw-bold d-block mb-1">Peran & Kedudukan</small>
                                    <div class="text-dark small fw-semibold">{{ $char->role }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-4 border">
                                    <small class="text-muted fw-bold d-block mb-1">Sifat & Karakter Utama</small>
                                    <div class="text-dark small fw-semibold">{{ $char->character_traits }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold text-dark mb-1"><i class="fa-solid fa-align-left text-primary me-1.5"></i> Ringkasan Tokoh</h6>
                            <p class="text-muted small mb-0" style="line-height: 1.5;">{{ $char->description }}</p>
                        </div>

                        <div class="p-3 rounded-4 bg-light border">
                            <h6 class="fw-bold text-dark mb-1"><i class="fa-solid fa-book-open-reader text-success me-1.5"></i> Cuplikan Cerita</h6>
                            <p class="text-muted small mb-0" style="line-height: 1.5;">{{ $char->story }}</p>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-top p-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Tutup</button>
                        <a href="{{ route('wayang.show', $char) }}" class="btn btn-primary rounded-pill px-4 btn-sm fw-bold" style="background:#16402E; border-color:#16402E;">
                            Buka Halaman Detail Penuh <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $characters->links() }}
    </div>
    @endif
</div>

<style>
.wayang-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(22, 64, 46, 0.12) !important;
}
.custom-scroll::-webkit-scrollbar {
    height: 6px;
}
.custom-scroll::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}
.custom-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}
</style>
@endsection

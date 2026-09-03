@extends('layouts.app')

@section('title', $character->name . ' - Tokoh Pewayangan Jawa - BasaKula')

@section('content')
<div class="container-fluid py-4" style="max-width: 1240px;">
    {{-- Breadcrumb & Back Button --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.9rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('wayang.index') }}" class="text-decoration-none text-muted">Pewayangan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('wayang.index', ['category' => $character->category_id]) }}" class="text-decoration-none text-muted">{{ $character->category->name }}</a></li>
                <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">{{ $character->name }}</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('wayang.edit', $character) }}" class="btn btn-warning rounded-pill px-3.5 py-2 btn-sm fw-bold shadow-xs text-dark d-inline-flex align-items-center gap-1.5" style="background:#FBBF24; border:none;">
                <i class="fa-solid fa-pen-to-square"></i> Edit Tokoh
            </a>
            <form action="{{ route('wayang.destroy', $character) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tokoh {{ $character->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger rounded-pill px-3.5 py-2 btn-sm fw-bold shadow-xs d-inline-flex align-items-center gap-1.5 bg-white">
                    <i class="fa-solid fa-trash"></i> Hapus
                </button>
            </form>
            @endif

            @auth
            @php
                $isBookmarked = \App\Models\Bookmark::where('user_id', auth()->id())
                    ->where('bookmarkable_type', \App\Models\WayangCharacter::class)
                    ->where('bookmarkable_id', $character->id)
                    ->exists();
            @endphp
            <button type="button" 
                    onclick="toggleBookmark('wayang', {{ $character->id }}, this)" 
                    class="btn {{ $isBookmarked ? 'btn-warning text-dark' : 'btn-outline-secondary bg-white' }} rounded-pill px-4 py-2 btn-sm fw-semibold shadow-xs">
                <i class="{{ $isBookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark me-1.5 text-warning"></i>
                <span class="btn-text">{{ $isBookmarked ? 'Tersimpan' : 'Simpan Bookmark' }}</span>
            </button>
            @endauth

            <a href="{{ route('wayang.index', ['category' => $character->category_id]) }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 btn-sm fw-semibold shadow-xs bg-white">
                <i class="fa-solid fa-arrow-left me-1.5"></i> Kembali ke Katalog Wayang
            </a>
        </div>
    </div>

    @php
        $badgeColor = match($character->category_id) {
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

    {{-- Hero Profile Banner --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" 
         style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%); color: #ffffff;">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
                {{-- Character Big Avatar --}}
                <div class="col-md-auto text-center text-md-start">
                    <div class="position-relative d-inline-block">
                        <img src="{{ asset('storage/' . $character->image_path) }}" 
                             alt="{{ $character->name }}" 
                             class="rounded-4 shadow-lg bg-white p-2" 
                             style="width: 160px; height: 160px; object-fit: cover; border: 4px solid rgba(255,255,255,0.4);"
                             onerror="this.onerror=null; this.src='{{ asset('storage/wayang/default.svg') }}';">
                    </div>
                </div>

                {{-- Character Title & Highlights --}}
                <div class="col-md">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-2.5">
                        <span class="badge rounded-pill px-3 py-1 fw-bold" 
                              style="background: rgba(255,255,255,0.2); color: #ffffff; border: 1px solid rgba(255,255,255,0.35); font-size: 0.8rem;">
                            {{ $character->category->name }}
                        </span>
                        <span class="badge rounded-pill px-3 py-1 fw-bold" 
                              style="background: #C9A66B; color: #16402E; font-size: 0.8rem;">
                            <i class="fa-solid fa-flag me-1"></i> {{ $character->allegiance }}
                        </span>
                        <span class="badge bg-white text-muted rounded-pill px-2.5 py-1 font-monospace" style="font-size: 0.75rem;">
                            ID Tokoh: #{{ $character->id }}
                        </span>
                    </div>

                    <h2 class="fw-bold text-white mb-2" style="letter-spacing: -0.5px; font-size: 2.2rem;">{{ $character->name }}</h2>
                    
                    @if($character->other_names && $character->other_names !== 'Tidak ada nama lain yang umum')
                    <p class="text-white-50 small mb-2 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-signature text-warning"></i>
                        <span><strong>Nama Lain / Gelar:</strong> {{ $character->other_names }}</span>
                    </p>
                    @endif

                    <p class="text-white-50 mb-0" style="font-size: 0.98rem; line-height: 1.55; max-width: 780px;">
                        {{ $character->role }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Content Layout --}}
    <div class="row g-4">
        {{-- Kolom Kiri: Kisah & Riwayat Lengkap --}}
        <div class="col-lg-8">
            {{-- Kartu Deskripsi & Karakter --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-4.5 mb-4" style="background:#ffffff; border: 1px solid #E2E8F0 !important;">
                <h5 class="fw-bold text-dark mb-3.5 d-flex align-items-center gap-2" style="font-size: 1.15rem;">
                    <i class="fa-solid fa-user-gear text-primary"></i> Deskripsi & Peran Tokoh
                </h5>
                
                <p class="text-dark mb-4" style="font-size: 1rem; line-height: 1.7;">
                    {{ $character->description }}
                </p>

                {{-- Sifat & Karakter Traits --}}
                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-2.5 small d-flex align-items-center gap-2">
                        <i class="fa-solid fa-heart-pulse text-danger fs-6"></i> Sifat & Watak Utama:
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(explode(',', $character->character_traits) as $trait)
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 shadow-xs fw-semibold" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-check-double text-success me-1"></i> {{ trim($trait) }}
                        </span>
                        @endforeach
                    </div>
                </div>

                {{-- Senjata Pusaka / Kesaktian --}}
                @if($character->weapon && $character->weapon !== 'Tidak memiliki senjata khusus' && $character->weapon !== 'Tidak disebutkan secara khusus')
                <div class="p-3.5 rounded-4" style="background: #F8FAFC; border-left: 4px solid #64748B !important;">
                    <h6 class="fw-bold text-dark mb-1.5 small d-flex align-items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-secondary"></i> Senjata & Kesaktian Pusaka:
                    </h6>
                    <p class="text-dark mb-0 fw-semibold" style="font-size: 0.95rem;">
                        {{ $character->weapon }}
                    </p>
                </div>
                @endif
            </div>

            {{-- Kartu Kisah & Perjalanan Pewayangan --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-4.5 mb-4" style="background:#ffffff; border: 1px solid #E2E8F0 !important;">
                <h5 class="fw-bold text-dark mb-3.5 d-flex align-items-center gap-2" style="font-size: 1.15rem;">
                    <i class="fa-solid fa-book-open-reader text-success"></i> Kisah & Riwayat dalam Bharatayuda
                </h5>
                <div class="p-4 rounded-4" style="background: #F8FAFC; border-left: 4px solid #16402E !important;">
                    <p class="text-dark mb-0" style="font-size: 1rem; line-height: 1.8; text-align: justify;">
                        {{ $character->story }}
                    </p>
                </div>
            </div>

            {{-- Kartu Silsilah & Hubungan Keluarga --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-4.5" style="background:#ffffff; border: 1px solid #E2E8F0 !important;">
                <h5 class="fw-bold text-dark mb-3.5 d-flex align-items-center gap-2" style="font-size: 1.15rem;">
                    <i class="fa-solid fa-sitemap text-primary"></i> Silsilah & Hubungan Keluarga
                </h5>
                <div class="p-3.5 rounded-4 d-flex align-items-start gap-3.5" style="background: #F8FAFC;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                         style="width:48px; height:48px; background: #EFF6FF; color: #2563EB;">
                        <i class="fa-solid fa-people-roof fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Garis Keturunan & Kekerabatan</h6>
                        <p class="text-muted mb-0" style="font-size: 0.92rem; line-height: 1.55;">
                            {{ $character->family }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Rangkuman Info & Tokoh Terkait --}}
        <div class="col-lg-4">
            {{-- Identitas Ringkas Tokoh --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="background:#ffffff; border: 1px solid #E2E8F0 !important;">
                <h5 class="fw-bold text-dark mb-3.5 border-bottom pb-2.5" style="font-size: 1.1rem;">
                    <i class="fa-solid fa-circle-info text-primary me-1.5"></i> Identitas Tokoh
                </h5>

                <div class="d-flex flex-column gap-3.5">
                    <div>
                        <small class="text-muted fw-semibold d-block mb-1">Nama Tokoh</small>
                        <span class="fw-bold text-dark fs-6">{{ $character->name }}</span>
                    </div>

                    <div>
                        <small class="text-muted fw-semibold d-block mb-1">Jenis Kelamin</small>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.82rem;">
                            @if($character->gender === 'Laki-laki')
                                <i class="fa-solid fa-mars text-primary me-1"></i> Laki-laki
                            @else
                                <i class="fa-solid fa-venus text-danger me-1"></i> Perempuan
                            @endif
                        </span>
                    </div>

                    <div>
                        <small class="text-muted fw-semibold d-block mb-1">Kategori Pewayangan</small>
                        <span class="badge {{ $badgeColor }} rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.82rem;">
                            {{ $character->category->name }}
                        </span>
                    </div>

                    <div>
                        <small class="text-muted fw-semibold d-block mb-1">Pihak / Keberpihakan</small>
                        <span class="badge bg-dark text-white rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.82rem;">
                            {{ $character->allegiance }}
                        </span>
                    </div>

                    @if($character->weapon)
                    <div>
                        <small class="text-muted fw-semibold d-block mb-1">Senjata Utama</small>
                        <span class="text-dark small fw-semibold">{{ $character->weapon }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Tokoh Terkait / Kategori Serupa --}}
            @if($relatedCharacters->isNotEmpty())
            <div class="card border-0 shadow-sm rounded-4 p-4" style="background:#ffffff; border: 1px solid #E2E8F0 !important;">
                <h5 class="fw-bold text-dark mb-3.5 border-bottom pb-2.5" style="font-size: 1.05rem;">
                    <i class="fa-solid fa-users text-success me-1.5"></i> Tokoh {{ $character->category->name }} Lainnya
                </h5>

                <div class="d-flex flex-column gap-2.5">
                    @foreach($relatedCharacters as $rc)
                    <a href="{{ route('wayang.show', $rc) }}" 
                       class="p-2.5 rounded-4 border bg-light bg-opacity-40 text-decoration-none d-flex align-items-center gap-3 text-dark related-card"
                       style="transition: all 0.2s ease; overflow: hidden;">
                        
                        <div class="rounded-3 overflow-hidden flex-shrink-0 border shadow-xs" style="width: 46px; height: 46px; background: #ffffff;">
                            <img src="{{ asset('storage/' . $rc->image_path) }}" 
                                 alt="{{ $rc->name }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.onerror=null; this.src='{{ asset('storage/wayang/default.svg') }}';">
                        </div>

                        <div class="flex-grow-1 overflow-hidden" style="min-width: 0;">
                            <h6 class="fw-bold text-dark mb-0.5 small text-truncate" style="font-size: 0.88rem;">{{ $rc->name }}</h6>
                            <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">{{ Str::limit($rc->role, 38) }}</small>
                        </div>

                        <div class="text-muted flex-shrink-0 ms-1">
                            <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem;"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.related-card:hover {
    background: #F1F5F9 !important;
    transform: translateX(3px);
    border-color: #CBD5E1 !important;
}
</style>
@endsection

@push('scripts')
<script>
function toggleBookmark(type, id, btn) {
    const icon = btn.querySelector('i');
    const label = btn.querySelector('.btn-text');

    btn.disabled = true;

    fetch('{{ route("student.bookmarks.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ type: type, id: id })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        if (data.status === 'success') {
            if (data.bookmarked) {
                btn.className = 'btn btn-warning text-dark rounded-pill px-4 py-2 btn-sm fw-semibold shadow-xs';
                icon.className = 'fa-solid fa-bookmark me-1.5 text-dark';
                if (label) label.textContent = 'Tersimpan';
            } else {
                btn.className = 'btn btn-outline-secondary bg-white rounded-pill px-4 py-2 btn-sm fw-semibold shadow-xs';
                icon.className = 'fa-regular fa-bookmark me-1.5 text-warning';
                if (label) label.textContent = 'Simpan Bookmark';
            }
        } else if (data.message) {
            alert(data.message);
        }
    })
    .catch(err => {
        btn.disabled = false;
        console.error('Bookmark error:', err);
    });
}
</script>
@endpush

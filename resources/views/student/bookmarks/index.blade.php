@extends('layouts.app')

@section('title', 'Bookmark Saya - BasaKula')

@section('content')
<div class="container-fluid py-4" style="max-width: 1240px;">
    {{-- Header Banner --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" 
         style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%); color: #ffffff;">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge rounded-pill px-3 py-1.5 fw-bold mb-2.5" 
                          style="background: rgba(255,255,255,0.2); color: #ffffff; border: 1px solid rgba(255,255,255,0.35); font-size: 0.8rem;">
                        <i class="fa-solid fa-bookmark me-1.5 text-warning"></i> Simpanan Pelajar
                    </span>
                    <h2 class="fw-bold text-white mb-2" style="font-size: 1.85rem;">
                        Materi Bookmark Saya
                    </h2>
                    <p class="small mb-0" style="max-width: 600px; color: rgba(255, 255, 255, 0.95) !important; font-size: 0.9rem; line-height: 1.5;">
                        Kumpulan materi pembelajaran Aksara Jawa, Tembang Macapat, dan Pewayangan yang telah Anda simpan untuk dipelajari kembali secara cepat.
                    </p>
                </div>

                <div class="d-none d-md-block text-end">
                    <div class="d-inline-flex p-3 bg-white bg-opacity-10 rounded-circle text-white shadow-sm">
                        <i class="fa-solid fa-bookmark fs-1 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <ul class="nav nav-pills custom-pills gap-2" id="bookmarkTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active rounded-pill px-4 py-2 fw-semibold btn-sm shadow-xs" 
                        id="all-tab" data-bs-toggle="pill" data-bs-target="#all-content" type="button">
                    <i class="fa-solid fa-layer-group me-1.5"></i> Semua Simpanan ({{ $bookmarks->count() }})
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 py-2 fw-semibold btn-sm shadow-xs" 
                        id="wayang-tab" data-bs-toggle="pill" data-bs-target="#wayang-content" type="button">
                    <i class="fa-solid fa-masks-theater me-1.5"></i> Pewayangan
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 py-2 fw-semibold btn-sm shadow-xs" 
                        id="macapat-tab" data-bs-toggle="pill" data-bs-target="#macapat-content" type="button">
                    <i class="fa-solid fa-music me-1.5"></i> Tembang Macapat
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 py-2 fw-semibold btn-sm shadow-xs" 
                        id="aksara-tab" data-bs-toggle="pill" data-bs-target="#aksara-content" type="button">
                    <i class="fa-solid fa-font me-1.5"></i> Aksara Jawa
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 py-2 fw-semibold btn-sm shadow-xs" 
                        id="vocab-tab" data-bs-toggle="pill" data-bs-target="#vocab-content" type="button">
                    <i class="fa-solid fa-book-journal-whills me-1.5"></i> Kosakata
                </button>
            </li>
        </ul>
    </div>

    {{-- Tab Contents --}}
    <div class="tab-content" id="bookmarkTabContent">
        {{-- ALL CONTENT --}}
        <div class="tab-pane fade show active" id="all-content" role="tabpanel">
            @if($bookmarks->isEmpty())
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-4">
                    <div class="mb-3">
                        <i class="fa-regular fa-bookmark text-muted opacity-50" style="font-size: 3.5rem;"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">Belum Ada Simpanan Materi</h5>
                    <p class="text-muted small mb-4" style="max-width: 450px; margin: 0 auto;">
                        Anda belum menandai materi apa pun. Jelajahi katalog Pewayangan, Macapat, atau Aksara Jawa dan klik ikon **Simpan Bookmark**!
                    </p>
                    <div>
                        <a href="{{ route('wayang.index') }}" class="btn btn-primary rounded-pill px-4 py-2 text-white fw-semibold btn-sm shadow-sm">
                            <i class="fa-solid fa-compass me-1.5"></i> Jelajahi Materi Sekarang
                        </a>
                    </div>
                </div>
            @else
                <div class="row g-3 g-md-4">
                    @foreach($bookmarks as $b)
                        @php
                            $item = $b->bookmarkable;
                        @endphp
                        @if($item)
                            <div class="col-12 col-sm-6 col-lg-4 col-xl-3" id="bookmark-card-{{ $b->id }}">
                                @include('student.bookmarks.partials.card', ['bookmark' => $b, 'item' => $item])
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        {{-- WAYANG CONTENT --}}
        <div class="tab-pane fade" id="wayang-content" role="tabpanel">
            @php
                $wayangBookmarks = $bookmarks->filter(fn($b) => $b->bookmarkable_type === \App\Models\WayangCharacter::class);
            @endphp
            @if($wayangBookmarks->isEmpty())
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-4">
                    <h6 class="fw-bold text-muted mb-0">Belum ada materi Pewayangan yang disimpan.</h6>
                </div>
            @else
                <div class="row g-3 g-md-4">
                    @foreach($wayangBookmarks as $b)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3" id="bookmark-card-wayang-{{ $b->id }}">
                            @include('student.bookmarks.partials.card', ['bookmark' => $b, 'item' => $b->bookmarkable])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- MACAPAT CONTENT --}}
        <div class="tab-pane fade" id="macapat-content" role="tabpanel">
            @php
                $macapatBookmarks = $bookmarks->filter(fn($b) => $b->bookmarkable_type === \App\Models\MacapatDetail::class);
            @endphp
            @if($macapatBookmarks->isEmpty())
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-4">
                    <h6 class="fw-bold text-muted mb-0">Belum ada Tembang Macapat yang disimpan.</h6>
                </div>
            @else
                <div class="row g-3 g-md-4">
                    @foreach($macapatBookmarks as $b)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3" id="bookmark-card-macapat-{{ $b->id }}">
                            @include('student.bookmarks.partials.card', ['bookmark' => $b, 'item' => $b->bookmarkable])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- AKSARA CONTENT --}}
        <div class="tab-pane fade" id="aksara-content" role="tabpanel">
            @php
                $aksaraBookmarks = $bookmarks->filter(fn($b) => $b->bookmarkable_type === \App\Models\JavaneseScriptDetail::class);
            @endphp
            @if($aksaraBookmarks->isEmpty())
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-4">
                    <h6 class="fw-bold text-muted mb-0">Belum ada Aksara Jawa yang disimpan.</h6>
                </div>
            @else
                <div class="row g-3 g-md-4">
                    @foreach($aksaraBookmarks as $b)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3" id="bookmark-card-aksara-{{ $b->id }}">
                            @include('student.bookmarks.partials.card', ['bookmark' => $b, 'item' => $b->bookmarkable])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- VOCAB CONTENT --}}
        <div class="tab-pane fade" id="vocab-content" role="tabpanel">
            @php
                $vocabBookmarks = $bookmarks->filter(fn($b) => $b->bookmarkable_type === \App\Models\Vocabulary::class);
            @endphp
            @if($vocabBookmarks->isEmpty())
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-4">
                    <h6 class="fw-bold text-muted mb-0">Belum ada Kosakata yang disimpan.</h6>
                </div>
            @else
                <div class="row g-3 g-md-4">
                    @foreach($vocabBookmarks as $b)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3" id="bookmark-card-vocab-{{ $b->id }}">
                            @include('student.bookmarks.partials.card', ['bookmark' => $b, 'item' => $b->bookmarkable])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.custom-pills .nav-link {
    color: #475569;
    background: #ffffff;
    border: 1px solid #E2E8F0;
}
.custom-pills .nav-link.active {
    background-color: #16402E !important;
    color: #ffffff !important;
    border-color: #16402E !important;
}
.hover-elevate {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.hover-elevate:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
}
</style>
@endsection

@push('scripts')
<script>
function removeBookmarkCard(type, id, cardId) {
    if (!confirm('Hapus materi ini dari daftar simpanan Anda?')) return;

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
        if (data.status === 'success' && !data.bookmarked) {
            const card = document.getElementById(cardId);
            if (card) {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                setTimeout(() => card.remove(), 300);
            }
        }
    })
    .catch(err => console.error('Remove bookmark error:', err));
}
</script>
@endpush

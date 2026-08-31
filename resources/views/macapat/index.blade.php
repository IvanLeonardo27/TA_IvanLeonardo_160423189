@extends('layouts.app')

@section('title', 'Tembang Macapat - Sinau Basa Jawa')

@section('content')
<div class="macapat-page-container pb-5">
    <!-- Header Section -->
    <div class="text-center py-4 mb-4">
        <div class="d-inline-flex align-items-center justify-content-center p-3 bg-soft-blue text-primary rounded-circle mb-3 shadow-sm">
            <i class="fa-solid fa-music fs-2"></i>
        </div>
        <h2 class="fw-bold text-main mb-2">Tembang Macapat</h2>
        <p class="text-muted mx-auto" style="max-width: 650px; font-size: 1.05rem;">
            Ayo sinau 10 jinis Tembang Macapat, mangerteni paugeran Guru Gatra, Guru Wilangan, lan Guru Lagu, sarta nyinaoni watak lan maknane.
        </p>
    </div>

    <!-- Search Bar Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-7 col-lg-6 col-xl-5">
            <div class="input-group input-group-lg search-box rounded-pill shadow-sm bg-white border">
                <span class="input-group-text bg-transparent border-0 ps-4 text-primary">
                    <i class="fa-solid fa-magnifying-glass fs-5"></i>
                </span>
                <input type="text" 
                       id="macapatSearchInput" 
                       class="form-control border-0 py-3 ps-2 pe-4 bg-transparent" 
                       placeholder="Cari tembang macapat..." 
                       aria-label="Cari tembang macapat"
                       autocomplete="off">
                <button type="button" id="clearSearchBtn" class="btn bg-transparent border-0 pe-4 text-muted d-none" title="Bersihkan pencarian">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    </div>

    @php
        $userMacapatBookmarkIds = auth()->check() 
            ? \App\Models\Bookmark::where('user_id', auth()->id())
                ->where('bookmarkable_type', \App\Models\MacapatDetail::class)
                ->pluck('bookmarkable_id')
                ->toArray() 
            : [];
    @endphp

    <!-- Grid Daftar 10 Tembang Macapat -->
    <div class="row g-4" id="macapatGrid">
        @forelse($categories as $item)
        @php $isBookmarked = in_array($item->id, $userMacapatBookmarkIds); @endphp
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 macapat-card-col" data-name="{{ strtolower($item->name) }}">
            <div class="card card-modern h-100 border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column hover-elevate position-relative">
                @auth
                <button type="button" 
                        onclick="event.preventDefault(); event.stopPropagation(); toggleBookmarkCard('macapat', {{ $item->id }}, this)" 
                        class="btn btn-sm p-0 border position-absolute top-0 end-0 m-2.5 z-3 d-flex align-items-center justify-content-center rounded-circle shadow-xs bg-white btn-bookmark-card" 
                        style="width: 32px; height: 32px; transition: all 0.2s ease;" 
                        title="{{ $isBookmarked ? 'Batal Simpan' : 'Simpan Bookmark' }}">
                    <i class="{{ $isBookmarked ? 'fa-solid text-warning' : 'fa-regular text-secondary opacity-60' }} fa-bookmark" style="font-size: 0.88rem;"></i>
                </button>
                @endauth

                <!-- Card Header Accent -->
                <div class="card-top-stripe"></div>

                <div class="card-body p-4 d-flex flex-column">
                    <!-- Nama Tembang (Elemen Visual Utama) -->
                    <div class="mb-3">
                        <span class="badge bg-soft-blue text-primary rounded-pill px-3 py-1 mb-2 fw-semibold" style="font-size: 0.75rem;">
                            Tembang Macapat
                        </span>
                        <h4 class="fw-bold text-main mb-1 text-truncate macapat-name">{{ $item->name }}</h4>
                    </div>

                    <!-- Watak Singkat -->
                    @if(!empty($item->watak))
                    <div class="mb-3 flex-grow-1">
                        <small class="text-muted fw-semibold d-block mb-1">
                            <i class="fa-solid fa-heart me-1 text-danger opacity-75"></i> Watak:
                        </small>
                        <p class="text-secondary small mb-0 line-clamp-2" title="{{ $item->watak }}">
                            {{ $item->watak }}
                        </p>
                    </div>
                    @endif

                    <!-- Aturan Paugeran (Pills) -->
                    <div class="bg-light rounded-3 p-3 mb-4 border border-light-subtle">
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                            <span class="small text-muted fw-semibold">Guru Gatra:</span>
                            <span class="badge bg-white text-primary border shadow-sm px-2 py-1">{{ $item->guru_gatra }} Gatra</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                            <span class="small text-muted fw-semibold">Guru Wilangan:</span>
                            <span class="small fw-bold text-dark text-end" style="max-width: 60%;">{{ $item->guru_wilangan }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted fw-semibold">Guru Lagu:</span>
                            <span class="small fw-bold text-primary text-end" style="max-width: 60%;">{{ $item->guru_lagu }}</span>
                        </div>
                    </div>

                    <!-- Tombol Pelajari -->
                    <div class="mt-auto">
                        <a href="{{ route('macapat.show', $item->id) }}" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold shadow-sm btn-bouncy d-flex align-items-center justify-content-center gap-2">
                            <span>Pelajari</span>
                            <i class="fa-solid fa-arrow-right small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted mb-0">Belum ada data Tembang Macapat.</p>
        </div>
        @endforelse
    </div>

    <!-- Empty Search State -->
    <div id="noResultsMessage" class="text-center py-5 d-none">
        <div class="mb-3 text-muted opacity-50">
            <i class="fa-solid fa-magnifying-glass fs-1"></i>
        </div>
        <h5 class="fw-bold text-muted mb-2">Tembang Macapat tidak ditemukan.</h5>
        <p class="text-muted small">Coba gunakan kata kunci nama tembang lain, misalnya: <em>Kinanthi</em>, <em>Pocung</em>, atau <em>Sinom</em>.</p>
    </div>
</div>

<style>
/* Custom Styling Khusus Tembang Macapat */
.macapat-page-container {
    max-width: 1320px;
    margin: 0 auto;
}
.card-top-stripe {
    height: 6px;
    background: linear-gradient(90deg, #1F4D3A 0%, #3B82F6 100%);
}
.hover-elevate {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.hover-elevate:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(31, 77, 58, 0.12) !important;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.search-box {
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}
.search-box:focus-within {
    border-color: #1F4D3A !important;
    box-shadow: 0 0 0 4px rgba(31, 77, 58, 0.15) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('macapatSearchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    const cardCols = document.querySelectorAll('.macapat-card-col');
    const noResults = document.getElementById('noResultsMessage');

    // Realtime Case-Insensitive Search
    searchInput.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();
        let visibleCount = 0;

        if (query.length > 0) {
            clearBtn.classList.remove('d-none');
        } else {
            clearBtn.classList.add('d-none');
        }

        cardCols.forEach(function (card) {
            const name = card.getAttribute('data-name');
            if (name.includes(query)) {
                card.classList.remove('d-none');
                visibleCount++;
            } else {
                card.classList.add('d-none');
            }
        });

        if (visibleCount === 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }
    });

    // Clear Button
    clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
        searchInput.focus();
    });
});

function toggleBookmarkCard(type, id, btn) {
    const icon = btn.querySelector('i');
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
                icon.className = 'fa-solid fa-bookmark text-warning';
                btn.title = 'Batal Simpan';
            } else {
                icon.className = 'fa-regular fa-bookmark text-secondary opacity-60';
                btn.title = 'Simpan Bookmark';
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
<style>
.btn-bookmark-card:hover {
    transform: scale(1.15);
    background-color: #F8FAFC !important;
}
</style>
<script src="{{ asset('js/basakula-search-dropdown.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.BasaKulaSearchDropdown) {
        new BasaKulaSearchDropdown({
            input: '#macapatSearchInput',
            storageKey: 'basakula_history_macapat',
            suggestions: ['Pocung', 'Kinanthi', 'Pangkur', 'Sinom', 'Asmaradana', 'Dhandhanggula', 'Durma', 'Mijil', 'Maskumambang', 'Gambuh', 'Megatruh'],
            onSelect: function (val) {
                const searchInput = document.getElementById('macapatSearchInput');
                if (searchInput) {
                    searchInput.value = val;
                    searchInput.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }
        });
    }
});
</script>
@endsection

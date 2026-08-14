@extends('layouts.app')

@section('title', 'Aksara Jawa - Sinau Basa Jawa')

@section('content')
<div class="aksara-page-container pb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="/ui/student" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Aksara Jawa</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="text-center py-4 mb-4">
        <div class="d-inline-flex align-items-center justify-content-center p-3 bg-soft-blue text-primary rounded-circle mb-3 shadow-sm">
            <i class="fa-solid fa-font fs-2"></i>
        </div>
        <h2 class="fw-bold text-main mb-2 text-uppercase tracking-wide">Aksara Jawa</h2>
        <p class="text-primary fw-semibold mb-1" style="font-size: 1.15rem; font-family: 'Georgia', serif;">
            "Sinau Aksara Jawa kanthi gampang lan nyenengake."
        </p>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            Pelajari bentuk, nama, bunyi, serta contoh kalimat penggunaan Aksara Jawa secara lengkap.
        </p>

        @auth
            @if(auth()->user()->isTeacher())
            <div class="mt-3">
                <a href="{{ route('teacher.javanese-script.index') }}" class="btn btn-warning text-dark rounded-pill px-4 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
                    <i class="fa-solid fa-gear"></i>
                    <span>Mode Pengajar: Kelola / Tambah Aksara</span>
                </a>
            </div>
            @endif
        @endauth
    </div>

    <!-- Search Bar -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-7 col-lg-6 col-xl-5">
            <div class="input-group input-group-lg search-box rounded-pill shadow-sm overflow-hidden bg-white border">
                <span class="input-group-text bg-transparent border-0 ps-4 text-primary">
                    <i class="fa-solid fa-magnifying-glass fs-5"></i>
                </span>
                <input type="text" 
                       id="aksaraSearchInput" 
                       class="form-control border-0 py-3 ps-2 pe-4 bg-transparent" 
                       placeholder="Cari aksara (nama atau latin)..." 
                       aria-label="Cari aksara">
                <button type="button" id="clearAksaraSearchBtn" class="btn bg-transparent border-0 pe-4 text-muted d-none" title="Bersihkan">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Kategori (Pills) -->
    <div class="category-filter-wrapper mb-4 text-center">
        <div class="d-flex flex-wrap justify-content-center gap-2" id="categoryFilterContainer">
            <button type="button" class="btn btn-category active rounded-pill px-4 py-2 fw-semibold shadow-sm" data-category-id="all">
                Semua
            </button>
            @foreach($categories as $cat)
            <button type="button" class="btn btn-category rounded-pill px-4 py-2 fw-semibold shadow-sm" data-category-id="{{ $cat->id }}">
                {{ $cat->name }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Mapping Karakter Unicode Aksara Jawa -->
    @php
        $javaneseGlyphs = [
            // Aksara Nglegena
            'ha' => 'ꦲ', 'na' => 'ꦤ', 'ca' => 'ꦕ', 'ra' => 'ꦫ', 'ka' => 'ꦏ',
            'da' => 'ꦢ', 'ta' => 'ꦠ', 'sa' => 'ꦱ', 'wa' => 'ꦮ', 'la' => 'ꦭ',
            'pa' => 'ꦥ', 'dha' => 'ꦝ', 'ja' => 'ꦗ', 'ya' => 'ꦪ', 'nya' => 'ꦚ',
            'ma' => 'ꦩ', 'ga' => 'ꦒ', 'ba' => 'ꦧ', 'tha' => 'ꦛ', 'nga' => 'ꦔ',
            // Aksara Swara
            'a' => 'ꦄ', 'i' => 'ꦅ', 'u' => 'ꦈ', 'e' => 'ꦌ', 'o' => 'ꦎ',
            // Sandhangan
            'wulu' => '◌ꦶ', 'suku' => '◌ꦸ', 'pepet' => '◌ꦼ', 'taling tarung' => 'ꦺ◌ꦴ',
            'taling' => 'ꦺ◌', 'layar' => '◌ꦂ', 'wignyan' => '◌ꦃ', 'cecak' => '◌ꦁ',
            'pangkon' => '◌꧀', 'pengkal' => '◌ꦾ', 'cakra' => '◌ꦿ', 'cakra keret' => '◌ꦽ',
            'pada adeg-adeg' => '꧋', 'pada lungsi' => '꧉', 'pada lingsa' => '꧈', 'pada pangkat' => '꧇',
            // Pasangan
            'pasangan ha' => '◌꧀ꦲ', 'pasangan na' => '◌꧀ꦤ', 'pasangan ca' => '◌꧀ꦕ', 'pasangan ra' => '◌꧀ꦫ', 'pasangan ka' => '◌꧀ꦏ',
            'pasangan da' => '◌꧀ꦢ', 'pasangan ta' => '◌꧀ꦠ', 'pasangan sa' => '◌꧀ꦱ', 'pasangan wa' => '◌꧀ꦮ', 'pasangan la' => '◌꧀ꦭ',
            'pasangan pa' => '◌꧀ꦥ', 'pasangan dha' => '◌꧀ꦝ', 'pasangan ja' => '◌꧀ꦗ', 'pasangan ya' => '◌꧀ꦪ', 'pasangan nya' => '◌꧀ꦚ',
            'pasangan ma' => '◌꧀ꦩ', 'pasangan ga' => '◌꧀ꦒ', 'pasangan ba' => '◌꧀ꦧ', 'pasangan tha' => '◌꧀ꦛ', 'pasangan nga' => '◌꧀ꦔ',
            // Aksara Murda
            'na murda' => 'ꦟ', 'ka murda' => 'ꦑ', 'ta murda' => 'ꦡ', 'sa murda' => 'ꦯ', 'pa murda' => 'ꦦ', 'ga murda' => 'ꦓ', 'ba murda' => 'ꦨ',
            // Pasangan Aksara Murda
            'pasangan na murda' => '◌꧀ꦟ', 'pasangan ka murda' => '◌꧀ꦑ', 'pasangan ta murda' => '◌꧀ꦡ', 'pasangan sa murda' => '◌꧀ꦯ',
            'pasangan pa murda' => '◌꧀ꦦ', 'pasangan ga murda' => '◌꧀ꦓ', 'pasangan ba murda' => '◌꧀ꦨ',
            // Aksara Rekan
            'kha' => 'ꦏ꦳', 'fa' => 'ꦥ꦳', 'za' => 'ꦗ꦳', 'dza' => 'ꦢ꦳', 'gha' => 'ꦒ꦳',
            // Pasangan Aksara Rekan
            'pasangan kha' => '◌꧀ꦏ꦳', 'pasangan fa' => '◌꧀ꦥ꦳', 'pasangan za' => '◌꧀ꦗ꦳', 'pasangan dza' => '◌꧀ꦢ꦳', 'pasangan gha' => '◌꧀ꦒ꦳',
            // Angka Jawa
            'angka 1' => '꧑', 'angka 2' => '꧒', 'angka 3' => '꧓', 'angka 4' => '꧔', 'angka 5' => '꧕',
            'angka 6' => '꧖', 'angka 7' => '꧗', 'angka 8' => '꧘', 'angka 9' => '꧙', 'angka 0' => '꧐'
        ];
    @endphp

    <!-- Grid Card Aksara Jawa (Responsive: 4 Col Desktop, 2-3 Tablet, 1-2 Mobile) -->
    <div class="row g-3 g-md-4" id="aksaraGrid">
        @forelse($scripts as $item)
        @php
            $key = strtolower(trim($item->name));
            $glyph = $javaneseGlyphs[$key] ?? $item->name;
        @endphp
        <div class="col-6 col-md-4 col-lg-3 col-xl-3 aksara-card-col" 
             data-name="{{ strtolower($item->name) }}" 
             data-latin="{{ strtolower($item->latin) }}" 
             data-category="{{ $item->category_id }}">
            <a href="{{ route('javanese-script.show', $item->id) }}" class="text-decoration-none text-dark d-block h-100">
                <div class="card card-modern h-100 border-0 shadow-sm rounded-4 overflow-hidden aksara-card position-relative text-center">
                    
                    <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-between align-items-center">
                        <!-- Badge Kategori -->
                        <span class="badge bg-light text-muted border rounded-pill px-3 py-1 mb-2 small fw-normal">
                            {{ $item->category->name ?? 'Aksara' }}
                        </span>

                        <!-- Kartu Visual Aksara Jawa (Desain Kartu Flashcard Tradisional) -->
                        <div class="aksara-flashcard w-100 my-2 p-3 rounded-3 position-relative d-flex flex-column align-items-center justify-content-center">
                            <div class="aksara-inner-border position-absolute"></div>
                            <span class="javanese-char-display">{{ $glyph }}</span>
                            <span class="aksara-latin-badge mt-1">{{ strtoupper($item->latin) }}</span>
                        </div>

                        <!-- Informasi Latin & Pelafalan -->
                        <div class="my-2">
                            <h4 class="fw-bold text-main mb-1">{{ $item->name }}</h4>
                            <div class="text-muted small">
                                <span class="d-block"><strong>Latin:</strong> {{ $item->latin }}</span>
                                @if(!empty($item->pronunciation))
                                <span class="d-block text-secondary"><strong>Pelafalan:</strong> /{{ $item->pronunciation }}/</span>
                                @endif
                            </div>
                        </div>

                        <!-- Tombol Detail -->
                        <div class="w-100 mt-auto pt-2 border-top">
                            <span class="btn btn-outline-primary btn-sm rounded-pill w-100 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2">
                                <span>Lihat Detail & Contoh</span>
                                <i class="fa-solid fa-arrow-right small"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fa-solid fa-font fs-1 text-muted mb-3 opacity-50"></i>
            <p class="text-muted mb-0">Belum ada data Aksara Jawa.</p>
        </div>
        @endforelse
    </div>

    <!-- Empty Search State -->
    <div id="noAksaraFound" class="text-center py-5 d-none">
        <div class="mb-3 text-muted opacity-50">
            <i class="fa-solid fa-magnifying-glass fs-1"></i>
        </div>
        <h5 class="fw-bold text-muted mb-2">Tidak ada aksara yang ditemukan.</h5>
        <p class="text-muted small">Coba kata kunci lain atau pilih filter kategori "Semua".</p>
    </div>
</div>

<style>
.aksara-page-container {
    max-width: 1320px;
    margin: 0 auto;
}
.tracking-wide {
    letter-spacing: 0.05em;
}
.search-box {
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}
.search-box:focus-within {
    border-color: #1F4D3A !important;
    box-shadow: 0 0 0 4px rgba(31, 77, 58, 0.15) !important;
}
.btn-category {
    background-color: #f8fafc;
    color: #475569;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
}
.btn-category:hover, .btn-category.active {
    background-color: #1F4D3A;
    color: #ffffff;
    border-color: #1F4D3A;
}
.aksara-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}
.aksara-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(31, 77, 58, 0.12) !important;
    border: 1px solid rgba(31, 77, 58, 0.3) !important;
}

/* Flashcard Aksara Jawa Styling */
.aksara-flashcard {
    background-color: #FBF9F4;
    border: 2px solid #22201D;
    min-height: 140px;
    box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05);
}
.aksara-inner-border {
    top: 6px;
    left: 6px;
    right: 6px;
    bottom: 6px;
    border: 1px solid rgba(34, 32, 29, 0.35);
    border-radius: 4px;
    pointer-events: none;
}
.javanese-char-display {
    font-family: 'Noto Sans Javanese', 'Noto Serif Javanese', 'Segoe UI Historic', 'Tuladha Jejeg', 'Javanese Text', serif;
    font-size: 3.6rem;
    font-weight: 700;
    line-height: 1.1;
    color: #111827;
    z-index: 1;
}
.aksara-latin-badge {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 800;
    letter-spacing: 0.15em;
    color: #374151;
    z-index: 1;
}
</style>

<script>
// Client-side Realtime Search & Category Filter
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('aksaraSearchInput');
    const clearBtn = document.getElementById('clearAksaraSearchBtn');
    const cardCols = document.querySelectorAll('.aksara-card-col');
    const noResults = document.getElementById('noAksaraFound');
    const categoryButtons = document.querySelectorAll('.btn-category');
    
    let activeCategory = 'all';

    function applyFilterAndSearch() {
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        if (query.length > 0) {
            clearBtn.classList.remove('d-none');
        } else {
            clearBtn.classList.add('d-none');
        }

        cardCols.forEach(function (card) {
            const name = card.getAttribute('data-name');
            const latin = card.getAttribute('data-latin');
            const category = card.getAttribute('data-category');

            const matchesCategory = (activeCategory === 'all' || category === activeCategory);
            const matchesSearch = (name.includes(query) || latin.includes(query));

            if (matchesCategory && matchesSearch) {
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
    }

    searchInput.addEventListener('input', applyFilterAndSearch);

    clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        applyFilterAndSearch();
        searchInput.focus();
    });

    categoryButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            categoryButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeCategory = this.getAttribute('data-category-id');
            applyFilterAndSearch();
        });
    });
});
</script>
@endsection

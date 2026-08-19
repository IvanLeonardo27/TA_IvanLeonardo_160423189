@extends('layouts.app')

@section('title', 'Aksara Jawa - BasaKula')

@section('content')
<div class="container-fluid px-0 pb-5">
    <!-- Header Section -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.classroom.index') }}" class="text-decoration-none text-muted">Panel Pembelajaran</a></li>
                    <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Materi Aksara Jawa</li>
                </ol>
            </nav>
            <h2 class="fw-bold text-main mb-1">Materi Aksara Jawa</h2>
            <p class="text-muted mb-0">Eksplorasi kumpulan data aksara Jawa, sandhangan, pasangan, angka, dan contoh kalimatnya.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('javanese-script.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2 bg-white">
                <i class="fa-solid fa-eye"></i>
                <span>Tampilan Interaktif</span>
            </a>
            @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('teacher.javanese-script.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Aksara Baru</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Filter & Pencarian -->
    <div class="card card-modern border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3 p-md-4">
            <form method="GET" action="{{ route('teacher.javanese-script.index') }}" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari nama, latin, atau pelafalan..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="category_id" class="form-select bg-light border-0">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill w-100 fw-semibold">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('teacher.javanese-script.index') }}" class="btn btn-light rounded-pill px-3" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left text-muted"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Mapping Karakter Unicode Aksara Jawa -->
    @php
        $javaneseGlyphs = [
            'ha' => 'ꦲ', 'na' => 'ꦤ', 'ca' => 'ꦕ', 'ra' => 'ꦫ', 'ka' => 'ꦏ',
            'da' => 'ꦢ', 'ta' => 'ꦠ', 'sa' => 'ꦱ', 'wa' => 'ꦮ', 'la' => 'ꦭ',
            'pa' => 'ꦥ', 'dha' => 'ꦝ', 'ja' => 'ꦗ', 'ya' => 'ꦪ', 'nya' => 'ꦚ',
            'ma' => 'ꦩ', 'ga' => 'ꦒ', 'ba' => 'ꦧ', 'tha' => 'ꦛ', 'nga' => 'ꦔ',
            'a' => 'ꦄ', 'i' => 'ꦅ', 'u' => 'ꦈ', 'e' => 'ꦌ', 'o' => 'ꦎ',
            'wulu' => '◌ꦶ', 'suku' => '◌ꦸ', 'pepet' => '◌ꦼ', 'taling tarung' => 'ꦺ◌ꦴ',
            'taling' => 'ꦺ◌', 'layar' => '◌ꦂ', 'wignyan' => '◌ꦃ', 'cecak' => '◌ꦁ',
            'pangkon' => '◌꧀', 'pengkal' => '◌ꦾ', 'cakra' => '◌ꦿ', 'cakra keret' => '◌ꦽ',
            'pada adeg-adeg' => '꧋', 'pada lungsi' => '꧉', 'pada lingsa' => '꧈', 'pada pangkat' => '꧇',
            'pasangan ha' => '◌꧀ꦲ', 'pasangan na' => '◌꧀ꦤ', 'pasangan ca' => '◌꧀ꦕ', 'pasangan ra' => '◌꧀ꦫ', 'pasangan ka' => '◌꧀ꦏ',
            'pasangan da' => '◌꧀ꦢ', 'pasangan ta' => '◌꧀ꦠ', 'pasangan sa' => '◌꧀ꦱ', 'pasangan wa' => '◌꧀ꦮ', 'pasangan la' => '◌꧀ꦭ',
            'pasangan pa' => '◌꧀ꦥ', 'pasangan dha' => '◌꧀ꦝ', 'pasangan ja' => '◌꧀ꦗ', 'pasangan ya' => '◌꧀ꦪ', 'pasangan nya' => '◌꧀ꦚ',
            'pasangan ma' => '◌꧀ꦩ', 'pasangan ga' => '◌꧀ꦒ', 'pasangan ba' => '◌꧀ꦧ', 'pasangan tha' => '◌꧀ꦛ', 'pasangan nga' => '◌꧀ꦔ',
            'na murda' => 'ꦟ', 'ka murda' => 'ꦑ', 'ta murda' => 'ꦡ', 'sa murda' => 'ꦯ', 'pa murda' => 'ꦦ', 'ga murda' => 'ꦓ', 'ba murda' => 'ꦨ',
            'pasangan na murda' => '◌꧀ꦟ', 'pasangan ka murda' => '◌꧀ꦑ', 'pasangan ta murda' => '◌꧀ꦡ', 'pasangan sa murda' => '◌꧀ꦯ',
            'pasangan pa murda' => '◌꧀ꦦ', 'pasangan ga murda' => '◌꧀ꦓ', 'pasangan ba murda' => '◌꧀ꦨ',
            'kha' => 'ꦏ꦳', 'fa' => 'ꦥ꦳', 'za' => 'ꦗ꦳', 'dza' => 'ꦢ꦳', 'gha' => 'ꦒ꦳',
            'pasangan kha' => '◌꧀ꦏ꦳', 'pasangan fa' => '◌꧀ꦥ꦳', 'pasangan za' => '◌꧀ꦗ꦳', 'pasangan dza' => '◌꧀ꦢ꦳', 'pasangan gha' => '◌꧀ꦒ꦳',
            'angka 1' => '꧑', 'angka 2' => '꧒', 'angka 3' => '꧓', 'angka 4' => '꧔', 'angka 5' => '꧕',
            'angka 6' => '꧖', 'angka 7' => '꧗', 'angka 8' => '꧘', 'angka 9' => '꧙', 'angka 0' => '꧐'
        ];
    @endphp

    <!-- Grid Kartu Aksara Jawa -->
    <div class="row g-4 mb-4">
        @forelse($scripts as $item)
        @php
            $key = strtolower(trim($item->latin));
            $glyph = $javaneseGlyphs[$key] ?? ($javaneseGlyphs[strtolower(trim($item->name))] ?? 'ꦲ');
            $example = $item->examples->first();
        @endphp
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card card-modern h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Kategori Badge -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">
                                {{ $item->category->name ?? 'Aksara' }}
                            </span>
                            @if(auth()->check() && auth()->user()->isAdmin())
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light rounded-circle p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 28px; height: 28px;">
                                    <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('teacher.javanese-script.edit', $item->id) }}">
                                            <i class="fa-solid fa-pen-to-square text-warning me-2"></i> Edit Data
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('teacher.javanese-script.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Aksara {{ $item->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fa-solid fa-trash me-2"></i> Hapus Aksara
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </div>

                        <!-- Flashcard Mini Display -->
                        <div class="teacher-flashcard p-2 rounded-3 text-center my-2 position-relative bg-light border">
                            <span class="javanese-char-teacher">{{ $glyph }}</span>
                            <div class="small fw-bold text-muted mt-1">{{ strtoupper($item->latin) }}</div>
                        </div>

                        <!-- Informasi Aksara -->
                        <div class="text-center my-2">
                            <h5 class="fw-bold text-main mb-1">{{ $item->name }}</h5>
                            <small class="text-muted d-block">Latin: <strong>{{ $item->latin }}</strong> | Bunyi: /{{ $item->pronunciation ?? $item->latin }}/</small>
                        </div>

                        <!-- Contoh Kalimat Snippet -->
                        @if($example)
                        <div class="p-2 bg-light rounded-3 small mt-2">
                            <small class="text-muted fw-bold d-block" style="font-size: 0.7rem;">Contoh Kalimat:</small>
                            <span class="d-block text-truncate text-secondary fw-semibold fst-italic">"{{ $example->javanese_latin_text }}"</span>
                            <span class="d-block text-truncate text-muted" style="font-size: 0.75rem;">{{ $example->indonesian_text }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Tombol Aksi Bawah -->
                    <div class="mt-3 pt-2 border-top">
                        @if(auth()->check() && auth()->user()->isAdmin())
                        <div class="d-flex gap-2">
                            <a href="{{ route('teacher.javanese-script.edit', $item->id) }}" class="btn btn-outline-warning btn-sm rounded-pill w-50 fw-semibold">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('teacher.javanese-script.destroy', $item->id) }}" class="w-50" onsubmit="return confirm('Hapus aksara {{ $item->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill w-100 fw-semibold">
                                    <i class="fa-solid fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                        @else
                        <a href="{{ route('javanese-script.show', $item->id) }}" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-semibold py-1.5">
                            <i class="fa-solid fa-book-open me-1.5"></i> Pelajari Aksara
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fa-solid fa-folder-open fs-1 text-muted opacity-50 mb-3"></i>
            <h5 class="fw-bold text-muted">Tidak ada data Aksara Jawa ditemukan.</h5>
            <p class="text-muted small">Silakan sesuaikan kata kunci pencarian.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $scripts->links() }}
    </div>
</div>

<style>
.teacher-flashcard {
    background-color: #FBF9F4 !important;
    border: 2px solid #22201D !important;
    min-height: 100px;
}
.javanese-char-teacher {
    font-family: 'Noto Sans Javanese', 'Noto Serif Javanese', 'Segoe UI Historic', 'Tuladha Jejeg', 'Javanese Text', serif;
    font-size: 2.8rem;
    font-weight: 700;
    line-height: 1.1;
    color: #111827;
}
</style>
@endsection

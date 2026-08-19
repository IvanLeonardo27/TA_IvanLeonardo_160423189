@extends('layouts.app')

@section('title', 'Aksara ' . $script->name . ' - Sinau Basa Jawa')

@section('content')
<div class="aksara-detail-container pb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="/ui/student" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('javanese-script.index') }}" class="text-decoration-none text-muted">Aksara Jawa</a></li>
            <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">{{ $script->name }}</li>
        </ol>
    </nav>

    <!-- Tombol Kembali & Aksi Pengajar -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <a href="{{ route('javanese-script.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2 bg-white">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Katalog Aksara</span>
        </a>

        @auth
            @if(auth()->user()->isAdmin())
            <div class="d-flex gap-2">
                <a href="{{ route('teacher.javanese-script.edit', $script->id) }}" class="btn btn-warning text-dark rounded-pill px-4 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Edit Aksara Ini</span>
                </a>
                <form method="POST" action="{{ route('teacher.javanese-script.destroy', $script->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Aksara {{ $script->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-pill px-4 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-trash"></i>
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
            @endif
        @endauth
    </div>

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
        $key = strtolower(trim($script->name));
        $glyph = $javaneseGlyphs[$key] ?? $script->name;
    @endphp

    <!-- Main Detail Card -->
    <div class="card card-modern border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <!-- Top Banner Header -->
        <div class="p-4 p-md-5 text-white position-relative text-center" style="background: linear-gradient(135deg, #1F4D3A 0%, #2b6c51 100%);">
            <span class="badge bg-white text-primary rounded-pill px-3 py-2 mb-3 fw-semibold shadow-sm">
                {{ $script->category->name ?? 'Aksara Jawa' }}
            </span>
            <h1 class="fw-bold mb-1 text-uppercase text-white tracking-wide display-5">{{ $script->name }}</h1>
            <p class="mb-0 text-white-50 fs-5">Karakter & Contoh Kalimat Penggunaan</p>
        </div>

        <div class="card-body p-4 p-md-5">
            <!-- Informasi Utama Aksara -->
            <div class="row align-items-center g-4 g-lg-5 mb-5">
                <!-- Kolom Kiri: Display Aksara Besar (Flashcard Format) -->
                <div class="col-md-5 text-center">
                    <div class="aksara-large-flashcard p-4 rounded-4 shadow-sm position-relative d-flex flex-column align-items-center justify-content-center">
                        <div class="aksara-large-inner-border position-absolute"></div>
                        <span class="display-1 fw-bold text-dark javanese-large-char my-2">{{ $glyph }}</span>
                        <span class="aksara-large-latin-badge mt-2">{{ strtoupper($script->latin) }}</span>
                    </div>
                </div>

                <!-- Kolom Kanan: Informasi Latin, Pelafalan & Kategori -->
                <div class="col-md-7">
                    <div class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-center">
                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted fw-semibold d-block">Nama Aksara</small>
                            <h2 class="fw-bold text-main mb-0">{{ $script->name }}</h2>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block">Huruf Latin</small>
                                    <span class="fs-5 fw-bold text-dark">{{ $script->latin }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block">Pelafalan Bunyi</small>
                                    <span class="fs-5 fw-bold text-primary">/{{ $script->pronunciation ?? $script->latin }}/</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block">Kategori</small>
                            <span class="fw-bold text-secondary">{{ $script->category->name ?? 'Aksara Jawa' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi Aksara -->
            @if(!empty($script->description))
            <div class="mb-5">
                <div class="p-4 bg-light rounded-4 border">
                    <h5 class="fw-bold text-main mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-book-open text-primary"></i>
                        <span>Penjelasan Aksara</span>
                    </h5>
                    <p class="text-secondary mb-0 leading-relaxed" style="font-size: 1.05rem; line-height: 1.8;">
                        {{ $script->description }}
                    </p>
                </div>
            </div>
            @endif

            <!-- CONTOH PENGGUNAAN DALAM KALIMAT (Aksara Jawa, Latin Jawa & Bahasa Indonesia) -->
            <div class="mb-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="p-2 bg-soft-blue text-primary rounded-circle">
                        <i class="fa-solid fa-feather-pointed fs-5"></i>
                    </div>
                    <h4 class="fw-bold text-main mb-0">Tuladha / Contoh Penggunaan Kalimat</h4>
                </div>

                @if($script->examples && $script->examples->count() > 0)
                    <div class="row g-3">
                        @foreach($script->examples as $index => $example)
                        <div class="col-12">
                            <div class="p-4 bg-white rounded-4 border border-2 border-primary-subtle shadow-sm">
                                <!-- Kalimat Aksara Jawa -->
                                <div class="mb-3 p-3 bg-light rounded-3 text-center">
                                    <small class="text-muted fw-semibold d-block mb-1 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Ukara Aksara Jawa</small>
                                    <div class="javanese-sentence-display text-primary fw-bold">
                                        {{ $example->javanese_script_text }}
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <!-- Latin Bahasa Jawa -->
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3 h-100">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="badge bg-primary text-white rounded-pill px-2 py-1 small">Basa Jawa</span>
                                                <small class="text-muted fw-semibold">Waosan Latin</small>
                                            </div>
                                            <p class="mb-0 fw-semibold text-dark fs-6 fst-italic">
                                                "{{ $example->javanese_latin_text }}"
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Terjemahan Bahasa Indonesia -->
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3 h-100">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="badge bg-success text-white rounded-pill px-2 py-1 small">Indonesia</span>
                                                <small class="text-muted fw-semibold">Terjemahan</small>
                                            </div>
                                            <p class="mb-0 text-secondary fs-6">
                                                "{{ $example->indonesian_text }}"
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-light rounded-4 border text-center text-muted">
                        <i class="fa-solid fa-circle-info fs-3 mb-2 d-block opacity-50"></i>
                        <p class="mb-0">Contoh kalimat untuk aksara ini sedang disusun.</p>
                    </div>
                @endif
            </div>

            <!-- Navigasi Aksara Sebelumnya & Berikutnya dalam Kategori yang sama -->
            <div class="pt-4 border-top d-flex justify-content-between align-items-center">
                @if($previousScript)
                    <a href="{{ route('javanese-script.show', $previousScript->id) }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span>Sebelumnya: <strong>{{ $previousScript->name }}</strong></span>
                    </a>
                @else
                    <button class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2" disabled>
                        <i class="fa-solid fa-chevron-left"></i>
                        <span>Aksara Pertama</span>
                    </button>
                @endif

                @if($nextScript)
                    <a href="{{ route('javanese-script.show', $nextScript->id) }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
                        <span>Berikutnya: <strong>{{ $nextScript->name }}</strong></span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <button class="btn btn-secondary rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2" disabled>
                        <span>Aksara Terakhir</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.aksara-detail-container {
    max-width: 1100px;
    margin: 0 auto;
}
.tracking-wide {
    letter-spacing: 0.05em;
}
.aksara-large-flashcard {
    background-color: #FBF9F4;
    border: 3px solid #22201D;
    min-height: 240px;
}
.aksara-large-inner-border {
    top: 8px;
    left: 8px;
    right: 8px;
    bottom: 8px;
    border: 1.5px solid rgba(34, 32, 29, 0.4);
    border-radius: 8px;
    pointer-events: none;
}
.javanese-large-char {
    font-family: 'Noto Sans Javanese', 'Noto Serif Javanese', 'Segoe UI Historic', 'Tuladha Jejeg', 'Javanese Text', serif;
    font-size: 5.5rem;
    line-height: 1;
    z-index: 1;
}
.aksara-large-latin-badge {
    font-family: 'Inter', sans-serif;
    font-size: 1.1rem;
    font-weight: 800;
    letter-spacing: 0.2em;
    color: #374151;
    z-index: 1;
}
.javanese-sentence-display {
    font-family: 'Noto Sans Javanese', 'Noto Serif Javanese', 'Segoe UI Historic', 'Tuladha Jejeg', 'Javanese Text', serif;
    font-size: 2rem;
    line-height: 1.5;
    letter-spacing: 0.02em;
}
</style>
@endsection

@extends('layouts.app')

@section('title', 'Edit Aksara ' . $script->name . ' - Panel Pengajar')

@section('content')
<div class="container-fluid px-0 pb-5" style="max-width: 900px;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('teacher.classroom.index') }}" class="text-decoration-none text-muted">Panel Pengajar</a></li>
            <li class="breadcrumb-item"><a href="{{ route('teacher.javanese-script.index') }}" class="text-decoration-none text-muted">Kelola Aksara Jawa</a></li>
            <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Edit {{ $script->name }}</li>
        </ol>
    </nav>

    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="{{ route('teacher.javanese-script.index') }}" class="btn btn-outline-secondary rounded-pill px-3 py-1 text-sm shadow-sm bg-white">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card card-modern border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-warning-subtle text-dark p-4 border-bottom">
            <h4 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i> Edit Data Aksara: {{ $script->name }}</h4>
            <p class="mb-0 text-muted small">Perbarui data karakter aksara, pelafalan, atau contoh kalimat penggunaannya.</p>
        </div>

        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('teacher.javanese-script.update', $script->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h5 class="fw-bold text-main mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-font text-primary me-2"></i> 1. Informasi Aksara
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kategori Aksara <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $script->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Aksara <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $script->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Huruf Latin <span class="text-danger">*</span></label>
                        <input type="text" name="latin" class="form-control @error('latin') is-invalid @enderror" value="{{ old('latin', $script->latin) }}" required>
                        @error('latin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Pelafalan Bunyi</label>
                        <input type="text" name="pronunciation" class="form-control @error('pronunciation') is-invalid @enderror" value="{{ old('pronunciation', $script->pronunciation) }}">
                        @error('pronunciation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Penjelasan / Deskripsi</label>
                        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $script->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Perbarui Gambar / Vektor Aksara (Opsional)</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept=".svg,.png,.jpg,.jpeg,.webp">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar yang sudah ada.</small>
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="fw-bold text-main mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-feather-pointed text-primary me-2"></i> 2. Contoh Kalimat Penggunaan
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Ukara Aksara Jawa (Teks Kalimat Aksara)</label>
                        <input type="text" name="javanese_script_text" class="form-control @error('javanese_script_text') is-invalid @enderror" value="{{ old('javanese_script_text', $example->javanese_script_text ?? '') }}">
                        @error('javanese_script_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Waosan Latin Basa Jawa</label>
                        <input type="text" name="javanese_latin_text" class="form-control @error('javanese_latin_text') is-invalid @enderror" value="{{ old('javanese_latin_text', $example->javanese_latin_text ?? '') }}">
                        @error('javanese_latin_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Terjemahan Bahasa Indonesia</label>
                        <input type="text" name="indonesian_text" class="form-control @error('indonesian_text') is-invalid @enderror" value="{{ old('indonesian_text', $example->indonesian_text ?? '') }}">
                        @error('indonesian_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Penataan Waosan Latin per Suku Kata --}}
                    <div class="col-12 mt-3">
                        <div class="card border rounded-4 bg-light shadow-2xs overflow-hidden">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <span class="fw-bold text-main d-block" style="font-size: 0.95rem;">
                                        <i class="fa-solid fa-layer-group text-primary me-1.5"></i> Penataan Waosan Latin per Suku Kata (Interlinear)
                                    </span>
                                    <small class="text-muted">Waosan Latin akan tampil tepat di bawah aksara masing-masing. Anda dapat menyesuaikannya bila diperlukan.</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold shadow-xs" id="btnAutoGenerateSyllables">
                                    <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Sinkronkan dari Teks
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <input type="hidden" name="syllable_breakdown" id="syllableBreakdownInput" value="{{ old('syllable_breakdown', isset($example) && $example->syllable_breakdown ? json_encode($example->syllable_breakdown) : '') }}">
                                
                                <div id="syllablesPreviewContainer" class="d-flex flex-wrap align-items-end gap-2 p-3 bg-white rounded-3 border" style="min-height: 85px;">
                                    <!-- Rendered dynamically -->
                                </div>
                                <small class="text-muted d-block mt-2 fst-italic">
                                    <i class="fa-solid fa-lightbulb text-warning me-1"></i> Tip: Klik tombol <strong>"Sinkronkan dari Teks"</strong> untuk membaca teks aksara di atas. Anda dapat mengubah suku kata Latin pada tiap kotak kecil di atas.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('teacher.javanese-script.index') }}" class="btn btn-light rounded-pill px-4 fw-semibold">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-semibold shadow-sm">
                        <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const scriptInput = document.querySelector('input[name="javanese_script_text"]');
    const hiddenInput = document.getElementById('syllableBreakdownInput');
    const container   = document.getElementById('syllablesPreviewContainer');
    const btnSync     = document.getElementById('btnAutoGenerateSyllables');

    const consonantMap = {
        'ꦲ': 'h', 'ꦤ': 'n', 'ꦕ': 'c', 'ꦫ': 'r', 'ꦏ': 'k',
        'ꦢ': 'd', 'ꦠ': 't', 'ꦱ': 's', 'ꦮ': 'w', 'ꦭ': 'l',
        'ꦥ': 'p', 'ꦝ': 'dh', 'ꦗ': 'j', 'ꦪ': 'y', 'ꦚ': 'ny',
        'ꦩ': 'm', 'ꦒ': 'g', 'ꦧ': 'b', 'ꦛ': 'th', 'ꦔ': 'ng',
        'ꦟ': 'n', 'ꦑ': 'k', 'ꦡ': 't', 'ꦯ': 's', 'ꦦ': 'p', 'ꦓ': 'g', 'ꦨ': 'b',
        'ꦄ': 'a', 'ꦅ': 'i', 'ꦈ': 'u', 'ꦌ': 'e', 'ꦎ': 'o', 'ꦉ': 're', 'ꦊ': 'le',
        '꧐': '0', '꧑': '1', '꧒': '2', '꧓': '3', '꧔': '4',
        '꧕': '5', '꧖': '6', '꧗': '7', '꧘': '8', '꧙': '9'
    };

    function splitJavaneseClusters(text) {
        if (!text) return [];
        const regex = /(?:[\uA984-\uA9B2\uA9D0-\uA9D9]\uA9B3?(?:\uA9C0[\uA984-\uA9B2]\uA9B3?)?[\uA9BD-\uA9BF]?[\uA9B4-\uA9BC]*[\uA980-\uA983]*(?:\uA9C0)?|[\uA9C1-\uA9CF]|[^\uA980-\uA9DF\s]+|\s+)/gu;
        const matches = text.match(regex);
        return matches ? matches.filter(c => c !== '') : [];
    }

    function clusterToLatinApprox(cluster) {
        const trimmed = cluster.trim();
        if (!trimmed) return '';
        const numbers = {'꧐': '0', '꧑': '1', '꧒': '2', '꧓': '3', '꧔': '4', '꧕': '5', '꧖': '6', '꧗': '7', '꧘': '8', '꧙': '9', '꧈': ',', '꧉': '.', '꧇': ':'};
        if (numbers[trimmed] !== undefined) return numbers[trimmed];

        let base = '', pasangan = '', medial = '', vowel = 'a', finalConsonant = '', isDead = false;
        let clusterNoPangkon = trimmed;
        if (trimmed.endsWith('꧀')) {
            isDead = true;
            clusterNoPangkon = trimmed.slice(0, -1);
        }

        const hasTaling = trimmed.includes('ꦺ');
        const hasTarung = trimmed.includes('ꦴ');
        const hasWulu = trimmed.includes('ꦶ') || trimmed.includes('ꦷ');
        const hasSuku = trimmed.includes('ꦸ') || trimmed.includes('ꦹ');
        const hasPepet = trimmed.includes('ꦼ');
        const hasDirgaMure = trimmed.includes('ꦻ');

        if (hasDirgaMure && hasTarung) vowel = 'au';
        else if (hasTaling && hasTarung) vowel = 'o';
        else if (hasDirgaMure) vowel = 'ai';
        else if (hasTaling || hasPepet) vowel = 'e';
        else if (hasWulu) vowel = 'i';
        else if (hasSuku) vowel = 'u';
        else if (hasTarung) vowel = 'a';

        if (trimmed.includes('ꦾ')) medial = 'y';
        if (trimmed.includes('ꦿ')) medial = 'r';
        if (trimmed.includes('ꦽ')) { medial = 'r'; vowel = 'e'; }

        if (trimmed.includes('ꦁ')) finalConsonant = 'ng';
        if (trimmed.includes('ꦂ')) finalConsonant = 'r';
        if (trimmed.includes('ꦃ')) finalConsonant = 'h';

        const pMatch = clusterNoPangkon.match(/꧀([\uA984-\uA9B2])/u);
        if (pMatch && consonantMap[pMatch[1]]) pasangan = consonantMap[pMatch[1]];

        const bMatch = trimmed.match(/^[\uA9C0]?([\uA984-\uA9B2])/u);
        if (bMatch && consonantMap[bMatch[1]]) base = consonantMap[bMatch[1]];
        if (base === 'h') base = '';

        if (pasangan) {
            return (base || '') + pasangan + medial + (isDead ? '' : vowel) + finalConsonant;
        } else {
            return base + medial + (isDead ? '' : vowel) + finalConsonant;
        }
    }

    function renderSyllables(data) {
        container.innerHTML = '';
        if (!data || data.length === 0) {
            container.innerHTML = '<span class="text-muted small fst-italic py-2">Belum ada suku kata terdeteksi. Isi teks aksara di atas lalu klik Sinkronkan.</span>';
            return;
        }

        data.forEach((item, index) => {
            if (item.aksara === ' ' || (item.aksara.trim() === '' && item.latin.trim() === '')) {
                const spaceDiv = document.createElement('div');
                spaceDiv.className = 'mx-1';
                spaceDiv.style.width = '12px';
                container.appendChild(spaceDiv);
                return;
            }

            const card = document.createElement('div');
            card.className = 'd-inline-flex flex-column align-items-center p-2 rounded-3 border bg-light shadow-2xs';
            card.innerHTML = `
                <span class="fs-4 fw-bold text-primary mb-1" style="font-family:'Noto Sans Javanese', serif; line-height:1.2;">${item.aksara}</span>
                <input type="text" class="form-control form-control-sm text-center fw-bold p-1 latin-input" 
                       value="${item.latin}" style="width: 58px; font-size: 0.84rem; background:#ffffff;" data-index="${index}">
            `;
            container.appendChild(card);
        });

        // Event listener update hidden JSON
        container.querySelectorAll('.latin-input').forEach(input => {
            input.addEventListener('input', function () {
                const idx = parseInt(this.dataset.index);
                if (data[idx]) {
                    data[idx].latin = this.value;
                    hiddenInput.value = JSON.stringify(data);
                }
            });
        });

        hiddenInput.value = JSON.stringify(data);
    }

    function generateFromScript() {
        const text = scriptInput ? scriptInput.value.trim() : '';
        if (!text) {
            renderSyllables([]);
            return;
        }
        const clusters = splitJavaneseClusters(text);
        const data = clusters.map(c => ({
            aksara: c,
            latin: clusterToLatinApprox(c)
        }));
        renderSyllables(data);
    }

    if (btnSync) {
        btnSync.addEventListener('click', generateFromScript);
    }

    // Initial load
    let initialData = [];
    try {
        if (hiddenInput && hiddenInput.value) {
            initialData = JSON.parse(hiddenInput.value);
        }
    } catch (e) {
        initialData = [];
    }

    if (initialData && initialData.length > 0) {
        renderSyllables(initialData);
    } else if (scriptInput && scriptInput.value.trim()) {
        generateFromScript();
    } else {
        renderSyllables([]);
    }
});
</script>
@endpush

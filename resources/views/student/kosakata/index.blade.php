@extends('layouts.app')

@section('title', 'Kamus Kosakata Basa Jawa')

@section('content')
{{-- Header Area & Modern Clean Search Engine --}}
<div class="row mb-4 align-items-center g-3">
    <div class="col-xl-5 col-lg-4">
        <h3 class="fw-bold text-main mb-1">
            <i class="fa-solid fa-book-journal-whills text-primary me-2"></i>Kamus Basa Jawa
        </h3>
        <p class="text-muted mb-0 small">Kamus kosakata Bahasa Jawa (Ngoko & Krama) diurutkan berurutan secara Abjad (A-Z).</p>
    </div>
    
    <div class="col-xl-7 col-lg-8">
        <form action="{{ url('/ui/kosakata') }}" method="GET" id="searchFilterForm">
            <div class="p-2 bg-white rounded-4 shadow-sm border border-light">
                <div class="row g-2 align-items-center">
                    {{-- Input Cari Kata --}}
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0 text-muted ps-3 pe-1">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-0 ps-1 py-2"
                                   placeholder="Cari kata (Indonesia / Ngoko / Krama)..."
                                   value="{{ request('search') }}" id="searchInput" style="box-shadow: none;" autocomplete="off">
                        </div>
                    </div>
                    
                    {{-- Filter Dropdown Kategori --}}
                    <div class="col-12 col-sm-6 col-md-4 border-start-custom">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0 text-primary ps-2 pe-1">
                                <i class="fa-solid fa-tags"></i>
                            </span>
                            <select name="category_id" class="form-select border-0 bg-transparent fw-semibold text-main py-2 pe-4" onchange="this.form.submit()" style="box-shadow: none; cursor: pointer;">
                                <option value="">Semua Kategori ({{ $categories->count() }})</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }} ({{ $cat->vocabularies_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tombol Cari & Reset --}}
                    <div class="col-12 col-md-2 d-flex gap-1 justify-content-end">
                        <button type="submit" class="btn btn-primary rounded-3 px-3 py-2 fw-semibold flex-grow-1" title="Cari">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        @if(request('search') || request('category_id'))
                            <a href="{{ url('/ui/kosakata') }}" class="btn btn-soft-danger rounded-3 px-3 py-2 text-danger" title="Reset Filter">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Sub-header info filter & audio settings --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 p-3 bg-white rounded-4 shadow-sm border border-light">
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-soft-blue text-primary rounded-pill px-3 py-2 fw-bold">
            <i class="fa-solid fa-arrow-down-a-z me-1"></i> Urutan Abjad (A-Z)
        </span>
        @if($selectedCategory)
            <span class="badge bg-warning bg-opacity-20 text-dark rounded-pill px-3 py-2 fw-semibold">
                <i class="fa-solid fa-tag me-1"></i> Filter: {{ $selectedCategory->name }}
            </span>
        @endif
    </div>

    @auth
        @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-primary rounded-pill px-3 py-1 fw-semibold d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addVocabModal">
                <i class="fa-solid fa-plus-circle"></i> Tambah Kata
            </button>
        </div>
        @endif
    @endauth
</div>


{{-- Container Daftar Kosakata --}}
<div class="row g-4" id="vocabListContainer">
    @include('student.kosakata._vocab_items')
</div>

{{-- Area Tombol "Tampilkan Lebih Banyak / Load More" --}}
<div class="text-center mt-5 mb-4" id="loadMoreContainer">
    @if($vocabularies->hasMorePages())
        <button id="btnLoadMore" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm btn-bouncy" data-next-url="{{ $vocabularies->nextPageUrl() }}">
            <i class="fa-solid fa-angle-down me-2"></i> Tampilkan Lebih Banyak (See More)
        </button>
    @else
        <div class="p-3 bg-white rounded-pill d-inline-block shadow-sm border border-light text-muted small fw-semibold">
            <i class="fa-solid fa-check-circle text-success me-1"></i> Semua kosakata telah ditampilkan (Total: {{ $vocabularies->total() }} kata)
        </div>
    @endif
</div>

{{-- Modal Tambah Kosakata (Pengajar & Admin) --}}
@auth
@if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
<div class="modal fade" id="addVocabModal" tabindex="-1" aria-labelledby="addVocabModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4 p-4">
                <h5 class="modal-title fw-bold" id="addVocabModalLabel">
                    <i class="fa-solid fa-plus-circle me-2"></i>Tambah Kosakata Baru (Pengajar)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kosakata.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kata Bahasa Indonesia <span class="text-danger">*</span></label>
                            <input type="text" name="indonesian_word" class="form-control rounded-3" placeholder="Contoh: Belajar" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategori Kosakata</label>
                            <select name="category_id" class="form-select rounded-3">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Javanese Ngoko <span class="text-danger">*</span></label>
                            <input type="text" name="javanese_ngoko" class="form-control rounded-3" placeholder="Contoh: Sinau" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Javanese Krama <span class="text-danger">*</span></label>
                            <input type="text" name="javanese_krama" class="form-control rounded-3" placeholder="Contoh: Sinau / Piwulang" required>
                        </div>
                        
                        <hr class="my-3 text-muted">
                        <h6 class="fw-bold text-main mb-2">Contoh Penggunaan Kalimat</h6>
                        
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted">Contoh Kalimat (Indonesia)</label>
                            <input type="text" name="example_indonesian" class="form-control rounded-3" placeholder="Contoh: Saya sedang belajar Bahasa Jawa.">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Contoh Kalimat (Ngoko)</label>
                            <input type="text" name="example_ngoko" class="form-control rounded-3" placeholder="Contoh: Aku lagi sinau Basa Jawa.">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Contoh Kalimat (Krama)</label>
                            <input type="text" name="example_krama" class="form-control rounded-3" placeholder="Contoh: Kula saweg sinau Basa Jawi.">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4 p-3">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold"><i class="fa-solid fa-save me-1"></i> Simpan Kosakata</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth
@endsection

@push('styles')
<style>
@media (min-width: 576px) {
    .border-start-custom {
        border-left: 1px solid rgba(0, 0, 0, 0.08) !important;
    }
}
.btn-soft-danger {
    background-color: rgba(220, 53, 69, 0.1);
    border: none;
}
.btn-soft-danger:hover {
    background-color: rgba(220, 53, 69, 0.2);
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnLoadMore = document.getElementById('btnLoadMore');
        const vocabContainer = document.getElementById('vocabListContainer');
        const loadMoreContainer = document.getElementById('loadMoreContainer');

        // Function binding untuk Audio TTS
        function initTtsButtons() {
            const voiceSelect = document.getElementById('ttsVoiceSelect');
            document.querySelectorAll('.btn-speak').forEach(button => {
                if (button.dataset.bound) return;
                button.dataset.bound = "true";

                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const textToSpeak = this.getAttribute('data-text');
                    if (!textToSpeak) return;

                    const icon = this.querySelector('i');
                    const originalClass = icon.className;
                    icon.className = 'fa-solid fa-spinner fa-spin text-primary';

                    const selectedVoice = voiceSelect ? voiceSelect.value : 'female';
                    const audioUrl = `{{ url('/api/tts') }}?text=${encodeURIComponent(textToSpeak)}&gender=${selectedVoice}`;
                    const audio = new Audio(audioUrl);
                    audio.playbackRate = 0.85;

                    audio.onplay = function() {
                        icon.className = 'fa-solid fa-volume-high text-success';
                    };
                    audio.onended = function() {
                        icon.className = originalClass;
                    };
                    audio.onerror = function() {
                        icon.className = originalClass;
                    };
                    audio.play().catch(() => {
                        icon.className = originalClass;
                    });
                });
            });
        }

        initTtsButtons();

        // AJAX Load More "Tampilkan Lebih Banyak"
        if (btnLoadMore) {
            btnLoadMore.addEventListener('click', function() {
                const nextUrl = this.getAttribute('data-next-url');
                if (!nextUrl) return;

                const originalText = this.innerHTML;
                this.disabled = true;
                this.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Memuat kosakata...';

                fetch(nextUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Append HTML baru ke container
                    vocabContainer.insertAdjacentHTML('beforeend', data.html);

                    // Re-bind TTS untuk elemen baru
                    initTtsButtons();

                    // Update next page URL atau sembunyikan tombol jika sudah habis
                    if (data.has_more) {
                        btnLoadMore.setAttribute('data-next-url', data.next_page_url);
                        btnLoadMore.disabled = false;
                        btnLoadMore.innerHTML = originalText;
                    } else {
                        loadMoreContainer.innerHTML = `
                            <div class="p-3 bg-white rounded-pill d-inline-block shadow-sm border border-light text-muted small fw-semibold animate__animated animate__fadeIn">
                                <i class="fa-solid fa-check-circle text-success me-1"></i> Semua kosakata telah ditampilkan (Total: ${data.total} kata)
                            </div>
                        `;
                    }
                })
                .catch(err => {
                    console.error('Error loading more vocabulary:', err);
                    btnLoadMore.disabled = false;
                    btnLoadMore.innerHTML = originalText;
                });
            });
        }
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
<script src="{{ asset('js/basakula-search-dropdown.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.BasaKulaSearchDropdown) {
        new BasaKulaSearchDropdown({
            input: '#searchInput',
            storageKey: 'basakula_history_vocab',
            suggestions: ['Sugeng', 'Matur Nuwun', 'Ngapura', 'Dheweke', 'Mangan / Dahar', 'Turu / Sare', 'Mlaku', 'Keluarga', 'Angka Sembilan']
        });
    }
});
</script>
@endpush

@extends('layouts.app')

@section('title', 'Tembang ' . $category->name . ' - Sinau Basa Jawa')

@section('content')
<div class="macapat-detail-container pb-5">
    <!-- Tombol Kembali & Bookmark -->
    <div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap">
        <a href="{{ route('macapat.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2 bg-white">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Tembang Macapat</span>
        </a>

        @auth
        @php
            $isBookmarked = \App\Models\Bookmark::where('user_id', auth()->id())
                ->where('bookmarkable_type', \App\Models\MacapatDetail::class)
                ->where('bookmarkable_id', $category->id)
                ->exists();
        @endphp
        <button type="button" 
                onclick="toggleBookmark('macapat', {{ $category->id }}, this)" 
                class="btn {{ $isBookmarked ? 'btn-warning text-dark' : 'btn-outline-secondary bg-white' }} rounded-pill px-4 py-2 btn-sm fw-semibold shadow-xs">
            <i class="{{ $isBookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark me-1.5 text-warning"></i>
            <span class="btn-text">{{ $isBookmarked ? 'Tersimpan' : 'Simpan Bookmark' }}</span>
        </button>
        @endauth
    </div>

    <!-- Banner Utama: Nama Tembang & Watak -->
    <div class="card card-modern border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="p-4 p-md-5 text-white position-relative" style="background: linear-gradient(135deg, #1F4D3A 0%, #2b6c51 100%);">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <span class="badge bg-white text-primary rounded-pill px-3 py-2 mb-3 fw-semibold shadow-sm">
                        Tembang Macapat
                    </span>
                    <h1 class="fw-bold mb-2 text-uppercase text-white tracking-wide">{{ $category->name }}</h1>
                    @if(!empty($category->watak))
                    <p class="mb-0 text-white-50 fs-5 fst-italic">
                        <i class="fa-solid fa-quote-left me-1 opacity-50"></i>{{ $category->watak }}<i class="fa-solid fa-quote-right ms-1 opacity-50"></i>
                    </p>
                    @endif
                </div>
                <div class="col-md-3 text-md-end d-none d-md-block">
                    <div class="d-inline-flex p-4 bg-white bg-opacity-10 rounded-circle text-white shadow-sm">
                        <i class="fa-solid fa-music fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deskripsi Filosofis (Jika ada) -->
        @if(!empty($category->description))
        <div class="card-body p-4 p-md-5 border-bottom">
            <h5 class="fw-bold text-main mb-3 d-flex align-items-center gap-2">
                <i class="fa-solid fa-book-open text-primary"></i>
                <span>Deskripsi Tembang</span>
            </h5>
            <p class="text-secondary mb-0 leading-relaxed" style="font-size: 1.05rem;">
                {{ $category->description }}
            </p>
        </div>
        @endif
    </div>

    <!-- Section: Aturan Tembang (Paugeran) -->
    <div class="card card-modern border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 p-md-5">
            <h4 class="fw-bold text-main mb-4 d-flex align-items-center gap-2 border-bottom pb-3">
                <i class="fa-solid fa-scale-balanced text-primary"></i>
                <span>Aturan Tembang (Paugeran)</span>
            </h4>

            <div class="row g-3 g-md-4">
                <!-- Guru Gatra -->
                <div class="col-md-4">
                    <div class="p-4 bg-light rounded-4 border border-light-subtle h-100 text-center">
                        <div class="badge bg-soft-blue text-primary p-3 rounded-circle mb-3">
                            <i class="fa-solid fa-list-ol fs-4"></i>
                        </div>
                        <h6 class="text-muted fw-semibold mb-1">Guru Gatra</h6>
                        <h3 class="fw-bold text-primary mb-1">{{ $category->guru_gatra }}</h3>
                        <small class="text-muted d-block">Baris / Larik saben sapada</small>
                    </div>
                </div>

                <!-- Guru Wilangan -->
                <div class="col-md-4">
                    <div class="p-4 bg-light rounded-4 border border-light-subtle h-100 text-center">
                        <div class="badge bg-soft-blue text-primary p-3 rounded-circle mb-3">
                            <i class="fa-solid fa-calculator fs-4"></i>
                        </div>
                        <h6 class="text-muted fw-semibold mb-1">Guru Wilangan</h6>
                        <h4 class="fw-bold text-primary mb-1">{{ $category->guru_wilangan }}</h4>
                        <small class="text-muted d-block">Cacahing wanda (suku kata) saben larik</small>
                    </div>
                </div>

                <!-- Guru Lagu -->
                <div class="col-md-4">
                    <div class="p-4 bg-light rounded-4 border border-light-subtle h-100 text-center">
                        <div class="badge bg-soft-blue text-primary p-3 rounded-circle mb-3">
                            <i class="fa-solid fa-font fs-4"></i>
                        </div>
                        <h6 class="text-muted fw-semibold mb-1">Guru Lagu</h6>
                        <h4 class="fw-bold text-primary mb-1">{{ $category->guru_lagu }}</h4>
                        <small class="text-muted d-block">Tibaning swara pungkasan saben larik</small>
                    </div>
                </div>
            </div>

            @if(!empty($category->watak))
            <div class="mt-4 p-3 bg-light rounded-3 border">
                <span class="fw-bold text-dark me-2"><i class="fa-solid fa-heart me-1 text-danger"></i> Watak:</span>
                <span class="text-secondary">{{ $category->watak }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Section: Contoh Tembang & Text-to-Speech -->
    <div class="card card-modern border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
            <h4 class="fw-bold text-main mb-4 d-flex align-items-center gap-2 border-bottom pb-3">
                <i class="fa-solid fa-scroll text-primary"></i>
                <span>Contoh Tembang {{ $category->name }}</span>
            </h4>

            <div class="row g-4">
                @forelse($category->details as $index => $detail)
                <div class="col-lg-6">
                    <div class="card h-100 border rounded-4 shadow-sm overflow-hidden example-card" id="card-detail-{{ $detail->id }}">
                        <!-- Card Header Contoh -->
                        <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center px-4 py-3">
                            <span class="badge bg-primary rounded-pill px-3 py-2 fw-semibold">
                                Contoh {{ $index + 1 }}
                            </span>
                            <span class="text-muted small">
                                <i class="fa-solid fa-book-bookmark me-1 text-primary"></i> Cakepan Macapat
                            </span>
                        </div>

                        <div class="card-body p-4 d-flex flex-column">
                            <!-- Lirik Tembang (Verse) dengan line break yang rapi -->
                            <div class="p-4 bg-light rounded-4 text-center mb-4 verse-container border">
                                <p class="mb-0 fw-bold text-dark verse-text" id="verse-{{ $detail->id }}" style="white-space: pre-line; line-height: 2; font-family: 'Georgia', 'Times New Roman', serif; font-size: 1.15rem;">{{ $detail->verse }}</p>
                            </div>

                            <!-- Terjemahan / Makna (Jika ada) -->
                            @if(!empty($detail->meaning))
                            <div class="mb-4">
                                <h6 class="fw-bold text-muted mb-2 small text-uppercase tracking-wider">
                                    <i class="fa-solid fa-language text-primary me-1"></i> Terjemahan:
                                </h6>
                                <div class="p-3 bg-white rounded-3 border-start border-3 border-primary bg-opacity-10 text-secondary leading-relaxed small" style="white-space: pre-line;">
                                    {{ $detail->meaning }}
                                </div>
                            </div>
                            @endif

                            <!-- Tombol Text-to-Speech (Speaker) -->
                            <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                <button type="button" 
                                        class="btn btn-primary rounded-pill px-4 py-2 fw-semibold tts-btn shadow-sm btn-bouncy d-inline-flex align-items-center gap-2" 
                                        data-detail-id="{{ $detail->id }}"
                                        id="tts-btn-{{ $detail->id }}">
                                    <i class="fa-solid fa-volume-high fs-5 tts-icon"></i>
                                    <span class="tts-label">Dengarkan</span>
                                </button>

                                <small class="text-muted tts-status-hint d-none text-primary fw-semibold" id="tts-hint-{{ $detail->id }}">
                                    <i class="fa-solid fa-wave-square me-1 animate__animated animate__pulse animate__infinite"></i> Membaca tembang...
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fa-solid fa-lines-leaning fs-1 text-muted mb-3 opacity-50"></i>
                    <h5 class="text-muted fw-bold">Belum ada contoh bait untuk tembang ini.</h5>
                    <p class="text-muted small">Contoh bait tembang macapat akan segera ditambahkan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Styling Khusus Halaman Detail */
.macapat-detail-container {
    max-width: 1200px;
    margin: 0 auto;
}
.tracking-wide {
    letter-spacing: 0.05em;
}
.verse-container {
    background-color: #f8fafc !important;
}
.example-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.example-card.is-playing {
    border-color: #1F4D3A !important;
    box-shadow: 0 8px 24px rgba(31, 77, 58, 0.18) !important;
}
.tts-btn.is-active {
    background-color: #dc2626 !important;
    border-color: #dc2626 !important;
    color: #ffffff !important;
}
</style>

<!-- JavaScript Text-to-Speech (Web Speech API) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const synth = window.speechSynthesis;
    let currentUtterance = null;
    let currentActiveBtn = null;
    let javaneseVoice = null;

    // Load and select best voice for Javanese / Indonesian
    function loadVoices() {
        if (!synth) return;
        const voices = synth.getVoices();
        
        // Priority 1: Javanese Voice (jv-ID or jv)
        javaneseVoice = voices.find(v => v.lang === 'jv-ID' || v.lang === 'jv' || v.name.toLowerCase().includes('javanese'));
        
        // Priority 2: Indonesian Voice (id-ID or id)
        if (!javaneseVoice) {
            javaneseVoice = voices.find(v => v.lang === 'id-ID' || v.lang === 'id' || v.name.toLowerCase().includes('indonesian') || v.name.toLowerCase().includes('indonesia'));
        }
    }

    if (synth) {
        loadVoices();
        if (speechSynthesis.onvoiceschanged !== undefined) {
            speechSynthesis.onvoiceschanged = loadVoices;
        }
    }

    // Stop current TTS playback and reset UI
    function stopCurrentTTS() {
        if (synth && synth.speaking) {
            synth.cancel();
        }
        if (currentActiveBtn) {
            resetButtonUI(currentActiveBtn);
            currentActiveBtn = null;
        }
        currentUtterance = null;
    }

    // Reset button to normal state
    function resetButtonUI(btn) {
        btn.classList.remove('is-active');
        const detailId = btn.getAttribute('data-detail-id');
        const icon = btn.querySelector('.tts-icon');
        const label = btn.querySelector('.tts-label');
        const hint = document.getElementById('tts-hint-' + detailId);
        const card = document.getElementById('card-detail-' + detailId);

        if (icon) icon.className = 'fa-solid fa-volume-high fs-5 tts-icon';
        if (label) label.textContent = 'Dengarkan';
        if (hint) hint.classList.add('d-none');
        if (card) card.classList.remove('is-playing');
    }

    // Set button to playing/active state
    function setButtonActiveUI(btn) {
        btn.classList.add('is-active');
        const detailId = btn.getAttribute('data-detail-id');
        const icon = btn.querySelector('.tts-icon');
        const label = btn.querySelector('.tts-label');
        const hint = document.getElementById('tts-hint-' + detailId);
        const card = document.getElementById('card-detail-' + detailId);

        if (icon) icon.className = 'fa-solid fa-circle-stop fs-5 tts-icon';
        if (label) label.textContent = 'Hentikan';
        if (hint) hint.classList.remove('d-none');
        if (card) card.classList.add('is-playing');
    }

    // Attach click listeners to all TTS buttons
    const ttsButtons = document.querySelectorAll('.tts-btn');
    ttsButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const detailId = this.getAttribute('data-detail-id');
            const verseElement = document.getElementById('verse-' + detailId);
            
            if (!verseElement) return;

            // Jika tombol yang sama ditekan saat sedang berbicara -> Hentikan
            if (currentActiveBtn === this && synth && synth.speaking) {
                stopCurrentTTS();
                return;
            }

            // Hentikan audio sebelumnya jika ada
            stopCurrentTTS();

            // Ambil teks HANYA dari kolom verse (tanpa terjemahan / info lain)
            const textToRead = verseElement.innerText.trim();

            if (!textToRead) return;

            if (!('speechSynthesis' in window)) {
                alert('Maaf, peramban (browser) Anda belum mendukung fitur Text-to-Speech Web Speech API.');
                return;
            }

            const utterance = new SpeechSynthesisUtterance(textToRead);
            
            // Konfigurasi suara
            if (javaneseVoice) {
                utterance.voice = javaneseVoice;
                utterance.lang = javaneseVoice.lang;
            } else {
                utterance.lang = 'id-ID';
            }

            utterance.rate = 0.85; // Sedikit lebih lambat agar siswa SD dapat menyimak pelafalan tembang
            utterance.pitch = 1.0;

            // Event listener saat selesai membaca
            utterance.onend = function () {
                stopCurrentTTS();
            };

            // Event listener saat terjadi kesalahan
            utterance.onerror = function () {
                stopCurrentTTS();
            };

            // Update UI dan mulai berbicara
            currentActiveBtn = button;
            currentUtterance = utterance;
            setButtonActiveUI(button);

            synth.speak(utterance);
        });
    });

    // Hentikan suara jika pengguna berpindah halaman
    window.addEventListener('beforeunload', function () {
        stopCurrentTTS();
    });
});

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
@endsection

@extends('layouts.app')

@section('title', 'Kamus Kosakata Basa Jawa')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-5">
        <h3 class="fw-bold text-main mb-1">Kamus Basa Jawa</h3>
        <p class="text-muted mb-0">Daftar kosakata Bahasa Jawa lengkap Ngoko & Krama beserta contoh penggunaan dan audio TTS.</p>
    </div>
    <div class="col-md-7 mt-3 mt-md-0">
        <div class="d-flex flex-column flex-sm-row gap-2">
            <form action="{{ url('/ui/kosakata') }}" method="GET" class="flex-grow-1">
                <div class="input-group input-group-lg shadow-sm rounded-4">
                    <span class="input-group-text bg-white border-end-0 rounded-start-4">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 rounded-end-4"
                           placeholder="Cari kata (Indonesia / Ngoko / Krama)..."
                           value="{{ request('search') }}" id="searchInput">
                </div>
            </form>
        </div>
        
        {{-- Pengaturan Suara TTS --}}
        <div class="d-flex flex-wrap align-items-center gap-3 mt-3 p-2 px-3 bg-white rounded-4 shadow-sm border border-light">
            <div class="d-flex align-items-center gap-2 flex-grow-1">
                <i class="fa-solid fa-user-gear text-primary fs-5"></i>
                <span class="small fw-semibold text-muted text-nowrap">Karakter Suara:</span>
                <select id="ttsVoiceSelect" class="form-select form-select-sm border-0 bg-light rounded-3 fw-semibold">
                    <option value="female" selected>👩 Bu Guru (Suara Wanita)</option>
                    <option value="male">👨 Pak Guru (Suara Pria)</option>
                    <option value="browser_fallback">🌐 Suara Default Browser (Web Speech API)</option>
                </select>
            </div>
            
            <div class="d-flex align-items-center gap-2" style="min-width: 170px;">
                <i class="fa-solid fa-gauge-high text-accent"></i>
                <span class="small fw-semibold text-muted">Laju:</span>
                <input type="range" id="ttsRateRange" class="form-range ms-1" min="0.5" max="1.5" step="0.1" value="0.85">
                <span id="ttsRateVal" class="badge bg-soft-blue text-primary rounded-pill small">0.85x</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4" id="vocabListContainer">
    @forelse($vocabularies as $vocab)
    <div class="col-12 vocab-card-item">
        <div class="card card-modern p-4 border-0 shadow-sm rounded-4">
            <div class="row align-items-center">
                {{-- Kata Utama --}}
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h4 class="fw-bold text-main mb-0">{{ $vocab->indonesian_word }}</h4>
                    </div>
                    <span class="badge bg-soft-blue text-primary rounded-pill small me-1">Bahasa Indonesia</span>
                    @if($vocab->category)
                    <span class="badge bg-warning bg-opacity-20 text-dark rounded-pill small"><i class="fa-solid fa-tag me-1"></i>{{ $vocab->category }}</span>
                    @endif
                </div>

                {{-- Padanan Jawa Ngoko & Krama --}}
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-semibold" style="width:110px;">Ngoko</span>
                            <span class="fs-5 fw-bold text-dark">{{ $vocab->javanese_ngoko ?? '-' }}</span>
                            <button class="btn btn-sm btn-light rounded-circle shadow-sm btn-speak ms-2"
                                    data-text="{{ $vocab->javanese_ngoko }}" title="Dengar Suara Ngoko">
                                <i class="fa-solid fa-volume-high text-accent"></i>
                            </button>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 fw-semibold" style="width:110px;">Krama</span>
                            <span class="fs-5 fw-bold text-primary">{{ $vocab->javanese_krama ?? '-' }}</span>
                            <button class="btn btn-sm btn-light rounded-circle shadow-sm btn-speak ms-2"
                                    data-text="{{ $vocab->javanese_krama }}" title="Dengar Suara Krama">
                                <i class="fa-solid fa-volume-high text-primary"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Tombol Toggle Contoh --}}
                <div class="col-md-2 text-md-end">
                    <button class="btn btn-outline-primary btn-bouncy rounded-pill px-3 py-2 w-100 btn-toggle-example"
                            type="button" data-bs-toggle="collapse" data-bs-target="#example-{{ $vocab->id }}">
                        <i class="fa-solid fa-book-open me-1"></i> Contoh
                    </button>
                </div>
            </div>

            {{-- Collapsible Contoh Penggunaan --}}
            <div class="collapse mt-4 pt-3 border-top" id="example-{{ $vocab->id }}">
                <h6 class="fw-bold text-main mb-3"><i class="fa-solid fa-lightbulb text-warning me-2"></i>Contoh Penggunaan Kalimat</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-4">
                            <small class="fw-semibold text-muted d-block mb-1">Bahasa Indonesia</small>
                            <p class="mb-0 text-dark small fw-semibold">{{ $vocab->example_indonesian ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-success bg-opacity-10 rounded-4">
                            <small class="fw-semibold text-success d-block mb-1">Bahasa Jawa Ngoko</small>
                            <p class="mb-0 text-dark small fw-semibold">{{ $vocab->example_ngoko ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-primary bg-opacity-10 rounded-4">
                            <small class="fw-semibold text-primary d-block mb-1">Bahasa Jawa Krama</small>
                            <p class="mb-0 text-dark small fw-semibold">{{ $vocab->example_krama ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_q7uarxsb.json" background="transparent" speed="1" style="width:150px;height:150px;margin:0 auto;" loop autoplay></lottie-player>
        <h5 class="fw-bold text-main mt-3">Kosakata Tidak Ditemukan</h5>
        <p class="text-muted">Coba ketik kata lain dalam pencarian.</p>
    </div>
    @endforelse
</div>

{{-- Pagination jika menggunakan data asli dari DB --}}
@if(method_exists($vocabularies, 'links'))
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-5 mb-4 p-3 bg-white rounded-4 shadow-sm border border-light gap-3">
    <div class="text-muted small fw-semibold">
        Menampilkan <span class="text-dark fw-bold">{{ $vocabularies->firstItem() ?? 0 }}</span> - <span class="text-dark fw-bold">{{ $vocabularies->lastItem() ?? 0 }}</span> dari <span class="text-primary fw-bold">{{ $vocabularies->total() }}</span> kosakata
    </div>
    <div class="pagination-custom">
        {{ $vocabularies->onEachSide(1)->links() }}
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const voiceSelect = document.getElementById('ttsVoiceSelect');
        const rateRange = document.getElementById('ttsRateRange');
        const rateVal = document.getElementById('ttsRateVal');

        // Update indicator nilai rate/kecepatan
        if (rateRange && rateVal) {
            rateRange.addEventListener('input', function() {
                rateVal.textContent = this.value + 'x';
            });
        }

        // Handler saat tombol speaker diklik menggunakan Server Audio / Proxy API & Fallback
        document.querySelectorAll('.btn-speak').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const textToSpeak = this.getAttribute('data-text');
                if (!textToSpeak) return;

                const icon = this.querySelector('i');
                const originalClass = icon.className;
                icon.className = 'fa-solid fa-spinner fa-spin text-primary';

                const selectedVoice = voiceSelect ? voiceSelect.value : 'female';
                const rateSpeed = rateRange ? parseFloat(rateRange.value) : 0.85;

                if (selectedVoice === 'female' || selectedVoice === 'male') {
                    // Gunakan Backend Audio Stream (Jaminan Suara Pria & Wanita 100% Berbeda)
                    const audioUrl = `{{ url('/api/tts') }}?text=${encodeURIComponent(textToSpeak)}&gender=${selectedVoice}`;
                    const audio = new Audio(audioUrl);
                    audio.playbackRate = rateSpeed;

                    audio.onplay = function() {
                        icon.className = 'fa-solid fa-volume-high text-success animate-pulse-glow';
                    };
                    audio.onended = function() {
                        icon.className = originalClass;
                    };
                    audio.onerror = function() {
                        // Fallback ke ResponsiveVoice / Web Speech API jika koneksi offline
                        if (typeof responsiveVoice !== 'undefined') {
                            responsiveVoice.speak(textToSpeak, selectedVoice === 'male' ? 'Indonesian Male' : 'Indonesian Female', {
                                rate: rateSpeed,
                                onend: function() { icon.className = originalClass; }
                            });
                        } else {
                            speakWithWebSpeech(textToSpeak, rateSpeed, icon, originalClass);
                        }
                    };

                    audio.play().catch(() => {
                        speakWithWebSpeech(textToSpeak, rateSpeed, icon, originalClass);
                    });
                } else {
                    speakWithWebSpeech(textToSpeak, rateSpeed, icon, originalClass);
                }
            });
        });

        // Helper Function untuk Web Speech API Browser
        function speakWithWebSpeech(textToSpeak, rateSpeed, icon, originalClass) {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const utterance = new SpeechSynthesisUtterance(textToSpeak);
                utterance.lang = 'id-ID';
                utterance.rate = rateSpeed;

                utterance.onend = function() { icon.className = originalClass; };
                utterance.onerror = function() { icon.className = originalClass; };

                window.speechSynthesis.speak(utterance);
            } else {
                icon.className = originalClass;
                alert("Fitur Text-to-Speech tidak didukung oleh browser Anda.");
            }
        }
    });

    /* =========================================================================
     * KODINGAN TTS LAMA (WEB SPEECH API MURNI BROWSER) - DI-COMMENT SESUAI PERMINTAAN
     * =========================================================================
    /*
    document.addEventListener('DOMContentLoaded', function() {
        const voiceSelect = document.getElementById('ttsVoiceSelect');
        const rateRange = document.getElementById('ttsRateRange');
        const rateVal = document.getElementById('ttsRateVal');
        let availableVoices = [];

        function populateVoiceList() {
            if (!('speechSynthesis' in window)) return;
            availableVoices = window.speechSynthesis.getVoices();
            if (!voiceSelect) return;
            voiceSelect.innerHTML = '';

            let selectedIndex = 0;
            availableVoices.forEach((voice, index) => {
                const option = document.createElement('option');
                option.textContent = `${voice.name} (${voice.lang})`;
                option.value = index;
                if (voice.lang.includes('id') || voice.lang.includes('ID')) selectedIndex = index;
                voiceSelect.appendChild(option);
            });
            if (availableVoices.length > 0) voiceSelect.selectedIndex = selectedIndex;
        }

        populateVoiceList();
        if (speechSynthesis.onvoiceschanged !== undefined) {
            speechSynthesis.onvoiceschanged = populateVoiceList;
        }
    });
    */
</script>
@endpush

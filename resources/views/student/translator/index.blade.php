@extends('layouts.app')

@section('title', 'Translator Jawa-Indonesia')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-main mb-1">
        <i class="fa-solid fa-language text-primary me-2"></i>Penerjemah Bahasa Jawa
    </h3>
    <p class="text-muted mb-0 small">Terjemahkan teks antara Bahasa Indonesia, Jawa Ngoko, dan Jawa Krama secara cepat dan akurat.</p>
</div>

<div class="card card-modern p-0 border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
    <!-- Header Language Selector Bar -->
    <div class="bg-white border-bottom p-3 p-sm-4">
        <div class="row align-items-center g-3">
            {{-- Bahasa Asal --}}
            <div class="col-12 col-md-5">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-soft-blue text-primary rounded-circle p-2">
                        <i class="fa-solid fa-pen-line fs-6"></i>
                    </span>
                    <div>
                        <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">DARI (INPUT):</small>
                        <span class="fw-bold fs-6 text-main" id="sourceLangLabel">Bahasa Indonesia</span>
                    </div>
                </div>
            </div>

            {{-- Tombol Tukar Bahasa (Swap) --}}
            <div class="col-12 col-md-2 text-center my-1 my-md-0 d-flex align-items-center justify-content-center">
                <button type="button" id="swapLangBtn" class="btn btn-light rounded-circle shadow-sm border btn-bouncy d-inline-flex align-items-center justify-content-center p-0" 
                        style="width: 42px; height: 42px;" title="Tukar Bahasa (Swap)">
                    <i class="fa-solid fa-arrow-right-arrow-left text-primary fs-6" style="margin: 0; line-height: 1;"></i>
                </button>
            </div>

            {{-- Bahasa Tujuan & Selector Ragam Ngoko / Krama --}}
            <div class="col-12 col-md-5">
                <div class="d-flex align-items-center justify-content-md-end justify-content-between gap-2 flex-wrap">
                    <div class="me-2 d-none d-lg-block">
                        <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">KE (HASIL):</small>
                        <span class="fw-bold fs-6 text-main" id="targetLangLabel">Bahasa Jawa</span>
                    </div>
                    
                    {{-- Form Select Ragam Bahasa --}}
                    <div class="d-inline-flex p-1 bg-light rounded-4 border shadow-sm w-100 w-sm-auto justify-content-center">
                        <input type="radio" class="btn-check" name="dialectOption" id="dialectNgoko" value="ngoko" checked>
                        <label class="btn btn-sm btn-dialect-pill rounded-3 px-2.5 px-sm-3 py-1.5 py-sm-2 fw-bold mb-0 text-nowrap flex-fill text-center" for="dialectNgoko">
                            <i class="fa-solid fa-comments me-1"></i> Ngoko
                        </label>

                        <input type="radio" class="btn-check" name="dialectOption" id="dialectKrama" value="krama">
                        <label class="btn btn-sm btn-dialect-pill rounded-3 px-2.5 px-sm-3 py-1.5 py-sm-2 fw-bold mb-0 text-nowrap flex-fill text-center" for="dialectKrama">
                            <i class="fa-solid fa-scroll me-1"></i> Krama Halus
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Body Panel Penerjemah -->
    <div class="row g-0">
        <!-- Input Textarea (Kiri) -->
        <div class="col-lg-6 border-end-lg position-relative d-flex flex-column" style="background: #ffffff;">
            <div class="p-3 p-sm-4 flex-grow-1">
                <textarea class="form-control border-0 p-0 shadow-none text-main fw-normal" 
                          id="sourceText" rows="6" 
                          placeholder="Ketik atau tempel kalimat yang ingin diterjemahkan di sini (minimal 10 kata)..." 
                          style="font-size: 1.05rem; resize: none; background: transparent;"></textarea>
            </div>
            
            {{-- Control Toolbar Input --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 p-3 px-3 px-sm-4 border-top border-light bg-light rounded-bottom-start-4">
                <span class="small fw-semibold text-muted" id="charCount">0 / 10 kata (minimal)</span>
                <div class="d-flex align-items-center gap-2">
                    {{-- Audio Speaker TTS Input --}}
                    <button type="button" class="btn btn-sm btn-white rounded-circle shadow-sm btn-action p-0 d-flex align-items-center justify-content-center me-1" 
                            id="speakSourceBtn" style="width: 38px; height: 38px;" title="Dengar Suara Teks Input">
                        <i class="fa-solid fa-volume-high text-primary"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold" id="clearBtn">
                        <i class="fa-solid fa-eraser me-1"></i> Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-4 fw-semibold shadow-sm" id="translateBtn">
                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Terjemahkan
                    </button>
                </div>
            </div>

        </div>
        
        <!-- Output Result Panel (Kanan) -->
        <div class="col-lg-6 position-relative d-flex flex-column" style="background: #FAF8F5;">
            <div class="p-3 p-sm-4 flex-grow-1">
                <div id="loadingSpinner" class="d-none text-center py-4">
                    <div class="spinner-border text-primary" role="status" style="width: 2.5rem; height: 2.5rem;">
                        <span class="visually-hidden">Menerjemahkan...</span>
                    </div>
                    <p class="small text-muted mt-2 fw-semibold mb-0">Sedang menerjemahkan teks...</p>
                </div>

                <div id="resultOutputContainer">
                    <textarea class="form-control border-0 p-0 shadow-none text-main fw-semibold" 
                              id="resultText" rows="6" 
                              placeholder="Hasil terjemahan Bahasa Jawa akan muncul di sini..." 
                              readonly style="font-size: 1.05rem; resize: none; background: transparent;"></textarea>
                </div>
            </div>
            
            {{-- Control Toolbar Output --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 p-3 px-3 px-sm-4 border-top border-light bg-light rounded-bottom-end-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success bg-gradient text-white rounded-pill px-3 py-2 fw-bold shadow-sm" id="targetDialectBadge">
                        🍃 Ragam Terjemahan: Ngoko
                    </span>
                </div>

                <div class="d-flex align-items-center gap-2 ms-auto ms-sm-0">
                    {{-- Audio Speaker TTS --}}
                    <button type="button" class="btn btn-sm btn-white rounded-circle shadow-sm btn-action p-0 d-flex align-items-center justify-content-center" 
                            id="speakResultBtn" style="width: 38px; height: 38px;" title="Dengar Suara Terjemahan">
                        <i class="fa-solid fa-volume-high text-primary"></i>
                    </button>
                    {{-- Salin Teks --}}
                    <button type="button" class="btn btn-sm btn-white rounded-circle shadow-sm btn-action p-0 d-flex align-items-center justify-content-center" 
                            id="copyResultBtn" style="width: 38px; height: 38px;" title="Salin Hasil Terjemahan">
                        <i class="fa-regular fa-copy text-muted"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Tips Penerjemahan --}}
<div class="card border-0 rounded-4 p-4 shadow-sm" style="background: linear-gradient(135deg, #ffffff 0%, #DCEAF7 100%); border-left: 5px solid var(--primary) !important;">
    <div class="d-flex align-items-start gap-3">
        <div class="p-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
            <i class="fa-solid fa-lightbulb fs-5"></i>
        </div>
        <div>
            <h6 class="fw-bold text-main mb-1">Tips & Panduan Penerjemahan Basa Jawa</h6>
            <p class="text-muted small mb-0">
                Pilih opsi <strong>🍃 Ngoko</strong> untuk percakapan santai sesama teman seumuran. Pilih opsi <strong>📜 Krama</strong> untuk percakapan sopan/santun kepada orang tua, guru, atau tokoh yang dihormati.
            </p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media (min-width: 992px) {
    .border-end-lg {
        border-right: 1px solid rgba(0, 0, 0, 0.08) !important;
    }
}
.btn-action {
    background: #ffffff;
    transition: all 0.2s ease;
}
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important;
}

/* Custom Dialect Pill Selector */
.btn-dialect-pill {
    border: none !important;
    color: var(--text-muted) !important;
    background: transparent;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 0.88rem;
    cursor: pointer;
}
.btn-dialect-pill:hover {
    color: var(--primary) !important;
}
.btn-check:checked + .btn-dialect-pill {
    background-color: var(--primary) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 10px rgba(31, 77, 58, 0.25) !important;
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sourceText = document.getElementById('sourceText');
        const resultText = document.getElementById('resultText');
        const charCount = document.getElementById('charCount');
        const clearBtn = document.getElementById('clearBtn');
        const translateBtn = document.getElementById('translateBtn');
        const swapLangBtn = document.getElementById('swapLangBtn');
        const sourceLangLabel = document.getElementById('sourceLangLabel');
        const targetLangLabel = document.getElementById('targetLangLabel');
        const targetDialectBadge = document.getElementById('targetDialectBadge');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const resultOutputContainer = document.getElementById('resultOutputContainer');
        const speakSourceBtn = document.getElementById('speakSourceBtn');
        const speakResultBtn = document.getElementById('speakResultBtn');
        const copyResultBtn = document.getElementById('copyResultBtn');
        const voiceSelect = document.getElementById('ttsVoiceSelect');
        const dialectOptions = document.querySelectorAll('input[name="dialectOption"]');

        let currentSource = 'id';
        let currentTarget = 'jw';
        let selectedDialect = 'ngoko';
        let debounceTimer = null;
        let currentTranslatorAudio = null;
        let currentTranslatorButton = null;

        // Function Play Audio Text-to-Speech (Berlaku untuk Input Teks & Hasil Terjemahan)
        function playAudioText(textToSpeak, btnElement) {
            if (!textToSpeak || !btnElement) return;

            const icon = btnElement.querySelector('i');
            const originalClass = 'fa-solid fa-volume-high text-primary';

            // JIKA SUARA SEDANG BERBUNYI: BERHENTIKAN SUARA (STOP AUDIO)
            if (currentTranslatorAudio || (window.speechSynthesis && window.speechSynthesis.speaking)) {
                if (currentTranslatorAudio) {
                    currentTranslatorAudio.pause();
                    currentTranslatorAudio.currentTime = 0;
                    currentTranslatorAudio = null;
                }
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                }
                if (currentTranslatorButton) {
                    const prevIcon = currentTranslatorButton.querySelector('i');
                    if (prevIcon) prevIcon.className = originalClass;
                    currentTranslatorButton = null;
                }
                icon.className = originalClass;
                return;
            }

            // JIKA SUARA TIDAK SEDANG BERBUNYI: PUTAR SUARA BARU
            icon.className = 'fa-solid fa-spinner fa-spin text-primary';
            currentTranslatorButton = btnElement;

            const selectedVoice = voiceSelect ? voiceSelect.value : 'female';
            const audioUrl = `{{ url('/api/tts') }}?text=${encodeURIComponent(textToSpeak)}&gender=${selectedVoice}`;
            const audio = new Audio(audioUrl);
            audio.playbackRate = 0.85;

            currentTranslatorAudio = audio;

            audio.onplay = function() {
                icon.className = 'fa-solid fa-volume-high text-success animate__animated animate__pulse animate__infinite';
            };

            function resetAudioState() {
                icon.className = originalClass;
                currentTranslatorAudio = null;
                currentTranslatorButton = null;
            }

            audio.onended = resetAudioState;

            // Fallback ke Web Speech API jika server proxy terhalang CORS/Network
            function playWebSpeechFallback() {
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                    const utterance = new SpeechSynthesisUtterance(textToSpeak);
                    utterance.lang = 'id-ID';
                    utterance.rate = 0.85;

                    utterance.onstart = function() {
                        icon.className = 'fa-solid fa-volume-high text-success animate__animated animate__pulse animate__infinite';
                    };
                    utterance.onend = resetAudioState;
                    utterance.onerror = resetAudioState;

                    window.speechSynthesis.speak(utterance);
                } else {
                    resetAudioState();
                }
            }

            audio.onerror = function() {
                playWebSpeechFallback();
            };

            audio.play().catch(() => {
                playWebSpeechFallback();
            });
        }

        // Speaker Input Teks (Bahasa Indonesia / Teks Asal)
        if (speakSourceBtn) {
            speakSourceBtn.addEventListener('click', function() {
                playAudioText(sourceText.value.trim(), this);
            });
        }

        // Speaker Hasil Terjemahan (Bahasa Jawa)
        if (speakResultBtn) {
            speakResultBtn.addEventListener('click', function() {
                playAudioText(resultText.value.trim(), this);
            });
        }


        // Dialect Option Change Event
        dialectOptions.forEach(opt => {
            opt.addEventListener('change', function() {
                selectedDialect = this.value;
                if (selectedDialect === 'krama') {
                    targetDialectBadge.className = 'badge bg-primary bg-gradient text-white rounded-pill px-3 py-2 fw-bold shadow-sm';
                    targetDialectBadge.innerHTML = '📜 Ragam Terjemahan: Krama (Halus)';
                } else {
                    targetDialectBadge.className = 'badge bg-success bg-gradient text-white rounded-pill px-3 py-2 fw-bold shadow-sm';
                    targetDialectBadge.innerHTML = '🍃 Ragam Terjemahan: Ngoko';
                }

                if (sourceText.value.trim() !== '') {
                    performTranslation();
                }
            });
        });

        sourceText.addEventListener('input', function() {
            const val = this.value.trim();
            const words = val ? val.split(/\s+/).filter(w => w.length > 0) : [];
            const wordCount = words.length;

            if (wordCount === 0) {
                charCount.className = 'small fw-semibold text-muted';
                charCount.textContent = '0 / 10 kata (minimal)';
                resultText.value = '';
                translateBtn.disabled = false;
                return;
            }

            if (wordCount < 10) {
                charCount.className = 'small fw-bold text-danger';
                charCount.textContent = `${wordCount} / 10 kata (Kurang dari minimal 10 kata!)`;
                resultText.value = `Teks yang diterjemahkan minimal 10 kata.\nTeks Anda saat ini baru berjumlah ${wordCount} kata. Mohon tambahkan kata lagi.`;
                translateBtn.disabled = true;
                return;
            }

            charCount.className = 'small fw-bold text-success';
            charCount.textContent = `${wordCount} kata (Memenuhi Syarat Minimal 10 Kata)`;
            translateBtn.disabled = false;
        });

        // Clear Button
        clearBtn.addEventListener('click', function() {
            sourceText.value = '';
            resultText.value = '';
            charCount.className = 'small fw-semibold text-muted';
            charCount.textContent = '0 / 10 kata (minimal)';
            translateBtn.disabled = false;
            sourceText.focus();
        });

        // Swap Language Button
        swapLangBtn.addEventListener('click', function() {
            if (currentSource === 'id') {
                currentSource = 'jw';
                currentTarget = 'id';
                sourceLangLabel.textContent = 'Bahasa Jawa';
                targetLangLabel.textContent = 'Bahasa Indonesia';
            } else {
                currentSource = 'id';
                currentTarget = 'jw';
                sourceLangLabel.textContent = 'Bahasa Indonesia';
                targetLangLabel.textContent = 'Bahasa Jawa';
            }

            const tempVal = sourceText.value;
            sourceText.value = resultText.value;
            resultText.value = tempVal;
            
            const words = sourceText.value.trim() ? sourceText.value.trim().split(/\s+/).filter(w => w.length > 0) : [];
            charCount.textContent = `${words.length} / 10 kata (minimal)`;

            if (sourceText.value.trim() !== '') {
                performTranslation();
            }
        });

        // Manual Translate Button
        translateBtn.addEventListener('click', function() {
            performTranslation();
        });

        // Function Perform API Translation
        function performTranslation() {
            const text = sourceText.value.trim();
            if (!text) return;

            loadingSpinner.classList.remove('d-none');
            resultOutputContainer.style.opacity = '0.4';

            fetch('{{ route("customer.translate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    text: text,
                    source: currentSource,
                    target: currentTarget,
                    dialect: selectedDialect
                })
            })
            .then(res => res.json())
            .then(data => {
                loadingSpinner.classList.add('d-none');
                resultOutputContainer.style.opacity = '1';

                if (data.translated) {
                    resultText.value = data.translated;
                } else if (data.message) {
                    resultText.value = 'Mohon maaf: ' + data.message;
                }
            })
            .catch(err => {
                loadingSpinner.classList.add('d-none');
                resultOutputContainer.style.opacity = '1';
                console.error('Translation error:', err);
            });
        }

        // Copy Text Button
        if (copyResultBtn) {
            copyResultBtn.addEventListener('click', function() {
                const textToCopy = resultText.value.trim();
                if (!textToCopy) return;

                navigator.clipboard.writeText(textToCopy).then(() => {
                    const icon = this.querySelector('i');
                    const originalClass = icon.className;
                    icon.className = 'fa-solid fa-check text-success';
                    
                    setTimeout(() => {
                        icon.className = originalClass;
                    }, 2000);
                });
            });
        }
    });
</script>
@endpush


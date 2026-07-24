@extends('layouts.app')

@section('title', 'Translator Jawa-Indonesia')

@section('content')
<div class="text-center mb-5">
    <h3 class="fw-bold text-main mb-2">Translator Basa Jawa</h3>
    <p class="text-muted">Terjemahkan teks dari Bahasa Indonesia ke Bahasa Jawa atau sebaliknya.</p>
</div>

<div class="card card-modern p-0 overflow-hidden">
    <!-- Header Translator -->
    <div class="bg-primary px-4 py-3 d-flex justify-content-between align-items-center text-white">
        <h6 class="mb-0 fw-bold w-50 text-center">Bahasa Indonesia</h6>
        <button class="btn btn-light rounded-circle text-primary shadow-sm" id="swapLangBtn" style="width: 40px; height: 40px;">
            <i class="fa-solid fa-arrow-right-arrow-left"></i>
        </button>
        <h6 class="mb-0 fw-bold w-50 text-center">Bahasa Jawa <small class="fw-normal">(Ngoko)</small></h6>
    </div>
    
    <!-- Body Translator -->
    <div class="row g-0">
        <!-- Input Box -->
        <div class="col-md-6 border-end position-relative">
            <textarea class="form-control border-0 p-4 shadow-none resize-none" id="sourceText" rows="8" placeholder="Ketik teks di sini..." style="font-size: 1.1rem; resize: none; background: transparent;"></textarea>
            
            <div class="d-flex justify-content-between align-items-center p-3 text-muted border-top bg-light">
                <small id="charCount">0 / 500 karakter</small>
                <div>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill me-2" id="clearBtn">Clear</button>
                    <button class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm">Terjemahkan</button>
                </div>
            </div>
        </div>
        
        <!-- Output Box -->
        <div class="col-md-6 bg-secondary position-relative">
            <textarea class="form-control border-0 p-4 shadow-none resize-none text-main" id="resultText" rows="8" placeholder="Terjemahan akan muncul di sini..." readonly style="font-size: 1.1rem; resize: none; background: transparent;"></textarea>
            
            <div class="d-flex justify-content-end align-items-center p-3 border-top border-light">
                <button class="btn btn-light rounded-circle text-muted shadow-sm me-2 btn-speak" data-target="resultText" style="width: 40px; height: 40px;" title="Putar Suara">
                    <i class="fa-solid fa-volume-high"></i>
                </button>
                <button class="btn btn-light rounded-circle text-muted shadow-sm" style="width: 40px; height: 40px;" title="Salin Teks">
                    <i class="fa-regular fa-copy"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 alert alert-info bg-soft-blue border-0 rounded-4 d-flex align-items-center">
    <i class="fa-solid fa-circle-info text-primary fs-4 me-3"></i>
    <div>
        <h6 class="fw-bold text-main mb-1">Tips Penerjemahan</h6>
        <p class="text-muted mb-0 small">Secara default terjemahan akan menggunakan gaya bahasa <strong>Ngoko Lugu</strong>. Jika Anda berbicara kepada orang yang lebih tua, pilihlah kosakata Krama pada fitur Kamus.</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Logic for Swap, Clear, and Char Count
    document.getElementById('sourceText').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length + " / 500 karakter";
    });
    
    document.getElementById('clearBtn').addEventListener('click', function() {
        document.getElementById('sourceText').value = '';
        document.getElementById('resultText').value = '';
        document.getElementById('charCount').textContent = "0 / 500 karakter";
    });

    // Web Speech API for Output
    document.querySelectorAll('.btn-speak').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const textToSpeak = document.getElementById(targetId).value;
            
            if(textToSpeak.trim() === '') return;
            
            if ('speechSynthesis' in window) {
                const utterance = new SpeechSynthesisUtterance(textToSpeak);
                utterance.lang = 'id-ID'; 
                utterance.rate = 0.9;
                window.speechSynthesis.speak(utterance);
            } else {
                alert("Browser Anda tidak mendukung fitur Text-to-Speech.");
            }
        });
    });
</script>
@endpush

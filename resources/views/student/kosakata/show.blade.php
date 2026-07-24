@extends('layouts.app')

@section('title', 'Detail Kosakata - Dahar')

@section('content')
<div class="mb-4">
    <a href="#" class="text-decoration-none text-muted fw-semibold"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Kamus</a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-modern p-5 text-center position-relative">
            <div class="position-absolute top-0 end-0 p-4">
                <button class="btn btn-light rounded-circle shadow-sm text-danger" style="width: 50px; height: 50px; font-size: 1.2rem;">
                    <i class="fa-solid fa-heart"></i>
                </button>
            </div>
            
            <div class="mb-4">
                <span class="badge bg-soft-blue text-primary rounded-pill px-3 py-2 fw-semibold mb-3">Krama Inggil</span>
                <h1 class="fw-bold text-main display-4 mb-0">Dahar</h1>
                <p class="text-muted mt-2">Bentuk dari kata dasar: Mangan (Ngoko Lugu)</p>
            </div>
            
            <button class="btn btn-primary rounded-circle shadow mb-5 btn-speak" data-text="Dahar" style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="fa-solid fa-volume-high"></i>
            </button>
            
            <hr class="w-25 mx-auto border-2 mb-5">
            
            <h3 class="fw-bold text-primary mb-4">Arti: Makan</h3>
            
            <div class="text-start bg-secondary p-4 rounded-4 text-muted">
                <h6 class="fw-bold text-main mb-3">Contoh Kalimat:</h6>
                <p class="fs-5 fst-italic mb-2">"Bapak saweg dahar wonten ing ruang makan."</p>
                <p class="mb-0 text-primary fw-semibold">Terjemahan: "Bapak sedang makan di ruang makan."</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Web Speech API Implementation for TTS
    document.querySelectorAll('.btn-speak').forEach(button => {
        button.addEventListener('click', function() {
            const textToSpeak = this.getAttribute('data-text');
            if ('speechSynthesis' in window) {
                const utterance = new SpeechSynthesisUtterance(textToSpeak);
                utterance.lang = 'id-ID'; 
                utterance.rate = 0.9;
                window.speechSynthesis.speak(utterance);
                
                const icon = this.querySelector('i');
                icon.classList.remove('fa-volume-high');
                icon.classList.add('fa-spinner', 'fa-spin');
                
                utterance.onend = function() {
                    icon.classList.remove('fa-spinner', 'fa-spin');
                    icon.classList.add('fa-volume-high');
                }
            } else {
                alert("Browser Anda tidak mendukung fitur Text-to-Speech.");
            }
        });
    });
</script>
@endpush

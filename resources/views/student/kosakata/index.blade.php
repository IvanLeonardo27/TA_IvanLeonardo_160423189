@extends('layouts.app')

@section('title', 'Kamus Kosakata Jawa')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h3 class="fw-bold text-main mb-1">Kamus Basa Jawa</h3>
        <p class="text-muted">Pencarian kosakata Jawa dan terjemahannya dilengkapi fitur audio.</p>
    </div>
    <div class="col-md-6 mt-3 mt-md-0">
        <div class="input-group input-group-lg shadow-sm rounded-4">
            <span class="input-group-text bg-white border-end-0 rounded-start-4" id="search-addon">
                <i class="fa-solid fa-magnifying-glass text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0 ps-0 rounded-end-4" placeholder="Cari kosakata..." aria-label="Search" aria-describedby="search-addon">
        </div>
    </div>
</div>

<!-- Kategori -->
<div class="d-flex gap-2 overflow-auto mb-4 pb-2" style="white-space: nowrap;">
    <button class="btn btn-primary rounded-pill px-4">Semua</button>
    <button class="btn btn-light text-muted border rounded-pill px-4">Ngoko Lugu</button>
    <button class="btn btn-light text-muted border rounded-pill px-4">Ngoko Alus</button>
    <button class="btn btn-light text-muted border rounded-pill px-4">Krama Lugu</button>
    <button class="btn btn-light text-muted border rounded-pill px-4">Krama Inggil</button>
    <button class="btn btn-light text-muted border rounded-pill px-4"><i class="fa-solid fa-star text-warning me-1"></i> Favorit</button>
</div>

<div class="row g-3">
    <!-- Card Kosakata 1 -->
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card card-modern p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h5 class="fw-bold text-main mb-0">Mangan</h5>
                    <small class="badge bg-light text-muted border mt-1">Ngoko Lugu</small>
                </div>
                <button class="btn btn-light rounded-circle shadow-sm btn-speak" data-text="Mangan" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-volume-high text-accent"></i>
                </button>
            </div>
            <p class="text-primary fw-semibold mb-3 fs-5">Makan</p>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm w-100 rounded-3">Detail</button>
                <button class="btn btn-light btn-sm rounded-3 border"><i class="fa-regular fa-heart"></i></button>
            </div>
        </div>
    </div>
    
    <!-- Card Kosakata 2 -->
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card card-modern p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h5 class="fw-bold text-main mb-0">Dahar</h5>
                    <small class="badge bg-light text-muted border mt-1">Krama Inggil</small>
                </div>
                <button class="btn btn-light rounded-circle shadow-sm btn-speak" data-text="Dahar" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-volume-high text-accent"></i>
                </button>
            </div>
            <p class="text-primary fw-semibold mb-3 fs-5">Makan</p>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm w-100 rounded-3">Detail</button>
                <button class="btn btn-light btn-sm rounded-3 border"><i class="fa-solid fa-heart text-danger"></i></button>
            </div>
        </div>
    </div>

    <!-- Card Kosakata 3 -->
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card card-modern p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h5 class="fw-bold text-main mb-0">Turu</h5>
                    <small class="badge bg-light text-muted border mt-1">Ngoko Lugu</small>
                </div>
                <button class="btn btn-light rounded-circle shadow-sm btn-speak" data-text="Turu" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-volume-high text-accent"></i>
                </button>
            </div>
            <p class="text-primary fw-semibold mb-3 fs-5">Tidur</p>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm w-100 rounded-3">Detail</button>
                <button class="btn btn-light btn-sm rounded-3 border"><i class="fa-regular fa-heart"></i></button>
            </div>
        </div>
    </div>
    
    <!-- Card Kosakata 4 -->
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card card-modern p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h5 class="fw-bold text-main mb-0">Sare</h5>
                    <small class="badge bg-light text-muted border mt-1">Krama Inggil</small>
                </div>
                <button class="btn btn-light rounded-circle shadow-sm btn-speak" data-text="Sare" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-volume-high text-accent"></i>
                </button>
            </div>
            <p class="text-primary fw-semibold mb-3 fs-5">Tidur</p>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm w-100 rounded-3">Detail</button>
                <button class="btn btn-light btn-sm rounded-3 border"><i class="fa-regular fa-heart"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Pagination Placeholder -->
<div class="d-flex justify-content-center mt-5">
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <li class="page-item disabled">
          <a class="page-link border-0 shadow-sm rounded-start-4 me-1" href="#" tabindex="-1" aria-disabled="true">Previous</a>
        </li>
        <li class="page-item active"><a class="page-link border-0 shadow-sm me-1 rounded-3" href="#">1</a></li>
        <li class="page-item"><a class="page-link border-0 shadow-sm me-1 rounded-3" href="#">2</a></li>
        <li class="page-item"><a class="page-link border-0 shadow-sm me-1 rounded-3" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link border-0 shadow-sm rounded-end-4" href="#">Next</a>
        </li>
      </ul>
    </nav>
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
                // Try to use Indonesian voice for Javanese approximation if available
                utterance.lang = 'id-ID'; 
                utterance.rate = 0.9; // Slightly slower for clarity
                window.speechSynthesis.speak(utterance);
                
                // Visual feedback
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

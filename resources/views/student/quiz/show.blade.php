@extends('layouts.app')

@section('title', 'Mengerjakan Quiz')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <!-- Header Quiz -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold text-main m-0">Quiz: Unggah-Ungguh Basa</h5>
            <div class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 fs-6 fw-bold">
                <i class="fa-regular fa-clock me-1"></i> 14:59
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="mb-4">
            <div class="d-flex justify-content-between small text-muted fw-semibold mb-1">
                <span>Soal 3 dari 10</span>
                <span>30% Selesai</span>
            </div>
            <div class="progress rounded-pill" style="height: 10px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <!-- Soal Card -->
        <div class="card card-modern p-5 mb-4">
            <h4 class="fw-bold text-main mb-4 lh-base">
                Yen matur marang Bapak/Ibu Guru ing sekolah, becike nggunakake basa...
            </h4>
            
            <div class="d-grid gap-3">
                <label class="btn btn-outline-secondary text-start p-3 rounded-4 fw-normal border-2 d-flex align-items-center" style="font-size: 1.1rem;">
                    <input type="radio" name="answer" class="form-check-input me-3 mt-0" style="width: 1.5rem; height: 1.5rem;">
                    Ngoko Lugu
                </label>
                <label class="btn btn-outline-secondary text-start p-3 rounded-4 fw-normal border-2 d-flex align-items-center" style="font-size: 1.1rem;">
                    <input type="radio" name="answer" class="form-check-input me-3 mt-0" style="width: 1.5rem; height: 1.5rem;">
                    Ngoko Alus
                </label>
                <label class="btn btn-outline-primary bg-soft-blue text-start p-3 rounded-4 fw-normal border-2 d-flex align-items-center" style="font-size: 1.1rem;">
                    <input type="radio" name="answer" class="form-check-input me-3 mt-0" checked style="width: 1.5rem; height: 1.5rem;">
                    Krama Alus (Inggil)
                </label>
                <label class="btn btn-outline-secondary text-start p-3 rounded-4 fw-normal border-2 d-flex align-items-center" style="font-size: 1.1rem;">
                    <input type="radio" name="answer" class="form-check-input me-3 mt-0" style="width: 1.5rem; height: 1.5rem;">
                    Krama Lugu
                </label>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="d-flex justify-content-between">
            <button class="btn btn-light px-4 py-2 text-muted fw-semibold rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i> Sebelumnya</button>
            <button class="btn btn-primary px-5 py-2 fw-semibold rounded-pill shadow-sm">Selanjutnya <i class="fa-solid fa-arrow-right ms-2"></i></button>
        </div>
        
    </div>
    
    <!-- Sidebar Quiz Navigator -->
    <div class="col-lg-4 d-none d-lg-block">
        <div class="card card-modern p-4 sticky-top" style="top: 100px;">
            <h6 class="fw-bold text-main mb-3">Navigasi Soal</h6>
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-success rounded-circle" style="width: 45px; height: 45px;">1</button>
                <button class="btn btn-success rounded-circle" style="width: 45px; height: 45px;">2</button>
                <button class="btn btn-primary border border-2 border-white shadow-sm rounded-circle" style="width: 45px; height: 45px;">3</button>
                <button class="btn btn-outline-secondary rounded-circle" style="width: 45px; height: 45px;">4</button>
                <button class="btn btn-outline-secondary rounded-circle" style="width: 45px; height: 45px;">5</button>
                <button class="btn btn-outline-secondary rounded-circle" style="width: 45px; height: 45px;">6</button>
                <button class="btn btn-outline-secondary rounded-circle" style="width: 45px; height: 45px;">7</button>
                <button class="btn btn-outline-secondary rounded-circle" style="width: 45px; height: 45px;">8</button>
                <button class="btn btn-outline-secondary rounded-circle" style="width: 45px; height: 45px;">9</button>
                <button class="btn btn-outline-secondary rounded-circle" style="width: 45px; height: 45px;">10</button>
            </div>
            <hr class="my-4 text-muted">
            <!-- Lottie Mascot Thinking -->
            <div class="d-flex justify-content-center mb-3" style="height: 120px;">
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_jcikwtux.json" background="transparent" speed="1" style="width: 100px; height: 100px;" loop autoplay></lottie-player>
            </div>
            <button id="btnSelesaikan" class="btn btn-danger bg-opacity-10 text-danger border-danger fw-bold w-100 rounded-pill btn-bouncy py-3">Selesaikan Quiz</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('btnSelesaikan').addEventListener('click', function() {
        // Trigger Confetti
        var duration = 3 * 1000;
        var animationEnd = Date.now() + duration;
        var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        var interval = setInterval(function() {
            var timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            var particleCount = 50 * (timeLeft / duration);
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
        }, 250);
        
        // Ganti teks tombol
        this.innerHTML = '<i class="fa-solid fa-check me-2"></i> Quiz Selesai!';
        this.classList.remove('btn-danger', 'bg-opacity-10', 'text-danger');
        this.classList.add('btn-success', 'text-white');
    });
</script>
@endpush

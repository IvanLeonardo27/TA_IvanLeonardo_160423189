@extends('layouts.app')

@section('title', 'Mengerjakan Evaluasi / Quiz Kelas')

@section('content')
<div class="row g-4">
    <!-- Main Content Area (Soal per Halaman) -->
    <div class="col-lg-8">
        
        <!-- Header Quiz Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white border-start border-4" style="border-color:#8B5CF6 !important;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="badge rounded-pill px-3 py-1 text-white fw-bold mb-2" style="background:#8B5CF6;">
                        <i class="fa-solid fa-pen-to-square me-1"></i> {{ $classroom->name ?? 'Kelas' }}
                    </span>
                    <h4 class="fw-bold text-main m-0">{{ $post->title ?? 'Evaluasi / Quiz' }}</h4>
                    <p class="text-muted small m-0 mt-1">{{ $quiz->instructions ?? 'Bacalah setiap soal dengan teliti dan pilih satu jawaban yang paling tepat.' }}</p>
                </div>
            </div>
        </div>

        @if($questions->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
            <i class="fa-solid fa-folder-open text-muted mb-3" style="font-size:3rem;"></i>
            <h5 class="fw-bold text-main">Belum Ada Soal Tersedia</h5>
            <p class="text-muted">Pengajar belum menambahkan soal pilihan ganda pada evaluasi ini.</p>
            <div>
                <button onclick="window.close()" class="btn rounded-pill px-4 text-white fw-bold" style="background:#8B5CF6;">Tutup Tab</button>
            </div>
        </div>
        @else
        <form action="{{ route('student.classroom.quiz.submit', $quiz) }}" method="POST" id="quizForm">
            @csrf
            <input type="hidden" name="started_at" value="{{ now()->toIso8601String() }}">

            <!-- Question Cards Container (Single Page View) -->
            <div id="questionsWrapper">
                @foreach($questions as $qIndex => $q)
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white question-slide {{ $qIndex === 0 ? '' : 'd-none' }}" id="slide-{{ $qIndex }}" data-index="{{ $qIndex }}" data-qid="{{ $q->id }}">
                    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                        <span class="badge rounded-pill px-3.5 py-2 fw-bold text-white fs-6 shadow-sm" style="background:#8B5CF6;">
                            Soal {{ $qIndex + 1 }} dari {{ $questions->count() }}
                        </span>
                        <span class="small text-purple fw-bold bg-purple bg-opacity-10 px-3 py-1.5 rounded-pill" style="color:#8B5CF6;">
                            <i class="fa-solid fa-star me-1"></i>Pilihan Ganda
                        </span>
                    </div>

                    <h5 class="fw-bold text-main mb-4 lh-base" style="white-space: pre-line; font-size:1.15rem;">
                        {{ $q->question }}
                    </h5>

                    <div class="d-flex flex-column gap-3 mb-2">
                        @if(is_array($q->options))
                            @foreach($q->options as $optIndex => $optText)
                            @php $letter = chr(65 + $optIndex); @endphp
                            <div class="option-card-wrapper position-relative">
                                <input type="radio" name="answers[{{ $q->id }}]" id="opt_{{ $q->id }}_{{ $optIndex }}" value="{{ $optIndex }}" class="btn-check option-radio-input" data-qindex="{{ $qIndex }}">
                                <label for="opt_{{ $q->id }}_{{ $optIndex }}" class="btn w-100 text-start p-3.5 rounded-4 d-flex align-items-center gap-3 option-custom-card shadow-sm border">
                                    <div class="letter-circle rounded-circle d-flex align-items-center justify-content-center fw-bold fs-6 shadow-sm flex-shrink-0">
                                        {{ $letter }}
                                    </div>
                                    <div class="fw-medium text-main fs-6 flex-grow-1">
                                        {{ $optText }}
                                    </div>
                                    <div class="check-icon-box rounded-circle d-flex align-items-center justify-content-center opacity-0 flex-shrink-0">
                                        <i class="fa-solid fa-check text-white" style="font-size:0.85rem;"></i>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Single Page Quiz Navigation Controls -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mt-4 bg-white">
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <button type="button" id="prevBtn" class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-muted border border-2 shadow-sm d-none">
                        <i class="fa-solid fa-arrow-left me-2"></i>Sebelumnya
                    </button>
                    <div class="text-muted small fw-semibold me-auto ms-2" id="pageIndicator">
                        Halaman <span id="currentNum">1</span> / {{ $questions->count() }}
                    </div>
                    <button type="button" id="nextBtn" class="btn rounded-pill px-4 py-2.5 fw-bold text-white shadow-sm btn-bouncy" style="background:#8B5CF6;">
                        Selanjutnya <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                    <button type="submit" id="submitBtn" class="btn rounded-pill px-4.5 py-2.5 fw-bold text-white shadow-sm btn-bouncy bg-success border-0 d-none">
                        <i class="fa-solid fa-circle-check me-2"></i>Selesai & Kumpulkan
                    </button>
                </div>
            </div>
        </form>
        @endif

    </div>

    <!-- Sidebar Right: Modern Countdown Timer & Question Grid Navigation -->
    <div class="col-lg-4">
        <div class="sticky-top" style="top: 20px; z-index: 100;">
            
            <!-- Modern Countdown Timer Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-center text-white overflow-hidden position-relative" id="timerCard" style="background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%); transition: all 0.5s ease;">
                <div class="position-absolute opacity-10" style="right:-10px; bottom:-10px; font-size:6rem;">
                    <i class="fa-solid fa-stopwatch"></i>
                </div>
                <div class="small fw-semibold text-white-50 text-uppercase tracking-wider mb-1">
                    <i class="fa-regular fa-clock me-1"></i> Sisa Waktu Pengerjaan
                </div>
                <div class="display-5 fw-extrabold font-monospace my-1 tracking-tight" id="timerDisplay">
                    00:00:00
                </div>
                <div class="progress rounded-pill bg-white bg-opacity-25 mt-2" style="height: 6px;">
                    <div class="progress-bar bg-white rounded-pill" id="timerProgress" role="progressbar" style="width: 100%; transition: width 1s linear;"></div>
                </div>
            </div>

            <!-- Modern Question Grid Navigator -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                    <h6 class="fw-bold text-main m-0"><i class="fa-solid fa-grip me-2 text-purple" style="color:#8B5CF6;"></i>Navigasi Soal</h6>
                    <span class="badge rounded-pill bg-light text-dark border font-monospace" id="answeredCountBadge">0 / {{ $questions->count() }} Terjawab</span>
                </div>
                
                <div class="row g-2" id="navGrid">
                    @foreach($questions as $qIndex => $q)
                    <div class="col-3">
                        <button type="button" class="btn w-100 rounded-3 font-monospace fw-bold py-2.5 nav-grid-btn {{ $qIndex === 0 ? 'active-grid' : '' }}" data-target="{{ $qIndex }}" id="nav-btn-{{ $qIndex }}" style="font-size:0.95rem;">
                            {{ $qIndex + 1 }}
                        </button>
                    </div>
                    @endforeach
                </div>

                <hr class="my-3">

                <!-- Legend Indicator -->
                <div class="d-flex align-items-center justify-content-between small text-muted px-1">
                    <div class="d-flex align-items-center gap-1.5">
                        <span class="d-inline-block rounded-circle" style="width:10px;height:10px;background:#8B5CF6;"></span>
                        <span>Aktif</span>
                    </div>
                    <div class="d-flex align-items-center gap-1.5">
                        <span class="d-inline-block rounded-circle bg-success" style="width:10px;height:10px;"></span>
                        <span>Terjawab</span>
                    </div>
                    <div class="d-flex align-items-center gap-1.5">
                        <span class="d-inline-block rounded-circle bg-light border" style="width:10px;height:10px;"></span>
                        <span>Belum</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.option-custom-card {
    background-color: #F8FAFC;
    border-color: #E2E8F0 !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.letter-circle {
    width: 38px;
    height: 38px;
    background-color: #FFFFFF;
    color: #475569;
    border: 1px solid #CBD5E1;
    transition: all 0.25s ease;
}

.check-icon-box {
    width: 26px;
    height: 26px;
    background-color: #8B5CF6;
    transition: all 0.25s ease;
}

.option-custom-card:hover {
    background-color: #F3E8FF !important;
    border-color: #C084FC !important;
    transform: translateY(-2px);
}

.option-custom-card:hover .letter-circle {
    background-color: #8B5CF6;
    color: #FFFFFF;
    border-color: #8B5CF6;
}

.option-radio-input:checked + .option-custom-card {
    background-color: #F3E8FF !important;
    border-color: #8B5CF6 !important;
    box-shadow: 0 4px 14px 0 rgba(139, 92, 246, 0.2) !important;
}

.option-radio-input:checked + .option-custom-card .letter-circle {
    background-color: #8B5CF6;
    color: #FFFFFF;
    border-color: #8B5CF6;
}

.option-radio-input:checked + .option-custom-card .check-icon-box {
    opacity: 1 !important;
}

/* Nav Grid Buttons Styling */
.nav-grid-btn {
    background-color: #F1F5F9;
    color: #475569;
    border: 1px solid #E2E8F0;
    transition: all 0.2s ease;
}

.nav-grid-btn:hover {
    background-color: #E2E8F0;
}

.nav-grid-btn.active-grid {
    background-color: #8B5CF6 !important;
    color: #FFFFFF !important;
    border-color: #8B5CF6 !important;
    box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);
}

.nav-grid-btn.answered-grid:not(.active-grid) {
    background-color: #10B981 !important;
    color: #FFFFFF !important;
    border-color: #10B981 !important;
}

/* Warning Pulse Animation for Timer < 1 minute */
@keyframes warningPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

.timer-warning-active {
    background: linear-gradient(135deg, #EF4444 0%, #B91C1C 100%) !important;
    animation: warningPulse 1.2s infinite ease-in-out;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalQuestions = {{ $questions->count() }};
    if (totalQuestions === 0) return;

    let currentIndex = 0;
    const slides     = document.querySelectorAll('.question-slide');
    const prevBtn    = document.getElementById('prevBtn');
    const nextBtn    = document.getElementById('nextBtn');
    const submitBtn  = document.getElementById('submitBtn');
    const currentNum = document.getElementById('currentNum');
    const navButtons = document.querySelectorAll('.nav-grid-btn');
    const quizForm   = document.getElementById('quizForm');

    // 1. Single Page Question Navigation Engine
    function goToSlide(index) {
        if (index < 0 || index >= totalQuestions) return;

        slides[currentIndex].classList.add('d-none');
        slides[index].classList.remove('d-none');

        navButtons[currentIndex].classList.remove('active-grid');
        navButtons[index].classList.add('active-grid');

        currentIndex = index;
        currentNum.textContent = currentIndex + 1;

        // Button Visibility Logic
        prevBtn.classList.toggle('d-none', currentIndex === 0);
        if (currentIndex === totalQuestions - 1) {
            nextBtn.classList.add('d-none');
            submitBtn.classList.remove('d-none');
        } else {
            nextBtn.classList.remove('d-none');
            submitBtn.classList.add('d-none');
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Call goToSlide on init to properly handle single question quizzes (1 of 1)
    goToSlide(0);

    prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
    nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));

    navButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = parseInt(btn.dataset.target);
            goToSlide(target);
        });
    });

    // 2. Answer Change Handler (Update Nav Grid Color to Green)
    const radioInputs = document.querySelectorAll('.option-radio-input');
    radioInputs.forEach(radio => {
        radio.addEventListener('change', function() {
            const qIndex = this.dataset.qindex;
            const navBtn = document.getElementById(`nav-btn-${qIndex}`);
            if (navBtn) {
                navBtn.classList.add('answered-grid');
            }
            updateAnsweredCount();
        });
    });

    function updateAnsweredCount() {
        const answered = document.querySelectorAll('.nav-grid-btn.answered-grid').length;
        document.getElementById('answeredCountBadge').textContent = `${answered} / ${totalQuestions} Terjawab`;
    }

    // 3. Countdown Timer Engine with Auto-Submit & <1m Red Alert
    const durationMinutes = {{ $quiz->duration_minutes ?? 30 }};
    let totalSeconds = durationMinutes * 60;
    const initialSeconds = totalSeconds;

    const timerDisplay  = document.getElementById('timerDisplay');
    const timerCard     = document.getElementById('timerCard');
    const timerProgress = document.getElementById('timerProgress');

    function updateTimer() {
        if (totalSeconds <= 0) {
            clearInterval(timerInterval);
            timerDisplay.textContent = "00:00:00";
            alert("⏰ Waktu pengerjaan kuis telah habis! Jawaban Anda akan dikumpulkan otomatis secara otomatis.");
            // Remove required attribute before auto submit to ensure form sends
            radioInputs.forEach(r => r.removeAttribute('required'));
            quizForm.submit();
            return;
        }

        const hrs  = Math.floor(totalSeconds / 3600);
        const mins = Math.floor((totalSeconds % 3600) / 60);
        const secs = totalSeconds % 60;

        const format = (n) => String(n).padStart(2, '0');
        timerDisplay.textContent = `${format(hrs)}:${format(mins)}:${format(secs)}`;

        // Update progress bar
        const pct = (totalSeconds / initialSeconds) * 100;
        timerProgress.style.width = `${pct}%`;

        // Check if remaining time < 60 seconds (1 minute warning) -> TURN RED
        if (totalSeconds <= 60 && !timerCard.classList.contains('timer-warning-active')) {
            timerCard.classList.add('timer-warning-active');
        }

        totalSeconds--;
    }

    updateTimer();
    const timerInterval = setInterval(updateTimer, 1000);
});
</script>
@endpush
@endsection

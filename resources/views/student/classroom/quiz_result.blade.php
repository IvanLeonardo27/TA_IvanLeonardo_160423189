@extends('layouts.app')

@section('title', 'Hasil Evaluasi / Quiz Kelas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- Modern Quiz Result Card -->
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden bg-white mb-4">
            
            <!-- Header Result Hero Banner -->
            <div class="p-5 text-center text-white position-relative" style="background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%);">
                <div class="position-absolute opacity-10" style="right:-20px; bottom:-20px; font-size:10rem;">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                
                <span class="badge bg-white text-purple rounded-pill px-3 py-1.5 fw-bold mb-3 shadow-sm" style="color:#8B5CF6;">
                    <i class="fa-solid fa-graduation-cap me-1"></i> {{ $classroom->name ?? 'Ruang Kelas' }}
                </span>

                <h3 class="fw-extrabold mb-1">{{ $post->title ?? 'Evaluasi / Quiz Kelas' }}</h3>
                <p class="text-white-50 small mb-4">{{ $quiz->instructions ?? 'Hasil evaluasi pengerjaan kuis pilihan ganda Anda.' }}</p>

                <!-- Score Badge Box -->
                @if($quiz->show_score)
                <div class="d-inline-flex flex-column align-items-center justify-content-center rounded-circle bg-white text-dark shadow-lg p-4 my-2" style="width:160px; height:160px; border:6px solid rgba(255,255,255,0.3);">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Nilai Anda</span>
                    <span class="display-4 fw-extrabold" style="color:#8B5CF6;">{{ $attempt->score }}</span>
                    <span class="text-muted small fw-semibold">/ {{ $quiz->max_score }}</span>
                </div>
                @else
                <div class="d-inline-flex flex-column align-items-center justify-content-center rounded-4 bg-white bg-opacity-20 text-white p-4 my-2" style="min-width:240px; border:2px dashed rgba(255,255,255,0.4);">
                    <i class="fa-solid fa-eye-slash fs-2 mb-2"></i>
                    <span class="fw-bold">Nilai Disembunyikan</span>
                    <span class="small opacity-75">Pengajar memilih untuk merahasiakan nilai.</span>
                </div>
                @endif
            </div>

            <!-- Details Body Information -->
            <div class="card-body p-4 p-md-5">
                <div class="row g-4 mb-4">
                    
                    <!-- Item 1: Nama Siswa -->
                    <div class="col-sm-6 col-md-3">
                        <div class="p-3 rounded-4 bg-light text-center h-100 border">
                            <div class="text-purple small fw-semibold mb-1" style="color:#8B5CF6;"><i class="fa-solid fa-user me-1"></i> Pelajar</div>
                            <div class="fw-bold text-main fs-6 text-truncate" title="{{ $attempt->player_name }}">{{ $attempt->player_name }}</div>
                        </div>
                    </div>

                    <!-- Item 2: Tanggal & Waktu -->
                    <div class="col-sm-6 col-md-3">
                        <div class="p-3 rounded-4 bg-light text-center h-100 border">
                            <div class="text-purple small fw-semibold mb-1" style="color:#8B5CF6;"><i class="fa-regular fa-calendar-check me-1"></i> Tanggal & Waktu</div>
                            <div class="fw-bold text-main small user-local-time" data-utc="{{ $attempt->taken_at ? $attempt->taken_at->toIso8601String() : $attempt->created_at->toIso8601String() }}">
                                {{ $attempt->taken_at ? $attempt->taken_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>

                    <!-- Item 3: Durasi Pengerjaan Aktual -->
                    <div class="col-sm-6 col-md-3">
                        <div class="p-3 rounded-4 bg-light text-center h-100 border">
                            <div class="text-purple small fw-semibold mb-1" style="color:#8B5CF6;"><i class="fa-regular fa-clock me-1"></i> Lama Pengerjaan</div>
                            <div class="fw-bold text-main small">{{ $attempt->time_spent_formatted }}</div>
                        </div>
                    </div>

                    <!-- Item 4: Status Kelulusan -->
                    <div class="col-sm-6 col-md-3">
                        <div class="p-3 rounded-4 bg-light text-center h-100 border">
                            <div class="text-purple small fw-semibold mb-1" style="color:#8B5CF6;"><i class="fa-solid fa-circle-check me-1"></i> Status Kuis</div>
                            <div class="fw-bold text-success small"><i class="fa-solid fa-check-circle me-1"></i> Selesai</div>
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                <!-- Action Footer Buttons -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <a href="{{ route('student.classroom.show', $classroom) }}" class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-muted border border-2">
                        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Ruang Kelas
                    </a>
                    <button type="button" onclick="closeQuizTab()" class="btn rounded-pill px-4.5 py-2.5 fw-bold text-white shadow-sm btn-bouncy ms-auto" style="background:#8B5CF6;">
                        <i class="fa-solid fa-xmark me-2"></i> Tutup & Selesai
                    </button>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function closeQuizTab() {
    try {
        window.open('', '_self', '');
        window.close();
    } catch (e) {}

    try {
        if (window.opener && !window.opener.closed) {
            window.opener.focus();
        }
    } catch (e) {}

    // Fallback: Jika window.close() diblokir oleh browser (misal tab hasil form POST/navigasi), redirect kembali ke kelas
    setTimeout(function() {
        window.location.href = "{{ route('student.classroom.show', $classroom) }}";
    }, 100);
}

document.addEventListener('DOMContentLoaded', function() {
    const timeElements = document.querySelectorAll('.user-local-time');
    timeElements.forEach(el => {
        const utcStr = el.dataset.utc;
        if (utcStr) {
            const date = new Date(utcStr);
            if (!isNaN(date.getTime())) {
                const day   = String(date.getDate()).padStart(2, '0');
                const month = date.toLocaleString('id-ID', { month: 'short' });
                const year  = date.getFullYear();
                const hours = String(date.getHours()).padStart(2, '0');
                const mins  = String(date.getMinutes()).padStart(2, '0');

                el.textContent = `${day} ${month} ${year}, ${hours}:${mins}`;
            }
        }
    });
});
</script>
@endpush

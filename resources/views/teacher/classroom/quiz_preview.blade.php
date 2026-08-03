@extends('layouts.app')

@section('title', 'Laporan & Hasil Evaluasi Kuis - Pengajar')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">

        <!-- Header Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white border-start border-4" style="border-color:#8B5CF6 !important;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <span class="badge rounded-pill px-3 py-1.5 text-white fw-bold mb-2" style="background:#8B5CF6;">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Kelas: {{ $classroom->name }}
                    </span>
                    <h4 class="fw-bold text-main m-0">{{ $post->title ?? 'Hasil Evaluasi Kuis' }}</h4>
                    <p class="text-muted small m-0 mt-1">Daftar rekap pengerjaan, nilai, durasi waktu, dan kunci jawaban kuis siswa.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('teacher.classroom.quiz.export_excel', $quiz) }}" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm btn-bouncy">
                        <i class="fa-solid fa-file-excel me-2"></i>Ekspor Excel / CSV
                    </a>
                    <a href="{{ route('teacher.classroom.show', $classroom) }}" class="btn btn-light rounded-pill px-4 py-2 fw-bold border">
                        <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white text-center">
                    <small class="text-muted fw-semibold">Total Pengumpulan</small>
                    <h3 class="fw-extrabold text-main my-1">{{ $attempts->count() }}</h3>
                    <small class="text-purple fw-bold" style="color:#8B5CF6;">Siswa Mengisi</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white text-center">
                    <small class="text-muted fw-semibold">Jumlah Soal</small>
                    <h3 class="fw-extrabold text-main my-1">{{ $questions->count() }}</h3>
                    <small class="text-muted">Pilihan Ganda</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white text-center">
                    <small class="text-muted fw-semibold">Durasi Kuis</small>
                    <h3 class="fw-extrabold text-main my-1">{{ $quiz->duration_minutes }}</h3>
                    <small class="text-muted">Menit Alokasi</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white text-center">
                    <small class="text-muted fw-semibold">Rata-rata Nilai</small>
                    <h3 class="fw-extrabold text-success my-1">
                        {{ $attempts->count() > 0 ? round($attempts->avg('score')) : 0 }}
                    </h3>
                    <small class="text-muted">Skala {{ $quiz->max_score }}</small>
                </div>
            </div>
        </div>

        <!-- Section 1: Daftar Hasil Pengerjaan Siswa -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-main mb-3"><i class="fa-solid fa-users me-2 text-purple" style="color:#8B5CF6;"></i>Hasil Pengerjaan Siswa</h5>

            @if($attempts->isEmpty())
            <div class="text-center py-5">
                <i class="fa-solid fa-user-clock text-muted mb-3" style="font-size:3rem;"></i>
                <h6 class="fw-bold text-main">Belum Ada Siswa yang Mengerjakan</h6>
                <p class="text-muted small">Hasil pengerjaan siswa akan otomatis muncul di sini setelah kuis dikumpulkan.</p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small">
                            <th class="py-3 px-3">#</th>
                            <th class="py-3">Nama Siswa</th>
                            <th class="py-3">Waktu & Tanggal Pengisian</th>
                            <th class="py-3">Durasi Pengerjaan</th>
                            <th class="py-3 text-center">Nilai Akhir</th>
                            <th class="py-3 text-end px-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attempts as $idx => $att)
                        <tr>
                            <td class="px-3 fw-bold text-muted">{{ $idx + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-purple bg-opacity-10 text-purple fw-bold d-flex align-items-center justify-content-center" style="width:36px;height:36px;color:#8B5CF6;">
                                        {{ strtoupper(substr($att->player_name ?? 'S', 0, 1)) }}
                                    </div>
                                    <span class="fw-bold text-main">{{ $att->player_name ?? 'Siswa' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="small user-local-time fw-semibold" data-utc="{{ $att->taken_at ? $att->taken_at->toIso8601String() : $att->created_at->toIso8601String() }}">
                                    {{ $att->taken_at ? $att->taken_at->format('d M Y, H:i') : $att->created_at->format('d M Y, H:i') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-purple bg-opacity-10 text-purple border border-purple rounded-pill fw-bold px-3 py-1.5" style="color:#8B5CF6;">
                                    <i class="fa-regular fa-clock me-1" style="color:#8B5CF6;"></i> {{ $att->time_spent_formatted }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="fs-5 fw-extrabold" style="color:#8B5CF6;">{{ $att->score }}</span>
                                <small class="text-muted">/ {{ $quiz->max_score }}</small>
                            </td>
                            <td class="text-end px-3">
                                @if($att->score >= 70)
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5 fw-bold">LULUS</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1.5 fw-bold">BELUM LULUS</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- Section 2: Struktur Soal & Kunci Jawaban Kuis -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-main mb-3"><i class="fa-solid fa-list-check me-2 text-purple" style="color:#8B5CF6;"></i>Kunci Jawaban Soal</h5>

            <div class="d-flex flex-column gap-3">
                @foreach($questions as $qIdx => $q)
                <div class="border rounded-4 p-3.5 bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-purple small" style="color:#8B5CF6;">Soal #{{ $qIdx + 1 }}</span>
                        <span class="badge bg-white text-dark border small">Kunci Jawaban: <strong>{{ chr(65 + (int)$q->correct_index) }}</strong></span>
                    </div>
                    <p class="fw-semibold text-main mb-2" style="white-space:pre-line;">{{ $q->question }}</p>
                    
                    <div class="d-flex flex-wrap gap-2">
                        @if(is_array($q->options))
                            @foreach($q->options as $optIdx => $optTxt)
                            @php $isCorrect = ($optIdx === (int)$q->correct_index); @endphp
                            <div class="badge {{ $isCorrect ? 'bg-success text-white' : 'bg-white text-dark border' }} px-3 py-2 rounded-3 text-start fw-normal">
                                <strong>{{ chr(65 + $optIdx) }}.</strong> {{ $optTxt }} {{ $isCorrect ? '✓' : '' }}
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
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
@endsection

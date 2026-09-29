@extends('layouts.app')

@section('title', 'Pembahasan & Kunci Jawaban – ' . ($post->title ?? 'Kuis'))

@section('content')
<div class="row justify-content-center animate__animated animate__fadeIn">
    <div class="col-lg-9 col-xl-8">

        <!-- Navigasi Kembali -->
        <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="{{ route('student.classroom.quiz.result', [$quiz, $attempt]) }}" class="text-muted text-decoration-none small fw-semibold">
                <i class="fa-solid fa-arrow-left me-1.5"></i>Kembali ke Ringkasan Nilai
            </a>
            <span class="badge bg-white text-dark border rounded-pill px-3 py-1.5 shadow-xs small">
                <i class="fa-solid fa-user me-1 text-purple" style="color:#8B5CF6;"></i>{{ $attempt->player_name ?? 'Siswa' }}
            </span>
        </div>

        <!-- Banner Header Pembahasan -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white border-start border-4" style="border-color:#8B5CF6 !important;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <span class="badge rounded-pill px-3 py-1.5 text-white fw-bold mb-2 shadow-xs" style="background:#8B5CF6;">
                        <i class="fa-solid fa-file-circle-check me-1"></i> Pembahasan Soal Kuis
                    </span>
                    <h4 class="fw-bold text-main m-0">{{ $post->title ?? 'Evaluasi Kuis' }}</h4>
                    <p class="text-muted small m-0 mt-1">
                        Berikut rincian pengerjaan tiap butir soal, kunci jawaban yang benar, perolehan nilai, serta pembahasan dari pengajar.
                    </p>
                </div>
                <div class="text-end">
                    <span class="text-muted small d-block">Perolehan Nilai Akhir</span>
                    <span class="display-6 fw-extrabold" style="color:#8B5CF6;">{{ $attempt->score }}</span>
                    <span class="text-muted small fw-semibold">/ {{ $quiz->max_score }}</span>
                </div>
            </div>
        </div>

        @php
            $totalQ = $questions->count();
            $maxScore = (float) ($quiz->max_score ?? 100);
            $pointsPerQ = $totalQ > 0 ? round($maxScore / $totalQ, 2) : 0;
        @endphp

        <!-- Daftar Soal & Rincian Jawaban -->
        <div class="d-flex flex-column gap-4 mb-4">
            @foreach($questions as $qIdx => $q)
                @php
                    $ans = $answers->get($q->id);
                    $scoreEarned = $ans ? (float)$ans->score_earned : 0;
                    $isCorrect = $ans ? (bool)$ans->is_correct : false;

                    // Opsi yang dipilih siswa (A, B, C, D)
                    $selectedOpt = $ans ? trim($ans->selected_option) : null;
                    $selectedIdx = ($selectedOpt && $selectedOpt !== '-') ? (ord(strtoupper($selectedOpt)) - 65) : null;

                    $optPercentages = $q->option_percentages ?? [];
                    $correctIdx = (int) $q->correct_index;

                    // Status Jawaban: Benar, Sebagian, atau Salah
                    $status = 'wrong';
                    if ($scoreEarned >= $pointsPerQ && $pointsPerQ > 0) {
                        $status = 'correct';
                    } elseif ($scoreEarned > 0) {
                        $status = 'partial';
                    }
                @endphp

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                    <!-- Header Kartu Soal -->
                    <div class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2" style="background:#FAF5FF;">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold fs-6 text-purple" style="color:#8B5CF6;">
                                Soal {{ $qIdx + 1 }}
                            </span>
                            <span class="text-muted opacity-50">•</span>
                            @if($status === 'correct')
                                <span class="badge bg-success-subtle text-success border border-success rounded-pill px-2.5 py-1 small fw-semibold">
                                    <i class="fa-solid fa-circle-check me-1"></i>Benar
                                </span>
                            @elseif($status === 'partial')
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning rounded-pill px-2.5 py-1 small fw-semibold">
                                    <i class="fa-solid fa-circle-half-stroke me-1"></i>Sebagian Benar
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-2.5 py-1 small fw-semibold">
                                    <i class="fa-solid fa-circle-xmark me-1"></i>Salah
                                </span>
                            @endif
                        </div>

                        <!-- Perolehan Nilai Soal -->
                        <div class="badge bg-white text-dark border rounded-pill px-3 py-1.5 shadow-xs font-monospace fw-bold" style="font-size:0.82rem;">
                            Nilai: <span class="{{ $scoreEarned > 0 ? 'text-success' : 'text-danger' }}">{{ round($scoreEarned, 2) }}</span> / {{ $pointsPerQ }}
                        </div>
                    </div>

                    <!-- Isi Soal & Pilihan Jawaban -->
                    <div class="p-4">
                        <!-- Teks Pertanyaan -->
                        <h6 class="fw-bold text-main lh-base mb-3" style="white-space: pre-line; font-size:1.05rem;">
                            {{ $q->question }}
                        </h6>

                        <!-- Gambar Soal (Jika Ada) -->
                        @if(!empty($q->image_path))
                        <div class="mb-3.5 text-center text-md-start">
                            <a href="{{ asset('storage/' . $q->image_path) }}" target="_blank" title="Klik untuk memperbesar gambar">
                                <img src="{{ asset('storage/' . $q->image_path) }}" alt="Gambar Soal {{ $qIdx + 1 }}" class="img-fluid rounded-3 border shadow-xs" style="max-height: 280px; object-fit: contain; background: #fff;">
                            </a>
                            <div class="mt-1">
                                <small class="text-muted" style="font-size:0.75rem;"><i class="fa-solid fa-magnifying-glass-plus me-1"></i>Klik gambar untuk melihat ukuran asli</small>
                            </div>
                        </div>
                        @endif

                        <!-- Daftar Opsi Pilihan Jawaban -->
                        <div class="d-flex flex-column gap-2 mb-2">
                            @if(is_array($q->options))
                                @foreach($q->options as $optIdx => $optText)
                                    @php
                                        $letter = chr(65 + $optIdx);
                                        $isStudentChoice = ($selectedIdx !== null && $selectedIdx === $optIdx);
                                        $weight = isset($optPercentages[$optIdx]) ? (int)$optPercentages[$optIdx] : ($optIdx === $correctIdx ? 100 : 0);
                                        $isMainKey = ($weight === 100 || $optIdx === $correctIdx);

                                        // Styling opsi berdasarkan status pilihan
                                        $cardBg = '#F8FAFC';
                                        $borderColor = '#E2E8F0';
                                        $textColor = 'text-dark';

                                        if ($isStudentChoice && $isMainKey) {
                                            $cardBg = '#F0FDF4'; // Hijau soft
                                            $borderColor = '#22C55E';
                                        } elseif ($isStudentChoice && $weight > 0) {
                                            $cardBg = '#FEFCE8'; // Kuning soft
                                            $borderColor = '#EAB308';
                                        } elseif ($isStudentChoice && !$isMainKey) {
                                            $cardBg = '#FEF2F2'; // Merah soft
                                            $borderColor = '#EF4444';
                                        } elseif (!$isStudentChoice && $isMainKey) {
                                            $cardBg = '#F0FDF4'; // Kunci jawaban
                                            $borderColor = '#86EFAC';
                                        }
                                    @endphp

                                    <div class="p-3 rounded-4 d-flex align-items-center justify-content-between gap-3 border transition"
                                         style="background: {{ $cardBg }}; border-color: {{ $borderColor }} !important; border-width: 1.5px !important;">
                                        
                                        <div class="d-flex align-items-center gap-3 overflow-hidden flex-grow-1">
                                            <!-- Lingkaran Huruf -->
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold fs-6 flex-shrink-0"
                                                 style="width:34px; height:34px; {{ $isStudentChoice ? ($isMainKey ? 'background:#22C55E; color:#fff;' : 'background:#EF4444; color:#fff;') : 'background:#E2E8F0; color:#475569;' }}">
                                                {{ $letter }}
                                            </div>

                                            <div class="fw-medium text-main" style="font-size:0.92rem;">
                                                {{ $optText }}
                                            </div>
                                        </div>

                                        <!-- Badge Status Opsi -->
                                        <div class="d-flex align-items-center gap-1.5 flex-shrink-0">
                                            @if($isStudentChoice)
                                                @if($isMainKey)
                                                    <span class="badge bg-success text-white rounded-pill px-2.5 py-1 small fw-semibold">
                                                        <i class="fa-solid fa-check me-1"></i>Jawaban Anda (Benar)
                                                    </span>
                                                @elseif($weight > 0)
                                                    <span class="badge bg-warning text-dark rounded-pill px-2.5 py-1 small fw-semibold">
                                                        <i class="fa-solid fa-check me-1"></i>Jawaban Anda ({{ $weight }}%)
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger text-white rounded-pill px-2.5 py-1 small fw-semibold">
                                                        <i class="fa-solid fa-xmark me-1"></i>Jawaban Anda (Salah)
                                                    </span>
                                                @endif
                                            @endif

                                            @if($isMainKey && !$isStudentChoice)
                                                <span class="badge bg-success-subtle text-success border border-success rounded-pill px-2.5 py-1 small fw-semibold">
                                                    <i class="fa-solid fa-key me-1"></i>Kunci Jawaban Benar
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Kotak Penjelasan / Pembahasan Guru (Highlight Kuning seperti Gambar Referensi) -->
                        @if(!empty($q->explanation))
                        <div class="mt-3.5 p-3.5 rounded-3 border" style="background: #FEF9C3; border-color: #FDE047 !important; border-left: 4.5px solid #EAB308 !important;">
                            <div class="d-flex align-items-start gap-2.5">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-0.5" style="width: 24px; height: 24px; background: #CA8A04; color: #fff;">
                                    <i class="fa-solid fa-lightbulb" style="font-size: 0.75rem;"></i>
                                </div>
                                <div class="flex-grow-1 text-dark" style="font-size: 0.88rem; line-height: 1.55;">
                                    <strong class="d-block mb-1" style="color: #854D0E;">Pembahasan Soal:</strong>
                                    <div style="white-space: pre-line; color: #713F12;">{{ $q->explanation }}</div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>

        <!-- Footer Action Buttons -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-5">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <a href="{{ route('student.classroom.quiz.result', [$quiz, $attempt]) }}" class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-muted border border-2">
                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Ringkasan Nilai
                </a>
                <a href="{{ route('student.classroom.show', $classroom) }}" class="btn rounded-pill px-4.5 py-2.5 fw-bold text-white shadow-sm btn-bouncy ms-auto" style="background:#8B5CF6;">
                    <i class="fa-solid fa-graduation-cap me-2"></i>Kembali ke Ruang Kelas
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

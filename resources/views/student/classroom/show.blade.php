@extends('layouts.app')

@section('title', $classroom->name ?? 'Ruang Kelas')

@section('content')
{{-- HERO BANNER REDESIGN (VANJAVA IL EARNING BRANDED) --}}
<div class="card border-0 shadow-sm mb-4 overflow-hidden animate__animated animate__fadeInDown" 
     style="border-radius: 24px; background: linear-gradient(135deg, {{ $classroom->banner_color ?? 'var(--primary)' }} 0%, color-mix(in srgb, {{ $classroom->banner_color ?? '#16382a' }} 70%, #000) 100%);">
    <div class="p-4 p-md-5 position-relative text-white" style="min-height: 190px;">
        <!-- Decorative Background Elements -->
        <div class="position-absolute" style="right: -40px; bottom: -50px; opacity: 0.12; pointer-events: none;">
            <i class="fa-solid fa-{{ $classroom->banner_icon ?? 'graduation-cap' }}" style="font-size: 16rem; color: #ffffff;"></i>
        </div>
        <div class="position-absolute" style="right: 180px; top: -30px; opacity: 0.08; pointer-events: none;">
            <i class="fa-solid fa-book-open" style="font-size: 10rem; color: #ffffff;"></i>
        </div>

        <div class="position-relative" style="z-index: 2;">
            <div class="d-flex align-items-center gap-2 mb-2">
                @if($classroom->subject)
                <span class="badge rounded-pill px-3 py-1.5 fw-bold bg-dark bg-opacity-40 text-white shadow-sm border border-white border-opacity-20" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-book-journal-whills me-1 text-accent"></i> {{ strtoupper($classroom->subject) }}
                </span>
                @endif
                <span class="badge rounded-pill px-3 py-1.5 fw-bold bg-accent text-white shadow-sm" style="font-size: 0.72rem;">
                    <i class="fa-solid fa-users me-1"></i> {{ $totalMembers }} Siswa
                </span>
            </div>
            
            <h1 class="fw-bold display-6 mb-2 text-white" style="color: #ffffff !important; text-shadow: 0 2px 10px rgba(0,0,0,0.45);">
                {{ $classroom->name }}
            </h1>
            
            <div class="d-flex align-items-center gap-3 mt-3">
                <div class="d-flex align-items-center gap-2 bg-dark bg-opacity-40 border border-white border-opacity-20 rounded-pill px-3 py-1.5 shadow-sm">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&size=32&background=C9A66B&color=fff" 
                         class="rounded-circle border border-2 border-white shadow-sm" width="28" height="28" alt="Pengajar">
                    <span class="small fw-bold text-white me-1">Pengajar: <span class="text-accent">{{ $teacher->name }}</span></span>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4">
    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- SEGMENTED NAVIGATION TABS (CUSTOM BRANDED DESIGN) --}}
<div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-2">
    <ul class="nav nav-pills nav-justified flex-column flex-md-row gap-2" id="classroomTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-3 fw-bold py-2.5 btn-tab-custom" id="weeks-tab" data-bs-toggle="tab" data-bs-target="#weeks-pane" type="button" role="tab">
                <i class="fa-solid fa-layer-group me-2"></i> Kurikulum & Materi Mingguan (Week)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-3 fw-bold py-2.5 btn-tab-custom" id="feed-tab" data-bs-toggle="tab" data-bs-target="#feed-pane" type="button" role="tab">
                <i class="fa-solid fa-comments me-2"></i> Feed Diskusi Terbaru
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-3 fw-bold py-2.5 btn-tab-custom" id="classmates-tab" data-bs-toggle="tab" data-bs-target="#classmates-pane" type="button" role="tab">
                <i class="fa-solid fa-users me-2"></i> Teman Sekelas ({{ $totalMembers }})
            </button>
        </li>
    </ul>
</div>

<div class="tab-content" id="classroomTabContent">
    {{-- TAB 1: KURIKULUM BERBASIS MINGGU (MOODLE / ULS STYLE) --}}
    <div class="tab-pane fade show active" id="weeks-pane" role="tabpanel">
        <div class="row g-4">
            <div class="col-lg-8 animate__animated animate__fadeInLeft">
                @include('classroom.partials._week_accordion', ['classroom' => $classroom, 'posts' => $posts])
            </div>

            <div class="col-lg-4 animate__animated animate__fadeInRight">
                {{-- Progress & Quick Info Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center justify-content-between">
                            <span><i class="fa-solid fa-chart-line text-primary me-2"></i>Kemajuan Pembelajaran</span>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1">Aktif</span>
                        </h6>

                        @php $studentProgress = $classroom->getStudentProgressPercent(); @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted fw-semibold">Progres Pembelajaran</small>
                                <small class="fw-bold text-primary">{{ $studentProgress }}%</small>
                            </div>
                            <div class="progress rounded-pill" style="height: 8px;">
                                <div class="progress-bar bg-primary rounded-pill" style="width: {{ $studentProgress }}%;"></div>
                            </div>
                        </div>

                        <div class="row g-2 text-center pt-2">
                            <div class="col-4">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="fa-solid fa-file-pdf text-danger mb-1 d-block"></i>
                                    <small class="fw-bold text-dark d-block" style="font-size: 0.75rem;">Materi</small>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $classroom->posts->where('type', 'material')->count() }} Item</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="fa-solid fa-clipboard-list text-primary mb-1 d-block"></i>
                                    <small class="fw-bold text-dark d-block" style="font-size: 0.75rem;">Tugas</small>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $classroom->posts->where('type', 'assignment')->count() }} Item</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="fa-solid fa-pen-to-square text-success mb-1 d-block"></i>
                                    <small class="fw-bold text-dark d-block" style="font-size: 0.75rem;">Quiz</small>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $classroom->posts->where('type', 'quiz')->count() }} Item</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informal Teacher Card --}}
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user-gear text-primary me-2"></i>Pengajar Kelas</h6>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&size=48&background=16402E&color=fff" 
                             class="rounded-circle shadow-xs" width="44" height="44" alt="{{ $teacher->name }}">
                        <div>
                            <h6 class="fw-bold text-dark mb-0">{{ $teacher->name }}</h6>
                            <small class="text-muted">Guru Pengampu</small>
                        </div>
                    </div>
                </div>

                {{-- Card Teman Sekelas (Sidebar Ringkas) --}}
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-users text-primary"></i> Teman Sekelas
                        </h6>
                        <span class="badge bg-primary-subtle text-primary rounded-pill fw-bold">{{ $totalMembers }} Siswa</span>
                    </div>
                    <p class="text-muted small mb-3" style="font-size: 0.78rem;">Klik avatar atau nama untuk melihat profil teman sekelas Anda.</p>
                    <div class="d-flex flex-wrap gap-1 align-items-center mb-3">
                        @foreach($members as $member)
                        @php
                            $mIsMe = ($member->id === Auth::id());
                            $mJoinedRaw = $member->pivot->joined_at ?? $member->created_at;
                            $mJoinedDate = $mJoinedRaw ? \Carbon\Carbon::parse($mJoinedRaw)->translatedFormat('d F Y') : '-';
                            $mAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&size=120&background=' . ($mIsMe ? '0D9488' : '16402E') . '&color=fff&bold=true';
                        @endphp
                        <button type="button" class="btn p-0 border-0 bg-transparent btn-show-classmate"
                                data-name="{{ $member->name }}"
                                data-avatar="{{ $mAvatar }}"
                                data-joined="{{ $mJoinedDate }}"
                                data-isme="{{ $mIsMe ? 'true' : 'false' }}"
                                title="{{ $member->name }} (Klik untuk lihat profil)">
                            <img src="{{ $mAvatar }}"
                                 class="rounded-circle border border-2 border-white shadow-xs hover-scale"
                                 width="36" height="36" alt="{{ $member->name }}"
                                 style="margin-left: -4px;">
                        </button>
                        @endforeach
                        @if($totalMembers > 10)
                        <button type="button" class="btn p-0 border-0 bg-transparent" onclick="document.getElementById('classmates-tab').click();" title="Lihat semua teman">
                            <div class="rounded-circle bg-light border border-2 border-white shadow-xs d-flex align-items-center justify-content-center"
                                 style="width:36px;height:36px;margin-left:-4px;font-size:.68rem;font-weight:700;color:var(--primary);">
                                +{{ $totalMembers - 10 }}
                            </div>
                        </button>
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary rounded-pill btn-sm w-100 fw-semibold" onclick="document.getElementById('classmates-tab').click();">
                        <i class="fa-solid fa-users me-1.5"></i> Lihat Semua Teman Sekelas
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB 2: FEED DISKUSI --}}
    <div class="tab-pane fade" id="feed-pane" role="tabpanel">
        <div class="row g-4">
            <div class="col-lg-8 animate__animated animate__fadeInLeft">

                @forelse($posts as $post)
                <div class="card border-0 shadow-sm mb-4 overflow-hidden post-card rounded-4 bg-white">

                    {{-- Header Post --}}
                    <div class="card-header border-0 bg-white pt-4 pb-0 px-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm text-white"
                                 style="width:46px;height:46px;background:{{ $post->type_color }};flex-shrink:0;">
                                <i class="fa-solid fa-{{ $post->type_icon }}"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-main mb-0">{{ $post->author->name }}</h6>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="badge rounded-pill ms-auto px-3 py-1.5 fw-semibold"
                                  style="background:{{ $post->type_color }}18; color:{{ $post->type_color }}; font-size:.75rem;">
                                {{ $post->type_label ?? (['announcement'=>'Pengumuman','material'=>'Materi','assignment'=>'Tugas','quiz'=>'Evaluasi / Quiz','url'=>'Tautan URL'][$post->type] ?? 'Postingan') }}
                            </span>
                        </div>
                        @if($post->title)
                        <h5 class="fw-bold text-main mt-3 mb-0">{{ $post->title }}</h5>
                        @endif
                    </div>

                    <div class="card-body px-4 pb-4 pt-3">
                        {{-- Slide Deck Reader (Coursera Style) jika materi berupa slide --}}
                        {{-- Card Materi Interaktif (Link ke Halaman Khusus Pembelajaran) --}}
                        @if($post->type === 'material')
                        @php
                            $slidesList       = $post->slides;
                            $totalSlides      = count($slidesList);
                            $checkpointSlide  = $post->checkpoint_slide;
                            $firstAtt         = $post->attachments->first();
                            $isPdf            = $firstAtt && str_ends_with(strtolower($firstAtt->file_path), '.pdf');
                        @endphp

                        @if($post->body && !str_starts_with(trim($post->body), '{'))
                        <p class="text-muted mb-3" style="white-space:pre-line;">{{ $post->body }}</p>
                        @endif

                        <div class="card border-0 rounded-4 overflow-hidden shadow-xs mb-3" style="background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%); border: 1.5px solid #E2E8F0 !important;">
                            <div class="card-body p-3.5 p-md-4">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-4 d-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger shadow-xs" style="width: 52px; height: 52px; flex-shrink:0;">
                                            <i class="fa-solid {{ $isPdf ? 'fa-file-pdf' : 'fa-file-powerpoint' }} fs-3"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-main mb-1 fs-6">{{ $firstAtt ? $firstAtt->original_name : ($post->title ?? 'Materi Pembelajaran') }}</h6>
                                            <div class="d-flex align-items-center gap-2 flex-wrap text-muted small" style="font-size:0.78rem;">
                                                <span class="badge bg-white text-dark border rounded-pill px-2.5 py-1">
                                                    <i class="fa-solid fa-layer-group text-primary me-1"></i> {{ $totalSlides > 0 ? $totalSlides . ' Halaman Slide' : 'Dokumen PDF' }}
                                                </span>
                                                @if($checkpointSlide > 0)
                                                <span class="badge bg-primary-subtle text-primary border rounded-pill px-2.5 py-1">
                                                    <i class="fa-solid fa-lock me-1"></i> Checkpoint di Hal. {{ $checkpointSlide }}
                                                </span>
                                                @endif
                                                @if($firstAtt)
                                                <span class="text-muted"><i class="fa-solid fa-paperclip me-1"></i> {{ $firstAtt->file_size_human }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        @if($firstAtt)
                                        <a href="{{ route('attachment.download', $firstAtt) }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 btn-sm fw-semibold shadow-xs" title="Unduh File">
                                            <i class="fa-solid fa-download me-1"></i> Unduh
                                        </a>
                                        @endif
                                        <a href="{{ route('student.classroom.material.show', [$classroom, $post]) }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold btn-bouncy shadow-sm">
                                            <i class="fa-solid fa-book-open-reader me-1.5"></i> Buka Materi <i class="fa-solid fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($post->type === 'url')
                        @if($post->body)
                        <p class="text-muted mb-3" style="white-space:pre-line;">{{ $post->body }}</p>
                        @endif
                        @php
                            $targetLink = $post->url ?: $post->link_url;
                        @endphp
                        @if($targetLink)
                        <div class="card border-0 rounded-4 overflow-hidden shadow-xs mb-3" style="background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%); border: 1.5px solid #BAE6FD !important;">
                            <div class="card-body p-3.5">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-4 d-flex align-items-center justify-content-center bg-info bg-opacity-20 text-info shadow-xs" style="width: 50px; height: 50px; flex-shrink:0;">
                                            <i class="fa-solid fa-link fs-4 text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-main mb-1 fs-6">{{ $post->title ?? 'Tautan Link Web' }}</h6>
                                            <a href="{{ $targetLink }}" target="_blank" rel="noopener noreferrer" class="text-primary text-decoration-none small text-truncate d-block" style="max-width: 460px;">
                                                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>{{ $targetLink }}
                                            </a>
                                        </div>
                                    </div>
                                    <a href="{{ $targetLink }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary rounded-pill px-4 py-2 fw-bold btn-bouncy shadow-sm">
                                        <i class="fa-solid fa-arrow-up-right-from-square me-1.5"></i> Buka Tautan
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                        @elseif($post->body)
                        <p class="text-muted mb-3" style="white-space:pre-line;">{{ $post->body }}</p>
                        @endif

                        {{-- Info Tugas Interaktif --}}
                        @if($post->type === 'assignment' && $post->assignment)
                        @php $mySubmission = $post->assignment->mySubmission; @endphp
                        <div class="rounded-4 p-4 mb-3" style="background:{{ $mySubmission ? '#F0FDF4' : '#FEF2F2' }}; border-left:4px solid {{ $mySubmission ? '#22C55E' : '#EF4444' }};">
                            <div class="row align-items-center g-3">
                                <div class="col-sm-4">
                                    <div class="fw-bold small" style="color:{{ $mySubmission ? '#16A34A' : '#DC2626' }}">
                                        <i class="fa-solid fa-{{ $mySubmission ? 'circle-check' : 'clock' }} me-1"></i>
                                        {{ $mySubmission ? 'Sudah Dikumpulkan' : 'Belum Dikumpulkan' }}
                                    </div>
                                    <small class="text-muted">
                                        Tenggat: {{ $post->assignment->due_date?->format('d M Y, H:i') ?? 'Tidak ada' }}
                                    </small>
                                </div>
                                @if($mySubmission && $mySubmission->score !== null)
                                <div class="col-sm-3 text-center">
                                    <div class="fw-bold text-success" style="font-size:1.8rem;">{{ $mySubmission->score }}</div>
                                    <small class="text-muted">/ {{ $post->assignment->max_score }}</small>
                                </div>
                                @endif
                                <div class="col-sm-{{ $mySubmission && $mySubmission->score !== null ? '5' : '8' }} text-sm-end">
                                    <a href="{{ route('student.classroom.submission.show', $post->assignment) }}"
                                       class="btn rounded-pill fw-semibold btn-bouncy shadow-sm px-4"
                                       style="background:{{ $post->assignment->is_overdue && !$mySubmission ? '#EF4444' : 'var(--primary)' }}; color:#fff; border:none;">
                                        <i class="fa-solid fa-{{ $mySubmission ? 'eye' : 'upload' }} me-2"></i>
                                        {{ $mySubmission ? 'Lihat Kiriman' : 'Kumpulkan Tugas' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Info Kuis Kelas untuk Siswa --}}
                        @if($post->type === 'quiz' && $post->quiz)
                        @php
                            $userAttempts = \App\Models\QuizAttempt::query()
                                ->where(function($q) use ($post) {
                                    if (!empty($post->quiz->id)) {
                                        $q->where('quiz_id', $post->quiz->id);
                                    }
                                    if (!empty($post->quiz->quiz_set_id)) {
                                        $q->orWhere('quiz_set_id', $post->quiz->quiz_set_id);
                                    }
                                    if (!empty($post->quiz->quiz_master_id)) {
                                        $q->orWhere('quiz_master_id', $post->quiz->quiz_master_id);
                                    }
                                })
                                ->where(function($q) {
                                    $q->where('user_id', auth()->id())
                                      ->orWhere('student_id', auth()->id());
                                })
                                ->orderBy('created_at', 'desc')
                                ->get();
                            $hasAttempted = $userAttempts->isNotEmpty();
                            $lastAttempt  = $userAttempts->first();
                            $isSingleOnly = ((int)$post->quiz->max_attempts === 1);
                        @endphp
                        <div class="rounded-4 p-4 mb-3" style="background:#F3E8FF; border-left:4px solid #8B5CF6;">
                            <div class="row align-items-center g-3">
                                <div class="col-sm-7">
                                    <div class="fw-bold small d-flex align-items-center gap-2 flex-wrap" style="color:#8B5CF6;">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> Evaluasi / Quiz Kelas
                                        @if($post->quiz->show_score)
                                            <span class="badge bg-white text-purple border rounded-pill shadow-sm" style="font-size: 0.68rem; color:#8B5CF6;">👁️ Nilai Ditampilkan</span>
                                        @else
                                            <span class="badge bg-white text-muted border rounded-pill shadow-sm" style="font-size: 0.68rem;">🙈 Nilai Disembunyikan</span>
                                        @endif
                                        @if($isSingleOnly)
                                            <span class="badge bg-white text-dark border rounded-pill shadow-sm" style="font-size: 0.68rem;">🔒 1 Kali Pengerjaan</span>
                                        @else
                                            <span class="badge bg-white text-success border rounded-pill shadow-sm" style="font-size: 0.68rem;">🔄 Pengerjaan Berkali-kali</span>
                                        @endif
                                    </div>
                                    <div class="small text-muted mt-1">
                                        <i class="fa-solid fa-clock me-1 text-purple"></i> Durasi: {{ $post->quiz->duration_minutes }} Menit
                                        <span class="mx-2">•</span>
                                        <i class="fa-solid fa-calendar me-1 text-purple"></i> Tenggat: {{ $post->quiz->due_date ? $post->quiz->due_date->format('d M Y, H:i') : 'Tidak ada tenggat' }}
                                    </div>

                                    {{-- Keterangan Waktu Pengerjaan Jika 1 Kali Saja --}}
                                    @if($hasAttempted && $isSingleOnly)
                                    <div class="alert alert-success bg-white border border-success rounded-3 p-2.5 mt-2.5 mb-0 text-success small fw-semibold">
                                        <i class="fa-solid fa-circle-check me-1"></i> Anda telah menyelesaikan kuis ini pada <strong class="user-local-time" data-utc="{{ $lastAttempt->taken_at ? $lastAttempt->taken_at->toIso8601String() : $lastAttempt->created_at->toIso8601String() }}">{{ $lastAttempt->taken_at ? $lastAttempt->taken_at->format('d M Y, H:i') : $lastAttempt->created_at->format('d M Y, H:i') }}</strong>
                                        @if($post->quiz->show_score)
                                            <span class="ms-1">(Nilai Anda: <strong>{{ $lastAttempt->score }} / {{ $post->quiz->max_score }}</strong>)</span>
                                        @endif
                                    </div>
                                    @endif
                                </div>

                                <div class="col-sm-5 text-sm-end">
                                    @if($hasAttempted && $isSingleOnly)
                                        {{-- Tombol Lihat Hasil untuk 1 Kali Pengerjaan & Sudah Mengisi --}}
                                        <a href="{{ route('student.classroom.quiz.result', [$post->quiz, $lastAttempt]) }}" target="_blank" class="btn rounded-pill fw-bold btn-bouncy shadow-sm px-4 text-white" style="background:#8B5CF6;">
                                            <i class="fa-solid fa-square-poll-vertical me-2"></i>Lihat Hasil Evaluasi
                                        </a>
                                    @else
                                        {{-- Masih Bisa Mengerjakan --}}
                                        <a href="{{ route('student.classroom.quiz.show', $post->quiz) }}" target="_blank" class="btn rounded-pill fw-bold btn-bouncy shadow-sm px-4 text-white" style="background:#8B5CF6;">
                                            <i class="fa-solid fa-play me-2"></i>{{ $hasAttempted ? 'Ulangi Kerjakan Kuis' : 'Kerjakan Kuis' }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Riwayat Pengerjaan Berkali-kali --}}
                            @if($hasAttempted && !$isSingleOnly)
                            <div class="mt-3 pt-3 border-top border-purple border-opacity-25">
                                <div class="fw-bold small text-purple mb-2" style="color:#8B5CF6;">
                                    <i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat Pengerjaan Anda ({{ $userAttempts->count() }} kali):
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    @foreach($userAttempts as $attIndex => $att)
                                    <div class="bg-white rounded-3 p-2.5 px-3 border d-flex align-items-center justify-content-between small">
                                        <div>
                                            <span class="fw-bold text-main">Percobaan #{{ $userAttempts->count() - $attIndex }}</span>
                                            <span class="text-muted mx-2">•</span>
                                            <span class="text-muted user-local-time" data-utc="{{ $att->taken_at ? $att->taken_at->toIso8601String() : $att->created_at->toIso8601String() }}">{{ $att->taken_at ? $att->taken_at->format('d M Y, H:i') : $att->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($post->quiz->show_score)
                                            <span class="badge bg-purple bg-opacity-10 text-purple fw-bold px-3 py-1.5 fs-6" style="color:#8B5CF6;">
                                                Nilai: {{ $att->score }} / {{ $post->quiz->max_score }}
                                            </span>
                                            @else
                                            <span class="badge bg-light text-muted fw-semibold">Nilai Disembunyikan</span>
                                            @endif
                                            <a href="{{ route('student.classroom.quiz.result', [$post->quiz, $att]) }}" target="_blank" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold text-purple" style="color:#8B5CF6;">
                                                <i class="fa-solid fa-eye me-1"></i> Detail
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        {{-- Lampiran (Hanya untuk post selain materi) --}}
                        @if($post->type !== 'material' && $post->attachments->isNotEmpty())
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($post->attachments as $att)
                            <button type="button" 
                                    onclick="previewFile('{{ asset('storage/'.$att->file_path) }}', '{{ addslashes($att->original_name) }}', '{{ $att->file_size_human }}', 'fa-{{ $att->file_icon }}', '{{ route('attachment.download', $att) }}')"
                                    class="btn btn-light border rounded-3 d-inline-flex align-items-center gap-2 text-decoration-none py-2 px-3 btn-bouncy text-start">
                                <i class="fa-solid fa-{{ $att->file_icon }} text-primary"></i>
                                <span class="fw-semibold small text-main">{{ $att->original_name }}</span>
                                <small class="text-muted">{{ $att->file_size_human }}</small>
                            </button>
                            @endforeach
                        </div>
                        @endif

                        {{-- Area Komentar --}}
                        <div class="pt-3 border-top">
                            @if($post->comments->isNotEmpty())
                            <div class="mb-3">
                                @foreach($post->comments->take(3) as $comment)
                                @php
                                    $cStudent = $classmates->firstWhere('id', $comment->user_id);
                                    $cJoined = $cStudent ? ($cStudent->pivot->joined_at ?? $cStudent->created_at) : null;
                                    $cJoinedDate = $cJoined ? \Carbon\Carbon::parse($cJoined)->translatedFormat('d F Y') : '-';
                                    $cIsMe = ($comment->user_id === Auth::id());
                                    $cAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&size=120&background=' . ($cIsMe ? '0D9488' : '16402E') . '&color=fff&bold=true';
                                @endphp
                                <div class="d-flex gap-3 mb-2 align-items-start">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&size=32"
                                         class="rounded-circle mt-1 {{ $cStudent ? 'btn-show-classmate' : '' }}" 
                                         width="32" height="32" style="flex-shrink:0; cursor:{{ $cStudent ? 'pointer' : 'default' }};"
                                         @if($cStudent)
                                         data-name="{{ $comment->user->name }}"
                                         data-avatar="{{ $cAvatar }}"
                                         data-joined="{{ $cJoinedDate }}"
                                         data-isme="{{ $cIsMe ? 'true' : 'false' }}"
                                         title="Klik untuk lihat profil {{ $comment->user->name }}"
                                         @endif>
                                    <div class="bg-light rounded-3 px-3 py-2 flex-grow-1">
                                        <span class="fw-bold text-main small {{ $cStudent ? 'btn-show-classmate' : '' }}" 
                                              style="cursor:{{ $cStudent ? 'pointer' : 'default' }};"
                                              @if($cStudent)
                                              data-name="{{ $comment->user->name }}"
                                              data-avatar="{{ $cAvatar }}"
                                              data-joined="{{ $cJoinedDate }}"
                                              data-isme="{{ $cIsMe ? 'true' : 'false' }}"
                                              title="Klik untuk lihat profil {{ $comment->user->name }}"
                                              @endif>
                                            {{ $comment->user->name }}
                                            @if($cStudent)
                                            <i class="fa-solid fa-circle-info ms-1 text-primary opacity-50" style="font-size: 0.65rem;"></i>
                                            @endif
                                        </span>
                                        <p class="mb-0 small text-muted">{{ $comment->comment }}</p>
                                        <small class="text-muted" style="font-size:.65rem;">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @endforeach
                                @if($post->comments->count() > 3)
                                <small class="text-muted ms-5 ps-3">+{{ $post->comments->count()-3 }} komentar lainnya</small>
                                @endif
                            </div>
                            @endif

                            <form action="{{ route('classroom.comment.store', $post) }}" method="POST" class="d-flex gap-2 align-items-center">
                                @csrf
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=32"
                                     class="rounded-circle" width="32" height="32" style="flex-shrink:0;">
                                <input type="text" name="comment" class="form-control rounded-pill border-0 bg-light"
                                       placeholder="Tambahkan komentar..." required>
                                <button type="submit" class="btn btn-primary rounded-circle btn-bouncy shadow-sm" style="width:38px;height:38px;padding:0;flex-shrink:0;">
                                    <i class="fa-solid fa-paper-plane fa-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 bg-white rounded-4 shadow-sm p-4">
                    <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_jcikwtux.json" background="transparent" speed="1"
                                   style="width:160px;height:160px;margin:0 auto;" loop autoplay></lottie-player>
                    <h5 class="fw-bold text-main mt-3">Belum Ada Postingan</h5>
                    <p class="text-muted small mb-0">Pengajar belum mempublikasikan pengumuman atau tugas baru di kelas ini.</p>
                </div>
                @endforelse

                {{ $posts->links() }}
            </div>

            {{-- Sidebar Kanan --}}
            <div class="col-lg-4 animate__animated animate__fadeInRight">
                {{-- Card Pengajar & Deskripsi Kelas --}}
                <div class="card border-0 shadow-sm p-4 mb-4 rounded-4 bg-white">
                    <h6 class="fw-bold text-main mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-info text-primary"></i> Info Kelas
                    </h6>
                    <div class="d-flex align-items-center gap-3 mb-3 p-3 bg-light rounded-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&size=42&background=1F4D3A&color=fff" class="rounded-circle shadow-sm" width="42" height="42">
                        <div>
                            <div class="fw-bold text-main small">{{ $teacher->name }}</div>
                            <small class="text-muted"><i class="fa-solid fa-chalkboard-user me-1"></i>Pengajar Utama</small>
                        </div>
                    </div>
                    @if($classroom->description)
                    <p class="text-muted small mb-0 lh-sm">{{ $classroom->description }}</p>
                    @endif
                </div>

                {{-- Card Teman Sekelas (Sidebar Ringkas) --}}
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-main mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-users text-primary"></i> Teman Sekelas
                        </h6>
                        <span class="badge bg-primary-subtle text-primary rounded-pill fw-bold">{{ $totalMembers }} Siswa</span>
                    </div>
                    <p class="text-muted small mb-3" style="font-size: 0.78rem;">Klik avatar atau nama untuk melihat profil teman sekelas Anda.</p>
                    <div class="d-flex flex-wrap gap-1 align-items-center mb-3">
                        @foreach($members as $member)
                        @php
                            $mIsMe = ($member->id === Auth::id());
                            $mJoinedRaw = $member->pivot->joined_at ?? $member->created_at;
                            $mJoinedDate = $mJoinedRaw ? \Carbon\Carbon::parse($mJoinedRaw)->translatedFormat('d F Y') : '-';
                            $mAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&size=120&background=' . ($mIsMe ? '0D9488' : '16402E') . '&color=fff&bold=true';
                        @endphp
                        <button type="button" class="btn p-0 border-0 bg-transparent btn-show-classmate"
                                data-name="{{ $member->name }}"
                                data-avatar="{{ $mAvatar }}"
                                data-joined="{{ $mJoinedDate }}"
                                data-isme="{{ $mIsMe ? 'true' : 'false' }}"
                                title="{{ $member->name }} (Klik untuk lihat profil)">
                            <img src="{{ $mAvatar }}"
                                 class="rounded-circle border border-2 border-white shadow-xs hover-scale"
                                 width="36" height="36" alt="{{ $member->name }}"
                                 style="margin-left:-4px;">
                        </button>
                        @endforeach
                        @if($totalMembers > 10)
                        <button type="button" class="btn p-0 border-0 bg-transparent" onclick="document.getElementById('classmates-tab').click();" title="Lihat semua teman">
                            <div class="rounded-circle bg-light border border-2 border-white shadow-xs d-flex align-items-center justify-content-center"
                                 style="width:36px;height:36px;margin-left:-4px;font-size:.68rem;font-weight:700;color:var(--primary);">
                                +{{ $totalMembers - 10 }}
                            </div>
                        </button>
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary rounded-pill btn-sm w-100 fw-semibold" onclick="document.getElementById('classmates-tab').click();">
                        <i class="fa-solid fa-users me-1.5"></i> Lihat Semua Teman Sekelas
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB 3: DAFTAR TEMAN SEKELAS (PRIVACY COMPLIANT & FULLY RESPONSIVE) --}}
    <div class="tab-pane fade" id="classmates-pane" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
            <div class="card-header bg-white border-bottom p-4 px-md-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                             style="width: 46px; height: 46px; background: rgba(22, 64, 46, 0.1); color: var(--primary, #16402E);">
                            <i class="fa-solid fa-users fs-5"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h5 class="fw-bold text-dark mb-0">Teman Sekelas</h5>
                                <span class="badge bg-primary rounded-pill px-3 py-1 fw-semibold" id="studentCounterBadge">{{ $totalMembers }} Pelajar</span>
                            </div>
                            <small class="text-muted">Daftar seluruh teman yang terdaftar dan belajar di ruang kelas {{ $classroom->name }}</small>
                        </div>
                    </div>
                    
                    {{-- Privacy Notice Pill --}}
                    <div class="d-flex align-items-center gap-2 text-muted small bg-light rounded-pill px-3 py-1.5 border">
                        <i class="fa-solid fa-shield-halved text-success"></i>
                        <span style="font-size: 0.78rem;">Informasi kontak pribadi dilindungi demi privasi</span>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="p-2.5 bg-light rounded-4 border d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 ps-3 text-muted">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" id="classmateSearchInput" class="form-control bg-transparent border-0 shadow-none py-2"
                               placeholder="Ketik untuk mencari nama teman sekelas..." onkeyup="filterClassmates()">
                        <button type="button" class="btn btn-link text-muted pe-3 text-decoration-none d-none" id="clearClassmateSearch" onclick="clearClassmateSearch()">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 px-md-4">
                <div class="row g-3" id="classmatesContainer">
                    @forelse($classmates as $student)
                    @php
                        $isMe = ($student->id === Auth::id());
                        $joinedRaw = $student->pivot->joined_at ?? $student->created_at;
                        $joinedDate = $joinedRaw ? \Carbon\Carbon::parse($joinedRaw)->translatedFormat('d F Y') : '-';
                        $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&size=120&background=' . ($isMe ? '0D9488' : '16402E') . '&color=fff&bold=true';
                    @endphp
                    <div class="col-12 col-sm-6 col-lg-4 classmate-card-item" data-name="{{ strtolower($student->name) }}">
                        <div class="card border rounded-4 p-3 h-100 bg-white shadow-xs hover-elevate-subtle transition"
                             style="border: 1px solid #E2E8F0 !important; cursor: pointer;"
                             onclick="openClassmateModal('{{ addslashes($student->name) }}', '{{ $avatarUrl }}', '{{ $joinedDate }}', {{ $isMe ? 'true' : 'false' }})"
                             title="Klik untuk melihat profil {{ $student->name }}">
                            <div class="d-flex align-items-center gap-3">
                                <div class="position-relative flex-shrink-0">
                                    <img src="{{ $avatarUrl }}"
                                         class="rounded-circle shadow-xs" width="50" height="50" alt="{{ $student->name }}"
                                         style="border: 2px solid #F1F5F9; object-fit: cover;">
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle" style="width: 12px; height: 12px;"></span>
                                </div>
                                <div class="overflow-hidden flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between gap-1 mb-1">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate text-hover-primary" title="{{ $student->name }}" style="font-size: 0.95rem;">
                                            {{ $student->name }}
                                        </h6>
                                        @if($isMe)
                                        <span class="badge bg-primary text-white rounded-pill px-2 py-0.5 flex-shrink-0" style="font-size: 0.65rem;">Anda</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 0.76rem;">
                                        <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">
                                            <i class="fa-solid fa-graduation-cap me-1"></i> Pelajar
                                        </span>
                                    </div>
                                    <div class="text-muted mt-1.5 text-truncate" style="font-size: 0.74rem;">
                                        <i class="fa-regular fa-calendar-check text-primary me-1"></i>Bergabung: {{ $joinedDate }}
                                    </div>
                                </div>
                                <div class="text-muted opacity-50 flex-shrink-0">
                                    <i class="fa-solid fa-chevron-right fs-6"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="fa-solid fa-user-group fs-1 text-muted opacity-25 mb-3 d-block"></i>
                        <h6 class="fw-bold text-dark">Belum Ada Teman Sekelas</h6>
                        <p class="small text-muted mb-0">Belum ada pelajar lain yang bergabung ke kelas ini.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pencarian Tidak Ditemukan --}}
                <div id="noClassmateSearchResults" class="text-center py-5 text-muted d-none">
                    <i class="fa-solid fa-magnifying-glass fs-2 text-muted opacity-50 mb-2 d-block"></i>
                    <h6 class="fw-bold text-dark mb-1">Teman Tidak Ditemukan</h6>
                    <p class="small text-muted mb-0">Tidak ada teman sekelas dengan nama yang cocok dengan pencarian Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL POP-UP PROFIL TEMAN SEKELAS (PRIVACY SAFE: NO EMAIL, NO SENSITIVE DATA) --}}
<div class="modal fade" id="classmateProfileModal" tabindex="-1" aria-labelledby="classmateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            {{-- Header with Classroom Gradient --}}
            <div class="position-relative p-4 pb-5 text-center text-white" 
                 style="background: linear-gradient(135deg, {{ $classroom->banner_color ?? 'var(--primary, #16402E)' }} 0%, color-mix(in srgb, {{ $classroom->banner_color ?? '#16402E' }} 70%, #000) 100%);">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white px-3 py-1 fw-semibold mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-id-badge me-1"></i> PROFIL TEMAN SEKELAS
                </span>
                <div class="text-white text-opacity-75 small text-truncate px-3 mt-1">
                    {{ $classroom->name }}
                </div>
            </div>

            {{-- Body --}}
            <div class="modal-body px-4 pt-0 pb-4 text-center">
                {{-- Overlapping Avatar --}}
                <div class="position-relative d-inline-block mb-3" style="margin-top: -48px;">
                    <img id="classmateModalAvatar" 
                         src="" 
                         alt="Foto Profil" 
                         class="rounded-circle shadow border border-4 border-white bg-white" 
                         width="96" height="96" 
                         style="object-fit: cover;">
                    <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-2 border-white rounded-circle" title="Anggota Aktif">
                        <span class="visually-hidden">Aktif</span>
                    </span>
                </div>

                {{-- Name --}}
                <h5 class="fw-bold text-dark mb-1 text-break" id="classmateModalName">
                    <!-- Dynamic -->
                </h5>

                <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-1 fw-semibold" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-graduation-cap me-1"></i> Pelajar
                    </span>
                    <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 fw-semibold d-none" id="classmateModalMeBadge" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-user-check me-1"></i> Anda
                    </span>
                </div>

                {{-- Tanggal Bergabung (Hanya info publik aman, TANPA EMAIL ATAU DATA PRIVASI) --}}
                <div class="card border rounded-4 bg-light p-3 mb-3 text-center" style="border-color: #E2E8F0 !important;">
                    <div class="d-flex align-items-center justify-content-center gap-1.5 text-muted small fw-semibold mb-1">
                        <i class="fa-regular fa-calendar-check text-primary"></i>
                        <span>Tanggal Bergabung ke Kelas</span>
                    </div>
                    <div class="fw-bold text-dark fs-6" id="classmateModalJoined">
                        <!-- Dynamic -->
                    </div>
                    <small class="text-muted mt-1 d-block" style="font-size: 0.72rem;">
                        Terdaftar aktif dalam pembelajaran kelas ini
                    </small>
                </div>

                {{-- Action / Close --}}
                <button type="button" class="btn btn-light rounded-pill w-100 py-2 fw-semibold text-secondary shadow-xs border" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.post-card { transition: box-shadow .25s; }
.post-card:hover { box-shadow: 0 12px 30px rgba(0,0,0,.1) !important; }

.btn-tab-custom {
    color: var(--text-muted) !important;
    background: transparent;
    transition: all 0.25s ease;
}
.btn-tab-custom.active {
    background-color: var(--primary) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(31, 77, 58, 0.25) !important;
}
.btn-tab-custom:hover:not(.active) {
    background-color: var(--secondary) !important;
    color: var(--primary) !important;
}

.classmate-card-item .card {
    transition: all 0.2s ease-in-out;
}
.classmate-card-item .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08) !important;
    border-color: var(--primary) !important;
}
.classmate-card-item .card:hover .text-hover-primary {
    color: var(--primary) !important;
}
.hover-scale {
    transition: transform 0.2s ease;
}
.hover-scale:hover {
    transform: scale(1.12);
}
</style>
@endpush

@push('scripts')
<script>
// Classmate Profile Modal & Search Engine
window.openClassmateModal = function(name, avatar, joined, isMe) {
    const modalEl = document.getElementById('classmateProfileModal');
    if (!modalEl) return;

    document.getElementById('classmateModalName').textContent = name || '-';
    document.getElementById('classmateModalAvatar').src = avatar || 'https://ui-avatars.com/api/?name=User&size=120';
    document.getElementById('classmateModalJoined').textContent = joined || '-';

    const meBadge = document.getElementById('classmateModalMeBadge');
    if (meBadge) {
        if (isMe === true || isMe === 'true') {
            meBadge.classList.remove('d-none');
        } else {
            meBadge.classList.add('d-none');
        }
    }

    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
};

window.filterClassmates = function() {
    const input = document.getElementById('classmateSearchInput');
    if (!input) return;
    const query = input.value.toLowerCase().trim();
    const items = document.querySelectorAll('.classmate-card-item');
    const clearBtn = document.getElementById('clearClassmateSearch');
    const noResults = document.getElementById('noClassmateSearchResults');

    if (clearBtn) {
        clearBtn.classList.toggle('d-none', query.length === 0);
    }

    let visibleCount = 0;
    items.forEach(item => {
        const name = item.getAttribute('data-name') || '';
        if (name.includes(query)) {
            item.classList.remove('d-none');
            visibleCount++;
        } else {
            item.classList.add('d-none');
        }
    });

    if (noResults) {
        noResults.classList.toggle('d-none', visibleCount > 0 || items.length === 0);
    }
};

window.clearClassmateSearch = function() {
    const input = document.getElementById('classmateSearchInput');
    if (input) {
        input.value = '';
        window.filterClassmates();
        input.focus();
    }
};

// Global click delegation for classmate trigger buttons
document.addEventListener('click', function(e) {
    const trigger = e.target.closest('.btn-show-classmate');
    if (trigger) {
        e.preventDefault();
        e.stopPropagation();
        const name = trigger.getAttribute('data-name');
        const avatar = trigger.getAttribute('data-avatar');
        const joined = trigger.getAttribute('data-joined');
        const isMe = trigger.getAttribute('data-isme');
        window.openClassmateModal(name, avatar, joined, isMe);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Local Time conversion
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

    // Coursera-Style Slide Reader Engine
    const slideDecks = document.querySelectorAll('.slide-reader-deck');
    slideDecks.forEach(deck => {
        const deckId          = deck.dataset.deckId;
        const totalSlides     = parseInt(deck.dataset.total) || 1;
        const checkpointSlide = parseInt(deck.dataset.checkpointSlide) || 0;
        const correctIndex    = parseInt(deck.dataset.correctIndex);

        let currentSlideIdx = 0;
        let isCheckpointSolved = localStorage.getItem(`basakula_checkpoint_passed_${deckId}`) === 'true';

        const slideItems       = deck.querySelectorAll('.slide-content-item');
        const prevBtn          = deck.querySelector('.prev-slide-btn');
        const nextBtn          = deck.querySelector('.next-slide-btn');
        const nextBtnText      = deck.querySelector('.next-btn-text');
        const nextBtnIcon      = deck.querySelector('.next-btn-icon');
        const numBadge         = deck.querySelector('.current-slide-num');
        const titleBadge       = deck.querySelector('.current-slide-title');
        const pdfCanvas        = deck.querySelector('#pdfCanvas-' + deckId);
        const pdfLoading       = deck.querySelector('#pdfLoading-' + deckId);
        const pdfUrl           = deck.dataset.pdfUrl;
        const overlay          = document.getElementById('checkpointPopup-' + deckId);
        const submitCpBtn      = overlay ? overlay.querySelector('.submit-checkpoint-btn') : null;
        const reviewBtn        = overlay ? overlay.querySelector('.review-slide-btn') : null;
        const alertBox         = overlay ? overlay.querySelector('.checkpoint-alert') : null;
        const optionLabels     = overlay ? overlay.querySelectorAll('.checkpoint-opt-label') : null;

        let pdfDocInstance = null;
        let isRendering = false;
        let pageNumPending = null;

        function renderPdfPage(num) {
            if (!pdfDocInstance || !pdfCanvas) return;
            isRendering = true;
            pdfDocInstance.getPage(num).then(function(page) {
                const ctx = pdfCanvas.getContext('2d');
                const container = pdfCanvas.parentElement;
                const containerW = Math.max(300, (container ? container.clientWidth : 750) - 24);
                const containerH = Math.max(300, (container ? container.clientHeight : 560) - 24);
                const unscaledViewport = page.getViewport({ scale: 1.0 });

                const scaleX = containerW / unscaledViewport.width;
                const scaleY = containerH / unscaledViewport.height;
                const fitScale = Math.min(scaleX, scaleY);

                const dpr = window.devicePixelRatio || 1.5;
                const renderScale = fitScale * Math.max(1.5, dpr);
                const viewport = page.getViewport({ scale: renderScale });

                pdfCanvas.height = viewport.height;
                pdfCanvas.width  = viewport.width;

                const cssWidth  = Math.round(unscaledViewport.width * fitScale);
                const cssHeight = Math.round(unscaledViewport.height * fitScale);
                pdfCanvas.style.width  = cssWidth + 'px';
                pdfCanvas.style.height = cssHeight + 'px';

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                page.render(renderContext).promise.then(function() {
                    isRendering = false;
                    if (pageNumPending !== null) {
                        renderPdfPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });
        }

        function queueRenderPdfPage(num) {
            if (isRendering) {
                pageNumPending = num;
            } else {
                renderPdfPage(num);
            }
        }

        if (pdfUrl && window.pdfjsLib && pdfCanvas) {
            pdfjsLib.getDocument(pdfUrl).promise.then(function(doc) {
                pdfDocInstance = doc;
                if (pdfLoading) pdfLoading.classList.add('d-none');
                if (pdfCanvas) pdfCanvas.classList.remove('d-none');
                renderPdfPage(currentSlideIdx + 1);
            }).catch(function(e) {
                console.error("PDF load error:", e);
                if (pdfLoading) pdfLoading.innerHTML = '<p class="text-white-50 small mb-0">Klik tombol Layar Penuh / Unduh File untuk membuka dokumen.</p>';
            });
        }

        function updateDeckUI(idx) {
            currentSlideIdx = idx;

            // 1. Render actual PDF page on canvas
            if (pdfDocInstance) {
                queueRenderPdfPage(idx + 1);
            }

            // 2. Show/hide manual slide items
            slideItems.forEach((item, sIdx) => {
                item.classList.toggle('d-none', sIdx !== idx);
            });

            // 3. Update badge & progress
            numBadge.textContent = idx + 1;
            titleBadge.textContent = `Halaman ${idx + 1}`;

            const progressPct = ((idx + 1) / totalSlides) * 100;
            progressBar.style.width = `${progressPct}%`;

            // 4. Update dots
            dots.forEach((dot, dIdx) => {
                if (dIdx === idx) {
                    dot.style.width = '22px';
                    dot.style.background = '#3B82F6';
                } else {
                    dot.style.width = '8px';
                    dot.style.background = '#CBD5E1';
                }
            });

            // 5. Update Prev/Next Buttons
            prevBtn.disabled = (idx === 0);

            if (idx === totalSlides - 1) {
                nextBtnText.textContent = 'Selesai Membaca 🎉';
                nextBtnIcon.className = 'fa-solid fa-check ms-1';
                nextBtn.classList.remove('btn-primary');
                nextBtn.classList.add('btn-success');
            } else {
                nextBtnText.textContent = 'Selanjutnya';
                nextBtnIcon.className = 'fa-solid fa-chevron-right ms-1';
                nextBtn.classList.remove('btn-success');
                nextBtn.classList.add('btn-primary');
            }
        }

        prevBtn.addEventListener('click', () => {
            if (currentSlideIdx > 0) {
                updateDeckUI(currentSlideIdx - 1);
            }
        });

        nextBtn.addEventListener('click', () => {
            // Check if current slide is the checkpoint slide and student hasn't passed checkpoint yet
            if (checkpointSlide > 0 && (currentSlideIdx + 1) === checkpointSlide && !isCheckpointSolved && overlay) {
                // Trigger In-Slide Checkpoint Popup with Blurred Background!
                overlay.classList.remove('d-none');
                return;
            }

            if (currentSlideIdx < totalSlides - 1) {
                updateDeckUI(currentSlideIdx + 1);
            } else {
                // Completed final slide
                if (window.confetti) {
                    window.confetti({ particleCount: 100, spread: 80, origin: { y: 0.6 } });
                }
                if (nextBtnText) {
                    nextBtnText.textContent = 'Selesai Dibaca! 🎉';
                }
            }
        });

        // Checkpoint option highlight
        if (optionLabels) {
            optionLabels.forEach(label => {
                label.addEventListener('click', () => {
                    optionLabels.forEach(l => {
                        l.classList.remove('border-primary', 'bg-primary-subtle');
                        l.classList.add('bg-white');
                    });
                    label.classList.add('border-primary', 'bg-primary-subtle');
                    label.classList.remove('bg-white');
                });
            });
        }

        // Review slide button
        if (reviewBtn) {
            reviewBtn.addEventListener('click', () => {
                overlay.classList.add('d-none');
            });
        }

        // Submit checkpoint answer button
        if (submitCpBtn) {
            submitCpBtn.addEventListener('click', () => {
                const selectedRadio = overlay.querySelector(`input[name="checkpoint_ans_${deckId}"]:checked`);
                if (!selectedRadio) {
                    alertBox.className = 'checkpoint-alert alert alert-warning py-2.5 px-3 rounded-3 small fw-semibold mb-3';
                    alertBox.textContent = '⚠️ Silakan pilih salah satu jawaban terlebih dahulu.';
                    alertBox.classList.remove('d-none');
                    return;
                }

                const userAns = parseInt(selectedRadio.value);
                if (userAns === correctIndex) {
                    // Correct!
                    isCheckpointSolved = true;
                    localStorage.setItem(`basakula_checkpoint_passed_${deckId}`, 'true');

                    if (window.confetti) {
                        window.confetti({ particleCount: 70, spread: 60, origin: { y: 0.5 } });
                    }

                    alertBox.className = 'checkpoint-alert alert alert-success py-2.5 px-3 rounded-3 small fw-semibold mb-3';
                    alertBox.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> <strong>Jawaban Benar!</strong> Kunci terbuka. Melanjutkan membaca ke halaman berikutnya...';
                    alertBox.classList.remove('d-none');

                    setTimeout(() => {
                        overlay.classList.add('d-none');
                        if (currentSlideIdx < totalSlides - 1) {
                            updateDeckUI(currentSlideIdx + 1);
                        }
                    }, 1100);
                } else {
                    // Wrong!
                    alertBox.className = 'checkpoint-alert alert alert-danger py-2.5 px-3 rounded-3 small fw-semibold mb-3 animate__animated animate__headShake';
                    alertBox.innerHTML = '<i class="fa-solid fa-circle-xmark me-1"></i> <strong>Jawaban Kurang Tepat!</strong> Silakan baca ulang materi ini untuk menemukan jawaban yang benar.';
                    alertBox.classList.remove('d-none');
                }
            });
        }

        // Initialize deck UI
        updateDeckUI(0);
    });
});
</script>
@endpush

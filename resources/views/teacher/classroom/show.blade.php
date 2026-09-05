@extends('layouts.app')

@section('title', $classroom->name . ' – Kelola Kelas')

@section('content')
{{-- HERO BANNER KELAS REDESIGN --}}
<div class="card border-0 shadow-sm mb-4 overflow-hidden animate__animated animate__fadeInDown" 
     style="border-radius:24px; background: linear-gradient(135deg, {{ $classroom->banner_color ?? 'var(--primary)' }} 0%, color-mix(in srgb, {{ $classroom->banner_color ?? '#16382a' }} 70%, #000) 100%);">
    <div class="p-4 p-md-5 position-relative text-white" style="min-height:190px;">
        <i class="fa-solid fa-{{ $classroom->banner_icon ?? 'graduation-cap' }} position-absolute opacity-10"
           style="font-size:15rem; right:-20px; bottom:-40px; color:#ffffff;"></i>
        
        <div class="position-relative" style="z-index:2;">
            @if($classroom->subject)
            <span class="badge rounded-pill px-3 py-1.5 mb-2 fw-bold bg-dark bg-opacity-40 text-white shadow-sm border border-white border-opacity-20"
                  style="letter-spacing:.5px; font-size:.72rem;">
                <i class="fa-solid fa-book-journal-whills me-1 text-accent"></i> {{ strtoupper($classroom->subject) }}
            </span>
            @endif

            <h1 class="fw-bold display-6 mb-2 text-white" style="text-shadow:0 2px 10px rgba(0,0,0,.25);">{{ $classroom->name }}</h1>

            <div class="d-flex align-items-center gap-2 mt-3 flex-wrap">
                <div class="d-flex align-items-center gap-2 bg-dark bg-opacity-40 border border-white border-opacity-20 rounded-pill px-3 py-1.5 shadow-sm">
                    <span class="small fw-bold text-white"><i class="fa-solid fa-users me-1 text-accent"></i> {{ $students->count() }} Siswa</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-dark bg-opacity-40 border border-white border-opacity-20 rounded-pill px-3 py-1.5 shadow-sm">
                    <span class="small fw-bold text-white"><i class="fa-solid fa-key me-1 text-accent"></i> Kode: <strong class="text-accent" style="letter-spacing:2px;">{{ $classroom->code }}</strong></span>
                </div>
                <span class="badge bg-success text-white fw-bold px-3 py-2 rounded-pill shadow-sm">Status: Aktif</span>
            </div>
        </div>

        {{-- Tombol aksi --}}
        <div class="position-absolute top-0 end-0 p-4 d-flex gap-2" style="z-index: 3;">
            <div class="dropdown">
                <button class="btn btn-sm rounded-circle shadow bg-white text-primary border-0" style="width:38px;height:38px;padding:0;" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 py-2">
                    <li>
                        <a class="dropdown-item py-2 fw-semibold" href="{{ route('teacher.classroom.edit', $classroom) }}">
                            <i class="fa-solid fa-pen me-2 text-warning"></i>Edit Kelas
                        </a>
                    </li>
                    @can('manageMembers', $classroom)
                    <li>
                        <button type="button" class="dropdown-item py-2 fw-semibold text-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            <i class="fa-solid fa-user-plus me-2"></i>Tambah Pelajar
                        </button>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 fw-semibold text-secondary" href="{{ route('teacher.classroom.members', $classroom) }}">
                            <i class="fa-solid fa-users-gear me-2 text-info"></i>Kelola Anggota Kelas
                        </a>
                    </li>
                    @endcan
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ route('teacher.classroom.destroy', $classroom) }}" method="POST"
                              onsubmit="return confirm('Hapus kelas ini secara permanen?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="dropdown-item py-2 fw-semibold text-danger">
                                <i class="fa-solid fa-trash me-2"></i>Hapus Kelas
                            </button>
                        </form>
                    </li>
                </ul>
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

{{-- NAVIGASI TAB MODERN --}}
<style>
#classroomTab .nav-link {
    background-color: #F8FAFC;
    color: #475569;
    border: 1.5px solid #E2E8F0;
    transition: all 0.2s ease-in-out;
}
#classroomTab .nav-link:hover {
    background-color: #F1F5F9;
    color: #1E293B;
    border-color: #CBD5E1;
}
#classroomTab .nav-link.active {
    background-color: var(--primary, #059669) !important;
    color: #FFFFFF !important;
    border-color: var(--primary, #059669) !important;
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important;
}
</style>

<ul class="nav nav-pills gap-2 mb-4 animate__animated animate__fadeInUp" id="classroomTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-pill px-4 py-2 fw-semibold"
                id="tab-weeks" data-bs-toggle="pill" data-bs-target="#pane-weeks"
                type="button" role="tab" data-tab="weeks">
            <i class="fa-solid fa-layer-group me-2"></i>Kurikulum & Minggu (Week)
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill px-4 py-2 fw-semibold"
                id="tab-stream" data-bs-toggle="pill" data-bs-target="#pane-stream"
                type="button" role="tab" data-tab="stream">
            <i class="fa-solid fa-comment-dots me-2"></i>Stream Feed
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('teacher.classroom.members', $classroom) }}" 
           class="nav-link rounded-pill px-4 py-2 fw-semibold"
           id="tab-people">
            <i class="fa-solid fa-users me-2"></i>Anggota Kelas
        </a>
    </li>
</ul>

<div class="tab-content animate__animated animate__fadeInUp">
    {{-- ======================== WEEKS TAB ======================== --}}
    <div class="tab-pane fade show active" id="pane-weeks" role="tabpanel">
        <div class="row g-4">
            <div class="col-lg-8">
                @include('classroom.partials._week_accordion', ['classroom' => $classroom, 'posts' => $posts])
            </div>
            <div class="col-lg-4">
                {{-- Quick Progress / Information Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center justify-content-between">
                            <span><i class="fa-solid fa-chart-line text-primary me-2"></i>Ringkasan Kelas</span>
                            <span class="badge bg-success text-white rounded-pill px-2.5 py-1">Aktif</span>
                        </h6>

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

                {{-- Action Card --}}
                <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                    <a href="{{ route('teacher.classroom.post.create', $classroom) }}" class="btn btn-primary rounded-pill py-2.5 fw-semibold w-100 mb-2 shadow-xs">
                        <i class="fa-solid fa-plus me-1.5"></i> Upload Post / Materi Baru
                    </a>
                    <a href="{{ route('teacher.classroom.edit', $classroom) }}" class="btn btn-outline-secondary rounded-pill py-2 fw-semibold w-100 btn-sm">
                        <i class="fa-solid fa-gear me-1.5"></i> Pengaturan Kelas
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== STREAM TAB ======================== --}}
    <div class="tab-pane fade" id="pane-stream" role="tabpanel">
        <div class="row g-4">
            {{-- Feed --}}
            <div class="col-lg-8">
                @forelse($posts as $post)
                <div class="card border-0 shadow-sm mb-4 overflow-hidden" style="border-radius:18px;">
                    {{-- Header post --}}
                    <div class="card-header border-0 bg-white pt-4 pb-0 px-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm text-white"
                                     style="width:46px;height:46px;background:{{ $post->type_color }};flex-shrink:0;">
                                    <i class="fa-solid fa-{{ $post->type_icon }}"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-main mb-0">{{ $post->author->name }}</h6>
                                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge rounded-pill px-3 fw-semibold" style="background:{{ $post->type_color }}20; color:{{ $post->type_color }}; font-size:.72rem;">
                                    {{ $post->type_label ?? (['announcement'=>'Pengumuman','material'=>'Materi','assignment'=>'Tugas','quiz'=>'Evaluasi / Quiz','url'=>'Tautan URL'][$post->type] ?? 'Postingan') }}
                                </span>
                                <form action="{{ route('teacher.classroom.post.destroy', [$classroom, $post]) }}" method="POST"
                                      onsubmit="return confirm('Hapus postingan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-light btn-sm rounded-circle text-danger" style="width:32px;height:32px;padding:0;" title="Hapus">
                                        <i class="fa-solid fa-trash fa-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @if($post->title)
                        <h5 class="fw-bold text-main mt-3 mb-0">{{ $post->title }}</h5>
                        @endif
                    </div>

                    <div class="card-body px-4 pb-3 pt-2">
                        {{-- Card Materi Interaktif (Link ke Halaman Khusus Pratinjau Pembelajaran) --}}
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
                                        <a href="{{ route('teacher.classroom.material.show', [$classroom, $post]) }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold btn-bouncy shadow-sm">
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

                        {{-- Info Tugas --}}
                        @if($post->type === 'assignment' && $post->assignment)
                        <div class="rounded-4 p-3.5 mb-3 d-flex flex-wrap justify-content-between align-items-center gap-3" style="background:#FEF2F2; border-left:5px solid #EF4444;">
                            <div>
                                <div class="fw-bold text-danger small"><i class="fa-regular fa-clock me-1"></i> Tenggat Waktu</div>
                                <div class="fw-bold text-dark" style="font-size:0.95rem;">
                                    {{ $post->assignment->due_date ? $post->assignment->due_date->format('d M Y, H:i') : 'Tidak ada tenggat' }}
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-wrap ms-auto">
                                <div class="text-end">
                                    <div class="fw-bold text-primary small">Terkumpul</div>
                                    <div class="fw-bold text-dark fs-5">{{ $post->assignment->submissions->count() }} / {{ $students->count() }}</div>
                                </div>
                                <button type="button" class="btn btn-danger rounded-pill px-3.5 py-2 btn-sm fw-bold btn-bouncy shadow-sm" data-bs-toggle="modal" data-bs-target="#submissionModal{{ $post->assignment->id }}">
                                    <i class="fa-solid fa-folder-open me-1.5"></i> Periksa Pengumpulan ({{ $post->assignment->submissions->count() }})
                                </button>
                            </div>
                        </div>
                        @endif

                        {{-- Info Quiz --}}
                        @if($post->type === 'quiz' && $post->quiz)
                        <div class="rounded-3 p-3 mb-3 d-flex gap-3 align-items-center" style="background:#F3E8FF; border-left:4px solid #8B5CF6;">
                            <div>
                                <div class="fw-bold text-purple small d-flex align-items-center gap-2" style="color:#8B5CF6;">
                                    Evaluasi / Quiz Kelas
                                    @if($post->quiz->show_score)
                                        <span class="badge bg-white text-purple border rounded-pill shadow-sm" style="font-size: 0.68rem; color:#8B5CF6;">👁️ Nilai Tampil</span>
                                    @else
                                        <span class="badge bg-white text-muted border rounded-pill shadow-sm" style="font-size: 0.68rem;">🙈 Nilai Sembunyi</span>
                                    @endif
                                </div>
                                <div class="fw-semibold text-main small mt-1">
                                    <i class="fa-solid fa-clock me-1 text-purple"></i> Durasi: {{ $post->quiz->duration_minutes }} Menit
                                    <span class="mx-2">•</span>
                                    <i class="fa-solid fa-calendar me-1 text-purple"></i> Tenggat: {{ $post->quiz->due_date ? $post->quiz->due_date->format('d M Y, H:i') : 'Tidak ada tenggat' }}
                                </div>
                            </div>
                            <div class="ms-auto text-end d-flex gap-2">
                                <a href="{{ route('teacher.classroom.quiz.export_excel', $post->quiz) }}" 
                                   class="btn btn-sm btn-success rounded-pill fw-bold px-3 btn-bouncy shadow-sm" title="Download Spreadsheet / Excel Hasil Siswa">
                                    <i class="fa-solid fa-file-excel me-1"></i> Ekspor Excel / CSV
                                </a>
                                <a href="{{ route('teacher.classroom.quiz.preview_submissions', $post->quiz) }}" target="_blank" class="btn btn-sm rounded-pill text-white fw-bold px-3 btn-bouncy" style="background:#8B5CF6;">
                                    <i class="fa-solid fa-chart-simple me-1"></i> Preview Laporan Kuis
                                </a>
                            </div>
                        </div>
                        @endif

                        {{-- Lampiran (Hanya untuk post selain materi) --}}
                        @if($post->type !== 'material' && $post->attachments->isNotEmpty())
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($post->attachments as $att)
                            <button type="button" 
                                    onclick="previewFile('{{ asset('storage/' . $att->file_path) }}', '{{ addslashes($att->original_name) }}', '{{ $att->file_size_human }}', 'fa-{{ $att->file_icon }}', '{{ route('attachment.download', $att) }}')"
                                    class="btn btn-light border rounded-3 d-inline-flex align-items-center gap-2 text-decoration-none py-2 px-3 btn-bouncy text-start">
                                <i class="fa-solid fa-{{ $att->file_icon }} text-primary"></i>
                                <span class="fw-semibold small text-main">{{ $att->original_name }}</span>
                                <small class="text-muted">{{ $att->file_size_human }}</small>
                            </button>
                            @endforeach
                        </div>
                        @endif

                        {{-- Komentar --}}
                        <div class="pt-3 border-top">
                            @if($post->comments->isNotEmpty())
                            <div class="mb-3">
                                @foreach($post->comments->take(3) as $comment)
                                <div class="d-flex gap-3 mb-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&size=32"
                                         class="rounded-circle" width="32" height="32" style="flex-shrink:0;">
                                    <div class="bg-light rounded-3 px-3 py-2 flex-grow-1">
                                        <span class="fw-bold text-main small">{{ $comment->user->name }}</span>
                                        <p class="mb-0 small text-muted">{{ $comment->comment }}</p>
                                    </div>
                                    @if($comment->user_id === auth()->id())
                                    <form action="{{ route('classroom.comment.destroy', $comment) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-link text-danger p-0" style="font-size:.7rem;" title="Hapus">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <form action="{{ route('classroom.comment.store', $post) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=32"
                                     class="rounded-circle" width="32" height="32" style="flex-shrink:0;">
                                <input type="text" name="comment" class="form-control rounded-pill border-0 bg-light"
                                       placeholder="Tambahkan komentar kelas..." required>
                                <button type="submit" class="btn btn-primary rounded-circle btn-bouncy" style="width:38px;height:38px;padding:0;flex-shrink:0;">
                                    <i class="fa-solid fa-paper-plane fa-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_q7uarxsb.json" background="transparent" speed="1" style="width:140px;height:140px;margin:0 auto;" loop autoplay></lottie-player>
                    <p class="text-muted mt-3">Belum ada postingan. Mulai dengan membuat pengumuman!</p>
                    <a href="{{ route('teacher.classroom.post.create', $classroom) }}" class="btn btn-primary rounded-pill px-4 btn-bouncy">
                        <i class="fa-solid fa-plus me-2"></i>Buat Post Pertama
                    </a>
                </div>
                @endforelse

                {{ $posts->links() }}
            </div>

            {{-- Sidebar Kanan --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:18px;">
                    <h6 class="fw-bold text-main mb-3">Kode Gabung Kelas</h6>
                    <div class="rounded-3 p-4 text-center shadow-sm" style="background: linear-gradient(135deg, var(--primary) 0%, #16382a 100%);">
                        <h3 class="fw-bold text-white font-monospace mb-2" style="letter-spacing:4px; text-shadow:0 2px 8px rgba(0,0,0,0.3);">{{ $classroom->code }}</h3>
                        <small class="text-white-50 d-block">Bagikan kode ini ke siswa untuk bergabung</small>
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-4" style="border-radius:18px;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-main mb-0">Anggota Terbaru</h6>
                        @can('manageMembers', $classroom)
                        <a href="{{ route('teacher.classroom.members', $classroom) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-0.5 fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.74rem;">
                            <i class="fa-solid fa-users-gear"></i>
                            <span>Kelola</span>
                        </a>
                        @endcan
                    </div>
                    @forelse($students->take(5) as $student)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=36" class="rounded-circle" width="36" height="36">
                        <span class="fw-semibold text-main small">{{ $student->name }}</span>
                    </div>
                    @empty
                    <p class="text-muted small">Belum ada siswa.</p>
                    @endforelse
                    @if($students->count() > 5)
                    <a href="{{ route('teacher.classroom.members', $classroom) }}" class="text-primary small fw-semibold text-decoration-none d-block mt-1">
                        +{{ $students->count() - 5 }} siswa lainnya
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ======================== MODAL PERIKSA & PENILAIAN TUGAS SISWA ======================== --}}
@foreach($posts->where('type', 'assignment') as $post)
@if($post->assignment)
<div class="modal fade" id="submissionModal{{ $post->assignment->id }}" tabindex="-1" aria-labelledby="submissionModalLabel{{ $post->assignment->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-bottom p-4">
                <div>
                    <span class="badge bg-danger rounded-pill px-3 py-1 mb-1">
                        <i class="fa-solid fa-clipboard-list me-1"></i> Pengumpulan Tugas
                    </span>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="submissionModalLabel{{ $post->assignment->id }}">
                        {{ $post->title ?? ($post->body ? Str::limit(strip_tags($post->body), 60) : 'Detail Tugas') }}
                    </h5>
                    <small class="text-muted">
                        <i class="fa-regular fa-clock me-1 text-danger"></i> Tenggat: {{ $post->assignment->due_date ? $post->assignment->due_date->translatedFormat('d F Y, H:i') : 'Tidak ada tenggat' }} 
                        &bull; Nilai Maksimal: <strong>{{ $post->assignment->max_score }}</strong>
                        &bull; Terkumpul: <strong class="text-primary">{{ $post->assignment->submissions->count() }} dari {{ $students->count() }} Siswa</strong>
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4 bg-light bg-opacity-25">
                @if($post->assignment->submissions->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-folder-open fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                    <h6 class="fw-bold text-dark">Belum ada siswa yang mengumpulkan tugas ini.</h6>
                    <p class="small text-muted mb-0">File tugas yang diunggah siswa akan langsung muncul di sini secara otomatis.</p>
                </div>
                @else
                <div class="table-responsive bg-white rounded-4 border shadow-sm">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-dark fw-bold border-bottom" style="font-size: 0.88rem;">
                            <tr>
                                <th class="ps-4 py-3">Siswa</th>
                                <th class="py-3">Waktu Pengumpulan</th>
                                <th class="py-3">Berkas / File Tugas</th>
                                <th class="py-3">Status & Nilai</th>
                                <th class="text-end pe-4 py-3">Beri / Ubah Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($post->assignment->submissions as $sub)
                            <tr>
                                <td class="ps-4 py-3.5">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center" style="width:40px;height:40px;font-size:0.95rem;">
                                            {{ strtoupper(substr($sub->student->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size:0.95rem;">{{ $sub->student->name ?? 'Siswa' }}</div>
                                            <small class="text-muted font-monospace">{{ $sub->student->user_code ?? $sub->student->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5">
                                    <div class="fw-semibold text-dark" style="font-size: 0.88rem;">
                                        {{ $sub->submitted_at ? $sub->submitted_at->translatedFormat('d M Y, H:i') : '-' }}
                                    </div>
                                    @if($post->assignment->due_date && $sub->submitted_at && $sub->submitted_at->greaterThan($post->assignment->due_date))
                                        <span class="badge bg-warning text-dark rounded-pill" style="font-size: 0.7rem;">Terlambat</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 0.7rem;">Tepat Waktu</span>
                                    @endif
                                </td>
                                <td class="py-3.5">
                                    @if($sub->file_path)
                                    <div class="d-flex flex-column gap-1">
                                        <a href="{{ asset('storage/' . $sub->file_path) }}" target="_blank" 
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5 shadow-xs" 
                                           style="width: fit-content;" title="Klik untuk mengunduh atau membuka file siswa di tab baru">
                                            <i class="fa-solid fa-file-arrow-down fs-6"></i>
                                            <span>{{ $sub->original_name ?? 'Unduh Berkas' }}</span>
                                        </a>
                                        @if($sub->note)
                                        <small class="text-muted fst-italic mt-1" style="font-size: 0.8rem;">
                                            <i class="fa-regular fa-comment-dots me-1"></i>"{{ $sub->note }}"
                                        </small>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-muted small"><i class="fa-solid fa-ban me-1"></i> Tidak ada file</span>
                                    @endif
                                </td>
                                <td class="py-3.5">
                                    @if($sub->status === 'graded')
                                        <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill bg-success-subtle text-success fw-bold" style="font-size:0.82rem;">
                                            <i class="fa-solid fa-circle-check"></i>
                                            <span>Nilai: {{ $sub->score }} / {{ $post->assignment->max_score }}</span>
                                        </div>
                                        @if($sub->teacher_feedback)
                                        <div class="text-muted small mt-1" style="font-size:0.78rem;">
                                            <strong>Feedback:</strong> {{ $sub->teacher_feedback }}
                                        </div>
                                        @endif
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2.5 py-1 fw-bold" style="font-size:0.75rem;">
                                            ⏳ Menunggu Dinilai
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4 py-3.5">
                                    <button class="btn btn-sm btn-dark rounded-pill px-3 py-1.5 fw-semibold shadow-xs" 
                                            type="button" data-bs-toggle="collapse" data-bs-target="#gradeForm{{ $sub->id }}" aria-expanded="false">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> {{ $sub->status === 'graded' ? 'Ubah Nilai' : 'Beri Nilai' }}
                                    </button>
                                </td>
                            </tr>
                            <tr class="collapse bg-light" id="gradeForm{{ $sub->id }}">
                                <td colspan="5" class="p-3.5 border-top">
                                    <form action="{{ route('teacher.classroom.submission.grade', $sub) }}" method="POST" class="row g-2 align-items-center">
                                        @csrf
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-white fw-bold">Skor (Maks {{ $post->assignment->max_score }})</span>
                                                <input type="number" name="score" class="form-control" min="0" max="{{ $post->assignment->max_score }}" 
                                                       value="{{ old('score', $sub->score) }}" placeholder="Contoh: 90" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="teacher_feedback" class="form-control form-control-sm" 
                                                   value="{{ old('teacher_feedback', $sub->teacher_feedback) }}" 
                                                   placeholder="Catatan / Feedback untuk siswa (Opsional)...">
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3.5 py-1.5 fw-bold shadow-xs">
                                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Nilai
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <div class="modal-footer bg-white border-top p-3">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

{{-- Modal Edit Judul Week Header --}}
<div class="modal fade" id="editWeekTitleModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold modal-title" style="color: #16402E;">Edit Judul Header Minggu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('teacher.classroom.week.title.update', $classroom) }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <input type="hidden" name="week_number" id="modalWeekNumberInput" value="1">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Topik / Header Minggu</label>
                        <input type="text" name="title" id="modalWeekTitleInput" class="form-control rounded-3" placeholder="Contoh: Pengenalan Basa Jawa" required>
                    </div>
                    <small class="text-muted">Judul ini akan langsung menggantikan nama header minggu di ruang kelas siswa (misal: <em>Week 1 - Pengenalan Basa Jawa</em>).</small>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white rounded-pill px-4 fw-semibold" style="background: #16402E;"><i class="fa-solid fa-save me-1"></i> Simpan Judul</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('teacher.classroom.partials._add_student_modal')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slideDecks = document.querySelectorAll('.slide-reader-deck');
    slideDecks.forEach(deck => {
        const deckId      = deck.dataset.deckId;
        const totalSlides = parseInt(deck.dataset.total) || 1;
        let currentSlideIdx = 0;

        const slideItems  = deck.querySelectorAll('.slide-content-item');
        const pdfCanvas   = deck.querySelector('#pdfCanvas' + deckId);
        const pdfLoading  = deck.querySelector('#pdfLoading' + deckId);
        const pdfUrl      = deck.dataset.pdfUrl;
        const prevBtn     = deck.querySelector('.prev-slide-btn');
        const nextBtn     = deck.querySelector('.next-slide-btn');
        const nextBtnText = deck.querySelector('.next-btn-text');
        const nextBtnIcon = deck.querySelector('.next-btn-icon');
        const numBadge    = deck.querySelector('.current-slide-num');
        const titleBadge  = deck.querySelector('.current-slide-title');
        const progressBar = deck.querySelector('.slide-progress-bar');
        const dots        = deck.querySelectorAll('.slide-dot');

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

            // Render PDF page
            if (pdfDocInstance) {
                queueRenderPdfPage(idx + 1);
            }

            slideItems.forEach((item, sIdx) => {
                item.classList.toggle('d-none', sIdx !== idx);
            });

            if (numBadge) numBadge.textContent = idx + 1;
            if (titleBadge) titleBadge.textContent = `Halaman ${idx + 1}`;

            const progressPct = ((idx + 1) / totalSlides) * 100;
            if (progressBar) progressBar.style.width = `${progressPct}%`;

            if (dots) {
                dots.forEach((dot, dIdx) => {
                    if (dIdx === idx) {
                        dot.style.width = '22px';
                        dot.style.background = '#3B82F6';
                    } else {
                        dot.style.width = '8px';
                        dot.style.background = '#CBD5E1';
                    }
                });
            }

            if (prevBtn) prevBtn.disabled = (idx === 0);

            if (idx === totalSlides - 1) {
                if (nextBtnText) nextBtnText.textContent = 'Selesai';
                if (nextBtnIcon) nextBtnIcon.className = 'fa-solid fa-check ms-1';
            } else {
                if (nextBtnText) nextBtnText.textContent = 'Selanjutnya';
                if (nextBtnIcon) nextBtnIcon.className = 'fa-solid fa-chevron-right ms-1';
            }
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (currentSlideIdx > 0) updateDeckUI(currentSlideIdx - 1);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                if (currentSlideIdx < totalSlides - 1) {
                    updateDeckUI(currentSlideIdx + 1);
                }
            });
        }

        updateDeckUI(0);
    });

    // Tab URL Routing (Support #weeks, #stream, #people, #anggota & ?tab=...)
    function activateTabFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');
        const hash = (window.location.hash || '').replace('#', '').toLowerCase();
        const target = tabParam || hash;

        if (target) {
            let targetBtn = null;
            if (target === 'weeks' || target === 'kurikulum') {
                targetBtn = document.getElementById('tab-weeks');
            } else if (target === 'stream' || target === 'feed') {
                targetBtn = document.getElementById('tab-stream');
            } else if (target === 'people' || target === 'anggota' || target === 'members' || target === 'pane-people') {
                window.location.href = "{{ route('teacher.classroom.members', $classroom) }}";
                return;
            }

            if (targetBtn) {
                const tabInstance = bootstrap.Tab.getOrCreateInstance(targetBtn);
                tabInstance.show();
            }
        }
    }

    // Update URL hash saat tab diklik
    document.querySelectorAll('#classroomTab button[data-bs-toggle="pill"]').forEach(btn => {
        btn.addEventListener('shown.bs.tab', () => {
            const tabKey = btn.getAttribute('data-tab');
            if (tabKey) {
                history.replaceState(null, null, '#' + tabKey);
            }
        });
    });

    activateTabFromUrl();
    window.addEventListener('hashchange', activateTabFromUrl);
});
</script>
@endpush



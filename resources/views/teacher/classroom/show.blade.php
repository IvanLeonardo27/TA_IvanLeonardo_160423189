@extends('layouts.app')

@section('title', $classroom->name . ' – Kelola Kelas')

@section('content')
{{-- HERO BANNER KELAS REDESIGN --}}
<div class="card border-0 shadow-sm mb-4 overflow-hidden animate__animated animate__fadeInDown" 
     style="border-radius:24px; background: linear-gradient(135deg, var(--primary) 0%, #16382a 100%);">
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
            <a href="{{ route('teacher.classroom.post.create', $classroom) }}"
               class="btn btn-sm fw-bold rounded-pill shadow btn-bouncy px-3 py-2 bg-white text-primary border-0">
                <i class="fa-solid fa-plus me-1"></i> Tambah Post
            </a>
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
<ul class="nav gap-2 mb-4 animate__animated animate__fadeInUp" id="classroomTab" role="tablist">
    @foreach([['stream','Stream','comment-dots'],['classwork','Tugas Kelas','book-open'],['people','Anggota','users']] as [$key, $label, $icon])
    <li class="nav-item">
        <button class="btn rounded-pill px-4 py-2 fw-semibold {{ $loop->first ? 'btn-primary shadow' : 'btn-light text-muted' }}"
                id="tab-{{ $key }}" data-bs-toggle="pill" data-bs-target="#pane-{{ $key }}"
                type="button" role="tab">
            <i class="fa-solid fa-{{ $icon }} me-2"></i>{{ $label }}
        </button>
    </li>
    @endforeach
</ul>

<div class="tab-content animate__animated animate__fadeInUp">

    {{-- ======================== STREAM TAB ======================== --}}
    <div class="tab-pane fade show active" id="pane-stream" role="tabpanel">
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
                                    {{ ['announcement'=>'Pengumuman','material'=>'Materi','assignment'=>'Tugas','quiz'=>'Evaluasi / Quiz'][$post->type] }}
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
                        @elseif($post->body)
                        <p class="text-muted mb-3" style="white-space:pre-line;">{{ $post->body }}</p>
                        @endif

                        {{-- Info Tugas --}}
                        @if($post->type === 'assignment' && $post->assignment)
                        <div class="rounded-3 p-3 mb-3 d-flex gap-3 align-items-center" style="background:#FEF2F2; border-left:4px solid #EF4444;">
                            <div>
                                <div class="fw-bold text-danger small">Tenggat Waktu</div>
                                <div class="fw-semibold text-main">
                                    {{ $post->assignment->due_date ? $post->assignment->due_date->format('d M Y, H:i') : 'Tidak ada tenggat' }}
                                </div>
                            </div>
                            <div class="ms-auto text-end">
                                <div class="fw-bold text-primary small">Terkumpul</div>
                                <div class="fw-bold text-main fs-5">{{ $post->assignment->submissions->count() }} / {{ $students->count() }}</div>
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
                    <h6 class="fw-bold text-main mb-3">Anggota Terbaru</h6>
                    @forelse($students->take(5) as $student)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=36" class="rounded-circle" width="36" height="36">
                        <span class="fw-semibold text-main small">{{ $student->name }}</span>
                    </div>
                    @empty
                    <p class="text-muted small">Belum ada siswa.</p>
                    @endforelse
                    @if($students->count() > 5)
                    <a href="#pane-people" onclick="document.getElementById('tab-people').click()" class="text-primary small fw-semibold text-decoration-none d-block mt-1">
                        +{{ $students->count() - 5 }} siswa lainnya
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== CLASSWORK TAB ======================== --}}
    <div class="tab-pane fade" id="pane-classwork" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold text-main m-0">Semua Tugas & Materi</h5>
            <a href="{{ route('teacher.classroom.post.create', $classroom) }}" class="btn btn-primary rounded-pill px-4 btn-bouncy">
                <i class="fa-solid fa-plus me-2"></i>Tambah
            </a>
        </div>

        @php $assignments = $posts->where('type', 'assignment'); @endphp
        @forelse($assignments as $post)
        <div class="card border-0 shadow-sm mb-3 d-flex flex-row align-items-center p-4 gap-4" style="border-radius:16px; border-left:5px solid #EF4444 !important;">
            <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center" style="width:50px;height:50px;flex-shrink:0;">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="fw-bold text-main mb-1">{{ $post->title ?? 'Tugas' }}</h6>
                <small class="text-muted">
                    Tenggat: {{ $post->assignment?->due_date?->format('d M Y, H:i') ?? 'Tidak ada' }}
                </small>
            </div>
            <div class="text-end">
                <h5 class="fw-bold text-primary mb-0">{{ $post->assignment?->submissions->count() ?? 0 }} / {{ $students->count() }}</h5>
                <small class="text-muted">Terkumpul</small>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <p class="text-muted">Belum ada tugas yang dibuat untuk kelas ini.</p>
        </div>
        @endforelse
    </div>

    {{-- ======================== PEOPLE TAB ======================== --}}
    <div class="tab-pane fade" id="pane-people" role="tabpanel">
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:18px;">
            <div class="d-flex justify-content-between align-items-center border-bottom border-primary pb-3 mb-4">
                <h5 class="fw-bold text-primary m-0">Pengajar</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=45" class="rounded-circle shadow-sm" width="45" height="45">
                <div>
                    <h6 class="fw-bold text-main mb-0">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">Pengajar Utama</small>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4" style="border-radius:18px;">
            <div class="d-flex justify-content-between align-items-center border-bottom border-primary pb-3 mb-4">
                <h5 class="fw-bold text-primary m-0">Siswa <span class="badge bg-primary rounded-pill ms-2">{{ $students->count() }}</span></h5>
            </div>
            <div class="row g-3">
                @forelse($students as $student)
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=40" class="rounded-circle" width="40" height="40">
                            <div>
                                <h6 class="fw-bold text-main mb-0 small">{{ $student->name }}</h6>
                                <small class="text-muted">{{ $student->email }}</small>
                            </div>
                        </div>
                        <form action="{{ route('teacher.classroom.member.remove', [$classroom, $student]) }}" method="POST"
                              onsubmit="return confirm('Keluarkan {{ $student->name }} dari kelas?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-light btn-sm rounded-circle text-danger" style="width:32px;height:32px;padding:0;" title="Keluarkan">
                                <i class="fa-solid fa-xmark fa-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-muted">Belum ada siswa yang bergabung.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
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
                const canvasArea = deck.querySelector('.slide-canvas-area');
                const availableWidth = Math.min((canvasArea ? canvasArea.clientWidth : 750) - 30, 850) || 720;
                const unscaledViewport = page.getViewport({ scale: 1 });
                const scale = (availableWidth / unscaledViewport.width) * 1.5;
                const viewport = page.getViewport({ scale: scale });

                pdfCanvas.height = viewport.height;
                pdfCanvas.width  = viewport.width;

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
});
</script>
@endpush

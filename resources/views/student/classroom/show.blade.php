@extends('layouts.app')

@section('title', $classroom->name ?? 'Ruang Kelas')

@section('content')
{{-- HERO BANNER REDESIGN (VANJAVA IL EARNING BRANDED) --}}
<div class="card border-0 shadow-sm mb-4 overflow-hidden animate__animated animate__fadeInDown" 
     style="border-radius: 24px; background: linear-gradient(135deg, var(--primary) 0%, #16382a 100%);">
    <div class="p-4 p-md-5 position-relative text-white" style="min-height: 190px;">
        <!-- Decorative Background Elements -->
        <div class="position-absolute" style="right: -40px; bottom: -50px; opacity: 0.12;">
            <i class="fa-solid fa-graduation-cap" style="font-size: 16rem; color: #ffffff;"></i>
        </div>
        <div class="position-absolute" style="right: 180px; top: -30px; opacity: 0.08;">
            <i class="fa-solid fa-book-open" style="font-size: 10rem; color: #ffffff;"></i>
        </div>

        <div class="position-relative" style="z-index: 2;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge rounded-pill px-3 py-1.5 fw-bold bg-white bg-opacity-20 text-white shadow-sm" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-book-journal-whills me-1"></i> {{ strtoupper($classroom->subject ?? 'Bahasa Jawa') }}
                </span>
                <span class="badge rounded-pill px-3 py-1.5 fw-bold bg-accent text-white shadow-sm" style="font-size: 0.72rem;">
                    <i class="fa-solid fa-users me-1"></i> {{ $totalMembers }} Siswa
                </span>
            </div>
            
            <h1 class="fw-bold display-6 mb-2 text-white" style="text-shadow: 0 2px 10px rgba(0,0,0,0.25);">
                {{ $classroom->name }}
            </h1>
            
            <div class="d-flex align-items-center gap-3 mt-3">
                <div class="d-flex align-items-center gap-2 bg-white bg-opacity-15 rounded-pill px-3 py-1.5 backdrop-blur">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&size=32&background=C9A66B&color=fff" 
                         class="rounded-circle border border-2 border-white shadow-sm" width="28" height="28" alt="Pengajar">
                    <span class="small fw-semibold text-white me-1">Pengajar: <strong>{{ $teacher->name }}</strong></span>
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
    <ul class="nav nav-pills nav-justified gap-2" id="classroomTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-3 fw-bold py-2.5 btn-tab-custom" id="feed-tab" data-bs-toggle="tab" data-bs-target="#feed-pane" type="button" role="tab">
                <i class="fa-solid fa-comments me-2"></i> Diskusi & Tugas Kelas
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-3 fw-bold py-2.5 btn-tab-custom" id="materi-tab" data-bs-toggle="tab" data-bs-target="#materi-pane" type="button" role="tab">
                <i class="fa-solid fa-book-open-reader me-2"></i> Modul Materi Pembelajaran
            </button>
        </li>
    </ul>
</div>

<div class="tab-content" id="classroomTabContent">
    {{-- TAB 1: FEED UTAMA --}}
    <div class="tab-pane fade show active" id="feed-pane" role="tabpanel">
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
                                {{ ['announcement'=>'Pengumuman','material'=>'Materi','assignment'=>'Tugas'][$post->type] }}
                            </span>
                        </div>
                        @if($post->title)
                        <h5 class="fw-bold text-main mt-3 mb-0">{{ $post->title }}</h5>
                        @endif
                    </div>

                    <div class="card-body px-4 pb-3 pt-2">
                        @if($post->body)
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

                        {{-- Lampiran --}}
                        @if($post->attachments->isNotEmpty())
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($post->attachments as $att)
                            <a href="{{ asset('storage/'.$att->file_path) }}" target="_blank"
                               class="btn btn-light border rounded-3 d-inline-flex align-items-center gap-2 text-decoration-none py-2 px-3 btn-bouncy">
                                <i class="fa-solid fa-{{ $att->file_icon }} text-primary"></i>
                                <span class="fw-semibold small text-main">{{ $att->original_name }}</span>
                                <small class="text-muted">{{ $att->file_size_human }}</small>
                            </a>
                            @endforeach
                        </div>
                        @endif

                        {{-- Area Komentar --}}
                        <div class="pt-3 border-top">
                            @if($post->comments->isNotEmpty())
                            <div class="mb-3">
                                @foreach($post->comments->take(3) as $comment)
                                <div class="d-flex gap-3 mb-2 align-items-start">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&size=32"
                                         class="rounded-circle mt-1" width="32" height="32" style="flex-shrink:0;">
                                    <div class="bg-light rounded-3 px-3 py-2 flex-grow-1">
                                        <span class="fw-bold text-main small">{{ $comment->user->name }}</span>
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

                {{-- Card Teman Sekelas --}}
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-main mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-users text-primary"></i> Teman Sekelas
                        </h6>
                        <span class="badge bg-soft-blue text-primary rounded-pill fw-bold">{{ $totalMembers }}</span>
                    </div>
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($members as $member)
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&size=36"
                             class="rounded-circle border border-2 border-white shadow-sm"
                             width="36" height="36" title="{{ $member->name }}"
                             style="margin-left:-6px;" alt="{{ $member->name }}">
                        @endforeach
                        @if($totalMembers > 10)
                        <div class="rounded-circle bg-light border border-2 border-white shadow-sm d-flex align-items-center justify-content-center"
                             style="width:36px;height:36px;margin-left:-6px;font-size:.65rem;font-weight:700;color:#6B7280;">
                            +{{ $totalMembers - 10 }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB 2: MODUL MATERI PEMBELAJARAN KELAS --}}
    <div class="tab-pane fade" id="materi-pane" role="tabpanel">
        <div class="row g-4 mb-4">
            <!-- Card Materi 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="card card-modern h-100 position-relative overflow-hidden border-0 shadow-sm rounded-4">
                    <div class="position-absolute top-0 end-0 p-3 z-3">
                        <button class="btn btn-light rounded-circle shadow-sm text-accent" style="width: 40px; height: 40px;">
                            <i class="fa-regular fa-bookmark"></i>
                        </button>
                    </div>
                    
                    <div class="bg-primary d-flex align-items-center justify-content-center" style="height: 170px; position: relative;">
                        <i class="fa-solid fa-users text-white opacity-25" style="font-size: 6rem; position: absolute; right: -20px; bottom: -20px;"></i>
                        <h3 class="text-white fw-bold mb-0 z-2 position-relative">Aksara Jawa</h3>
                    </div>
                    
                    <div class="card-body p-4 bg-white">
                        <span class="badge bg-soft-blue text-primary rounded-pill mb-2 px-3">Menulis & Membaca</span>
                        <h5 class="fw-bold text-main">Aksara Jawa Dasar (Carakan)</h5>
                        <p class="text-muted small mb-3">Belajar mengenal, membaca, dan menulis 20 aksara dasar bahasa Jawa.</p>
                        
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}" class="rounded-circle me-2" width="24">
                            <small class="text-muted fw-semibold">Oleh: {{ $teacher->name }}</small>
                        </div>
                        
                        <div class="d-flex justify-content-between text-muted small mb-3">
                            <span><i class="fa-regular fa-clock me-1"></i> 45 Menit</span>
                            <span><i class="fa-solid fa-list me-1"></i> 4 Section</span>
                        </div>
                        
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-success fw-bold d-block text-end mb-4">100% Selesai</small>
                        
                        <a href="/ui/materi/show" class="btn btn-outline-primary w-100 rounded-pill fw-semibold">Buka Materi</a>
                    </div>
                </div>
            </div>
            
            <!-- Card Materi 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="card card-modern h-100 position-relative overflow-hidden border-0 shadow-sm rounded-4">
                    <div class="position-absolute top-0 end-0 p-3 z-3">
                        <button class="btn btn-light rounded-circle shadow-sm text-accent" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-bookmark"></i>
                        </button>
                    </div>
                    
                    <div class="bg-accent d-flex align-items-center justify-content-center" style="height: 170px; position: relative;">
                        <i class="fa-solid fa-people-arrows text-white opacity-25" style="font-size: 6rem; position: absolute; right: -20px; bottom: -20px;"></i>
                        <h3 class="text-white fw-bold mb-0 z-2 position-relative">Unggah-Ungguh</h3>
                    </div>
                    
                    <div class="card-body p-4 bg-white">
                        <span class="badge bg-soft-blue text-primary rounded-pill mb-2 px-3">Tata Krama</span>
                        <h5 class="fw-bold text-main">Ngoko Lugu lan Ngoko Alus</h5>
                        <p class="text-muted small mb-3">Memahami perbedaan dan penggunaan tingkatan bahasa dalam keseharian.</p>
                        
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}" class="rounded-circle me-2" width="24">
                            <small class="text-muted fw-semibold">Oleh: {{ $teacher->name }}</small>
                        </div>
                        
                        <div class="d-flex justify-content-between text-muted small mb-3">
                            <span><i class="fa-regular fa-clock me-1"></i> 60 Menit</span>
                            <span><i class="fa-solid fa-list me-1"></i> 5 Section</span>
                        </div>
                        
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-primary fw-bold d-block text-end mb-4">60% Selesai</small>
                        
                        <a href="/ui/materi/show" class="btn btn-primary w-100 rounded-pill fw-semibold shadow-sm">Lanjutkan Belajar <i class="fa-solid fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Card Materi 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="card card-modern h-100 position-relative overflow-hidden border-0 shadow-sm rounded-4">
                    <div class="position-absolute top-0 end-0 p-3 z-3">
                        <button class="btn btn-light rounded-circle shadow-sm text-accent" style="width: 40px; height: 40px;">
                            <i class="fa-regular fa-bookmark"></i>
                        </button>
                    </div>
                    
                    <div class="bg-secondary d-flex align-items-center justify-content-center border-bottom" style="height: 170px; position: relative;">
                        <i class="fa-solid fa-music text-accent opacity-25" style="font-size: 6rem; position: absolute; right: -20px; bottom: -20px;"></i>
                        <h3 class="text-primary fw-bold mb-0 z-2 position-relative">Tembang Macapat</h3>
                    </div>
                    
                    <div class="card-body p-4 bg-white">
                        <span class="badge bg-soft-blue text-primary rounded-pill mb-2 px-3">Sastra</span>
                        <h5 class="fw-bold text-main">Mengenal Tembang Pocung</h5>
                        <p class="text-muted small mb-3">Belajar menyanyikan dan memaknai lirik dari Tembang Macapat Pocung.</p>
                        
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}" class="rounded-circle me-2" width="24">
                            <small class="text-muted fw-semibold">Oleh: {{ $teacher->name }}</small>
                        </div>
                        
                        <div class="d-flex justify-content-between text-muted small mb-3">
                            <span><i class="fa-regular fa-clock me-1"></i> 30 Menit</span>
                            <span><i class="fa-solid fa-list me-1"></i> 3 Section</span>
                        </div>
                        
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted fw-bold d-block text-end mb-4">Belum Dimulai</small>
                        
                        <a href="/ui/materi/show" class="btn btn-outline-primary w-100 rounded-pill fw-semibold">Mulai Belajar</a>
                    </div>
                </div>
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
</style>
@endpush

@extends('layouts.app')

@section('title', $classroom->name . ' – Kelola Kelas')

@section('content')
{{-- HERO BANNER KELAS --}}
<div class="card border-0 shadow-sm mb-4 overflow-hidden animate__animated animate__fadeInDown" style="border-radius:20px;">
    <div class="p-5 position-relative text-white" style="background:{{ $classroom->banner_color }}; min-height:180px;">
        <i class="fa-solid fa-{{ $classroom->banner_icon }} position-absolute opacity-10"
           style="font-size:14rem; right:-20px; bottom:-40px;"></i>
        <div class="position-relative" style="z-index:1;">
            <span class="badge rounded-pill px-3 py-1 mb-2 fw-semibold"
                  style="background:rgba(255,255,255,.2); letter-spacing:.5px; font-size:.7rem;">
                {{ strtoupper($classroom->subject ?? 'Bahasa Jawa') }}
            </span>
            <h1 class="fw-bold display-6 mb-1" style="text-shadow:0 2px 8px rgba(0,0,0,.15);">{{ $classroom->name }}</h1>
            <div class="d-flex align-items-center gap-3 mt-2 flex-wrap">
                <span class="opacity-80 small"><i class="fa-solid fa-users me-1"></i>{{ $students->count() }} Siswa</span>
                <span class="opacity-80 small"><i class="fa-solid fa-key me-1"></i>Kode: <strong style="letter-spacing:2px;">{{ $classroom->code }}</strong></span>
                <span class="badge bg-white text-success fw-semibold px-3 py-1 rounded-pill shadow-sm">Aktif</span>
            </div>
        </div>

        {{-- Tombol aksi --}}
        <div class="position-absolute top-0 end-0 p-4 d-flex gap-2">
            <a href="{{ route('teacher.classroom.post.create', $classroom) }}"
               class="btn btn-sm fw-semibold rounded-pill shadow-sm px-3"
               style="background:rgba(255,255,255,.9); color:{{ $classroom->banner_color }};">
                <i class="fa-solid fa-plus me-1"></i> Tambah Post
            </a>
            <div class="dropdown">
                <button class="btn btn-sm rounded-circle shadow-sm" style="background:rgba(255,255,255,.9); color:{{ $classroom->banner_color }}; width:36px;height:36px;padding:0;" data-bs-toggle="dropdown">
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
                                    {{ ['announcement'=>'Pengumuman','material'=>'Materi','assignment'=>'Tugas'][$post->type] }}
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
                        @if($post->body)
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

                        {{-- Lampiran --}}
                        @if($post->attachments->isNotEmpty())
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($post->attachments as $att)
                            <a href="{{ asset('storage/' . $att->file_path) }}" target="_blank"
                               class="btn btn-light border rounded-3 d-inline-flex align-items-center gap-2 text-decoration-none py-2 px-3">
                                <i class="fa-solid fa-{{ $att->file_icon }} text-primary"></i>
                                <span class="fw-semibold small text-main">{{ $att->original_name }}</span>
                                <small class="text-muted">{{ $att->file_size_human }}</small>
                            </a>
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
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3 text-center">
                        <h3 class="fw-bold text-primary font-monospace mb-1" style="letter-spacing:4px;">{{ $classroom->code }}</h3>
                        <small class="text-muted">Bagikan kode ini ke siswa</small>
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

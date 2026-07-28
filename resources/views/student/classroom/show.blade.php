@extends('layouts.app')

@section('title', $classroom->name)

@section('content')
{{-- HERO BANNER --}}
<div class="card border-0 shadow-sm mb-4 overflow-hidden animate__animated animate__fadeInDown" style="border-radius:20px;">
    <div class="p-4 p-md-5 position-relative text-white" style="background:{{ $classroom->banner_color }}; min-height:180px;">
        <i class="fa-solid fa-{{ $classroom->banner_icon }} position-absolute opacity-10"
           style="font-size:14rem; right:-20px; bottom:-40px;"></i>
        <div class="position-relative" style="z-index:1;">
            <span class="badge rounded-pill px-3 py-1 mb-2 fw-semibold"
                  style="background:rgba(255,255,255,.2); letter-spacing:.5px; font-size:.7rem;">
                {{ strtoupper($classroom->subject ?? 'Bahasa Jawa') }}
            </span>
            <h1 class="fw-bold display-6 mb-1" style="text-shadow:0 2px 8px rgba(0,0,0,.15);">{{ $classroom->name }}</h1>
            <p class="opacity-75 mb-0"><i class="fa-solid fa-user-tie me-1"></i>{{ $teacher->name }}</p>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4">
    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
    {{-- Feed Utama --}}
    <div class="col-lg-8 animate__animated animate__fadeInLeft">

        @forelse($posts as $post)
        <div class="card border-0 shadow-sm mb-4 overflow-hidden post-card" style="border-radius:18px;">

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
                    <span class="badge rounded-pill ms-auto px-3 fw-semibold"
                          style="background:{{ $post->type_color }}18; color:{{ $post->type_color }}; font-size:.72rem;">
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
                <div class="rounded-3 p-4 mb-3" style="background:{{ $mySubmission ? '#F0FDF4' : '#FEF2F2' }}; border-left:4px solid {{ $mySubmission ? '#22C55E' : '#EF4444' }};">
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
                               style="background:{{ $post->assignment->is_overdue && !$mySubmission ? '#EF4444' : $classroom->banner_color }}; color:#fff; border:none;">
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
        <div class="text-center py-5">
            <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_jcikwtux.json" background="transparent" speed="1"
                           style="width:160px;height:160px;margin:0 auto;" loop autoplay></lottie-player>
            <p class="text-muted mt-3 fw-semibold">Belum ada postingan dari pengajar.</p>
        </div>
        @endforelse

        {{ $posts->links() }}
    </div>

    {{-- Sidebar Kanan --}}
    <div class="col-lg-4 animate__animated animate__fadeInRight">
        {{-- Info Kelas --}}
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:18px;">
            <h6 class="fw-bold text-main mb-3">Info Kelas</h6>
            <div class="d-flex align-items-center gap-3 mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&size=42" class="rounded-circle shadow-sm" width="42" height="42">
                <div>
                    <div class="fw-bold text-main small">{{ $teacher->name }}</div>
                    <small class="text-muted">Pengajar</small>
                </div>
            </div>
            @if($classroom->description)
            <p class="text-muted small mb-0">{{ $classroom->description }}</p>
            @endif
        </div>

        {{-- Anggota --}}
        <div class="card border-0 shadow-sm p-4" style="border-radius:18px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-main mb-0">Teman Sekelas</h6>
                <span class="badge bg-primary rounded-pill">{{ $totalMembers }}</span>
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
@endsection

@push('styles')
<style>
.post-card { transition: box-shadow .25s; }
.post-card:hover { box-shadow: 0 12px 30px rgba(0,0,0,.1) !important; }
</style>
@endpush

@extends('layouts.app')

@section('title', 'Kelas Saya')

@section('content')
{{-- Header --}}
<div class="mb-4 animate__animated animate__fadeInDown">
    <h2 class="fw-bold text-main mb-1">Kelas Saya</h2>
    <p class="text-muted mb-0">Semua kelas yang sedang Anda ikuti</p>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4">
    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4">
    <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ $errors->first() }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($classrooms->isEmpty())
<div class="text-center py-5 my-4 animate__animated animate__fadeIn">
    <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_jcikwtux.json" background="transparent" speed="1"
                   style="width:200px;height:200px;margin:0 auto;" loop autoplay></lottie-player>
    <h4 class="fw-bold text-main mt-3">Belum Ikut Kelas Apapun</h4>
    <p class="text-muted">Masukkan kode kelas dari pengajar Anda untuk mulai belajar!</p>
    <button class="btn btn-primary rounded-pill px-5 mt-2 btn-bouncy shadow" data-bs-toggle="modal" data-bs-target="#joinModal">
        <i class="fa-solid fa-plus me-2"></i>Gabung Kelas Sekarang
    </button>
</div>
@else
<div class="row g-4">
    @foreach($classrooms as $i => $classroom)
    <div class="col-xl-4 col-md-6 animate__animated animate__zoomIn" style="animation-delay:{{ $i * 0.08 }}s">
        <div class="card border-0 shadow-sm h-100 overflow-hidden classroom-card" style="border-radius:20px; transition:.3s;">
            {{-- Banner --}}
            <div class="position-relative text-white p-4" style="background:{{ $classroom->banner_color }}; min-height:150px; border-radius:20px 20px 0 0;">
                <i class="fa-solid fa-{{ $classroom->banner_icon }} position-absolute opacity-10"
                   style="font-size:9rem; right:-15px; bottom:-25px;"></i>

                {{-- Avatar Guru --}}
                <img src="https://ui-avatars.com/api/?name={{ urlencode($classroom->teacher->name) }}&size=38&background=ffffff&color={{ ltrim($classroom->banner_color,'#') }}"
                     class="rounded-circle border border-2 border-white shadow-sm mb-3"
                     width="38" height="38" alt="Pengajar">

                <span class="badge d-block rounded-pill mb-1 px-2 py-1" style="background:rgba(255,255,255,.2); font-size:.68rem; letter-spacing:.4px; max-width:fit-content;">
                    {{ strtoupper($classroom->subject ?? 'Bahasa Jawa') }}
                </span>
                <h4 class="fw-bold mb-0 text-truncate position-relative" style="z-index:1; text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    {{ $classroom->name }}
                </h4>
                <small class="position-relative opacity-80" style="z-index:1;">{{ $classroom->teacher->name }}</small>
            </div>

            {{-- Card Body --}}
            <div class="card-body p-4 bg-white d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="text-muted small"><i class="fa-solid fa-users me-1"></i>{{ $classroom->students_count }} Siswa</span>
                </div>

                @if($classroom->description)
                <p class="text-muted small mb-3 flex-grow-1" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                    {{ $classroom->description }}
                </p>
                @else
                <div class="flex-grow-1"></div>
                @endif

                <a href="{{ route('student.classroom.show', $classroom) }}"
                   class="btn w-100 rounded-pill fw-semibold btn-bouncy py-2 mt-2 shadow-sm"
                   style="background:{{ $classroom->banner_color }}; color:#fff; border:none;">
                    Masuk Kelas <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Modal Gabung Kelas --}}
<div class="modal fade" id="joinModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-5 pt-5">
                <div>
                    <h4 class="fw-bold text-main mb-1">Gabung Kelas</h4>
                    <p class="text-muted small mb-0">Minta kode dari pengajar, lalu masukkan di sini</p>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-5 py-4">
                <form action="{{ route('student.classroom.join') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kode Kelas</label>
                        <input type="text" name="code" id="joinCode"
                               class="form-control form-control-lg rounded-4 border-0 bg-light text-center fw-bold"
                               style="letter-spacing:4px; font-size:1.4rem;"
                               placeholder="XXXX-XXXX" maxlength="9"
                               oninput="this.value=this.value.toUpperCase()" required autofocus>
                        <div class="form-text text-center mt-2">Contoh: <strong>JW5A-26BD</strong></div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold btn-bouncy shadow fs-5">
                        <i class="fa-solid fa-door-open me-2"></i>Gabung Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.classroom-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.12) !important; }
</style>
@endpush

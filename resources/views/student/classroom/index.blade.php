@extends('layouts.app')

@section('title', 'Dashboard & Kelas Saya')

@section('content')
@php
    $hour = (int) date('H');
    if ($hour >= 4 && $hour < 11) {
        $greeting = 'Sugeng Enjing';
        $timeIcon = 'fa-sun text-warning';
    } elseif ($hour >= 11 && $hour < 15) {
        $greeting = 'Sugeng Siang';
        $timeIcon = 'fa-sun text-warning';
    } elseif ($hour >= 15 && $hour < 18) {
        $greeting = 'Sugeng Sonten';
        $timeIcon = 'fa-cloud-sun text-warning';
    } else {
        $greeting = 'Sugeng Dalu';
        $timeIcon = 'fa-moon text-info';
    }
@endphp

{{-- 1. Hero Greeting Banner --}}
<div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden text-white position-relative" 
     style="background: var(--grad-hero); border: 1px solid rgba(255,255,255,0.1) !important;">

    <div class="card-body p-4 p-md-5 position-relative" style="z-index: 2;">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" 
                     style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                    <i class="fa-solid {{ $timeIcon }}" aria-hidden="true"></i>
                    <span class="small fw-semibold">{{ $greeting }}, Sinau Basa Jawa!</span>
                </div>
                
                <h2 class="fw-bold text-white mb-2" style="letter-spacing: -0.02em;">
                    {{ $greeting }}, {{ auth()->user()->name }}!
                </h2>
                <p class="text-white-50 mb-3 mb-md-0 fs-6" style="max-width: 600px;">
                    Ayo terusake sinau basa lan sastra Jawa dina iki kanthi semangat. Priksa kelas, tugas, lan materi paling anyar ing ngisor iki.
                </p>
            </div>

            
            <div class="col-lg-4 text-lg-end d-flex flex-column flex-sm-row flex-lg-column gap-2 justify-content-lg-end position-relative" style="z-index: 5;">
                <button class="btn btn-accent rounded-pill px-4 py-2.5 shadow-sm fw-bold btn-bouncy" 
                        data-bs-toggle="modal" data-bs-target="#joinModal">
                    <i class="fa-solid fa-plus-circle me-2" aria-hidden="true"></i>Gabung Kelas Anyar
                </button>
                <a href="{{ route('calendar.index') }}" 
                   class="btn rounded-pill px-4 py-2.5 fw-bold shadow-sm btn-bouncy d-inline-flex align-items-center justify-content-center gap-2"
                   style="background: rgba(0, 0, 0, 0.35); border: 2px solid #C9A66B; color: #e2b76b; backdrop-filter: blur(10px);">
                    <i class="fa-solid fa-calendar-days text-accent" aria-hidden="true"></i>
                    <span>Kalender Pembelajaran</span>
                </a>
            </div>

        </div>
    </div>
</div>

{{-- Alert Messages --}}
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

{{-- 2. Quick Stat Counters --}}
<div class="row g-3 mb-4">
    {{-- Total Kelas --}}
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white" style="border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 48px; height: 48px; background: rgba(31, 77, 58, 0.1); color: var(--primary);">
                    <i class="fa-solid fa-chalkboard-user fs-5"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0 lh-1">{{ $totalClassrooms }}</h4>
                    <small class="text-muted" style="font-size: 0.8rem;">Kelas Diikuti</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Tugas Aktif --}}
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white" style="border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 48px; height: 48px; background: rgba(234, 88, 12, 0.1); color: #ea580c;">
                    <i class="fa-solid fa-list-check fs-5"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0 lh-1">{{ $activeAssignmentsCount }}</h4>
                    <small class="text-muted" style="font-size: 0.8rem;">Tugas Perlu Dikerjakan</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Kuis Aktif --}}
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white" style="border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 48px; height: 48px; background: rgba(14, 165, 233, 0.1); color: #0ea5e9;">
                    <i class="fa-solid fa-circle-question fs-5"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0 lh-1">{{ $activeQuizzesCount }}</h4>
                    <small class="text-muted" style="font-size: 0.8rem;">Kuis Siap Dikerjakan</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Bookmark --}}
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white" style="border: 1px solid #E2E8F0 !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 48px; height: 48px; background: rgba(201, 166, 107, 0.15); color: #b4935b;">
                    <i class="fa-solid fa-bookmark fs-5"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0 lh-1">{{ $totalBookmarks }}</h4>
                    <small class="text-muted" style="font-size: 0.8rem;">Materi Dibookmark</small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. Section Header: Ruang Kelas Saya --}}
<div class="d-flex align-items-center justify-content-between gap-2 gap-sm-3 mt-5 mb-4 pt-2 pb-1">
    <div class="d-flex align-items-center gap-3 min-w-0">
        <h5 class="fw-bold text-main mb-0" style="font-size: clamp(1.05rem, 3.6vw, 1.35rem); letter-spacing: -0.01em;">
            Ruang Kelas Panjenengan
        </h5>
        <span class="badge bg-primary text-white rounded-pill px-3 py-1.5 flex-shrink-0 shadow-xs ms-1" style="font-size: 0.76rem; font-weight: 600;">
            {{ $classrooms->count() }} Kelas
        </span>
    </div>
    
    <div class="flex-shrink-0 ms-2">
        <button class="btn btn-outline-primary rounded-pill px-3.5 py-2 shadow-xs fw-semibold text-nowrap d-inline-flex align-items-center gap-2 btn-bouncy" 
                style="font-size: 0.85rem;"
                data-bs-toggle="modal" data-bs-target="#joinModal">
            <i class="fa-solid fa-plus-circle" aria-hidden="true"></i>
            <span>Gabung Kelas</span>
        </button>
    </div>
</div>



{{-- 4. Classroom Grid --}}
@if($classrooms->isEmpty())
<div class="card border-0 rounded-4 shadow-sm p-5 text-center my-4 bg-white" style="border: 1px solid #E2E8F0 !important;">
    <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_jcikwtux.json" background="transparent" speed="1"
                   style="width:180px;height:180px;margin:0 auto;" loop autoplay></lottie-player>
    <h4 class="fw-bold text-main mt-3 mb-1">Durung Melu Kelas Apa-apa</h4>
    <p class="text-muted mb-4" style="max-width: 460px; margin: 0 auto;">
        Panjenengan durung mlebu ing kelas sinau. Nyuwun kode kelas saka guru / bapak ibu pengajar kanggo miwiti sinau!
    </p>
    <div>
        <button class="btn btn-primary rounded-pill px-5 py-2.5 btn-bouncy shadow fw-bold" data-bs-toggle="modal" data-bs-target="#joinModal">
            <i class="fa-solid fa-plus-circle me-2"></i>Gabung Kelas Saiki
        </button>
    </div>
</div>
@else
<div class="row g-4 mb-5">
    @foreach($classrooms as $i => $classroom)
    <div class="col-xl-4 col-md-6 animate__animated animate__fadeInUp" style="animation-delay:{{ $i * 0.05 }}s">
        <div class="card border-0 shadow-sm h-100 overflow-hidden classroom-card bg-white" 
             style="border-radius:20px; transition: transform .25s ease, box-shadow .25s ease; border: 1px solid #E2E8F0 !important;">
            
            {{-- Banner Card --}}
            <div class="position-relative text-white p-4" 
                 style="background:{{ $classroom->banner_color }}; min-height:140px; border-radius:20px 20px 0 0;">
                <i class="fa-solid fa-{{ $classroom->banner_icon }} position-absolute opacity-10"
                   style="font-size:8.5rem; right:-15px; bottom:-25px; pointer-events: none;"></i>

                <div class="d-flex align-items-center justify-content-between mb-3 position-relative" style="z-index: 2;">
                    {{-- Avatar Guru --}}
                    <div class="d-flex align-items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($classroom->teacher->name) }}&size=36&background=ffffff&color={{ ltrim($classroom->banner_color,'#') }}"
                             class="rounded-circle border border-2 border-white shadow-sm"
                             width="36" height="36" alt="Pengajar">
                        <div class="lh-1 text-truncate" style="max-width: 160px;">
                            <small class="text-white-50 d-block" style="font-size: 0.7rem;">Pengajar</small>
                            <span class="text-white fw-semibold small text-truncate d-block">{{ $classroom->teacher->name }}</span>
                        </div>
                    </div>

                    <span class="badge rounded-pill px-2.5 py-1" style="background:rgba(255,255,255,.2); font-size:.68rem; letter-spacing:.4px;">
                        {{ strtoupper($classroom->subject ?? 'Bahasa Jawa') }}
                    </span>
                </div>

                <h4 class="fw-bold mb-1 text-white text-truncate position-relative" style="z-index:1; color:#ffffff !important; text-shadow:0 1px 4px rgba(0,0,0,.35);">
                    {{ $classroom->name }}
                </h4>
            </div>

            {{-- Card Body --}}
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3 text-muted small">
                        <span class="d-flex align-items-center gap-1.5">
                            <i class="fa-solid fa-users text-muted"></i> {{ $classroom->students_count }} Siswa
                        </span>
                        @if($classroom->code)
                        <span class="badge bg-light text-dark font-monospace border px-2 py-1" style="font-size: 0.72rem;">
                            {{ $classroom->code }}
                        </span>
                        @endif
                    </div>

                    @if($classroom->description)
                    <p class="text-muted small mb-3" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; line-height: 1.45;">
                        {{ $classroom->description }}
                    </p>
                    @else
                    <p class="text-muted small mb-3 fst-italic" style="font-size: 0.82rem;">
                        Sugeng rawuh ing kelas {{ $classroom->name }}. Sinau kanthi aktif lan gayeng!
                    </p>
                    @endif
                </div>

                <a href="{{ route('student.classroom.show', $classroom) }}"
                   class="btn w-100 rounded-pill fw-bold py-2.5 mt-2 shadow-sm text-white d-flex align-items-center justify-content-center gap-2 btn-bouncy"
                   style="background:{{ $classroom->banner_color }}; border:none;">
                    <span>Mlebu Kelas</span>
                    <i class="fa-solid fa-arrow-right fs-6"></i>
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
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-primary text-white p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="fa-solid fa-door-open fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-white mb-0">Gabung Ruang Kelas</h5>
                        <small class="text-white-50">Ketik kode kelas 8-9 karakter saka pengajar</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 p-md-5">
                <form action="{{ route('student.classroom.join') }}" method="POST">
                    @csrf
                    <div class="mb-4 text-center">
                        <label class="form-label fw-bold text-dark mb-2">Kode Kelas</label>
                        <input type="text" name="code" id="joinCode"
                               class="form-control form-control-lg rounded-4 border text-center fw-bold font-monospace py-3 shadow-xs"
                               style="letter-spacing:4px; font-size:1.4rem; background: #F8FAFC;"
                               placeholder="JW5A-26BD" maxlength="9"
                               oninput="this.value=this.value.toUpperCase()" required autofocus>
                        <div class="form-text mt-2 text-muted small">
                            <i class="fa-solid fa-circle-info me-1"></i>Contoh format: <strong>JW5A-26BD</strong>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold btn-bouncy shadow fs-6">
                        <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Gabung Kelas Saiki
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.classroom-card:hover { 
    transform: translateY(-6px); 
    box-shadow: 0 16px 30px rgba(0,0,0,.08) !important; 
}
</style>
@endpush


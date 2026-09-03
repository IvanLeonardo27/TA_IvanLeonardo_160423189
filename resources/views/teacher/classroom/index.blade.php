@extends('layouts.app')

@section('title', auth()->user()->isAdmin() ? 'Kelola Ruang Kelas - Admin BasaKula' : 'Kelas Saya')

@section('content')
{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-5 animate__animated animate__fadeInDown flex-wrap gap-3">
    <div>
        <h2 class="fw-bold text-main mb-1">{{ auth()->user()->isAdmin() ? 'Kelola Seluruh Ruang Kelas' : 'Kelas Saya' }}</h2>
        <p class="text-muted mb-0">{{ auth()->user()->isAdmin() ? 'Pantau, buka, edit, atau hapus seluruh ruang kelas yang dibuat oleh setiap pengajar' : 'Kelola semua kelas yang Anda ajar' }}</p>
    </div>
    <a href="{{ route('teacher.classroom.create') }}" class="btn btn-primary rounded-pill px-4 shadow btn-bouncy">
        <i class="fa-solid fa-plus me-2"></i>Buat Kelas Baru
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($classrooms->isEmpty())
<div class="text-center py-5 my-5 animate__animated animate__fadeIn">
    <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_q7uarxsb.json" background="transparent" speed="1" style="width:200px;height:200px;margin:0 auto;" loop autoplay></lottie-player>
    <h4 class="fw-bold text-main mt-3">Belum Ada Kelas</h4>
    <p class="text-muted">Mulai buat kelas pertama Anda dan undang siswa untuk bergabung!</p>
    <a href="{{ route('teacher.classroom.create') }}" class="btn btn-primary rounded-pill px-5 mt-2 btn-bouncy shadow">
        <i class="fa-solid fa-plus me-2"></i>Buat Kelas Sekarang
    </a>
</div>
@else
<div class="row g-4">
    @foreach($classrooms as $i => $classroom)
    <div class="col-xl-4 col-md-6 animate__animated animate__zoomIn" style="animation-delay: {{ $i * 0.08 }}s">
        <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 20px; transition: transform 0.25s, box-shadow 0.25s;">
            {{-- Banner Kelas --}}
            <div class="position-relative text-white p-4" style="background: {{ $classroom->banner_color }}; min-height: 140px; border-radius: 20px 20px 0 0;">
                {{-- Background Icon Dekoratif --}}
                <i class="fa-solid fa-{{ $classroom->banner_icon }} position-absolute opacity-10"
                   style="font-size:9rem; right:-15px; bottom:-25px; z-index:0;"></i>

                {{-- Menu Dropdown --}}
                <div class="position-absolute top-0 end-0 p-3" style="z-index:2;">
                    <button class="btn btn-sm btn-light rounded-circle shadow-sm opacity-90"
                            data-bs-toggle="dropdown" style="width:32px;height:32px;padding:0;">
                        <i class="fa-solid fa-ellipsis-vertical" style="color:{{ $classroom->banner_color }};font-size:.85rem;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 py-2">
                        <li>
                            <a class="dropdown-item py-2 fw-semibold" href="{{ route('teacher.classroom.show', $classroom) }}">
                                <i class="fa-solid fa-door-open me-2 text-primary"></i>Buka Kelas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 fw-semibold" href="{{ route('teacher.classroom.edit', $classroom) }}">
                                <i class="fa-solid fa-pen me-2 text-warning"></i>Edit Kelas
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form action="{{ route('teacher.classroom.destroy', $classroom) }}" method="POST"
                                  onsubmit="return confirm('Hapus kelas ini? Semua data akan terhapus permanen.')">
                                @csrf @method('DELETE')
                                <button class="dropdown-item py-2 fw-semibold text-danger" type="submit">
                                    <i class="fa-solid fa-trash me-2"></i>Hapus Kelas
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <div class="position-relative" style="z-index:1;">
                    <span class="badge rounded-pill mb-2 px-3 py-1 fw-semibold"
                          style="background:rgba(255,255,255,0.25); font-size:.7rem; letter-spacing:.5px;">
                        {{ strtoupper($classroom->subject ?? 'Bahasa Jawa') }}
                    </span>
                    <h4 class="fw-bold mb-0 text-white text-truncate" style="color:#ffffff !important; text-shadow:0 1px 4px rgba(0,0,0,.35);">
                        {{ $classroom->name }}
                    </h4>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="card-body p-4 bg-white position-relative">
                {{-- Avatar Guru Pemilik Kelas --}}
                <img src="https://ui-avatars.com/api/?name={{ urlencode($classroom->teacher->name ?? 'Guru') }}&background={{ ltrim($classroom->banner_color, '#') }}&color=fff"
                     class="rounded-circle border border-3 border-white shadow-sm position-absolute"
                     style="width:52px;height:52px;top:-26px;left:20px;" alt="Avatar {{ $classroom->teacher->name ?? 'Guru' }}"
                     title="Pengajar: {{ $classroom->teacher->name ?? 'Guru' }}">

                <div class="mt-3">
                    {{-- Nama Pengajar --}}
                    <div class="d-flex align-items-center gap-1.5 mb-2 text-truncate" title="{{ $classroom->teacher->name ?? '-' }}">
                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1 small fw-semibold">
                            <i class="fa-solid fa-chalkboard-user text-primary me-1"></i> {{ $classroom->teacher->name ?? 'Pengajar' }}
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="text-muted small">
                            <i class="fa-solid fa-users me-1"></i>{{ $classroom->students_count }} Siswa
                        </span>
                        <span class="badge rounded-pill px-3 py-1 fw-semibold {{ $classroom->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ $classroom->status === 'active' ? 'Aktif' : 'Diarsipkan' }}
                        </span>
                    </div>

                    {{-- Kode kelas --}}
                    <div class="d-flex align-items-center justify-content-between bg-light rounded-3 px-3 py-2 mb-3">
                        <span class="text-muted small">Kode Kelas</span>
                        <span class="fw-bold font-monospace" style="letter-spacing:2px; color:{{ $classroom->banner_color }}">
                            {{ $classroom->code }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white border-0 px-4 pb-4">
                <a href="{{ route('teacher.classroom.show', $classroom) }}"
                   class="btn w-100 rounded-pill fw-semibold btn-bouncy py-2"
                   style="background:{{ $classroom->banner_color }}; color:#fff; border:none;">
                    Buka Kelas <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection

@push('styles')
<style>
.card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.12) !important; }
</style>
@endpush

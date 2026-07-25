@extends('layouts.app')

@section('title', 'Ruang Kelas Saya')

@section('content')
<div class="row mb-4 align-items-center animate__animated animate__fadeInDown">
    <div class="col-md-8">
        <h3 class="fw-bold text-main mb-1">Kelas Saya</h3>
        <p class="text-muted">Daftar kelas yang sedang Anda ikuti.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <!-- Button trigger modal untuk Gabung Kelas -->
        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm btn-bouncy" data-bs-toggle="modal" data-bs-request="GabungKelasModal">
            <i class="fa-solid fa-plus me-2"></i> Gabung Kelas
        </button>
    </div>
</div>

<div class="row g-4">
    <!-- Class Card (Joined) -->
    <div class="col-lg-4 col-md-6 animate__animated animate__zoomIn" style="animation-delay: 0.1s;">
        <div class="card card-modern gamified h-100 overflow-hidden">
            <div class="bg-primary text-white p-4 position-relative" style="height: 140px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                <h4 class="fw-bold mb-1 z-2 position-relative text-truncate" title="Bahasa Jawa - Kelas 5A">Bahasa Jawa - Kelas 5A</h4>
                <p class="mb-0 text-white-50 small z-2 position-relative">Pak Guru</p>
                <i class="fa-solid fa-graduation-cap position-absolute opacity-25" style="font-size: 6rem; right: -10px; bottom: -20px;"></i>
            </div>
            
            <div class="card-body p-4 pt-4 position-relative">
                <img src="https://ui-avatars.com/api/?name=Pak+Guru&background=fff&color=1F4D3A" class="rounded-circle shadow-sm position-absolute border border-3 border-white" style="width: 60px; height: 60px; top: -30px; left: 20px;" alt="Avatar Pengajar">
                
                <div class="mt-4">
                    <div class="alert alert-warning border-0 rounded-3 p-2 small fw-semibold">
                        <i class="fa-solid fa-clock text-warning me-2"></i> Tugas: Mengarang Bebas besok!
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-transparent border-0 p-4 pt-0">
                <a href="/ui/student/kelas/show" class="btn btn-outline-primary w-100 rounded-4 btn-bouncy">Masuk Kelas</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Gabung Kelas -->
<div class="modal fade" id="gabungKelasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-main">Gabung ke Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-4">
                    <p class="text-muted small text-start">Minta kode kelas kepada pengajar Anda, lalu masukkan kodenya di sini.</p>
                    <input type="text" class="form-control form-control-lg rounded-3 text-center fw-bold" placeholder="Contoh: JW5A-26" style="letter-spacing: 2px;" required>
                </div>
                <button type="button" class="btn btn-primary w-100 rounded-pill btn-bouncy py-2">Gabung Sekarang</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-bs-request="GabungKelasModal"]').forEach(btn => {
        btn.addEventListener('click', () => {
            new bootstrap.Modal(document.getElementById('gabungKelasModal')).show();
        });
    });
</script>
@endpush

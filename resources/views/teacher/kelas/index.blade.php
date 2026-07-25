@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="row mb-4 align-items-center animate__animated animate__fadeInDown">
    <div class="col-md-8">
        <h3 class="fw-bold text-main mb-1">Daftar Kelas Anda</h3>
        <p class="text-muted">Kelola semua kelas yang Anda ajar di satu tempat.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <!-- Button trigger modal untuk Buat Kelas -->
        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm btn-bouncy" data-bs-toggle="modal" data-bs-request="BuatKelasModal">
            <i class="fa-solid fa-plus me-2"></i> Buat Kelas Baru
        </button>
    </div>
</div>

<div class="row g-4">
    <!-- Class Card 1 -->
    <div class="col-lg-4 col-md-6 animate__animated animate__zoomIn" style="animation-delay: 0.1s;">
        <div class="card card-modern gamified h-100 overflow-hidden">
            <!-- Header Class (Banner) -->
            <div class="bg-primary text-white p-4 position-relative" style="height: 140px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                <div class="position-absolute top-0 end-0 p-3">
                    <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown" style="width: 35px; height: 35px;">
                        <i class="fa-solid fa-ellipsis-vertical text-primary"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                        <li><a class="dropdown-item fw-semibold" href="#"><i class="fa-solid fa-pen me-2 text-muted"></i> Edit Kelas</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger fw-semibold" href="#"><i class="fa-solid fa-trash me-2"></i> Hapus Kelas</a></li>
                    </ul>
                </div>
                
                <h4 class="fw-bold mb-1 z-2 position-relative text-truncate" title="Bahasa Jawa - Kelas 5A">Bahasa Jawa - Kelas 5A</h4>
                <p class="mb-0 text-white-50 small z-2 position-relative">Tahun Ajaran 2026/2027</p>
                <i class="fa-solid fa-graduation-cap position-absolute opacity-25" style="font-size: 6rem; right: -10px; bottom: -20px;"></i>
            </div>
            
            <div class="card-body p-4 pt-4 position-relative">
                <!-- Avatar Profil Pengajar -->
                <img src="https://ui-avatars.com/api/?name=Pak+Guru&background=fff&color=1F4D3A" class="rounded-circle shadow-sm position-absolute border border-3 border-white" style="width: 60px; height: 60px; top: -30px; left: 20px;" alt="Avatar">
                
                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small"><i class="fa-solid fa-users me-2"></i> 32 Siswa</span>
                        <span class="badge bg-soft-blue text-primary rounded-pill px-3">Aktif</span>
                    </div>
                    
                    <p class="text-muted small">Materi terakhir: <strong>Unggah-Ungguh Basa</strong></p>
                </div>
            </div>
            
            <div class="card-footer bg-transparent border-0 p-4 pt-0">
                <a href="/ui/teacher/kelas/show" class="btn btn-outline-primary w-100 rounded-4 btn-bouncy">Buka Kelas</a>
            </div>
        </div>
    </div>
    
    <!-- Class Card 2 -->
    <div class="col-lg-4 col-md-6 animate__animated animate__zoomIn" style="animation-delay: 0.2s;">
        <div class="card card-modern gamified h-100 overflow-hidden">
            <div class="bg-accent text-white p-4 position-relative" style="height: 140px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                <div class="position-absolute top-0 end-0 p-3">
                    <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown" style="width: 35px; height: 35px;">
                        <i class="fa-solid fa-ellipsis-vertical text-accent"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                        <li><a class="dropdown-item fw-semibold" href="#"><i class="fa-solid fa-pen me-2 text-muted"></i> Edit Kelas</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger fw-semibold" href="#"><i class="fa-solid fa-trash me-2"></i> Hapus Kelas</a></li>
                    </ul>
                </div>
                
                <h4 class="fw-bold mb-1 z-2 position-relative text-truncate">Bahasa Jawa - Kelas 5B</h4>
                <p class="mb-0 text-white-50 small z-2 position-relative">Tahun Ajaran 2026/2027</p>
                <i class="fa-solid fa-book-open position-absolute opacity-25" style="font-size: 6rem; right: -10px; bottom: -20px;"></i>
            </div>
            
            <div class="card-body p-4 pt-4 position-relative">
                <img src="https://ui-avatars.com/api/?name=Pak+Guru&background=fff&color=C9A66B" class="rounded-circle shadow-sm position-absolute border border-3 border-white" style="width: 60px; height: 60px; top: -30px; left: 20px;" alt="Avatar">
                
                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small"><i class="fa-solid fa-users me-2"></i> 28 Siswa</span>
                        <span class="badge bg-soft-blue text-primary rounded-pill px-3">Aktif</span>
                    </div>
                    <p class="text-muted small">Materi terakhir: <strong>Aksara Jawa Dasar</strong></p>
                </div>
            </div>
            
            <div class="card-footer bg-transparent border-0 p-4 pt-0">
                <a href="/ui/teacher/kelas/show" class="btn btn-outline-accent w-100 rounded-4 btn-bouncy">Buka Kelas</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Buat Kelas -->
<div class="modal fade" id="buatKelasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-main">Buat Kelas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-main">Nama Kelas</label>
                        <input type="text" class="form-control rounded-3" placeholder="Contoh: Bahasa Jawa Kelas 6A" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-main">Deskripsi/Tahun Ajaran</label>
                        <input type="text" class="form-control rounded-3" placeholder="Contoh: Tahun Ajaran 2026/2027">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-main">Tema Warna (Banner)</label>
                        <div class="d-flex gap-2">
                            <div class="rounded-circle bg-primary cursor-pointer border border-3 border-white shadow-sm" style="width:30px; height:30px;"></div>
                            <div class="rounded-circle bg-accent cursor-pointer" style="width:30px; height:30px;"></div>
                            <div class="rounded-circle bg-info cursor-pointer" style="width:30px; height:30px;"></div>
                            <div class="rounded-circle bg-success cursor-pointer" style="width:30px; height:30px;"></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary w-100 rounded-pill btn-bouncy py-2">Buat Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script simpel untuk demo memunculkan modal
    document.querySelectorAll('[data-bs-request="BuatKelasModal"]').forEach(btn => {
        btn.addEventListener('click', () => {
            new bootstrap.Modal(document.getElementById('buatKelasModal')).show();
        });
    });
</script>
@endpush

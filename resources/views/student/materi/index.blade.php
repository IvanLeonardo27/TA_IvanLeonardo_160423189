@extends('layouts.app')

@section('title', 'Daftar Materi')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h3 class="fw-bold text-main mb-1">Daftar Materi Basa Jawa</h3>
        <p class="text-muted">Pilih materi yang ingin kamu pelajari hari ini.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end gap-2">
        @auth
            @if(auth()->user()->isTeacher())
            <button class="btn btn-primary rounded-4 px-4 py-2 d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addMateriModal">
                <i class="fa-solid fa-plus-circle"></i> Buat Materi Baru
            </button>
            @endif
        @endauth
        <div class="btn-group shadow-sm rounded-4" role="group">
            <button type="button" class="btn btn-outline-primary px-3">Semua</button>
            <button type="button" class="btn btn-light text-muted px-3">Unggah Pengajar</button>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Card Materi 1 -->
    <div class="col-lg-4 col-md-6">
        <div class="card card-modern h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 z-3">
                <button class="btn btn-light rounded-circle shadow-sm text-accent" style="width: 40px; height: 40px;">
                    <i class="fa-regular fa-bookmark"></i>
                </button>
            </div>
            
            <div class="bg-primary d-flex align-items-center justify-content-center" style="height: 180px; position: relative;">
                <i class="fa-solid fa-users text-white opacity-25" style="font-size: 6rem; position: absolute; right: -20px; bottom: -20px;"></i>
                <h2 class="text-white fw-bold mb-0 z-2 position-relative">Aksara Jawa</h2>
            </div>
            
            <div class="card-body p-4">
                <span class="badge bg-soft-blue text-primary rounded-pill mb-2 px-3">Menulis & Membaca</span>
                <h5 class="fw-bold text-main">Aksara Jawa Dasar (Carakan)</h5>
                <p class="text-muted small mb-3">Belajar mengenal, membaca, dan menulis 20 aksara dasar bahasa Jawa.</p>
                
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name=Pak+Guru" class="rounded-circle me-2" width="24">
                    <small class="text-muted fw-semibold">Oleh: Pak Sudarso</small>
                </div>
                
                <div class="d-flex justify-content-between text-muted small mb-3">
                    <span><i class="fa-regular fa-clock me-1"></i> 45 Menit</span>
                    <span><i class="fa-solid fa-list me-1"></i> 4 Section</span>
                </div>
                
                <div class="progress mb-2" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-success fw-bold d-block text-end mb-4">100% Selesai</small>
                
                <button class="btn btn-outline-primary w-100 rounded-4">Ulangi Materi</button>
            </div>
        </div>
    </div>
    
    <!-- Card Materi 2 -->
    <div class="col-lg-4 col-md-6">
        <div class="card card-modern h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 z-3">
                <button class="btn btn-light rounded-circle shadow-sm text-accent" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-bookmark"></i>
                </button>
            </div>
            
            <div class="bg-accent d-flex align-items-center justify-content-center" style="height: 180px; position: relative;">
                <i class="fa-solid fa-people-arrows text-white opacity-25" style="font-size: 6rem; position: absolute; right: -20px; bottom: -20px;"></i>
                <h2 class="text-white fw-bold mb-0 z-2 position-relative">Unggah-Ungguh</h2>
            </div>
            
            <div class="card-body p-4">
                <span class="badge bg-soft-blue text-primary rounded-pill mb-2 px-3">Tata Krama</span>
                <h5 class="fw-bold text-main">Ngoko Lugu lan Ngoko Alus</h5>
                <p class="text-muted small mb-3">Memahami perbedaan dan penggunaan tingkatan bahasa dalam keseharian.</p>
                
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name=Bu+Guru" class="rounded-circle me-2" width="24">
                    <small class="text-muted fw-semibold">Oleh: Bu Retno</small>
                </div>
                
                <div class="d-flex justify-content-between text-muted small mb-3">
                    <span><i class="fa-regular fa-clock me-1"></i> 60 Menit</span>
                    <span><i class="fa-solid fa-list me-1"></i> 5 Section</span>
                </div>
                
                <div class="progress mb-2" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-primary fw-bold d-block text-end mb-4">60% Selesai</small>
                
                <button class="btn btn-primary w-100 rounded-4">Lanjutkan Belajar <i class="fa-solid fa-arrow-right ms-2"></i></button>
            </div>
        </div>
    </div>
    
    <!-- Card Materi 3 -->
    <div class="col-lg-4 col-md-6">
        <div class="card card-modern h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 z-3">
                <button class="btn btn-light rounded-circle shadow-sm text-accent" style="width: 40px; height: 40px;">
                    <i class="fa-regular fa-bookmark"></i>
                </button>
            </div>
            
            <div class="bg-secondary d-flex align-items-center justify-content-center border-bottom" style="height: 180px; position: relative;">
                <i class="fa-solid fa-music text-accent opacity-25" style="font-size: 6rem; position: absolute; right: -20px; bottom: -20px;"></i>
                <h2 class="text-primary fw-bold mb-0 z-2 position-relative">Tembang Macapat</h2>
            </div>
            
            <div class="card-body p-4">
                <span class="badge bg-soft-blue text-primary rounded-pill mb-2 px-3">Sastra</span>
                <h5 class="fw-bold text-main">Mengenal Tembang Pocung</h5>
                <p class="text-muted small mb-3">Belajar menyanyikan dan memaknai lirik dari Tembang Macapat Pocung.</p>
                
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name=Pak+Guru" class="rounded-circle me-2" width="24">
                    <small class="text-muted fw-semibold">Oleh: Pak Sudarso</small>
                </div>
                
                <div class="d-flex justify-content-between text-muted small mb-3">
                    <span><i class="fa-regular fa-clock me-1"></i> 30 Menit</span>
                    <span><i class="fa-solid fa-list me-1"></i> 3 Section</span>
                </div>
                
                <div class="progress mb-2" style="height: 8px;">
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted fw-bold d-block text-end mb-4">Belum Dimulai</small>
                
                <button class="btn btn-outline-primary w-100 rounded-4">Mulai Belajar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Buat Materi Baru (Pengajar) --}}
@auth
@if(auth()->user()->isTeacher())
<div class="modal fade" id="addMateriModal" tabindex="-1" aria-labelledby="addMateriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4 p-4">
                <h5 class="modal-title fw-bold" id="addMateriModalLabel">
                    <i class="fa-solid fa-plus-circle me-2"></i>Buat & Unggah Materi Baru (Pengajar)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Judul Materi <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control rounded-3" placeholder="Contoh: Aksara Jawa Dasar (Carakan)" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select name="category" class="form-select rounded-3" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Aksara Jawa">Aksara Jawa</option>
                                <option value="Unggah Ungguh">Unggah-Ungguh Basa</option>
                                <option value="Sastra">Sastra & Tembang</option>
                                <option value="TATA BASA">Tata Basa</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi Singkat Materi <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control rounded-3" rows="2" placeholder="Jelaskan ringkasan materi pembelajaran..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Isi Materi Lengkap / Teks Pembelajaran <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control rounded-3" rows="5" placeholder="Tuliskan isi materi pembelajaran secara lengkap..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Lampiran File Pembelajaran (PDF / Modul)</label>
                            <input type="file" name="attachment" class="form-control rounded-3">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estimasi Waktu Belajar (Menit)</label>
                            <input type="number" name="duration" class="form-control rounded-3" placeholder="Contoh: 20" value="20">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4 p-3">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold"><i class="fa-solid fa-cloud-arrow-up me-1"></i> Terbitkan Materi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth
@endsection

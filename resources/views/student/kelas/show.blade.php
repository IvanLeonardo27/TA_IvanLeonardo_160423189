@extends('layouts.app')

@section('title', 'Ruang Kelas')

@section('content')
<!-- Header Kelas -->
<div class="card card-modern border-0 overflow-hidden mb-4 animate__animated animate__fadeInDown">
    <div class="bg-primary p-4 p-md-5 position-relative text-white" style="border-radius: var(--radius-md);">
        <i class="fa-solid fa-graduation-cap position-absolute opacity-25" style="font-size: 15rem; right: 5%; bottom: -50px;"></i>
        <div class="position-relative z-2">
            <h1 class="fw-bold display-5 mb-2">Bahasa Jawa - Kelas 5A</h1>
            <p class="fs-5 mb-0 text-white-50">Pengajar: Pak Guru</p>
        </div>
    </div>
</div>

<div class="row g-4 animate__animated animate__fadeInUp">
    <!-- Sidebar Kiri: Upcoming Tasks -->
    <div class="col-lg-3">
        <div class="card card-modern p-4 mb-4 border-0">
            <h6 class="fw-bold text-main mb-3">Mendatang</h6>
            <div class="alert alert-warning border-0 rounded-3 p-2 small mb-2">
                <strong class="d-block text-warning mb-1">Besok, 23:59</strong>
                Mengarang Bebas
            </div>
            <a href="#" class="fw-semibold small text-primary text-decoration-none">Lihat Semua</a>
        </div>
    </div>

    <!-- Feed & Tugas Utama -->
    <div class="col-lg-9">
        
        <!-- Postingan Materi -->
        <div class="card card-modern p-4 mb-4 border-0">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-soft-blue text-primary rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 45px; height: 45px;">
                    <i class="fa-solid fa-book"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-main mb-0">Pak Guru memposting materi baru: Ngoko Lugu lan Alus</h6>
                    <small class="text-muted">22 Jul</small>
                </div>
            </div>
            
            <p class="text-muted mb-3">Silakan pelajari materi PDF yang telah dilampirkan, sebelum kita kuis minggu depan!</p>
            
            <!-- Lampiran -->
            <div class="d-flex mb-4">
                <div class="border rounded-4 p-2 pe-4 d-flex align-items-center cursor-pointer btn-bouncy bg-light">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" width="40" class="me-3">
                    <div>
                        <h6 class="fw-semibold text-main mb-0 fs-6">Modul_Ngoko.pdf</h6>
                        <small class="text-muted">PDF Document</small>
                    </div>
                </div>
            </div>

            <!-- Komentar Kelas -->
            <div class="mt-2 pt-3 border-top">
                <small class="text-muted fw-semibold mb-2 d-block">Komentar Kelas</small>
                <div class="d-flex mt-2 align-items-center">
                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" class="rounded-circle me-3" width="30">
                    <input type="text" class="form-control rounded-pill border-0 bg-light" placeholder="Tambahkan komentar kelas...">
                    <button class="btn btn-light text-primary rounded-circle ms-2"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>
        </div>

        <!-- Tugas dengan Drag & Drop UI -->
        <div class="card card-modern p-4 mb-4 border-0">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 45px; height: 45px;">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div class="w-100 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold text-main mb-0">Tugas: Mengarang Bebas</h6>
                        <small class="text-muted">Tenggat: Besok, 23:59</small>
                    </div>
                    <span class="badge bg-danger rounded-pill px-3">Belum Diserahkan</span>
                </div>
            </div>
            
            <p class="text-muted mb-4">Buatlah sebuah karangan bebas sebanyak 2 paragraf menggunakan ragam bahasa Ngoko Alus.</p>
            
            <!-- Upload Tugas Area (Modern Drag & Drop) -->
            <div class="upload-area p-5 border border-2 border-dashed rounded-4 text-center mb-4 position-relative bg-light transition-all cursor-pointer" id="drop-area">
                <input type="file" id="fileElem" multiple accept="image/*, .pdf, .doc, .docx" class="position-absolute w-100 h-100 opacity-0" style="top:0; left:0; cursor:pointer;" onchange="handleFiles(this.files)">
                <i class="fa-solid fa-cloud-arrow-up text-primary mb-3" style="font-size: 3rem;"></i>
                <h5 class="fw-bold text-main">Tarik & Lepas File Tugas Anda Di Sini</h5>
                <p class="text-muted small mb-0">Atau klik untuk memilih file dari komputer (PDF, DOCX, JPG)</p>
            </div>
            
            <!-- Tampilan File Terpilih (Simulasi) -->
            <div id="gallery" class="d-flex flex-column gap-2 mb-3"></div>

            <div class="d-flex justify-content-end">
                <button class="btn btn-primary rounded-pill px-5 py-2 btn-bouncy fw-bold">Serahkan Tugas</button>
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .border-dashed {
        border-style: dashed !important;
        border-color: #cbd5e1 !important;
    }
    .upload-area:hover {
        background-color: var(--bg-soft-blue) !important;
        border-color: var(--primary) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Simple script to handle file selection preview
    function handleFiles(files) {
        let gallery = document.getElementById('gallery');
        gallery.innerHTML = '';
        [...files].forEach(file => {
            let item = document.createElement('div');
            item.className = 'border rounded-3 p-3 d-flex justify-content-between align-items-center bg-white shadow-sm';
            item.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-file-lines text-primary fs-4 me-3"></i>
                    <span class="fw-semibold text-main">${file.name}</span>
                </div>
                <button class="btn btn-sm btn-light text-danger rounded-circle" onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark"></i></button>
            `;
            gallery.appendChild(item);
        });
    }
</script>
@endpush

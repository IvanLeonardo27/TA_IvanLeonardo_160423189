@extends('layouts.app')

@section('title', 'Detail Materi - Unggah Ungguh')

@section('content')
<div class="mb-4">
    <a href="#" class="text-decoration-none text-muted fw-semibold"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar Materi</a>
</div>

<div class="row g-4">
    <!-- Konten Utama (Video/PDF) -->
    <div class="col-lg-8">
        <div class="card card-modern p-4 mb-4">
            <h4 class="fw-bold text-main mb-3">Section 1: Pangerten Ngoko Lugu</h4>
            
            <!-- Video Placeholder -->
            <div class="bg-dark rounded-4 mb-4 d-flex align-items-center justify-content-center position-relative overflow-hidden" style="height: 400px;">
                <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=1470&auto=format&fit=crop" class="w-100 h-100 object-fit-cover opacity-50" alt="Thumbnail">
                <button class="btn btn-primary rounded-circle position-absolute" style="width: 80px; height: 80px; font-size: 2rem; z-index: 2;">
                    <i class="fa-solid fa-play" style="margin-left: 5px;"></i>
                </button>
            </div>
            
            <h5 class="fw-bold text-main">Deskripsi Materi</h5>
            <p class="text-muted">Ngoko lugu yaiku basa ngoko sing ora dicampur karo tembung-tembung krama inggil tumrap wong sing diajak guneman. Wujud basane ngoko kabeh, ora ana kramane.
            Basa ngoko lugu digunakake kanggo:
            </p>
            <ul class="text-muted">
                <li>Kanca sing wis rumaket (akrab).</li>
                <li>Wong tuwa marang wong enom (tuladha: Bapak marang anak).</li>
                <li>Panggedhe marang andhahane (Bos marang bawahan).</li>
            </ul>

            <div class="d-flex mt-5 border-top pt-4 justify-content-between align-items-center">
                <button class="btn btn-light text-muted px-4 rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i> Sebelumnya</button>
                <button class="btn btn-primary px-4 rounded-pill">Tandai Selesai & Lanjut <i class="fa-solid fa-arrow-right ms-2"></i></button>
            </div>
        </div>
    </div>

    <!-- Sidebar Detail (Daftar Section & Lampiran) -->
    <div class="col-lg-4">
        <div class="card card-modern p-4 mb-4">
            <h6 class="fw-bold text-main mb-3">Daftar Isi Materi</h6>
            <div class="progress mb-2" style="height: 6px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted d-block mb-4 text-end">1 dari 4 Selesai</small>

            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-bottom-0 rounded-3 mb-2 bg-primary text-white shadow-sm">
                    <i class="fa-solid fa-circle-play me-3"></i>
                    <div>
                        <h6 class="mb-0 fw-semibold">1. Pangerten Ngoko Lugu</h6>
                        <small class="text-white-50">10 Menit</small>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-bottom-0 rounded-3 mb-2 bg-light text-main">
                    <i class="fa-regular fa-circle-play text-muted me-3"></i>
                    <div>
                        <h6 class="mb-0 fw-semibold">2. Pangerten Ngoko Alus</h6>
                        <small class="text-muted">15 Menit</small>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-bottom-0 rounded-3 mb-2 bg-light text-main">
                    <i class="fa-regular fa-file-pdf text-danger me-3 ms-1"></i>
                    <div>
                        <h6 class="mb-0 fw-semibold">3. Tuladha Ukara (PDF)</h6>
                        <small class="text-muted">Membaca</small>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-bottom-0 rounded-3 mb-2 bg-light text-main">
                    <i class="fa-solid fa-lock text-muted me-3 ms-1"></i>
                    <div>
                        <h6 class="mb-0 fw-semibold">4. Quiz Evaluasi</h6>
                        <small class="text-muted">10 Soal</small>
                    </div>
                </a>
            </div>
        </div>

        <div class="card card-modern p-4">
            <h6 class="fw-bold text-main mb-3">Lampiran Pendukung</h6>
            <button class="btn btn-outline-primary rounded-3 w-100 d-flex justify-content-between align-items-center mb-2 btn-bouncy">
                <span><i class="fa-solid fa-file-pdf me-2 text-danger"></i> Modul_Ngoko.pdf</span>
                <i class="fa-solid fa-download"></i>
            </button>
            <button class="btn btn-outline-primary rounded-3 w-100 d-flex justify-content-between align-items-center btn-bouncy">
                <span><i class="fa-solid fa-file-powerpoint me-2 text-warning"></i> Slide_Presentasi.pptx</span>
                <i class="fa-solid fa-download"></i>
            </button>
            
            <div class="mt-4 text-center">
                <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_q7uarxsb.json" background="transparent" speed="1" style="width: 150px; height: 150px; margin: 0 auto;" loop autoplay></lottie-player>
                <p class="text-primary fw-bold small mt-2">Semangat Belajarnya!</p>
            </div>
        </div>
    </div>
</div>
@endsection

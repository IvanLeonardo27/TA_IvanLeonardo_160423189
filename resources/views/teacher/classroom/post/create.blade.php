@extends('layouts.app')

@section('title', 'Buat Postingan – ' . $classroom->name)

@section('content')
<div class="row justify-content-center animate__animated animate__fadeInUp">
    <div class="col-xl-8 col-lg-10">
        <div class="mb-4">
            <a href="{{ route('teacher.classroom.show', $classroom) }}" class="text-muted text-decoration-none small">
                <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke {{ $classroom->name }}
            </a>
        </div>        
        
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-3 p-md-5">
                <h4 class="fw-bold text-main mb-1">Buat Postingan Baru</h4>
                <p class="text-muted mb-4 mb-md-5">Bagikan pengumuman, materi, atau tugas kepada siswa.</p>

                <form action="{{ route('teacher.classroom.post.store', $classroom) }}" method="POST" enctype="multipart/form-data" id="postForm" novalidate>
                    @csrf

                    @php
                        $selectedType = old('type', request('type', 'material'));
                        $targetWeek = (int) request('week', old('week_number', 1));
                        $targetWeekTitle = $targetWeek === 0 ? 'General (Pengumuman Umum)' : ('Week ' . $targetWeek . ' - ' . $classroom->getWeekTitle($targetWeek));
                    @endphp

                    {{-- Target Minggu Otomatis Terhubung dari Button + (Menghilangkan Dropdown Manual) --}}
                    <input type="hidden" name="week_number" value="{{ $targetWeek }}">
                    <div class="mb-4 p-3 rounded-4 bg-light border d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px; height:36px; background:#E0F2FE; color:#0284C7;">
                                <i class="fa-solid fa-calendar-check fs-6"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.72rem; line-height: 1.1;">Penempatan Konten</small>
                                <span class="fw-bold text-dark" style="font-size: 0.88rem;">{{ $targetWeekTitle }}</span>
                            </div>
                        </div>
                        <span class="badge bg-white text-primary border rounded-pill px-2.5 py-1 fw-semibold shadow-xs" style="font-size: 0.72rem;">
                            <i class="fa-solid fa-link me-1 opacity-75"></i>Terpilih Otomatis
                        </span>
                    </div>

                    {{-- Pilih Tipe Post (4 Fitur Pembelajaran + Pengumuman) --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Jenis Postingan <span class="text-danger">*</span></label>
                        <input type="hidden" name="type" id="typeInput" value="{{ $selectedType }}">
                        <div class="d-flex gap-2 gap-md-3 flex-wrap">
                            @foreach([
                                ['material','Materi Belajar','book-open','#3B82F6'],
                                ['assignment','Tugas','clipboard-list','#EF4444'],
                                ['quiz','Evaluasi / Quiz','pen-to-square','#8B5CF6'],
                                ['url','Tautan Web / URL','link','#0284C7'],
                                ['announcement','Pengumuman','bullhorn','#10B981'],
                            ] as [$val, $label, $icon, $color])
                            <button type="button" class="type-btn btn border-2 rounded-4 px-3 px-md-4 py-2.5 py-md-3 d-flex flex-column align-items-center gap-1 {{ $val === $selectedType ? 'btn-primary border-primary text-white' : 'btn-light' }}"
                                    data-type="{{ $val }}" data-color="{{ $color }}" style="flex:1 1 auto; min-width:110px; max-width:160px; transition:.2s;">
                                <i class="fa-solid fa-{{ $icon }} fs-4"></i>
                                <span class="fw-semibold small text-center" style="font-size:0.8rem;">{{ $label }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" id="titleLabel">Judul Postingan <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="postTitleInput" class="form-control rounded-4 border-0 bg-light form-control-lg"
                               placeholder="Judul postingan..." value="{{ old('title') }}">
                    </div>

                    {{-- Status Visibilitas Siswa --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Visibilitas Siswa <span class="text-muted fw-normal">(Status Akses)</span></label>
                        <select name="is_published" class="form-select rounded-4 border-0 bg-light form-select-lg">
                            <option value="1" {{ old('is_published', '1') == '1' ? 'selected' : '' }}>Tampilkan Langsung ke Siswa</option>
                            <option value="0" {{ old('is_published') === '0' ? 'selected' : '' }}>Sembunyikan dari Siswa (Draft)</option>
                        </select>
                        <div class="form-text text-muted small">
                            Jika disembunyikan (<em>Hidden from students</em>), postingan ini hanya dapat dilihat oleh Pengajar dan belum dapat diakses oleh Siswa.
                        </div>
                    </div>

                    {{-- Field Khusus Tautan URL (Referensi Gambar 4: Moodle New URL) --}}
                    <div id="urlFields" class="d-none">
                        <div class="card border-0 rounded-4 p-4 shadow-sm mb-4" style="background: #F0F9FF; border: 1.5px solid #BAE6FD !important;">
                            <div class="d-flex align-items-center gap-3 mb-3 pb-2 border-bottom border-info-subtle">
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-white shadow-xs" style="width:42px;height:42px;flex-shrink:0; color:#0284C7;">
                                    <i class="fa-solid fa-link fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0" style="color: #0369A1;">Tautan Web Eksternal (External URL)</h6>
                                    <small class="text-muted">Masukkan tautan website referensi, artikel, Google Docs/Drive, atau video.</small>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-bold small text-dark" id="externalUrlLabel">
                                    External URL <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-0 text-muted shadow-xs"><i class="fa-solid fa-globe"></i></span>
                                    <input type="url" name="link_url" id="linkUrlInput" class="form-control border-0 bg-white shadow-xs form-control-lg" 
                                           placeholder="https://contoh-website.com/materi-pembelajaran" value="{{ old('link_url') }}">
                                </div>
                                <div class="form-text text-muted small mt-1.5">
                                    <i class="fa-solid fa-circle-info me-1"></i>Contoh format: <code>https://id.wikipedia.org/...</code> atau <code>https://docs.google.com/...</code>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi Umum / Pengantar --}}
                    <div class="mb-4" id="standardBodyField">
                        <label class="form-label fw-semibold" id="standardBodyLabel">Isi / Deskripsi Materi</label>
                        <textarea name="body" rows="4" class="form-control rounded-4 border-0 bg-light"
                                  placeholder="Tuliskan ringkasan materi, petunjuk umum, atau deskripsi pembelajaran...">{{ old('body') }}</textarea>
                    </div>

                    {{-- Field Khusus Materi: Upload PDF atau Slide Builder --}}
                    <div id="materialSection" class="d-none">
                        {{-- Format Penyajian Materi --}}
                        <div class="card border-0 rounded-4 p-3 p-md-4 shadow-sm mb-4" style="background:#F8FAFC; border:1.5px solid #E2E8F0 !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom">
                                <div>
                                    <h6 class="fw-bold text-main m-0 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-file-pdf text-danger fs-5"></i> Format Penyajian Materi
                                    </h6>
                                    <small class="text-muted">Pilih metode penyajian dokumen PDF atau ketik slide teks.</small>
                                </div>
                                <input type="hidden" name="material_input_mode" id="materialInputMode" value="ppt">
                                <div class="btn-group p-1 bg-white rounded-pill shadow-sm border" role="group">
                                    <button type="button" id="modePptBtn" class="btn btn-sm rounded-pill px-2.5 px-md-3 fw-bold btn-primary text-white" style="transition:.2s; font-size:0.78rem;">
                                        <i class="fa-solid fa-file-pdf me-1"></i> Upload File PDF Materi
                                    </button>
                                    <button type="button" id="modeManualBtn" class="btn btn-sm rounded-pill px-2.5 px-md-3 fw-bold btn-light text-muted" style="transition:.2s; font-size:0.78rem;">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> Ketik Slide Teks
                                    </button>
                                </div>
                            </div>

                            {{-- Mode 1: Upload File PDF Materi (Praktis, langsung tampil interaktif di web) --}}
                            <div id="pptUploadModeWrapper">
                                <div class="row g-3">
                                    <div class="col-md-7">
                                        <label class="form-label fw-semibold text-main small">Pilih Berkas PDF Materi / Slide <span class="text-danger">*</span></label>
                                        <div id="pptDropZone" class="p-3 p-md-4 border-2 border-dashed rounded-4 bg-white text-center position-relative w-100" style="border-color:#EF4444 !important; cursor:pointer; min-height:120px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                                            <input type="file" name="files[]" id="pptFileInput" accept=".pdf,.ppt,.pptx" class="position-absolute w-100 h-100 opacity-0" style="top:0;left:0;cursor:pointer;">
                                            <div id="pptFileDisplay" class="w-100">
                                                <i class="fa-solid fa-file-pdf text-danger fs-2 mb-2"></i>
                                                <h6 class="fw-bold text-main mb-1 fs-6">Klik atau Seret Berkas PDF Di Sini</h6>
                                                <small class="text-muted d-block" style="font-size:0.75rem;">Format didukung: .pdf (Maks. 20 MB)</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold text-main small">Total Jumlah Halaman / Slide PDF <span class="text-danger">*</span></label>
                                        <div class="bg-white p-3 rounded-4 border shadow-sm w-100">
                                            <div class="input-group mb-2">
                                                <span class="input-group-text bg-light border-0 fw-bold text-danger" style="font-size:0.85rem;"><i class="fa-solid fa-file-pdf me-1"></i> Total</span>
                                                <input type="number" name="total_ppt_slides" id="totalPptSlidesInput" class="form-control border-0 bg-light fw-bold text-center fs-5" value="10" min="1" max="150">
                                                <span class="input-group-text bg-light border-0 text-muted" style="font-size:0.85rem;">Halaman</span>
                                            </div>
                                            <small class="text-muted d-block mb-2" style="font-size:0.75rem; line-height:1.3;">
                                                Masukkan jumlah halaman pada berkas PDF Anda.
                                            </small>
                                            <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-2.5 rounded-3 mb-0 small" style="font-size:0.75rem;">
                                                <i class="fa-solid fa-circle-check text-success flex-shrink-0"></i>
                                                <span><strong>Praktis:</strong> Siswa dapat membaca PDF langsung di dalam web.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Mode 2: Ketik Slide Manual (Opsional jika ingin ketik teks) --}}
                            <div id="manualSlidesModeWrapper" class="d-none mt-3">
                                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                    <span class="badge bg-primary text-white rounded-pill px-2.5 py-1" style="font-size:0.7rem;" id="slideTotalBadge">1 Slide</span>
                                    <button type="button" id="addSlideBtn" class="btn btn-sm rounded-pill btn-outline-primary fw-bold px-3 btn-bouncy">
                                        <i class="fa-solid fa-plus me-1"></i> Tambah Slide Baru
                                    </button>
                                </div>
                                <div id="slidesContainer" class="d-flex flex-column gap-3">
                                    <!-- Dynamic Slides injected via JS -->
                                </div>
                            </div>
                        </div>

                        {{-- Mode Belajar dengan Latihan Soal (In-Slide Checkpoint) --}}
                        <div class="card border-0 rounded-4 p-3 p-md-4 shadow-sm" style="background: linear-gradient(135deg, #F0FDF4 0%, #EFF6FF 100%); border: 1.5px solid #BFDBFE !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-white shadow-sm text-primary" style="width:44px;height:44px;flex-shrink:0;">
                                        <i class="fa-solid fa-graduation-cap fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-main mb-1 d-flex align-items-center gap-2 flex-wrap" style="font-size:0.95rem;">
                                            Fitur Pertanyaan Singkat di Atas Slide
                                            <span class="badge bg-primary text-white rounded-pill px-2 py-0.5" style="font-size:0.65rem;">In-Slide Checkpoint</span>
                                        </h6>
                                        <p class="text-muted small mb-0" style="font-size:0.8rem;">Tampilkan 1 pertanyaan pilihan ganda tepat setelah siswa membaca slide tertentu.</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2 bg-white rounded-pill p-1.5 shadow-sm border">
                                    <span class="small fw-bold px-2 text-muted" style="font-size:0.78rem;">Beri Pertanyaan Singkat?</span>
                                    <input type="hidden" name="has_practice_questions" id="hasPracticeQuestionsInput" value="0">
                                    <button type="button" id="practiceNoBtn" class="btn btn-sm rounded-pill px-3 fw-bold btn-primary text-white" style="transition:.2s; font-size:0.78rem;">
                                        <i class="fa-solid fa-xmark me-1"></i>Tidak
                                    </button>
                                    <button type="button" id="practiceYesBtn" class="btn btn-sm rounded-pill px-3 fw-bold btn-light text-muted" style="transition:.2s; font-size:0.78rem;">
                                        <i class="fa-solid fa-check me-1"></i>Ya
                                    </button>
                                </div>
                            </div>

                            {{-- Container Pertanyaan Checkpoint (Muncul saat Pengajar memilih "Ya") --}}
                            <div id="materialQuestionsWrapper" class="d-none mt-4 pt-4 border-top border-primary-subtle">
                                <div class="alert alert-primary bg-white border border-primary-subtle rounded-4 p-3 mb-4 shadow-sm">
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-7">
                                            <label class="form-label fw-bold text-main mb-1" style="font-size:0.9rem;">
                                                <i class="fa-solid fa-stopwatch-20 text-primary me-1"></i> Mau ditampilkan setelah pembaca membaca slide berapa? <span class="text-danger">*</span>
                                            </label>
                                            <p class="text-muted small mb-0" style="font-size:0.78rem;">Pertanyaan akan langsung muncul mengunci slide target dan menguji siswa sebelum lanjut ke slide berikutnya.</p>
                                        </div>
                                        <div class="col-md-5">
                                            <select name="checkpoint_slide" id="checkpointSlideSelect" class="form-select rounded-4 border-primary shadow-sm fw-bold text-primary">
                                                <option value="1">Setelah Slide 1</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white border-start border-4 border-primary">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="badge rounded-pill px-3 py-1.5 fw-bold text-white" style="background:#3B82F6; font-size:0.8rem;">
                                            <i class="fa-solid fa-circle-question me-1"></i> Pertanyaan Checkpoint Pemahaman
                                        </span>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold text-main small">Pertanyaan Soal <span class="text-danger">*</span></label>
                                        <textarea name="material_questions[0][text]" id="matQuestionTextInput" rows="2" class="form-control rounded-4 border-0 bg-light"
                                                  placeholder="Contoh: Apa arti dari materi yang dibahas pada slide di atas?"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-1">
                                            <label class="form-label fw-semibold text-main m-0 small">Pilihan Jawaban & Kunci</label>
                                            <small class="text-muted" style="font-size:0.72rem;"><i class="fa-solid fa-circle-info me-1"></i>Pilih radio button untuk menentukan kunci jawaban yang benar</small>
                                        </div>

                                        <div id="materialOptionsList" class="d-flex flex-column gap-2">
                                            <!-- Option rows injected via JS -->
                                        </div>

                                        <div class="mt-3">
                                            <button type="button" id="addMaterialOptBtn" class="btn btn-light border btn-sm rounded-pill fw-semibold text-primary px-3 py-1.5" style="font-size:0.8rem;">
                                                <i class="fa-solid fa-plus me-1"></i> Tambah Pilihan Jawaban (+ E, F...)
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Field Khusus Tugas --}}
                    <div id="assignmentFields" class="d-none">
                        <hr class="my-4">
                        <h6 class="fw-bold text-danger mb-3"><i class="fa-solid fa-clipboard-list me-2"></i>Detail Tugas</h6>
                        <div class="row g-3 g-md-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tenggat Waktu</label>
                                <input type="datetime-local" name="assignment_due_date" id="assignmentDueDate" class="form-control rounded-4 border-0 bg-light" value="{{ old('assignment_due_date', old('due_date')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nilai Maksimal</label>
                                <input type="number" name="max_score" class="form-control rounded-4 border-0 bg-light"
                                       placeholder="100" min="0" max="1000" value="{{ old('max_score', 100) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Instruksi Tugas</label>
                                <textarea name="instructions" rows="3" class="form-control rounded-4 border-0 bg-light"
                                          placeholder="Jelaskan cara pengerjaan tugas...">{{ old('instructions') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Field Khusus Evaluasi / Quiz --}}
                    <div id="quizFields" class="d-none">
                        <hr class="my-4">
                        <h6 class="fw-bold text-purple mb-3" style="color: #8B5CF6;"><i class="fa-solid fa-pen-to-square me-2"></i>Pengaturan Evaluasi / Quiz Kelas</h6>
                        <div class="row g-3 g-md-4 mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Tenggat Waktu Kuis <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="quiz_due_date" id="quizDueDate" class="form-control rounded-4 border-0 bg-light" value="{{ old('quiz_due_date', old('due_date')) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Durasi (Menit)</label>
                                <input type="number" name="duration_minutes" class="form-control rounded-4 border-0 bg-light"
                                       placeholder="30" min="1" max="300" value="{{ old('duration_minutes', 30) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Batas Pengisian</label>
                                <select name="max_attempts" class="form-select rounded-4 border-0 bg-light fw-semibold">
                                    <option value="1" {{ old('max_attempts', '1') == '1' ? 'selected' : '' }}>🔒 Hanya 1 Kali</option>
                                    <option value="0" {{ old('max_attempts') == '0' ? 'selected' : '' }}>🔄 Bebas (Berkali-kali)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Visibilitas Nilai Siswa</label>
                                <select name="show_score" class="form-select rounded-4 border-0 bg-light fw-semibold">
                                    <option value="1" {{ old('show_score', '1') == '1' ? 'selected' : '' }}>👁️ Tampilkan Nilai Langsung</option>
                                    <option value="0" {{ old('show_score') == '0' ? 'selected' : '' }}>🙈 Sembunyikan Nilai</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Izin Pembahasan & Kunci Jawaban</label>
                                <select name="show_explanation" class="form-select rounded-4 border-0 bg-light fw-semibold">
                                    <option value="0" {{ old('show_explanation', '0') == '0' ? 'selected' : '' }}>🔒 Kunci Pembahasan (Hanya Nilai)</option>
                                    <option value="1" {{ old('show_explanation') == '1' ? 'selected' : '' }}>🔓 Buka Pembahasan (Siswa Bisa Tinjau)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Instruksi & Petunjuk Kuis</label>
                                <textarea name="instructions" rows="2" class="form-control rounded-4 border-0 bg-light"
                                          placeholder="Tuliskan petunjuk pengerjaan kuis untuk siswa...">{{ old('instructions') }}</textarea>
                            </div>
                        </div>

                        {{-- DYNAMIC QUESTION BUILDER (PILIHAN GANDA) --}}
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2 flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="fw-bold text-main m-0 small"><i class="fa-solid fa-list-ol text-purple me-2"></i>Daftar Soal Pilihan Ganda</h6>
                                <span class="badge bg-light text-secondary border rounded-pill px-2.5 py-1 font-monospace" id="questionCountBadge" style="font-size:0.75rem;">1 Soal</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-sm rounded-pill fw-bold px-3 btn-bouncy" style="background:#F3E8FF; color:#7C3AED; border:1px solid #DDD6FE; font-size:0.8rem;" data-bs-toggle="modal" data-bs-target="#questionBankModal">
                                    <i class="fa-solid fa-boxes-stacked me-1"></i> Ambil dari Bank Soal
                                </button>
                                <button type="button" id="addQuestionTopBtn" class="btn btn-sm rounded-pill text-white fw-bold px-3 btn-bouncy" style="background:#8B5CF6; font-size:0.8rem;">
                                    <i class="fa-solid fa-plus me-1"></i> Tambah Soal Manual
                                </button>
                            </div>
                        </div>

                        <div id="questionsContainer" class="d-flex flex-column gap-4">
                            <!-- Question Card Template will be injected via JS -->
                        </div>

                        {{-- Tombol Tambah Soal Baru di Akhir Setiap Soal --}}
                        <div class="mt-4 text-center" id="addQuestionEndWrapper">
                            <div class="p-3.5 rounded-4 border-2 border-dashed bg-white shadow-xs d-flex flex-column align-items-center justify-content-center"
                                 style="border-color: #C4B5FD !important; border-style: dashed !important; background: linear-gradient(135deg, rgba(139,92,246,0.03) 0%, rgba(243,232,255,0.25) 100%) !important;">
                                <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                    <button type="button" class="btn rounded-pill fw-bold px-4 py-2.5 btn-bouncy shadow-sm d-inline-flex align-items-center gap-2"
                                            data-bs-toggle="modal" data-bs-target="#questionBankModal"
                                            style="background: #F3E8FF; color: #7C3AED; border: 1.5px solid #DDD6FE; font-size: 0.92rem;">
                                        <i class="fa-solid fa-boxes-stacked fs-5"></i>
                                        <span>Ambil dari Bank Soal</span>
                                    </button>
                                    <button type="button" id="addQuestionBtn" class="btn rounded-pill text-white fw-bold px-4 py-2.5 btn-bouncy shadow-sm d-inline-flex align-items-center gap-2"
                                            style="background: #8B5CF6; font-size: 0.92rem;">
                                        <i class="fa-solid fa-circle-plus fs-5"></i>
                                        <span>Tambah Soal Manual</span>
                                    </button>
                                </div>
                                <span class="text-muted small mt-2" style="font-size: 0.76rem;">
                                    <i class="fa-solid fa-circle-info text-purple me-1"></i>Anda dapat memilih soal yang sudah tersimpan di Bank Soal atau membuat soal baru.
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Upload Lampiran (Hanya untuk Pengumuman, Tugas, atau Kuis) --}}
                    <div class="mb-4 mt-4" id="standardAttachmentSection">
                        <label class="form-label fw-semibold">Lampiran File (Opsional)</label>
                        <div id="dropZone" class="border-2 border-dashed rounded-4 p-4 p-md-5 text-center position-relative"
                             style="border-color:#CBD5E1; background:#F8FAFC; cursor:pointer; transition:.2s;">
                            <input type="file" name="files[]" id="filesInput" multiple class="position-absolute w-100 h-100 opacity-0"
                                   style="top:0;left:0;cursor:pointer;">
                            <i class="fa-solid fa-cloud-arrow-up text-primary mb-2 fs-2"></i>
                            <h6 class="fw-bold text-main mb-1 fs-6">Seret & Lepas File Di Sini</h6>
                            <p class="text-muted small mb-0" style="font-size:0.75rem;">PDF, DOCX, JPG, MP4 – Maksimum 20 MB per file</p>
                        </div>
                        <div id="filePreview" class="mt-3 d-flex flex-column gap-2"></div>
                    </div>

                    {{-- Action Buttons (Mobile Responsive) --}}
                    <div class="d-flex flex-column flex-sm-row gap-2 mt-4 pt-3 border-top">
                        <button type="submit" id="submitPostBtn" class="btn btn-primary rounded-pill px-5 py-2.5 btn-bouncy fw-semibold shadow order-1 order-sm-2 w-100 w-sm-auto text-center">
                            <i class="fa-solid fa-paper-plane me-2"></i>Posting Sekarang
                        </button>
                        <a href="{{ route('teacher.classroom.show', $classroom) }}" class="btn btn-light rounded-pill px-4 py-2.5 order-2 order-sm-1 w-100 w-sm-auto text-center">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Ambil dari Bank Soal --}}
<div class="modal fade" id="questionBankModal" tabindex="-1" aria-labelledby="questionBankModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-bottom py-3 px-4" style="background: linear-gradient(135deg, #F5F3FF 0%, #EDE9FE 100%);">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:36px;height:36px;background:#8B5CF6;">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-main mb-0" id="questionBankModalLabel">Pilih Soal dari Bank Soal</h5>
                        <small class="text-muted" style="font-size:0.75rem;">Pilih butir soal yang ingin Anda gunakan ulang pada kuis ini</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                {{-- Search & Filter --}}
                <div class="row g-2 mb-3">
                    <div class="col-md-7">
                        <div class="input-group shadow-xs rounded-pill overflow-hidden">
                            <span class="input-group-text bg-white border-0 ps-3">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" id="bankSearchInput" class="form-control border-0 bg-white py-2" placeholder="Cari pertanyaan soal...">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <select id="bankCategorySelect" class="form-select border-0 rounded-pill py-2 shadow-xs fw-semibold bg-white">
                            <option value="all">Semua Kategori Topik</option>
                            <option value="umum">Umum</option>
                            <option value="aksara-jawa">Aksara Jawa</option>
                            <option value="macapat">Tembang Macapat</option>
                            <option value="wayang">Pewayangan</option>
                            <option value="unggah-ungguh">Unggah-Ungguh Basa</option>
                        </select>
                    </div>
                </div>

                {{-- Loading Spinner --}}
                <div id="bankLoadingSpinner" class="text-center py-5 d-none">
                    <div class="spinner-border text-purple" role="status" style="color:#8B5CF6;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted small mt-2 mb-0">Memuat data Bank Soal...</p>
                </div>

                {{-- Container Daftar Soal Bank Soal --}}
                <div id="bankQuestionsList" class="d-flex flex-column gap-2.5">
                    <!-- Questions injected dynamically via AJAX -->
                </div>
            </div>
            <div class="modal-footer border-top py-2.5 px-4 bg-white d-flex justify-content-between align-items-center">
                <div>
                    <span class="fw-bold text-main small" id="bankSelectedCounter">0 soal dipilih</span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4 py-2" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="insertSelectedQuestionsBtn" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-xs" style="background:#8B5CF6; border-color:#8B5CF6;" disabled>
                        <i class="fa-solid fa-plus me-1"></i> Tambahkan ke Kuis
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-dashed { border-style: dashed !important; }
#dropZone:hover { border-color: var(--bs-primary) !important; background: #EFF6FF !important; }
.btn-bouncy:active { transform: scale(0.97); }
</style>
@endpush

@push('scripts')
<script>
    const typeButtons               = document.querySelectorAll('.type-btn');
    const typeInput                 = document.getElementById('typeInput');
    const assignFields              = document.getElementById('assignmentFields');
    const quizFields                = document.getElementById('quizFields');
    const materialSection           = document.getElementById('materialSection');
    const urlFields                 = document.getElementById('urlFields');
    const standardAttachmentSection = document.getElementById('standardAttachmentSection');
    const titleLabel                = document.getElementById('titleLabel');
    const postTitleInput            = document.getElementById('postTitleInput');
    const standardBodyLabel         = document.getElementById('standardBodyLabel');

    function syncFieldStates(type) {
        assignFields.classList.toggle('d-none', type !== 'assignment');
        quizFields.classList.toggle('d-none', type !== 'quiz');
        materialSection.classList.toggle('d-none', type !== 'material');
        if (urlFields) {
            urlFields.classList.toggle('d-none', type !== 'url');
            urlFields.querySelectorAll('input, select, textarea').forEach(el => el.disabled = (type !== 'url'));
        }

        if (standardAttachmentSection) {
            standardAttachmentSection.classList.toggle('d-none', type === 'material' || type === 'url' || type === 'quiz');
        }
        const filesInput = document.getElementById('filesInput');
        if (filesInput) {
            filesInput.disabled = (type === 'material' || type === 'url' || type === 'quiz');
        }

        // Toggle disabled attribute so hidden inputs are not submitted
        assignFields.querySelectorAll('input, select, textarea').forEach(el => el.disabled = (type !== 'assignment'));
        quizFields.querySelectorAll('input, select, textarea').forEach(el => el.disabled = (type !== 'quiz'));
        materialSection.querySelectorAll('input, select, textarea').forEach(el => el.disabled = (type !== 'material'));

        const quizDueDate = document.getElementById('quizDueDate');
        if (quizDueDate) {
            if (type === 'quiz') {
                quizDueDate.setAttribute('required', 'required');
            } else {
                quizDueDate.removeAttribute('required');
            }
        }

        // Dynamic labels based on type
        if (type === 'url') {
            if (titleLabel) titleLabel.innerHTML = 'Nama Tautan (Name) <span class="text-danger">*</span>';
            if (postTitleInput) postTitleInput.placeholder = 'Contoh: Materi Dokumentasi Kotlin / Link Modul...';
            if (standardBodyLabel) standardBodyLabel.textContent = 'Deskripsi Tautan (Description) - Opsional';
        } else if (type === 'assignment') {
            if (titleLabel) titleLabel.innerHTML = 'Judul Tugas <span class="text-danger">*</span>';
            if (postTitleInput) postTitleInput.placeholder = 'Judul tugas...';
            if (standardBodyLabel) standardBodyLabel.textContent = 'Ringkasan Tugas';
        } else if (type === 'quiz') {
            if (titleLabel) titleLabel.innerHTML = 'Judul Evaluasi / Quiz <span class="text-danger">*</span>';
            if (postTitleInput) postTitleInput.placeholder = 'Judul kuis atau ujian...';
            if (standardBodyLabel) standardBodyLabel.textContent = 'Petunjuk Singkat Kuis';
        } else if (type === 'material') {
            if (titleLabel) titleLabel.innerHTML = 'Judul Materi Pembelajaran <span class="text-danger">*</span>';
            if (postTitleInput) postTitleInput.placeholder = 'Judul materi...';
            if (standardBodyLabel) standardBodyLabel.textContent = 'Isi / Deskripsi Materi';
        } else {
            if (titleLabel) titleLabel.innerHTML = 'Judul Pengumuman';
            if (postTitleInput) postTitleInput.placeholder = 'Judul pengumuman...';
            if (standardBodyLabel) standardBodyLabel.textContent = 'Isi Pengumuman';
        }
    }

    typeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const type  = btn.dataset.type;
            typeInput.value = type;

            syncFieldStates(type);

            typeButtons.forEach(b => {
                b.className = b.className.replace(/btn-primary|border-primary|text-white/g, '').trim();
                b.classList.add('btn-light');
            });
            btn.classList.remove('btn-light');
            btn.classList.add('btn-primary', 'border-primary', 'text-white');
        });
    });

    // Initial sync
    syncFieldStates(typeInput.value || 'material');

    // Format Mode Switcher (PPT Upload vs Ketik Slide Manual)
    const modePptBtn             = document.getElementById('modePptBtn');
    const modeManualBtn          = document.getElementById('modeManualBtn');
    const materialInputMode      = document.getElementById('materialInputMode');
    const pptUploadModeWrapper   = document.getElementById('pptUploadModeWrapper');
    const manualSlidesModeWrapper= document.getElementById('manualSlidesModeWrapper');
    const totalPptSlidesInput    = document.getElementById('totalPptSlidesInput');
    const pptFileInput           = document.getElementById('pptFileInput');
    const pptFileDisplay         = document.getElementById('pptFileDisplay');
    const checkpointSlideSelect  = document.getElementById('checkpointSlideSelect');

    function syncPptCheckpointOptions() {
        const total = Math.max(1, parseInt(totalPptSlidesInput.value) || 10);
        checkpointSlideSelect.innerHTML = '';
        for (let num = 1; num <= total; num++) {
            const opt = document.createElement('option');
            opt.value = num;
            opt.textContent = `Setelah Halaman / Slide ${num}${num === Math.ceil(total/2) ? ' (Tengah Materi)' : ''}`;
            checkpointSlideSelect.appendChild(opt);
        }
        checkpointSlideSelect.value = Math.ceil(total / 2);
    }

    if (totalPptSlidesInput) {
        totalPptSlidesInput.addEventListener('input', syncPptCheckpointOptions);
    }

    if (pptFileInput) {
        pptFileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const sizeMb = (file.size / 1024 / 1024).toFixed(2);
                pptFileDisplay.innerHTML = `
                    <div class="d-flex align-items-center justify-content-center gap-3 p-2">
                        <i class="fa-solid fa-file-pdf text-danger fs-2"></i>
                        <div class="text-start">
                            <h6 class="fw-bold text-main mb-0">${file.name}</h6>
                            <small class="text-success fw-semibold"><i class="fa-solid fa-check-circle me-1"></i>Berkas PDF siap diunggah (${sizeMb} MB)</small>
                        </div>
                    </div>
                `;
            }
        });
    }

    modePptBtn.addEventListener('click', () => {
        materialInputMode.value = 'ppt';
        modePptBtn.classList.remove('btn-light', 'text-muted');
        modePptBtn.classList.add('btn-primary', 'text-white');

        modeManualBtn.classList.remove('btn-primary', 'text-white');
        modeManualBtn.classList.add('btn-light', 'text-muted');

        pptUploadModeWrapper.classList.remove('d-none');
        manualSlidesModeWrapper.classList.add('d-none');

        syncPptCheckpointOptions();
    });

    modeManualBtn.addEventListener('click', () => {
        materialInputMode.value = 'manual';
        modeManualBtn.classList.remove('btn-light', 'text-muted');
        modeManualBtn.classList.add('btn-primary', 'text-white');

        modePptBtn.classList.remove('btn-primary', 'text-white');
        modePptBtn.classList.add('btn-light', 'text-muted');

        manualSlidesModeWrapper.classList.remove('d-none');
        pptUploadModeWrapper.classList.add('d-none');

        updateSlideNumbers();
    });

    // Default init PPT checkpoint options
    syncPptCheckpointOptions();

    // Dynamic Multi-Slide Builder for Material
    const slidesContainer = document.getElementById('slidesContainer');
    const addSlideBtn     = document.getElementById('addSlideBtn');
    const slideTotalBadge = document.getElementById('slideTotalBadge');

    function renderSlideCard(index) {
        const slideCard = document.createElement('div');
        slideCard.className = 'card border rounded-4 p-3 bg-white shadow-sm slide-item';
        slideCard.dataset.slideIndex = index;

        slideCard.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1.5 fw-bold slide-badge">
                    <i class="fa-solid fa-file-powerpoint me-1"></i> Slide ${index + 1}
                </span>
                <button type="button" class="btn btn-light btn-sm text-danger rounded-circle remove-slide-btn" title="Hapus Slide Ini" style="width:30px;height:30px;padding:0;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="mb-2">
                <input type="text" name="slides[${index}][title]" class="form-control form-control-sm rounded-3 border-0 bg-light fw-semibold"
                       placeholder="Judul Slide ${index + 1} (Opsional)..." value="${index === 0 ? 'Pengantar Materi' : ''}">
            </div>
            <div>
                <textarea name="slides[${index}][content]" rows="3" class="form-control rounded-3 border-0 bg-light"
                          placeholder="Tuliskan isi materi untuk Slide ${index + 1}..."></textarea>
            </div>
        `;

        const removeBtn = slideCard.querySelector('.remove-slide-btn');
        removeBtn.addEventListener('click', () => {
            if (slidesContainer.children.length <= 1) {
                alert('Materi harus memiliki minimal 1 slide.');
                return;
            }
            slideCard.remove();
            updateSlideNumbers();
        });

        slidesContainer.appendChild(slideCard);
    }

    function updateSlideNumbers() {
        const total = slidesContainer.children.length;
        slideTotalBadge.textContent = `${total} Slide`;

        if (materialInputMode.value === 'manual') {
            checkpointSlideSelect.innerHTML = '';
            [...slidesContainer.children].forEach((card, idx) => {
                const num = idx + 1;
                card.dataset.slideIndex = idx;
                const badge = card.querySelector('.slide-badge');
                badge.innerHTML = `<i class="fa-solid fa-file-powerpoint me-1"></i> Slide ${num}`;

                const opt = document.createElement('option');
                opt.value = num;
                opt.textContent = `Setelah Slide ${num}${num === Math.ceil(total/2) ? ' (Tengah Materi)' : ''}`;
                checkpointSlideSelect.appendChild(opt);
            });

            const defaultMid = Math.max(1, Math.ceil(total / 2));
            checkpointSlideSelect.value = defaultMid;
        }
    }

    // Initialize with 3 slides by default for manual mode
    renderSlideCard(0);
    renderSlideCard(1);
    renderSlideCard(2);
    updateSlideNumbers();

    addSlideBtn.addEventListener('click', () => {
        const currentCount = slidesContainer.children.length;
        renderSlideCard(currentCount);
        updateSlideNumbers();
    });

    // In-Slide Checkpoint Toggle
    const practiceYesBtn          = document.getElementById('practiceYesBtn');
    const practiceNoBtn           = document.getElementById('practiceNoBtn');
    const hasPracticeInput        = document.getElementById('hasPracticeQuestionsInput');
    const materialQuestionsWrapper = document.getElementById('materialQuestionsWrapper');
    const materialOptionsList     = document.getElementById('materialOptionsList');
    const addMaterialOptBtn       = document.getElementById('addMaterialOptBtn');

    practiceYesBtn.addEventListener('click', () => {
        hasPracticeInput.value = '1';
        practiceYesBtn.classList.remove('btn-light', 'text-muted');
        practiceYesBtn.classList.add('btn-primary', 'text-white');

        practiceNoBtn.classList.remove('btn-primary', 'text-white');
        practiceNoBtn.classList.add('btn-light', 'text-muted');

        materialQuestionsWrapper.classList.remove('d-none');
    });

    practiceNoBtn.addEventListener('click', () => {
        hasPracticeInput.value = '0';
        practiceNoBtn.classList.remove('btn-light', 'text-muted');
        practiceNoBtn.classList.add('btn-primary', 'text-white');

        practiceYesBtn.classList.remove('btn-primary', 'text-white');
        practiceYesBtn.classList.add('btn-light', 'text-muted');

        materialQuestionsWrapper.classList.add('d-none');
    });

    function renderSingleOption(container, letter) {
        const row = document.createElement('div');
        row.className = 'd-flex align-items-center gap-2 option-row w-100 mb-2 animate__animated animate__fadeIn';

        row.innerHTML = `
            <div class="form-check d-flex align-items-center m-0 flex-shrink-0">
                <input class="form-check-input me-1.5" type="radio" name="material_questions[0][correct]" value="${letter}" ${letter === 'A' ? 'checked' : ''} style="cursor:pointer; width:18px; height:18px;">
                <span class="badge bg-light text-dark border font-monospace fw-bold px-2 py-1 mat-opt-letter" style="font-size:0.85rem;">${letter}</span>
            </div>
            <input type="text" name="material_questions[0][options][${letter}]" class="form-control rounded-4 border-0 bg-light flex-grow-1" style="min-width:0;"
                   placeholder="Pilihan jawaban ${letter}...">
            <button type="button" class="btn btn-light btn-sm text-danger rounded-circle remove-opt-btn flex-shrink-0" style="width:30px;height:30px;padding:0;" title="Hapus Pilihan">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;

        const removeBtn = row.querySelector('.remove-opt-btn');
        removeBtn.addEventListener('click', () => {
            if (container.children.length <= 2) {
                alert('Pilihan ganda harus memiliki minimal 2 pilihan jawaban.');
                return;
            }
            row.remove();
            reorderMatOptionBadges();
        });

        container.appendChild(row);
    }

    function reorderMatOptionBadges() {
        [...materialOptionsList.children].forEach((row, idx) => {
            const letter = String.fromCharCode(65 + idx);
            const badge  = row.querySelector('.mat-opt-letter');
            const radio  = row.querySelector('input[type="radio"]');
            const text   = row.querySelector('input[type="text"]');

            badge.textContent = letter;
            radio.value = letter;
            text.name = `material_questions[0][options][${letter}]`;
            text.placeholder = `Pilihan jawaban ${letter}...`;
        });
    }

    // Default 4 Options for Checkpoint: A, B, C, D
    ['A', 'B', 'C', 'D'].forEach(letter => renderSingleOption(materialOptionsList, letter));

    addMaterialOptBtn.addEventListener('click', () => {
        const nextLetter = String.fromCharCode(65 + materialOptionsList.children.length);
        renderSingleOption(materialOptionsList, nextLetter);
    });

    // File preview
    document.getElementById('filesInput').addEventListener('change', function() {
        const preview = document.getElementById('filePreview');
        preview.innerHTML = '';
        [...this.files].forEach(file => {
            const el = document.createElement('div');
            el.className = 'border rounded-3 p-3 d-flex align-items-center gap-3 bg-white shadow-sm';
            el.innerHTML = `
                <i class="fa-solid fa-file-lines text-primary fs-5"></i>
                <div class="flex-grow-1">
                    <div class="fw-semibold text-main small">${file.name}</div>
                    <small class="text-muted">${(file.size/1024/1024).toFixed(2)} MB</small>
                </div>
                <button type="button" class="btn btn-light btn-sm text-danger rounded-circle" style="width:30px;height:30px;padding:0;">
                    <i class="fa-solid fa-xmark fa-xs"></i>
                </button>`;
            el.querySelector('button').onclick = () => el.remove();
            preview.appendChild(el);
        });
    });

    // Universal Dynamic MCQ Question Builder for Quiz
    const questionsContainer = document.getElementById('questionsContainer');
    const addQuestionBtn     = document.getElementById('addQuestionBtn');
    let quizQuestionIndexCount = 0;

    function renderGenericQuestionCard(container, qIndex, fieldPrefix, themeColor = '#8B5CF6') {
        const card = document.createElement('div');
        card.className = 'card border-0 shadow-sm rounded-4 question-card p-3 p-md-4 bg-white border-start border-4';
        card.style.borderColor = themeColor;
        card.dataset.qIndex = qIndex;

        card.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge rounded-pill px-3 py-1.5 fw-bold text-white fs-6 question-number-badge" style="background:${themeColor};">
                    Soal #${qIndex + 1}
                </span>
                <button type="button" class="btn btn-light btn-sm text-danger rounded-circle remove-q-btn" title="Hapus Soal Ini" style="width:34px;height:34px;padding:0;">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-main small">Pertanyaan Soal</label>
                <textarea name="${fieldPrefix}[${qIndex}][text]" rows="2" class="form-control rounded-4 border-0 bg-light"
                          placeholder="Tuliskan pertanyaan pilihan ganda..."></textarea>
            </div>

            <!-- Toggle & Upload Lampiran Gambar Soal (Opsional) -->
            <div class="mb-3 p-3 rounded-4 bg-light border border-dashed">
                <div class="form-check form-switch mb-0 d-flex align-items-center gap-2">
                    <input class="form-check-input q-image-toggle" type="checkbox" role="switch" id="toggleImg_${fieldPrefix}_${qIndex}" style="cursor:pointer; width:2.2em; height:1.2em;">
                    <label class="form-check-label fw-semibold text-main small user-select-none" for="toggleImg_${fieldPrefix}_${qIndex}" style="cursor:pointer;">
                        <i class="fa-regular fa-image me-1 text-primary"></i>Sertakan Gambar pada Soal Ini (Opsional)
                    </label>
                </div>

                <div class="q-image-upload-wrapper mt-2.5 d-none">
                    <div class="d-flex align-items-center gap-2">
                        <input type="file" name="${fieldPrefix}[${qIndex}][image]" class="form-control form-control-sm rounded-3 q-image-input" accept=".png, .jpg, .jpeg, image/png, image/jpeg">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-1">
                        <small class="text-muted" style="font-size:0.75rem;"><i class="fa-solid fa-circle-info me-1"></i>Hanya format <strong>PNG</strong> atau <strong>JPG/JPEG</strong> (Maks 5MB).</small>
                    </div>

                    <!-- Live Image Preview Box -->
                    <div class="q-image-preview-box mt-2 p-2 border rounded-3 bg-white d-none align-items-center justify-content-between gap-3 shadow-xs">
                        <div class="d-flex align-items-center gap-2.5 overflow-hidden">
                            <img src="" class="q-image-preview-thumb rounded-2 border" style="width: 50px; height: 50px; object-fit: cover;">
                            <div class="text-truncate">
                                <span class="d-block small fw-bold text-dark text-truncate q-image-name" style="max-width:240px;"></span>
                                <small class="text-muted q-image-size" style="font-size: 0.72rem;"></small>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-2.5 py-1 q-image-remove-btn" title="Hapus Gambar" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-trash me-1"></i>Hapus
                        </button>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-1">
                    <label class="form-label fw-semibold text-main m-0 small">Pilihan Jawaban & Bobot Nilai (%)</label>
                    <small class="text-muted" style="font-size:0.72rem;"><i class="fa-solid fa-circle-info me-1"></i>Pilih radio / dropdown 100% untuk kunci utama. Bisa atur 25%, 50%, atau 75% untuk jawaban sebagian benar.</small>
                </div>

                <div class="options-list d-flex flex-column gap-2"></div>

                <div class="mt-3">
                    <button type="button" class="btn btn-light border btn-sm rounded-pill fw-semibold add-option-btn px-3 py-1.5" style="color:${themeColor}; font-size:0.8rem;">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Pilihan Jawaban (+ E, F...)
                    </button>
                </div>
            </div>

            <!-- Penjelasan / Pembahasan Jawaban Guru (Opsional) -->
            <div class="mb-2 p-3 rounded-4 bg-light border border-dashed">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <button type="button" class="btn btn-sm btn-white border rounded-pill px-3 py-1.5 toggle-exp-btn text-muted fw-semibold" style="font-size:0.78rem; background:#fff;">
                        <i class="fa-regular fa-lightbulb me-1 text-warning"></i><span class="exp-btn-text">+ Beri Penjelasan Jawaban (Opsional)</span>
                    </button>
                    <small class="text-muted" style="font-size:0.72rem;"><i class="fa-solid fa-circle-info me-1"></i>Dapat dibaca oleh siswa jika izin pembahasan kuis dibuka.</small>
                </div>
                <div class="exp-wrapper mt-2.5 d-none">
                    <label class="form-label fw-semibold text-main small mb-1">Teks Pembahasan / Alasan Jawaban Benar (Opsional)</label>
                    <textarea name="${fieldPrefix}[${qIndex}][explanation]" rows="2" class="form-control rounded-3 border-0 bg-white"
                              placeholder="Tuliskan pembahasan atau alasan kenapa jawaban tersebut benar..."></textarea>
                </div>
            </div>
        `;

        // Explanation Toggle Logic
        const toggleExpBtn = card.querySelector('.toggle-exp-btn');
        const expWrapper   = card.querySelector('.exp-wrapper');
        const expBtnText   = card.querySelector('.exp-btn-text');
        const expTextarea  = card.querySelector('textarea[name$="[explanation]"]');

        toggleExpBtn.addEventListener('click', () => {
            const isHidden = expWrapper.classList.contains('d-none');
            if (isHidden) {
                expWrapper.classList.remove('d-none');
                expBtnText.textContent = '- Tutup Kolom Penjelasan';
                toggleExpBtn.classList.remove('text-muted');
                toggleExpBtn.classList.add('text-primary');
                if (expTextarea) expTextarea.focus();
            } else {
                expWrapper.classList.add('d-none');
                expBtnText.textContent = '+ Beri Penjelasan Jawaban (Opsional)';
                toggleExpBtn.classList.remove('text-primary');
                toggleExpBtn.classList.add('text-muted');
            }
        });

        // Image Toggle & Upload Logic
        const imgToggle       = card.querySelector('.q-image-toggle');
        const imgWrapper      = card.querySelector('.q-image-upload-wrapper');
        const imgInput        = card.querySelector('.q-image-input');
        const imgPreviewBox   = card.querySelector('.q-image-preview-box');
        const imgPreviewThumb = card.querySelector('.q-image-preview-thumb');
        const imgName         = card.querySelector('.q-image-name');
        const imgSize         = card.querySelector('.q-image-size');
        const imgRemoveBtn    = card.querySelector('.q-image-remove-btn');

        imgToggle.addEventListener('change', () => {
            if (imgToggle.checked) {
                imgWrapper.classList.remove('d-none');
            } else {
                imgWrapper.classList.add('d-none');
                imgInput.value = '';
                imgPreviewBox.classList.add('d-none');
                imgPreviewBox.classList.remove('d-flex');
                imgPreviewThumb.src = '';
            }
        });

        imgInput.addEventListener('change', () => {
            const file = imgInput.files && imgInput.files[0];
            if (!file) {
                imgPreviewBox.classList.add('d-none');
                imgPreviewBox.classList.remove('d-flex');
                return;
            }

            // Client-side strict validation: PNG or JPG/JPEG
            const allowedExts = ['png', 'jpg', 'jpeg'];
            const fileExt = file.name.split('.').pop().toLowerCase();
            if (!allowedExts.includes(fileExt)) {
                alert('⚠️ Format gambar tidak didukung!\nHanya file gambar berformat PNG atau JPG/JPEG yang diperbolehkan.');
                imgInput.value = '';
                imgPreviewBox.classList.add('d-none');
                imgPreviewBox.classList.remove('d-flex');
                return;
            }

            // Client-side size limit check: 5MB
            if (file.size > 5 * 1024 * 1024) {
                alert('⚠️ Ukuran gambar terlalu besar!\nMaksimal ukuran gambar adalah 5MB.');
                imgInput.value = '';
                imgPreviewBox.classList.add('d-none');
                imgPreviewBox.classList.remove('d-flex');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreviewThumb.src = e.target.result;
                imgName.textContent = file.name;
                imgSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
                imgPreviewBox.classList.remove('d-none');
                imgPreviewBox.classList.add('d-flex');
            };
            reader.readAsDataURL(file);
        });

        imgRemoveBtn.addEventListener('click', () => {
            imgInput.value = '';
            imgPreviewBox.classList.add('d-none');
            imgPreviewBox.classList.remove('d-flex');
            imgPreviewThumb.src = '';
        });

        const optionsList = card.querySelector('.options-list');
        const addOptBtn   = card.querySelector('.add-option-btn');
        const removeQBtn  = card.querySelector('.remove-q-btn');

        ['A', 'B', 'C', 'D'].forEach(letter => {
            renderGenericOptionRow(optionsList, qIndex, letter, fieldPrefix);
        });

        addOptBtn.addEventListener('click', () => {
            const currentCount = optionsList.children.length;
            const nextLetter = String.fromCharCode(65 + currentCount);
            renderGenericOptionRow(optionsList, qIndex, nextLetter, fieldPrefix);
        });

        removeQBtn.addEventListener('click', () => {
            if (container.children.length <= 1) {
                alert('Daftar harus memiliki minimal 1 soal.');
                return;
            }
            card.remove();
            updateGenericQuestionNumbers(container);
        });

        container.appendChild(card);
    }

    function renderGenericOptionRow(container, qIndex, letter, fieldPrefix) {
        const row = document.createElement('div');
        row.className = 'd-flex align-items-center gap-2 option-row w-100 mb-2 animate__animated animate__fadeIn';

        const isDefault100 = (letter === 'A');

        row.innerHTML = `
            <div class="form-check d-flex align-items-center m-0 flex-shrink-0" title="Tandai Kunci Utama (100%)">
                <input class="form-check-input me-1.5 option-radio-key" type="radio" name="${fieldPrefix}[${qIndex}][correct]" value="${letter}" ${isDefault100 ? 'checked' : ''} style="cursor:pointer; width:18px; height:18px;">
                <span class="badge bg-light text-dark border font-monospace fw-bold px-2 py-1 option-letter-badge" style="font-size:0.85rem;">${letter}</span>
            </div>
            <input type="text" name="${fieldPrefix}[${qIndex}][options][${letter}]" class="form-control rounded-4 border-0 bg-light flex-grow-1" style="min-width:0;"
                   placeholder="Tuliskan pilihan jawaban ${letter}...">
            <div class="flex-shrink-0" style="width: 105px;">
                <select name="${fieldPrefix}[${qIndex}][percentages][${letter}]" class="form-select form-select-sm rounded-3 fw-bold option-pct-select"
                        style="font-size:0.82rem; cursor:pointer;" title="Bobot Persentase Nilai Opsi ${letter}">
                    <option value="0" ${!isDefault100 ? 'selected' : ''}>0%</option>
                    <option value="25">25%</option>
                    <option value="50">50%</option>
                    <option value="75">75%</option>
                    <option value="100" ${isDefault100 ? 'selected' : ''}>100%</option>
                </select>
            </div>
            <button type="button" class="btn btn-light btn-sm text-danger rounded-circle remove-opt-btn flex-shrink-0" style="width:30px;height:30px;padding:0;" title="Hapus Pilihan">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;

        const pctSelect = row.querySelector('.option-pct-select');
        const radioBtn  = row.querySelector('.option-radio-key');

        function updateSelectColor(select) {
            const val = parseInt(select.value) || 0;
            select.classList.remove('bg-success-subtle', 'text-success', 'border', 'border-success', 'bg-primary-subtle', 'text-primary', 'border-primary', 'bg-warning-subtle', 'text-warning-emphasis', 'border-warning', 'bg-light', 'text-muted', 'border-0');
            if (val === 100) {
                select.classList.add('bg-success-subtle', 'text-success', 'border', 'border-success');
            } else if (val === 75 || val === 50) {
                select.classList.add('bg-primary-subtle', 'text-primary', 'border', 'border-primary');
            } else if (val === 25) {
                select.classList.add('bg-warning-subtle', 'text-warning-emphasis', 'border', 'border-warning');
            } else {
                select.classList.add('bg-light', 'text-muted', 'border-0');
            }
        }

        updateSelectColor(pctSelect);

        // Saat dropdown persentase berubah
        pctSelect.addEventListener('change', () => {
            updateSelectColor(pctSelect);
            if (pctSelect.value === '100') {
                radioBtn.checked = true;
                // Jika opsi ini diset 100%, ubah opsi lain yang tadinya 100% menjadi 0% agar kunci utama tetap terpusat
                container.querySelectorAll('.option-row').forEach(otherRow => {
                    if (otherRow !== row) {
                        const otherSelect = otherRow.querySelector('.option-pct-select');
                        if (otherSelect && otherSelect.value === '100') {
                            otherSelect.value = '0';
                            updateSelectColor(otherSelect);
                        }
                    }
                });
            } else if (radioBtn.checked && pctSelect.value !== '100') {
                // Jika radio sedang aktif di opsi ini tapi diturunkan dari 100%, cari opsi lain yang 100%
                const other100 = container.querySelector('.option-row:not(:focus-within) .option-pct-select option[value="100"]:checked');
                if (other100) {
                    const parentRadio = other100.closest('.option-row').querySelector('.option-radio-key');
                    if (parentRadio) parentRadio.checked = true;
                }
            }
        });

        // Saat radio button diklik
        radioBtn.addEventListener('change', () => {
            if (radioBtn.checked) {
                pctSelect.value = '100';
                updateSelectColor(pctSelect);

                // Set opsi lain yang tadinya 100% menjadi 0%
                container.querySelectorAll('.option-row').forEach(otherRow => {
                    if (otherRow !== row) {
                        const otherSelect = otherRow.querySelector('.option-pct-select');
                        if (otherSelect && otherSelect.value === '100') {
                            otherSelect.value = '0';
                            updateSelectColor(otherSelect);
                        }
                    }
                });
            }
        });

        const removeBtn = row.querySelector('.remove-opt-btn');
        removeBtn.addEventListener('click', () => {
            if (container.children.length <= 2) {
                alert('Pilihan ganda harus memiliki minimal 2 pilihan jawaban.');
                return;
            }
            row.remove();
            reorderGenericOptionBadges(container);
        });

        container.appendChild(row);
    }

    function reorderGenericOptionBadges(container) {
        [...container.children].forEach((row, idx) => {
            const letter = String.fromCharCode(65 + idx);
            const badge  = row.querySelector('.option-letter-badge');
            const radio  = row.querySelector('.option-radio-key') || row.querySelector('input[type="radio"]');
            const text   = row.querySelector('input[type="text"]');
            const select = row.querySelector('.option-pct-select');

            badge.textContent = letter;
            radio.value = letter;
            text.name = text.name.replace(/\[options\]\[[A-Z]\]/, `[options][${letter}]`);
            text.placeholder = `Tuliskan pilihan jawaban ${letter}...`;
            if (select) {
                select.name = select.name.replace(/\[percentages\]\[[A-Z]\]/, `[percentages][${letter}]`);
                select.title = `Bobot Persentase Nilai Opsi ${letter}`;
            }
        });
    }

    function updateGenericQuestionNumbers(container) {
        const total = container.children.length;
        [...container.children].forEach((card, idx) => {
            const badge = card.querySelector('.question-number-badge');
            if (badge) badge.textContent = `Soal #${idx + 1}`;
        });
        const countBadge = document.getElementById('questionCountBadge');
        if (countBadge) {
            countBadge.textContent = `${total} Soal`;
        }
    }

    // Initialize Quiz with 1 question card by default
    renderGenericQuestionCard(questionsContainer, 0, 'questions', '#8B5CF6');
    updateGenericQuestionNumbers(questionsContainer);

    function addNewQuizQuestion() {
        quizQuestionIndexCount++;
        renderGenericQuestionCard(questionsContainer, quizQuestionIndexCount, 'questions', '#8B5CF6');
        updateGenericQuestionNumbers(questionsContainer);

        // Smooth scroll to the newly added question card & focus
        const lastCard = questionsContainer.lastElementChild;
        if (lastCard) {
            lastCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            const textarea = lastCard.querySelector('textarea');
            if (textarea) setTimeout(() => textarea.focus(), 250);
        }
    }

    if (addQuestionBtn) {
        addQuestionBtn.addEventListener('click', addNewQuizQuestion);
    }
    const addQuestionTopBtn = document.getElementById('addQuestionTopBtn');
    if (addQuestionTopBtn) {
        addQuestionTopBtn.addEventListener('click', addNewQuizQuestion);
    }

    // ==========================================
    // QUESTION BANK (BANK SOAL) PICKER LOGIC
    // ==========================================
    const questionBankModal          = document.getElementById('questionBankModal');
    const bankSearchInput            = document.getElementById('bankSearchInput');
    const bankCategorySelect         = document.getElementById('bankCategorySelect');
    const bankLoadingSpinner         = document.getElementById('bankLoadingSpinner');
    const bankQuestionsList          = document.getElementById('bankQuestionsList');
    const bankSelectedCounter        = document.getElementById('bankSelectedCounter');
    const insertSelectedQuestionsBtn = document.getElementById('insertSelectedQuestionsBtn');

    let cachedBankQuestions = [];
    let selectedBankQuestionIds = new Set();

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, m => map[m]);
    }

    function getAlreadyAddedBankIds() {
        const addedIds = new Set();
        document.querySelectorAll('input[name="selected_question_ids[]"]').forEach(input => {
            if (input.value) addedIds.add(parseInt(input.value));
        });
        return addedIds;
    }

    async function loadBankQuestions() {
        if (!bankQuestionsList) return;
        bankLoadingSpinner.classList.remove('d-none');
        bankQuestionsList.innerHTML = '';
        insertSelectedQuestionsBtn.disabled = true;
        selectedBankQuestionIds.clear();
        updateBankSelectedCounter();

        const category = bankCategorySelect.value;
        const qSearch  = bankSearchInput.value.trim();

        const params = new URLSearchParams();
        if (category && category !== 'all') params.append('category', category);
        if (qSearch) params.append('q', qSearch);

        try {
            const res = await fetch(`{{ route('teacher.question-bank.api.list') }}?${params.toString()}`);
            const json = await res.json();
            if (json.status === 'success') {
                cachedBankQuestions = json.data;
                renderBankQuestions(cachedBankQuestions);
            } else {
                bankQuestionsList.innerHTML = `<div class="text-center py-4 text-danger"><i class="fa-solid fa-circle-exclamation me-1"></i>Gagal memuat soal.</div>`;
            }
        } catch (err) {
            bankQuestionsList.innerHTML = `<div class="text-center py-4 text-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i>Terjadi kesalahan saat memuat Bank Soal.</div>`;
        } finally {
            bankLoadingSpinner.classList.add('d-none');
        }
    }

    function renderBankQuestions(questions) {
        if (!questions || questions.length === 0) {
            bankQuestionsList.innerHTML = `
                <div class="text-center py-5 bg-white rounded-4 border">
                    <i class="fa-solid fa-boxes-stacked fs-2 text-muted mb-2 opacity-50"></i>
                    <h6 class="fw-bold text-main mb-1">Tidak Ada Soal Ditemukan</h6>
                    <p class="text-muted small mb-3">Tidak ada butir soal yang sesuai dengan pencarian atau kategori ini.</p>
                    <a href="{{ route('teacher.question-bank.create') }}" target="_blank" class="btn btn-sm rounded-pill btn-outline-primary px-3">
                        <i class="fa-solid fa-plus me-1"></i>Buat Soal Baru di Bank Soal
                    </a>
                </div>
            `;
            return;
        }

        const alreadyAdded = getAlreadyAddedBankIds();

        bankQuestionsList.innerHTML = '';
        questions.forEach(q => {
            const isAlreadyInQuiz = alreadyAdded.has(q.id);
            const isChecked = selectedBankQuestionIds.has(q.id);

            const card = document.createElement('div');
            card.className = `p-3 rounded-4 bg-white border transition-all ${isAlreadyInQuiz ? 'opacity-75 bg-light' : 'hover-shadow'}`;
            card.style.cursor = isAlreadyInQuiz ? 'default' : 'pointer';

            const opts = Array.isArray(q.options) ? q.options : [];
            const pcts = Array.isArray(q.option_percentages) ? q.option_percentages : [];

            let optionsHtml = '';
            opts.forEach((optText, optIdx) => {
                const letter = String.fromCharCode(65 + optIdx);
                const pct = pcts[optIdx] ?? (optIdx === q.correct_index ? 100 : 0);
                const isKey = (pct === 100);
                optionsHtml += `
                    <div class="col-sm-6">
                        <div class="p-1.5 px-2 rounded-2 border d-flex align-items-center gap-1.5 ${isKey ? 'bg-success-subtle border-success text-success fw-bold' : 'bg-light border-0 text-muted'} small" style="font-size:0.75rem;">
                            <span class="badge ${isKey ? 'bg-success text-white' : 'bg-secondary text-white'} rounded-circle" style="width:18px;height:18px;line-height:14px;padding:0;text-align:center;">${letter}</span>
                            <span class="text-truncate">${escapeHtml(optText)}</span>
                            ${isKey ? '<i class="fa-solid fa-check ms-auto"></i>' : ''}
                        </div>
                    </div>
                `;
            });

            card.innerHTML = `
                <div class="d-flex align-items-start gap-3">
                    <div class="pt-1">
                        <input type="checkbox" class="form-check-input bank-item-check" data-id="${q.id}"
                               ${isChecked ? 'checked' : ''} ${isAlreadyInQuiz ? 'disabled checked' : ''}
                               style="width: 1.3em; height: 1.3em; cursor:${isAlreadyInQuiz ? 'not-allowed' : 'pointer'};">
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between mb-1 gap-2 flex-wrap">
                            <span class="badge rounded-pill px-2.5 py-1 text-white fw-bold" style="background:#8B5CF6; font-size:0.7rem;">
                                ${escapeHtml(q.category ? q.category.toUpperCase() : 'UMUM')}
                            </span>
                            ${isAlreadyInQuiz ? '<span class="badge bg-secondary text-white rounded-pill px-2 py-0.5" style="font-size:0.68rem;"><i class="fa-solid fa-check me-1"></i>Sudah Masuk Kuis</span>' : ''}
                        </div>
                        <p class="fw-bold text-main mb-2 small" style="line-height: 1.4;">${escapeHtml(q.question)}</p>
                        ${q.image_path ? `<div class="mb-2"><img src="${q.image_path}" class="rounded-2 border" style="max-height:80px; object-fit:contain;"></div>` : ''}
                        <div class="row g-1 mb-1">
                            ${optionsHtml}
                        </div>
                        ${q.explanation ? `
                            <div class="mt-2 p-1.5 px-2 rounded-2 bg-light border text-muted small" style="font-size: 0.72rem;">
                                <i class="fa-regular fa-lightbulb text-warning me-1"></i><strong>Pembahasan:</strong> ${escapeHtml(q.explanation)}
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;

            if (!isAlreadyInQuiz) {
                card.addEventListener('click', (e) => {
                    if (e.target.tagName === 'INPUT' || e.target.tagName === 'LABEL') return;
                    const chk = card.querySelector('.bank-item-check');
                    chk.checked = !chk.checked;
                    chk.dispatchEvent(new Event('change'));
                });
            }

            const checkbox = card.querySelector('.bank-item-check');
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    selectedBankQuestionIds.add(q.id);
                } else {
                    selectedBankQuestionIds.delete(q.id);
                }
                updateBankSelectedCounter();
            });

            bankQuestionsList.appendChild(card);
        });
    }

    function updateBankSelectedCounter() {
        const count = selectedBankQuestionIds.size;
        bankSelectedCounter.textContent = `${count} soal dipilih`;
        insertSelectedQuestionsBtn.disabled = (count === 0);
    }

    if (questionBankModal) {
        questionBankModal.addEventListener('show.bs.modal', loadBankQuestions);
    }

    let searchTimer;
    if (bankSearchInput) {
        bankSearchInput.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(loadBankQuestions, 350);
        });
    }

    if (bankCategorySelect) {
        bankCategorySelect.addEventListener('change', loadBankQuestions);
    }

    // Insert selected questions to the quiz
    insertSelectedQuestionsBtn.addEventListener('click', () => {
        if (selectedBankQuestionIds.size === 0) return;

        // Check if there is an untouched initial empty card
        if (questionsContainer.children.length === 1) {
            const firstCard = questionsContainer.firstElementChild;
            const textarea = firstCard.querySelector('textarea');
            const hiddenBank = firstCard.querySelector('input[name="selected_question_ids[]"]');
            if (!hiddenBank && textarea && textarea.value.trim() === '') {
                firstCard.remove();
            }
        }

        selectedBankQuestionIds.forEach(id => {
            const q = cachedBankQuestions.find(item => item.id === id);
            if (!q) return;

            renderBankQuestionCard(q);
        });

        updateGenericQuestionNumbers(questionsContainer);

        // Hide modal
        const modalInstance = bootstrap.Modal.getInstance(questionBankModal);
        if (modalInstance) {
            modalInstance.hide();
        }
    });

    function renderBankQuestionCard(q) {
        const card = document.createElement('div');
        card.className = 'card border-0 shadow-sm rounded-4 question-card p-3 p-md-4 bg-white border-start border-4 bank-question-item';
        card.style.borderColor = '#8B5CF6';
        card.dataset.bankId = q.id;

        const opts = Array.isArray(q.options) ? q.options : [];
        const pcts = Array.isArray(q.option_percentages) ? q.option_percentages : [];

        let optionsHtml = '';
        opts.forEach((optText, optIdx) => {
            const letter = String.fromCharCode(65 + optIdx);
            const pct = pcts[optIdx] ?? (optIdx === q.correct_index ? 100 : 0);
            const isKey = (pct === 100);
            const isPartial = (pct > 0 && pct < 100);
            optionsHtml += `
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2 p-2 px-3 rounded-3 border ${isKey ? 'border-success bg-success-subtle text-success fw-bold' : (isPartial ? 'border-primary-subtle bg-primary-subtle' : 'bg-light border-0 text-main')}">
                        <span class="badge ${isKey ? 'bg-success text-white' : 'bg-secondary text-white'} rounded-circle flex-shrink-0" style="width:24px;height:24px;line-height:16px;text-align:center;font-size:0.75rem;">
                            ${letter}
                        </span>
                        <span class="flex-grow-1 small">${escapeHtml(optText)}</span>
                        ${isKey ? '<span class="badge bg-success text-white rounded-pill px-2 py-0.5" style="font-size: 0.68rem;"><i class="fa-solid fa-check me-1"></i>Kunci (100%)</span>' : (isPartial ? `<span class="badge bg-primary text-white rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">${pct}%</span>` : '')}
                    </div>
                </div>
            `;
        });

        card.innerHTML = `
            <input type="hidden" name="selected_question_ids[]" value="${q.id}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="badge rounded-pill px-3 py-1.5 fw-bold text-white fs-6 question-number-badge" style="background:#8B5CF6;">
                        Soal #
                    </span>
                    <span class="badge rounded-pill px-2.5 py-1 text-white fw-semibold" style="background: #7C3AED; font-size: 0.72rem;">
                        <i class="fa-solid fa-boxes-stacked me-1"></i>Bank Soal: ${(q.category || 'Umum').toUpperCase()}
                    </span>
                </div>
                <button type="button" class="btn btn-light btn-sm text-danger rounded-circle remove-q-btn" title="Hapus Soal Ini dari Kuis" style="width:34px;height:34px;padding:0;">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>

            <div class="mb-3">
                <p class="fw-bold text-main mb-2 fs-6" style="line-height:1.5;">${escapeHtml(q.question)}</p>
                ${q.image_path ? `<div class="mb-2"><img src="${q.image_path}" class="rounded-3 border" style="max-height:140px; object-fit:contain;"></div>` : ''}
            </div>

            <div class="row g-2 mb-3">
                ${optionsHtml}
            </div>

            ${q.explanation ? `
                <div class="alert alert-light border border-warning-subtle rounded-3 p-2.5 px-3 mb-0 d-flex align-items-start gap-2" style="background:#FFFBEB;">
                    <i class="fa-regular fa-lightbulb text-warning fs-6 mt-0.5 flex-shrink-0"></i>
                    <div class="small">
                        <strong class="text-warning-emphasis">Penjelasan Kunci Jawaban:</strong>
                        <div class="text-muted mt-0.5" style="font-size: 0.82rem;">${escapeHtml(q.explanation)}</div>
                    </div>
                </div>
            ` : ''}
        `;

        const removeBtn = card.querySelector('.remove-q-btn');
        removeBtn.addEventListener('click', () => {
            card.remove();
            updateGenericQuestionNumbers(questionsContainer);
        });

        questionsContainer.appendChild(card);
    }

    // Client-side Form Submit Validation (Reliable submission)
    const postForm      = document.getElementById('postForm');
    const submitPostBtn = document.getElementById('submitPostBtn');

    postForm.addEventListener('submit', function(e) {
        const currentType = typeInput.value;

        if (currentType === 'material') {
            // Validate Checkpoint question if enabled
            if (hasPracticeInput && hasPracticeInput.value === '1') {
                const qText = document.getElementById('matQuestionTextInput');
                if (!qText || !qText.value.trim()) {
                    e.preventDefault();
                    alert('⚠️ Silakan tuliskan pertanyaan soal checkpoint terlebih dahulu.');
                    qText?.focus();
                    return false;
                }
            }
        }

        if (currentType === 'quiz') {
            const hasBankQuestions = document.querySelectorAll('input[name="selected_question_ids[]"]').length > 0;
            const manualTextareas = document.querySelectorAll('textarea[name^="questions["]');
            let hasManualQuestion = false;
            manualTextareas.forEach(t => {
                if (t.name.endsWith('[text]') && t.value.trim() !== '') {
                    hasManualQuestion = true;
                }
            });

            if (!hasBankQuestions && !hasManualQuestion) {
                e.preventDefault();
                alert('⚠️ Silakan pilih butir soal dari Bank Soal atau tuliskan minimal 1 pertanyaan soal kuis terlebih dahulu.');
                if (submitPostBtn) {
                    submitPostBtn.disabled = false;
                    submitPostBtn.innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i>Posting Sekarang';
                }
                return false;
            }
        }

        // Visual feedback
        if (submitPostBtn) {
            submitPostBtn.disabled = true;
            submitPostBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Menyimpan Postingan...';
        }
    });
</script>
@endpush



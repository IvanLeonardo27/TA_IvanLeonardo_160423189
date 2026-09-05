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
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small">Tenggat Waktu Kuis</label>
                                <input type="datetime-local" name="quiz_due_date" id="quizDueDate" class="form-control rounded-4 border-0 bg-light" value="{{ old('quiz_due_date', old('due_date')) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small">Durasi (Menit)</label>
                                <input type="number" name="duration_minutes" class="form-control rounded-4 border-0 bg-light"
                                       placeholder="30" min="1" max="300" value="{{ old('duration_minutes', 30) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small">Visibilitas Nilai</label>
                                <select name="show_score" class="form-select rounded-4 border-0 bg-light fw-semibold">
                                    <option value="1" {{ old('show_score', '1') == '1' ? 'selected' : '' }}>👁️ Tampilkan Nilai</option>
                                    <option value="0" {{ old('show_score') == '0' ? 'selected' : '' }}>🙈 Sembunyikan Nilai</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small">Batas Pengisian</label>
                                <select name="max_attempts" class="form-select rounded-4 border-0 bg-light fw-semibold">
                                    <option value="1" {{ old('max_attempts', '1') == '1' ? 'selected' : '' }}>🔒 Hanya 1 Kali</option>
                                    <option value="0" {{ old('max_attempts') == '0' ? 'selected' : '' }}>🔄 Bebas (Berkali-kali)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Instruksi & Petunjuk Kuis</label>
                                <textarea name="instructions" rows="2" class="form-control rounded-4 border-0 bg-light"
                                          placeholder="Tuliskan petunjuk pengerjaan kuis untuk siswa...">{{ old('instructions') }}</textarea>
                            </div>
                        </div>

                        {{-- DYNAMIC QUESTION BUILDER (PILIHAN GANDA) --}}
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="fw-bold text-main m-0 small"><i class="fa-solid fa-list-ol text-purple me-2"></i>Daftar Soal Pilihan Ganda</h6>
                                <span class="badge bg-light text-secondary border rounded-pill px-2.5 py-1 font-monospace" id="questionCountBadge" style="font-size:0.75rem;">1 Soal</span>
                            </div>
                            <button type="button" id="addQuestionTopBtn" class="btn btn-sm rounded-pill text-white fw-bold px-3 btn-bouncy" style="background:#8B5CF6; font-size:0.8rem;">
                                <i class="fa-solid fa-plus me-1"></i> Tambah Soal
                            </button>
                        </div>

                        <div id="questionsContainer" class="d-flex flex-column gap-4">
                            <!-- Question Card Template will be injected via JS -->
                        </div>

                        {{-- Tombol Tambah Soal Baru di Akhir Setiap Soal --}}
                        <div class="mt-4 text-center" id="addQuestionEndWrapper">
                            <div class="p-3.5 rounded-4 border-2 border-dashed bg-white shadow-xs d-flex flex-column align-items-center justify-content-center"
                                 style="border-color: #C4B5FD !important; border-style: dashed !important; background: linear-gradient(135deg, rgba(139,92,246,0.03) 0%, rgba(243,232,255,0.25) 100%) !important;">
                                <button type="button" id="addQuestionBtn" class="btn rounded-pill text-white fw-bold px-4 py-2.5 btn-bouncy shadow-sm d-inline-flex align-items-center gap-2"
                                        style="background: #8B5CF6; font-size: 0.92rem;">
                                    <i class="fa-solid fa-circle-plus fs-5"></i>
                                    <span>Tambah Soal Baru</span>
                                </button>
                                <span class="text-muted small mt-2" style="font-size: 0.76rem;">
                                    <i class="fa-solid fa-arrow-down text-purple me-1"></i>Soal berikutnya akan ditambahkan di sini, dan tombol ini otomatis selalu berada di akhir soal.
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
        standardAttachmentSection.classList.toggle('d-none', type === 'material' || type === 'url');

        // Toggle disabled attribute so hidden inputs are not submitted
        assignFields.querySelectorAll('input, select, textarea').forEach(el => el.disabled = (type !== 'assignment'));
        quizFields.querySelectorAll('input, select, textarea').forEach(el => el.disabled = (type !== 'quiz'));
        materialSection.querySelectorAll('input, select, textarea').forEach(el => el.disabled = (type !== 'material'));

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

            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-1">
                    <label class="form-label fw-semibold text-main m-0 small">Pilihan Jawaban & Kunci</label>
                    <small class="text-muted" style="font-size:0.72rem;"><i class="fa-solid fa-circle-info me-1"></i>Pilih radio button untuk kunci yang benar</small>
                </div>

                <div class="options-list d-flex flex-column gap-2"></div>

                <div class="mt-3">
                    <button type="button" class="btn btn-light border btn-sm rounded-pill fw-semibold add-option-btn px-3 py-1.5" style="color:${themeColor}; font-size:0.8rem;">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Pilihan Jawaban (+ E, F...)
                    </button>
                </div>
            </div>
        `;

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

        row.innerHTML = `
            <div class="form-check d-flex align-items-center m-0 flex-shrink-0">
                <input class="form-check-input me-1.5" type="radio" name="${fieldPrefix}[${qIndex}][correct]" value="${letter}" ${letter === 'A' ? 'checked' : ''} style="cursor:pointer; width:18px; height:18px;">
                <span class="badge bg-light text-dark border font-monospace fw-bold px-2 py-1 option-letter-badge" style="font-size:0.85rem;">${letter}</span>
            </div>
            <input type="text" name="${fieldPrefix}[${qIndex}][options][${letter}]" class="form-control rounded-4 border-0 bg-light flex-grow-1" style="min-width:0;"
                   placeholder="Tuliskan pilihan jawaban ${letter}...">
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
            reorderGenericOptionBadges(container);
        });

        container.appendChild(row);
    }

    function reorderGenericOptionBadges(container) {
        [...container.children].forEach((row, idx) => {
            const letter = String.fromCharCode(65 + idx);
            const badge  = row.querySelector('.option-letter-badge');
            const radio  = row.querySelector('input[type="radio"]');
            const text   = row.querySelector('input[type="text"]');

            badge.textContent = letter;
            radio.value = letter;
            text.placeholder = `Tuliskan pilihan jawaban ${letter}...`;
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

    // Client-side Form Submit Validation (Reliable submission)
    const postForm      = document.getElementById('postForm');
    const submitPostBtn = document.getElementById('submitPostBtn');

    postForm.addEventListener('submit', function(e) {
        const currentType = typeInput.value;

        if (currentType === 'material') {
            // Validate Checkpoint question if enabled
            if (hasPracticeInput.value === '1') {
                const qText = document.getElementById('matQuestionTextInput');
                if (!qText || !qText.value.trim()) {
                    e.preventDefault();
                    alert('⚠️ Silakan tuliskan pertanyaan soal checkpoint terlebih dahulu.');
                    qText?.focus();
                    return false;
                }
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



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

        <div class="card border-0 shadow-sm" style="border-radius:24px;">
            <div class="card-body p-5">
                <h4 class="fw-bold text-main mb-1">Buat Postingan Baru</h4>
                <p class="text-muted mb-5">Bagikan pengumuman, materi, atau tugas kepada siswa.</p>

                <form action="{{ route('teacher.classroom.post.store', $classroom) }}" method="POST" enctype="multipart/form-data" id="postForm">
                    @csrf

                    {{-- Pilih Tipe Post --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Jenis Postingan <span class="text-danger">*</span></label>
                        <input type="hidden" name="type" id="typeInput" value="announcement">
                        <div class="d-flex gap-3 flex-wrap">
                            @foreach([
                                ['announcement','Pengumuman','bullhorn','#10B981'],
                                ['material','Materi Belajar','book-open','#3B82F6'],
                                ['assignment','Tugas','clipboard-list','#EF4444'],
                                ['quiz','Evaluasi / Quiz','pen-to-square','#8B5CF6'],
                            ] as [$val, $label, $icon, $color])
                            <button type="button" class="type-btn btn border-2 rounded-4 px-4 py-3 d-flex flex-column align-items-center gap-1 {{ $val === 'announcement' ? 'btn-primary border-primary text-white' : 'btn-light' }}"
                                    data-type="{{ $val }}" data-color="{{ $color }}" style="min-width:130px; transition:.2s;">
                                <i class="fa-solid fa-{{ $icon }} fs-4"></i>
                                <span class="fw-semibold small">{{ $label }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" name="title" class="form-control rounded-4 border-0 bg-light form-control-lg"
                               placeholder="Judul postingan..." value="{{ old('title') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Isi / Deskripsi</label>
                        <textarea name="body" rows="5" class="form-control rounded-4 border-0 bg-light"
                                  placeholder="Tuliskan isi pengumuman, deskripsi materi, instruksi tugas, atau petunjuk kuis...">{{ old('body') }}</textarea>
                    </div>

                    {{-- Field Khusus Tugas --}}
                    <div id="assignmentFields" class="d-none">
                        <hr class="my-4">
                        <h6 class="fw-bold text-danger mb-3"><i class="fa-solid fa-clipboard-list me-2"></i>Detail Tugas</h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tenggat Waktu</label>
                                <input type="datetime-local" name="due_date" class="form-control rounded-4 border-0 bg-light" value="{{ old('due_date') }}">
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
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tenggat Waktu Kuis</label>
                                <input type="datetime-local" name="due_date" class="form-control rounded-4 border-0 bg-light" value="{{ old('due_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Durasi (Menit)</label>
                                <input type="number" name="duration_minutes" class="form-control rounded-4 border-0 bg-light"
                                       placeholder="30" min="1" max="300" value="{{ old('duration_minutes', 30) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Visibilitas Nilai Siswa</label>
                                <select name="show_score" class="form-select rounded-4 border-0 bg-light fw-semibold">
                                    <option value="1" {{ old('show_score', '1') == '1' ? 'selected' : '' }}>👁️ Tampilkan Nilai</option>
                                    <option value="0" {{ old('show_score') == '0' ? 'selected' : '' }}>🙈 Sembunyikan Nilai</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Batas Pengisian Siswa</label>
                                <select name="max_attempts" class="form-select rounded-4 border-0 bg-light fw-semibold">
                                    <option value="1" {{ old('max_attempts', '1') == '1' ? 'selected' : '' }}>🔒 Hanya 1 Kali Pengerjaan</option>
                                    <option value="0" {{ old('max_attempts') == '0' ? 'selected' : '' }}>🔄 Bebas Pengerjaan (Berkali-kali)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Instruksi & Petunjuk Kuis</label>
                                <textarea name="instructions" rows="2" class="form-control rounded-4 border-0 bg-light"
                                          placeholder="Tuliskan petunjuk pengerjaan kuis untuk siswa...">{{ old('instructions') }}</textarea>
                            </div>
                        </div>

                        {{-- DYNAMIC QUESTION BUILDER (PILIHAN GANDA) --}}
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                            <h6 class="fw-bold text-main m-0"><i class="fa-solid fa-list-ol text-purple me-2"></i>Daftar Soal Pilihan Ganda</h6>
                            <button type="button" id="addQuestionBtn" class="btn btn-sm rounded-pill text-white fw-bold px-3 btn-bouncy" style="background:#8B5CF6;">
                                <i class="fa-solid fa-plus me-1"></i> Tambah Soal Baru
                            </button>
                        </div>

                        <div id="questionsContainer" class="d-flex flex-column gap-4">
                            <!-- Question Card Template will be injected via JS -->
                        </div>
                    </div>

                    {{-- Upload Lampiran --}}
                    <div class="mb-5 mt-4">
                        <label class="form-label fw-semibold">Lampiran File (Opsional)</label>
                        <div id="dropZone" class="border-2 border-dashed rounded-4 p-5 text-center position-relative"
                             style="border-color:#CBD5E1; background:#F8FAFC; cursor:pointer; transition:.2s;">
                            <input type="file" name="files[]" id="filesInput" multiple class="position-absolute w-100 h-100 opacity-0"
                                   style="top:0;left:0;cursor:pointer;">
                            <i class="fa-solid fa-cloud-arrow-up text-primary mb-3" style="font-size:2.5rem;"></i>
                            <h6 class="fw-bold text-main">Seret & Lepas File Di Sini</h6>
                            <p class="text-muted small mb-0">PDF, DOCX, JPG, MP4 – Maksimum 20 MB per file</p>
                        </div>
                        <div id="filePreview" class="mt-3 d-flex flex-column gap-2"></div>
                    </div>

                    <div class="d-flex gap-3">
                        <a href="{{ route('teacher.classroom.show', $classroom) }}" class="btn btn-light rounded-pill px-4 py-2">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 btn-bouncy fw-semibold shadow">
                            <i class="fa-solid fa-paper-plane me-2"></i>Posting Sekarang
                        </button>
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
</style>
@endpush

@push('scripts')
<script>
    const typeButtons  = document.querySelectorAll('.type-btn');
    const typeInput    = document.getElementById('typeInput');
    const assignFields = document.getElementById('assignmentFields');
    const quizFields   = document.getElementById('quizFields');

    typeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const type  = btn.dataset.type;
            const color = btn.dataset.color;

            typeInput.value = type;
            assignFields.classList.toggle('d-none', type !== 'assignment');
            quizFields.classList.toggle('d-none', type !== 'quiz');

            typeButtons.forEach(b => {
                b.className = b.className.replace(/btn-primary|border-primary|text-white/g, '').trim();
                b.classList.add('btn-light');
            });
            btn.classList.remove('btn-light');
            btn.classList.add('btn-primary', 'border-primary', 'text-white');
        });
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

    // Dynamic MCQ Question Builder Engine
    const questionsContainer = document.getElementById('questionsContainer');
    const addQuestionBtn     = document.getElementById('addQuestionBtn');
    let questionIndexCount   = 0;

    function renderQuestionCard(qIndex) {
        const card = document.createElement('div');
        card.className = 'card border-0 shadow-sm rounded-4 question-card p-4 bg-white border-start border-4 border-purple';
        card.style.borderColor = '#8B5CF6';
        card.dataset.qIndex = qIndex;

        card.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge rounded-pill px-3 py-2 fw-bold text-white fs-6 question-number-badge" style="background:#8B5CF6;">
                    Soal #${qIndex + 1}
                </span>
                <button type="button" class="btn btn-light btn-sm text-danger rounded-circle remove-q-btn" title="Hapus Soal Ini" style="width:36px;height:36px;padding:0;">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-main">Pertanyaan Soal</label>
                <textarea name="questions[${qIndex}][text]" rows="2" class="form-control rounded-4 border-0 bg-light"
                          placeholder="Tuliskan pertanyaan pilihan ganda..." required></textarea>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <label class="form-label fw-semibold text-main m-0">Pilihan Jawaban & Kunci</label>
                    <small class="text-muted"><i class="fa-solid fa-circle-info me-1"></i>Pilih radio button untuk menentukan kunci jawaban yang benar</small>
                </div>

                <div class="options-list d-flex flex-column gap-2"></div>

                <div class="mt-3">
                    <button type="button" class="btn btn-light border btn-sm rounded-pill fw-semibold text-purple add-option-btn" style="color:#8B5CF6;">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Pilihan Jawaban (+ E, F...)
                    </button>
                </div>
            </div>
        `;

        const optionsList = card.querySelector('.options-list');
        const addOptBtn   = card.querySelector('.add-option-btn');
        const removeQBtn  = card.querySelector('.remove-q-btn');

        // Render default 4 options: A, B, C, D
        ['A', 'B', 'C', 'D'].forEach(letter => {
            renderOptionRow(optionsList, qIndex, letter);
        });

        // Add option click handler (+ E, + F, etc.)
        addOptBtn.addEventListener('click', () => {
            const currentCount = optionsList.children.length;
            const nextLetter = String.fromCharCode(65 + currentCount); // 65 = 'A'
            renderOptionRow(optionsList, qIndex, nextLetter);
        });

        // Remove question handler
        removeQBtn.addEventListener('click', () => {
            if (questionsContainer.children.length <= 1) {
                alert('Kuis harus memiliki minimal 1 soal.');
                return;
            }
            card.remove();
            updateQuestionNumbers();
        });

        questionsContainer.appendChild(card);
    }

    function renderOptionRow(container, qIndex, letter) {
        const row = document.createElement('div');
        row.className = 'd-flex align-items-center gap-2 option-row animate__animated animate__fadeIn';

        row.innerHTML = `
            <div class="form-check d-flex align-items-center m-0">
                <input class="form-check-input me-2" type="radio" name="questions[${qIndex}][correct]" value="${letter}" ${letter === 'A' ? 'checked' : ''} style="cursor:pointer; width:20px; height:20px;">
                <span class="badge bg-light text-dark border font-monospace fw-bold fs-6 px-3 py-2 option-letter-badge" style="min-width:42px;">${letter}</span>
            </div>
            <input type="text" name="questions[${qIndex}][options][${letter}]" class="form-control rounded-4 border-0 bg-light"
                   placeholder="Tuliskan pilihan jawaban ${letter}..." required>
            <button type="button" class="btn btn-light btn-sm text-danger rounded-circle remove-opt-btn" style="width:32px;height:32px;padding:0;" title="Hapus Pilihan">
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
            reorderOptionBadges(container);
        });

        container.appendChild(row);
    }

    function reorderOptionBadges(container) {
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

    function updateQuestionNumbers() {
        [...questionsContainer.children].forEach((card, idx) => {
            const badge = card.querySelector('.question-number-badge');
            badge.textContent = `Soal #${idx + 1}`;
        });
    }

    // Initialize with 1 Question Card by default
    renderQuestionCard(0);

    addQuestionBtn.addEventListener('click', () => {
        questionIndexCount++;
        renderQuestionCard(questionIndexCount);
        updateQuestionNumbers();
    });
</script>
@endpush

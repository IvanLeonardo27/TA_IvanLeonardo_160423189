@extends('layouts.app')

@section('title', 'Kumpulkan Tugas')

@section('content')
<div class="row justify-content-center animate__animated animate__fadeInUp">
    <div class="col-xl-8 col-lg-10">
        <div class="mb-4">
            <a href="{{ route('student.classroom.show', $classroom) }}" class="text-muted text-decoration-none small">
                <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke {{ $classroom->name }}
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Detail Tugas --}}
        <div class="card border-0 shadow-sm mb-4 overflow-hidden" style="border-radius:20px;">
            <div class="p-1" style="background:linear-gradient(135deg,#EF4444,#F97316);"></div>
            <div class="card-body p-5">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:56px;height:56px;flex-shrink:0;">
                        <i class="fa-solid fa-clipboard-list fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold text-main mb-1">{{ $assignment->post->title ?? 'Tugas' }}</h3>
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <span class="text-muted small">
                                <i class="fa-regular fa-clock me-1"></i>
                                Tenggat:
                                <strong class="{{ $assignment->is_overdue ? 'text-danger' : 'text-success' }}">
                                    {{ $assignment->due_date ? $assignment->due_date->format('d M Y, H:i') : 'Tidak ada' }}
                                </strong>
                            </span>
                            <span class="text-muted small">
                                <i class="fa-solid fa-star me-1 text-warning"></i>
                                Nilai Maks: <strong>{{ $assignment->max_score }}</strong>
                            </span>
                        </div>
                    </div>
                </div>

                @if($assignment->instructions)
                <div class="bg-light rounded-4 p-4">
                    <h6 class="fw-bold text-main mb-2"><i class="fa-solid fa-circle-info me-2 text-primary"></i>Instruksi</h6>
                    <p class="text-muted mb-0" style="white-space:pre-line;">{{ $assignment->instructions }}</p>
                </div>
                @endif

                @if($assignment->post->body)
                <p class="text-muted mt-3 mb-0" style="white-space:pre-line;">{{ $assignment->post->body }}</p>
                @endif
            </div>
        </div>

        {{-- Status Pengumpulan --}}
        @if($submission)
        <div class="card border-0 shadow-sm mb-4" style="border-radius:20px; border-left:5px solid {{ $submission->status === 'graded' ? '#22C55E' : '#3B82F6' }} !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <h6 class="fw-bold text-main mb-1">Tugas Sudah Dikumpulkan</h6>
                        <small class="text-muted">{{ $submission->submitted_at->format('d M Y, H:i') }}</small>
                        <div class="mt-2 d-flex align-items-center gap-2 p-2 bg-light rounded-3">
                            <i class="fa-solid fa-file-lines text-primary"></i>
                            <span class="fw-semibold small text-main">{{ $submission->original_name }}</span>
                            <a href="{{ asset('storage/'.$submission->file_path) }}" target="_blank"
                               class="btn btn-sm btn-outline-primary rounded-pill ms-2 px-3">
                                <i class="fa-solid fa-download me-1"></i>Unduh
                            </a>
                        </div>
                        @if($submission->note)
                        <p class="text-muted small mt-2 mb-0"><em>"{{ $submission->note }}"</em></p>
                        @endif
                    </div>
                    <div class="text-end">
                        {!! $submission->status_badge !!}
                        @if($submission->score !== null)
                        <div class="mt-2">
                            <span class="fw-bold text-success" style="font-size:2rem;">{{ $submission->score }}</span>
                            <small class="text-muted"> / {{ $assignment->max_score }}</small>
                        </div>
                        @endif
                    </div>
                </div>
                @if($submission->teacher_feedback)
                <div class="mt-3 p-3 bg-success bg-opacity-10 rounded-3">
                    <small class="fw-bold text-success d-block mb-1"><i class="fa-solid fa-comment me-1"></i>Catatan Pengajar</small>
                    <p class="text-muted small mb-0">{{ $submission->teacher_feedback }}</p>
                </div>
                @endif

                @if($submission->status !== 'graded')
                <div class="mt-3 pt-3 border-top">
                    <p class="text-muted small mb-2">Ingin mengganti file? Upload ulang di bawah ini.</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Form Upload Tugas --}}
        @if(!$submission || $submission->status !== 'graded')
        <div class="card border-0 shadow-sm" style="border-radius:20px;">
            <div class="card-body p-5">
                <h5 class="fw-bold text-main mb-1">
                    {{ $submission ? 'Ganti File Pengumpulan' : 'Kumpulkan Tugas' }}
                </h5>
                <p class="text-muted mb-4 small">Format yang diterima: PDF, DOCX, JPG, PNG – Maks. 20MB</p>

                <form action="{{ route('student.classroom.submission.store', $assignment) }}" method="POST" enctype="multipart/form-data" id="submitForm">
                    @csrf

                    {{-- Drag & Drop Zone --}}
                    <div id="dropZone" class="border-2 border-dashed rounded-4 p-5 text-center position-relative mb-4"
                         style="border-color:#CBD5E1; background:#F8FAFC; cursor:pointer; transition:.25s; min-height:200px;">
                        <input type="file" name="file" id="fileInput" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               class="position-absolute w-100 h-100 opacity-0" style="top:0;left:0;cursor:pointer;">

                        <div id="dropDefault">
                            <div class="mb-3 animate-float d-inline-block">
                                <i class="fa-solid fa-cloud-arrow-up text-primary" style="font-size:3rem;"></i>
                            </div>
                            <h5 class="fw-bold text-main">Seret & Lepas File Anda Di Sini</h5>
                            <p class="text-muted mb-2">atau</p>
                            <span class="btn btn-outline-primary rounded-pill px-4 btn-bouncy">Pilih File dari Komputer</span>
                        </div>

                        <div id="dropSelected" class="d-none">
                            <i class="fa-solid fa-circle-check text-success mb-2" style="font-size:3rem;"></i>
                            <h5 class="fw-bold text-main" id="selectedFileName">–</h5>
                            <small class="text-muted" id="selectedFileSize">–</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Catatan (Opsional)</label>
                        <textarea name="note" rows="2" class="form-control rounded-4 border-0 bg-light"
                                  placeholder="Tuliskan catatan untuk pengajar...">{{ old('note') }}</textarea>
                    </div>

                    <div class="d-flex gap-3">
                        @if($submission)
                        <form action="{{ route('student.classroom.submission.destroy', $assignment) }}" method="POST"
                              onsubmit="return confirm('Tarik pengumpulan tugas ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                                <i class="fa-solid fa-rotate-left me-2"></i>Tarik Kembali
                            </button>
                        </form>
                        @endif
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold btn-bouncy shadow flex-grow-1">
                            <i class="fa-solid fa-paper-plane me-2"></i>
                            {{ $submission ? 'Perbarui Pengumpulan' : 'Kumpulkan Tugas' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.border-dashed { border-style: dashed !important; }
#dropZone:hover, #dropZone.dragover { border-color: var(--bs-primary) !important; background:#EFF6FF !important; }
</style>
@endpush

@push('scripts')
<script>
    const fileInput   = document.getElementById('fileInput');
    const dropZone    = document.getElementById('dropZone');
    const dropDefault = document.getElementById('dropDefault');
    const dropSelected = document.getElementById('dropSelected');
    const nameEl      = document.getElementById('selectedFileName');
    const sizeEl      = document.getElementById('selectedFileSize');

    function showSelected(file) {
        nameEl.textContent = file.name;
        sizeEl.textContent = (file.size/1024/1024).toFixed(2) + ' MB';
        dropDefault.classList.add('d-none');
        dropSelected.classList.remove('d-none');
        dropZone.style.borderColor = '#22C55E';
        dropZone.style.background  = '#F0FDF4';
    }

    fileInput.addEventListener('change', () => { if (fileInput.files[0]) showSelected(fileInput.files[0]); });

    ['dragover','dragenter'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.add('dragover'); }));
    ['dragleave','drop'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.remove('dragover'); }));
    dropZone.addEventListener('drop', ev => {
        const file = ev.dataTransfer.files[0];
        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            showSelected(file);
        }
    });
</script>
@endpush

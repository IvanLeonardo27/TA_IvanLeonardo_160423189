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
                                  placeholder="Tuliskan isi pengumuman, deskripsi materi, atau instruksi tugas...">{{ old('body') }}</textarea>
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
    const typeButtons = document.querySelectorAll('.type-btn');
    const typeInput   = document.getElementById('typeInput');
    const assignFields = document.getElementById('assignmentFields');

    typeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const type  = btn.dataset.type;
            const color = btn.dataset.color;

            typeInput.value = type;
            assignFields.classList.toggle('d-none', type !== 'assignment');

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
</script>
@endpush

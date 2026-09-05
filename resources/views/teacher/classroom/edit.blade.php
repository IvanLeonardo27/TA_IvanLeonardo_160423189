@extends('layouts.app')

@section('title', 'Pengaturan Kelas – ' . $classroom->name)

@section('content')
<div class="row justify-content-center animate__animated animate__fadeInUp">
    <div class="col-xl-8 col-lg-10">
        <div class="mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <a href="{{ route('teacher.classroom.show', $classroom) }}" class="text-muted text-decoration-none small d-inline-flex align-items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke {{ $classroom->name }}</span>
            </a>
            <span class="badge bg-light text-muted border rounded-pill px-3 py-1.5 small">
                <i class="fa-solid fa-hashtag me-1"></i>Kode Kelas: <strong class="text-dark">{{ $classroom->code }}</strong>
            </span>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius:24px; overflow:hidden;">
            {{-- Preview Banner --}}
            <div id="bannerPreview" class="d-flex align-items-end px-5 pt-4 pb-3 position-relative text-white"
                 style="min-height:160px; background:{{ old('banner_color', $classroom->banner_color ?? '#059669') }}; transition:background .3s;">
                <i id="bannerIconPreview" class="fa-solid fa-{{ old('banner_icon', $classroom->banner_icon ?? 'graduation-cap') }} position-absolute opacity-15"
                   style="font-size:10rem;right:-10px;bottom:-20px;"></i>
                <div class="position-relative" style="z-index:1;">
                    <h3 id="namePreviw" class="fw-bold mb-0" style="text-shadow:0 2px 6px rgba(0,0,0,.2);">
                        {{ old('name', $classroom->name) }}
                    </h3>
                    <p id="subjectPreview" class="mb-0 opacity-75 small mt-1">
                        {{ old('subject', $classroom->subject ?: 'Mata Pelajaran') }}
                    </p>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                    <div>
                        <h5 class="fw-bold text-main mb-0">Pengaturan & Detail Kelas</h5>
                        <small class="text-muted">Perbarui informasi, tema banner, dan status ruang kelas Anda.</small>
                    </div>
                    <span class="badge rounded-pill px-3 py-1.5 {{ $classroom->status === 'active' ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border' }}">
                        <i class="fa-solid fa-circle-dot me-1" style="font-size: 0.65rem;"></i>{{ ucfirst($classroom->status) }}
                    </span>
                </div>

                <form action="{{ route('teacher.classroom.update', $classroom) }}" method="POST" id="editClassForm">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="nameInput"
                                   class="form-control form-control-lg rounded-4 border-0 bg-light @error('name') is-invalid @enderror"
                                   placeholder="Contoh: Bahasa Jawa – Kelas 5A"
                                   value="{{ old('name', $classroom->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Mata Pelajaran</label>
                            <input type="text" name="subject" id="subjectInput"
                                   class="form-control form-control-lg rounded-4 border-0 bg-light"
                                   placeholder="Bahasa Jawa"
                                   value="{{ old('subject', $classroom->subject) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi Kelas</label>
                            <textarea name="description" rows="3"
                                      class="form-control rounded-4 border-0 bg-light"
                                      placeholder="Tuliskan deskripsi singkat tentang kelas ini...">{{ old('description', $classroom->description) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status Kelas <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-lg rounded-4 border-0 bg-light fw-semibold">
                                <option value="active" {{ old('status', $classroom->status) === 'active' ? 'selected' : '' }}>
                                    🟢 Aktif (Dapat Diakses Siswa)
                                </option>
                                <option value="archived" {{ old('status', $classroom->status) === 'archived' ? 'selected' : '' }}>
                                    📦 Diarsipkan (Read-only / Tutup Kelas)
                                </option>
                            </select>
                        </div>

                        {{-- Pilih Warna Banner --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold d-block">Warna Banner</label>
                            <input type="hidden" name="banner_color" id="bannerColorInput" value="{{ old('banner_color', $classroom->banner_color ?? '#059669') }}">
                            <div class="d-flex gap-2.5 flex-wrap mt-1">
                                @foreach(['#059669','#2563EB','#7C3AED','#DC2626','#D97706','#0D9488','#0284C7','#E11D48','#15803D','#8B5CF6','#1F4D3A','#374151'] as $color)
                                @php $isCurrentColor = strtolower(old('banner_color', $classroom->banner_color ?? '')) === strtolower($color); @endphp
                                <button type="button" class="color-btn rounded-circle border-0 shadow-sm"
                                        data-color="{{ $color }}"
                                        style="width:38px;height:38px;background:{{ $color }};transition:all .2s; {{ $isCurrentColor ? 'transform:scale(1.3); outline:3px solid #000;' : '' }}"
                                        title="{{ $color }}"></button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Pilih Icon Banner --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold d-block">Ikon Banner</label>
                            <input type="hidden" name="banner_icon" id="bannerIconInput" value="{{ old('banner_icon', $classroom->banner_icon ?? 'graduation-cap') }}">
                            <div class="d-flex gap-2 flex-wrap mt-1">
                                @foreach(['graduation-cap','book-open','star','bolt','rocket','palette','music','globe','landmark','pencil','lightbulb','trophy'] as $icon)
                                @php $isCurrentIcon = old('banner_icon', $classroom->banner_icon ?? '') === $icon; @endphp
                                <button type="button" class="icon-btn btn {{ $isCurrentIcon ? 'btn-primary text-white' : 'btn-light' }} rounded-3"
                                        data-icon="{{ $icon }}" style="width:46px;height:46px;padding:0;font-size:1.15rem;"
                                        title="{{ $icon }}">
                                    <i class="fa-solid fa-{{ $icon }}"></i>
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-5 pt-3 border-top justify-content-between flex-wrap">
                        <a href="{{ route('teacher.classroom.show', $classroom) }}" class="btn btn-light rounded-pill px-4 py-2.5">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2.5 btn-bouncy fw-semibold shadow">
                            <i class="fa-solid fa-check me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Live preview
    const nameInput    = document.getElementById('nameInput');
    const subjectInput = document.getElementById('subjectInput');
    const namePrev     = document.getElementById('namePreviw');
    const subjectPrev  = document.getElementById('subjectPreview');
    const banner       = document.getElementById('bannerPreview');
    const iconPrev     = document.getElementById('bannerIconPreview');

    if (nameInput && namePrev) {
        nameInput.addEventListener('input', () => namePrev.textContent = nameInput.value || 'Nama Kelas Anda');
    }
    if (subjectInput && subjectPrev) {
        subjectInput.addEventListener('input', () => subjectPrev.textContent = subjectInput.value || 'Mata Pelajaran');
    }

    // Pilih warna
    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const color = btn.dataset.color;
            document.getElementById('bannerColorInput').value = color;
            banner.style.background = color;
            document.querySelectorAll('.color-btn').forEach(b => {
                b.style.transform = 'scale(1)';
                b.style.outline = 'none';
            });
            btn.style.transform = 'scale(1.3)';
            btn.style.outline = '3px solid #000';
        });
    });

    // Pilih icon
    document.querySelectorAll('.icon-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const icon = btn.dataset.icon;
            document.getElementById('bannerIconInput').value = icon;
            iconPrev.className = `fa-solid fa-${icon} position-absolute opacity-15`;
            document.querySelectorAll('.icon-btn').forEach(b => b.classList.remove('btn-primary','text-white'));
            btn.classList.add('btn-primary','text-white');
        });
    });
</script>
@endpush

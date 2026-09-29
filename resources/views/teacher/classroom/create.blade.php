@extends('layouts.app')

@section('title', 'Buat Kelas Baru')

@section('content')
<div class="row justify-content-center animate__animated animate__fadeInUp">
    <div class="col-xl-8 col-lg-10">
        <div class="mb-4">
            <a href="{{ route('teacher.classroom.index') }}" class="text-muted text-decoration-none small">
                <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Daftar Kelas
            </a>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius:24px; overflow:hidden;">
            {{-- Preview Banner --}}
            <div id="bannerPreview" class="d-flex align-items-end px-4 px-md-5 pt-4 pb-3 position-relative text-white"
                 style="min-height:160px; background:{{ old('banner_color', '#059669') }}; transition:background .3s; overflow:hidden;">
                <i id="bannerIconPreview" class="fa-solid fa-graduation-cap position-absolute opacity-15"
                   style="font-size:10rem; right:-10px; bottom:-20px; color:#ffffff; opacity:0.15 !important; pointer-events:none;"></i>
                <div class="position-relative" style="z-index:1;">
                    <h3 id="namePreviw" class="fw-bold mb-0 text-white" style="color:#ffffff !important; text-shadow:0 2px 8px rgba(0,0,0,.45);">
                        Nama Kelas Anda
                    </h3>
                </div>
            </div>

            <div class="card-body p-5">
                <h5 class="fw-bold text-main mb-4">Detail Kelas</h5>
                <form action="{{ route('teacher.classroom.store') }}" method="POST" id="createClassForm">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="nameInput"
                                   class="form-control form-control-lg rounded-4 border-0 bg-light @error('name') is-invalid @enderror"
                                   placeholder="Contoh: Kelas 5A"
                                   value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi Kelas</label>
                            <textarea name="description" rows="3"
                                      class="form-control rounded-4 border-0 bg-light"
                                      placeholder="Tuliskan deskripsi singkat tentang kelas ini...">{{ old('description') }}</textarea>
                        </div>

                        {{-- Pilih Warna Banner --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Warna Banner</label>
                            <input type="hidden" name="banner_color" id="bannerColorInput" value="{{ old('banner_color', '#059669') }}">
                            <div class="d-flex gap-2 flex-wrap mt-1">
                                @foreach(['#059669','#2563EB','#7C3AED','#DC2626','#D97706','#0D9488','#0284C7','#E11D48','#15803D','#8B5CF6'] as $color)
                                <button type="button" class="color-btn rounded-circle border-0 shadow-sm"
                                        data-color="{{ $color }}"
                                        style="width:36px;height:36px;background:{{ $color }};transition:transform .15s;"
                                        title="{{ $color }}"></button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Pilih Icon Banner --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ikon Banner</label>
                            <input type="hidden" name="banner_icon" id="bannerIconInput" value="{{ old('banner_icon', 'graduation-cap') }}">
                            <div class="d-flex gap-2 flex-wrap mt-1">
                                @foreach(['graduation-cap','book-open','star','bolt','rocket','palette','music','globe'] as $icon)
                                <button type="button" class="icon-btn btn btn-light rounded-3"
                                        data-icon="{{ $icon }}" style="width:44px;height:44px;padding:0;font-size:1.1rem;"
                                        title="{{ $icon }}">
                                    <i class="fa-solid fa-{{ $icon }}"></i>
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-5">
                        <a href="{{ route('teacher.classroom.index') }}" class="btn btn-light rounded-pill px-4 py-2">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 btn-bouncy fw-semibold shadow">
                            <i class="fa-solid fa-check me-2"></i>Buat Kelas
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
    const namePrev     = document.getElementById('namePreviw');
    const banner       = document.getElementById('bannerPreview');
    const iconPrev     = document.getElementById('bannerIconPreview');

    if (nameInput && namePrev) {
        nameInput.addEventListener('input', () => namePrev.textContent = nameInput.value || 'Nama Kelas Anda');
    }

    // Pilih warna
    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const color = btn.dataset.color;
            document.getElementById('bannerColorInput').value = color;
            banner.style.background = color;
            document.querySelectorAll('.color-btn').forEach(b => b.style.transform = 'scale(1)');
            btn.style.transform = 'scale(1.35)';
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

    // Set awal
    const defaultColor = document.getElementById('bannerColorInput').value || '#059669';
    const initColorBtn = document.querySelector(`.color-btn[data-color="${defaultColor}"]`);
    if (initColorBtn) initColorBtn.style.transform = 'scale(1.35)';
    const defaultIcon = document.getElementById('bannerIconInput').value || 'graduation-cap';
    const initIconBtn = document.querySelector(`.icon-btn[data-icon="${defaultIcon}"]`);
    if (initIconBtn) initIconBtn.classList.add('btn-primary','text-white');
</script>
@endpush

@extends('layouts.app')

@section('title', 'Edit Aksara ' . $script->name . ' - Panel Pengajar')

@section('content')
<div class="container-fluid px-0 pb-5" style="max-width: 900px;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('teacher.classroom.index') }}" class="text-decoration-none text-muted">Panel Pengajar</a></li>
            <li class="breadcrumb-item"><a href="{{ route('teacher.javanese-script.index') }}" class="text-decoration-none text-muted">Kelola Aksara Jawa</a></li>
            <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Edit {{ $script->name }}</li>
        </ol>
    </nav>

    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="{{ route('teacher.javanese-script.index') }}" class="btn btn-outline-secondary rounded-pill px-3 py-1 text-sm shadow-sm bg-white">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card card-modern border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-warning-subtle text-dark p-4 border-bottom">
            <h4 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i> Edit Data Aksara: {{ $script->name }}</h4>
            <p class="mb-0 text-muted small">Perbarui data karakter aksara, pelafalan, atau contoh kalimat penggunaannya.</p>
        </div>

        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('teacher.javanese-script.update', $script->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h5 class="fw-bold text-main mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-font text-primary me-2"></i> 1. Informasi Aksara
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kategori Aksara <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $script->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Aksara <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $script->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Huruf Latin <span class="text-danger">*</span></label>
                        <input type="text" name="latin" class="form-control @error('latin') is-invalid @enderror" value="{{ old('latin', $script->latin) }}" required>
                        @error('latin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Pelafalan Bunyi</label>
                        <input type="text" name="pronunciation" class="form-control @error('pronunciation') is-invalid @enderror" value="{{ old('pronunciation', $script->pronunciation) }}">
                        @error('pronunciation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Penjelasan / Deskripsi</label>
                        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $script->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Perbarui Gambar / Vektor Aksara (Opsional)</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept=".svg,.png,.jpg,.jpeg,.webp">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar yang sudah ada.</small>
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="fw-bold text-main mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-feather-pointed text-primary me-2"></i> 2. Contoh Kalimat Penggunaan
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Ukara Aksara Jawa (Teks Kalimat Aksara)</label>
                        <input type="text" name="javanese_script_text" class="form-control @error('javanese_script_text') is-invalid @enderror" value="{{ old('javanese_script_text', $example->javanese_script_text ?? '') }}">
                        @error('javanese_script_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Waosan Latin Basa Jawa</label>
                        <input type="text" name="javanese_latin_text" class="form-control @error('javanese_latin_text') is-invalid @enderror" value="{{ old('javanese_latin_text', $example->javanese_latin_text ?? '') }}">
                        @error('javanese_latin_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Terjemahan Bahasa Indonesia</label>
                        <input type="text" name="indonesian_text" class="form-control @error('indonesian_text') is-invalid @enderror" value="{{ old('indonesian_text', $example->indonesian_text ?? '') }}">
                        @error('indonesian_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('teacher.javanese-script.index') }}" class="btn btn-light rounded-pill px-4 fw-semibold">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-semibold shadow-sm">
                        <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

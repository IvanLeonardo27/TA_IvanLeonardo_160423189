@extends('layouts.app')

@section('title', 'Tambah Tokoh Wayang Baru - Admin BasaKula')

@section('content')
<div class="container-fluid px-0 pb-5" style="max-width: 900px;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('wayang.index') }}" class="text-decoration-none text-muted">Ensiklopedia Wayang</a></li>
            <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Tambah Tokoh Wayang</li>
        </ol>
    </nav>

    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="{{ route('wayang.index') }}" class="btn btn-outline-secondary rounded-pill px-3 py-1 text-sm shadow-sm bg-white">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Katalog Wayang
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card card-modern border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header p-4" style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%); color: #ffffff;">
            <h4 class="fw-bold mb-1 text-white"><i class="fa-solid fa-plus-circle me-2"></i> Tambah Tokoh Wayang Baru</h4>
            <p class="mb-0 text-white-50 small">Masukkan profil tokoh, silsilah, pusaka sakti, watak ksatria, dan kisah pewayangannya.</p>
        </div>

        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('wayang.store') }}" enctype="multipart/form-data">
                @csrf

                <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-id-badge text-primary me-2"></i> 1. Identitas & Silsilah Tokoh
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Tokoh Wayang <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="Contoh: Raden Gatotkaca" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kategori Tokoh</label>
                        <select name="category_id" class="form-select rounded-3 @error('category_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lain / Alias (Dasanama)</label>
                        <input type="text" name="other_names" class="form-control rounded-3" 
                               value="{{ old('other_names') }}" placeholder="Contoh: Tetuka, Kancing Jaya, Purubaya">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <select name="gender" class="form-select rounded-3">
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            <option value="Dewa" {{ old('gender') == 'Dewa' ? 'selected' : '' }}>Dewa / Batara</option>
                            <option value="Raksasa" {{ old('gender') == 'Raksasa' ? 'selected' : '' }}>Raksasa / Danawa</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Pihak / Kubu (Allegiance)</label>
                        <input type="text" name="allegiance" class="form-control rounded-3" 
                               value="{{ old('allegiance') }}" placeholder="Contoh: Pandawa / Kurawa / Netral">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Peran / Kedudukan (Role)</label>
                        <input type="text" name="role" class="form-control rounded-3" 
                               value="{{ old('role') }}" placeholder="Contoh: Senapati Perang Pringgandani">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Senjata Pusaka / Aji-aji</label>
                        <input type="text" name="weapon" class="form-control rounded-3" 
                               value="{{ old('weapon') }}" placeholder="Contoh: Kotang Antakusuma, Caping Basunanda">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Silsilah Keluarga (Family)</label>
                        <input type="text" name="family" class="form-control rounded-3" 
                               value="{{ old('family') }}" placeholder="Contoh: Putra Raden Werkudara dan Dewi Arimbi">
                    </div>
                </div>

                <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-scroll text-primary me-2"></i> 2. Watak, Karakteristik, & Kisah
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Watak & Karakteristik Ksatria</label>
                        <textarea name="character_traits" class="form-control rounded-3" rows="2" 
                                  placeholder="Contoh: Berani, setia pada kebenaran, teguh pendirian, dan rela berkorban demi nusa bangsa.">{{ old('character_traits') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Deskripsi Ringkas</label>
                        <textarea name="description" class="form-control rounded-3" rows="3" 
                                  placeholder="Ringkasan pengenalan tokoh wayang...">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Kisah Lengkap & Teladan Pewayangan (Story)</label>
                        <textarea name="story" class="form-control rounded-3" rows="5" 
                                  placeholder="Tuliskan kisah perjalanan hidup, peran dalam lakon Baratayuda/Ramayana, dan nilai budi pekertinya...">{{ old('story') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Foto / Ilustrasi Tokoh Wayang</label>
                        <input type="file" name="image" class="form-control rounded-3 @error('image') is-invalid @enderror" accept="image/*">
                        <div class="form-text">Format didukung: PNG, JPG, WEBP, SVG. Maks 2MB.</div>
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('wayang.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold" style="background: #16402E; border: none;">
                        <i class="fa-solid fa-save me-1.5"></i> Simpan Tokoh Wayang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Tambah Kategori Macapat')

@section('content')
<div class="mb-4">
    <a href="{{ route('teacher.macapat.index') }}" class="text-decoration-none text-muted fw-semibold">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar Macapat
    </a>
</div>

<div class="card card-modern border-0 shadow-sm rounded-4">
    <div class="card-body p-4 p-md-5">
        <h4 class="fw-bold mb-4 text-main">Tambah Kategori Tembang Macapat</h4>
        
        <form action="{{ route('teacher.macapat.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Tembang</label>
                    <input type="text" name="name" class="form-control rounded-3" placeholder="Contoh: Pocung, Sinom, Dhandhanggula" required value="{{ old('name') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Guru Gatra (Jumlah Baris per Bait)</label>
                    <input type="number" name="guru_gatra" class="form-control rounded-3" placeholder="Contoh: 4" required value="{{ old('guru_gatra') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Guru Wilangan (Jumlah Suku Kata Tiap Baris)</label>
                    <input type="text" name="guru_wilangan" class="form-control rounded-3" placeholder="Contoh: 12, 6, 8, 12" required value="{{ old('guru_wilangan') }}">
                    <small class="text-muted">Pisahkan dengan koma untuk setiap baris.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Guru Lagu (Vokal Akhir Tiap Baris)</label>
                    <input type="text" name="guru_lagu" class="form-control rounded-3" placeholder="Contoh: u, a, i, a" required value="{{ old('guru_lagu') }}">
                    <small class="text-muted">Pisahkan dengan koma untuk setiap baris.</small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Watak / Karakter Tembang</label>
                <textarea name="watak" class="form-control rounded-3" rows="2" placeholder="Contoh: Kendho tanpa greget saut, sembrana parikena...">{{ old('watak') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi & Makna Filosofis</label>
                <textarea name="description" class="form-control rounded-3" rows="3" placeholder="Penjelasan sejarah, filosofi hidup, atau penggunaan tembang...">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">
                <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Kategori
            </button>
            <a href="{{ route('teacher.macapat.index') }}" class="btn btn-light rounded-pill px-4 ms-2">Batal</a>
        </form>
    </div>
</div>
@endsection

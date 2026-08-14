@extends('layouts.app')

@section('title', 'Edit Kategori Macapat')

@section('content')
<div class="mb-4">
    <a href="{{ route('teacher.macapat.index') }}" class="text-decoration-none text-muted fw-semibold">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar Macapat
    </a>
</div>

<div class="card card-modern border-0 shadow-sm rounded-4">
    <div class="card-body p-4 p-md-5">
        <h4 class="fw-bold mb-4 text-main">Edit Kategori Tembang: {{ $category->name }}</h4>
        
        <form action="{{ route('teacher.macapat.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Tembang</label>
                    <input type="text" name="name" class="form-control rounded-3" required value="{{ old('name', $category->name) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Guru Gatra (Jumlah Baris per Bait)</label>
                    <input type="number" name="guru_gatra" class="form-control rounded-3" required value="{{ old('guru_gatra', $category->guru_gatra) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Guru Wilangan (Jumlah Suku Kata Tiap Baris)</label>
                    <input type="text" name="guru_wilangan" class="form-control rounded-3" required value="{{ old('guru_wilangan', $category->guru_wilangan) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Guru Lagu (Vokal Akhir Tiap Baris)</label>
                    <input type="text" name="guru_lagu" class="form-control rounded-3" required value="{{ old('guru_lagu', $category->guru_lagu) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Watak / Karakter Tembang</label>
                <textarea name="watak" class="form-control rounded-3" rows="2">{{ old('watak', $category->watak) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi & Makna Filosofis</label>
                <textarea name="description" class="form-control rounded-3" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">
                <i class="fa-solid fa-floppy-disk me-2"></i> Perbarui Kategori
            </button>
            <a href="{{ route('teacher.macapat.index') }}" class="btn btn-light rounded-pill px-4 ms-2">Batal</a>
        </form>
    </div>
</div>
@endsection

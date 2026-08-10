@extends('layouts.app')

@section('title', 'Katalog Materi Belajar')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h3 class="fw-bold text-main mb-1">Materi Pembelajaran <i class="fa-solid fa-book text-primary ms-2"></i></h3>
        <p class="text-muted">Jelajahi materi, Sastra Jawa, Unggah-Ungguh Basa, dan lainnya.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <form action="{{ route('student.materials.index') }}" method="GET" class="d-flex">
            <select name="type" class="form-select rounded-pill shadow-sm me-2" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>Umum</option>
                <option value="unggah_ungguh" {{ request('type') == 'unggah_ungguh' ? 'selected' : '' }}>Unggah-Ungguh Basa</option>
                <option value="sastra_jawa" {{ request('type') == 'sastra_jawa' ? 'selected' : '' }}>Sastra Jawa</option>
                <option value="aksara_jawa" {{ request('type') == 'aksara_jawa' ? 'selected' : '' }}>Aksara Jawa</option>
            </select>
        </form>
    </div>
</div>

<div class="row g-4">
    @forelse($materials as $material)
    <div class="col-md-4 col-sm-6">
        <a href="{{ route('student.materials.show', $material) }}" class="text-decoration-none text-dark">
            <div class="card card-modern h-100 border-0 shadow-sm rounded-4 hover-lift">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <span class="badge bg-soft-blue text-primary px-3 py-2 rounded-pill">
                            {{ ucfirst(str_replace('_', ' ', $material->type)) }}
                        </span>
                        <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> {{ $material->created_at->diffForHumans() }}</small>
                    </div>
                    <h5 class="fw-bold mb-2">{{ $material->title }}</h5>
                    <p class="text-muted small flex-grow-1">{{ Str::limit($material->description, 80) }}</p>
                    
                    <div class="mt-3 pt-3 border-top d-flex align-items-center">
                        <div class="avatar-sm bg-light text-primary rounded-circle d-flex justify-content-center align-items-center me-2" style="width:30px; height:30px;">
                            <i class="fa-solid fa-user-tie small"></i>
                        </div>
                        <small class="text-muted fw-semibold">{{ $material->teacher->name ?? 'Pengajar' }}</small>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" width="150" alt="Empty" class="mb-3 opacity-50">
        <h5 class="text-muted fw-bold">Belum ada materi</h5>
        <p class="text-muted">Pilih tipe lain atau coba lagi nanti.</p>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $materials->links() }}
</div>
@endsection

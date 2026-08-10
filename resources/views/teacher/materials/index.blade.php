@extends('layouts.app')

@section('title', 'Manajemen Materi - Pengajar')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h3 class="fw-bold text-main mb-1">Manajemen Materi <i class="fa-solid fa-book-open text-primary ms-2"></i></h3>
        <p class="text-muted">Kelola materi Unggah-Ungguh Basa, Sastra Jawa, dan Aksara Jawa.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('teacher.materials.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Tambah Materi Baru
        </a>
    </div>
</div>

<div class="card card-modern border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Judul Materi</th>
                        <th>Kategori</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materials as $material)
                    <tr>
                        <td>
                            <h6 class="mb-0 fw-bold">{{ $material->title }}</h6>
                        </td>
                        <td>{{ $material->category->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $material->type)) }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $material->status }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('teacher.materials.show', $material) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('teacher.materials.edit', $material) }}" class="btn btn-sm btn-warning text-white"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('teacher.materials.destroy', $material) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus materi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada materi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $materials->links() }}
        </div>
    </div>
</div>
@endsection

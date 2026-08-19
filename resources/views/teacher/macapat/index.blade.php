@extends('layouts.app')

@section('title', 'Tembang Macapat - BasaKula')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h3 class="fw-bold text-main mb-1">Tembang Macapat <i class="fa-solid fa-music text-primary ms-2"></i></h3>
        <p class="text-muted">Eksplorasi 11 Tembang Macapat beserta paugeran (Guru Gatra, Wilangan, Lagu) dan cakepan liriknya.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('teacher.macapat.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Tambah Kategori Macapat
        </a>
        @endif
    </div>
</div>

<div class="card card-modern border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        @if(session('success'))
            <div class="alert alert-success rounded-4 border-0 mb-4">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Tembang</th>
                        <th>Guru Gatra</th>
                        <th>Guru Wilangan</th>
                        <th>Guru Lagu</th>
                        <th>Jumlah Bait</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $item)
                    <tr>
                        <td>
                            <h6 class="mb-1 fw-bold text-primary">{{ $item->name }}</h6>
                            <small class="text-muted">{{ Str::limit($item->watak ?? $item->description, 50) }}</small>
                        </td>
                        <td><span class="badge bg-secondary">{{ $item->guru_gatra }} Gatra</span></td>
                        <td><code>{{ $item->guru_wilangan }}</code></td>
                        <td><code>{{ $item->guru_lagu }}</code></td>
                        <td><span class="badge bg-soft-blue text-primary">{{ $item->details_count }} Bait</span></td>
                        <td class="text-end">
                            <a href="{{ route('teacher.macapat.show', $item) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                <i class="fa-solid fa-book-open me-1"></i> Detail & Bait
                            </a>
                            @if(auth()->check() && auth()->user()->isAdmin())
                            <a href="{{ route('teacher.macapat.edit', $item) }}" class="btn btn-sm btn-warning text-white rounded-pill px-3 me-1">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('teacher.macapat.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori tembang macapat ini beserta seluruh baitnya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data Tembang Macapat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection

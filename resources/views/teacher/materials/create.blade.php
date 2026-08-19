@extends('layouts.app')

@section('title', 'Tambah Materi')

@section('content')
<div class="card card-modern border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <h4 class="fw-bold mb-4">Tambah Materi Baru</h4>
        
        <form action="{{ route('teacher.materials.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Judul Materi</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipe Materi</label>
                    <select name="type" id="materialType" class="form-select" required onchange="toggleFields()">
                        <option value="general">Umum</option>
                        <option value="sastra_jawa">Sastra Jawa</option>
                        <option value="aksara_jawa">Aksara Jawa</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <!-- Fields Sastra Jawa -->
            <div id="fields_sastra_jawa" class="d-none border p-3 rounded mb-3 bg-light">
                <h6 class="fw-bold text-primary">Detail Sastra Jawa</h6>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="author" class="form-control">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Genre (Misal: Geguritan)</label>
                        <input type="text" name="genre" class="form-control">
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label">Isi / Lirik</label>
                    <textarea name="content" class="form-control" rows="5"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Materi</button>
            <a href="{{ route('teacher.materials.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
        </form>
    </div>
</div>

<script>
function toggleFields() {
    const type = document.getElementById('materialType').value;
    document.getElementById('fields_sastra_jawa').classList.add('d-none');
    
    if (type === 'sastra_jawa') {
        document.getElementById('fields_sastra_jawa').classList.remove('d-none');
    }
}
</script>
@endsection

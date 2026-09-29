@extends('layouts.app')

@section('title', 'Bank Soal - BasaKula')

@section('content')
{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeInDown flex-wrap gap-3">
    <div>
        <h2 class="fw-bold text-main mb-1">
            <i class="fa-solid fa-boxes-stacked me-2" style="color: #8B5CF6;"></i>Bank Soal
        </h2>
        <p class="text-muted mb-0">
            {{ auth()->user()->isAdmin() ? 'Katalog seluruh butir soal kuis pilihan ganda di platform' : 'Kelola kumpulan soal kuis pilihan ganda milik Anda yang siap dipakai ulang kapan saja pada kelas Anda.' }}
        </p>
    </div>
    <a href="{{ route('teacher.question-bank.create') }}" class="btn btn-primary rounded-pill px-4 shadow btn-bouncy w-100 w-sm-auto text-center" style="background:#8B5CF6; border-color:#8B5CF6;">
        <i class="fa-solid fa-plus me-2"></i>Tambah Soal Baru
    </a>
</div>

{{-- Alert Notifikasi --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
    <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Filter & Pencarian --}}
<div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
    <div class="card-body p-3 p-md-4">
        <form method="GET" action="{{ route('teacher.question-bank.index') }}" class="row g-2 align-items-center">
            <div class="col-md-6 col-lg-7">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0 ps-3">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-0 bg-light rounded-end-pill py-2" placeholder="Cari isi pertanyaan soal...">
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <select name="category" class="form-select border-0 bg-light rounded-pill py-2 fw-semibold">
                    <option value="all">Semua Kategori Topik</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-pill px-3 py-2 flex-grow-1 fw-semibold" style="background:#8B5CF6; border-color:#8B5CF6;">
                    Filter
                </button>
                @if(request('q') || (request('category') && request('category') !== 'all'))
                    <a href="{{ route('teacher.question-bank.index') }}" class="btn btn-light rounded-circle p-2" title="Reset Filter" style="width:38px;height:38px;">
                        <i class="fa-solid fa-rotate-left text-muted"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Daftar Soal --}}
@if($questions->isEmpty())
<div class="text-center py-5 my-5 animate__animated animate__fadeIn">
    <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-purple-subtle text-purple mb-3 shadow-xs" style="width:80px;height:80px;background:rgba(139,92,246,0.1);color:#8B5CF6;">
        <i class="fa-solid fa-boxes-stacked fs-1"></i>
    </div>
    <h4 class="fw-bold text-main mt-2">Belum Ada Soal di Bank Soal</h4>
    <p class="text-muted col-md-6 mx-auto">
        Simpan pertanyaan dan pilihan jawaban pilihan ganda ke Bank Soal agar Anda dapat dengan mudah menggunakannya kembali pada kuis kelas kapan saja.
    </p>
    <a href="{{ route('teacher.question-bank.create') }}" class="btn btn-primary rounded-pill px-4 mt-2 shadow btn-bouncy" style="background:#8B5CF6; border-color:#8B5CF6;">
        <i class="fa-solid fa-plus me-2"></i>Buat Butir Soal Pertama
    </a>
</div>
@else
<div class="d-flex flex-column gap-3 mb-4">
    @foreach($questions as $index => $q)
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white hover-shadow transition-all border-start border-4" style="border-color: #8B5CF6 !important;">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex justify-content-between align-items-start gap-2 mb-3 flex-wrap">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="badge rounded-pill px-3 py-1.5 fw-bold text-white shadow-xs" style="background: #8B5CF6; font-size: 0.8rem;">
                        Soal #{{ $questions->firstItem() + $index }}
                    </span>
                    <span class="badge bg-light text-secondary border rounded-pill px-2.5 py-1 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                        {{ $categories[$q->category] ?? ucfirst($q->category ?? 'Umum') }}
                    </span>
                    @if(auth()->user()->isAdmin() && $q->teacher)
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                            <i class="fa-solid fa-chalkboard-user me-1"></i>{{ $q->teacher->name }}
                        </span>
                    @endif
                </div>

                {{-- Aksi Edit & Hapus --}}
                <div class="d-flex align-items-center gap-1">
                    <a href="{{ route('teacher.question-bank.edit', $q) }}" class="btn btn-sm btn-light rounded-pill px-3 fw-semibold text-warning-emphasis" title="Edit Soal">
                        <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                    </a>
                    <button type="button" class="btn btn-sm btn-light rounded-pill px-3 fw-semibold text-danger" title="Hapus Soal"
                            onclick="confirmDeleteQuestion('{{ route('teacher.question-bank.destroy', $q) }}')">
                        <i class="fa-solid fa-trash me-1"></i>Hapus
                    </button>
                </div>
            </div>

            {{-- Teks Pertanyaan --}}
            <h6 class="fw-bold text-main mb-3 fs-6" style="line-height: 1.5;">
                {{ $q->question ?? $q->question_text }}
            </h6>

            {{-- Lampiran Gambar Soal (Jika Ada) --}}
            @if($q->image_path)
            <div class="mb-3">
                <a href="{{ asset('storage/' . $q->image_path) }}" target="_blank" class="d-inline-block">
                    <img src="{{ asset('storage/' . $q->image_path) }}" alt="Gambar Soal" class="rounded-3 border shadow-xs" style="max-height: 160px; max-width: 100%; object-fit: contain;">
                </a>
            </div>
            @endif

            {{-- Pilihan Jawaban (A, B, C, D...) --}}
            <div class="row g-2 mb-3">
                @php
                    $options = is_array($q->options) ? $q->options : (json_decode($q->options, true) ?? []);
                    $percentages = is_array($q->option_percentages) ? $q->option_percentages : (json_decode($q->option_percentages, true) ?? []);
                @endphp
                @foreach($options as $optIdx => $optText)
                    @php
                        $letter = chr(65 + $optIdx);
                        $pct = $percentages[$optIdx] ?? ($optIdx == $q->correct_index ? 100 : 0);
                        $isKey = ($pct == 100);
                        $isPartial = ($pct > 0 && $pct < 100);
                    @endphp
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 p-2 px-3 rounded-3 border {{ $isKey ? 'border-success bg-success-subtle' : ($isPartial ? 'border-primary-subtle bg-primary-subtle' : 'bg-light border-0') }}">
                            <span class="badge {{ $isKey ? 'bg-success text-white' : 'bg-secondary text-white' }} rounded-circle flex-shrink-0" style="width:24px;height:24px;line-height:16px;text-align:center;font-size:0.75rem;">
                                {{ $letter }}
                            </span>
                            <span class="flex-grow-1 small {{ $isKey ? 'fw-bold text-success' : 'text-main' }}">
                                {{ $optText }}
                            </span>
                            @if($isKey)
                                <span class="badge bg-success text-white rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                    <i class="fa-solid fa-check me-1"></i>Kunci (100%)
                                </span>
                            @elseif($isPartial)
                                <span class="badge bg-primary text-white rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                    {{ $pct }}%
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Penjelasan / Pembahasan (Jika Ada) --}}
            @if(!empty($q->explanation))
            <div class="alert alert-light border border-warning-subtle rounded-3 p-2.5 px-3 mb-0 d-flex align-items-start gap-2" style="background:#FFFBEB;">
                <i class="fa-regular fa-lightbulb text-warning fs-6 mt-0.5 flex-shrink-0"></i>
                <div class="small">
                    <strong class="text-warning-emphasis">Penjelasan Kunci Jawaban:</strong>
                    <div class="text-muted mt-0.5" style="font-size: 0.82rem;">{{ $q->explanation }}</div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center">
    {{ $questions->links() }}
</div>
@endif

{{-- Form Hapus Hidden --}}
<form id="deleteQuestionForm" method="POST" action="" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDeleteQuestion(url) {
    if (confirm('Apakah Anda yakin ingin menghapus butir soal ini dari Bank Soal?')) {
        const form = document.getElementById('deleteQuestionForm');
        form.action = url;
        form.submit();
    }
}
</script>
@endsection

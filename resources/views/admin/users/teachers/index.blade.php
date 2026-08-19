@extends('layouts.app')

@section('title', 'Kelola Data Pengajar - Admin BasaKula')

@section('content')
<div class="container-fluid py-4" style="max-width: 1240px;">
    {{-- Header Banner --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%); color: #ffffff;">
        <div class="card-body p-4 p-md-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 d-flex align-items-center justify-content-center" style="background: rgba(255,255,255,0.15); width: 56px; height: 56px;">
                    <i class="fa-solid fa-chalkboard-user text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-white mb-1.5">Kelola Data Akun Pengajar</h4>
                    <p class="text-white-50 small mb-0">Manajemen guru terdaftar dengan kode akun unik (format: <code style="background: rgba(255,255,255,0.2); color: #ffffff !important; padding: 3px 8px; border-radius: 6px;">277YYXX</code>).</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2.5 flex-wrap">
                <div class="d-inline-flex align-items-center gap-2 px-4 py-2.5 rounded-pill fw-semibold shadow-xs" 
                     style="background: rgba(255, 255, 255, 0.2); color: #ffffff !important; font-size: 0.88rem; border: 1.5px solid rgba(255, 255, 255, 0.35);">
                    <i class="fa-solid fa-users me-1 text-white"></i> {{ $totalTeachers }} Total Pengajar ({{ $activeTeachers }} Aktif)
                </div>
                <a href="{{ route('admin.users.teachers.create') }}" class="btn btn-light rounded-pill px-4 py-2.5 fw-bold btn-bouncy shadow-sm" style="color: #16402E !important; font-size: 0.9rem;">
                    <i class="fa-solid fa-user-plus me-1.5"></i> Tambah Pengajar
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success rounded-4 border-0 mb-4 p-3.5 d-flex align-items-center gap-2.5 shadow-sm">
        <i class="fa-solid fa-circle-check fs-5 text-success"></i>
        <div class="fw-medium text-dark">{{ session('success') }}</div>
    </div>
    @endif

    {{-- Filter & Search Card --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background:#ffffff; border: 1px solid #E2E8F0 !important;">
        <div class="card-body p-3.5">
            <form action="{{ route('admin.users.teachers.index') }}" method="GET" class="row g-2.5 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-muted">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-light border-start-0 rounded-end-pill py-2 text-dark" 
                               placeholder="Cari nama, email, atau kode pengajar (277...)..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select rounded-pill bg-light py-2 text-dark" onchange="this.form.submit()">
                        <option value="">Semua Status Akun</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif (Dapat Login)</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif (Ditangguhkan)</option>
                    </select>
                </div>
                <div class="col-md-4 text-md-end">
                    <button type="submit" class="btn btn-dark rounded-pill px-3.5 py-2 btn-sm fw-semibold">
                        <i class="fa-solid fa-filter me-1"></i> Terapkan Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']) && (request('search') || request('status')))
                    <a href="{{ route('admin.users.teachers.index') }}" class="btn btn-outline-secondary rounded-pill px-3.5 py-2 btn-sm ms-1">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background:#ffffff; border: 1px solid #E2E8F0 !important;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size:0.92rem;">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3.5 fw-bold text-dark">Kode Pengajar</th>
                        <th class="py-3.5 fw-bold text-dark">Nama & Email</th>
                        <th class="py-3.5 fw-bold text-dark">NIP & Lembaga</th>
                        <th class="py-3.5 fw-bold text-dark">Ruang Kelas</th>
                        <th class="py-3.5 fw-bold text-dark">Status</th>
                        <th class="py-3.5 fw-bold text-dark">Login Terakhir</th>
                        <th class="text-end pe-4 py-3.5 fw-bold text-dark">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $t)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-inline-flex align-items-center justify-content-center font-monospace fw-bold rounded-pill shadow-xs" 
                                 style="background: #F8FAFC; color: #0F172A !important; border: 1.5px solid #CBD5E1; font-size:0.86rem; letter-spacing: 0.5px; padding: 6px 14px; min-width: 95px;">
                                {{ $t->user_code ?? '-' }}
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $t->name }}</div>
                            <small class="text-muted">{{ $t->email }}</small>
                        </td>
                        <td class="py-3">
                            <div class="fw-semibold text-dark">{{ $t->teacherProfile->nip ?? '-' }}</div>
                            <small class="text-muted">{{ $t->teacherProfile->institution_name ?? '-' }}</small>
                        </td>
                        <td class="py-3">
                            <div class="d-inline-flex align-items-center px-3 py-1.5 rounded-pill fw-semibold shadow-xs" 
                                 style="background: #F8FAFC; color: #334155 !important; border: 1.5px solid #E2E8F0; font-size: 0.83rem;">
                                <i class="fa-solid fa-chalkboard text-primary me-1.5"></i> {{ $t->classrooms_count ?? 0 }} Kelas
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="d-inline-flex align-items-center px-3 py-1.5 rounded-pill fw-bold shadow-xs" 
                                 style="{{ $t->status === 'active' ? 'background: #DCFCE7; color: #166534 !important; border: 1.5px solid #86EFAC;' : 'background: #FEE2E2; color: #991B1B !important; border: 1.5px solid #FCA5A5;' }}; font-size: 0.78rem;">
                                ● {{ $t->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </div>
                        </td>
                        <td class="text-muted small py-3">
                            {{ $t->last_login ? $t->last_login->translatedFormat('d M Y, H:i') : 'Belum Pernah' }}
                        </td>
                        <td class="text-end pe-4 py-3">
                            <div class="d-inline-flex gap-1.5">
                                <a href="{{ route('admin.users.teachers.edit', $t) }}" class="btn btn-light btn-sm rounded-circle p-2 shadow-xs border" style="width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;" title="Edit Data Pengajar">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                </a>
                                <form action="{{ route('admin.users.toggle_status', $t) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle p-2 shadow-xs border" style="width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;"
                                            title="{{ $t->status === 'active' ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                        <i class="fa-solid {{ $t->status === 'active' ? 'fa-user-slash text-warning' : 'fa-user-check text-success' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.teachers.destroy', $t) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengajar {{ $t->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle p-2 shadow-xs border" style="width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;" title="Hapus Akun">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-users-slash fs-2 mb-2 d-block opacity-50"></i>
                            Tidak ada data pengajar yang sesuai dengan filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($teachers->hasPages())
        <div class="p-3.5 border-top d-flex justify-content-end bg-light bg-opacity-25">
            {{ $teachers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

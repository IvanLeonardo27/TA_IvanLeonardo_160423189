@extends('layouts.app')

@section('title', 'Kawruh Basa Jawa - BasaKula')

@section('content')
<div class="container-fluid py-3 py-md-4 px-2 px-md-4" style="max-width: 1300px;">
    {{-- Hero Section --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" 
         style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%); color: #ffffff;">
        <div class="card-body p-3 p-sm-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-8">
                    <span class="badge rounded-pill px-3 py-1.5 mb-2 mb-sm-3 fw-bold shadow-xs text-nowrap" 
                          style="background: rgba(255,255,255,0.2); color: #ffffff; border: 1px solid rgba(255,255,255,0.3); font-size: 0.8rem;">
                        <i class="fa-solid fa-book-open me-1.5"></i> Paramasastra & Kawruh Basa Jawa
                    </span>
                    <h2 class="fw-bold text-white mb-2 fs-3 fs-md-2" style="letter-spacing: -0.5px;">Kawruh Basa Jawa</h2>
                    <p class="text-white-50 mb-3 mb-md-4" style="font-size: 0.95rem; max-width: 650px; line-height: 1.5;">
                        Koleksi materi pendukung paramasastra Jawa: Tetuwuhan (kembang, pentil, woh, isi, wit, godhong), Kewan (arane anak kewan), lan Manungsa (urutane turunan, sedulur, prenah sedulur, arane wong, lan sebutane bocah).
                    </p>

                    {{-- Form Pencarian Terpadu (Mobile & Desktop Friendly) --}}
                    <form action="{{ route('kawruh-basa.index') }}" method="GET" class="w-100" style="max-width: 600px;">
                        <input type="hidden" name="category" value="{{ $activeCategory }}">
                        <div class="input-group input-group-lg shadow-sm rounded-pill bg-white p-1">
                            <span class="input-group-text bg-transparent border-0 ps-3 pe-2 text-muted">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="search" id="kawruhSearchInput" class="form-control border-0 bg-transparent py-2 ps-1 text-dark fw-semibold" 
                                   placeholder="Cari istilah Jawa atau artinya..." 
                                   value="{{ $search }}" style="font-size: 0.9rem;"
                                   autocomplete="off">
                            <button type="submit" class="btn btn-primary rounded-pill px-3 px-sm-4 fw-bold btn-bouncy" style="background:#C9A66B; border:none; color:#16402E; font-size: 0.9rem;">
                                Cari
                            </button>
                        </div>
                        @if($search)
                        <div class="mt-2 ms-1">
                            <a href="{{ route('kawruh-basa.index', ['category' => $activeCategory]) }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1.5 shadow-xs" style="font-size: 0.82rem;">
                                <i class="fa-solid fa-rotate-left"></i> Reset Pencarian (Menampilkan Semua)
                            </a>
                        </div>
                        @endif
                    </form>
                </div>

                <div class="col-lg-4 text-center d-none d-lg-block">
                    <div class="d-inline-flex p-4 rounded-circle shadow-lg" 
                         style="background: rgba(255,255,255,0.08); border: 2px dashed rgba(255,255,255,0.25);">
                        <i class="fa-solid {{ $categoryMeta['icon'] ?? 'fa-book-open' }} text-white" style="font-size: 6rem; opacity: 0.9;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Success / Error --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-xs mb-4" role="alert">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-check fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Filter Dropdown Toolbar (Responsif & Rapi) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
        <div class="card-body p-3 p-sm-4">
            <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center justify-content-between gap-3">
                
                {{-- Dropdown Pilihan Kategori --}}
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 flex-grow-1">
                    <label class="fw-bold text-dark mb-0 small text-uppercase flex-shrink-0" style="font-size: 0.82rem; letter-spacing: 0.5px;">
                        <i class="fa-solid fa-layer-group text-success me-1"></i> Kategori:
                    </label>

                    {{-- Dropdown Menu Bootstrap yang Dikelompokkan --}}
                    <div class="dropdown flex-grow-1 w-100 w-sm-auto" style="min-width: 280px; max-width: 480px;">
                        <button class="btn btn-white dropdown-toggle w-100 rounded-pill px-3 py-2.5 fw-bold shadow-xs d-flex align-items-center justify-content-between gap-2 border text-dark" 
                                type="button" id="kawruhCategoryDropdown" data-bs-toggle="dropdown" aria-expanded="false" 
                                style="background: #FFFFFF; border-color: #CBD5E1 !important; font-size: 0.92rem;">
                            <span class="d-flex align-items-center gap-2 text-truncate">
                                <i class="fa-solid {{ $categoryMeta['icon'] }} text-success"></i>
                                <span class="text-truncate">{{ $categoryMeta['name'] }}</span>
                            </span>
                            <span class="badge rounded-pill ms-2 text-white flex-shrink-0" style="background: #16402E; font-size: 0.75rem;">
                                {{ $counts[$activeCategory] ?? 0 }} Entri
                            </span>
                        </button>
                        <ul class="dropdown-menu shadow-lg rounded-4 p-2 border-0 w-100" aria-labelledby="kawruhCategoryDropdown" style="max-height: 440px; overflow-y: auto; min-width: 290px;">
                            
                            {{-- Kelompok 1: Tetuwuhan --}}
                            <li class="dropdown-header text-uppercase fw-bold text-success px-3 pt-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                <i class="fa-solid fa-seedling me-1"></i> A. Tetuwuhan (Tumbuhan)
                            </li>
                            @foreach(['arane_kembang', 'arane_pentil', 'arane_woh', 'arane_isi', 'arane_wit', 'arane_godhong'] as $k)
                            <li>
                                <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center justify-content-between my-0.5 {{ $activeCategory === $k ? 'active fw-bold' : '' }}" 
                                   href="{{ route('kawruh-basa.index', array_filter(['category' => $k, 'search' => $search])) }}"
                                   style="{{ $activeCategory === $k ? 'background: #16402E; color: #ffffff;' : '' }}">
                                    <span class="d-flex align-items-center gap-2 text-truncate">
                                        <i class="fa-solid {{ $categories[$k]['icon'] }} {{ $activeCategory === $k ? 'text-white' : 'text-muted' }}" style="width: 18px;"></i>
                                        <span class="text-truncate">{{ $categories[$k]['name'] }}</span>
                                    </span>
                                    <span class="badge rounded-pill {{ $activeCategory === $k ? 'bg-light text-dark' : 'bg-secondary-subtle text-secondary' }} ms-2" style="font-size: 0.72rem;">
                                        {{ $counts[$k] ?? 0 }}
                                    </span>
                                </a>
                            </li>
                            @endforeach

                            <li><hr class="dropdown-divider my-2"></li>

                            {{-- Kelompok 2: Kewan --}}
                            <li class="dropdown-header text-uppercase fw-bold text-success px-3" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                <i class="fa-solid fa-paw me-1"></i> B. Kewan (Hewan)
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center justify-content-between my-0.5 {{ $activeCategory === 'arane_anak_kewan' ? 'active fw-bold' : '' }}" 
                                   href="{{ route('kawruh-basa.index', array_filter(['category' => 'arane_anak_kewan', 'search' => $search])) }}"
                                   style="{{ $activeCategory === 'arane_anak_kewan' ? 'background: #16402E; color: #ffffff;' : '' }}">
                                    <span class="d-flex align-items-center gap-2 text-truncate">
                                        <i class="fa-solid {{ $categories['arane_anak_kewan']['icon'] }} {{ $activeCategory === 'arane_anak_kewan' ? 'text-white' : 'text-muted' }}" style="width: 18px;"></i>
                                        <span class="text-truncate">{{ $categories['arane_anak_kewan']['name'] }}</span>
                                    </span>
                                    <span class="badge rounded-pill {{ $activeCategory === 'arane_anak_kewan' ? 'bg-light text-dark' : 'bg-secondary-subtle text-secondary' }} ms-2" style="font-size: 0.72rem;">
                                        {{ $counts['arane_anak_kewan'] ?? 0 }}
                                    </span>
                                </a>
                            </li>

                            <li><hr class="dropdown-divider my-2"></li>

                            {{-- Kelompok 3: Manungsa --}}
                            <li class="dropdown-header text-uppercase fw-bold text-success px-3" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                <i class="fa-solid fa-users me-1"></i> C. Manungsa (Kekerabatan & Ciri)
                            </li>
                            @foreach(['urutane_turunan', 'urutane_sedulur', 'prenah_sedulur', 'arane_wong', 'sebutane_bocah'] as $k)
                            <li>
                                <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center justify-content-between my-0.5 {{ $activeCategory === $k ? 'active fw-bold' : '' }}" 
                                   href="{{ route('kawruh-basa.index', array_filter(['category' => $k, 'search' => $search])) }}"
                                   style="{{ $activeCategory === $k ? 'background: #16402E; color: #ffffff;' : '' }}">
                                    <span class="d-flex align-items-center gap-2 text-truncate">
                                        <i class="fa-solid {{ $categories[$k]['icon'] }} {{ $activeCategory === $k ? 'text-white' : 'text-muted' }}" style="width: 18px;"></i>
                                        <span class="text-truncate">{{ $categories[$k]['name'] }}</span>
                                    </span>
                                    <span class="badge rounded-pill {{ $activeCategory === $k ? 'bg-light text-dark' : 'bg-secondary-subtle text-secondary' }} ms-2" style="font-size: 0.72rem;">
                                        {{ $counts[$k] ?? 0 }}
                                    </span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Info Ringkas Kategori Aktif --}}
                <div class="text-md-end text-muted small d-none d-md-block">
                    <span class="fw-semibold text-dark">{{ $totalAll }}</span> total entri di <span class="fw-semibold text-dark">{{ count($categories) }}</span> kategori
                </div>
            </div>
        </div>
    </div>

    {{-- Judul Kategori (Warna Dasar Putih Kontras, Tegas & Tombol Rapi Proporsional) --}}
    <div class="card border-0 shadow-sm rounded-4 p-3 p-sm-4 mb-4" 
         style="background: #FFFFFF; border: 1px solid #E2E8F0 !important; border-left: 6px solid #16402E !important;">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div class="d-flex align-items-center gap-3 flex-grow-1" style="min-width: 0;">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                     style="width: 52px; height: 52px; background: rgba(22, 64, 46, 0.08); color: #16402E; font-size: 1.55rem;">
                    <i class="fa-solid {{ $categoryMeta['icon'] }}"></i>
                </div>
                <div class="flex-grow-1" style="min-width: 0;">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h3 class="fw-bold mb-0 text-dark text-nowrap" style="color: #16402E !important; font-size: 1.35rem;">
                            {{ $categoryMeta['name'] }}
                        </h3>
                        <span class="badge rounded-pill px-2.5 py-1 fw-bold text-nowrap" style="background: rgba(22, 64, 46, 0.09); color: #16402E; font-size: 0.78rem; border: 1px solid rgba(22, 64, 46, 0.18);">
                            {{ $items->total() }} Entri Ditemukan
                        </span>
                    </div>
                    <p class="text-secondary mb-0 mt-1" style="font-size: 0.9rem; line-height: 1.4;">
                        {{ $categoryMeta['desc'] }}
                    </p>
                </div>
            </div>

            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher()))
            <div class="flex-shrink-0" style="width: auto !important;">
                <button type="button" class="btn btn-warning rounded-pill px-3.5 py-2 fw-bold text-dark d-inline-flex align-items-center gap-2 shadow-xs text-nowrap btn-bouncy" 
                        data-bs-toggle="modal" data-bs-target="#createEntryModal"
                        style="background: #FBBF24; border: none; font-size: 0.88rem; width: auto !important; max-width: fit-content !important;">
                    <i class="fa-solid fa-plus-circle"></i> Tambah Entri
                </button>
            </div>
            @endif
        </div>
    </div>

    {{-- BAGAN DIAGRAM VISUAL KHUSUS URUTANE TURUNAN & URUTANE SEDULUR (SESUAI BUKU PEPAK KACA 26) --}}
    @if(in_array($activeCategory, ['urutane_turunan', 'urutane_sedulur']))
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
        <div class="card-header bg-white border-bottom p-3 p-md-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                <div>
                    <h5 class="fw-bold mb-1" style="color: #16402E;">
                        <i class="fa-solid fa-diagram-project text-success me-2"></i>
                        Bagan Diagram Visual Silsilah & Urutan Jawa
                    </h5>
                    <p class="text-muted small mb-0">
                        Visualisasi silsilah leluhur, keturunan, lan urutan sedulur adhedhasar buku Pepak Kaca 26.
                    </p>
                </div>
                <span class="badge rounded-pill bg-light text-dark border px-3 py-1.5 small text-nowrap">
                    <i class="fa-solid fa-book-open me-1 text-secondary"></i> Sumber: Kaca 26 Pepak
                </span>
            </div>
        </div>

        <div class="card-body p-3 p-md-4" style="background: #FAFBFD;">
            <div class="row g-4 justify-content-center">
                
                {{-- DIAGRAM 1: URUTANE TURUNAN --}}
                <div class="col-12 {{ $activeCategory === 'urutane_turunan' ? 'col-lg-7' : 'col-lg-6' }}">
                    <div class="p-3 p-md-4 rounded-4 bg-white border shadow-xs h-100">
                        <div class="text-center mb-3">
                            <span class="badge rounded-pill px-3 py-1 fw-bold mb-1" style="background: rgba(22, 64, 46, 0.08); color: #16402E;">
                                1. URUTANE TURUNAN
                            </span>
                            <h6 class="fw-bold text-dark mb-0">Silsilah Leluhur Munggah & Keturunan Mudhun</h6>
                        </div>

                        {{-- Bagian Leluhur (Panah Munggah / Ke Atas) --}}
                        <div class="text-center mb-2">
                            <small class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-0.5" style="font-size: 0.72rem;">
                                <i class="fa-solid fa-arrow-up me-1"></i> Leluhur Munggah (Nenek Moyang)
                            </small>
                        </div>

                        @php
                            $leluhur = [
                                ['term' => 'Grepak senthe', 'desc' => 'Generasi kaping 8 munggah', 'step' => '+8'],
                                ['term' => 'Gantung siwur', 'desc' => 'Generasi kaping 7 munggah', 'step' => '+7'],
                                ['term' => 'Udheg-udheg',   'desc' => 'Generasi kaping 6 munggah', 'step' => '+6'],
                                ['term' => 'Wareng',        'desc' => 'Generasi kaping 5 munggah', 'step' => '+5'],
                                ['term' => 'Canggah',       'desc' => 'Generasi kaping 4 munggah', 'step' => '+4'],
                                ['term' => 'Buyut',         'desc' => 'Generasi kaping 3 munggah', 'step' => '+3'],
                                ['term' => 'Embah',         'desc' => 'Kakek utawa nenek',         'step' => '+2'],
                            ];
                        @endphp

                        <div class="d-flex flex-column align-items-center">
                            @foreach($leluhur as $node)
                                <div class="diagram-node rounded-pill px-3 py-1.5 shadow-xs text-center d-flex align-items-center justify-content-between my-0.5" 
                                     style="background: #FFFFFF; border: 1.5px solid #CBD5E1; width: 100%; max-width: 320px;">
                                    <span class="badge rounded-pill bg-light text-muted border px-2 py-0.5" style="font-size: 0.68rem;">{{ $node['step'] }}</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.92rem;">{{ $node['term'] }}</span>
                                    <small class="text-muted" style="font-size: 0.72rem;">{{ $node['desc'] }}</small>
                                </div>
                                <div class="text-success fw-bold my-1" style="font-size: 0.82rem;">
                                    <i class="fa-solid fa-arrow-up"></i>
                                </div>
                            @endforeach

                            {{-- Pusat Silsilah: Bapak Ibu - Bale Somah Sesuai PDF --}}
                            <div class="d-flex align-items-center justify-content-center gap-2 my-2 w-100 flex-wrap" style="max-width: 420px;">
                                <div class="diagram-node-center rounded-4 px-4 py-2 text-center shadow text-white" 
                                     style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%); border: 2px solid #C9A66B; min-width: 190px;">
                                    <div class="text-uppercase small fw-bold" style="color: #FBBF24; font-size: 0.7rem; letter-spacing: 0.5px;">Pusat Silsilah</div>
                                    <div class="fw-bold fs-5">Bapak Ibu</div>
                                    <div class="small text-white-50" style="font-size: 0.75rem;">Wong tuwa (Ayah & Ibu)</div>
                                </div>
                                <div class="text-muted d-none d-sm-block fw-bold">—</div>
                                <div class="diagram-node-somah rounded-pill px-3 py-1.5 shadow-xs text-center" 
                                     style="background: #FEF3C7; color: #92400E; border: 1px dashed #F59E0B;">
                                    <div class="fw-bold" style="font-size: 0.85rem;"><i class="fa-solid fa-people-roof me-1"></i> bale somah</div>
                                    <small style="font-size: 0.7rem;">Rumah tangga / Pasangan</small>
                                </div>
                            </div>

                            {{-- Bagian Keturunan (Panah Mudhun / Ke Bawah) --}}
                            <div class="text-center my-2">
                                <small class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-0.5" style="font-size: 0.72rem;">
                                    <i class="fa-solid fa-arrow-down me-1"></i> Keturunan Mudhun (Anak Cucu)
                                </small>
                            </div>

                            @php
                                $keturunan = [
                                    ['term' => 'Anak',          'desc' => 'Keturunan kaping 1 mudhun', 'step' => '-1'],
                                    ['term' => 'Putu',          'desc' => 'Cucu (Keturunan kaping 2)', 'step' => '-2'],
                                    ['term' => 'Buyut',         'desc' => 'Cicit (Keturunan kaping 3)','step' => '-3'],
                                    ['term' => 'Canggah',       'desc' => 'Generasi kaping 4 mudhun', 'step' => '-4'],
                                    ['term' => 'Wareng',        'desc' => 'Generasi kaping 5 mudhun', 'step' => '-5'],
                                    ['term' => 'Udheg-udheg',   'desc' => 'Generasi kaping 6 mudhun', 'step' => '-6'],
                                    ['term' => 'Gantung siwur', 'desc' => 'Generasi kaping 7 mudhun', 'step' => '-7'],
                                    ['term' => 'Grepak senthe', 'desc' => 'Generasi kaping 8 mudhun', 'step' => '-8'],
                                ];
                            @endphp

                            @foreach($keturunan as $node)
                                <div class="text-success fw-bold my-1" style="font-size: 0.82rem;">
                                    <i class="fa-solid fa-arrow-down"></i>
                                </div>
                                <div class="diagram-node rounded-pill px-3 py-1.5 shadow-xs text-center d-flex align-items-center justify-content-between my-0.5" 
                                     style="background: #FFFFFF; border: 1.5px solid #CBD5E1; width: 100%; max-width: 320px;">
                                    <span class="badge rounded-pill bg-light text-muted border px-2 py-0.5" style="font-size: 0.68rem;">{{ $node['step'] }}</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.92rem;">{{ $node['term'] }}</span>
                                    <small class="text-muted" style="font-size: 0.72rem;">{{ $node['desc'] }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- DIAGRAM 2: URUTANE SEDULUR --}}
                <div class="col-12 {{ $activeCategory === 'urutane_sedulur' ? 'col-lg-7' : 'col-lg-5' }}">
                    <div class="p-3 p-md-4 rounded-4 bg-white border shadow-xs h-100">
                        <div class="text-center mb-3">
                            <span class="badge rounded-pill px-3 py-1 fw-bold mb-1" style="background: rgba(22, 64, 46, 0.08); color: #16402E;">
                                2. URUTANE SEDULUR
                            </span>
                            <h6 class="fw-bold text-dark mb-0">Urutan Kelahiran Sedulur ing Kulawarga</h6>
                        </div>

                        @php
                            $sedulurTop = [
                                ['term' => 'Pembarep',  'desc' => 'Anak nomer siji (sulung)',  'step' => '#1', 'color' => '#16402E'],
                                ['term' => 'Penggulu',  'desc' => 'Anak nomer loro',           'step' => '#2', 'color' => '#1F523D'],
                                ['term' => 'Pandhadha', 'desc' => 'Anak nomer telu',           'step' => '#3', 'color' => '#2D6A4F'],
                            ];
                            $sedulurBottom = [
                                ['term' => 'Sumendhi',          'desc' => 'Kakang wuragil / sadurunge pungkasan', 'step' => 'N-1', 'color' => '#B45309'],
                                ['term' => 'Wuragil / waruju',  'desc' => 'Anak seng keri dhewe (bungsu)',       'step' => 'N',   'color' => '#C9A66B'],
                            ];
                        @endphp

                        <div class="d-flex flex-column align-items-center">
                            @foreach($sedulurTop as $i => $node)
                                @if($i > 0)
                                <div class="text-success fw-bold my-1" style="font-size: 0.95rem;">
                                    <i class="fa-solid fa-arrow-down"></i>
                                </div>
                                @endif
                                <div class="diagram-node rounded-4 p-3 shadow-xs text-center w-100" 
                                     style="background: #FFFFFF; border: 2px solid {{ $node['color'] }}; max-width: 290px;">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <span class="badge rounded-pill text-white px-2 py-0.5" style="background: {{ $node['color'] }}; font-size: 0.72rem;">{{ $node['step'] }}</span>
                                        <small class="text-muted" style="font-size: 0.7rem;">Urutan Jawa</small>
                                    </div>
                                    <div class="fw-bold fs-5" style="color: {{ $node['color'] }};">{{ $node['term'] }}</div>
                                    <div class="small text-muted mt-1" style="font-size: 0.8rem;">{{ $node['desc'] }}</div>
                                </div>
                            @endforeach

                            {{-- Garis Putus-putus Pemisah Sesuai Gambar PDF --}}
                            <div class="text-success fw-bold my-1" style="font-size: 0.95rem;">
                                <i class="fa-solid fa-arrow-down"></i>
                            </div>
                            <div class="my-2 py-1 text-center w-100" style="max-width: 290px;">
                                <div class="border-top border-2 border-dashed border-secondary opacity-50" style="margin: 0 auto;"></div>
                                <small class="text-muted fst-italic" style="font-size: 0.72rem;">(Garis pemisah sedulur tengah - pungkasan)</small>
                            </div>
                            <div class="text-success fw-bold my-1" style="font-size: 0.95rem;">
                                <i class="fa-solid fa-arrow-down"></i>
                            </div>

                            @foreach($sedulurBottom as $i => $node)
                                @if($i > 0)
                                <div class="text-success fw-bold my-1" style="font-size: 0.95rem;">
                                    <i class="fa-solid fa-arrow-down"></i>
                                </div>
                                @endif
                                <div class="diagram-node rounded-4 p-3 shadow-xs text-center w-100" 
                                     style="background: #FFFFFF; border: 2px solid {{ $node['color'] }}; max-width: 290px;">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <span class="badge rounded-pill text-white px-2 py-0.5" style="background: {{ $node['color'] }}; font-size: 0.72rem;">{{ $node['step'] }}</span>
                                        <small class="text-muted" style="font-size: 0.7rem;">Urutan Jawa</small>
                                    </div>
                                    <div class="fw-bold fs-5" style="color: {{ $node['color'] }};">{{ $node['term'] }}</div>
                                    <div class="small text-muted mt-1" style="font-size: 0.8rem;">{{ $node['desc'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif

    {{-- Grid Kartu Materi Kawruh Basa --}}
    @if($items->count() > 0)
    <div class="row g-3 g-md-4 mb-4">
        @foreach($items as $item)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden transition-all hover-translate-y"
                 style="background: #FFFFFF; border: 1px solid #E2E8F0 !important;">
                <div class="card-body p-3 p-sm-4 d-flex flex-column justify-content-between">
                    <div>
                        {{-- Header Kartu: Nomor ID & Tanggal --}}
                        <div class="d-flex align-items-center justify-content-between mb-2 pb-1">
                            <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(22, 64, 46, 0.08); color: #16402E; font-size: 0.76rem; font-weight: 700;">
                                #{{ $item->id }}
                            </span>
                            <span class="text-muted small" style="font-size: 0.75rem;">
                                {{ $item->created_at ? $item->created_at->format('d M Y') : '' }}
                            </span>
                        </div>

                        {{-- Istilah Jawa --}}
                        <h4 class="fw-bold mb-2 text-dark" style="color: #16402E !important; font-size: 1.25rem;">
                            {{ $item->javanese_term }}
                        </h4>

                        {{-- Arti / Tegese Bahasa Indonesia --}}
                        <div class="p-3 rounded-3 mt-3" style="background: #F8FAFC; border-left: 3px solid #C9A66B;">
                            <div class="text-muted small fw-semibold text-uppercase mb-1" style="font-size: 0.68rem; letter-spacing: 0.5px;">Tegese / Arti Indonesia:</div>
                            <p class="fw-semibold text-dark mb-0" style="font-size: 0.95rem; line-height: 1.45;">
                                {{ $item->indonesia_meaning }}
                            </p>
                        </div>
                    </div>

                    {{-- Footer Kartu: Aksi Guru & Admin --}}
                    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher()))
                    <div class="mt-4 pt-3 border-top d-flex justify-content-end align-items-center gap-2" style="border-color: #F1F5F9 !important;">
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1.5" 
                                style="font-size: 0.8rem;"
                                data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                        </button>
                        <form action="{{ route('teacher.kawruh-basa.destroy', ['category' => $activeCategory, 'id' => $item->id]) }}" 
                              method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus entri \'{{ $item->javanese_term }}\'?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1.5" style="font-size: 0.8rem;" title="Hapus Entri">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Modal Edit (Responsif untuk Pengajar/Admin) --}}
        @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher()))
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content rounded-4 border-0 shadow">
                    <form action="{{ route('teacher.kawruh-basa.update', ['category' => $activeCategory, 'id' => $item->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header border-0 pb-0 px-4 pt-4">
                            <h5 class="modal-title fw-bold" id="editModalLabel{{ $item->id }}" style="color: #16402E;">
                                <i class="fa-solid fa-pen-to-square me-2"></i>Edit Entri: {{ $item->javanese_term }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Istilah Jawa (javanese_term) <span class="text-danger">*</span></label>
                                <input type="text" name="javanese_term" class="form-control rounded-3" value="{{ $item->javanese_term }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Arti Indonesia (indonesia_meaning) <span class="text-danger">*</span></label>
                                <textarea name="indonesia_meaning" rows="3" class="form-control rounded-3" required>{{ $item->indonesia_meaning }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-4 pb-4">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: #16402E; border: none;">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @endforeach
    </div>

    {{-- Pagination Links (Responsif) --}}
    <div class="d-flex justify-content-center overflow-auto py-2">
        {{ $items->links() }}
    </div>
    @else
    <div class="card border-0 shadow-sm rounded-4 text-center p-4 p-sm-5 mb-4" style="background: #FFFFFF;">
        <div class="mb-3 text-muted">
            <i class="fa-solid fa-folder-open" style="font-size: 3.5rem; opacity: 0.35;"></i>
        </div>
        <h5 class="fw-bold text-dark">Data Tidak Ditemukan</h5>
        <p class="text-muted" style="max-width: 450px; margin: 0 auto; font-size: 0.92rem;">
            @if($search)
                Tidak ada entri pada kategori <strong>{{ $categoryMeta['name'] }}</strong> yang cocok dengan kata kunci "{{ $search }}". Silakan reset pencarian atau gunakan kata kunci lain.
            @else
                Belum ada entri data pada kategori {{ $categoryMeta['name'] }}.
            @endif
        </p>
        @if($search)
        <div class="mt-3">
            <a href="{{ route('kawruh-basa.index', ['category' => $activeCategory]) }}" class="btn btn-outline-secondary rounded-pill px-4 btn-sm">
                <i class="fa-solid fa-rotate-left me-1"></i> Reset Pencarian
            </a>
        </div>
        @endif
    </div>
    @endif
</div>

{{-- Modal Tambah Entri Baru (Responsif untuk Pengajar/Admin) --}}
@if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher()))
<div class="modal fade" id="createEntryModal" tabindex="-1" aria-labelledby="createEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route('teacher.kawruh-basa.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold" id="createEntryModalLabel" style="color: #16402E;">
                        <i class="fa-solid fa-circle-plus me-2"></i>Tambah Entri Kawruh Basa Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Kategori <span class="text-danger">*</span></label>
                        <select name="category" class="form-select rounded-3" required>
                            <optgroup label="🌱 TETUWUHAN (TUMBUHAN)">
                                @foreach(['arane_kembang', 'arane_pentil', 'arane_woh', 'arane_isi', 'arane_wit', 'arane_godhong'] as $k)
                                <option value="{{ $k }}" {{ $activeCategory === $k ? 'selected' : '' }}>
                                    {{ $categories[$k]['name'] }}
                                </option>
                                @endforeach
                            </optgroup>
                            <optgroup label="🐾 KEWAN (HEWAN)">
                                <option value="arane_anak_kewan" {{ $activeCategory === 'arane_anak_kewan' ? 'selected' : '' }}>
                                    {{ $categories['arane_anak_kewan']['name'] }}
                                </option>
                            </optgroup>
                            <optgroup label="👤 MANUNGSA (KEKERABATAN & CIRI)">
                                @foreach(['urutane_turunan', 'urutane_sedulur', 'prenah_sedulur', 'arane_wong', 'sebutane_bocah'] as $k)
                                <option value="{{ $k }}" {{ $activeCategory === $k ? 'selected' : '' }}>
                                    {{ $categories[$k]['name'] }}
                                </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Istilah Jawa (javanese_term) <span class="text-danger">*</span></label>
                        <input type="text" name="javanese_term" class="form-control rounded-3" placeholder="Contoh: Dangu / Cemeng" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Arti Indonesia (indonesia_meaning) <span class="text-danger">*</span></label>
                        <textarea name="indonesia_meaning" rows="3" class="form-control rounded-3" placeholder="Contoh: Kembang aren / Anak kucing" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: #16402E; border: none;">Simpan Entri</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
.hover-translate-y {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-translate-y:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(22, 64, 46, 0.08) !important;
}
.dropdown-menu .dropdown-item:hover {
    background-color: #F1F5F9;
}
.dropdown-menu .dropdown-item.active:hover {
    background-color: #16402E;
}
.diagram-node:hover {
    border-color: #16402E !important;
    background-color: #F0FDF4 !important;
}
</style>
@endsection

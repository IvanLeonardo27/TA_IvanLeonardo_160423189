@php
    $userVocabBookmarkIds = auth()->check() 
        ? \App\Models\Bookmark::where('user_id', auth()->id())
            ->where('bookmarkable_type', \App\Models\Vocabulary::class)
            ->pluck('bookmarkable_id')
            ->toArray() 
        : [];
@endphp

@forelse($vocabularies as $vocab)
@php $isBookmarked = in_array($vocab->id, $userVocabBookmarkIds); @endphp
<div class="col-12 vocab-card-item">
    <div class="card card-modern p-4 border-0 shadow-sm rounded-4 position-relative">
        @auth
        <button type="button" 
                onclick="toggleBookmarkCard('vocab', {{ $vocab->id }}, this)" 
                class="btn btn-sm p-0 border position-absolute top-0 end-0 m-3 z-3 d-flex align-items-center justify-content-center rounded-circle shadow-xs bg-white btn-bookmark-card" 
                style="width: 32px; height: 32px; transition: all 0.2s ease;" 
                title="{{ $isBookmarked ? 'Batal Simpan' : 'Simpan Bookmark' }}">
            <i class="{{ $isBookmarked ? 'fa-solid text-warning' : 'fa-regular text-secondary opacity-60' }} fa-bookmark" style="font-size: 0.88rem;"></i>
        </button>
        @endauth

        <div class="row align-items-center pe-md-4">
            {{-- Kata Utama (A-Z) --}}
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-primary rounded-circle text-white d-inline-flex align-items-center justify-content-center me-1 fw-bold" style="width:28px; height:28px; font-size: 0.85rem;">
                        {{ strtoupper(substr($vocab->indonesian_word, 0, 1)) }}
                    </span>
                    <h4 class="fw-bold text-main mb-0">{{ $vocab->indonesian_word }}</h4>
                </div>
                <span class="badge bg-soft-blue text-primary rounded-pill small me-1">Bahasa Indonesia</span>
                @if($vocab->categoryObj)
                <span class="badge bg-warning bg-opacity-20 text-dark rounded-pill small"><i class="fa-solid fa-tag me-1"></i>{{ $vocab->categoryObj->name }}</span>
                @elseif($vocab->category)
                <span class="badge bg-warning bg-opacity-20 text-dark rounded-pill small"><i class="fa-solid fa-tag me-1"></i>{{ $vocab->category }}</span>
                @endif
            </div>

            {{-- Padanan Jawa Ngoko & Krama --}}
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-semibold" style="width:110px;">Ngoko</span>
                        <span class="fs-5 fw-bold text-dark">{{ $vocab->javanese_ngoko ?? '-' }}</span>
                        <button class="btn btn-sm btn-light rounded-circle shadow-sm btn-speak ms-2"
                                data-text="{{ $vocab->javanese_ngoko }}" title="Dengar Suara Ngoko">
                            <i class="fa-solid fa-volume-high text-accent"></i>
                        </button>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary text-white rounded-pill px-3 py-1 fw-semibold" style="width:110px;">Krama</span>
                        <span class="fs-5 fw-bold text-primary">{{ $vocab->javanese_krama ?? '-' }}</span>
                        <button class="btn btn-sm btn-light rounded-circle shadow-sm btn-speak ms-2"
                                data-text="{{ $vocab->javanese_krama }}" title="Dengar Suara Krama">
                            <i class="fa-solid fa-volume-high text-primary"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Tombol Toggle Contoh --}}
            <div class="col-md-2 text-md-end">
                <button class="btn btn-outline-primary btn-bouncy rounded-pill px-3 py-2 w-100 btn-toggle-example"
                        type="button" data-bs-toggle="collapse" data-bs-target="#example-{{ $vocab->id }}">
                    <i class="fa-solid fa-book-open me-1"></i> Contoh
                </button>
            </div>
        </div>

        {{-- Collapsible Contoh Penggunaan --}}
        <div class="collapse mt-4 pt-3 border-top" id="example-{{ $vocab->id }}">
            <h6 class="fw-bold text-main mb-3"><i class="fa-solid fa-lightbulb text-warning me-2"></i>Contoh Penggunaan Kalimat</h6>
            @forelse($vocab->examples as $index => $example)
            <div class="row g-3 @if(!$loop->first) mt-2 pt-2 border-top border-dashed @endif">
                {{-- Indonesia --}}
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-4 h-100 position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="fw-semibold text-muted">Bahasa Indonesia @if($vocab->examples->count() > 1) #{{ $index + 1 }} @endif</small>
                            @if(!empty($example->indonesian_sentence))
                            <button class="btn btn-sm btn-white rounded-circle shadow-sm btn-speak p-0 d-flex align-items-center justify-content-center"
                                    style="width:28px; height:28px;"
                                    data-text="{{ $example->indonesian_sentence }}" title="Dengar Kalimat Indonesia">
                                <i class="fa-solid fa-volume-high text-muted" style="font-size: 0.75rem;"></i>
                            </button>
                            @endif
                        </div>
                        <p class="mb-0 text-dark small fw-semibold">{{ $example->indonesian_sentence ?? '-' }}</p>
                    </div>
                </div>

                {{-- Ngoko --}}
                <div class="col-md-4">
                    <div class="p-3 bg-success bg-opacity-10 rounded-4 h-100 position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="fw-semibold text-success">Bahasa Jawa Ngoko</small>
                            @php $ngokoText = $example->ngoko_sentence ?? $example->javanese_sentence; @endphp
                            @if(!empty($ngokoText))
                            <button class="btn btn-sm btn-white rounded-circle shadow-sm btn-speak p-0 d-flex align-items-center justify-content-center ms-1"
                                    style="width:28px; height:28px;"
                                    data-text="{{ $ngokoText }}" title="Dengar Kalimat Ngoko">
                                <i class="fa-solid fa-volume-high text-success" style="font-size: 0.75rem;"></i>
                            </button>
                            @endif
                        </div>
                        <p class="mb-0 text-dark small fw-semibold">{{ $ngokoText ?? '-' }}</p>
                    </div>
                </div>

                {{-- Krama --}}
                <div class="col-md-4">
                    <div class="p-3 bg-primary text-white rounded-4 h-100 position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="fw-semibold text-white-50">Bahasa Jawa Krama</small>
                            @if(!empty($example->krama_sentence))
                            <button class="btn btn-sm btn-light rounded-circle shadow-sm btn-speak p-0 d-flex align-items-center justify-content-center ms-1"
                                    style="width:28px; height:28px;"
                                    data-text="{{ $example->krama_sentence }}" title="Dengar Kalimat Krama">
                                <i class="fa-solid fa-volume-high text-primary" style="font-size: 0.75rem;"></i>
                            </button>
                            @endif
                        </div>
                        <p class="mb-0 text-white small fw-semibold">{{ $example->krama_sentence ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted small mb-0">Belum ada contoh penggunaan kalimat untuk kata ini.</p>
            @endforelse
        </div>

        @if(auth()->check() && auth()->user()->isAdmin())
        @php
            if (!isset($allCategoriesList)) {
                $allCategoriesList = \App\Models\VocabularyCategory::orderBy('name')->get();
            }
        @endphp
        <div class="d-flex gap-2 mt-3 pt-3 border-top justify-content-end align-items-center">
            <small class="text-muted fw-bold me-auto"><i class="fa-solid fa-shield-halved text-primary me-1"></i> Kontrol Admin:</small>
            <button type="button" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold shadow-xs text-dark" data-bs-toggle="modal" data-bs-target="#editVocabModal{{ $vocab->id }}">
                <i class="fa-solid fa-pen-to-square me-1"></i> Edit Kosakata
            </button>
            <form action="{{ route('kosakata.destroy', $vocab) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kosakata \'{{ $vocab->indonesian_word }}\'?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold shadow-xs">
                    <i class="fa-solid fa-trash me-1"></i> Hapus
                </button>
            </form>
        </div>

        {{-- Modal Edit Kosakata untuk Admin --}}
        <div class="modal fade" id="editVocabModal{{ $vocab->id }}" tabindex="-1" aria-labelledby="editVocabModalLabel{{ $vocab->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden text-start">
                    <div class="modal-header p-4" style="background: linear-gradient(135deg, #16402E 0%, #1F523D 100%); color: #ffffff;">
                        <h5 class="modal-title fw-bold text-white" id="editVocabModalLabel{{ $vocab->id }}">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Edit Kosakata: {{ $vocab->indonesian_word }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('kosakata.update', $vocab) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body p-4">
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Bahasa Indonesia <span class="text-danger">*</span></label>
                                    <input type="text" name="indonesian_word" class="form-control rounded-3" value="{{ $vocab->indonesian_word }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Jawa Ngoko <span class="text-danger">*</span></label>
                                    <input type="text" name="javanese_ngoko" class="form-control rounded-3" value="{{ $vocab->javanese_ngoko }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Jawa Krama <span class="text-danger">*</span></label>
                                    <input type="text" name="javanese_krama" class="form-control rounded-3" value="{{ $vocab->javanese_krama }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Kategori Kosakata</label>
                                    <select name="category_id" class="form-select rounded-3">
                                        <option value="">-- Tanpa Kategori --</option>
                                        @foreach($allCategoriesList as $catItem)
                                        <option value="{{ $catItem->id }}" {{ $vocab->category_id == $catItem->id ? 'selected' : '' }}>
                                            {{ $catItem->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <h6 class="fw-bold text-dark mb-2 pb-1 border-bottom">Contoh Kalimat Penggunaan</h6>
                            @php $firstEx = $vocab->examples->first(); @endphp
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Kalimat Bahasa Indonesia</label>
                                    <textarea name="example_indonesian" class="form-control rounded-3" rows="2">{{ $firstEx->indonesian_sentence ?? '' }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Kalimat Jawa Ngoko</label>
                                    <textarea name="example_ngoko" class="form-control rounded-3" rows="2">{{ $firstEx->ngoko_sentence ?? ($firstEx->javanese_sentence ?? '') }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Kalimat Jawa Krama</label>
                                    <textarea name="example_krama" class="form-control rounded-3" rows="2">{{ $firstEx->krama_sentence ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light p-3">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold" style="background:#16402E; border:none;">
                                <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@empty
<div class="text-center py-5">
    <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_q7uarxsb.json" background="transparent" speed="1" style="width:150px;height:150px;margin:0 auto;" loop autoplay></lottie-player>
    <h5 class="fw-bold text-main mt-3">Kosakata Tidak Ditemukan</h5>
    <p class="text-muted">Coba ketik kata lain atau reset filter kategori.</p>
</div>
@endforelse

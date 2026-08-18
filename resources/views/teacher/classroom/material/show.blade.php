@extends('layouts.app')

@section('title', 'Materi: ' . ($post->title ?? 'Pembelajaran') . ' - ' . $classroom->name)

@section('content')
<div class="container-fluid py-4" style="max-width: 1100px;">
    {{-- Header & Navigasi Kembali --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <a href="{{ route('teacher.classroom.show', $classroom) }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 btn-sm fw-semibold shadow-xs">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Kelas
        </a>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary rounded-pill px-3 py-1.5 fw-bold"><i class="fa-solid fa-book-open me-1"></i> Pratinjau Materi Pengajar</span>
            <span class="badge bg-light text-muted border rounded-pill px-3 py-1.5">{{ $classroom->name }}</span>
        </div>
    </div>

    @php
        $slidesList       = $post->slides;
        $totalSlides      = count($slidesList);
        $checkpointSlide  = $post->checkpoint_slide;
        $checkpointQ      = $post->checkpoint_question;
        $firstAtt         = $post->attachments->first();
        $isPdf            = $firstAtt && str_ends_with(strtolower($firstAtt->file_path), '.pdf');
    @endphp

    {{-- Kartu Utama Materi Pembelajaran --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="background:#ffffff; border:1px solid #E2E8F0 !important;">
        <div class="card-body p-4 p-md-5">
            {{-- Info Materi --}}
            <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4 pb-3 border-bottom">
                <div>
                    <h3 class="fw-bold text-main mb-2">{{ $post->title ?? 'Materi Pembelajaran' }}</h3>
                    <div class="d-flex align-items-center gap-3 text-muted small flex-wrap">
                        <span><i class="fa-solid fa-user-tie text-primary me-1"></i> {{ $post->author->name }}</span>
                        <span><i class="fa-solid fa-clock me-1"></i> {{ $post->created_at->diffForHumans() }}</span>
                        @if($checkpointQ && $checkpointSlide > 0)
                        <span class="badge bg-primary-subtle text-primary border rounded-pill px-2.5 py-1">
                            <i class="fa-solid fa-lock me-1"></i> Checkpoint Halaman {{ $checkpointSlide }}
                        </span>
                        @endif
                    </div>
                </div>
                @if($firstAtt)
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary rounded-pill px-3 py-2 btn-sm fw-semibold shadow-xs"
                            onclick="previewFile('{{ asset('storage/' . $firstAtt->file_path) }}', '{{ addslashes($firstAtt->original_name) }}', '{{ $firstAtt->file_size_human }}', '{{ $isPdf ? 'fa-file-pdf' : 'fa-file-powerpoint' }}', '{{ route('attachment.download', $firstAtt) }}')">
                        <i class="fa-solid fa-expand me-1"></i> Layar Penuh
                    </button>
                    <a href="{{ route('attachment.download', $firstAtt) }}" class="btn btn-danger rounded-pill px-3 py-2 btn-sm fw-semibold text-white shadow-xs">
                        <i class="fa-solid fa-download me-1"></i> Unduh PDF
                    </a>
                </div>
                @endif
            </div>

            @if($post->body && !str_starts_with(trim($post->body), '{'))
            <div class="p-3 bg-light rounded-4 border mb-4 text-main" style="line-height:1.7;">
                {{ $post->body }}
            </div>
            @endif

            {{-- Coursera Style Slide Reader Deck --}}
            @if($totalSlides > 0)
            <div class="slide-reader-deck card border-0 rounded-4 overflow-hidden shadow-sm" id="slideDeck-{{ $post->id }}"
                 data-deck-id="{{ $post->id }}"
                 data-total="{{ $totalSlides }}"
                 data-checkpoint-slide="{{ $checkpointSlide }}"
                 data-correct-index="{{ $checkpointQ ? $checkpointQ->correct_index : -1 }}"
                 data-pdf-url="{{ $isPdf ? asset('storage/' . $firstAtt->file_path) : '' }}"
                 style="background:#F8FAFC; border:1.5px solid #E2E8F0 !important;">
                
                {{-- Slide Reader Header --}}
                <div class="bg-white px-4 py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary text-white rounded-pill px-3 py-1.5 fw-bold slide-counter-badge">
                            Slide <span class="current-slide-num">1</span> / {{ $totalSlides }}
                        </span>
                        <span class="fw-bold text-main small current-slide-title">{{ $slidesList[0]['title'] ?? 'Halaman 1' }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        @if($checkpointQ && $checkpointSlide > 0)
                        <span class="badge bg-primary-subtle text-primary border rounded-pill px-2.5 py-1 small" title="Pertanyaan Checkpoint di Slide {{ $checkpointSlide }}">
                            <i class="fa-solid fa-lock me-1"></i> Checkpoint Halaman {{ $checkpointSlide }}
                        </span>
                        @endif
                        <div class="progress rounded-pill bg-light" style="width:140px; height:8px;">
                            <div class="progress-bar bg-primary rounded-pill slide-progress-bar" style="width: {{ (1 / $totalSlides) * 100 }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Canvas Area --}}
                <div class="p-3 p-md-4 slide-canvas-area position-relative" style="min-height:300px;">
                    @if($isPdf)
                        <div class="rounded-4 overflow-hidden border shadow-sm position-relative d-flex align-items-center justify-content-center"
                             style="min-height:540px; background:#334155 !important;">
                            <div id="pdfLoading-{{ $post->id }}" class="text-center p-4 text-white">
                                <div class="spinner-border text-primary mb-2" role="status"></div>
                                <p class="small mb-0 text-white-50">Memuat halaman PDF materi...</p>
                            </div>
                            <canvas id="pdfCanvas-{{ $post->id }}" class="d-none shadow rounded-3 my-2" style="max-width:100%; height:auto; display:block;"></canvas>
                        </div>
                    @else
                        @foreach($slidesList as $sIdx => $slide)
                        <div class="slide-content-item {{ $sIdx === 0 ? '' : 'd-none' }}" data-slide-index="{{ $sIdx }}">
                            @if(!empty($slide['title']))
                            <h5 class="fw-bold text-primary mb-3">{{ $slide['title'] }}</h5>
                            @endif
                            <div class="text-main p-4 bg-white rounded-4 border shadow-sm" style="font-size:1.05rem; line-height:1.8; white-space:pre-line;">{{ $slide['content'] }}</div>
                        </div>
                        @endforeach
                    @endif
                </div>

                {{-- Slide Navigation Footer --}}
                <div class="bg-white px-4 py-3 border-top d-flex align-items-center justify-content-between">
                    <button type="button" class="btn btn-light rounded-pill px-4 py-2 fw-semibold text-muted prev-slide-btn" disabled>
                        <i class="fa-solid fa-chevron-left me-1"></i> Sebelumnya
                    </button>

                    {{-- Dots --}}
                    <div class="d-flex gap-1.5 align-items-center slide-dots-container">
                        @for($d=0; $d < min(15, $totalSlides); $d++)
                        <span class="rounded-pill slide-dot {{ $d === 0 ? 'active' : '' }}"
                              style="width:{{ $d === 0 ? '22px' : '8px' }}; height:8px; background:{{ $d === 0 ? '#3B82F6' : '#CBD5E1' }}; transition:.3s;"></span>
                        @endfor
                    </div>

                    <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-bold btn-bouncy next-slide-btn">
                        <span class="next-btn-text">Selanjutnya</span> <i class="fa-solid fa-chevron-right ms-1 next-btn-icon"></i>
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Forum Diskusi Materi --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 mt-4" style="background:#ffffff; border:1px solid #E2E8F0 !important;">
        <h6 class="fw-bold text-main mb-3 d-flex align-items-center gap-2">
            <i class="fa-solid fa-comments text-primary"></i> Diskusi & Pertanyaan Materi ({{ $post->comments->count() }})
        </h6>

        <form action="{{ route('classroom.comment.store', $post) }}" method="POST" class="d-flex gap-2 align-items-center mb-4">
            @csrf
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=36" class="rounded-circle" width="36" height="36" style="flex-shrink:0;">
            <input type="text" name="comment" class="form-control rounded-pill border-0 bg-light px-4 py-2.5" placeholder="Tuliskan balasan atau catatan untuk siswa..." required>
            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold btn-bouncy shadow-sm d-flex align-items-center gap-1.5" style="height:44px;">
                <i class="fa-solid fa-paper-plane fa-xs"></i> <span>Kirim</span>
            </button>
        </form>

        <div class="d-flex flex-column gap-3">
            @forelse($post->comments as $comment)
            <div class="p-3 rounded-4 bg-light border d-flex align-items-start gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&size=36" class="rounded-circle mt-0.5" width="36" height="36" style="flex-shrink:0;">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="fw-bold small text-main">{{ $comment->user->name }}</span>
                        <div class="d-flex align-items-center gap-2">
                            <small class="text-muted" style="font-size:0.75rem;">{{ $comment->created_at->diffForHumans() }}</small>
                            @if($comment->user_id === auth()->id() || $classroom->teacher_id === auth()->id())
                            <form action="{{ route('classroom.comment.destroy', $comment) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0 ms-1" style="font-size:0.75rem;" title="Hapus komentar" onclick="return confirm('Hapus komentar ini?')">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    <p class="mb-0 small text-main" style="line-height:1.5;">{{ $comment->comment }}</p>
                </div>
            </div>
            @empty
            <p class="text-muted small text-center py-3 mb-0">Belum ada diskusi untuk materi ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deck = document.getElementById('slideDeck-{{ $post->id }}');
    if (!deck) return;

    const deckId          = deck.dataset.deckId;
    const totalSlides     = parseInt(deck.dataset.total) || 1;
    let currentSlideIdx   = 0;

    const slideItems      = deck.querySelectorAll('.slide-content-item');
    const prevBtn         = deck.querySelector('.prev-slide-btn');
    const nextBtn         = deck.querySelector('.next-slide-btn');
    const nextBtnText     = deck.querySelector('.next-btn-text');
    const nextBtnIcon     = deck.querySelector('.next-btn-icon');
    const numBadge        = deck.querySelector('.current-slide-num');
    const titleBadge      = deck.querySelector('.current-slide-title');
    const progressBar     = deck.querySelector('.slide-progress-bar');
    const dots            = deck.querySelectorAll('.slide-dot');
    const pdfCanvas       = deck.querySelector('#pdfCanvas-' + deckId);
    const pdfLoading      = deck.querySelector('#pdfLoading-' + deckId);
    const pdfUrl          = deck.dataset.pdfUrl;

    let pdfDocInstance = null;
    let isRendering = false;
    let pageNumPending = null;

    function renderPdfPage(num) {
        if (!pdfDocInstance || !pdfCanvas) return;
        isRendering = true;
        pdfDocInstance.getPage(num).then(function(page) {
            const ctx = pdfCanvas.getContext('2d');
            const canvasArea = deck.querySelector('.slide-canvas-area');
            const availableWidth = Math.min((canvasArea ? canvasArea.clientWidth : 800) - 30, 950) || 780;
            const unscaledViewport = page.getViewport({ scale: 1 });
            const scale = (availableWidth / unscaledViewport.width) * 1.5;
            const viewport = page.getViewport({ scale: scale });

            pdfCanvas.height = viewport.height;
            pdfCanvas.width  = viewport.width;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            page.render(renderContext).promise.then(function() {
                isRendering = false;
                if (pageNumPending !== null) {
                    renderPdfPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });
    }

    function queueRenderPdfPage(num) {
        if (isRendering) {
            pageNumPending = num;
        } else {
            renderPdfPage(num);
        }
    }

    if (pdfUrl && window.pdfjsLib && pdfCanvas) {
        pdfjsLib.getDocument(pdfUrl).promise.then(function(doc) {
            pdfDocInstance = doc;
            if (pdfLoading) pdfLoading.classList.add('d-none');
            if (pdfCanvas) pdfCanvas.classList.remove('d-none');
            renderPdfPage(currentSlideIdx + 1);
        }).catch(function(e) {
            console.error("PDF load error:", e);
            if (pdfLoading) pdfLoading.innerHTML = '<p class="text-white-50 small mb-0">Gunakan tombol Layar Penuh / Unduh File untuk membuka dokumen.</p>';
        });
    }

    function updateDeckUI(idx) {
        currentSlideIdx = idx;

        if (pdfDocInstance) {
            queueRenderPdfPage(idx + 1);
        }

        slideItems.forEach((item, sIdx) => {
            item.classList.toggle('d-none', sIdx !== idx);
        });

        if (numBadge) numBadge.textContent = idx + 1;
        if (titleBadge) titleBadge.textContent = `Halaman ${idx + 1}`;

        const progressPct = ((idx + 1) / totalSlides) * 100;
        if (progressBar) progressBar.style.width = `${progressPct}%`;

        if (dots) {
            dots.forEach((dot, dIdx) => {
                if (dIdx === idx) {
                    dot.style.width = '22px';
                    dot.style.background = '#3B82F6';
                } else {
                    dot.style.width = '8px';
                    dot.style.background = '#CBD5E1';
                }
            });
        }

        if (prevBtn) prevBtn.disabled = (idx === 0);

        if (idx === totalSlides - 1) {
            if (nextBtnText) nextBtnText.textContent = 'Selesai';
            if (nextBtnIcon) nextBtnIcon.className = 'fa-solid fa-check ms-1';
        } else {
            if (nextBtnText) nextBtnText.textContent = 'Selanjutnya';
            if (nextBtnIcon) nextBtnIcon.className = 'fa-solid fa-chevron-right ms-1';
        }
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            if (currentSlideIdx > 0) updateDeckUI(currentSlideIdx - 1);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (currentSlideIdx < totalSlides - 1) {
                updateDeckUI(currentSlideIdx + 1);
            }
        });
    }

    updateDeckUI(0);
});
</script>
@endpush

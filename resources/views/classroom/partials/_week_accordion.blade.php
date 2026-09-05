@php
    $postsByWeek = $posts->groupBy(function($post) {
        return $post->calculated_week_number;
    });

    $customTitles = $classroom->week_titles ?? [];
    $maxCustomWeek = count($customTitles) > 0 ? max(array_keys($customTitles)) : 0;
    $maxPostWeek = $postsByWeek->keys()->max() ?? 0;
    $maxWeekCount = $maxCustomWeek > 0 ? max(1, $maxCustomWeek, $maxPostWeek) : max(4, $maxPostWeek);
    $isTeacher = auth()->user()->isTeacher() || auth()->user()->isAdmin();
@endphp

<style>
.hover-bg-danger:hover {
    background-color: #FEE2E2 !important;
    border-color: #FCA5A5 !important;
    color: #DC2626 !important;
}
</style>

<div class="accordion basakula-course-accordion mb-4" id="courseWeeksAccordion">
    {{-- GENERAL SECTION (WEEK 0 - HANYA TAMPIL JIKA ADA POSTINGAN UTAMA/PENGUMUMAN Awal) --}}
    @php 
        $generalPosts = $postsByWeek->get(0, collect()); 
        $hasCustomGeneralTitle = isset($customTitles[0]) && !empty(trim($customTitles[0]));
    @endphp
    @if($generalPosts->count() > 0 || $hasCustomGeneralTitle)
    <div class="accordion-item border-0 shadow-sm rounded-4 mb-3 overflow-hidden" style="border: 1px solid #E2E8F0 !important;">
        <h2 class="accordion-header" id="headingWeek0">
            <button class="accordion-button rounded-4 bg-white py-3.5 px-4 fw-bold text-dark d-flex align-items-center justify-content-between" 
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseWeek0" aria-expanded="true">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" style="width:36px; height:36px; background-color: #DCFCE7; color: #15803D;">
                        <i class="fa-solid fa-bullhorn fs-6"></i>
                    </div>
                    <span class="fs-6 fw-bold" style="color: #16402E;">{{ $classroom->getWeekTitle(0) }}</span>
                </div>
                @if($isTeacher)
                <span class="btn btn-sm btn-light border rounded-pill text-dark ms-auto me-3 px-3 py-1 fw-semibold shadow-xs" 
                      style="font-size: 0.78rem;"
                      onclick="event.stopPropagation(); openEditWeekTitleModal(0, '{{ addslashes($classroom->getWeekTitle(0)) }}')">
                    <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Edit Judul Header
                </span>
                @endif
            </button>
        </h2>
        <div id="collapseWeek0" class="accordion-collapse collapse show" data-bs-parent="#courseWeeksAccordion">
            <div class="accordion-body p-4 bg-white border-top">
                @include('classroom.partials._week_posts_list', ['posts' => $generalPosts])

                @if($isTeacher)
                <div class="mt-4 pt-2 text-center position-relative d-flex align-items-center justify-content-center">
                    <div class="position-absolute w-100 border-top" style="border-color: #E2E8F0; z-index: 1;"></div>
                    <a href="{{ route('teacher.classroom.post.create', [$classroom, 'week' => 0]) }}" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1.5 bg-white shadow-xs fw-semibold position-relative d-inline-flex align-items-center gap-2 hover-elevate transition" 
                       style="z-index: 2; border-color: #CBD5E1; color: #1E293B; font-size: 0.8rem;"
                       title="Tambahkan konten di Pengumuman Umum">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width: 20px; height: 20px;">
                            <i class="fa-solid fa-plus" style="font-size: 0.65rem;"></i>
                        </div>
                        <span>Tambah Pengumuman / Konten Umum</span>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- WEEK 1 HINGGA WEEK MAX --}}
    @for($w = 1; $w <= $maxWeekCount; $w++)
        @php
            $weekPosts = $postsByWeek->get($w, collect());
            $customTitle = $classroom->week_titles[$w] ?? null;
            $rawTitle = trim($customTitle ?? '');
            $displayHeaderTitle = !empty($rawTitle) ? "Week {$w} - {$rawTitle}" : "Week {$w}";
            $isExpanded = $w === 1;
        @endphp
        <div class="accordion-item border-0 shadow-sm rounded-4 mb-3 overflow-hidden" style="border: 1px solid #E2E8F0 !important;">
            <h2 class="accordion-header" id="headingWeek{{ $w }}">
                <button class="accordion-button {{ $isExpanded ? '' : 'collapsed' }} rounded-4 bg-white py-3.5 px-4 fw-bold text-dark d-flex align-items-center justify-content-between" 
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseWeek{{ $w }}" aria-expanded="{{ $isExpanded ? 'true' : 'false' }}">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" style="width:36px; height:36px; background-color: #E0F2FE; color: #0284C7;">
                            <i class="fa-solid fa-calendar-week fs-6"></i>
                        </div>
                        <span class="fs-6 fw-bold" style="color: #16402E;">{{ $displayHeaderTitle }}</span>
                    </div>
                    @if($isTeacher)
                    <div class="d-flex align-items-center gap-2 ms-auto me-3">
                        <span class="btn btn-sm btn-light border rounded-pill text-dark px-3 py-1 fw-semibold shadow-xs" 
                              style="font-size: 0.78rem;"
                              onclick="event.stopPropagation(); openEditWeekTitleModal({{ $w }}, '{{ addslashes($rawTitle) }}')">
                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Edit Judul Header
                        </span>

                        <span class="btn btn-sm btn-light border rounded-circle text-danger p-0 d-inline-flex align-items-center justify-content-center shadow-xs hover-bg-danger"
                              style="width: 29px; height: 29px; cursor: pointer; transition: all 0.2s;"
                              title="Hapus Week {{ $w }} Beserta Seluruh Isinya"
                              onclick="event.stopPropagation(); confirmDeleteWeek({{ $w }})">
                            <i class="fa-solid fa-trash" style="font-size: 0.72rem;"></i>
                        </span>
                    </div>
                    @endif
                </button>
            </h2>
            <div id="collapseWeek{{ $w }}" class="accordion-collapse collapse {{ $isExpanded ? 'show' : '' }}" data-bs-parent="#courseWeeksAccordion">
                <div class="accordion-body p-4 bg-white border-top">
                    @include('classroom.partials._week_posts_list', ['posts' => $weekPosts, 'weekNumber' => $w])

                    @if($isTeacher)
                    <div class="mt-4 pt-2 text-center position-relative d-flex align-items-center justify-content-center">
                        <div class="position-absolute w-100 border-top" style="border-color: #E2E8F0; z-index: 1;"></div>
                        <a href="{{ route('teacher.classroom.post.create', [$classroom, 'week' => $w]) }}" 
                           class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1.5 bg-white shadow-xs fw-semibold position-relative d-inline-flex align-items-center gap-2 hover-elevate transition" 
                           style="z-index: 2; border-color: #CBD5E1; color: #1E293B; font-size: 0.8rem;"
                           title="Tambahkan aktivitas atau materi di Week {{ $w }}">
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width: 20px; height: 20px;">
                                <i class="fa-solid fa-plus" style="font-size: 0.65rem;"></i>
                            </div>
                            <span>Tambah Materi / Aktivitas di Week {{ $w }}</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endfor
</div>

@if($isTeacher)
{{-- TOMBOL TAMBAH MINGGU MANUAL --}}
<div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden" style="border: 1.5px dashed #CBD5E1 !important;">
    <div class="card-body p-3.5 d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" style="width: 44px; height: 44px; background: #F0FDF4; color: #15803D;">
                <i class="fa-solid fa-calendar-plus fs-5"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">Perluas Kurikulum Pembelajaran</h6>
                <small class="text-muted">Tambahkan minggu baru (Week {{ $maxWeekCount + 1 }}) secara manual untuk menyusun silabus pembelajaran berikutnya.</small>
            </div>
        </div>
        <form action="{{ route('teacher.classroom.week.add', $classroom) }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-xs btn-bouncy d-inline-flex align-items-center gap-2">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Minggu Baru (Add Week)</span>
            </button>
        </form>
    </div>
</div>
@endif

@if($isTeacher)
{{-- Form Global untuk Hapus Week (Disimpan di luar akordion agar tidak merusak HTML button) --}}
<form id="deleteWeekFormGlobal" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
function openEditWeekTitleModal(weekNum, currentTitle) {
    document.getElementById('modalWeekNumberInput').value = weekNum;
    document.getElementById('modalWeekTitleInput').value = currentTitle;
    const modalElement = document.getElementById('editWeekTitleModal');
    if (modalElement) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        modal.show();
    }
}

function confirmDeleteWeek(weekNum) {
    if (confirm('Apakah Anda yakin ingin menghapus Week ' + weekNum + ' beserta seluruh materi dan postingan di dalamnya secara langsung?')) {
        const form = document.getElementById('deleteWeekFormGlobal');
        form.action = "{{ url('teacher/classroom/' . $classroom->id . '/weeks') }}/" + weekNum;
        form.submit();
    }
}
</script>
@endpush
@endif

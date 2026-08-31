@php
    $postsByWeek = $posts->groupBy(function($post) {
        return $post->calculated_week_number;
    });

    $customTitles = $classroom->week_titles ?? [];
    $maxCustomWeek = count($customTitles) > 0 ? max(array_keys($customTitles)) : 0;
    $maxPostWeek = $postsByWeek->keys()->max() ?? 0;
    $maxWeekCount = max(4, $maxCustomWeek, $maxPostWeek);
    $isTeacher = auth()->user()->isTeacher();
@endphp

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
                    <span class="btn btn-sm btn-light border rounded-pill text-dark ms-auto me-3 px-3 py-1 fw-semibold shadow-xs" 
                          style="font-size: 0.78rem;"
                          onclick="event.stopPropagation(); openEditWeekTitleModal({{ $w }}, '{{ addslashes($rawTitle) }}')">
                        <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Edit Judul Header
                    </span>
                    @endif
                </button>
            </h2>
            <div id="collapseWeek{{ $w }}" class="accordion-collapse collapse {{ $isExpanded ? 'show' : '' }}" data-bs-parent="#courseWeeksAccordion">
                <div class="accordion-body p-4 bg-white border-top">
                    @include('classroom.partials._week_posts_list', ['posts' => $weekPosts, 'weekNumber' => $w])
                </div>
            </div>
        </div>
    @endfor
</div>

@if($isTeacher)
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
</script>
@endpush
@endif

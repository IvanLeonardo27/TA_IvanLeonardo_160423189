@if($posts->isEmpty())
    <div class="text-center py-4 px-3 bg-light rounded-4 border border-dashed text-muted">
        <i class="fa-solid fa-folder-open fs-3 opacity-50 mb-2"></i>
        <p class="small mb-0 fw-semibold">Belum ada materi, tugas, atau quiz di minggu ini.</p>
    </div>
@else
    <div class="d-flex flex-column gap-2.5">
        @foreach($posts as $post)
            @php
                $isTeacherUser = auth()->check() && (auth()->user()->isTeacher() || auth()->user()->isAdmin());

                $style = match($post->type) {
                    'material'     => ['bg' => '#FEE2E2', 'color' => '#DC2626', 'icon' => 'fa-file-pdf', 'label' => 'Materi Belajar', 'badge' => 'bg-danger-subtle text-danger border-danger'],
                    'assignment'   => ['bg' => '#FEF3C7', 'color' => '#D97706', 'icon' => 'fa-file-signature', 'label' => 'Tugas', 'badge' => 'bg-warning-subtle text-warning-emphasis border-warning'],
                    'quiz'         => ['bg' => '#DCFCE7', 'color' => '#15803D', 'icon' => 'fa-circle-question', 'label' => 'Evaluasi / Quiz', 'badge' => 'bg-success-subtle text-success border-success'],
                    'url'          => ['bg' => '#E0F2FE', 'color' => '#0284C7', 'icon' => 'fa-link', 'label' => 'Tautan URL', 'badge' => 'bg-info-subtle text-info border-info'],
                    'announcement' => ['bg' => '#E0F2FE', 'color' => '#0284C7', 'icon' => 'fa-bullhorn', 'label' => 'Pengumuman', 'badge' => 'bg-info-subtle text-info-emphasis border-info'],
                    default        => ['bg' => '#F1F5F9', 'color' => '#475569', 'icon' => 'fa-file', 'label' => 'Post', 'badge' => 'bg-secondary-subtle text-secondary border-secondary']
                };

                // URL aksi berdasarkan role & tipe
                $targetUrl = '#';
                if ($post->type === 'material') {
                    $targetUrl = $isTeacherUser
                        ? route('teacher.classroom.material.show', [$post->classroom_id, $post->id])
                        : route('student.classroom.material.show', [$post->classroom_id, $post->id]);
                } elseif ($post->type === 'assignment' && $post->assignment) {
                    $targetUrl = route('student.classroom.submission.show', $post->assignment->id);
                } elseif ($post->type === 'quiz' && $post->quiz) {
                    $targetUrl = $isTeacherUser
                        ? route('teacher.classroom.quiz.preview_submissions', $post->quiz->id)
                        : route('student.classroom.quiz.show', $post->quiz->id);
                } elseif ($post->type === 'url') {
                    $targetUrl = $post->link_url ?: '#';
                }

                // Pembersihan deskripsi jika mengandung JSON raw
                $bodyPreview = '';
                if (!empty($post->body)) {
                    $trimmedBody = trim($post->body);
                    if (str_starts_with($trimmedBody, '{') || str_starts_with($trimmedBody, '[')) {
                        $json = json_decode($trimmedBody, true);
                        if (is_array($json)) {
                            if (!empty($json['plain_summary'])) {
                                $bodyPreview = $json['plain_summary'];
                            } elseif (!empty($json['summary'])) {
                                $bodyPreview = $json['summary'];
                            }
                        }
                    } else {
                        $bodyPreview = strip_tags($trimmedBody);
                    }
                }
            @endphp

            <div class="card border-0 shadow-sm rounded-4 bg-white hover-elevate transition" style="border: 1px solid #E2E8F0 !important; padding: 1.25rem 1.5rem !important;">
                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                    <div class="d-flex align-items-center gap-3 overflow-hidden">
                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                             style="width: 44px; height: 44px; background-color: {{ $style['bg'] }}; color: {{ $style['color'] }};">
                            <i class="fa-solid {{ $style['icon'] }} fs-5"></i>
                        </div>

                        <div class="overflow-hidden">
                            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                <span class="badge rounded-pill px-2.5 py-0.5 fw-semibold border {{ $style['badge'] }}" style="font-size: 0.7rem;">
                                    {{ $style['label'] }}
                                </span>
                                @if($isTeacherUser && !$post->is_published)
                                    <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-2.5 py-0.5 fw-semibold" style="font-size: 0.7rem;">
                                        Hidden from students
                                    </span>
                                @endif
                                <small class="text-muted" style="font-size: 0.72rem;">
                                    <i class="fa-regular fa-clock me-1 opacity-75"></i>{{ $post->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>

                            @if($isTeacherUser && $post->type === 'assignment' && $post->assignment)
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#submissionModal{{ $post->assignment->id }}" class="fw-bold text-dark text-decoration-none text-truncate d-block" style="font-size: 0.95rem;">
                                    {{ $post->title ?: 'Tugas Tanpa Judul' }}
                                </a>
                            @else
                                <a href="{{ $targetUrl }}" {{ $post->type === 'url' ? 'target="_blank" rel="noopener noreferrer"' : '' }} class="fw-bold text-dark text-decoration-none text-truncate d-block" style="font-size: 0.95rem;">
                                    {{ $post->title ?: 'Dokumen / Post Tanpa Judul' }}
                                    @if($post->type === 'url')
                                        <i class="fa-solid fa-arrow-up-right-from-square ms-1 text-primary small" style="font-size: 0.75rem;"></i>
                                    @endif
                                </a>
                            @endif

                            @if($post->type === 'url' && $post->link_url)
                                <div class="mt-0.5">
                                    <a href="{{ $post->link_url }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-muted small text-truncate d-inline-block" style="max-width: 380px; font-size: 0.75rem;">
                                        <i class="fa-solid fa-link me-1 text-info"></i>{{ $post->link_url }}
                                    </a>
                                </div>
                            @endif

                            @if(!empty($bodyPreview))
                                <small class="text-muted text-truncate d-block mt-0.5" style="font-size: 0.78rem;">
                                    {{ Str::limit($bodyPreview, 90) }}
                                </small>
                            @endif

                            @if($post->type === 'assignment' && $post->assignment && $post->assignment->due_date)
                                <small class="text-danger fw-semibold d-block mt-1" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-calendar-xmark me-1"></i> Tenggat: {{ \Carbon\Carbon::parse($post->assignment->due_date)->format('d M Y, H:i') }}
                                </small>
                            @endif

                            @if($post->type === 'quiz' && $post->quiz)
                                @php $qAttempt = !$isTeacherUser ? $post->quiz->myAttempt : null; @endphp
                                @if($qAttempt)
                                    <small class="text-success fw-semibold d-block mt-1" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-circle-check me-1"></i> Sudah dikerjakan
                                        @if($qAttempt->taken_at)
                                            pada {{ $qAttempt->taken_at->format('d M Y, H:i') }}
                                        @endif
                                        @if($post->quiz->show_score)
                                            • Nilai: <strong class="text-success">{{ $qAttempt->score }}/{{ $post->quiz->max_score }}</strong>
                                        @endif
                                    </small>
                                @elseif($post->quiz->due_date)
                                    <small class="text-purple fw-semibold d-block mt-1" style="font-size: 0.75rem; color:#8B5CF6;">
                                        <i class="fa-regular fa-calendar me-1"></i> Tenggat: {{ \Carbon\Carbon::parse($post->quiz->due_date)->format('d M Y, H:i') }}
                                    </small>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Status / Action Button --}}
                    <div class="d-flex align-items-center gap-2 flex-shrink-0 ms-auto ms-md-0">
                        @if($isTeacherUser)
                            {{-- Tombol Toggle Visibilitas untuk Pengajar --}}
                            <form action="{{ route('teacher.classroom.post.toggle_visibility', $post) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-light border rounded-pill px-3 py-1.5 text-dark fw-semibold shadow-xs" style="font-size: 0.78rem;" title="{{ $post->is_published ? 'Sembunyikan dari siswa' : 'Tampilkan ke siswa' }}">
                                    @if($post->is_published)
                                        <i class="fa-regular fa-eye-slash me-1 text-muted"></i> Sembunyikan
                                    @else
                                        <i class="fa-regular fa-eye me-1 text-success"></i> Tampilkan
                                    @endif
                                </button>
                            </form>

                            {{-- Tombol Aksi Kelola untuk Pengajar --}}
                            @if($post->type === 'material')
                                <a href="{{ route('teacher.classroom.material.show', [$post->classroom_id, $post->id]) }}" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold text-primary border-primary border hover-bg-primary" style="font-size: 0.78rem;">
                                    Buka Materi <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            @elseif($post->type === 'assignment')
                                @if($post->assignment)
                                <button type="button" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold text-danger border-danger border hover-bg-danger shadow-xs" style="font-size: 0.78rem;" data-bs-toggle="modal" data-bs-target="#submissionModal{{ $post->assignment->id }}">
                                    Periksa Tugas <i class="fa-solid fa-folder-open ms-1"></i>
                                </button>
                                @endif
                            @elseif($post->type === 'quiz' && $post->quiz)
                                <a href="{{ route('teacher.classroom.quiz.preview_submissions', $post->quiz->id) }}" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold text-success border-success border" style="font-size: 0.78rem;">
                                    Hasil Quiz <i class="fa-solid fa-chart-pie ms-1"></i>
                                </a>
                            @elseif($post->type === 'url' && $post->link_url)
                                <a href="{{ $post->link_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold text-info border-info border hover-bg-info" style="font-size: 0.78rem;">
                                    Buka Tautan <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @endif

                            {{-- Tombol Hapus Postingan (Soft Delete) --}}
                            <form action="{{ route('teacher.classroom.post.destroy', [$post->classroom_id, $post->id]) }}" method="POST"
                                  class="d-inline ms-1"
                                  onsubmit="return confirm('Hapus postingan \'{{ addslashes($post->title ?? 'tanpa judul') }}\'? Postingan akan dipindahkan ke arsip sampah (Soft Delete).')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light border rounded-circle text-danger shadow-xs hover-shadow d-inline-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px; padding: 0;"
                                        title="Hapus Postingan">
                                    <i class="fa-solid fa-trash fa-xs"></i>
                                </button>
                            </form>
                        @else
                            {{-- Tampilan Aksi untuk Siswa --}}
                            @if($post->type === 'material')
                                <a href="{{ $targetUrl }}" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold text-primary border-primary border hover-bg-primary" style="font-size: 0.78rem;">
                                    Buka Materi <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            @elseif($post->type === 'assignment')
                                @php $mySub = $post->assignment ? $post->assignment->mySubmission : null; @endphp
                                @if($mySub)
                                    <a href="{{ $targetUrl }}" class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold text-white border-0 shadow-xs" style="font-size: 0.78rem; background-color: #10B981;" title="Lihat Tugas Terkumpul">
                                        <i class="fa-solid fa-circle-check me-1"></i> Terkumpul
                                    </a>
                                @else
                                    <a href="{{ $targetUrl }}" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold text-danger border-danger border" style="font-size: 0.78rem;">
                                        Kumpulkan <i class="fa-solid fa-upload ms-1"></i>
                                    </a>
                                @endif
                            @elseif($post->type === 'quiz')
                                @php
                                    $myAttempt = $post->quiz ? $post->quiz->myAttempt : null;
                                    $isSingleOnly = $post->quiz && ((int)$post->quiz->max_attempts === 1);
                                @endphp
                                @if($myAttempt)
                                    <div class="d-flex align-items-center gap-1.5">
                                        <a href="{{ route('student.classroom.quiz.result', [$post->quiz->id, $myAttempt->id]) }}" class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold text-white border-0 shadow-xs btn-bouncy" style="font-size: 0.78rem; background-color: #10B981;" title="Lihat Hasil Evaluasi / Quiz">
                                            <i class="fa-solid fa-circle-check me-1"></i> Telah Mengerjakan Quiz
                                        </a>
                                        @if(!$isSingleOnly)
                                            <a href="{{ route('student.classroom.quiz.show', $post->quiz->id) }}" class="btn btn-sm btn-light border rounded-pill px-2.5 py-1.5 fw-semibold text-muted shadow-xs hover-shadow" style="font-size: 0.75rem;" title="Ulangi Kerjakan Kuis">
                                                <i class="fa-solid fa-rotate-right"></i>
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <a href="{{ $targetUrl }}" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold text-success border-success border btn-bouncy" style="font-size: 0.78rem;">
                                        Kerjakan <i class="fa-solid fa-pen-to-square ms-1"></i>
                                    </a>
                                @endif
                            @elseif($post->type === 'url' && $post->link_url)
                                <a href="{{ $post->link_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold text-info border-info border hover-bg-info" style="font-size: 0.78rem;">
                                    Buka Tautan <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1.5 fw-semibold" style="font-size: 0.72rem;">
                                    <i class="fa-solid fa-check me-1"></i> Tersedia
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

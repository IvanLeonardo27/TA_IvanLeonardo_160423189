{{-- ======================== MODAL TAMBAH PELAJAR KE KELAS ======================== --}}
@can('manageMembers', $classroom)
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true" style="z-index: 1065;">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ route('teacher.classroom.member.add', $classroom) }}" method="POST" class="d-flex flex-column h-100">
                @csrf
                <div class="modal-header border-bottom p-4" style="background: linear-gradient(135deg, rgba(5,150,105,0.06) 0%, rgba(37,99,235,0.06) 100%);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width: 48px; height: 48px; background: rgba(5, 150, 105, 0.12); color: #059669;">
                            <i class="fa-solid fa-user-plus fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-main mb-0" id="addStudentModalLabel">Tambah Pelajar ke Kelas</h5>
                            <small class="text-muted">Pilih siswa yang terdaftar di sistem untuk dimasukkan ke kelas <strong>{{ $classroom->name }}</strong></small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    @if(!isset($availableStudents) || $availableStudents->isEmpty())
                        <div class="text-center py-5">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 68px; height: 68px; background: rgba(5, 150, 105, 0.1); color: #059669;">
                                <i class="fa-solid fa-circle-check fs-2"></i>
                            </div>
                            <h5 class="fw-bold text-main mb-1">Semua Siswa Sudah Terdaftar</h5>
                            <p class="text-muted small mb-0" style="max-width: 380px; margin: 0 auto;">
                                Seluruh pelajar yang terdaftar aktif di sistem sudah menjadi anggota kelas ini.
                            </p>
                        </div>
                    @else
                        {{-- Search Filter & Select All Bar --}}
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 ps-3">
                                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                                    </span>
                                    <input type="text" id="searchStudentInput" class="form-control bg-light border-0 py-2"
                                           placeholder="Cari nama, NIS, atau email..." onkeyup="filterStudentsList()">
                                </div>
                            </div>
                            <div class="col-md-5 d-flex align-items-center justify-content-between justify-content-md-end gap-3">
                                <div class="form-check m-0">
                                    <input class="form-check-input cursor-pointer" type="checkbox" id="selectAllStudents" onchange="toggleSelectAllStudents(this)">
                                    <label class="form-check-label small fw-semibold text-dark user-select-none cursor-pointer" for="selectAllStudents">
                                        Pilih Semua ({{ $availableStudents->count() }})
                                    </label>
                                </div>
                                <span id="selectedCountBadge" class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1.5 fw-semibold" style="font-size: 0.78rem;">
                                    0 dipilih
                                </span>
                            </div>
                        </div>

                        {{-- Scrollable List of Students --}}
                        <div class="border rounded-4 p-2 overflow-auto" style="max-height: 360px;" id="studentsContainer">
                            <div class="row g-2" id="studentsList">
                                @foreach($availableStudents as $student)
                                <div class="col-md-6 student-item-col" data-student-search="{{ strtolower($student->name . ' ' . $student->email . ' ' . ($student->user_code ?? '')) }}">
                                    <label class="d-flex align-items-center gap-3 p-2.5 rounded-3 border bg-white h-100 cursor-pointer hover-shadow transition-all mb-0 user-select-none"
                                           for="student_chk_{{ $student->id }}" style="cursor: pointer;">
                                        <input class="form-check-input student-checkbox flex-shrink-0 m-0" type="checkbox"
                                               name="student_ids[]" value="{{ $student->id }}" id="student_chk_{{ $student->id }}"
                                               onchange="updateSelectedCount()">
                                        
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=40&background=E2E8F0&color=1E293B"
                                             class="rounded-circle flex-shrink-0 shadow-xs" width="38" height="38" alt="{{ $student->name }}">
                                        
                                        <div class="min-w-0 flex-grow-1">
                                            <div class="fw-bold text-dark text-truncate small">{{ $student->name }}</div>
                                            <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                                @if(!empty($student->user_code))
                                                <span class="badge bg-light text-secondary font-monospace border" style="font-size: 0.65rem;">
                                                    {{ $student->user_code }}
                                                </span>
                                                @endif
                                                <span class="text-muted text-truncate" style="font-size: 0.72rem;">{{ $student->email }}</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div id="noStudentFoundMsg" class="text-center py-4 text-muted small d-none">
                                <i class="fa-solid fa-user-slash fs-4 d-block mb-2 text-secondary"></i>
                                Tidak ditemukan pelajar yang cocok dengan kata kunci pencarian.
                            </div>
                        </div>
                    @endif
                </div>

                <div class="modal-footer bg-light border-top p-3.5 d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fa-solid fa-circle-info me-1 text-primary"></i>Pelajar yang ditambahkan akan langsung dapat mengakses kelas ini.
                    </small>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4 py-2 fw-semibold" data-bs-dismiss="modal">Batal</button>
                        @if(isset($availableStudents) && $availableStudents->isNotEmpty())
                        <button type="submit" id="submitAddStudentsBtn" class="btn btn-primary rounded-pill px-4 py-2 btn-bouncy fw-bold shadow-xs" disabled>
                            <i class="fa-solid fa-user-plus me-1.5"></i>Tambahkan ke Kelas
                        </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Modal Siswa Functions (Global / Shared)
if (typeof filterStudentsList === 'undefined') {
    function filterStudentsList() {
        const searchInput = document.getElementById('searchStudentInput');
        if (!searchInput) return;
        const query = searchInput.value.toLowerCase().trim();
        const items = document.querySelectorAll('.student-item-col');
        let visibleCount = 0;

        items.forEach(item => {
            const text = item.getAttribute('data-student-search');
            if (!query || text.includes(query)) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        const noFound = document.getElementById('noStudentFoundMsg');
        if (noFound) {
            if (visibleCount === 0) {
                noFound.classList.remove('d-none');
            } else {
                noFound.classList.add('d-none');
            }
        }
    }

    function toggleSelectAllStudents(master) {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(chk => {
            const col = chk.closest('.student-item-col');
            if (!col || !col.classList.contains('d-none')) {
                chk.checked = master.checked;
            }
        });
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const checked = document.querySelectorAll('.student-checkbox:checked').length;
        const badge = document.getElementById('selectedCountBadge');
        if (badge) {
            badge.textContent = `${checked} dipilih`;
        }
        const btn = document.getElementById('submitAddStudentsBtn');
        if (btn) {
            btn.disabled = (checked === 0);
        }
    }
}
</script>
@endcan

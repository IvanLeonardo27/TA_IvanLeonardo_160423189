@extends('layouts.app')

@section('title', 'Edit Soal - Bank Soal')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">
        {{-- Breadcrumb & Back --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('teacher.question-bank.index') }}" class="btn btn-light rounded-pill px-3 py-2 fw-semibold text-muted">
                <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Bank Soal
            </a>
            <span class="badge rounded-pill px-3 py-2 text-white fw-bold" style="background: #8B5CF6;">
                <i class="fa-solid fa-boxes-stacked me-1"></i> Bank Soal
            </span>
        </div>

        @if($errors->any())
        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
            <h6 class="fw-bold mb-2"><i class="fa-solid fa-triangle-exclamation me-2"></i>Gagal Memperbarui Soal:</h6>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="card-header bg-white border-bottom p-4">
                <h4 class="fw-bold text-main mb-1">
                    <i class="fa-solid fa-pen-to-square me-2" style="color:#8B5CF6;"></i>Edit Butir Soal
                </h4>
                <p class="text-muted small mb-0">
                    Perubahan pada butir soal ini akan tersimpan di Bank Soal pribadi Anda.
                </p>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('teacher.question-bank.update', $question) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Kategori Topik --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-main">
                            Kategori Topik Pembelajaran <span class="text-danger">*</span>
                        </label>
                        <select name="category" class="form-select rounded-4 border-0 bg-light py-2.5 fw-semibold" required>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ old('category', $question->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pertanyaan Soal --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-main">
                            Isi Pertanyaan Soal <span class="text-danger">*</span>
                        </label>
                        <textarea name="question" rows="3" class="form-control rounded-4 border-0 bg-light p-3"
                                  placeholder="Tuliskan pertanyaan pilihan ganda secara jelas..." required>{{ old('question', $question->question ?? $question->question_text) }}</textarea>
                    </div>

                    {{-- Lampiran Gambar Soal (Opsional) --}}
                    <div class="mb-4 p-3.5 rounded-4 bg-light border border-dashed">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-semibold text-main small m-0">
                                <i class="fa-regular fa-image me-1 text-primary"></i>Lampiran Gambar Soal (Opsional)
                            </label>
                            @if($question->image_path)
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="removeExistingImage" style="cursor:pointer;">
                                    <label class="form-check-label text-danger small fw-semibold" for="removeExistingImage" style="cursor:pointer;">
                                        Hapus gambar saat ini
                                    </label>
                                </div>
                            @endif
                        </div>

                        @if($question->image_path)
                            <div class="mb-3 p-2 bg-white rounded-3 border d-inline-block" id="currentImageBox">
                                <small class="text-muted d-block mb-1">Gambar saat ini:</small>
                                <img src="{{ asset('storage/' . $question->image_path) }}" alt="Gambar Soal" class="rounded-2 border" style="max-height: 120px; object-fit: contain;">
                            </div>
                        @endif

                        <div>
                            <input type="file" name="image" id="imageInput" class="form-control rounded-3" accept=".png, .jpg, .jpeg, image/png, image/jpeg">
                            <small class="text-muted d-block mt-1" style="font-size:0.75rem;">
                                <i class="fa-solid fa-circle-info me-1"></i>Hanya jika ingin mengganti gambar: Format <strong>PNG</strong>, <strong>JPG/JPEG</strong> (Maksimum 5MB).
                            </small>
                        </div>
                    </div>

                    {{-- Pilihan Jawaban & Bobot Nilai (%) --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-1">
                            <label class="form-label fw-semibold text-main m-0">Pilihan Jawaban & Bobot Nilai (%) <span class="text-danger">*</span></label>
                            <small class="text-muted" style="font-size:0.75rem;"><i class="fa-solid fa-circle-info me-1"></i>Pilih radio / dropdown 100% untuk kunci utama.</small>
                        </div>

                        <div id="optionsList" class="d-flex flex-column gap-2">
                            <!-- Options rendered via JS -->
                        </div>

                        <div class="mt-3">
                            <button type="button" id="addOptionBtn" class="btn btn-light border btn-sm rounded-pill fw-semibold px-3 py-1.5" style="color:#8B5CF6; font-size:0.82rem;">
                                <i class="fa-solid fa-plus me-1"></i> Tambah Pilihan Jawaban (+ E, F...)
                            </button>
                        </div>
                    </div>

                    {{-- Penjelasan / Pembahasan Kunci Jawaban (Opsional) --}}
                    <div class="mb-4 p-3.5 rounded-4 bg-light border border-dashed">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <label class="form-label fw-semibold text-main m-0 small">
                                <i class="fa-regular fa-lightbulb me-1 text-warning"></i>Penjelasan / Pembahasan Jawaban (Opsional)
                            </label>
                            <small class="text-muted" style="font-size:0.75rem;"><i class="fa-solid fa-circle-info me-1"></i>Membantu siswa memahami kenapa jawaban ini benar.</small>
                        </div>
                        <div class="mt-2">
                            <textarea name="explanation" rows="2" class="form-control rounded-3 border-0 bg-white"
                                      placeholder="Tuliskan alasan atau sumber materi kenapa pilihan jawaban tersebut merupakan kunci yang tepat...">{{ old('explanation', $question->explanation) }}</textarea>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('teacher.question-bank.index') }}" class="btn btn-light rounded-pill px-4 py-2.5">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2.5 fw-semibold shadow btn-bouncy" style="background:#8B5CF6; border-color:#8B5CF6;">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const optionsList = document.getElementById('optionsList');
    const addOptionBtn = document.getElementById('addOptionBtn');

    // Existing options data from controller
    @php
        $existingOpts = is_array($question->options) ? $question->options : (json_decode($question->options, true) ?? []);
        $existingPcts = is_array($question->option_percentages) ? $question->option_percentages : (json_decode($question->option_percentages, true) ?? []);
        $correctIdx   = (int) ($question->correct_index ?? 0);
    @endphp

    const initialOptions = @json($existingOpts);
    const initialPercentages = @json($existingPcts);
    const initialCorrectIdx = {{ $correctIdx }};

    function renderOptionRow(container, letter, isDefault100 = false, initialText = '', initialPct = 0) {
        const row = document.createElement('div');
        row.className = 'd-flex align-items-center gap-2 option-row';
        row.dataset.letter = letter;

        row.innerHTML = `
            <div class="input-group-text bg-white border-0 p-0">
                <input class="form-check-input m-0 option-radio-key" type="radio" name="correct" value="${letter}"
                       ${isDefault100 ? 'checked' : ''} style="cursor:pointer; width:1.2em; height:1.2em;" title="Tandai sebagai Kunci Jawaban Utama">
            </div>
            <div class="badge rounded-circle bg-white border text-dark fw-bold option-letter-badge flex-shrink-0"
                 style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;">
                ${letter}
            </div>
            <input type="text" name="options[${letter}]" class="form-control rounded-4 border-0 bg-light flex-grow-1" style="min-width:0;"
                   placeholder="Tuliskan pilihan jawaban ${letter}..." value="${initialText.replace(/"/g, '&quot;')}" required>
            <div class="flex-shrink-0" style="width: 105px;">
                <select name="percentages[${letter}]" class="form-select form-select-sm rounded-3 fw-bold option-pct-select"
                        style="font-size:0.82rem; cursor:pointer;" title="Bobot Persentase Nilai Opsi ${letter}">
                    <option value="0" ${initialPct == 0 ? 'selected' : ''}>0%</option>
                    <option value="25" ${initialPct == 25 ? 'selected' : ''}>25%</option>
                    <option value="50" ${initialPct == 50 ? 'selected' : ''}>50%</option>
                    <option value="75" ${initialPct == 75 ? 'selected' : ''}>75%</option>
                    <option value="100" ${initialPct == 100 ? 'selected' : ''}>100%</option>
                </select>
            </div>
            <button type="button" class="btn btn-light btn-sm text-danger rounded-circle remove-opt-btn flex-shrink-0" style="width:30px;height:30px;padding:0;" title="Hapus Pilihan">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;

        const pctSelect = row.querySelector('.option-pct-select');
        const radioBtn  = row.querySelector('.option-radio-key');

        function updateColor(select) {
            const val = parseInt(select.value) || 0;
            select.classList.remove('bg-success-subtle', 'text-success', 'border-success', 'bg-primary-subtle', 'text-primary', 'border-primary', 'bg-warning-subtle', 'text-warning-emphasis', 'border-warning', 'bg-light', 'text-muted', 'border-0');
            if (val === 100) {
                select.classList.add('bg-success-subtle', 'text-success', 'border', 'border-success');
            } else if (val === 75 || val === 50) {
                select.classList.add('bg-primary-subtle', 'text-primary', 'border', 'border-primary');
            } else if (val === 25) {
                select.classList.add('bg-warning-subtle', 'text-warning-emphasis', 'border', 'border-warning');
            } else {
                select.classList.add('bg-light', 'text-muted', 'border-0');
            }
        }

        updateColor(pctSelect);

        pctSelect.addEventListener('change', () => {
            updateColor(pctSelect);
            if (pctSelect.value === '100') {
                radioBtn.checked = true;
                container.querySelectorAll('.option-row').forEach(other => {
                    if (other !== row) {
                        const sel = other.querySelector('.option-pct-select');
                        if (sel && sel.value === '100') {
                            sel.value = '0';
                            updateColor(sel);
                        }
                    }
                });
            } else if (radioBtn.checked && pctSelect.value !== '100') {
                const other100 = container.querySelector('.option-row:not(:focus-within) .option-pct-select option[value="100"]:checked');
                if (other100) {
                    const parentRadio = other100.closest('.option-row').querySelector('.option-radio-key');
                    if (parentRadio) parentRadio.checked = true;
                }
            }
        });

        radioBtn.addEventListener('change', () => {
            if (radioBtn.checked) {
                pctSelect.value = '100';
                updateColor(pctSelect);
                container.querySelectorAll('.option-row').forEach(other => {
                    if (other !== row) {
                        const sel = other.querySelector('.option-pct-select');
                        if (sel && sel.value === '100') {
                            sel.value = '0';
                            updateColor(sel);
                        }
                    }
                });
            }
        });

        const removeBtn = row.querySelector('.remove-opt-btn');
        removeBtn.addEventListener('click', () => {
            if (container.children.length <= 2) {
                alert('Pilihan ganda harus memiliki minimal 2 pilihan jawaban.');
                return;
            }
            row.remove();
            reorderOptionBadges(container);
        });

        container.appendChild(row);
    }

    function reorderOptionBadges(container) {
        [...container.children].forEach((row, idx) => {
            const letter = String.fromCharCode(65 + idx);
            const badge  = row.querySelector('.option-letter-badge');
            const radio  = row.querySelector('.option-radio-key');
            const text   = row.querySelector('input[type="text"]');
            const select = row.querySelector('.option-pct-select');

            badge.textContent = letter;
            radio.value = letter;
            text.name = `options[${letter}]`;
            text.placeholder = `Tuliskan pilihan jawaban ${letter}...`;
            if (select) {
                select.name = `percentages[${letter}]`;
                select.title = `Bobot Persentase Nilai Opsi ${letter}`;
            }
        });
    }

    // Populate existing options
    if (initialOptions && initialOptions.length > 0) {
        initialOptions.forEach((optText, idx) => {
            const letter = String.fromCharCode(65 + idx);
            const pct = initialPercentages && initialPercentages[idx] !== undefined ? initialPercentages[idx] : (idx === initialCorrectIdx ? 100 : 0);
            const isKey = (pct == 100);
            renderOptionRow(optionsList, letter, isKey, optText, pct);
        });
    } else {
        renderOptionRow(optionsList, 'A', true, '', 100);
        renderOptionRow(optionsList, 'B', false, '', 0);
    }

    addOptionBtn.addEventListener('click', () => {
        const nextLetter = String.fromCharCode(65 + optionsList.children.length);
        renderOptionRow(optionsList, nextLetter, false, '', 0);
    });
});
</script>
@endpush
@endsection

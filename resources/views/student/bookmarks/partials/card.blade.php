@php
    $type = match(get_class($item)) {
        \App\Models\WayangCharacter::class => 'wayang',
        \App\Models\MacapatDetail::class => 'macapat',
        \App\Models\JavaneseScriptDetail::class => 'aksara',
        \App\Models\Vocabulary::class => 'vocab',
        default => 'other'
    };

    $config = match($type) {
        'wayang' => [
            'theme' => 'gradient-wayang',
            'header_bg' => 'linear-gradient(135deg, #16402E 0%, #276247 100%)',
            'badge_bg' => 'bg-emerald-subtle text-emerald',
            'label' => '🎭 Pewayangan',
            'url' => route('wayang.show', $item->id),
            'btn_color' => '#16402E'
        ],
        'macapat' => [
            'theme' => 'gradient-macapat',
            'header_bg' => 'linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%)',
            'badge_bg' => 'bg-purple-subtle text-purple',
            'label' => '🎵 Tembang Macapat',
            'url' => route('macapat.show', $item->macapat_category_id ?? $item->id),
            'btn_color' => '#6D28D9'
        ],
        'aksara' => [
            'theme' => 'gradient-aksara',
            'header_bg' => 'linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%)',
            'badge_bg' => 'bg-blue-subtle text-primary',
            'label' => '📜 Aksara Jawa',
            'url' => route('javanese-script.show', $item->id),
            'btn_color' => '#1D4ED8'
        ],
        'vocab' => [
            'theme' => 'gradient-vocab',
            'header_bg' => 'linear-gradient(135deg, #0D9488 0%, #0F766E 100%)',
            'badge_bg' => 'bg-teal-subtle text-teal',
            'label' => '📖 Kosakata',
            'url' => route('kosakata.index'),
            'btn_color' => '#0F766E'
        ],
        default => [
            'theme' => 'gradient-default',
            'header_bg' => 'linear-gradient(135deg, #64748B 0%, #475569 100%)',
            'badge_bg' => 'bg-secondary-subtle text-secondary',
            'label' => 'Materi',
            'url' => '#',
            'btn_color' => '#475569'
        ]
    };
@endphp

<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white bookmark-card-item position-relative hover-elevate transition">
    {{-- Card Header Banner --}}
    <div class="p-3 text-white position-relative" style="background: {{ $config['header_bg'] }};">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="badge rounded-pill px-2.5 py-1 fw-bold bg-white text-dark shadow-xs" style="font-size: 0.73rem;">
                {{ $config['label'] }}
            </span>
            <button type="button" 
                    onclick="removeBookmarkCard('{{ $type }}', {{ $item->id }}, 'bookmark-card-{{ $bookmark->id }}')" 
                    class="btn btn-sm btn-light text-danger rounded-circle p-0 d-flex align-items-center justify-content-center shadow-xs" 
                    style="width: 28px; height: 28px;" 
                    title="Hapus dari Bookmark">
                <i class="fa-solid fa-trash-can" style="font-size: 0.75rem;"></i>
            </button>
        </div>

        {{-- Visual Highlight berdasarkan Tipe Materi --}}
        @if($type === 'wayang')
            <div class="d-flex align-items-center gap-3 my-2">
                <img src="{{ asset('storage/' . $item->image_path) }}" 
                     alt="{{ $item->name }}" 
                     class="rounded-3 border border-2 border-white shadow-sm flex-shrink-0" 
                     style="width: 50px; height: 50px; object-fit: cover;"
                     onerror="this.onerror=null; this.src='{{ asset('storage/wayang/default.svg') }}';">
                <div class="overflow-hidden">
                    <h6 class="fw-bold text-white mb-0.5 text-truncate" style="font-size: 1rem;">{{ $item->name }}</h6>
                    <small class="d-block text-truncate" style="color: rgba(255, 255, 255, 0.92) !important; font-size: 0.78rem; font-weight: 500;">{{ $item->category->name ?? 'Wayang' }}</small>
                </div>
            </div>
        @elseif($type === 'aksara')
            @php
                $javaneseGlyphs = [
                    'ha' => 'ꦲ', 'na' => 'ꦤ', 'ca' => 'ꦕ', 'ra' => 'ꦫ', 'ka' => 'ꦏ',
                    'da' => 'ꦢ', 'ta' => 'ꦠ', 'sa' => 'ꦱ', 'wa' => 'ꦮ', 'la' => 'ꦭ',
                    'pa' => 'ꦥ', 'dha' => 'ꦝ', 'ja' => 'ꦗ', 'ya' => 'ꦪ', 'nya' => 'ꦚ',
                    'ma' => 'ꦩ', 'ga' => 'ꦒ', 'ba' => 'ꦧ', 'tha' => 'ꦛ', 'nga' => 'ꦔ',
                ];
                $key = strtolower(trim($item->name));
                $glyph = $javaneseGlyphs[$key] ?? $item->name;
            @endphp
            <div class="d-flex align-items-center gap-3 my-1">
                <div class="rounded-3 bg-white text-dark fw-bold d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" 
                     style="width: 48px; height: 48px; font-family: 'Noto Sans Javanese', serif; font-size: 1.8rem; line-height: 1;">
                    {{ $glyph }}
                </div>
                <div class="overflow-hidden">
                    <h6 class="fw-bold text-white mb-0.5 text-truncate" style="font-size: 1rem;">Aksara {{ $item->name }}</h6>
                    <small class="d-block text-truncate" style="color: rgba(255, 255, 255, 0.92) !important; font-size: 0.78rem; font-weight: 500;">Latin: {{ $item->latin }}</small>
                </div>
            </div>
        @elseif($type === 'macapat')
            <div class="d-flex align-items-center gap-3 my-2">
                <div class="rounded-circle bg-white bg-opacity-20 text-white d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 44px; height: 44px;">
                    <i class="fa-solid fa-music fs-5"></i>
                </div>
                <div class="overflow-hidden">
                    <h6 class="fw-bold text-white mb-0.5 text-truncate" style="font-size: 1rem;">Tembang {{ $item->name ?? 'Macapat' }}</h6>
                    <small class="d-block text-truncate" style="color: rgba(255, 255, 255, 0.92) !important; font-size: 0.78rem; font-weight: 500;">{{ $item->guru_gatra ?? '7' }} Gatra</small>
                </div>
            </div>
        @elseif($type === 'vocab')
            <div class="d-flex align-items-center gap-3 my-2">
                <div class="rounded-circle bg-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" 
                     style="width: 44px; height: 44px; font-size: 1.1rem; color: #0F766E;">
                    {{ strtoupper(substr($item->indonesian_word, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <h6 class="fw-bold text-white mb-0.5 text-truncate" style="font-size: 1rem;">{{ $item->indonesian_word }}</h6>
                    <small class="d-block text-truncate" style="color: rgba(255, 255, 255, 0.92) !important; font-size: 0.78rem; font-weight: 500;">Kosakata Bahasa Jawa</small>
                </div>
            </div>
        @endif
    </div>

    {{-- Card Body Content --}}
    <div class="card-body p-3 d-flex flex-column justify-content-between">
        <div class="mb-2">
            @if($type === 'wayang')
                <small class="text-muted d-block text-truncate mb-1" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-flag text-success me-1"></i> {{ $item->allegiance ?? 'Pewayangan Jawa' }}
                </small>
                <p class="text-secondary small mb-0" style="font-size: 0.82rem; line-height: 1.35;">
                    {{ Str::limit($item->role ?? $item->description, 55) }}
                </p>
            @elseif($type === 'macapat')
                @if(!empty($item->watak))
                <small class="text-muted d-block mb-1 text-truncate" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-heart text-danger me-1"></i> Watak: {{ Str::limit($item->watak, 35) }}
                </small>
                @endif
                <p class="text-secondary small mb-0" style="font-size: 0.82rem; line-height: 1.35;">
                    {{ Str::limit($item->description ?? 'Kaidah Tembang Macapat', 55) }}
                </p>
            @elseif($type === 'aksara')
                <small class="text-muted d-block mb-1" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-volume-high text-primary me-1"></i> Pelafalan: /{{ $item->pronunciation ?? $item->latin }}/
                </small>
                <p class="text-secondary small mb-0" style="font-size: 0.82rem; line-height: 1.35;">
                    Kategori: {{ $item->category->name ?? 'Aksara Jawa' }}
                </p>
            @elseif($type === 'vocab')
                <div class="d-flex flex-column gap-1 my-1">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-0.5 fw-semibold" style="font-size: 0.7rem;">Ngoko</span>
                        <span class="fw-bold text-dark text-truncate" style="font-size: 0.85rem;">{{ $item->javanese_ngoko ?? '-' }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-0.5 fw-semibold" style="font-size: 0.7rem;">Krama</span>
                        <span class="fw-bold text-primary text-truncate" style="font-size: 0.85rem;">{{ $item->javanese_krama ?? '-' }}</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- Card Footer Action --}}
        <div class="pt-2.5 border-top border-light d-flex align-items-center justify-content-between mt-2">
            <small class="text-muted" style="font-size: 0.7rem;">
                {{ $bookmark->created_at->diffForHumans() }}
            </small>
            <a href="{{ $config['url'] }}" 
               class="btn btn-sm rounded-pill px-3 py-1 text-white fw-semibold shadow-xs" 
               style="background: {{ $config['btn_color'] }}; font-size: 0.78rem;">
                Buka Materi <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

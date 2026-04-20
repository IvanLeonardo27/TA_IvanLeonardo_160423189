@extends('layouts.admin')

@section('title', 'Admin Sinau Basa - Panel Pengelola')
@section('body_class', 'flex min-h-screen')

@section('content')
    <!-- Sidebar Navigation -->
    <aside
        class="w-64 sidebar text-white flex flex-col fixed h-full z-50 transition-transform -translate-x-full md:translate-x-0"
        id="sidebar">
        <div class="p-6 flex items-center gap-3">
            <div
                class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-green-800 font-bold text-xl shadow-lg">
                S</div>
            <span class="text-xl font-bold tracking-tight">Admin Sinau</span>
        </div>

        <nav class="flex-1 px-4 space-y-2 mt-4">
            <button type="button" onclick="switchPage('dashboard')"
                class="nav-item active w-full flex items-center gap-3 px-4 py-3 text-sm font-medium" id="nav-dashboard">
                <span>📊</span> Dashboard
            </button>
            <button type="button" onclick="switchPage('kosakata')"
                class="nav-item w-full flex items-center gap-3 px-4 py-3 text-sm font-medium" id="nav-kosakata">
                <span>📖</span> Kelola Kosakata
            </button>
            <button type="button" onclick="switchPage('kuis')"
                class="nav-item w-full flex items-center gap-3 px-4 py-3 text-sm font-medium" id="nav-kuis">
                <span>🏆</span> Kelola Kuis
            </button>
            <button type="button" onclick="switchPage('siswa')"
                class="nav-item w-full flex items-center gap-3 px-4 py-3 text-sm font-medium" id="nav-siswa">
                <span>👥</span> Statistik Siswa
            </button>
        </nav>

        <div class="p-4 border-t border-white/10">
            <button type="button"
                class="nav-item w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-white/80 hover:text-white">
                <span>🚪</span> Keluar
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 md:ml-64 p-4 md:p-8">

        <!-- Top Header -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h2 id="page-title" class="text-2xl font-bold text-gray-800">Dashboard Ringkasan</h2>
                <p class="text-gray-500">Selamat datang kembali, Admin!</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:block text-right">
                    <p class="text-sm font-bold">Admin Utama</p>
                    <p class="text-xs text-gray-500">Super Admin</p>
                </div>
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Admin" alt="Avatar"
                    class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
            </div>
        </header>

        @if (session('status'))
            <div class="main-card p-4 mb-6 border border-green-100 bg-green-50 text-green-800 text-sm font-medium">
                {{ session('status') }}
            </div>
        @endif

        <!-- Dashboard View -->
        <div id="dashboard-view" class="view-content space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="main-card p-6 flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-2xl">📖</div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Kosakata</p>
                        <p class="text-2xl font-bold">{{ number_format($stats['total_kosakata'] ?? 0) }}</p>
                    </div>
                </div>
                <div class="main-card p-6 flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-2xl">❓</div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Soal</p>
                        <p class="text-2xl font-bold">{{ number_format($stats['total_soal'] ?? 0) }}</p>
                    </div>
                </div>
                <div class="main-card p-6 flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-2xl">👦</div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Siswa Aktif</p>
                        <p class="text-2xl font-bold">{{ number_format($stats['siswa_aktif'] ?? 0) }}</p>
                    </div>
                </div>
                <div class="main-card p-6 flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center text-2xl">⭐</div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Rata-rata Skor</p>
                        <p class="text-2xl font-bold">{{ number_format((float) ($stats['rata_rata_skor'] ?? 0), 1) }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
                <div class="main-card p-6">
                    <h3 class="font-bold text-lg mb-4">Aktivitas Terakhir</h3>
                    <div class="space-y-4">
                        @forelse ($recentActivities as $activity)
                            <div class="flex items-center justify-between py-2 border-b border-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs">
                                        {{ $activity->icon }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium">{{ $activity->description }}</p>
                                        <p class="text-xs text-gray-400">{{ $activity->created_at?->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Belum ada aktivitas.</p>
                        @endforelse
                    </div>
                </div>
                <div class="main-card p-6">
                    <h3 class="font-bold text-lg mb-4">Siswa Berprestasi Minggu Ini</h3>
                    <div class="space-y-4">
                        @forelse ($topStudentsThisWeek as $row)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($row->player_name) }}"
                                        class="w-8 h-8 rounded-full" alt="{{ $row->player_name }}">
                                    <span class="text-sm font-medium">{{ $row->player_name }}</span>
                                </div>
                                <span class="text-green-600 font-bold">Skor: {{ (int) $row->best_score }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Belum ada data minggu ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Kosakata View -->
        <div id="kosakata-view" class="view-content hidden">
            <div class="main-card overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="relative w-full md:w-64">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                        <input type="text" placeholder="Cari kosakata..."
                            class="w-full pl-10 pr-4 py-2 border rounded-xl text-sm outline-none focus:border-green-500">
                    </div>
                    <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                        <a href="{{ route('admin.vocab.export') }}"
                            class="px-6 py-2 rounded-xl text-sm font-bold bg-gray-100 hover:bg-gray-200 transition flex items-center gap-2 w-full md:w-auto justify-center">
                            <span>⬇️</span> Export CSV
                        </a>
                        <button type="button" onclick="toggleImportForm()"
                            class="px-6 py-2 rounded-xl text-sm font-bold bg-gray-100 hover:bg-gray-200 transition flex items-center gap-2 w-full md:w-auto justify-center">
                            <span>⬆️</span> Import CSV
                        </button>
                        <button type="button" onclick="toggleVocabForm()"
                            class="btn-green px-6 py-2 rounded-xl text-sm font-bold flex items-center gap-2 w-full md:w-auto justify-center">
                            <span>+</span> {{ $editingWord ? 'Edit Kosakata' : 'Tambah Kosakata' }}
                        </button>
                    </div>
                </div>

                <div id="import-form" class="p-6 border-b border-gray-100 hidden">
                    <form method="POST" action="{{ route('admin.vocab.import') }}" enctype="multipart/form-data"
                        class="flex flex-col md:flex-row gap-3 items-start md:items-end">
                        @csrf
                        <div class="w-full md:flex-1">
                            <label class="block text-xs font-bold text-gray-500 mb-2">File CSV</label>
                            <input type="file" name="file" accept=".csv,text/csv"
                                class="w-full px-4 py-2 border rounded-xl text-sm outline-none focus:border-green-500"
                                required>
                            <p class="text-xs text-gray-400 mt-2">Header minimal: <span class="font-mono">indo,jawa</span>
                            </p>
                        </div>
                        <button type="submit" class="btn-green px-6 py-2 rounded-xl text-sm font-bold w-full md:w-auto">
                            Upload & Import
                        </button>
                    </form>
                </div>

                <div id="vocab-form"
                    class="p-6 border-b border-gray-100 {{ $errors->any() || $editingWord ? '' : 'hidden' }}">
                    @if ($errors->any())
                        <div class="mb-4 p-4 rounded-xl border border-red-100 bg-red-50 text-red-700 text-sm">
                            <p class="font-bold mb-2">Periksa kembali input:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                        action="{{ $editingWord ? route('admin.vocab.update', $editingWord) : route('admin.vocab.store') }}"
                        class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        @csrf
                        @if ($editingWord)
                            @method('PUT')
                        @endif

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 mb-2">Bahasa Indonesia</label>
                            <input name="indo" value="{{ old('indo', $editingWord?->indo) }}" required
                                maxlength="120"
                                class="w-full px-4 py-2 border rounded-xl text-sm outline-none focus:border-green-500"
                                placeholder="Contoh: makan">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 mb-2">Basa Jawa (Ngoko)</label>
                            <input name="jawa" value="{{ old('jawa', $editingWord?->jawa) }}" required
                                maxlength="120"
                                class="w-full px-4 py-2 border rounded-xl text-sm outline-none focus:border-green-500"
                                placeholder="Contoh: mangan">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2">Emoji (opsional)</label>
                            <input name="emoji" value="{{ old('emoji', $editingWord?->emoji) }}" maxlength="16"
                                class="w-full px-4 py-2 border rounded-xl text-sm outline-none focus:border-green-500"
                                placeholder="🍚">
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-gray-500 mb-2">Kategori</label>
                            <select name="vocab_category_id"
                                class="w-full px-4 py-2 border rounded-xl text-sm outline-none focus:border-green-500">
                                <option value="">- Tanpa kategori -</option>
                                @foreach ($vocabCategories as $cat)
                                    <option value="{{ $cat->id }}" @selected((string) old('vocab_category_id', $editingWord?->vocab_category_id) === (string) $cat->id)>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2 flex items-center gap-4">
                            <label class="inline-flex items-center gap-2 text-sm">
                                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $editingWord?->is_published ?? true))>
                                <span class="font-medium text-gray-700">Tampilkan ke siswa</span>
                            </label>
                        </div>

                        <div class="md:col-span-5 flex flex-col md:flex-row gap-2 md:justify-end">
                            @if ($editingWord)
                                <a href="{{ route('admin.home', ['view' => 'kosakata']) }}"
                                    class="px-6 py-2 rounded-xl text-sm font-bold bg-gray-100 hover:bg-gray-200 transition text-center">Batal</a>
                            @endif
                            <button type="submit"
                                class="btn-green px-6 py-2 rounded-xl text-sm font-bold w-full md:w-auto">
                                {{ $editingWord ? 'Simpan Perubahan' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
                            <tr>
                                <th class="px-6 py-4">Bahasa Indonesia</th>
                                <th class="px-6 py-4">Basa Jawa (Ngoko)</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($vocabWords as $word)
                                @php
                                    $slug = $word->category?->slug;
                                    $label = $word->category?->name ?? 'Lainnya';
                                    $badge = match ($slug) {
                                        'angka' => 'bg-green-100 text-green-700',
                                        'hewan' => 'bg-blue-100 text-blue-700',
                                        'tubuh' => 'bg-purple-100 text-purple-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium">{{ $word->indo }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $word->jawa }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 {{ $badge }} text-[10px] font-bold rounded-full">{{ $label }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.home', ['view' => 'kosakata', 'edit' => $word->id]) }}"
                                            class="text-blue-500 mr-2 hover:underline">Edit</a>
                                        <form method="POST" action="{{ route('admin.vocab.destroy', $word) }}"
                                            class="inline" onsubmit="return confirm('Hapus kosakata ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-6 text-sm text-gray-400 text-center">Belum ada
                                        kosakata.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 border-t border-gray-100 text-center">
                    <button type="button" class="text-sm text-gray-400 hover:text-green-600 font-medium">Lihat Semua
                        Data</button>
                </div>
            </div>
        </div>

        <!-- Kuis View -->
        <div id="kuis-view" class="view-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($quizSets as $set)
                    <div class="main-card p-6 border-l-4 {{ $set->is_default ? 'border-green-500' : 'border-blue-500' }}">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-bold text-lg">{{ $set->title }}</h4>
                                <p class="text-xs text-gray-400">
                                    Terakhir diupdate:
                                    {{ $set->last_question_updated_at ? \Carbon\Carbon::parse($set->last_question_updated_at)->translatedFormat('d M Y') : '-' }}
                                </p>
                            </div>
                            <span
                                class="bg-{{ $set->is_active ? 'green' : 'gray' }}-100 text-{{ $set->is_active ? 'green' : 'gray' }}-700 px-3 py-1 rounded-full text-xs font-bold">
                                {{ $set->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-gray-600 mb-6">
                            <span>❓ {{ (int) ($set->questions_count ?? 0) }} Soal</span>
                            <span>⏱️ Tanpa Waktu</span>
                        </div>
                        <div class="flex gap-2">
                            <button type="button"
                                class="flex-1 py-2 bg-gray-100 rounded-lg text-xs font-bold hover:bg-gray-200 transition">Edit
                                Soal</button>
                            <button type="button"
                                class="flex-1 py-2 border border-red-200 text-red-500 rounded-lg text-xs font-bold hover:bg-red-50 transition">
                                {{ $set->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="main-card p-6 text-sm text-gray-400">Belum ada set kuis.</div>
                @endforelse

                <button type="button"
                    class="main-card border-2 border-dashed border-gray-200 p-6 flex flex-col items-center justify-center text-gray-400 hover:border-green-500 hover:text-green-500 transition group">
                    <span class="text-3xl mb-2 group-hover:scale-110 transition">+</span>
                    <span class="font-bold">Buat Set Kuis Baru</span>
                </button>
            </div>
        </div>

        <!-- Siswa View -->
        <div id="siswa-view" class="view-content hidden">
            <div class="main-card p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg">Daftar Nilai Siswa Terbaru</h3>
                    <button type="button" class="text-sm text-green-600 font-bold hover:underline">Ekspor Data
                        (.csv)</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="text-gray-400 text-xs font-bold uppercase tracking-wider">
                            <tr>
                                <th class="pb-4">Nama Siswa</th>
                                <th class="pb-4">Kuis Terakhir</th>
                                <th class="pb-4">Tanggal</th>
                                <th class="pb-4 text-right">Skor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($recentAttempts as $attempt)
                                <tr>
                                    <td class="py-4 flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-xs">
                                            👶</div>
                                        <span class="text-sm font-medium">{{ $attempt->player_name }}</span>
                                    </td>
                                    <td class="py-4 text-sm">{{ $attempt->quizSet?->title ?? '-' }}</td>
                                    <td class="py-4 text-sm text-gray-400">
                                        {{ $attempt->taken_at?->translatedFormat('d M Y') }}</td>
                                    <td class="py-4 text-right font-bold text-green-600">{{ (int) $attempt->score }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-sm text-gray-400 text-center">Belum ada nilai
                                        siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('scripts')
    <script>
        function toggleImportForm(forceOpen = null) {
            const form = document.getElementById('import-form');
            if (!form) return;
            if (forceOpen === true) {
                form.classList.remove('hidden');
                return;
            }
            if (forceOpen === false) {
                form.classList.add('hidden');
                return;
            }
            form.classList.toggle('hidden');
        }

        function toggleVocabForm(forceOpen = null) {
            const form = document.getElementById('vocab-form');
            if (!form) return;
            if (forceOpen === true) {
                form.classList.remove('hidden');
                return;
            }
            if (forceOpen === false) {
                form.classList.add('hidden');
                return;
            }
            form.classList.toggle('hidden');
        }

        function switchPage(pageId) {
            // Hide all views
            document.querySelectorAll('.view-content').forEach(view => {
                view.classList.add('hidden');
            });

            // Show target view
            document.getElementById(`${pageId}-view`).classList.remove('hidden');

            // Update Sidebar UI
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            document.getElementById(`nav-${pageId}`).classList.add('active');

            // Update Title
            const titles = {
                'dashboard': 'Dashboard Ringkasan',
                'kosakata': 'Manajemen Kosakata',
                'kuis': 'Pengaturan Kuis',
                'siswa': 'Laporan Belajar Siswa'
            };
            document.getElementById('page-title').innerText = titles[pageId];

            // Close sidebar on mobile after selection
            if (window.innerWidth < 768) {
                document.getElementById('sidebar').classList.add('-translate-x-full');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const initialView = params.get('view') || @json($errors->any() || $editingWord ? 'kosakata' : 'dashboard');
            if (['dashboard', 'kosakata', 'kuis', 'siswa'].includes(initialView)) {
                switchPage(initialView);
            }
            if (initialView === 'kosakata' && (@json($errors->any()) || @json((bool) $editingWord))) {
                toggleVocabForm(true);
            }
        });

        // Toggle mobile sidebar (simplified for this demo)
        document.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                // You can add a hamburger button trigger here
            }
        });
    </script>
@endpush

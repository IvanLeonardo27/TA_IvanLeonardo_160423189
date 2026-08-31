@extends('layouts.customer')

@section('title', 'Sinau Basa - Belajar Bahasa Jawa Seru')
@section('body_class', 'min-h-screen pb-20')

@section('content')
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-nav border-b border-green-100">
        <div class="max-w-4xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div
                    class="w-10 h-10 bg-green-primary rounded-xl flex items-center justify-center text-white font-bold text-xl">
                    S</div>
                <h1 class="text-2xl font-bold text-green-primary tracking-tight">Sinau Basa</h1>
            </div>
            <div class="hidden md:flex gap-6 font-medium">
                <button type="button" onclick="showSection('home')"
                    class="hover:text-green-primary transition">Beranda</button>
                <button type="button" onclick="showSection('kamus')"
                    class="hover:text-green-primary transition">Kosakata</button>
                <button type="button" onclick="showSection('translate')"
                    class="hover:text-green-primary transition">Terjemah</button>
                <button type="button" onclick="showSection('kuis')"
                    class="hover:text-green-primary transition">Kuis</button>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto pt-28 px-6">

        <!-- Section: Home -->
        <section id="home-section" class="section-content">
            <div class="flex flex-col md:flex-row items-center gap-10 mb-12">
                <div class="flex-1">
                    <div class="character-bubble">
                        <p class="text-lg font-medium">Sugeng Rawuh, Cah Bagus &amp; Cah Ayu! 👋 Mari belajar Bahasa Jawa
                            dengan cara yang menyenangkan.</p>
                    </div>
                    <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=Felix" alt="Character" class="w-32 h-32">
                    <h2 class="text-4xl font-bold mt-6 leading-tight">Belajar Bahasa Jawa Jadi <span
                            class="text-green-primary">Luwih Gampang!</span></h2>
                    <p class="text-gray-600 mt-4 text-lg">Pilih menu di bawah ini untuk memulai petualanganmu!</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div onclick="showSection('kamus')" class="card p-6 cursor-pointer hover:scale-105">
                    <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mb-4 text-3xl">📖</div>
                    <h3 class="text-xl font-bold">Kosakata</h3>
                    <p class="text-gray-500 mt-2">Kumpulan kata-kata dasar sehari-hari.</p>
                </div>
                <div onclick="showSection('translate')" class="card p-6 cursor-pointer hover:scale-105">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-4 text-3xl">🗣️</div>
                    <h3 class="text-xl font-bold">Terjemah</h3>
                    <p class="text-gray-500 mt-2">Cari arti kata dan dengarkan suaranya.</p>
                </div>
                <div onclick="showSection('kuis')" class="card p-6 cursor-pointer hover:scale-105">
                    <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center mb-4 text-3xl">🏆</div>
                    <h3 class="text-xl font-bold">Kuis Seru</h3>
                    <p class="text-gray-500 mt-2">Uji kemampuanmu dan dapatkan skor!</p>
                </div>
            </div>
        </section>

        <!-- Section: Kosakata -->
        <section id="kamus-section" class="section-content hidden">
            <button type="button" onclick="showSection('home')"
                class="mb-6 text-green-primary font-bold flex items-center gap-2">
                <span>← Kembali</span>
            </button>
            <h2 class="text-3xl font-bold mb-8 text-center">Sinau Kosakata</h2>

            <div id="kamus-filter" class="flex gap-4 mb-8 overflow-x-auto pb-2 no-scrollbar">
                @forelse ($kamusTabs as $tab)
                    @php
                        $active = ($defaultKamusSlug ?? '') === $tab['slug'];
                    @endphp
                    <button type="button" onclick="filterKamus(@json($tab['slug']))"
                        class="px-6 py-2 rounded-full bg-white border-2 {{ $active ? 'border-green-primary text-green-primary shadow-sm' : 'border-gray-200' }} font-bold hover:border-green-primary transition"
                        data-kamus-filter data-slug="{{ $tab['slug'] }}">{{ $tab['label'] }}</button>
                @empty
                    <div class="text-sm text-gray-400">Belum ada kategori kosakata.</div>
                @endforelse
            </div>

            <div id="kamus-grid" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Items injected by JS -->
            </div>
        </section>

        <!-- Section: Translate -->
        <section id="translate-section" class="section-content hidden">
            <button type="button" onclick="showSection('home')"
                class="mb-6 text-green-primary font-bold flex items-center gap-2">
                <span>← Kembali</span>
            </button>
            <div class="card p-8 max-w-2xl mx-auto">
                <h2 class="text-2xl font-bold mb-6 text-center">Terjemah &amp; Suara</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-500 mb-2 uppercase">Bahasa Indonesia</label>
                        <input type="text" id="input-indo" placeholder="Ketik kata di sini (minimal 10 kata)..."
                            class="w-full p-4 border-2 border-gray-100 rounded-2xl focus:border-green-primary outline-none transition text-lg">
                    </div>

                    <div class="flex justify-center">
                        <div class="bg-green-50 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-500 mb-2 uppercase">Basa Jawa (Ngoko)</label>
                        <div class="relative">
                            <div id="output-jawa"
                                class="w-full p-4 border-2 border-dashed border-green-200 bg-green-50 rounded-2xl text-lg font-bold min-h-[60px] flex items-center">
                                Hasil terjemahan...
                            </div>
                            <button type="button" onclick="playTTS(document.getElementById('output-jawa').innerText)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 bg-green-primary text-white p-2 rounded-xl hover:bg-[var(--color-green-dark)] transition">
                                🔊
                            </button>
                        </div>
                    </div>

                    <button type="button" onclick="translateAction()" class="btn-primary w-full text-xl mt-4">Terjemahkan
                        Sekarang</button>
                    <p class="text-xs text-center text-gray-400 mt-2 italic">*Terjemahan kalimat menggunakan library
                        penerjemah (tidak bergantung kosakata DB).
                    </p>
                </div>
            </div>
        </section>

        <!-- Section: Kuis -->
        <section id="kuis-section" class="section-content hidden">
            <button type="button" onclick="showSection('home')"
                class="mb-6 text-green-primary font-bold flex items-center gap-2">
                <span>← Kembali</span>
            </button>

            <div id="kuis-container" class="card p-8 max-w-2xl mx-auto">
                <div id="kuis-intro">
                    <h2 class="text-3xl font-bold text-center mb-4">Siap Bermain? 🎮</h2>
                    <p class="text-center text-gray-600 mb-8">Jawab 5 pertanyaan tentang Bahasa Jawa dan lihat seberapa
                        jago kamu!</p>
                    <div class="flex justify-center">
                        <button type="button" onclick="startKuis()" class="btn-primary px-12 text-xl">Mulai
                            Kuis</button>
                    </div>
                </div>

                <div id="kuis-active" class="hidden">
                    <div class="flex justify-between items-center mb-6">
                        <span id="kuis-progress"
                            class="font-bold text-green-primary uppercase tracking-widest text-sm">Pertanyaan 1 / 5</span>
                        <div class="h-2 w-32 bg-gray-100 rounded-full overflow-hidden">
                            <div id="kuis-bar" class="h-full bg-green-primary transition-all duration-300"
                                style="width: 20%"></div>
                        </div>
                    </div>

                    <h3 id="kuis-question" class="text-2xl font-bold mb-8">Apa arti kata "Siji" dalam Bahasa Indonesia?
                    </h3>

                    <div id="kuis-options" class="grid grid-cols-1 gap-4">
                        <!-- Options injected by JS -->
                    </div>
                </div>

                <div id="kuis-result" class="hidden text-center">
                    <div id="result-emoji" class="text-7xl mb-4">🏆</div>
                    <h2 class="text-3xl font-bold mb-2">Hebat Banget!</h2>
                    <p class="text-gray-600 mb-6">Skor kamu adalah:</p>
                    <div class="text-6xl font-black text-green-primary mb-8" id="final-score">100</div>
                    <button type="button" onclick="startKuis()" class="btn-primary">Main Lagi</button>
                </div>
            </div>
        </section>

    </main>

    <!-- Bottom Navigation (Mobile Only) -->
    <div
        class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 flex justify-around py-3 px-2 z-50">
        <button type="button" onclick="showSection('home')"
            class="flex flex-col items-center gap-1 text-xs font-bold text-gray-400">
            <span class="text-xl">🏠</span> Beranda
        </button>
        <button type="button" onclick="showSection('kamus')"
            class="flex flex-col items-center gap-1 text-xs font-bold text-gray-400">
            <span class="text-xl">📖</span> Kamus
        </button>
        <button type="button" onclick="showSection('translate')"
            class="flex flex-col items-center gap-1 text-xs font-bold text-gray-400">
            <span class="text-xl">🗣️</span> Terjemah
        </button>
        <button type="button" onclick="showSection('kuis')"
            class="flex flex-col items-center gap-1 text-xs font-bold text-gray-400">
            <span class="text-xl">🏆</span> Kuis
        </button>
    </div>
@endsection

@push('scripts')
    <script>
        // Data from database (injected by Laravel)
        const dataKamus = @json($dataKamus);
        const defaultKamusSlug = @json($defaultKamusSlug ?? null);
        const kuisData = @json($kuisData);
        const translateUrl = @json(route('customer.translate'));
        const quizAttemptUrl = @json(route('customer.quiz.attempt'));
        const quizSetId = @json($quizSetId ?? null);

        let currentKuisIdx = 0;
        let score = 0;

        // Core Functions
        function showSection(sectionId) {
            document.querySelectorAll('.section-content').forEach(s => s.classList.add('hidden'));
            document.getElementById(`${sectionId}-section`).classList.remove('hidden');
            window.scrollTo(0, 0);

            if (sectionId === 'kamus') {
                const firstSlug = Object.keys(dataKamus || {})[0];
                filterKamus(defaultKamusSlug || firstSlug);
            }
        }

        // Kamus Logic
        function filterKamus(cat) {
            const grid = document.getElementById('kamus-grid');
            grid.innerHTML = '';

            if (!cat || !dataKamus || !dataKamus[cat]) {
                grid.innerHTML = '<div class="col-span-full text-center text-sm text-gray-400">Belum ada kosakata.</div>';
                return;
            }

            // Update UI buttons
            const buttons = document.querySelectorAll('#kamus-filter [data-kamus-filter]');
            buttons.forEach(btn => {
                btn.classList.remove('border-green-primary', 'text-green-primary');
                btn.classList.add('border-gray-200');

                if (btn.dataset.slug === cat) {
                    btn.classList.add('border-green-primary', 'text-green-primary');
                    btn.classList.remove('border-gray-200');
                }
            });

            dataKamus[cat].forEach(item => {
                const div = document.createElement('div');
                div.className =
                    'card p-4 text-center hover:bg-green-50 transition cursor-pointer flex flex-col items-center';
                div.onclick = () => playTTS(item.jawa);

                const emojiHtml = item.emoji ? `<div class="text-4xl mb-2">${item.emoji}</div>` : '';
                div.innerHTML = `
                    ${emojiHtml}
                    <div class="font-bold text-green-primary text-lg">${item.jawa}</div>
                    <div class="text-sm text-gray-500">${item.indo}</div>
                    <div class="mt-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded">🔊 Dengar</div>
                `;
                grid.appendChild(div);
            });
        }

        // TTS Logic
        function playTTS(text) {
            if (!window.speechSynthesis) {
                alert("Browser kamu tidak mendukung suara.");
                return;
            }

            // Cancel current speech
            window.speechSynthesis.cancel();

            const utterance = new SpeechSynthesisUtterance(text);

            // Optimization for Indonesian context (closest accent to Javanese in standard TTS)
            utterance.lang = 'id-ID';
            utterance.rate = 0.9;
            utterance.pitch = 1.1; // Slightly higher for kids

            window.speechSynthesis.speak(utterance);
        }

        // Translate Logic
        function translateAction() {
            const input = document.getElementById('input-indo').value.toLowerCase().trim();
            const output = document.getElementById('output-jawa');

            const btn = document.querySelector("button[onclick='translateAction()']");
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!input) {
                output.innerText = "...";
                return;
            }

            const words = input ? input.split(/\s+/).filter(w => w.length > 0) : [];
            if (words.length < 10) {
                output.innerText = `⚠️ Teks yang diterjemahkan minimal 10 kata. (Input Anda: ${words.length} kata)`;
                output.classList.remove('text-green-primary');
                return;
            }

            output.innerText = 'Menerjemahkan...';
            output.classList.remove('text-green-primary');

            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-70');
            }

            fetch(translateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        ...(csrf ? {
                            'X-CSRF-TOKEN': csrf
                        } : {}),
                    },
                    body: JSON.stringify({
                        text: document.getElementById('input-indo').value.trim(),
                        source: 'id',
                        target: 'jw'
                    })
                })
                .then(async (res) => {
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw new Error(data.message || 'Gagal menerjemahkan');
                    return data;
                })
                .then((data) => {
                    output.innerText = data.translated || '-';
                    output.classList.add('text-green-primary');
                })
                .catch((err) => {
                    output.innerText = err?.message || 'Gagal menerjemahkan. Coba lagi.';
                    output.classList.remove('text-green-primary');
                })
                .finally(() => {
                    if (btn) {
                        btn.disabled = false;
                        btn.classList.remove('opacity-70');
                    }
                });
        }

        // Kuis Logic
        function startKuis() {
            currentKuisIdx = 0;
            score = 0;
            document.getElementById('kuis-intro').classList.add('hidden');
            document.getElementById('kuis-result').classList.add('hidden');
            document.getElementById('kuis-active').classList.remove('hidden');
            loadQuestion();
        }

        function loadQuestion() {
            const data = kuisData[currentKuisIdx];
            document.getElementById('kuis-progress').innerText = `Pertanyaan ${currentKuisIdx + 1} / ${kuisData.length}`;
            document.getElementById('kuis-bar').style.width = `${((currentKuisIdx + 1) / kuisData.length) * 100}%`;
            document.getElementById('kuis-question').innerText = data.q;

            const optionsBox = document.getElementById('kuis-options');
            optionsBox.innerHTML = '';

            data.a.forEach((opt, idx) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className =
                    'w-full text-left p-4 border-2 border-gray-100 rounded-2xl hover:border-green-primary hover:bg-green-50 transition font-medium flex items-center justify-between group';
                btn.innerHTML = `
                    <span>${opt}</span>
                    <span class="opacity-0 group-hover:opacity-100">➔</span>
                `;
                btn.onclick = () => handleAnswer(idx);
                optionsBox.appendChild(btn);
            });
        }

        function handleAnswer(idx) {
            const correct = kuisData[currentKuisIdx].correct;
            kuisData[currentKuisIdx]._chosenIndex = idx;
            if (idx === correct) score += 20;

            currentKuisIdx++;
            if (currentKuisIdx < kuisData.length) {
                loadQuestion();
            } else {
                showResult();
            }
        }

        function showResult() {
            document.getElementById('kuis-active').classList.add('hidden');
            document.getElementById('kuis-result').classList.remove('hidden');
            document.getElementById('final-score').innerText = score;

            const emoji = document.getElementById('result-emoji');
            if (score >= 80) emoji.innerText = '🏆';
            else if (score >= 60) emoji.innerText = '🌟';
            else emoji.innerText = '📚';

            // Save analytics (best-effort, no UX changes)
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const playerName = localStorage.getItem('sinau_player_name') || 'Guest';

                if (quizSetId) {
                    fetch(quizAttemptUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            ...(csrf ? {
                                'X-CSRF-TOKEN': csrf
                            } : {}),
                        },
                        body: JSON.stringify({
                            quiz_set_id: quizSetId,
                            player_name: playerName,
                            score: score,
                            answers: (kuisData || []).map((q, idx) => ({
                                question_id: q.id,
                                chosen_index: q._chosenIndex ?? null,
                                time_ms: null,
                            })),
                        })
                    });
                }
            } catch (e) {
                // ignore
            }
        }

        // Init
        window.onload = () => {
            console.log("Sinau Basa Jawa - UI Ready");
        }
    </script>
@endpush

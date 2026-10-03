# -*- coding: utf-8 -*-
"""
Full Complete Generator for BasaKula LMS Low-Fidelity Wireframes (Hitam Putih / Grayscale)
Generates 30 Full-Screen Architectural Wireframe Screens (1440px Desktop)
Output files:
- figma_lofi_wireframes.html (root)
- docs/figma_lofi_wireframes.html
"""

import os

def build_full_html():
    screens = []

    # -------------------------------------------------------------
    # 01. LOGIN SYSTEM
    # -------------------------------------------------------------
    screens.append("""
    <!-- 01. LOGIN SYSTEM -->
    <section id="wf-01" class="space-y-3 wf-screen" data-role="auth">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-01</span>
                <span class="font-bold text-slate-900 text-sm">UI Login Sistem (Autentikasi Multi-Role)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa / Pengajar / Admin</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-200 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl p-16 flex items-center justify-center relative" style="background-image: radial-gradient(#94a3b8 1.5px, transparent 1.5px); background-size: 20px 20px;">
            <div class="bg-white rounded-2xl border-2 border-slate-900 p-10 w-full max-w-md space-y-6 shadow-md">
                <div class="text-center space-y-2">
                    <div class="w-16 h-16 bg-slate-900 text-white font-black text-2xl rounded-xl flex items-center justify-center mx-auto border-2 border-slate-900 font-mono">[B]</div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">BasaKula LMS</h3>
                    <p class="text-xs text-slate-600 font-medium">Sistem Pembelajaran Bahasa Jawa Terintegrasi</p>
                    <div class="inline-block border border-slate-400 bg-slate-100 text-slate-700 text-[10px] font-mono font-bold px-3 py-1 rounded-full uppercase">Lo-Fi Wireframe • Hitam Putih</div>
                </div>
                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1.5 uppercase font-mono text-[11px]">Email / Nomor Induk (NIS/NIP) <span class="text-slate-500">*</span></label>
                        <div class="p-3 bg-slate-50 border-2 border-slate-900 rounded-lg font-mono text-slate-700 text-xs flex items-center justify-between">
                            <span>siswa@sekolah.sch.id</span>
                            <span class="text-slate-400 text-[10px]">[Text Field]</span>
                        </div>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1.5 uppercase font-mono text-[11px]">Kata Sandi (Password) <span class="text-slate-500">*</span></label>
                        <div class="p-3 bg-slate-50 border-2 border-slate-900 rounded-lg font-mono text-slate-700 text-xs flex items-center justify-between">
                            <span>••••••••••••</span>
                            <span class="text-slate-400 text-[10px]">[Password Field]</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-slate-600 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer font-medium">
                            <input type="checkbox" checked class="rounded border-slate-900">
                            <span>Ingat Sesi Masuk</span>
                        </label>
                        <span class="underline font-bold">Lupa Kata Sandi?</span>
                    </div>
                    <button class="w-full py-3.5 bg-slate-900 text-white font-bold rounded-lg border-2 border-slate-900 text-xs uppercase tracking-wider shadow-sm flex items-center justify-center gap-2">
                        <span>[Button Primary] Masuk Ke Sistem</span>
                    </button>
                </div>
                <div class="pt-4 border-t-2 border-dashed border-slate-300 text-center text-[10px] text-slate-500 space-y-1">
                    <p class="font-bold text-slate-700">Pemberitahuan Akun Pengguna:</p>
                    <p>Akun Pelajar dan Pengajar dibuat & didaftarkan langsung oleh Administrator Sekolah.</p>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 02. PROFIL PENGGUNA
    # -------------------------------------------------------------
    screens.append("""
    <!-- 02. PROFIL PENGGUNA -->
    <section id="wf-02" class="space-y-3 wf-screen" data-role="auth">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-02</span>
                <span class="font-bold text-slate-900 text-sm">UI Pengaturan Profil Pengguna & Keamanan Akun</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa / Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📊 Beranda & Kelas</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📅 Kalender</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📜 Modul Aksara Jawa</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎵 Tembang Macapat</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">👤 Profil Saya [Aktif]</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase">👤 Pengaturan Profil Akun</h2>
                        <p class="text-xs text-slate-600 font-mono">Kelola informasi data diri, email, dan keamanan kata sandi Anda</p>
                    </div>
                    <button class="px-4 py-2 bg-slate-900 text-white font-bold text-xs rounded-lg border-2 border-slate-900 uppercase font-mono">[Button] Simpan Perubahan</button>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-4 text-center">
                        <div class="w-24 h-24 bg-slate-100 border-2 border-dashed border-slate-500 rounded-full mx-auto flex flex-col items-center justify-center text-slate-500 font-mono text-[10px]">
                            <svg class="w-8 h-8 mb-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>[Avatar]</span>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-base text-slate-900">Budi Santoso</h4>
                            <span class="inline-block bg-slate-100 border border-slate-900 text-[10px] font-mono font-bold px-2 py-0.5 rounded mt-1 uppercase">Pelajar Aktif (NIS: 16042)</span>
                        </div>
                        <div class="border-t border-slate-300 pt-3 text-left text-xs font-mono space-y-2">
                            <div class="flex justify-between"><span class="text-slate-500">Kelas:</span><span class="font-bold">X-A</span></div>
                            <div class="flex justify-between"><span class="text-slate-500">Sekolah:</span><span class="font-bold">SMAN 1 Surakarta</span></div>
                            <div class="flex justify-between"><span class="text-slate-500">Terdaftar:</span><span class="font-bold">12 Juli 2026</span></div>
                        </div>
                        <button class="w-full py-2 bg-white text-slate-900 border-2 border-slate-900 font-bold text-xs rounded-lg uppercase font-mono">[Button] Ganti Foto</button>
                    </div>
                    <div class="col-span-2 bg-white p-6 rounded-xl border-2 border-slate-900 space-y-5">
                        <h4 class="font-bold text-sm text-slate-900 uppercase font-mono border-b pb-2">Informasi Biodata & Kredensial</h4>
                        <div class="grid grid-cols-2 gap-4 text-xs font-mono">
                            <div><label class="block font-bold text-slate-700 mb-1">NAMA LENGKAP</label><div class="p-2.5 bg-slate-50 border-2 border-slate-400 rounded-lg">Budi Santoso</div></div>
                            <div><label class="block font-bold text-slate-700 mb-1">ALAMAT EMAIL</label><div class="p-2.5 bg-slate-50 border-2 border-slate-400 rounded-lg">budi.santoso@sekolah.sch.id</div></div>
                            <div><label class="block font-bold text-slate-700 mb-1">KATA SANDI BARU</label><div class="p-2.5 bg-white border-2 border-slate-900 rounded-lg text-slate-400">[Kosongkan jika tidak diganti]</div></div>
                            <div><label class="block font-bold text-slate-700 mb-1">KONFIRMASI KATA SANDI</label><div class="p-2.5 bg-white border-2 border-slate-900 rounded-lg text-slate-400">[Ulangi kata sandi baru]</div></div>
                        </div>
                        <div class="border-t border-slate-300 pt-4 space-y-3">
                            <h4 class="font-bold text-sm text-slate-900 uppercase font-mono">Preferensi Notifikasi & Aksesibilitas</h4>
                            <div class="space-y-2 text-xs font-mono">
                                <label class="flex items-center gap-2"><input type="checkbox" checked class="rounded border-slate-900"> <span>Kirim pemberitahuan tenggat kuis melalui email</span></label>
                                <label class="flex items-center gap-2"><input type="checkbox" checked class="rounded border-slate-900"> <span>Tampilkan transkripsi Latin pada aksara Jawa secara default</span></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 03. DASHBOARD SISWA
    # -------------------------------------------------------------
    screens.append("""
    <!-- 03. DASHBOARD SISWA -->
    <section id="wf-03" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-03</span>
                <span class="font-bold text-slate-900 text-sm">UI Dashboard Pelajar & Ruang Kelas Saya</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Peran: Siswa</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">📊 Beranda & Kelas [Aktif]</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📅 Kalender Pembelajaran</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📜 Modul Aksara Jawa</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎵 Tembang Macapat</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎭 Pewayangan Jawa</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📖 Kamus Kosakata</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🌐 Translator Jawa</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🔖 Bookmark Saya</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="bg-white border-2 border-slate-900 p-6 rounded-xl flex justify-between items-center shadow-sm">
                    <div class="space-y-1.5">
                        <span class="border border-slate-900 bg-slate-100 text-[10px] font-mono font-bold px-2.5 py-0.5 rounded uppercase">[Banner Sambutan Siswa]</span>
                        <h3 class="text-2xl font-black text-slate-900 uppercase">Sugeng Rawuh, Budi Santoso!</h3>
                        <p class="text-xs text-slate-600 font-mono">Selamat belajar di Ruang Kelas Bahasa Jawa X-A. Periksa materi dan jadwal evaluasi hari ini.</p>
                    </div>
                    <button class="px-5 py-2.5 bg-slate-900 text-white font-bold text-xs rounded-lg border-2 border-slate-900 uppercase font-mono">[Button] Masuk Ke Kelas</button>
                </div>
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 space-y-2">
                        <div class="w-8 h-8 bg-slate-200 border border-slate-900 rounded flex items-center justify-center font-mono font-bold text-xs">[01]</div>
                        <h4 class="font-bold text-xs text-slate-900 uppercase">Aksara Jawa</h4>
                        <p class="text-[11px] text-slate-600 font-mono">20 Aksara Nglegena, Pasangan, Sandhangan.</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 space-y-2">
                        <div class="w-8 h-8 bg-slate-200 border border-slate-900 rounded flex items-center justify-center font-mono font-bold text-xs">[02]</div>
                        <h4 class="font-bold text-xs text-slate-900 uppercase">Tembang Macapat</h4>
                        <p class="text-[11px] text-slate-600 font-mono">11 Pupuh Macapat, Guru Lagu & Audio TTS.</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 space-y-2">
                        <div class="w-8 h-8 bg-slate-200 border border-slate-900 rounded flex items-center justify-center font-mono font-bold text-xs">[03]</div>
                        <h4 class="font-bold text-xs text-slate-900 uppercase">Pewayangan Jawa</h4>
                        <p class="text-[11px] text-slate-600 font-mono">Pandawa Lima, Punokawan & Kurawa.</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 space-y-2">
                        <div class="w-8 h-8 bg-slate-200 border border-slate-900 rounded flex items-center justify-center font-mono font-bold text-xs">[04]</div>
                        <h4 class="font-bold text-xs text-slate-900 uppercase">Translator Jawa</h4>
                        <p class="text-[11px] text-slate-600 font-mono">Alih Bahasa Ngoko & Krama Madya/Inggil.</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-2 space-y-4">
                        <div class="flex justify-between items-center border-b-2 border-slate-900 pb-2">
                            <h4 class="font-black text-sm uppercase tracking-tight text-slate-900">Ruang Kelas Saya (Semester Genap)</h4>
                            <button class="text-xs font-mono font-bold border border-slate-900 px-3 py-1 rounded bg-white">+ Gabung Kelas Lain</button>
                        </div>
                        <div class="bg-white p-5 rounded-xl border-2 border-slate-900 flex justify-between items-center shadow-sm">
                            <div class="space-y-1.5">
                                <span class="bg-slate-100 border border-slate-900 text-[10px] font-mono font-bold px-2 py-0.5 rounded uppercase">KODE KELAS: JWX26</span>
                                <h5 class="font-extrabold text-base text-slate-900">Bahasa Jawa X-A (Wajib)</h5>
                                <p class="text-xs text-slate-600 font-mono">Pengajar: Pak Guru Budi, S.Pd. • 32 Pelajar Terdaftar</p>
                                <div class="flex items-center gap-2 pt-1 text-[11px] font-mono text-slate-500">
                                    <span>[Progres Pembelajaran: Minggu ke-4 / 16 Minggu]</span>
                                </div>
                            </div>
                            <button class="px-4 py-2.5 bg-slate-900 text-white font-bold text-xs rounded-lg uppercase font-mono">[Button] Buka Kelas</button>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-4">
                        <h4 class="font-black text-xs uppercase tracking-tight text-slate-900 border-b pb-2">⏰ Tenggat Tugas & Kuis</h4>
                        <div class="p-3 bg-slate-50 border border-slate-400 rounded-lg space-y-1 text-xs font-mono">
                            <span class="bg-slate-200 border border-slate-900 text-[9px] font-bold px-1.5 py-0.5 rounded">TUGAS MANDIRI</span>
                            <div class="font-bold text-slate-900">Menulis Aksara Jawa Legena</div>
                            <div class="text-[10px] text-slate-600">Batas: Kamis, 23:59 WIB</div>
                        </div>
                        <div class="p-3 bg-slate-50 border border-slate-400 rounded-lg space-y-1 text-xs font-mono">
                            <span class="bg-slate-900 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">EVALUASI / KUIS</span>
                            <div class="font-bold text-slate-900">Kuis 01: Kaidah Macapat</div>
                            <div class="text-[10px] text-slate-600">Batas: Jumat, 14:00 WIB</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 04. KALENDER PEMBELAJARAN
    # -------------------------------------------------------------
    screens.append("""
    <!-- 04. KALENDER PEMBELAJARAN -->
    <section id="wf-04" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-04</span>
                <span class="font-bold text-slate-900 text-sm">UI Kalender Pembelajaran & Jadwal Kelas</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa / Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📊 Beranda & Kelas</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">📅 Kalender [Aktif]</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📜 Modul Aksara Jawa</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎵 Tembang Macapat</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎭 Pewayangan Jawa</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="bg-white p-5 rounded-xl border-2 border-slate-900 flex justify-between items-center shadow-sm">
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-black text-slate-900 uppercase font-mono">📅 Kalender Pembelajaran & Tenggat</h3>
                        <span class="bg-slate-100 border border-slate-900 text-slate-900 text-xs font-bold px-3 py-1 rounded font-mono">September 2026</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="px-3 py-1.5 border-2 border-slate-900 bg-white font-mono text-xs font-bold rounded">&lt; Bulan Lalu</button>
                        <button class="px-3 py-1.5 border-2 border-slate-900 bg-slate-900 text-white font-mono text-xs font-bold rounded">Bulan Depan &gt;</button>
                        <button class="px-3 py-1.5 border-2 border-slate-900 bg-white font-mono text-xs font-bold rounded">📥 Ekspor PDF/ICS</button>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-2 bg-white p-6 rounded-xl border-2 border-slate-900 space-y-3">
                        <div class="grid grid-cols-7 gap-2 text-center text-xs font-mono font-bold text-slate-700 border-b-2 border-slate-900 pb-2">
                            <span>SENIN</span><span>SELASA</span><span>RABU</span><span>KAMIS</span><span>JUMAT</span><span>SABTU</span><span>MINGGU</span>
                        </div>
                        <div class="grid grid-cols-7 gap-2 text-center text-xs font-mono">
                            <div class="p-3 bg-slate-100 text-slate-400 rounded border border-slate-200">31</div>
                            <div class="p-3 bg-white border border-slate-300 rounded">1</div>
                            <div class="p-3 bg-slate-900 text-white font-bold rounded border-2 border-slate-900">2 <span class="block text-[8px]">[Hari Ini]</span></div>
                            <div class="p-3 bg-slate-100 border-2 border-slate-900 rounded font-bold">3 <span class="block text-[8px] bg-slate-200 rounded mt-0.5">📝 Tugas 1</span></div>
                            <div class="p-3 bg-white border border-slate-300 rounded">4</div>
                            <div class="p-3 bg-white border border-slate-300 rounded">5</div>
                            <div class="p-3 bg-white border border-slate-300 rounded">6</div>
                            <!-- Row 2 -->
                            <div class="p-3 bg-slate-100 border-2 border-slate-900 rounded font-bold">7 <span class="block text-[8px] bg-slate-900 text-white rounded mt-0.5">🎯 Kuis 1</span></div>
                            <div class="p-3 bg-white border border-slate-300 rounded">8</div>
                            <div class="p-3 bg-white border border-slate-300 rounded">9</div>
                            <div class="p-3 bg-white border border-slate-300 rounded">10</div>
                            <div class="p-3 bg-slate-100 border-2 border-slate-900 rounded font-bold">11 <span class="block text-[8px] bg-slate-200 rounded mt-0.5">📝 Tugas 2</span></div>
                            <div class="p-3 bg-white border border-slate-300 rounded">12</div>
                            <div class="p-3 bg-white border border-slate-300 rounded">13</div>
                            <!-- Row 3 -->
                            <div class="p-3 bg-white border border-slate-300 rounded">14</div>
                            <div class="p-3 bg-white border border-slate-300 rounded">15</div>
                            <div class="p-3 bg-white border border-slate-300 rounded">16</div>
                            <div class="p-3 bg-white border border-slate-300 rounded">17</div>
                            <div class="p-3 bg-slate-100 border-2 border-slate-900 rounded font-bold">18 <span class="block text-[8px] bg-slate-900 text-white rounded mt-0.5">🎯 UTS</span></div>
                            <div class="p-3 bg-white border border-slate-300 rounded">19</div>
                            <div class="p-3 bg-white border border-slate-300 rounded">20</div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-4">
                        <h4 class="font-black text-xs uppercase font-mono border-b pb-2">Rincian Agenda Bulan Ini</h4>
                        <div class="p-3 bg-slate-50 border-2 border-slate-900 rounded-lg space-y-1 font-mono text-xs">
                            <span class="border border-slate-900 bg-white text-[9px] font-bold px-1 rounded uppercase">Tenggat Tugas Mandiri</span>
                            <div class="font-bold text-slate-900 pt-1">Menulis Aksara Jawa Legena</div>
                            <div class="text-[10px] text-slate-500">Kamis, 3 Sep 2026 • 23:59 WIB</div>
                        </div>
                        <div class="p-3 bg-slate-50 border-2 border-slate-900 rounded-lg space-y-1 font-mono text-xs">
                            <span class="border border-slate-900 bg-slate-900 text-white text-[9px] font-bold px-1 rounded uppercase">Evaluasi Kuis Interaktif</span>
                            <div class="font-bold text-slate-900 pt-1">Kuis Kaidah Macapat Kinanthi</div>
                            <div class="text-[10px] text-slate-500">Senin, 7 Sep 2026 • 14:00 WIB</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 05. MODUL AKSARA JAWA (KATALOG)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 05. MODUL AKSARA JAWA (KATALOG) -->
    <section id="wf-05" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-05</span>
                <span class="font-bold text-slate-900 text-sm">UI Modul Pembelajaran Aksara Jawa (Katalog Siswa)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📊 Beranda & Kelas</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📅 Kalender</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">📜 Modul Aksara [Aktif]</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎵 Tembang Macapat</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎭 Pewayangan Jawa</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">📜 Pembelajaran Aksara Jawa Hanacaraka</h2>
                        <p class="text-xs text-slate-600 font-mono">Pelajari 20 Aksara Nglegena dasar, aturan Pasangan, dan Sandhangan swara/panyigeg.</p>
                    </div>
                    <div class="flex gap-2 font-mono text-xs">
                        <button class="px-4 py-2 bg-slate-900 text-white font-bold rounded-lg border-2 border-slate-900 uppercase">[Tab] Nglegena (20)</button>
                        <button class="px-4 py-2 bg-white text-slate-900 font-bold rounded-lg border-2 border-slate-900 uppercase">[Tab] Sandhangan</button>
                        <button class="px-4 py-2 bg-white text-slate-900 font-bold rounded-lg border-2 border-slate-900 uppercase">[Tab] Pasangan</button>
                    </div>
                </div>
                <div class="grid grid-cols-5 gap-4">
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 text-center space-y-2">
                        <div class="text-3xl font-bold font-mono">ꦲ</div>
                        <div class="font-extrabold text-sm font-mono text-slate-900">HA (Ha/A)</div>
                        <div class="text-[10px] text-slate-500 font-mono">[Hana / Urip]</div>
                        <button class="w-full py-1 text-[11px] font-mono font-bold border border-slate-900 rounded bg-slate-100">[Detail]</button>
                    </div>
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 text-center space-y-2">
                        <div class="text-3xl font-bold font-mono">ꦤ</div>
                        <div class="font-extrabold text-sm font-mono text-slate-900">NA (Na)</div>
                        <div class="text-[10px] text-slate-500 font-mono">[Wujud / Ada]</div>
                        <button class="w-full py-1 text-[11px] font-mono font-bold border border-slate-900 rounded bg-slate-100">[Detail]</button>
                    </div>
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 text-center space-y-2">
                        <div class="text-3xl font-bold font-mono">ꦕ</div>
                        <div class="font-extrabold text-sm font-mono text-slate-900">CA (Ca)</div>
                        <div class="text-[10px] text-slate-500 font-mono">[Cipta / Rasa]</div>
                        <button class="w-full py-1 text-[11px] font-mono font-bold border border-slate-900 rounded bg-slate-100">[Detail]</button>
                    </div>
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 text-center space-y-2">
                        <div class="text-3xl font-bold font-mono">ꦫ</div>
                        <div class="font-extrabold text-sm font-mono text-slate-900">RA (Ra)</div>
                        <div class="text-[10px] text-slate-500 font-mono">[Jiwa / Roh]</div>
                        <button class="w-full py-1 text-[11px] font-mono font-bold border border-slate-900 rounded bg-slate-100">[Detail]</button>
                    </div>
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 text-center space-y-2">
                        <div class="text-3xl font-bold font-mono">ꦏ</div>
                        <div class="font-extrabold text-sm font-mono text-slate-900">KA (Ka)</div>
                        <div class="text-[10px] text-slate-500 font-mono">[Karsa / Karya]</div>
                        <button class="w-full py-1 text-[11px] font-mono font-bold border border-slate-900 rounded bg-slate-100">[Detail]</button>
                    </div>
                    <!-- Row 2 -->
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 text-center space-y-2"><div class="text-3xl font-bold font-mono">ꦢ</div><div class="font-extrabold text-sm font-mono">DA (Da)</div><div class="text-[10px] text-slate-500 font-mono">[Dzat Ilahi]</div><button class="w-full py-1 text-[11px] font-mono font-bold border border-slate-900 rounded bg-slate-100">[Detail]</button></div>
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 text-center space-y-2"><div class="text-3xl font-bold font-mono">ꦠ</div><div class="font-extrabold text-sm font-mono">TA (Ta)</div><div class="text-[10px] text-slate-500 font-mono">[Tetes / Getar]</div><button class="w-full py-1 text-[11px] font-mono font-bold border border-slate-900 rounded bg-slate-100">[Detail]</button></div>
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 text-center space-y-2"><div class="text-3xl font-bold font-mono">ꦱ</div><div class="font-extrabold text-sm font-mono">SA (Sa)</div><div class="text-[10px] text-slate-500 font-mono">[Sifat Sejati]</div><button class="w-full py-1 text-[11px] font-mono font-bold border border-slate-900 rounded bg-slate-100">[Detail]</button></div>
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 text-center space-y-2"><div class="text-3xl font-bold font-mono">ꦮ</div><div class="font-extrabold text-sm font-mono">WA (Wa)</div><div class="text-[10px] text-slate-500 font-mono">[Wujud Alam]</div><button class="w-full py-1 text-[11px] font-mono font-bold border border-slate-900 rounded bg-slate-100">[Detail]</button></div>
                    <div class="bg-white p-4 rounded-xl border-2 border-slate-900 text-center space-y-2"><div class="text-3xl font-bold font-mono">ꦭ</div><div class="font-extrabold text-sm font-mono">LA (La)</div><div class="text-[10px] text-slate-500 font-mono">[Langgeng]</div><button class="w-full py-1 text-[11px] font-mono font-bold border border-slate-900 rounded bg-slate-100">[Detail]</button></div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 06. MODUL AKSARA JAWA (DETAIL & LATIHAN)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 06. MODUL AKSARA JAWA (DETAIL & LATIHAN) -->
    <section id="wf-06" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-06</span>
                <span class="font-bold text-slate-900 text-sm">UI Detail Aksara Jawa & Uraian Suku Kata</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">&lt; Kembali ke Katalog</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">📜 Detail Aksara HA</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <span class="border border-slate-900 bg-slate-100 text-[10px] font-mono font-bold px-2 py-0.5 rounded uppercase">Aksara Nglegena No. 01</span>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono mt-1">Detail Aksara: ꦲ (HA)</h2>
                    </div>
                    <button class="px-4 py-2 border-2 border-slate-900 bg-white font-mono text-xs font-bold rounded">&lt; Kembali ke Daftar Aksara</button>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl border-2 border-slate-900 text-center space-y-4">
                        <div class="w-32 h-32 bg-slate-100 border-2 border-slate-900 rounded-xl mx-auto flex items-center justify-center text-6xl font-bold font-mono">ꦲ</div>
                        <div class="space-y-1">
                            <h4 class="font-black text-lg font-mono">HA / A</h4>
                            <p class="text-xs text-slate-600 font-mono">Pelafalan Fonetik: /ha/ atau /a/</p>
                        </div>
                        <div class="p-3 bg-slate-50 border border-slate-400 rounded-lg text-left text-xs font-mono space-y-1.5">
                            <div><span class="text-slate-500">Pasangan:</span> <span class="font-bold">꧀ꦲ (Pasangan Ha)</span></div>
                            <div><span class="text-slate-500">Filosofi:</span> <span class="font-bold">Hana Huruf / Urip Hidup</span></div>
                            <div><span class="text-slate-500">Kategori:</span> <span class="font-bold">Nglegena Dasar</span></div>
                        </div>
                    </div>
                    <div class="col-span-2 space-y-4">
                        <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-3">
                            <h4 class="font-bold text-sm text-slate-900 uppercase font-mono border-b pb-2">Panduan Goresan / Stroke Penulisan</h4>
                            <div class="w-full h-32 bg-slate-100 border-2 border-dashed border-slate-400 rounded-lg flex flex-col items-center justify-center font-mono text-xs text-slate-500">
                                <svg class="w-8 h-8 mb-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                <span>[Diagram Animasi / Langkah Goresan Aksara HA (1 → 2 → 3)]</span>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-3">
                            <h4 class="font-bold text-sm text-slate-900 uppercase font-mono border-b pb-2">Contoh Penggunaan Kata & Pemenggalan Suku Kata</h4>
                            <div class="space-y-2 text-xs font-mono">
                                <div class="p-3 bg-slate-50 border border-slate-300 rounded flex justify-between items-center">
                                    <div><span class="font-bold text-slate-900 text-sm">Hana (ꦲꦤ)</span> — Ada / Tercipta</div>
                                    <span class="bg-slate-200 px-2 py-0.5 rounded text-[10px]">Suku Kata: Ha - Na</span>
                                </div>
                                <div class="p-3 bg-slate-50 border border-slate-300 rounded flex justify-between items-center">
                                    <div><span class="font-bold text-slate-900 text-sm">Hawa (ꦲꦮ)</span> — Udara / Atmosfer</div>
                                    <span class="bg-slate-200 px-2 py-0.5 rounded text-[10px]">Suku Kata: Ha - Wa</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 07. MODUL TEMBANG MACAPAT (KATALOG)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 07. MODUL TEMBANG MACAPAT (KATALOG) -->
    <section id="wf-07" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-07</span>
                <span class="font-bold text-slate-900 text-sm">UI Modul Pembelajaran Tembang Macapat (Katalog Siswa)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📊 Beranda & Kelas</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📜 Modul Aksara Jawa</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🎵 Tembang Macapat [Aktif]</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎭 Pewayangan Jawa</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">🎵 Khazanah 11 Tembang Macapat</h2>
                        <p class="text-xs text-slate-600 font-mono">Pelajari filosofi tahapan hidup manusia melalui sastra tembang macapat klasik Jawa.</p>
                    </div>
                    <div class="border border-slate-900 bg-white font-mono text-xs px-3 py-1.5 rounded font-bold">Total: 11 Pupuh Macapat</div>
                </div>
                <div class="grid grid-cols-3 gap-5">
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3 shadow-sm">
                        <div class="flex justify-between items-center">
                            <span class="bg-slate-100 border border-slate-900 text-[10px] font-mono font-bold px-2 py-0.5 rounded uppercase">Pupuh 01</span>
                            <span class="text-xs font-mono font-bold text-slate-500">6 Gatra</span>
                        </div>
                        <h4 class="font-black text-lg text-slate-900 font-mono">Kinanthi</h4>
                        <p class="text-xs text-slate-600 font-mono">Watak: Mesra, asih, gandrung, piwulang becik kanthi rasa tresna.</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-400 rounded text-[11px] font-mono">
                            <span class="font-bold">Kaidah Guru Lagu & Wilangan:</span><br>
                            8u, 8i, 8a, 8i, 8a, 8i
                        </div>
                        <button class="w-full py-2 bg-slate-900 text-white font-mono font-bold text-xs rounded border border-slate-900">[Button] Buka Materi & Audio</button>
                    </div>
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3 shadow-sm">
                        <div class="flex justify-between items-center">
                            <span class="bg-slate-100 border border-slate-900 text-[10px] font-mono font-bold px-2 py-0.5 rounded uppercase">Pupuh 02</span>
                            <span class="text-xs font-mono font-bold text-slate-500">9 Gatra</span>
                        </div>
                        <h4 class="font-black text-lg text-slate-900 font-mono">Sinom</h4>
                        <p class="text-xs text-slate-600 font-mono">Watak: Grapyak, sumanak, tinarbuka, cocok kanggo sesorah.</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-400 rounded text-[11px] font-mono">
                            <span class="font-bold">Kaidah Guru Lagu & Wilangan:</span><br>
                            8a, 8i, 8a, 8i, 7i, 8u, 7a, 8i, 12a
                        </div>
                        <button class="w-full py-2 bg-slate-900 text-white font-mono font-bold text-xs rounded border border-slate-900">[Button] Buka Materi & Audio</button>
                    </div>
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3 shadow-sm">
                        <div class="flex justify-between items-center">
                            <span class="bg-slate-100 border border-slate-900 text-[10px] font-mono font-bold px-2 py-0.5 rounded uppercase">Pupuh 03</span>
                            <span class="text-xs font-mono font-bold text-slate-500">10 Gatra</span>
                        </div>
                        <h4 class="font-black text-lg text-slate-900 font-mono">Dhandhanggula</h4>
                        <p class="text-xs text-slate-600 font-mono">Watak: Luwes, ngresepake, manis, cocog kanggo pambuka crita.</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-400 rounded text-[11px] font-mono">
                            <span class="font-bold">Kaidah Guru Lagu & Wilangan:</span><br>
                            10i, 10a, 8e, 7u, 9i, 7a, 6u, 8a, 12i, 7a
                        </div>
                        <button class="w-full py-2 bg-slate-900 text-white font-mono font-bold text-xs rounded border border-slate-900">[Button] Buka Materi & Audio</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 08. MODUL TEMBANG MACAPAT (DETAIL & AUDIO)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 08. MODUL TEMBANG MACAPAT (DETAIL & AUDIO) -->
    <section id="wf-08" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-08</span>
                <span class="font-bold text-slate-900 text-sm">UI Detail Pupuh Macapat & Audio Melodi Tembang</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">&lt; Kembali ke Katalog</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🎵 Kinanthi (Detail)</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <span class="border border-slate-900 bg-slate-100 text-[10px] font-mono font-bold px-2 py-0.5 rounded uppercase">Pupuh Macapat No. 01</span>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono mt-1">Pupuh Kinanthi — Bait 1 & Audio Cengkok</h2>
                    </div>
                    <button class="px-4 py-2 border-2 border-slate-900 bg-white font-mono text-xs font-bold rounded">&lt; Kembali ke Katalog Macapat</button>
                </div>
                <!-- Audio Player Wireframe -->
                <div class="bg-white p-5 rounded-xl border-2 border-slate-900 flex items-center justify-between gap-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <button class="w-12 h-12 bg-slate-900 text-white rounded-full flex items-center justify-center font-bold text-sm border-2 border-slate-900 font-mono">▶</button>
                        <div>
                            <h4 class="font-bold text-sm font-mono text-slate-900">Audio Tembang Kinanthi Slendro Manyura</h4>
                            <p class="text-[11px] text-slate-500 font-mono">Pelaras: Nyi Condrolukito • Durasi: 02:45</p>
                        </div>
                    </div>
                    <div class="flex-1 px-4">
                        <div class="w-full bg-slate-200 h-2 rounded-full border border-slate-400 relative">
                            <div class="bg-slate-900 h-2 rounded-full w-1/3"></div>
                        </div>
                        <div class="flex justify-between text-[10px] font-mono text-slate-500 pt-1">
                            <span>00:55</span><span>02:45</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="px-3 py-1.5 border border-slate-900 rounded font-mono text-xs bg-slate-100">🔊 100%</button>
                        <button class="px-3 py-1.5 border border-slate-900 rounded font-mono text-xs bg-slate-100">Speed: 1.0x</button>
                    </div>
                </div>
                <!-- Lyrics & Translation -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-4">
                        <h4 class="font-bold text-xs uppercase font-mono border-b pb-2">Cakepan Tembang Jawa (Serat Wulangreh)</h4>
                        <div class="space-y-3 font-mono text-sm leading-relaxed text-slate-900">
                            <p>1. Padha gulangen ing kalbu, (8u)</p>
                            <p>2. Ing sasmita amrih lantip, (8i)</p>
                            <p>3. Aja sira dhemen mangan, (8a)</p>
                            <p>4. Lan aja dhemen nendra guling, (8i)</p>
                            <p>5. Cegaha hawa nepsu, (8a)</p>
                            <p>6. Dimen luhur budi pekerti. (8i)</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-4">
                        <h4 class="font-bold text-xs uppercase font-mono border-b pb-2">Terjemahan Bahasa Indonesia & Makna Filosofis</h4>
                        <div class="space-y-3 font-mono text-xs leading-relaxed text-slate-700">
                            <p>1. Biasakanlah melatih kepekaan batinmu,</p>
                            <p>2. Agar tajam menangkap isyarat kebaikan,</p>
                            <p>3. Janganlah hanya gemar makan kenyang,</p>
                            <p>4. Dan janganlah suka tidur bermalas-malasan,</p>
                            <p>5. Kekanglah hawa nafsu keduniawian,</p>
                            <p>6. Agar martabat serta budi pekertimu menjadi mulia.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 09. MODUL PEWAYANGAN JAWA (KATALOG)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 09. MODUL PEWAYANGAN JAWA (KATALOG) -->
    <section id="wf-09" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-09</span>
                <span class="font-bold text-slate-900 text-sm">UI Modul Pewayangan Jawa (Katalog Tokoh Siswa)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📊 Beranda & Kelas</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📜 Modul Aksara Jawa</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎵 Tembang Macapat</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🎭 Pewayangan [Aktif]</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">🎭 Galeri Karakter Tokoh Pewayangan Jawa</h2>
                        <p class="text-xs text-slate-600 font-mono">Telusuri tokoh Pandawa Lima, Punokawan, dan Kurawa beserta watak luhurnya.</p>
                    </div>
                    <div class="flex gap-2 font-mono text-xs">
                        <button class="px-3.5 py-1.5 bg-slate-900 text-white font-bold rounded-lg border-2 border-slate-900 uppercase">[Filter] Semua</button>
                        <button class="px-3.5 py-1.5 bg-white text-slate-900 font-bold rounded-lg border-2 border-slate-900 uppercase">Pandawa Lima</button>
                        <button class="px-3.5 py-1.5 bg-white text-slate-900 font-bold rounded-lg border-2 border-slate-900 uppercase">Punokawan</button>
                        <button class="px-3.5 py-1.5 bg-white text-slate-900 font-bold rounded-lg border-2 border-slate-900 uppercase">Kurawa</button>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-5">
                    <!-- Yudhistira -->
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3 text-center shadow-sm">
                        <div class="w-full h-36 bg-slate-100 border-2 border-dashed border-slate-400 rounded-lg flex flex-col items-center justify-center font-mono text-[10px] text-slate-500">
                            <svg class="w-8 h-8 mb-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>[Ilustrasi: Puntadewa / Yudhistira]</span>
                        </div>
                        <div>
                            <span class="border border-slate-900 bg-slate-100 text-[9px] font-mono font-bold px-2 py-0.5 rounded uppercase">PANDAWA LIMA</span>
                            <h4 class="font-black text-base text-slate-900 font-mono mt-1">Raden Puntadewa</h4>
                            <p class="text-[11px] text-slate-500 font-mono">Watak: Sabar, ikhlas, adil, jujur getih putih.</p>
                        </div>
                        <button class="w-full py-1.5 bg-slate-900 text-white font-mono font-bold text-xs rounded border border-slate-900">[Button] Lihat Biodata</button>
                    </div>
                    <!-- Werkudara -->
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3 text-center shadow-sm">
                        <div class="w-full h-36 bg-slate-100 border-2 border-dashed border-slate-400 rounded-lg flex flex-col items-center justify-center font-mono text-[10px] text-slate-500">
                            <svg class="w-8 h-8 mb-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>[Ilustrasi: Werkudara / Bima]</span>
                        </div>
                        <div>
                            <span class="border border-slate-900 bg-slate-100 text-[9px] font-mono font-bold px-2 py-0.5 rounded uppercase">PANDAWA LIMA</span>
                            <h4 class="font-black text-base text-slate-900 font-mono mt-1">Raden Werkudara</h4>
                            <p class="text-[11px] text-slate-500 font-mono">Watak: Gagah berani, teguh, pembela kebenaran.</p>
                        </div>
                        <button class="w-full py-1.5 bg-slate-900 text-white font-mono font-bold text-xs rounded border border-slate-900">[Button] Lihat Biodata</button>
                    </div>
                    <!-- Janaka -->
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3 text-center shadow-sm">
                        <div class="w-full h-36 bg-slate-100 border-2 border-dashed border-slate-400 rounded-lg flex flex-col items-center justify-center font-mono text-[10px] text-slate-500">
                            <svg class="w-8 h-8 mb-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>[Ilustrasi: Janaka / Arjuna]</span>
                        </div>
                        <div>
                            <span class="border border-slate-900 bg-slate-100 text-[9px] font-mono font-bold px-2 py-0.5 rounded uppercase">PANDAWA LIMA</span>
                            <h4 class="font-black text-base text-slate-900 font-mono mt-1">Raden Janaka</h4>
                            <p class="text-[11px] text-slate-500 font-mono">Watak: Alus, pinter jemparing, luhur budi pekerti.</p>
                        </div>
                        <button class="w-full py-1.5 bg-slate-900 text-white font-mono font-bold text-xs rounded border border-slate-900">[Button] Lihat Biodata</button>
                    </div>
                    <!-- Semar -->
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3 text-center shadow-sm">
                        <div class="w-full h-36 bg-slate-100 border-2 border-dashed border-slate-400 rounded-lg flex flex-col items-center justify-center font-mono text-[10px] text-slate-500">
                            <svg class="w-8 h-8 mb-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>[Ilustrasi: Kyai Semar Badranaya]</span>
                        </div>
                        <div>
                            <span class="border border-slate-900 bg-slate-100 text-[9px] font-mono font-bold px-2 py-0.5 rounded uppercase">PUNOKAWAN</span>
                            <h4 class="font-black text-base text-slate-900 font-mono mt-1">Kyai Semar</h4>
                            <p class="text-[11px] text-slate-500 font-mono">Watak: Wicaksana, pamomong ksatria, andhap asor.</p>
                        </div>
                        <button class="w-full py-1.5 bg-slate-900 text-white font-mono font-bold text-xs rounded border border-slate-900">[Button] Lihat Biodata</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 10. MODUL PEWAYANGAN JAWA (DETAIL TOKOH)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 10. MODUL PEWAYANGAN JAWA (DETAIL TOKOH) -->
    <section id="wf-10" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-10</span>
                <span class="font-bold text-slate-900 text-sm">UI Detail Tokoh Pewayangan, Karakteristik & Pusaka</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">&lt; Kembali ke Katalog</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🎭 Detail Werkudara</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <span class="border border-slate-900 bg-slate-100 text-[10px] font-mono font-bold px-2 py-0.5 rounded uppercase">Satria Panenggak Pandawa</span>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono mt-1">Raden Werkudara (Bima Sena)</h2>
                    </div>
                    <button class="px-4 py-2 border-2 border-slate-900 bg-white font-mono text-xs font-bold rounded">&lt; Kembali ke Katalog Tokoh</button>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-4 text-center">
                        <div class="w-full h-56 bg-slate-100 border-2 border-dashed border-slate-400 rounded-lg flex flex-col items-center justify-center font-mono text-xs text-slate-500">
                            <svg class="w-12 h-12 mb-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>[Ilustrasi Tokoh: Raden Werkudara]</span>
                        </div>
                        <div class="p-3 bg-slate-50 border border-slate-400 rounded-lg text-left text-xs font-mono space-y-1.5">
                            <div><span class="text-slate-500">Kasatriyan:</span> <span class="font-bold">Jipang / Tunggul Pamenang</span></div>
                            <div><span class="text-slate-500">Pusaka Utama:</span> <span class="font-bold">Kuku Pancanaka, Gada Rujakpala</span></div>
                            <div><span class="text-slate-500">Aji-Aji:</span> <span class="font-bold">Bandung Bondowoso, Blabag Pengantol-antol</span></div>
                        </div>
                    </div>
                    <div class="col-span-2 space-y-4">
                        <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-3">
                            <h4 class="font-bold text-xs uppercase font-mono border-b pb-2">Watak & Falsafah Hidup</h4>
                            <p class="text-xs font-mono text-slate-700 leading-relaxed">
                                Raden Werkudara minangka panenggak Pandawa. Dikenal minangka ksatria kang ora tau nganggo basa krama marang sapa wae kajaba marang Dewa Ruci (gurune sejati). Dheweke tansah jujur, blak-kotang, teguh ing janji, lan ora wedi marang pati menawa mbela bebener.
                            </p>
                        </div>
                        <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-3">
                            <h4 class="font-bold text-xs uppercase font-mono border-b pb-2">Silsilah & Trah Keluarga</h4>
                            <div class="grid grid-cols-2 gap-3 text-xs font-mono">
                                <div class="p-3 bg-slate-50 border border-slate-300 rounded">
                                    <span class="text-slate-500">Rama & Ibu:</span>
                                    <div class="font-bold text-slate-900">Prabu Pandu Dewanata & Dewi Kunti</div>
                                </div>
                                <div class="p-3 bg-slate-50 border border-slate-300 rounded">
                                    <span class="text-slate-500">Putra-Putra:</span>
                                    <div class="font-bold text-slate-900">Raden Gatotkaca, Antareja, Antasena</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 11. KAMUS KOSAKATA BASA JAWA
    # -------------------------------------------------------------
    screens.append("""
    <!-- 11. KAMUS KOSAKATA BASA JAWA -->
    <section id="wf-11" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-11</span>
                <span class="font-bold text-slate-900 text-sm">UI Kamus Kosakata Basa Jawa (Pencarian & Tingkatan Bahasa)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa / Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📊 Beranda & Kelas</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">📖 Kamus Kosakata [Aktif]</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🌐 Translator Jawa</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4">
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">📖 Kamus Kosakata & Unggah-Ungguh Basa Jawa</h2>
                    <p class="text-xs text-slate-600 font-mono">Cari padanan tembung Ngoko, Krama Madya, Krama Inggil, dan terjemahan bahasa Indonesia.</p>
                </div>
                <!-- Search Bar Wireframe -->
                <div class="bg-white p-4 rounded-xl border-2 border-slate-900 flex gap-3">
                    <div class="flex-1 p-3 bg-slate-50 border-2 border-slate-900 rounded-lg font-mono text-xs flex items-center justify-between">
                        <span>Ketik kata (misal: mangan, sare, tindak, omahe)...</span>
                        <span class="text-slate-400">[Search Input]</span>
                    </div>
                    <select class="px-3 bg-white border-2 border-slate-900 rounded-lg font-mono text-xs font-bold">
                        <option>Semua Tingkatan Basa</option>
                        <option>Ngoko Lugas</option>
                        <option>Krama Madya</option>
                        <option>Krama Inggil</option>
                    </select>
                    <button class="px-6 py-3 bg-slate-900 text-white font-bold rounded-lg border-2 border-slate-900 uppercase font-mono text-xs">[Button] Cari Kata</button>
                </div>
                <!-- Word Entries Table Wireframe -->
                <div class="bg-white rounded-xl border-2 border-slate-900 overflow-hidden">
                    <div class="grid grid-cols-5 p-3.5 bg-slate-100 border-b-2 border-slate-900 font-mono text-xs font-bold text-slate-800">
                        <span>TEMBUNG NGOKO</span>
                        <span>KRAMA MADYA</span>
                        <span>KRAMA INGGIL</span>
                        <span>BAHASA INDONESIA</span>
                        <span class="text-right">AKSI</span>
                    </div>
                    <!-- Row 1 -->
                    <div class="grid grid-cols-5 p-4 border-b border-slate-200 font-mono text-xs items-center hover:bg-slate-50">
                        <span class="font-bold text-slate-900">Mangan</span>
                        <span class="text-slate-700">Nedha</span>
                        <span class="font-bold text-slate-900">Dhahar</span>
                        <span class="text-slate-600">Makan</span>
                        <div class="text-right"><button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold">[Detail / Bookmark]</button></div>
                    </div>
                    <!-- Row 2 -->
                    <div class="grid grid-cols-5 p-4 border-b border-slate-200 font-mono text-xs items-center hover:bg-slate-50">
                        <span class="font-bold text-slate-900">Turu</span>
                        <span class="text-slate-700">Tilem</span>
                        <span class="font-bold text-slate-900">Sare</span>
                        <span class="text-slate-600">Tidur</span>
                        <div class="text-right"><button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold">[Detail / Bookmark]</button></div>
                    </div>
                    <!-- Row 3 -->
                    <div class="grid grid-cols-5 p-4 border-b border-slate-200 font-mono text-xs items-center hover:bg-slate-50">
                        <span class="font-bold text-slate-900">Lunga</span>
                        <span class="text-slate-700">Kesah</span>
                        <span class="font-bold text-slate-900">Tindak</span>
                        <span class="text-slate-600">Pergi / Berangkat</span>
                        <div class="text-right"><button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold">[Detail / Bookmark]</button></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 12. TRANSLATOR JAWA
    # -------------------------------------------------------------
    screens.append("""
    <!-- 12. TRANSLATOR JAWA -->
    <section id="wf-12" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-12</span>
                <span class="font-bold text-slate-900 text-sm">UI Penerjemah Multi-Layer Bahasa Jawa (Ngoko & Krama)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa / Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📊 Beranda & Kelas</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📖 Kamus Kosakata</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🌐 Translator Jawa [Aktif]</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4">
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">🌐 Penerjemah Cerdas Bahasa Jawa</h2>
                    <p class="text-xs text-slate-600 font-mono">Terjemahkan kalimat Bahasa Indonesia ke Bahasa Jawa ragam Ngoko, Krama Madya, atau Krama Inggil.</p>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <!-- Source Text Box -->
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3">
                        <div class="flex justify-between items-center border-b pb-2 text-xs font-mono font-bold">
                            <span>BAHASA INDONESIA (SUMBER)</span>
                            <span class="text-slate-400">[Karakter: 42/500]</span>
                        </div>
                        <div class="w-full h-44 p-3 bg-slate-50 border border-slate-300 rounded-lg font-mono text-xs text-slate-800">
                            Saya ingin pergi ke rumah kakek besok pagi.
                        </div>
                        <div class="flex justify-end">
                            <button class="px-4 py-2 bg-slate-900 text-white font-mono text-xs font-bold rounded uppercase">[Button] Terjemahkan Sekarang</button>
                        </div>
                    </div>
                    <!-- Target Text Box -->
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3">
                        <div class="flex justify-between items-center border-b pb-2 text-xs font-mono font-bold">
                            <span>HASIL TERJEMAHAN: JAWA KRAMA ALUS</span>
                            <div class="flex gap-1">
                                <span class="bg-slate-200 px-2 py-0.5 rounded text-[10px]">Ngoko</span>
                                <span class="bg-slate-900 text-white px-2 py-0.5 rounded text-[10px]">Krama Alus</span>
                            </div>
                        </div>
                        <div class="w-full h-44 p-3 bg-slate-100 border-2 border-slate-900 rounded-lg font-mono text-xs text-slate-900 font-bold">
                            Kula badhe sowan dhateng dalemipun eyang benjing enjing.
                        </div>
                        <div class="flex justify-between items-center text-xs font-mono">
                            <span class="text-slate-500 text-[11px]">[Tingkatan tutur: Krama Alus / Inggil]</span>
                            <button class="px-3 py-1.5 border border-slate-900 bg-white font-mono text-xs font-bold rounded">📋 Salin Teks</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 13. BOOKMARK / SIMPANAN MATERI
    # -------------------------------------------------------------
    screens.append("""
    <!-- 13. BOOKMARK / SIMPANAN MATERI -->
    <section id="wf-13" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-13</span>
                <span class="font-bold text-slate-900 text-sm">UI Bookmark & Materi Pembelajaran Disimpan Siswa</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📊 Beranda & Kelas</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🔖 Bookmark [Aktif]</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">🔖 Simpanan Materi & Favorit Saya</h2>
                        <p class="text-xs text-slate-600 font-mono">Daftar modul, slide pembelajaran, dan ringkasan yang ditandai untuk dibaca kembali.</p>
                    </div>
                    <span class="border border-slate-900 bg-white font-mono text-xs px-3 py-1.5 rounded font-bold">Total: 3 Materi Tersimpan</span>
                </div>
                <div class="space-y-4">
                    <div class="p-5 bg-white rounded-xl border-2 border-slate-900 flex justify-between items-center shadow-sm">
                        <div class="space-y-1 font-mono text-xs">
                            <span class="bg-slate-100 border border-slate-900 px-2 py-0.5 rounded font-bold text-[9px] uppercase">MODUL SLIDE PDF • KELAS X-A</span>
                            <h4 class="font-black text-sm text-slate-900">Slide Modul: Aturan Sandhangan Swara & Panyigeg</h4>
                            <p class="text-slate-500">Disimpan pada 24 Agustus 2026 • Guru: Pak Budi, S.Pd.</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1.5 bg-slate-900 text-white text-xs font-bold rounded font-mono">[Buka Materi]</button>
                            <button class="px-3 py-1.5 border border-slate-900 bg-white text-xs font-bold rounded font-mono">[Hapus Pin]</button>
                        </div>
                    </div>
                    <div class="p-5 bg-white rounded-xl border-2 border-slate-900 flex justify-between items-center shadow-sm">
                        <div class="space-y-1 font-mono text-xs">
                            <span class="bg-slate-100 border border-slate-900 px-2 py-0.5 rounded font-bold text-[9px] uppercase">TEMBANG MACAPAT</span>
                            <h4 class="font-black text-sm text-slate-900">Serat Wulangreh: Pupuh Kinanthi 6 Gatra</h4>
                            <p class="text-slate-500">Disimpan pada 28 Agustus 2026</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1.5 bg-slate-900 text-white text-xs font-bold rounded font-mono">[Buka Materi]</button>
                            <button class="px-3 py-1.5 border border-slate-900 bg-white text-xs font-bold rounded font-mono">[Hapus Pin]</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 14. RUANG KELAS SISWA (TIMELINE)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 14. RUANG KELAS SISWA (TIMELINE) -->
    <section id="wf-14" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-14</span>
                <span class="font-bold text-slate-900 text-sm">UI Ruang Kelas Siswa & Timeline Materi/Slide PDF</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Siswa</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🏫 Kelas X-A [Aktif]</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">&lt; Dashboard Siswa</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <!-- Class Header Banner Wireframe -->
                <div class="bg-white p-6 rounded-xl border-2 border-slate-900 flex justify-between items-center shadow-sm">
                    <div class="space-y-1 font-mono">
                        <span class="border border-slate-900 bg-slate-100 text-[10px] font-bold px-2 py-0.5 rounded uppercase">KODE KELAS: JWX26</span>
                        <h2 class="text-2xl font-black text-slate-900 uppercase">Bahasa Jawa X-A SMAN 1 Surakarta</h2>
                        <p class="text-xs text-slate-600">Pengajar: Pak Guru Budi, S.Pd. • 32 Pelajar • Semester Genap 2026/2027</p>
                    </div>
                    <div class="flex gap-2 font-mono text-xs">
                        <button class="px-4 py-2 bg-slate-900 text-white font-bold rounded uppercase">[Tab] Aliran Materi</button>
                        <button class="px-4 py-2 bg-white text-slate-900 font-bold rounded border border-slate-900 uppercase">Daftar Teman</button>
                    </div>
                </div>
                <!-- Week Filter & Posts -->
                <div class="grid grid-cols-4 gap-6">
                    <div class="space-y-2 font-mono text-xs">
                        <div class="font-bold uppercase border-b pb-1 text-slate-700">Daftar Minggu:</div>
                        <div class="p-2 bg-slate-900 text-white font-bold rounded">Week 1 - Pengantar Aksara</div>
                        <div class="p-2 bg-white border border-slate-400 rounded text-slate-700">Week 2 - Pasangan Aksara</div>
                        <div class="p-2 bg-white border border-slate-400 rounded text-slate-700">Week 3 - Sandhangan</div>
                    </div>
                    <div class="col-span-3 space-y-4">
                        <!-- Post Item 1: Material PDF -->
                        <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3">
                            <div class="flex justify-between items-center font-mono text-xs">
                                <span class="bg-slate-100 border border-slate-900 px-2 py-0.5 rounded font-bold text-[9px] uppercase">📖 MATERI PEMBELAJARAN (PDF SLIDE)</span>
                                <span class="text-slate-400">Diposkan: 2 Sep 2026</span>
                            </div>
                            <h4 class="font-black text-base text-slate-900 font-mono">Modul 01: Pengenalan 20 Aksara Nglegena</h4>
                            <p class="text-xs text-slate-600 font-mono">Silakan pelajari slide materi di bawah ini sebelum mengerjakan latihan checkpoint pemahaman.</p>
                            <!-- PDF Reader Wireframe Placeholder -->
                            <div class="w-full h-44 bg-slate-100 border-2 border-dashed border-slate-400 rounded-lg flex flex-col items-center justify-center font-mono text-xs text-slate-500">
                                <svg class="w-8 h-8 mb-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>[Embedded PDF Slide Reader Widget: Halaman 1 dari 12]</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-[11px] font-mono text-slate-500">Checkpoint Slide: Muncul Pertanyaan pada Slide 6</span>
                                <button class="px-4 py-2 bg-slate-900 text-white font-mono text-xs font-bold rounded">[Buka Layar Penuh]</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 15. PENGERJAAN KUIS SISWA
    # -------------------------------------------------------------
    screens.append("""
    <!-- 15. PENGERJAAN KUIS SISWA -->
    <section id="wf-15" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-15</span>
                <span class="font-bold text-slate-900 text-sm">UI Lembar Pengerjaan Evaluasi / Kuis Interaktif</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl p-8 space-y-6">
            <!-- Quiz Header Bar Wireframe -->
            <div class="bg-white p-5 rounded-xl border-2 border-slate-900 flex justify-between items-center shadow-sm">
                <div class="space-y-1 font-mono">
                    <span class="bg-slate-100 border border-slate-900 text-[10px] font-bold px-2 py-0.5 rounded uppercase">EVALUASI MINGGUAN KELAS X-A</span>
                    <h2 class="text-xl font-black text-slate-900 uppercase">Kuis 01: Kaidah Aksara Jawa & Pasangan</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-slate-100 border-2 border-slate-900 rounded-lg text-center font-mono">
                        <span class="text-[9px] text-slate-500 block uppercase">SISA WAKTU</span>
                        <span class="font-black text-lg text-slate-900">24 : 18 Menit</span>
                    </div>
                    <button class="px-5 py-3 bg-slate-900 text-white font-mono font-bold text-xs rounded-lg uppercase">[Submit] Kumpulkan Jawaban</button>
                </div>
            </div>
            <!-- Quiz Body -->
            <div class="grid grid-cols-4 gap-6">
                <!-- Question Card -->
                <div class="col-span-3 bg-white p-6 rounded-xl border-2 border-slate-900 space-y-5">
                    <div class="flex justify-between items-center border-b pb-2 font-mono">
                        <span class="bg-slate-900 text-white text-xs font-bold px-3 py-1 rounded">SOAL NOMOR 01 DARI 10</span>
                        <span class="text-xs text-slate-500">Bobot Nilai: 10 Poin</span>
                    </div>
                    <!-- Question Text & Image Placeholder -->
                    <div class="space-y-3 font-mono">
                        <p class="text-sm font-bold text-slate-900 leading-relaxed">
                            Aksara Jawa ing ngisor iki kang diarani pasangan saka aksara 'NA' yaiku ...
                        </p>
                        <div class="w-full h-32 bg-slate-100 border-2 border-dashed border-slate-400 rounded-lg flex flex-col items-center justify-center font-mono text-xs text-slate-500">
                            <span>[Placeholder Gambar Soal: Diagram Aksara Na]</span>
                        </div>
                    </div>
                    <!-- Multiple Choice Radio Buttons Wireframe -->
                    <div class="space-y-3 font-mono text-xs">
                        <label class="p-3.5 bg-slate-50 border-2 border-slate-900 rounded-lg flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="q1" checked class="w-4 h-4">
                            <span class="font-bold bg-slate-200 border px-2 py-0.5 rounded">A</span>
                            <span>꧀ꦤ (Pasangan Na kang manggon ing sisih tengen jejer aksara)</span>
                        </label>
                        <label class="p-3.5 bg-white border border-slate-400 rounded-lg flex items-center gap-3 cursor-pointer hover:bg-slate-50">
                            <input type="radio" name="q1" class="w-4 h-4">
                            <span class="font-bold bg-slate-200 border px-2 py-0.5 rounded">B</span>
                            <span>꧀ꦲ (Pasangan Ha kang manggon ing sisih tengen jejer aksara)</span>
                        </label>
                        <label class="p-3.5 bg-white border border-slate-400 rounded-lg flex items-center gap-3 cursor-pointer hover:bg-slate-50">
                            <input type="radio" name="q1" class="w-4 h-4">
                            <span class="font-bold bg-slate-200 border px-2 py-0.5 rounded">C</span>
                            <span>꧀ꦕ (Pasangan Ca kang nggandhul ing ngisor aksara)</span>
                        </label>
                        <label class="p-3.5 bg-white border border-slate-400 rounded-lg flex items-center gap-3 cursor-pointer hover:bg-slate-50">
                            <input type="radio" name="q1" class="w-4 h-4">
                            <span class="font-bold bg-slate-200 border px-2 py-0.5 rounded">D</span>
                            <span>꧀ꦫ (Pasangan Ra kang arupa cakra)</span>
                        </label>
                    </div>
                </div>
                <!-- Number Palette Navigator -->
                <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-4 font-mono">
                    <h4 class="font-bold text-xs uppercase border-b pb-2 text-slate-800">Navigasi Butir Soal</h4>
                    <div class="grid grid-cols-5 gap-2 text-center text-xs">
                        <div class="p-2.5 bg-slate-900 text-white font-bold rounded border border-slate-900">1</div>
                        <div class="p-2.5 bg-slate-200 text-slate-800 font-bold rounded border border-slate-400">2</div>
                        <div class="p-2.5 bg-slate-200 text-slate-800 font-bold rounded border border-slate-400">3</div>
                        <div class="p-2.5 bg-white text-slate-400 rounded border border-slate-300">4</div>
                        <div class="p-2.5 bg-white text-slate-400 rounded border border-slate-300">5</div>
                        <div class="p-2.5 bg-white text-slate-400 rounded border border-slate-300">6</div>
                        <div class="p-2.5 bg-white text-slate-400 rounded border border-slate-300">7</div>
                        <div class="p-2.5 bg-white text-slate-400 rounded border border-slate-300">8</div>
                        <div class="p-2.5 bg-white text-slate-400 rounded border border-slate-300">9</div>
                        <div class="p-2.5 bg-white text-slate-400 rounded border border-slate-300">10</div>
                    </div>
                    <div class="pt-3 border-t text-[10px] space-y-1 text-slate-600">
                        <div class="flex items-center gap-2"><div class="w-3 h-3 bg-slate-900 rounded"></div> <span>Soal aktif</span></div>
                        <div class="flex items-center gap-2"><div class="w-3 h-3 bg-slate-200 border rounded"></div> <span>Sudah dijawab</span></div>
                        <div class="flex items-center gap-2"><div class="w-3 h-3 bg-white border rounded"></div> <span>Belum dijawab</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 16. REVIEW & PEMBAHASAN KUIS SISWA
    # -------------------------------------------------------------
    screens.append("""
    <!-- 16. REVIEW & PEMBAHASAN KUIS SISWA -->
    <section id="wf-16" class="space-y-3 wf-screen" data-role="student">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-16</span>
                <span class="font-bold text-slate-900 text-sm">UI Review Pembahasan & Kunci Jawaban Kuis Siswa</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Siswa</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl p-8 space-y-6">
            <!-- Score Banner Wireframe -->
            <div class="bg-white p-6 rounded-xl border-2 border-slate-900 flex justify-between items-center shadow-sm font-mono">
                <div class="space-y-1">
                    <span class="bg-slate-100 border border-slate-900 text-[10px] font-bold px-2 py-0.5 rounded uppercase">HASIL EVALUASI PEMBELAJARAN</span>
                    <h2 class="text-xl font-black text-slate-900 uppercase">Tinjauan Pembahasan: Kuis 01 Aksara Jawa</h2>
                    <p class="text-xs text-slate-600">Pelajar: Budi Santoso (NIS: 16042) • Waktu Pengerjaan: 18 Menit 30 Detik</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-slate-50 border-2 border-slate-900 rounded-lg text-center">
                        <span class="text-[9px] text-slate-500 block uppercase font-bold">SKOR AKHIR</span>
                        <span class="font-black text-2xl text-slate-900">90 / 100</span>
                    </div>
                    <button class="px-4 py-3 border-2 border-slate-900 bg-white font-bold text-xs rounded uppercase">&lt; Kembali ke Kelas</button>
                </div>
            </div>
            <!-- Question Review Card 1 (Correct) -->
            <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-4 font-mono text-xs">
                <div class="flex justify-between items-center border-b pb-2">
                    <div class="flex items-center gap-2">
                        <span class="bg-slate-900 text-white font-bold px-2.5 py-1 rounded">SOAL #1</span>
                        <span class="border border-slate-900 bg-slate-100 px-2 py-0.5 rounded font-bold uppercase">[STATUS: BENAR • 10 POIN]</span>
                    </div>
                    <span class="text-slate-500">Kategori: Aksara Jawa</span>
                </div>
                <p class="font-bold text-sm text-slate-900">Aksara Jawa ing ngisor iki kang diarani pasangan saka aksara 'NA' yaiku ...</p>
                <div class="p-3 bg-slate-100 border-2 border-slate-900 rounded-lg flex items-center justify-between">
                    <div>
                        <span class="font-bold">Jawaban Anda: A. ꧀ꦤ</span> (Sesuai Kunci Jawaban 100%)
                    </div>
                    <span class="bg-slate-900 text-white px-2 py-0.5 rounded text-[10px] font-bold">[✓ BENAR]</span>
                </div>
                <!-- Teacher Explanation Box Wireframe -->
                <div class="p-3.5 bg-slate-50 border-2 border-dashed border-slate-400 rounded-lg space-y-1">
                    <span class="font-bold text-slate-900 uppercase text-[11px]">💡 Penjelasan & Pembahasan Pengajar:</span>
                    <p class="text-slate-600 text-[11px] leading-relaxed">
                        Pasangan 'Na' ditulis ing sisih tengen (jejer) karo aksara legena sadurunge, ora nggandhul ing ngisor, kanggo mateni swara vokal aksara ngarepe.
                    </p>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 17. DASHBOARD PENGAJAR & KELOLA KELAS
    # -------------------------------------------------------------
    screens.append("""
    <!-- 17. DASHBOARD PENGAJAR & KELOLA KELAS -->
    <section id="wf-17" class="space-y-3 wf-screen" data-role="teacher">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-17</span>
                <span class="font-bold text-slate-900 text-sm">UI Dashboard Pengajar & Kelola Ruang Kelas</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Peran: Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Pengajar</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🏫 Kelola Kelas [Aktif]</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">➕ Buat Kelas Baru</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📦 Bank Soal Saya</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📅 Kalender</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">🏫 Ruang Kelas Yang Saya Ajar</h2>
                        <p class="text-xs text-slate-600 font-mono">Pantau seluruh kelas, publikasikan materi slide PDF, dan evaluasi hasil belajar siswa.</p>
                    </div>
                    <button class="px-5 py-2.5 bg-slate-900 text-white font-mono font-bold text-xs rounded-lg uppercase">[Button] + Buat Kelas Baru</button>
                </div>
                <!-- 3 Class Cards Grid -->
                <div class="grid grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl border-2 border-slate-900 overflow-hidden shadow-sm font-mono text-xs">
                        <div class="p-4 bg-slate-100 border-b-2 border-slate-900 space-y-1">
                            <span class="border border-slate-900 px-1.5 py-0.5 rounded text-[9px] bg-white font-bold">KODE: JWX26</span>
                            <h4 class="font-black text-base text-slate-900">Bahasa Jawa X-A</h4>
                            <p class="text-[11px] text-slate-500">32 Siswa Terdaftar • 4 Modul Terbit</p>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between text-[11px] text-slate-600"><span>Minggu Aktif:</span><span class="font-bold">Minggu 4</span></div>
                            <div class="flex justify-between text-[11px] text-slate-600"><span>Tugas Berjalan:</span><span class="font-bold">1 Tugas Mandiri</span></div>
                            <div class="flex gap-2 pt-2">
                                <button class="w-full py-2 bg-slate-900 text-white font-bold rounded uppercase">[Buka Kelas]</button>
                                <button class="py-2 px-3 border border-slate-900 rounded bg-white font-bold">[Edit]</button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border-2 border-slate-900 overflow-hidden shadow-sm font-mono text-xs">
                        <div class="p-4 bg-slate-100 border-b-2 border-slate-900 space-y-1">
                            <span class="border border-slate-900 px-1.5 py-0.5 rounded text-[9px] bg-white font-bold">KODE: JWX27</span>
                            <h4 class="font-black text-base text-slate-900">Bahasa Jawa X-B</h4>
                            <p class="text-[11px] text-slate-500">30 Siswa Terdaftar • 4 Modul Terbit</p>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between text-[11px] text-slate-600"><span>Minggu Aktif:</span><span class="font-bold">Minggu 4</span></div>
                            <div class="flex justify-between text-[11px] text-slate-600"><span>Tugas Berjalan:</span><span class="font-bold">1 Tugas Mandiri</span></div>
                            <div class="flex gap-2 pt-2">
                                <button class="w-full py-2 bg-slate-900 text-white font-bold rounded uppercase">[Buka Kelas]</button>
                                <button class="py-2 px-3 border border-slate-900 rounded bg-white font-bold">[Edit]</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 18. FORM BUAT KELAS BARU (PENGAJAR)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 18. FORM BUAT KELAS BARU (PENGAJAR) -->
    <section id="wf-18" class="space-y-3 wf-screen" data-role="teacher">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-18</span>
                <span class="font-bold text-slate-900 text-sm">UI Formulir Pembuatan Ruang Kelas Baru</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Pengajar</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🏫 Kelola Kelas</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">➕ Buat Kelas [Aktif]</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="max-w-2xl bg-white p-8 rounded-xl border-2 border-slate-900 space-y-6 shadow-sm font-mono text-xs">
                    <div class="border-b pb-3">
                        <h2 class="text-xl font-black text-slate-900 uppercase">➕ Buat Ruang Kelas Baru</h2>
                        <p class="text-slate-600 text-[11px]">Sistem akan mengenerate kode kelas unik untuk dibagikan kepada peserta didik.</p>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block font-bold mb-1">NAMA RUANG KELAS <span class="text-slate-500">*</span></label>
                            <div class="p-3 bg-slate-50 border-2 border-slate-900 rounded-lg text-slate-800">Bahasa Jawa X-C (Peminatan)</div>
                        </div>
                        <div>
                            <label class="block font-bold mb-1">MATA PELAJARAN / TINGKAT</label>
                            <div class="p-3 bg-slate-50 border-2 border-slate-400 rounded-lg text-slate-800">Muatan Lokal Bahasa Daerah Jawa - Kelas 10</div>
                        </div>
                        <div>
                            <label class="block font-bold mb-1">DESKRIPSI & PETUNJUK KELAS</label>
                            <div class="p-3 bg-slate-50 border-2 border-slate-400 rounded-lg text-slate-500 h-20">Tuliskan tujuan pembelajaran dan aturan umum kelas...</div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold mb-1">TEMA BANNER KELAS</label>
                                <div class="p-3 bg-slate-100 border border-slate-400 rounded text-center">[Pilihan Skema Warna Monokrom]</div>
                            </div>
                            <div>
                                <label class="block font-bold mb-1">IKON DEKORATIF KELAS</label>
                                <div class="p-3 bg-slate-100 border border-slate-400 rounded text-center">[Ikon: fa-graduation-cap]</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button class="px-4 py-2 border border-slate-900 bg-white font-bold rounded">Batal</button>
                        <button class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded uppercase">[Button] Simpan & Buat Kelas</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 19. DETAIL KELAS PENGAJAR & MANAJEMEN MINGGU
    # -------------------------------------------------------------
    screens.append("""
    <!-- 19. DETAIL KELAS PENGAJAR & MANAJEMEN MINGGU -->
    <section id="wf-19" class="space-y-3 wf-screen" data-role="teacher">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-19</span>
                <span class="font-bold text-slate-900 text-sm">UI Manajemen Ruang Kelas & Kurikulum Mingguan Pengajar</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Pengajar</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🏫 Detail Kelas X-A [Aktif]</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📦 Bank Soal Saya</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="bg-white p-6 rounded-xl border-2 border-slate-900 flex justify-between items-center shadow-sm font-mono text-xs">
                    <div class="space-y-1">
                        <span class="border border-slate-900 bg-slate-100 px-2 py-0.5 rounded font-bold uppercase text-[9px]">KODE KELAS: JWX26</span>
                        <h2 class="text-2xl font-black text-slate-900 uppercase">Bahasa Jawa X-A SMAN 1 Surakarta</h2>
                        <p class="text-slate-600">32 Siswa Terdaftar • Pengaturan Kurikulum Semester 16 Minggu</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-slate-900 text-white font-bold rounded uppercase">[Button] + Buat Postingan Baru</button>
                        <button class="px-3 py-2 border border-slate-900 bg-white font-bold rounded uppercase">Kelola Siswa</button>
                    </div>
                </div>
                <!-- Week Management Cards -->
                <div class="space-y-4 font-mono text-xs">
                    <!-- Week 1 Box -->
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3">
                        <div class="flex justify-between items-center border-b pb-2">
                            <div class="flex items-center gap-2">
                                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-[10px]">MINGGU 1</span>
                                <span class="font-bold text-slate-900 text-sm">Pengantar Aksara Jawa Nglegena</span>
                            </div>
                            <div class="flex gap-2">
                                <button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold">[Edit Judul]</button>
                                <button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold text-slate-600">[+ Tambah Post di Minggu Ini]</button>
                            </div>
                        </div>
                        <div class="p-3 bg-slate-50 border border-slate-300 rounded flex justify-between items-center">
                            <div>
                                <span class="border border-slate-900 bg-white text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">Materi PDF</span>
                                <span class="font-bold text-slate-900 ml-2">Slide 01: Mengenal Huruf Hanacaraka</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-slate-500">Status: Publik (Terlihat Siswa)</span>
                                <button class="border border-slate-900 px-2 py-0.5 rounded bg-white text-[10px] font-bold">[Hapus]</button>
                            </div>
                        </div>
                    </div>
                    <!-- Week 2 Box -->
                    <div class="bg-white p-5 rounded-xl border-2 border-slate-900 space-y-3">
                        <div class="flex justify-between items-center border-b pb-2">
                            <div class="flex items-center gap-2">
                                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-[10px]">MINGGU 2</span>
                                <span class="font-bold text-slate-900 text-sm">Pasangan Aksara Jawa & Latihan Mandiri</span>
                            </div>
                            <div class="flex gap-2">
                                <button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold">[Edit Judul]</button>
                                <button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold text-slate-600">[+ Tambah Post]</button>
                            </div>
                        </div>
                        <div class="p-3 bg-slate-50 border border-slate-300 rounded flex justify-between items-center">
                            <div>
                                <span class="border border-slate-900 bg-slate-900 text-white text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">Kuis / Evaluasi</span>
                                <span class="font-bold text-slate-900 ml-2">Kuis 01: Kaidah Aksara & Pasangan</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="border border-slate-900 px-2 py-0.5 rounded bg-white text-[10px] font-bold">[Rekap Nilai Siswa]</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 20. FORM BUAT POSTINGAN KELAS (MATERI, TUGAS, KUIS)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 20. FORM BUAT POSTINGAN KELAS -->
    <section id="wf-20" class="space-y-3 wf-screen" data-role="teacher">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-20</span>
                <span class="font-bold text-slate-900 text-sm">UI Formulir Buat Postingan Kelas (Materi, Tugas, Kuis)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl p-8 space-y-6">
            <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-6 shadow-sm font-mono text-xs">
                <div class="flex justify-between items-center border-b pb-3">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 uppercase">➕ Buat Postingan Baru: Kelas X-A</h2>
                        <p class="text-slate-600 text-[11px]">Pilih jenis postingan pembelajaran yang ingin dibagikan ke siswa.</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 border-2 border-slate-900 bg-white font-bold rounded uppercase">Materi PDF</button>
                        <button class="px-4 py-2 border-2 border-slate-900 bg-white font-bold rounded uppercase">Tugas Mandiri</button>
                        <button class="px-4 py-2 border-2 border-slate-900 bg-slate-900 text-white font-bold rounded uppercase">Evaluasi / Kuis [Aktif]</button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold mb-1">TARGET MINGGU KURIKULUM</label>
                        <select class="w-full p-2.5 bg-slate-50 border-2 border-slate-900 rounded-lg">
                            <option>Week 2 - Pasangan Aksara Jawa</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold mb-1">JUDUL KUIS / EVALUASI <span class="text-slate-500">*</span></label>
                        <div class="p-2.5 bg-slate-50 border-2 border-slate-900 rounded-lg text-slate-800">Kuis 02: Membaca Kalimat Aksara Jawa</div>
                    </div>
                </div>
                <!-- Quiz Settings Wireframe -->
                <div class="p-4 bg-slate-100 border-2 border-slate-400 rounded-xl space-y-3">
                    <h4 class="font-bold text-slate-900 uppercase">Pengaturan Evaluasi Kuis</h4>
                    <div class="grid grid-cols-3 gap-3">
                        <div><label class="block text-[10px] text-slate-500 font-bold">DURASI (MENIT)</label><div class="p-2 bg-white border border-slate-400 rounded">30 Menit</div></div>
                        <div><label class="block text-[10px] text-slate-500 font-bold">BATAS PENGERJAAN</label><div class="p-2 bg-white border border-slate-400 rounded">🔒 1 Kali Pengisian</div></div>
                        <div><label class="block text-[10px] text-slate-500 font-bold">IZIN PEMBAHASAN</label><div class="p-2 bg-white border border-slate-400 rounded">🔒 Kunci Pembahasan (Nilai Saja)</div></div>
                    </div>
                </div>
                <!-- Action: Ambil dari Bank Soal Wireframe -->
                <div class="p-5 bg-white border-2 border-dashed border-slate-900 rounded-xl flex justify-between items-center">
                    <div>
                        <h4 class="font-black text-sm uppercase text-slate-900">📦 Ambil Soal dari Bank Soal Saya</h4>
                        <p class="text-slate-600 text-[11px]">Gunakan kembali soal-soal yang sudah pernah Anda simpan di Bank Soal tanpa mengetik ulang.</p>
                    </div>
                    <button class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-lg border-2 border-slate-900 uppercase">[Modal Button] Ambil dari Bank Soal</button>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button class="px-4 py-2 border border-slate-900 bg-white font-bold rounded">Batal</button>
                    <button class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded uppercase">[Button] Posting Kuis Ke Kelas</button>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 21. BANK SOAL PENGAJAR (KATALOG)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 21. BANK SOAL PENGAJAR (KATALOG) -->
    <section id="wf-21" class="space-y-3 wf-screen" data-role="teacher">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-21</span>
                <span class="font-bold text-slate-900 text-sm">UI Bank Soal Pengajar (Katalog Butir Soal & Filter Topik)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Pengajar</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🏫 Kelola Ruang Kelas</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">📦 Bank Soal Saya [Aktif]</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">📅 Kalender</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">📦 Bank Soal Pribadi Pengajar</h2>
                        <p class="text-xs text-slate-600 font-mono">Kelola kumpulan soal pilihan ganda milik Anda yang siap dipakai ulang kapan saja pada kuis kelas.</p>
                    </div>
                    <button class="px-5 py-2.5 bg-slate-900 text-white font-mono font-bold text-xs rounded-lg uppercase">[Button] + Tambah Soal Baru</button>
                </div>
                <!-- Search & Topic Filter -->
                <div class="bg-white p-4 rounded-xl border-2 border-slate-900 flex gap-3 font-mono text-xs">
                    <div class="flex-1 p-2.5 bg-slate-50 border border-slate-400 rounded flex items-center justify-between text-slate-500">
                        <span>Cari teks pertanyaan butir soal...</span>
                        <span>[Search]</span>
                    </div>
                    <select class="px-3 bg-white border border-slate-900 rounded font-bold">
                        <option>Semua Topik (Aksara, Macapat, Wayang, Unggah-Ungguh)</option>
                    </select>
                    <button class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded">[Filter]</button>
                </div>
                <!-- Question Cards in Bank -->
                <div class="space-y-4 font-mono text-xs">
                    <div class="bg-white p-6 rounded-xl border-2 border-slate-900 space-y-3">
                        <div class="flex justify-between items-center border-b pb-2">
                            <div class="flex items-center gap-2">
                                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-[10px]">SOAL #01</span>
                                <span class="border border-slate-900 bg-slate-100 text-[10px] font-bold px-2 py-0.5 rounded uppercase">TOPIK: AKSARA JAWA</span>
                            </div>
                            <div class="flex gap-2">
                                <button class="border border-slate-900 px-2.5 py-1 rounded bg-white text-[10px] font-bold">[Edit]</button>
                                <button class="border border-slate-900 px-2.5 py-1 rounded bg-white text-[10px] font-bold text-slate-600">[Hapus]</button>
                            </div>
                        </div>
                        <p class="font-bold text-sm text-slate-900">Aksara Jawa ing ngisor iki kang diarani pasangan saka aksara 'NA' yaiku ...</p>
                        <div class="grid grid-cols-2 gap-2 text-[11px]">
                            <div class="p-2 bg-slate-100 border border-slate-900 rounded font-bold">A. ꧀ꦤ [Kunci Jawaban 100%]</div>
                            <div class="p-2 bg-white border border-slate-300 rounded text-slate-600">B. ꧀ꦲ (0%)</div>
                            <div class="p-2 bg-white border border-slate-300 rounded text-slate-600">C. ꧀ꦕ (0%)</div>
                            <div class="p-2 bg-white border border-slate-300 rounded text-slate-600">D. ꧀ꦫ (0%)</div>
                        </div>
                        <div class="p-2.5 bg-slate-50 border border-dashed border-slate-400 rounded text-[10px] text-slate-600">
                            <strong>Pembahasan Guru:</strong> Pasangan Na ditulis jejer ing sisih tengen aksara legena.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 22. FORM TAMBAH SOAL KE BANK SOAL
    # -------------------------------------------------------------
    screens.append("""
    <!-- 22. FORM TAMBAH SOAL KE BANK SOAL -->
    <section id="wf-22" class="space-y-3 wf-screen" data-role="teacher">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-22</span>
                <span class="font-bold text-slate-900 text-sm">UI Formulir Tambah Butir Soal Baru ke Bank Soal</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl p-8 space-y-6">
            <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl border-2 border-slate-900 space-y-5 font-mono text-xs">
                <div class="border-b pb-3">
                    <h2 class="text-xl font-black text-slate-900 uppercase">➕ Tambah Butir Soal ke Bank Soal</h2>
                    <p class="text-slate-600 text-[11px]">Soal yang disimpan di sini dapat digunakan berulang kali pada setiap kuis kelas.</p>
                </div>
                <div>
                    <label class="block font-bold mb-1">KATEGORI TOPIK PEMBELAJARAN <span class="text-slate-500">*</span></label>
                    <select class="w-full p-2.5 bg-slate-50 border-2 border-slate-900 rounded-lg">
                        <option>Aksara Jawa</option>
                        <option>Tembang Macapat</option>
                        <option>Pewayangan</option>
                        <option>Unggah-Ungguh Basa</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold mb-1">ISI PERTANYAAN SOAL <span class="text-slate-500">*</span></label>
                    <div class="p-3 bg-slate-50 border-2 border-slate-900 rounded-lg h-24 text-slate-700">Tuliskan teks pertanyaan pilihan ganda secara jelas...</div>
                </div>
                <div>
                    <label class="block font-bold mb-1">LAMPIRAN GAMBAR SOAL (OPSIONAL - PNG/JPG)</label>
                    <div class="p-3 bg-slate-100 border-2 border-dashed border-slate-400 rounded-lg text-center text-slate-500">[Upload File Gambar Soal - Maks 5MB]</div>
                </div>
                <div class="space-y-2">
                    <label class="block font-bold">PILIHAN JAWABAN & BOBOT (%)</label>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <input type="radio" checked>
                            <span class="w-6 text-center font-bold">A</span>
                            <div class="flex-1 p-2 bg-slate-50 border border-slate-400 rounded">Opsi jawaban A (Kunci Benar)</div>
                            <span class="p-2 bg-slate-900 text-white font-bold rounded">100%</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="radio">
                            <span class="w-6 text-center font-bold">B</span>
                            <div class="flex-1 p-2 bg-slate-50 border border-slate-400 rounded">Opsi jawaban B</div>
                            <span class="p-2 bg-slate-100 border rounded">0%</span>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block font-bold mb-1">PENJELASAN / PEMBAHASAN KUNCI JAWABAN (OPSIONAL)</label>
                    <div class="p-3 bg-slate-50 border border-slate-400 rounded-lg h-20 text-slate-500">Tuliskan ulasan kenapa opsi A merupakan kunci jawaban yang benar...</div>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button class="px-4 py-2 border border-slate-900 bg-white font-bold rounded">Batal</button>
                    <button class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded uppercase">[Button] Simpan ke Bank Soal</button>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 23. MODAL "AMBIL DARI BANK SOAL"
    # -------------------------------------------------------------
    screens.append("""
    <!-- 23. MODAL "AMBIL DARI BANK SOAL" -->
    <section id="wf-23" class="space-y-3 wf-screen" data-role="teacher">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-23</span>
                <span class="font-bold text-slate-900 text-sm">UI Modal Pemilih Soal dari Bank Soal (Kuis Kelas)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-400 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl p-16 flex items-center justify-center relative" style="background-image: radial-gradient(#64748b 1.5px, transparent 1.5px); background-size: 20px 20px;">
            <!-- Modal Box Wireframe -->
            <div class="bg-white rounded-2xl border-2 border-slate-900 p-8 w-full max-w-3xl space-y-5 shadow-2xl font-mono text-xs">
                <div class="flex justify-between items-center border-b pb-3">
                    <div class="flex items-center gap-2">
                        <span class="bg-slate-900 text-white font-bold px-2 py-1 rounded text-xs">[MODAL]</span>
                        <h3 class="text-base font-black text-slate-900 uppercase">Pilih Soal dari Bank Soal Saya</h3>
                    </div>
                    <button class="font-bold text-sm text-slate-500">[✕]</button>
                </div>
                <div class="flex gap-3">
                    <div class="flex-1 p-2 bg-slate-50 border border-slate-400 rounded flex justify-between text-slate-500">
                        <span>Cari teks butir soal...</span>
                        <span>[Search]</span>
                    </div>
                    <select class="p-2 border border-slate-900 rounded font-bold">
                        <option>Semua Topik</option>
                        <option>Aksara Jawa</option>
                    </select>
                </div>
                <!-- Checklist items -->
                <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                    <div class="p-3 bg-slate-50 border-2 border-slate-900 rounded-lg flex items-start gap-3">
                        <input type="checkbox" checked class="mt-1 w-4 h-4">
                        <div class="flex-1 space-y-1">
                            <span class="bg-slate-200 border px-1.5 py-0.5 rounded text-[9px] font-bold uppercase">Aksara Jawa</span>
                            <p class="font-bold text-slate-900 text-xs">Aksara Jawa ing ngisor iki kang diarani pasangan saka aksara 'NA' yaiku ...</p>
                            <p class="text-[10px] text-slate-500">Kunci: A. ꧀ꦤ (100%) • Ada Pembahasan Guru</p>
                        </div>
                    </div>
                    <div class="p-3 bg-white border border-slate-400 rounded-lg flex items-start gap-3">
                        <input type="checkbox" class="mt-1 w-4 h-4">
                        <div class="flex-1 space-y-1">
                            <span class="bg-slate-200 border px-1.5 py-0.5 rounded text-[9px] font-bold uppercase">Tembang Macapat</span>
                            <p class="font-bold text-slate-900 text-xs">Pira cacahe guru gatra kang ana ing pupuh tembang Macapat Kinanthi?</p>
                            <p class="text-[10px] text-slate-500">Kunci: B. 6 Gatra (100%)</p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-3 border-t">
                    <span class="font-bold text-slate-700">1 butir soal terpilih</span>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 border border-slate-900 bg-white font-bold rounded">Batal</button>
                        <button class="px-6 py-2 bg-slate-900 text-white font-bold rounded uppercase">[Button] Tambahkan ke Kuis</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 24. PREVIEW HASIL KUIS (PENGAJAR)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 24. PREVIEW HASIL KUIS (PENGAJAR) -->
    <section id="wf-24" class="space-y-3 wf-screen" data-role="teacher">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-24</span>
                <span class="font-bold text-slate-900 text-sm">UI Rekap Nilai Kuis Siswa & Kontrol Review (Sisi Pengajar)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl p-8 space-y-6">
            <div class="bg-white p-6 rounded-xl border-2 border-slate-900 flex justify-between items-center shadow-sm font-mono text-xs">
                <div class="space-y-1">
                    <span class="border border-slate-900 bg-slate-100 px-2 py-0.5 rounded font-bold uppercase text-[9px]">REKAPITULASI HASIL KUIS KELAS</span>
                    <h2 class="text-xl font-black text-slate-900 uppercase">Kuis 01: Kaidah Aksara Jawa (Kelas X-A)</h2>
                    <p class="text-slate-600">32 Siswa • 30 Sudah Mengerjakan • Rata-Rata Nilai: 84.5</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 border-2 border-slate-900 bg-white font-bold rounded uppercase">🔓 Buka Review untuk Siswa</button>
                    <button class="px-4 py-2 bg-slate-900 text-white font-bold rounded uppercase font-mono">📥 Ekspor CSV/Excel</button>
                </div>
            </div>
            <!-- Submissions Table Wireframe -->
            <div class="bg-white rounded-xl border-2 border-slate-900 overflow-hidden font-mono text-xs">
                <div class="grid grid-cols-5 p-3.5 bg-slate-100 border-b-2 border-slate-900 font-bold text-slate-800">
                    <span>NAMA PELAJAR</span>
                    <span>WAKTU SUBMIT</span>
                    <span>DURASI PENGERJAAN</span>
                    <span>NILAI AKHIR</span>
                    <span class="text-right">STATUS</span>
                </div>
                <div class="grid grid-cols-5 p-4 border-b border-slate-200 items-center hover:bg-slate-50">
                    <span class="font-bold text-slate-900">Budi Santoso</span>
                    <span class="text-slate-600">2 Sep 2026, 14:22</span>
                    <span class="text-slate-600">18 Menit</span>
                    <span class="font-black text-sm text-slate-900">90 / 100</span>
                    <div class="text-right"><span class="bg-slate-900 text-white px-2 py-0.5 rounded text-[10px] font-bold">LULUS</span></div>
                </div>
                <div class="grid grid-cols-5 p-4 border-b border-slate-200 items-center hover:bg-slate-50">
                    <span class="font-bold text-slate-900">Siti Rahmawati</span>
                    <span class="text-slate-600">2 Sep 2026, 14:28</span>
                    <span class="text-slate-600">22 Menit</span>
                    <span class="font-black text-sm text-slate-900">100 / 100</span>
                    <div class="text-right"><span class="bg-slate-900 text-white px-2 py-0.5 rounded text-[10px] font-bold">LULUS</span></div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 25. PENGAJAR - KELOLA AKSARA JAWA
    # -------------------------------------------------------------
    screens.append("""
    <!-- 25. PENGAJAR - KELOLA AKSARA JAWA -->
    <section id="wf-25" class="space-y-3 wf-screen" data-role="teacher">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-25</span>
                <span class="font-bold text-slate-900 text-sm">UI Kelola Master Pembelajaran Aksara Jawa (Sisi Pengajar)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Pengajar</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🏫 Kelola Ruang Kelas</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">📜 Kelola Aksara [Aktif]</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">📜 Kelola Master Materi Aksara Jawa</h2>
                        <p class="text-xs text-slate-600 font-mono">Ubah filosofi, pasangan, atau tambah contoh kosakata beraksara Jawa.</p>
                    </div>
                    <button class="px-5 py-2.5 bg-slate-900 text-white font-mono font-bold text-xs rounded-lg uppercase">[Button] + Tambah Entri Aksara</button>
                </div>
                <div class="bg-white rounded-xl border-2 border-slate-900 overflow-hidden font-mono text-xs">
                    <div class="grid grid-cols-5 p-3.5 bg-slate-100 border-b-2 border-slate-900 font-bold text-slate-800">
                        <span>HURUF AKSARA</span><span>NAMA LATIN</span><span>PASANGAN</span><span>KATEGORI</span><span class="text-right">AKSI</span>
                    </div>
                    <div class="grid grid-cols-5 p-4 border-b border-slate-200 items-center hover:bg-slate-50">
                        <span class="text-2xl font-bold">ꦲ</span>
                        <span class="font-bold">HA / A</span>
                        <span>꧀ꦲ (Pasangan Ha)</span>
                        <span>Nglegena Dasar</span>
                        <div class="text-right"><button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold">[Edit]</button></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 26. PENGAJAR - KELOLA TEMBANG MACAPAT
    # -------------------------------------------------------------
    screens.append("""
    <!-- 26. PENGAJAR - KELOLA TEMBANG MACAPAT -->
    <section id="wf-26" class="space-y-3 wf-screen" data-role="teacher">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-26</span>
                <span class="font-bold text-slate-900 text-sm">UI Kelola Materi Tembang Macapat & Unggah Audio (Sisi Pengajar)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Pengajar</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🏫 Kelola Ruang Kelas</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🎵 Kelola Macapat [Aktif]</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">🎵 Kelola Data 11 Pupuh Tembang Macapat</h2>
                        <p class="text-xs text-slate-600 font-mono">Sunting cakepan lirik, kaidah guru lagu/wilangan, dan unggah berkas audio tembang.</p>
                    </div>
                    <button class="px-5 py-2.5 bg-slate-900 text-white font-mono font-bold text-xs rounded-lg uppercase">[Button] + Tambah Bait Baru</button>
                </div>
                <div class="bg-white rounded-xl border-2 border-slate-900 overflow-hidden font-mono text-xs">
                    <div class="grid grid-cols-5 p-3.5 bg-slate-100 border-b-2 border-slate-900 font-bold text-slate-800">
                        <span>PUPUH MACAPAT</span><span>GATRA</span><span>WATAK</span><span>AUDIO TERSEDIA</span><span class="text-right">AKSI</span>
                    </div>
                    <div class="grid grid-cols-5 p-4 border-b border-slate-200 items-center hover:bg-slate-50">
                        <span class="font-bold text-slate-900">Kinanthi</span>
                        <span>6 Gatra</span>
                        <span>Asih, tresna, piwulang</span>
                        <span>kinanthi_manyura.mp3</span>
                        <div class="text-right"><button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold">[Kelola Bait & Audio]</button></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 27. PENGAJAR - KELOLA PEWAYANGAN JAWA
    # -------------------------------------------------------------
    screens.append("""
    <!-- 27. PENGAJAR - KELOLA PEWAYANGAN JAWA -->
    <section id="wf-27" class="space-y-3 wf-screen" data-role="teacher">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-27</span>
                <span class="font-bold text-slate-900 text-sm">UI Kelola Katalog Tokoh Pewayangan Jawa (Sisi Pengajar)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Pengajar</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[B]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula LMS</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Role: Pengajar</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🏫 Kelola Ruang Kelas</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🎭 Kelola Wayang [Aktif]</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">🎭 Kelola Master Data Karakter Wayang</h2>
                        <p class="text-xs text-slate-600 font-mono">Unggah ilustrasi tokoh, atur senjata pusaka, watak, dan silsilah keluarga.</p>
                    </div>
                    <button class="px-5 py-2.5 bg-slate-900 text-white font-mono font-bold text-xs rounded-lg uppercase">[Button] + Tambah Tokoh Wayang</button>
                </div>
                <div class="bg-white rounded-xl border-2 border-slate-900 overflow-hidden font-mono text-xs">
                    <div class="grid grid-cols-5 p-3.5 bg-slate-100 border-b-2 border-slate-900 font-bold text-slate-800">
                        <span>FOTO / SILUET</span><span>NAMA TOKOH</span><span>KATEGORI</span><span>KASATRIYAN</span><span class="text-right">AKSI</span>
                    </div>
                    <div class="grid grid-cols-5 p-4 border-b border-slate-200 items-center hover:bg-slate-50">
                        <span>[Thumb: Puntadewa]</span>
                        <span class="font-bold text-slate-900">Raden Puntadewa</span>
                        <span>Pandawa Lima</span>
                        <span>Amarta</span>
                        <div class="text-right"><button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold">[Edit]</button></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 28. DASHBOARD ADMIN
    # -------------------------------------------------------------
    screens.append("""
    <!-- 28. DASHBOARD ADMIN -->
    <section id="wf-28" class="space-y-3 wf-screen" data-role="admin">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-28</span>
                <span class="font-bold text-slate-900 text-sm">UI Dashboard Super Administrator & Statistik Platform</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Super Admin</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[A]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula ADMIN</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Super Admin</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">🛡️ Dashboard [Aktif]</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">👨‍🏫 Kelola Pengajar</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎓 Kelola Pelajar</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">⏱️ Log Aktivitas</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🏫 Kelola Seluruh Kelas</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">🛡️ Pusat Kendali Administrator</h2>
                        <p class="text-xs text-slate-600 font-mono">Ringkasan operasional sistem, jumlah akun pengguna, dan interaksi pembelajaran aktif.</p>
                    </div>
                    <span class="border border-slate-900 bg-white font-mono text-xs px-3 py-1.5 rounded font-bold">Status: Online & Sehat</span>
                </div>
                <!-- 4 KPI Metrics Wireframe -->
                <div class="grid grid-cols-4 gap-4 font-mono">
                    <div class="p-5 bg-white rounded-xl border-2 border-slate-900 space-y-1">
                        <span class="text-[10px] text-slate-500 font-bold uppercase">TOTAL PENGAJAR</span>
                        <div class="text-2xl font-black text-slate-900">12 Guru</div>
                        <span class="text-[10px] text-slate-500">Aktif mengajar semester ini</span>
                    </div>
                    <div class="p-5 bg-white rounded-xl border-2 border-slate-900 space-y-1">
                        <span class="text-[10px] text-slate-500 font-bold uppercase">TOTAL PELAJAR</span>
                        <div class="text-2xl font-black text-slate-900">384 Siswa</div>
                        <span class="text-[10px] text-slate-500">Terdaftar di 12 kelas</span>
                    </div>
                    <div class="p-5 bg-white rounded-xl border-2 border-slate-900 space-y-1">
                        <span class="text-[10px] text-slate-500 font-bold uppercase">RUANG KELAS AKTIF</span>
                        <div class="text-2xl font-black text-slate-900">16 Kelas</div>
                        <span class="text-[10px] text-slate-500">Kurikulum semester genap</span>
                    </div>
                    <div class="p-5 bg-white rounded-xl border-2 border-slate-900 space-y-1">
                        <span class="text-[10px] text-slate-500 font-bold uppercase">LOG AKTIVITAS SISWA</span>
                        <div class="text-2xl font-black text-slate-900">1.420 Aksi</div>
                        <span class="text-[10px] text-slate-500">Tercatat dalam 30 hari</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 29. ADMIN - KELOLA PENGGUNA (GURU & SISWA)
    # -------------------------------------------------------------
    screens.append("""
    <!-- 29. ADMIN - KELOLA PENGGUNA -->
    <section id="wf-29" class="space-y-3 wf-screen" data-role="admin">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-29</span>
                <span class="font-bold text-slate-900 text-sm">UI Manajemen Akun Pengguna (Pengajar & Pelajar)</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Super Admin</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[A]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula ADMIN</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Super Admin</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🛡️ Dashboard</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">👨‍🏫 Kelola Pengajar [Aktif]</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎓 Kelola Pelajar</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">⏱️ Log Aktivitas</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">👨‍🏫 Manajemen Akun Pengajar Sekolah</h2>
                        <p class="text-xs text-slate-600 font-mono">Daftarkan akun guru baru, reset kata sandi, atau nonaktifkan akses akun.</p>
                    </div>
                    <button class="px-5 py-2.5 bg-slate-900 text-white font-mono font-bold text-xs rounded-lg uppercase">[Button] + Daftarkan Pengajar Baru</button>
                </div>
                <div class="bg-white rounded-xl border-2 border-slate-900 overflow-hidden font-mono text-xs">
                    <div class="grid grid-cols-5 p-3.5 bg-slate-100 border-b-2 border-slate-900 font-bold text-slate-800">
                        <span>NAMA PENGAJAR</span><span>NIP / EMAIL</span><span>KELAS DIAMPU</span><span>STATUS AKUN</span><span class="text-right">AKSI</span>
                    </div>
                    <div class="grid grid-cols-5 p-4 border-b border-slate-200 items-center hover:bg-slate-50">
                        <span class="font-bold text-slate-900">Pak Guru Budi, S.Pd.</span>
                        <span class="text-slate-600">198504122010011005</span>
                        <span>Kelas X-A, X-B</span>
                        <div><span class="border border-slate-900 bg-slate-100 px-2 py-0.5 rounded text-[10px] font-bold">AKTIF</span></div>
                        <div class="text-right flex justify-end gap-1">
                            <button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold">[Edit]</button>
                            <button class="border border-slate-900 px-2 py-1 rounded bg-white text-[10px] font-bold">[Toggle Status]</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # -------------------------------------------------------------
    # 30. ADMIN - LOG AKTIVITAS PEMBELAJARAN
    # -------------------------------------------------------------
    screens.append("""
    <!-- 30. ADMIN - LOG AKTIVITAS PEMBELAJARAN -->
    <section id="wf-30" class="space-y-3 wf-screen" data-role="admin">
        <div class="flex justify-between items-center text-xs font-mono text-slate-600 border-b-2 border-slate-900 pb-2">
            <div class="flex items-center gap-2">
                <span class="bg-slate-900 text-white font-bold px-2 py-0.5 rounded text-xs font-mono">WF-30</span>
                <span class="font-bold text-slate-900 text-sm">UI Audit Trail & Log Aktivitas Pembelajaran Sistem</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 font-bold">
                <span class="border border-slate-900 px-2 py-0.5 rounded bg-white text-slate-900 uppercase">Super Admin</span>
                <span class="border border-slate-400 px-2 py-0.5 rounded bg-slate-100">1440 × 900 Desktop Grid</span>
            </div>
        </div>
        <div class="w-[1440px] bg-slate-50 text-slate-900 rounded-2xl border-2 border-slate-900 shadow-xl flex overflow-hidden">
            <div class="w-64 bg-slate-100 border-r-2 border-slate-900 p-5 flex flex-col justify-between flex-shrink-0">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b-2 border-slate-900 pb-4">
                        <div class="w-9 h-9 bg-slate-900 text-white font-black text-lg rounded-lg flex items-center justify-center font-mono">[A]</div>
                        <div><h3 class="font-black text-sm uppercase">BasaKula ADMIN</h3><span class="text-[9px] font-mono border border-slate-900 px-1 rounded uppercase bg-white">Super Admin</span></div>
                    </div>
                    <div class="space-y-1.5 text-xs font-mono">
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🛡️ Dashboard</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">👨‍🏫 Kelola Pengajar</div>
                        <div class="p-2.5 rounded bg-slate-200 border border-slate-400 text-slate-700">🎓 Kelola Pelajar</div>
                        <div class="p-2.5 rounded bg-slate-900 text-white font-bold border border-slate-900">⏱️ Log Aktivitas [Aktif]</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 space-y-6 bg-slate-50">
                <div class="border-b-2 border-slate-900 pb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight font-mono">⏱️ Audit Trail Log Aktivitas Pembelajaran</h2>
                        <p class="text-xs text-slate-600 font-mono">Catatan kronologis aktivitas autentikasi, penyelesaian materi, dan submit kuis siswa.</p>
                    </div>
                    <button class="px-4 py-2 border-2 border-slate-900 bg-white font-mono text-xs font-bold rounded uppercase">🗑️ Reset / Bersihkan Log</button>
                </div>
                <div class="bg-white rounded-xl border-2 border-slate-900 overflow-hidden font-mono text-xs">
                    <div class="grid grid-cols-5 p-3.5 bg-slate-100 border-b-2 border-slate-900 font-bold text-slate-800">
                        <span>PENGGUNA / ROLE</span><span>AKTIVITAS / AKSI</span><span>DESKRIPSI RINCIAN</span><span>TIMESTAMP</span><span class="text-right">IP ADDRESS</span>
                    </div>
                    <div class="grid grid-cols-5 p-4 border-b border-slate-200 items-center hover:bg-slate-50">
                        <div><span class="font-bold text-slate-900">Budi Santoso</span><span class="block text-[9px] text-slate-500">Siswa (NIS: 16042)</span></div>
                        <span class="font-bold">SUBMIT_QUIZ</span>
                        <span>Menyelesaikan Kuis 01 Aksara Jawa (Skor: 90)</span>
                        <span class="text-slate-500">2 Sep 2026, 14:22:15</span>
                        <span class="text-right text-slate-500">192.168.1.45</span>
                    </div>
                    <div class="grid grid-cols-5 p-4 border-b border-slate-200 items-center hover:bg-slate-50">
                        <div><span class="font-bold text-slate-900">Pak Guru Budi, S.Pd.</span><span class="block text-[9px] text-slate-500">Pengajar</span></div>
                        <span class="font-bold">CREATE_POST</span>
                        <span>Mempublikasikan Slide Modul PDF Minggu ke-2</span>
                        <span class="text-slate-500">2 Sep 2026, 09:15:02</span>
                        <span class="text-right text-slate-500">192.168.1.10</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    """)

    # Combine into full HTML
    all_screens_html = "\n".join(screens)

    html_template = f"""<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BasaKula LMS - 30 Low-Fidelity Wireframes (Hitam Putih / Grayscale)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;600;700;800&family=Noto+Sans+Javanese&display=swap');
        body {{
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0b0f19;
            color: #0f172a;
        }}
        .font-mono {{ font-family: 'JetBrains Mono', monospace; }}
        .font-javanese {{ font-family: 'Noto Sans Javanese', serif; }}
        @media print {{
            body {{ background-color: #ffffff !important; padding: 0 !important; }}
            .no-print {{ display: none !important; }}
            .wf-screen {{ page-break-after: always; margin-bottom: 2rem; }}
        }}
    </style>
</head>
<body class="p-6 md:p-8 space-y-12">

    <!-- FLOATING TOP NAVIGATION / CONTROL BAR -->
    <header class="no-print max-w-[1440px] mx-auto bg-slate-900 text-white border-2 border-slate-700 rounded-3xl p-6 shadow-2xl space-y-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-full bg-white text-slate-900 text-xs font-mono font-bold uppercase">📐 Low-Fidelity (Lo-Fi) Wireframe</span>
                    <span class="px-3 py-1 rounded-full border border-slate-600 text-slate-300 text-xs font-mono">100% Hitam Putih / Monochrome</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-white uppercase tracking-tight">BasaKula LMS — 30 Screen Low-Fidelity Blueprint</h1>
                <p class="text-slate-300 text-xs mt-1">Perancangan Arsitektur Antarmuka (Wireframe Hitam Putih) untuk Laporan Skripsi / Tugas Akhir.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="figma_ui_kit.html" class="px-4 py-2.5 rounded-xl border border-slate-600 bg-slate-800 text-white hover:bg-slate-700 font-mono text-xs font-bold transition-all flex items-center gap-2">
                    <span>🎨 Buka Versi High-Fidelity (Full Color)</span>
                </a>
                <button onclick="window.print()" class="px-4 py-2.5 rounded-xl bg-white text-slate-950 font-mono text-xs font-bold hover:bg-slate-200 transition-all flex items-center gap-2 shadow-sm">
                    <span>🖨️ Cetak / Ekspor PDF</span>
                </button>
            </div>
        </div>

        <!-- QUICK SCREEN JUMP SELECTOR & ROLE FILTER -->
        <div class="pt-3 border-t border-slate-800 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 text-xs font-mono">
            <div class="flex items-center gap-2">
                <span class="text-slate-400 font-bold uppercase">Lompat Ke Layar:</span>
                <select onchange="if(this.value) location.hash = this.value;" class="bg-slate-800 border border-slate-600 text-white rounded-lg p-2 font-mono text-xs focus:ring-2 focus:ring-white">
                    <option value="">-- Pilih Nomor Layar Wireframe --</option>
                    <option value="#wf-01">01. Login Sistem</option>
                    <option value="#wf-02">02. Profil Pengguna</option>
                    <option value="#wf-03">03. Dashboard Pelajar</option>
                    <option value="#wf-04">04. Kalender Pembelajaran</option>
                    <option value="#wf-05">05. Aksara Jawa (Katalog)</option>
                    <option value="#wf-06">06. Aksara Jawa (Detail)</option>
                    <option value="#wf-07">07. Tembang Macapat (Katalog)</option>
                    <option value="#wf-08">08. Tembang Macapat (Audio & Detail)</option>
                    <option value="#wf-09">09. Pewayangan (Katalog Tokoh)</option>
                    <option value="#wf-10">10. Pewayangan (Detail Tokoh)</option>
                    <option value="#wf-11">11. Kamus Kosakata</option>
                    <option value="#wf-12">12. Translator Jawa</option>
                    <option value="#wf-13">13. Bookmark Siswa</option>
                    <option value="#wf-14">14. Ruang Kelas Siswa (Timeline)</option>
                    <option value="#wf-15">15. Pengerjaan Kuis Siswa</option>
                    <option value="#wf-16">16. Review Pembahasan Kuis</option>
                    <option value="#wf-17">17. Dashboard & Kelola Kelas Guru</option>
                    <option value="#wf-18">18. Form Buat Kelas Baru</option>
                    <option value="#wf-19">19. Detail Kelas Guru & Manajemen Minggu</option>
                    <option value="#wf-20">20. Form Buat Postingan Kelas</option>
                    <option value="#wf-21">21. Bank Soal Pengajar (Katalog)</option>
                    <option value="#wf-22">22. Form Tambah Soal ke Bank Soal</option>
                    <option value="#wf-23">23. Modal Ambil dari Bank Soal</option>
                    <option value="#wf-24">24. Rekap Nilai Kuis (Sisi Guru)</option>
                    <option value="#wf-25">25. Guru - Kelola Aksara Jawa</option>
                    <option value="#wf-26">26. Guru - Kelola Tembang Macapat</option>
                    <option value="#wf-27">27. Guru - Kelola Pewayangan</option>
                    <option value="#wf-28">28. Dashboard Super Admin</option>
                    <option value="#wf-29">29. Admin - Kelola Pengguna</option>
                    <option value="#wf-30">30. Admin - Log Aktivitas Belajar</option>
                </select>
            </div>
            <div class="flex items-center gap-1.5" id="roleFilterButtons">
                <button onclick="filterScreens('all')" class="px-3 py-1.5 rounded-lg bg-white text-slate-900 font-bold border border-slate-300">Semua (30)</button>
                <button onclick="filterScreens('student')" class="px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 hover:text-white border border-slate-700">Siswa (13)</button>
                <button onclick="filterScreens('teacher')" class="px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 hover:text-white border border-slate-700">Pengajar (11)</button>
                <button onclick="filterScreens('admin')" class="px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 hover:text-white border border-slate-700">Admin (6)</button>
            </div>
        </div>
    </header>

    <!-- ALL 30 WIREFRAME SCREENS -->
    <main class="max-w-[1440px] mx-auto space-y-16">
        {all_screens_html}
    </main>

    <!-- FOOTER -->
    <footer class="no-print max-w-[1440px] mx-auto text-center py-10 border-t border-slate-800 text-slate-400 font-mono text-xs space-y-2">
        <p class="font-bold text-white uppercase">BasaKula LMS — Low-Fidelity UI/UX Wireframe Specification</p>
        <p>Format 1440px Desktop Grid • Grayscale / Monochrome • Siap diimpor langsung ke Figma via plugin html.to.design</p>
        <p class="text-[11px] text-slate-500">Tugas Akhir: Ivan Leonardo (160423189) • Pembelajaran Bahasa Jawa Terintegrasi</p>
    </footer>

    <script>
        function filterScreens(role) {{
            const screens = document.querySelectorAll('.wf-screen');
            screens.forEach(s => {{
                if (role === 'all' || s.dataset.role === role || (role === 'student' && s.dataset.role === 'auth')) {{
                    s.style.display = 'block';
                }} else {{
                    s.style.display = 'none';
                }}
            }});
        }}
    </script>
</body>
</html>
"""

    out_root = r"c:\Users\USER\Downloads\TA_IvanLeonardo_160423189\figma_lofi_wireframes.html"
    out_docs = r"c:\Users\USER\Downloads\TA_IvanLeonardo_160423189\docs\figma_lofi_wireframes.html"

    with open(out_root, "w", encoding="utf-8") as f:
        f.write(html_template)
    print(f"Written {len(html_template)} bytes to {out_root}")

    with open(out_docs, "w", encoding="utf-8") as f:
        f.write(html_template)
    print(f"Written {len(html_template)} bytes to {out_docs}")

if __name__ == '__main__':
    build_full_html()

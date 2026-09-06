/**
 * BasaKula LMS - Interactive Tutorial Tour Engine (Driver.js v1.x)
 * Features auto-sidebar-opening on mobile/desktop, glowing spotlight beacon,
 * and exact visual location badges for Admin, Teacher (Pengajar), and Student (Pelajar).
 */

window.BasaKulaTutorial = (function () {
    let driverObj = null;

    function isMobileScreen() {
        return window.innerWidth < 992;
    }

    function locBadge(locText) {
        return `<div class="tour-loc-badge"><i class="fa-solid fa-location-dot me-1"></i> Lokasi: <b>${locText}</b></div>`;
    }

    function getStepsForRole(role) {
        const r = (role || 'student').toLowerCase();
        const sidePos = isMobileScreen() ? 'bottom' : 'right';

        if (r === 'admin') {
            return [
                // 1. Mobile Hamburger Menu (Only on mobile)
                {
                    element: '#sidebarCollapse',
                    popover: {
                        title: '📱 Menu Navigasi Utama',
                        description: `${locBadge('Tombol ☰ di Navbar Kiri Atas')}Gunakan tombol menu ini untuk membuka atau menutup seluruh menu kendali BasaKula saat menggunakan perangkat HP atau tablet.`,
                        side: 'bottom',
                        align: 'start'
                    }
                },
                // 2. Sidebar Header
                {
                    element: '[data-tour="sidebar-header"]',
                    popover: {
                        title: '🎓 Panel Administrator BasaKula',
                        description: `${locBadge('Header Navigasi Sidebar')}Selamat datang di Pusat Pengelola BasaKula LMS! Mari ikuti panduan letak seluruh fitur navigasi admin berikut.`,
                        side: sidePos,
                        align: 'start'
                    }
                },
                // 3. Kelola Pengajar
                {
                    element: '[data-tour="sidebar-kelola-pengajar"]',
                    popover: {
                        title: '👥 Kelola Data Pengajar (Guru)',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Klik menu ini untuk mendaftarkan akun guru baru, mereset password, mengedit profil, dan memantau status aktif akun guru.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 4. Kelola Pelajar
                {
                    element: '[data-tour="sidebar-kelola-pelajar"]',
                    popover: {
                        title: '🎓 Kelola Data Pelajar (Siswa)',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Manajemen siswa terpadu untuk memverifikasi NISN, mendaftarkan siswa baru, dan melihat kelas yang diikuti.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 5. Kelola Ruang Kelas
                {
                    element: '[data-tour="sidebar-kelola-kelas"]',
                    popover: {
                        title: '🏫 Kelola Seluruh Ruang Kelas',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Pantau dan kelola seluruh ruang kelas aktif yang dibuat oleh setiap pengajar di sistem BasaKula.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 6. Audit Log
                {
                    element: '[data-tour="sidebar-log-aktivitas"]',
                    popover: {
                        title: '📜 Audit Log Aktivitas Sistem',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Rekam jejak audit trail seluruh aktivitas: riwayat login pengguna, pembuatan kelas, dan pengubahan data.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 7. Kalender Sistem
                {
                    element: '[data-tour="sidebar-kalender"]',
                    popover: {
                        title: '📅 Kalender Sistem',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Kalender penanggalan sistem BasaKula untuk navigasi tanggal dan bulan secara praktis tanpa pencatatan tugas atau materi.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 7. Modul Aksara Jawa
                {
                    element: '[data-tour="sidebar-aksara"]',
                    popover: {
                        title: '📜 Modul Aksara Jawa',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Referensi lengkap 20 Aksara Carakan Nglegena, Pasangan, Sandhangan, dan Aksara Swara.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 8. Modul Macapat
                {
                    element: '[data-tour="sidebar-macapat"]',
                    popover: {
                        title: '🎵 Modul Tembang Macapat',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Referensi 10 Tembang Macapat, kaidah Guru Gatra/Wilangan/Lagu, serta pemutaran audio lirik tembang.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 9. Modul Wayang
                {
                    element: '[data-tour="sidebar-wayang"]',
                    popover: {
                        title: '🎭 Ensiklopedia Pewayangan',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Katalog tokoh wayang Jawa (Pandawa 5, Punakawan, Kurawa, dan Tokoh Wanita) lengkap dengan watak.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 10. Kamus Kosakata
                {
                    element: '[data-tour="sidebar-kamus"]',
                    popover: {
                        title: '📖 Master Kosakata (Import CSV)',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Mengimpor ribuan kosakata Bahasa Jawa secara massal via CSV serta memverifikasi padanan kata Ngoko/Krama.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 11. Translator Jawa
                {
                    element: '[data-tour="sidebar-translator"]',
                    popover: {
                        title: '🔤 Translator Jawa Otomatis',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Penerjemah cepat dari Bahasa Indonesia ke Bahasa Jawa Ngoko dan Krama.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 12. Dashboard Quick Button: Tambah Pengajar (jika ada di halaman)
                {
                    element: '[data-tour="admin-btn-tambah-pengajar"]',
                    popover: {
                        title: '⚡ Tombol Pintas Tambah Pengajar',
                        description: `${locBadge('Banner Dashboard Utama')}Selain dari menu samping, Anda juga dapat mendaftarkan akun pengajar baru langsung melalui tombol pintas di dashboard ini.`,
                        side: 'bottom',
                        align: 'start'
                    }
                },
                // 13. Dashboard Quick Button: Tambah Pelajar (jika ada di halaman)
                {
                    element: '[data-tour="admin-btn-tambah-pelajar"]',
                    popover: {
                        title: '⚡ Tombol Pintas Tambah Pelajar',
                        description: `${locBadge('Banner Dashboard Utama')}Daftarkan akun siswa baru dengan cepat langsung dari tombol pintas di halaman dashboard ini.`,
                        side: 'bottom',
                        align: 'start'
                    }
                },
                // 14. Tutorial Navbar Trigger
                {
                    element: '[data-tour="btn-tutorial-trigger"]',
                    popover: {
                        title: '❓ Bantuan Kapan Saja',
                        description: `${locBadge('Tombol di Navbar Kanan Atas')}Tekan tombol <b>Tutorial System</b> ini kapan saja jika Anda ingin memutar ulang panduan lokasi fitur BasaKula!`,
                        side: 'bottom',
                        align: 'end'
                    }
                }
            ];
        } else if (r === 'teacher' || r === 'pengajar') {
            return [
                // 1. Mobile Hamburger Menu
                {
                    element: '#sidebarCollapse',
                    popover: {
                        title: '📱 Menu Navigasi Pengajar',
                        description: `${locBadge('Tombol ☰ di Navbar Kiri Atas')}Tekan tombol menu ini untuk membuka dan menutup navigasi pembelajaran saat memakai perangkat HP.`,
                        side: 'bottom',
                        align: 'start'
                    }
                },
                // 2. Sidebar Header
                {
                    element: '[data-tour="sidebar-header"]',
                    popover: {
                        title: '🎓 Ruang Pengajar BasaKula',
                        description: `${locBadge('Header Navigasi Sidebar')}Sugeng rawuh! Mari kenali letak menu pembelajaran untuk mengelola ruang kelas, materi, dan siswa Anda.`,
                        side: sidePos,
                        align: 'start'
                    }
                },
                // 3. Kelola Kelas
                {
                    element: '[data-tour="sidebar-kelola-kelas"]',
                    popover: {
                        title: '👥 Kelola Ruang Kelas',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Masuk ke ruang kelas yang Anda ampu, bagikan materi, buat tugas atau kuis, dan periksa hasil belajar siswa.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 4. Buat Kelas Baru
                {
                    element: '[data-tour="sidebar-buat-kelas"]',
                    popover: {
                        title: '➕ Buat Ruang Kelas Baru',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Buat ruang kelas baru untuk siswa Anda lengkap dengan banner dan ikon visual yang menarik.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 5. Kalender
                {
                    element: '[data-tour="sidebar-kalender"]',
                    popover: {
                        title: '📅 Kalender Pembelajaran',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Pantau agenda mingguan, jadwal kuis, dan tenggat pengumpulan tugas siswa secara visual.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 6. Aksara Jawa
                {
                    element: '[data-tour="sidebar-aksara"]',
                    popover: {
                        title: '📜 Referensi Aksara Jawa',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Akses cepat materi 20 Aksara Nglegena, Aksara Swara, Sandhangan, dan Pasangan untuk bahan mengajar.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 7. Macapat
                {
                    element: '[data-tour="sidebar-macapat"]',
                    popover: {
                        title: '🎵 Referensi Tembang Macapat',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Pelajari 10 Tembang Macapat, kaidah Guru Gatra/Wilangan/Lagu, serta pemutaran audio lirik tembang.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 8. Wayang
                {
                    element: '[data-tour="sidebar-wayang"]',
                    popover: {
                        title: '🎭 Ensiklopedia Pewayangan',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Katalog tokoh wayang Jawa (Pandawa 5, Punakawan, Kurawa) untuk memperkaya diskusi kelas.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 9. Kamus
                {
                    element: '[data-tour="sidebar-kamus"]',
                    popover: {
                        title: '📖 Kamus Kosakata Jawa',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Pencarian kosakata Jawa Ngoko dan Krama terurut abjad (A-Z) lengkap dengan pelafalan suara audio.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 10. Translator
                {
                    element: '[data-tour="sidebar-translator"]',
                    popover: {
                        title: '🔤 Translator Jawa Instan',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Terjemahkan kalimat Bahasa Indonesia ke Bahasa Jawa Ngoko dan Krama secara praktis.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 11. Quick Button: Buat Kelas Baru (jika ada di halaman)
                {
                    element: '[data-tour="teacher-btn-buat-kelas"]',
                    popover: {
                        title: '⚡ Tombol Pintas Buat Kelas',
                        description: `${locBadge('Pojok Kanan Atas Halaman')}Klik tombol ini untuk langsung membuka formulir pembuatan ruang kelas baru.`,
                        side: 'bottom',
                        align: 'end'
                    }
                },
                // 12. Tutorial Trigger
                {
                    element: '[data-tour="btn-tutorial-trigger"]',
                    popover: {
                        title: '❓ Panduan Tutorial Kapan Saja',
                        description: `${locBadge('Tombol di Navbar Kanan Atas')}Klik tombol <b>Tutorial System</b> ini kapan saja untuk memutar kembali petunjuk penggunaan sistem BasaKula.`,
                        side: 'bottom',
                        align: 'end'
                    }
                }
            ];
        } else {
            // Student / Pelajar (Default)
            return [
                // 1. Mobile Hamburger Menu
                {
                    element: '#sidebarCollapse',
                    popover: {
                        title: '📱 Menu Navigasi Belajar',
                        description: `${locBadge('Tombol ☰ di Navbar Kiri Atas')}Tekan tombol menu ini untuk membuka daftar modul pembelajaran, ruang kelas, dan fitur belajar di HP kamu.`,
                        side: 'bottom',
                        align: 'start'
                    }
                },
                // 2. Sidebar Header
                {
                    element: '[data-tour="sidebar-header"]',
                    popover: {
                        title: '🎓 Sugeng Rawuh di BasaKula LMS!',
                        description: `${locBadge('Header Navigasi Sidebar')}Selamat datang! Mari ikuti tur interaktif untuk mengetahui letak seluruh modul dan fitur belajar Bahasa Jawa.`,
                        side: sidePos,
                        align: 'start'
                    }
                },
                // 3. Dashboard Siswa
                {
                    element: '[data-tour="sidebar-dashboard-siswa"]',
                    popover: {
                        title: '🏠 Dashboard & Kelas Saya',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Halaman utama untuk melihat kelas yang kamu ikuti, memantau tugas & kuis aktif, serta progres belajarmu.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 4. Kalender
                {
                    element: '[data-tour="sidebar-kalender"]',
                    popover: {
                        title: '📅 Kalender Pembelajaran',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Cek jadwal kuis, pengumpulan tugas sekolah, dan agenda kegiatan belajar kamu agar tidak terlewat.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 5. Aksara Jawa
                {
                    element: '[data-tour="sidebar-aksara"]',
                    popover: {
                        title: '📜 Modul Aksara Jawa',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Sinau 20 Aksara Carakan Nglegena, Aksara Swara, Sandhangan, dan Pasangan dengan font Jawa interaktif.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 6. Macapat
                {
                    element: '[data-tour="sidebar-macapat"]',
                    popover: {
                        title: '🎵 Modul Tembang Macapat',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Sinau 10 Tembang Macapat, kaidah Guru Gatra/Wilangan/Lagu, serta dengarkan audio tembang macapat.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 7. Wayang
                {
                    element: '[data-tour="sidebar-wayang"]',
                    popover: {
                        title: '🎭 Ensiklopedia Pewayangan',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Jelajahi tokoh wayang Jawa (Pandawa 5, Punakawan, Kurawa) lengkap dengan silsilah dan watak kesatria.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 8. Kamus
                {
                    element: '[data-tour="sidebar-kamus"]',
                    popover: {
                        title: '📖 Kamus Kosakata Jawa',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Cari arti kata Ngoko dan Krama dari A-Z dan dengarkan suara pengucapan audio aslinya.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 9. Translator
                {
                    element: '[data-tour="sidebar-translator"]',
                    popover: {
                        title: '🔤 Translator Jawa Praktis',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Terjemahkan kalimat Bahasa Indonesia ke Bahasa Jawa Ngoko dan Krama Halus secara instan.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 10. Bookmark
                {
                    element: '[data-tour="sidebar-bookmark"]',
                    popover: {
                        title: '🔖 Bookmark Simpanan Saya',
                        description: `${locBadge('Menu Sidebar Kiri')}<b>Terletak di sini!</b> Buka kembali materi, kuis, kosakata, dan tokoh wayang favorit yang telah kamu tandai dengan tanda bookmark.`,
                        side: sidePos,
                        align: 'center'
                    }
                },
                // 11. Quick Button: Gabung Kelas (jika ada di halaman)
                {
                    element: '[data-tour="student-btn-gabung-kelas"]',
                    popover: {
                        title: '⚡ Tombol Gabung Kelas Anyar',
                        description: `${locBadge('Banner Dashboard Siswa')}Masukkan kode unik kelas yang diberikan oleh gurumu melalui tombol ini untuk langsung bergabung ke ruang kelas!`,
                        side: 'bottom',
                        align: 'end'
                    }
                },
                // 12. Tutorial Trigger
                {
                    element: '[data-tour="btn-tutorial-trigger"]',
                    popover: {
                        title: '❓ Bantuan & Tutorial Belajar',
                        description: `${locBadge('Tombol di Navbar Kanan Atas')}Jika bingung mencari letak fitur atau modul, tekan tombol <b>Tutorial System</b> ini kapan saja untuk memutar ulang panduan!`,
                        side: 'bottom',
                        align: 'end'
                    }
                }
            ];
        }
    }

    function initDriver() {
        if (typeof window.driver === 'undefined') {
            console.warn('Driver.js is not loaded yet.');
            return null;
        }

        const driverFn = window.driver.js ? window.driver.js.driver : window.driver;

        return driverFn({
            animate: true,
            opacity: 0.78,
            padding: 8,
            allowClose: true,
            overlayClickNext: false,
            popoverClass: 'basakula-tour-popover',
            nextBtnText: 'Selanjutnya ➔',
            prevBtnText: '⇠ Sebelumnya',
            doneBtnText: 'Selesai ✨',
            progressText: 'Langkah {{current}} dari {{total}}',
            showProgress: true,
            onHighlightStarted: function (element, step, options) {
                const isMobile = isMobileScreen();
                const sidebar = document.querySelector('.sidebar');
                const backdrop = document.getElementById('sidebar-backdrop');
                const isInsideSidebar = element && sidebar && sidebar.contains(element);

                if (isInsideSidebar) {
                    // Open sidebar smoothly and keep it visible
                    if (sidebar) {
                        sidebar.classList.add('active');
                        sidebar.classList.add('tour-open');
                        if (backdrop) backdrop.classList.remove('active');
                        if (isMobile) document.body.classList.add('sidebar-open');
                        try {
                            element.scrollIntoView({ behavior: 'instant', block: 'center' });
                        } catch (e) {
                            element.scrollIntoView();
                        }
                    }
                } else {
                    // Outside sidebar: close sidebar on mobile so element on page is in full view
                    if (sidebar && isMobile) {
                        sidebar.classList.remove('active');
                        sidebar.classList.remove('tour-open');
                        document.body.classList.remove('sidebar-open');
                    }
                    if (element) {
                        try {
                            element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        } catch (e) {
                            element.scrollIntoView();
                        }
                    }
                }
            },
            onHighlighted: function (element, step, options) {
                // Ensure alignment recalculation after any smooth scroll finishes
                setTimeout(function () {
                    if (driverObj && typeof driverObj.refresh === 'function') {
                        driverObj.refresh();
                    }
                }, 80);
            },
            onDestroyed: function () {
                cleanupSidebar();
                driverObj = null;
            }
        });
    }

    function cleanupSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        if (sidebar) {
            sidebar.classList.remove('active');
            sidebar.classList.remove('tour-open');
        }
        if (backdrop) {
            backdrop.classList.remove('active');
        }
        document.body.classList.remove('sidebar-open');
    }

    function startTour() {
        if (!driverObj) {
            driverObj = initDriver();
        }

        if (!driverObj) {
            alert('Panduan tutorial sedang disiapkan. Silakan coba sebentar lagi.');
            return;
        }

        const role = window.BASAKULA_USER_ROLE || 'student';
        const rawSteps = getStepsForRole(role);

        // Filter steps to only include elements that exist and are visible in DOM
        const validSteps = rawSteps.filter(step => {
            if (!step.element) return true;
            const el = document.querySelector(step.element);
            if (!el) return false;
            const style = window.getComputedStyle(el);
            if (style.display === 'none' || style.visibility === 'hidden') return false;
            return true;
        });

        if (validSteps.length === 0) {
            console.log('No valid tour elements found on current page.');
            return;
        }

        driverObj.setSteps(validSteps);
        driverObj.drive();
    }

    // Safety fallback: ensure clicking Done on the last step or Close (x) button always finishes the tour cleanly
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.driver-popover-next-btn, .driver-popover-close-btn');
        if (!btn || !driverObj) return;

        if (btn.classList.contains('driver-popover-close-btn')) {
            setTimeout(function () {
                if (driverObj && typeof driverObj.destroy === 'function') {
                    driverObj.destroy();
                }
            }, 10);
        } else if (btn.classList.contains('driver-popover-next-btn') && typeof driverObj.hasNextStep === 'function' && !driverObj.hasNextStep()) {
            setTimeout(function () {
                if (driverObj && typeof driverObj.destroy === 'function') {
                    driverObj.destroy();
                }
            }, 10);
        }
    });

    return {
        startTour: startTour
    };
})();

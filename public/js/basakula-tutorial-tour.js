/**
 * BasaKula LMS - Role-Based Interactive System Tutorial Tour Engine (Driver.js)
 */

window.BasaKulaTutorial = (function () {
    let driverObj = null;

    function getStepsForRole(role) {
        const r = (role || 'student').toLowerCase();

        if (r === 'admin') {
            return [
                {
                    element: '[data-tour="sidebar-header"]',
                    popover: {
                        title: '🎓 Panel Administrator BasaKula',
                        description: 'Selamat datang di Panel Utama Pengelola BasaKula LMS! Mari ikuti panduan singkat pengenalan fitur navigasi admin.',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '[data-tour="sidebar-kelola-pengajar"]',
                    popover: {
                        title: '👥 Kelola Data Pengajar (Guru)',
                        description: 'Menu ini digunakan untuk menambah akun guru baru, mereset password, mengedit data pengajar, dan mengaktifkan status akun.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-kelola-pelajar"]',
                    popover: {
                        title: '🎓 Kelola Data Pelajar (Siswa)',
                        description: 'Menu manajemen siswa untuk memverifikasi NISN, mendaftarkan akun siswa baru, serta melihat daftar kelas yang diikuti siswa.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-log-aktivitas"]',
                    popover: {
                        title: '📜 Audit Log Aktivitas Sistem',
                        description: 'Pantau riwayat audit trail aktivitas login pengguna, aktivitas pembuatan kelas, serta perubahan data penting dalam sistem.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-kamus"]',
                    popover: {
                        title: '📖 Kelola Master Kosakata (CSV Import)',
                        description: 'Mengimpor ribuan kosakata Bahasa Jawa secara massal via CSV serta memverifikasi padanan kata Ngoko dan Krama.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="btn-tutorial-trigger"]',
                    popover: {
                        title: '❓ Bantuan Kapan Saja',
                        description: 'Anda dapat mengulang panduan tur interaktif ini kapan saja dengan menekan tombol "Tutorial System" pada navbar ini.',
                        side: 'bottom',
                        align: 'end'
                    }
                }
            ];
        } else if (r === 'teacher' || r === 'pengajar') {
            return [
                {
                    element: '[data-tour="sidebar-header"]',
                    popover: {
                        title: '🎓 Ruang Pengajar BasaKula',
                        description: 'Sugeng rawuh! Mari ikuti panduan pengelolaan kelas dan pembuatan materi pembelajaran untuk siswa Anda.',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '[data-tour="sidebar-kelola-kelas"]',
                    popover: {
                        title: '👥 Kelola Ruang Kelas',
                        description: 'Halaman utama untuk memantau semua ruang kelas yang Anda ampu, melihat jumlah siswa terdaftar, dan mengakses ruang kelas.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-buat-kelas"]',
                    popover: {
                        title: '➕ Buat Ruang Kelas Baru',
                        description: 'Klik menu ini untuk membuat ruang kelas baru. Anda dapat memilih warna banner dan ikon visual yang menarik untuk kelas.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-kalender"]',
                    popover: {
                        title: '📅 Kalender Pembelajaran',
                        description: 'Memantau agenda mingguan, tenggat pengumpulan tugas siswa, dan jadwal kuis interaktif secara visual.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-aksara"]',
                    popover: {
                        title: '📜 Referensi Aksara Jawa',
                        description: 'Akses cepat ke materi 20 Aksara Nglegena, Aksara Swara, Sandhangan, & Pasangan untuk bahan mengajar.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-macapat"]',
                    popover: {
                        title: '🎵 Referensi Tembang Macapat',
                        description: 'Pelajari 10 Tembang Macapat, tabel Guru Gatra, Guru Wilangan, Guru Lagu, serta pemutaran audio lirik.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-wayang"]',
                    popover: {
                        title: '🎭 Ensiklopedia Pewayangan',
                        description: 'Katalog lengkap tokoh wayang Jawa (Pandawa 5, Punakawan, Kurawa) untuk memperkaya diskusi kelas.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="btn-tutorial-trigger"]',
                    popover: {
                        title: '❓ Panduan Tutorial Kapan Saja',
                        description: 'Klik tombol ini kapan saja untuk memutar kembali petunjuk penggunaan sistem BasaKula.',
                        side: 'bottom',
                        align: 'end'
                    }
                }
            ];
        } else {
            // Student / Pelajar (Default)
            return [
                {
                    element: '[data-tour="sidebar-header"]',
                    popover: {
                        title: '🎓 Sugeng Rawuh di BasaKula LMS!',
                        description: 'Selamat datang! Mari ikuti tur interaktif untuk memahami cara belajar dan menggunakan seluruh modul pembelajaran Jawa.',
                        side: 'right',
                        align: 'start'
                    }
                },
                {
                    element: '[data-tour="sidebar-dashboard-siswa"]',
                    popover: {
                        title: '🏠 Dashboard & Kelas Saya',
                        description: 'Tempat melihat kelas yang Anda ikuti, memantau progres belajar (hingga 100%), dan masuk ke ruang kelas.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-kalender"]',
                    popover: {
                        title: '📅 Kalender Pembelajaran',
                        description: 'Cek jadwal kuis, pengumpulan tugas sekolah, dan agenda kegiatan belajar Anda agar tidak terlewat.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-aksara"]',
                    popover: {
                        title: '📜 Modul Aksara Jawa',
                        description: 'Sinau 20 Aksara Carakan Nglegena, Aksara Swara, Sandhangan, dan Pasangan dilengkapi visualisasi font Jawa.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-macapat"]',
                    popover: {
                        title: '🎵 Modul Tembang Macapat',
                        description: 'Sinau 10 Tembang Macapat, kaidah Guru Gatra/Wilangan/Lagu, serta dengarkan pemutaran audio lirik tembang.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-wayang"]',
                    popover: {
                        title: '🎭 Ensiklopedia Pewayangan',
                        description: 'Jelajahi tokoh wayang Jawa (Pandawa 5, Punakawan, Kurawa) lengkap dengan silsilah keluarga dan watak ksatria.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-kamus"]',
                    popover: {
                        title: '📖 Kamus Kosakata Basa Jawa',
                        description: 'Cari kosakata Jawa (Ngoko & Krama) terurut Abjad (A-Z) dan dengarkan pengucapan audio (TTS).',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-translator"]',
                    popover: {
                        title: '🔤 Translator Jawa Instant',
                        description: 'Terjemahkan kalimat Bahasa Indonesia ke Bahasa Jawa Ngoko dan Krama Halus secara cepat.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="sidebar-bookmark"]',
                    popover: {
                        title: '🔖 Bookmark Simpanan Saya',
                        description: 'Akses kembali materi, kosakata, dan tokoh wayang favorit yang telah Anda simpan dengan tombol 🔖.',
                        side: 'right',
                        align: 'center'
                    }
                },
                {
                    element: '[data-tour="btn-tutorial-trigger"]',
                    popover: {
                        title: '❓ Bantuan & Tutorial',
                        description: 'Anda bisa menekan tombol "Tutorial System" ini kapan saja untuk memutar ulang panduan ini!',
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
            opacity: 0.75,
            padding: 8,
            allowClose: true,
            overlayClickNext: false,
            popoverClass: 'basakula-tour-popover',
            nextBtnText: 'Selanjutnya ➔',
            prevBtnText: '⇠ Sebelumnya',
            doneBtnText: 'Selesai ✨',
            progressText: 'Langkah {{current}} dari {{total}}',
            showProgress: true
        });
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

        // Filter steps to only include elements that currently exist in DOM
        const validSteps = rawSteps.filter(step => {
            if (!step.element) return true;
            return document.querySelector(step.element) !== null;
        });

        if (validSteps.length === 0) {
            console.log('No valid tour elements found on current page.');
            return;
        }

        driverObj.setSteps(validSteps);
        driverObj.drive();
    }

    return {
        startTour: startTour
    };
})();

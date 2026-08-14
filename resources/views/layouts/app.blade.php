<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LMS Bahasa Jawa') - BasaKula</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome / Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts for Javanese Script & Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Noto+Sans+Javanese:wght@500;600;700&family=Noto+Serif+Javanese:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Animate.css for Gamified entrance animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- ResponsiveVoice JS (Multi-Voice Indonesian TTS) -->
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=FREE_KEY"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @stack('styles')
</head>
<body>
    
    <div class="wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Page Content -->
        <div id="content">
            <!-- Navbar -->
            @include('layouts.navbar')

            <!-- Main Content Area -->
            <main class="container-fluid">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- File Viewer Modal (Google Drive Style Previewer) -->
    <div class="modal fade" id="fileViewerModal" tabindex="-1" aria-hidden="true" style="backdrop-filter: blur(8px); background: rgba(0,0,0,0.6);">
        <div class="modal-dialog modal-xl modal-dialog-centered" style="height: 90vh;">
            <div class="modal-content border-0 shadow-lg h-100 overflow-hidden" style="border-radius: 20px; background: #0f172a; color: #fff;">
                <div class="modal-header border-0 bg-dark bg-opacity-50 px-4 py-3 text-white">
                    <div class="d-flex align-items-center gap-3">
                        <i id="previewFileIcon" class="fa-solid fa-file text-accent fs-4"></i>
                        <div>
                            <h6 id="previewFileName" class="fw-bold mb-0 text-white text-truncate" style="max-width: 450px;">Document Preview</h6>
                            <small id="previewFileSize" class="text-white-50" style="font-size: 0.75rem;"></small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <a id="previewDownloadBtn" href="#" download class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm btn-bouncy">
                            <i class="fa-solid fa-download me-1"></i> Unduh
                        </a>
                        <a id="previewExternalBtn" href="#" target="_blank" class="btn btn-light btn-sm rounded-pill px-3 shadow-sm btn-bouncy text-dark fw-semibold">
                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Buka Tab Baru
                        </a>
                        <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body p-0 d-flex align-items-center justify-content-center bg-black bg-opacity-40 position-relative overflow-hidden" id="previewContainer">
                    <div id="previewSpinner" class="spinner-border text-primary position-absolute" role="status">
                        <span class="visually-hidden">Memuat berkas...</span>
                    </div>
                    <iframe id="previewIframe" src="" class="w-100 h-100 border-0 d-none"></iframe>
                    <img id="previewImg" src="" class="img-fluid max-h-100 d-none" style="max-height: 80vh; object-fit: contain;">
                    <video id="previewVideo" controls class="w-100 max-h-100 d-none" style="max-height: 80vh;"></video>
                    <div id="previewUnsupported" class="text-center p-5 d-none">
                        <i class="fa-solid fa-file-circle-exclamation text-warning mb-3" style="font-size: 4rem;"></i>
                        <h5 class="fw-bold text-white mb-2">Pratinjau Tidak Tersedia</h5>
                        <p class="text-white-50 mb-4">Format berkas ini tidak dapat dipratinjau langsung. Silakan unduh berkas untuk membukanya.</p>
                        <a id="previewFallbackDownload" href="#" download class="btn btn-primary rounded-pill px-4 btn-bouncy">
                            <i class="fa-solid fa-download me-2"></i>Unduh Berkas Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- LottieFiles Web Player (For Mascots) -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    
    <!-- Canvas Confetti (For Quiz/Success Effects) -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    
    <!-- Core JS & Auto Logout AFK Detector -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Sidebar Toggle Logic
            const sidebarToggle = document.getElementById('sidebarCollapse');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }

            // --- AFK Auto Logout System (20 Menit Inaktivitas) ---
            const timeoutDuration = 20 * 60 * 1000; // 20 Menit dalam Milidetik
            let afkTimer;

            function resetAfkTimer() {
                clearTimeout(afkTimer);
                afkTimer = setTimeout(function() {
                    // Redirect paksa ke halaman login saat idle / AFK 20 menit
                    alert("Sesi Anda telah berakhir karena tidak ada aktivitas selama 20 menit.");
                    window.location.href = "{{ route('login') }}";
                }, timeoutDuration);
            }

            // Event listener untuk mendeteksi aktivitas pengguna (Mouse, Keyboard, Touch, Scroll)
            const activityEvents = ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'];
            activityEvents.forEach(event => {
                window.addEventListener(event, resetAfkTimer, true);
            });

            // Inisialisasi timer pertama kali
            resetAfkTimer();
        });

        // Global Drive-Style File Previewer Function
        window.previewFile = function(url, fileName, fileSize = '', iconClass = 'fa-file', downloadUrl = '') {
            const modalEl = document.getElementById('fileViewerModal');
            if (!modalEl) return;

            const modal = new bootstrap.Modal(modalEl);
            const nameEl = document.getElementById('previewFileName');
            const sizeEl = document.getElementById('previewFileSize');
            const iconEl = document.getElementById('previewFileIcon');
            const downloadBtn = document.getElementById('previewDownloadBtn');
            const externalBtn = document.getElementById('previewExternalBtn');
            const fallbackDl = document.getElementById('previewFallbackDownload');

            const iframe = document.getElementById('previewIframe');
            const img = document.getElementById('previewImg');
            const video = document.getElementById('previewVideo');
            const spinner = document.getElementById('previewSpinner');
            const unsupported = document.getElementById('previewUnsupported');

            // Reset view state
            [iframe, img, video, unsupported].forEach(el => el.classList.add('d-none'));
            spinner.classList.remove('d-none');

            nameEl.textContent = fileName || 'Dokumen Preview';
            sizeEl.textContent = fileSize ? '(' + fileSize + ')' : '';
            iconEl.className = 'fa-solid ' + (iconClass || 'fa-file') + ' text-accent fs-4';

            const dlTarget = downloadUrl || url;
            downloadBtn.href = dlTarget;
            externalBtn.href = url;
            fallbackDl.href = dlTarget;

            const ext = (fileName.split('.').pop() || '').toLowerCase();
            
            if (['pdf'].includes(ext)) {
                iframe.src = url;
                iframe.onload = () => spinner.classList.add('d-none');
                iframe.classList.remove('d-none');
            } else if (['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx'].includes(ext)) {
                // Untuk lingkungan lokal (127.0.0.1 / localhost), Office Viewer & Google Docs tidak dapat mengunduh berkas langsung dari localhost publik.
                const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
                
                if (isLocal) {
                    // Tampilkan pesan informatif ramah pengguna bahwa berkas lokal siap diunduh/dibuka
                    spinner.classList.add('d-none');
                    unsupported.classList.remove('d-none');
                } else {
                    const absoluteUrl = window.location.origin + (url.startsWith('/') ? url : '/' + url);
                    iframe.src = `https://view.officeapps.live.com/op/embed.aspx?src=${encodeURIComponent(absoluteUrl)}`;
                    iframe.onload = () => spinner.classList.add('d-none');
                    iframe.classList.remove('d-none');
                }
            } else if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(ext)) {
                img.src = url;
                img.onload = () => spinner.classList.add('d-none');
                img.classList.remove('d-none');
            } else if (['mp4', 'webm', 'ogg'].includes(ext)) {
                video.src = url;
                video.onloadeddata = () => spinner.classList.add('d-none');
                video.classList.remove('d-none');
            } else {
                spinner.classList.add('d-none');
                unsupported.classList.remove('d-none');
            }

            modal.show();

            modalEl.addEventListener('hidden.bs.modal', function () {
                iframe.src = '';
                img.src = '';
                video.pause();
                video.src = '';
            }, { once: true });
        };
    </script>
    
    @stack('scripts')
</body>
</html>

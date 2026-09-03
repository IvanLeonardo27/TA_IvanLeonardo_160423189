<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#1F4D3A">
    <meta name="color-scheme" content="light">
    <title>@yield('title', 'LMS Bahasa Jawa') - BasaKula</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 â€” via kit CDN (lebih stabil di mobile) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- Google Fonts for Javanese Script & Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Noto+Sans+Javanese:wght@500;600;700&family=Noto+Serif+Javanese:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- ResponsiveVoice JS (Multi-Voice Indonesian TTS) -->
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=FREE_KEY"></script>
    
    <!-- PDF.js for Native In-Page Slide Rendering -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        if (window.pdfjsLib) {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        }
    </script>

    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Responsive CSS (Mobile/Tablet/Desktop) -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    
    <!-- Driver.js Spotlight Tour Library & Custom Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet" href="{{ asset('css/basakula-tutorial.css') }}">
    
    @stack('styles')
</head>
<body>
    
    <!-- Sidebar Backdrop (Mobile Overlay) -->
    <div id="sidebar-backdrop"></div>

    <div class="wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Page Content -->
        <div id="content">
            <!-- Navbar -->
            @include('layouts.navbar')

            <!-- Main Content Area -->
            <main class="container-fluid px-0 px-md-2">
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
                        <i id="previewFileIcon" class="fa-solid fa-file text-accent fs-4" aria-hidden="true"></i>
                        <div>
                            <h6 id="previewFileName" class="fw-bold mb-0 text-white text-truncate" style="max-width: 250px;">Document Preview</h6>
                            <small id="previewFileSize" class="text-white-50" style="font-size: 0.75rem;"></small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <a id="previewDownloadBtn" href="#" download class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm">
                            <i class="fa-solid fa-download me-1" aria-hidden="true"></i> <span class="d-none d-sm-inline">Unduh</span>
                        </a>
                        <a id="previewExternalBtn" href="#" target="_blank" class="btn btn-light btn-sm rounded-pill px-3 shadow-sm text-dark fw-semibold">
                            <i class="fa-solid fa-arrow-up-right-from-square me-1" aria-hidden="true"></i> <span class="d-none d-sm-inline">Tab Baru</span>
                        </a>
                        <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body p-0 d-flex align-items-center justify-content-center bg-black bg-opacity-40 position-relative overflow-hidden" id="previewContainer">
                    <div id="previewSpinner" class="spinner-border text-primary position-absolute" role="status">
                        <span class="visually-hidden">Memuat berkas...</span>
                    </div>
                    <iframe id="previewIframe" src="" class="w-100 h-100 border-0 d-none"></iframe>
                    <img id="previewImg" src="" class="img-fluid d-none" style="max-height: 80vh; object-fit: contain;" alt="Preview">
                    <video id="previewVideo" controls class="w-100 d-none" style="max-height: 80vh;"></video>
                    <div id="previewUnsupported" class="text-center p-5 d-none">
                        <i class="fa-solid fa-file-circle-exclamation text-warning mb-3" style="font-size: 4rem;" aria-hidden="true"></i>
                        <h5 class="fw-bold text-white mb-2">Pratinjau Tidak Tersedia</h5>
                        <p class="text-white-50 mb-4">Format berkas ini tidak dapat dipratinjau langsung. Silakan unduh berkas untuk membukanya.</p>
                        <a id="previewFallbackDownload" href="#" download class="btn btn-primary rounded-pill px-4">
                            <i class="fa-solid fa-download me-2" aria-hidden="true"></i>Unduh Berkas Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- LottieFiles Web Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    
    <!-- Canvas Confetti (Quiz/Success Effects) -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    
    <!-- Core JS: Sidebar + AFK + File Previewer -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // â”€â”€â”€ SIDEBAR SYSTEM â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            const sidebarToggle = document.getElementById('sidebarCollapse');
            const sidebarCloseBtn = document.querySelector('.sidebar-close-btn');
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            function openSidebar() {
                sidebar.classList.add('active');
                backdrop.classList.add('active');
                document.body.classList.add('sidebar-open');
            }

            function closeSidebar() {
                sidebar.classList.remove('active');
                backdrop.classList.remove('active');
                document.body.classList.remove('sidebar-open');
            }


            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    if (sidebar.classList.contains('active')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            }

            // Close via X button inside sidebar
            if (sidebarCloseBtn) {
                sidebarCloseBtn.addEventListener('click', closeSidebar);
            }

            // Close when backdrop is tapped
            if (backdrop) {
                backdrop.addEventListener('click', closeSidebar);
            }

            // Auto-close sidebar when any nav-link is clicked (mobile)
            const sidebarLinks = sidebar ? sidebar.querySelectorAll('.nav-link') : [];
            sidebarLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        closeSidebar();
                    }
                });
            });

            // ─── TOUCH SWIPE GESTURE (Slide ke kanan buka sidebar, Slide ke kiri tutup) ───
            let touchStartX = 0;
            let touchStartY = 0;
            let touchEndX = 0;
            let touchEndY = 0;

            window.addEventListener('touchstart', function(e) {
                if (e.touches && e.touches.length > 0) {
                    touchStartX = e.touches[0].clientX;
                    touchStartY = e.touches[0].clientY;
                }
            }, { passive: true });

            window.addEventListener('touchend', function(e) {
                if (window.innerWidth >= 992 || !sidebar) return;

                if (e.changedTouches && e.changedTouches.length > 0) {
                    touchEndX = e.changedTouches[0].clientX;
                    touchEndY = e.changedTouches[0].clientY;
                    
                    const deltaX = touchEndX - touchStartX;
                    const deltaY = touchEndY - touchStartY;
                    
                    // Pastikan geseran dominan horizontal (bukan scroll atas/bawah)
                    if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 40) {
                        const isOpen = sidebar.classList.contains('active');
                        
                        // 1. Geser ke KANAN (Edge Swipe Right) -> Buka sidebar jika dimulai dari tepi kiri layar (<= 35px)
                        if (deltaX > 0 && !isOpen && touchStartX <= 35) {
                            openSidebar();
                        }

                        
                        // 2. Geser ke KIRI (Swipe Left) -> Tutup sidebar jika sedang terbuka
                        if (deltaX < 0 && isOpen) {
                            closeSidebar();
                        }
                    }
                }
            }, { passive: true });

            // ─── AFK AUTO LOGOUT (20 Menit) ──────────────────────────

            const timeoutDuration = 20 * 60 * 1000;
            let afkTimer;

            function resetAfkTimer() {
                clearTimeout(afkTimer);
                afkTimer = setTimeout(function() {
                    alert("Sesi Anda telah berakhir karena tidak ada aktivitas selama 20 menit.");
                    window.location.href = "{{ route('login') }}";
                }, timeoutDuration);
            }

            const activityEvents = ['mousemove', 'keydown', 'click', 'scroll', 'touchstart', 'touchmove'];
            activityEvents.forEach(function(event) {
                window.addEventListener(event, resetAfkTimer, { passive: true });
            });

            resetAfkTimer();
        });

        // â”€â”€â”€ GLOBAL FILE PREVIEWER â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        window.previewFile = function(url, fileName, fileSize, iconClass, downloadUrl) {
            fileSize = fileSize || '';
            iconClass = iconClass || 'fa-file';
            downloadUrl = downloadUrl || '';

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

            [iframe, img, video, unsupported].forEach(function(el) { el.classList.add('d-none'); });
            spinner.classList.remove('d-none');

            nameEl.textContent = fileName || 'Dokumen Preview';
            sizeEl.textContent = fileSize ? '(' + fileSize + ')' : '';
            iconEl.className = 'fa-solid ' + iconClass + ' text-accent fs-4';

            const dlTarget = downloadUrl || url;
            downloadBtn.href = dlTarget;
            externalBtn.href = url;
            fallbackDl.href = dlTarget;

            const ext = (fileName.split('.').pop() || '').toLowerCase();
            
            if (['pdf'].includes(ext)) {
                iframe.src = url;
                iframe.onload = function() { spinner.classList.add('d-none'); };
                iframe.classList.remove('d-none');
            } else if (['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx'].includes(ext)) {
                const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
                if (isLocal) {
                    spinner.classList.add('d-none');
                    unsupported.classList.remove('d-none');
                } else {
                    const absoluteUrl = window.location.origin + (url.startsWith('/') ? url : '/' + url);
                    iframe.src = 'https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURIComponent(absoluteUrl);
                    iframe.onload = function() { spinner.classList.add('d-none'); };
                    iframe.classList.remove('d-none');
                }
            } else if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(ext)) {
                img.src = url;
                img.onload = function() { spinner.classList.add('d-none'); };
                img.classList.remove('d-none');
            } else if (['mp4', 'webm', 'ogg'].includes(ext)) {
                video.src = url;
                video.onloadeddata = function() { spinner.classList.add('d-none'); };
                video.classList.remove('d-none');
            } else {
                spinner.classList.add('d-none');
                unsupported.classList.remove('d-none');
            }

            modal.show();

            modalEl.addEventListener('hidden.bs.modal', function() {
                iframe.src = '';
                img.src = '';
                video.pause();
                video.src = '';
            }, { once: true });
        };
    </script>
    
    <!-- Driver.js & BasaKula Tutorial Engine -->
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="{{ asset('js/basakula-tutorial-tour.js') }}"></script>
    @auth
    <script>
        window.BASAKULA_USER_ROLE = "{{ auth()->user()->isAdmin() ? 'admin' : (auth()->user()->isTeacher() ? 'teacher' : 'student') }}";
    </script>
    @endauth

    @stack('scripts')
</body>
</html>

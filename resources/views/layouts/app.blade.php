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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time() }}">
    <!-- Responsive CSS (Mobile/Tablet/Desktop) -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}?v={{ file_exists(public_path('css/responsive.css')) ? filemtime(public_path('css/responsive.css')) : time() }}">
    
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
    <div class="modal fade" id="fileViewerModal" tabindex="-1" aria-hidden="true" style="backdrop-filter: blur(10px); background: rgba(0,0,0,0.75);">
        <div class="modal-dialog modal-xl modal-dialog-centered file-viewer-dialog">
            <div class="modal-content border-0 shadow-2xl overflow-hidden file-viewer-content" style="background: #0f172a; color: #fff;">
                {{-- Sticky Header (Always pinned at the top, guaranteed visible with prominent close button) --}}
                <div class="modal-header border-0 bg-dark bg-opacity-75 px-3 px-md-4 py-2.5 text-white flex-shrink-0 d-flex align-items-center justify-content-between gap-2" style="border-bottom: 1px solid rgba(255,255,255,0.12) !important; z-index: 10;">
                    <div class="d-flex align-items-center gap-2.5 overflow-hidden flex-grow-1 me-2" style="min-width: 0;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: rgba(255,255,255,0.1);">
                            <i id="previewFileIcon" class="fa-solid fa-file text-accent fs-5" aria-hidden="true"></i>
                        </div>
                        <div class="overflow-hidden flex-grow-1" style="min-width: 0;">
                            <h6 id="previewFileName" class="fw-bold mb-0 text-white text-truncate" style="font-size: 0.9rem;">Document Preview</h6>
                            <small id="previewFileSize" class="text-white-50 d-block text-truncate" style="font-size: 0.72rem;"></small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-1.5 flex-shrink-0">
                        <a id="previewDownloadBtn" href="#" download class="btn btn-outline-light btn-sm rounded-pill px-2.5 px-md-3 py-1.5 shadow-sm d-inline-flex align-items-center gap-1" title="Unduh Berkas">
                            <i class="fa-solid fa-download" aria-hidden="true"></i> 
                            <span class="d-none d-sm-inline">Unduh</span>
                        </a>
                        <a id="previewExternalBtn" href="#" target="_blank" class="btn btn-light btn-sm rounded-pill px-2.5 px-md-3 py-1.5 shadow-sm text-dark fw-semibold d-inline-flex align-items-center gap-1" title="Buka di Tab Baru">
                            <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i> 
                            <span class="d-none d-sm-inline">Tab Baru</span>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm rounded-pill px-2.5 px-md-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1 shadow-sm ms-1" data-bs-dismiss="modal" title="Tutup Pratinjau">
                            <i class="fa-solid fa-xmark"></i>
                            <span>Tutup</span>
                        </button>
                    </div>
                </div>

                {{-- Body Container --}}
                <div class="modal-body p-0 d-flex align-items-center justify-content-center bg-black bg-opacity-50 position-relative overflow-hidden flex-grow-1" id="previewContainer" style="min-height: 0;">
                    <div id="previewSpinner" class="spinner-border text-primary position-absolute" role="status">
                        <span class="visually-hidden">Memuat berkas...</span>
                    </div>
                    <iframe id="previewIframe" src="" class="w-100 h-100 border-0 d-none" style="display: block;"></iframe>
                    <img id="previewImg" src="" class="img-fluid d-none" style="max-height: 85vh; object-fit: contain;" alt="Preview">
                    <video id="previewVideo" controls class="w-100 d-none" style="max-height: 85vh;"></video>
                    <div id="previewUnsupported" class="text-center p-4 p-md-5 d-none">
                        <i class="fa-solid fa-file-circle-exclamation text-warning mb-3" style="font-size: 3.5rem;" aria-hidden="true"></i>
                        <h5 class="fw-bold text-white mb-2">Pratinjau Tidak Tersedia</h5>
                        <p class="text-white-50 mb-4 small" style="max-width: 400px; margin: 0 auto;">Format berkas ini tidak dapat dipratinjau langsung di browser. Silakan unduh berkas untuk membukanya.</p>
                        <a id="previewFallbackDownload" href="#" download class="btn btn-primary rounded-pill px-4 fw-semibold">
                            <i class="fa-solid fa-download me-2" aria-hidden="true"></i>Unduh Berkas Sekarang
                        </a>
                    </div>

                    {{-- Floating Bottom Close Button (Specially for Mobile) --}}
                    <button type="button" class="btn btn-danger rounded-pill shadow-lg position-absolute d-md-none file-viewer-floating-close"
                            style="bottom: 16px; left: 50%; transform: translateX(-50%); z-index: 20; padding: 7px 18px; font-weight: 700; font-size: 0.8rem; white-space: nowrap; box-shadow: 0 4px 16px rgba(0,0,0,0.6) !important;"
                            data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark me-1"></i> Tutup Layar Penuh
                    </button>
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

            // ─── GLOBAL BOOTSTRAP MODAL SYSTEM & MOBILE BACK BUTTON ───
            // 1. Move all modals to document.body so they escape any parent stacking contexts
            document.querySelectorAll('.modal').forEach(function(modalEl) {
                if (modalEl.parentElement !== document.body) {
                    document.body.appendChild(modalEl);
                }
            });

            // 2. On show.bs.modal, guarantee the modal is on document.body and push history state
            document.addEventListener('show.bs.modal', function(e) {
                const modalEl = e.target;
                if (modalEl && modalEl.classList.contains('modal') && modalEl.parentElement !== document.body) {
                    document.body.appendChild(modalEl);
                }

                // Add history entry for mobile browser back button dismiss
                if (!window.location.hash.includes('modal-active')) {
                    window.history.pushState({ modalActive: true, modalId: modalEl.id }, '', window.location.href);
                }
            });

            // 3. When a modal finishes closing, clean up orphaned backdrops and sync history
            document.addEventListener('hidden.bs.modal', function(e) {
                const anyOpenModal = document.querySelector('.modal.show');
                if (!anyOpenModal) {
                    document.querySelectorAll('.modal-backdrop').forEach(function(b) {
                        b.remove();
                    });
                    document.body.classList.remove('modal-open');
                    document.body.style.removeProperty('overflow');
                    document.body.style.removeProperty('padding-right');

                    if (window.history.state && window.history.state.modalActive) {
                        window.history.back();
                    }
                }
            });

            // 4. Handle Mobile Browser / Gesture Back Button to dismiss active modal
            window.addEventListener('popstate', function(e) {
                const openModals = document.querySelectorAll('.modal.show');
                if (openModals.length > 0) {
                    openModals.forEach(function(m) {
                        const bsInstance = bootstrap.Modal.getInstance(m);
                        if (bsInstance) {
                            bsInstance.hide();
                        } else {
                            m.classList.remove('show');
                            m.style.display = 'none';
                        }
                    });
                    document.querySelectorAll('.modal-backdrop').forEach(function(b) {
                        b.remove();
                    });
                    document.body.classList.remove('modal-open');
                    document.body.style.removeProperty('overflow');
                }
            });
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
                const pdfTargetUrl = url.includes('#') ? url : (url + '#view=FitH');
                iframe.src = pdfTargetUrl;
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

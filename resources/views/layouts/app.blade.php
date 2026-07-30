<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LMS Bahasa Jawa') - VanJava iLearning</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome / Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
    </script>
    
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') - LMS Bahasa Jawa</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome / Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        body {
            background: var(--grad-primary-cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-card {
            background: var(--bg-main);
            border-radius: var(--radius-lg);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }
        .auth-img {
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .auth-img::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            top: -50%;
            left: -50%;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-4">
                <h2 class="fw-bold text-white"><i class="fa-solid fa-graduation-cap me-2"></i>VanJava <span style="color: var(--accent);">iLearning</span></h2>
                <p class="text-white-50">Platform Belajar Bahasa Jawa Interaktif</p>
            </div>
        </div>
        
        <div class="auth-card row mx-auto">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Password Visibility Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-password-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const targetSelector = this.getAttribute('data-target');
                    const input = document.querySelector(targetSelector);
                    const icon = this.querySelector('i');
                    
                    if (input) {
                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                            icon.classList.remove('text-muted');
                            icon.classList.add('text-primary');
                        } else {
                            input.type = 'password';
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                            icon.classList.remove('text-primary');
                            icon.classList.add('text-muted');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>

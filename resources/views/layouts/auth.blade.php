<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk') - BasaKula</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Noto Serif Javanese -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Javanese:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-dark: #0f291e;
            --primary-emerald: #16402e;
            --accent-gold: #e2b76b;
            --accent-gold-light: #f5e4bd;
            --text-dark: #1e293b;
        }

        * {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0b1e16 0%, #163e2d 50%, #0d271c 100%);
            position: relative;
            overflow-x: hidden;
            padding: 24px 16px;
        }

        /* Subtle Geometric Batik / Ornament Background Overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(226, 183, 107, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(22, 64, 46, 0.5) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(226, 183, 107, 0.03) 0%, transparent 60%);
            pointer-events: none;
            z-index: 1;
        }

        /* Decorative Floating Glow Spheres */
        .glow-sphere-1 {
            position: absolute;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(226, 183, 107, 0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            filter: blur(40px);
            pointer-events: none;
            z-index: 1;
        }
        .glow-sphere-2 {
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(22, 64, 46, 0.6) 0%, transparent 70%);
            bottom: -120px;
            left: -120px;
            filter: blur(50px);
            pointer-events: none;
            z-index: 1;
        }

        .auth-container {
            width: 100%;
            max-width: 960px;
            position: relative;
            z-index: 10;
        }

        /* Glassmorphism Card Container */
        .glass-auth-card {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 28px;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.35),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        /* Left Side: Jawa Cultural Branding */
        .glass-left-panel {
            background: linear-gradient(145deg, #113324 0%, #1a4a35 60%, #0d281d 100%);
            color: #ffffff;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem 2.5rem;
        }

        .glass-left-panel::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 10% 90%, rgba(226, 183, 107, 0.15) 0%, transparent 50%);
            pointer-events: none;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            width: fit-content;
        }

        .javanese-watermark {
            font-family: 'Noto Serif Javanese', serif;
            position: absolute;
            right: -25px;
            bottom: -35px;
            font-size: 9rem;
            color: rgba(255, 255, 255, 0.04);
            user-select: none;
            pointer-events: none;
            line-height: 1;
        }

        /* Form Inputs & Controls */
        .custom-input-group {
            position: relative;
            transition: all 0.25s ease;
        }

        .custom-input-group .form-control {
            border-radius: 14px;
            padding: 0.85rem 1rem 0.85rem 2.9rem;
            border: 1.5px solid #e2e8f0;
            font-size: 0.95rem;
            background: #f8fafc;
            color: #1e293b;
            transition: all 0.2s ease;
        }

        .custom-input-group .form-control:focus {
            background: #ffffff;
            border-color: #16402e;
            box-shadow: 0 0 0 4px rgba(22, 64, 46, 0.12);
        }

        .input-icon-left {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            z-index: 5;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .custom-input-group:focus-within .input-icon-left {
            color: #16402e;
        }

        .input-btn-right {
            position: absolute;
            right: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            z-index: 5;
            padding: 4px;
        }

        .input-btn-right:hover {
            color: #1e293b;
        }

        /* Modern Elegant Submit Button */
        .btn-auth-submit {
            background: linear-gradient(135deg, #16402e 0%, #1f563e 100%);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 0.9rem 1.5rem;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.02em;
            box-shadow: 0 8px 20px -4px rgba(22, 64, 46, 0.4);
            transition: all 0.25s ease;
        }

        .btn-auth-submit:hover {
            background: linear-gradient(135deg, #123325 0%, #174230 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px -4px rgba(22, 64, 46, 0.5);
        }

        .btn-auth-submit:active {
            transform: translateY(0);
        }

        /* Feature Pills on Left Panel */
        .feature-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 10px 14px;
            margin-bottom: 10px;
        }
        .feature-pill i {
            color: var(--accent-gold);
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    
    <!-- Background Glowing Spheres -->
    <div class="glow-sphere-1"></div>
    <div class="glow-sphere-2"></div>

    <div class="auth-container">
        <div class="glass-auth-card">
            <div class="row g-0">
                @yield('content')
            </div>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-4">
            <small class="text-white-50">© {{ date('Y') }} BasaKula. Wadhah Sinau Basa lan Sastra Jawa Interaktif.</small>
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
                        } else {
                            input.type = 'password';
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>

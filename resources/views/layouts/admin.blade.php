<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#568203">
    <title>@yield('title', 'Admin Sinau Basa - Panel Pengelola')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <!-- Driver.js Spotlight Tour Library & Custom Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css">
    <link rel="stylesheet" href="{{ asset('css/basakula-tutorial.css') }}">

    <style>
        :root {
            --color-almond: #EFDECD;
            --color-green: #568203;
            --color-green-dark: #3e5d02;
        }

        body {
            font-family: 'Fredoka', sans-serif;
            background-color: var(--color-almond);
            color: #333;
        }

        .sidebar {
            background-color: var(--color-green);
        }

        .nav-item {
            transition: all 0.2s;
            border-radius: 12px;
        }

        .nav-item:hover,
        .nav-item.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .btn-green {
            background-color: var(--color-green);
            color: white;
            transition: all 0.2s;
        }

        .btn-green:hover {
            background-color: var(--color-green-dark);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>

    @stack('styles')
</head>

<body class="@yield('body_class', '')">
    @yield('content')

    <!-- Driver.js & BasaKula Tutorial Engine -->
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script src="{{ asset('js/basakula-tutorial-tour.js') }}"></script>
    @auth
    <script>
        window.BASAKULA_USER_ROLE = "admin";
    </script>
    @endauth

    @stack('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Sinau Basa - Panel Pengelola')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

    @stack('scripts')
</body>

</html>

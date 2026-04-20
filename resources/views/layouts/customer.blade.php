<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sinau Basa - Belajar Bahasa Jawa Seru')</title>

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

        .bg-green-primary {
            background-color: var(--color-green);
        }

        .text-green-primary {
            color: var(--color-green);
        }

        .border-green-primary {
            border-color: var(--color-green);
        }

        .card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 8px 0px rgba(86, 130, 3, 0.1);
            transition: transform 0.2s;
        }

        .btn-primary {
            background-color: var(--color-green);
            color: white;
            padding: 12px 24px;
            border-radius: 16px;
            font-weight: 600;
            box-shadow: 0 4px 0px var(--color-green-dark);
            transition: all 0.1s;
        }

        .btn-primary:active {
            transform: translateY(4px);
            box-shadow: 0 0px 0px var(--color-green-dark);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .tab-active {
            border-bottom: 4px solid var(--color-green);
            color: var(--color-green);
        }

        .character-bubble {
            position: relative;
            background: white;
            border-radius: 20px;
            padding: 15px;
            margin-bottom: 20px;
            border: 2px solid var(--color-green);
        }

        .character-bubble::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 20px;
            border-width: 10px 10px 0;
            border-style: solid;
            border-color: var(--color-green) transparent;
        }

        /* hide scrollbar (mobile chip list) */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    @stack('styles')
</head>

<body class="@yield('body_class', '')">
    @yield('content')

    @stack('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>@yield('title', 'Absensi Hunter')</title>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function () {
            var currentZoom = 1;
            // Block Ctrl+Scroll zoom
            document.addEventListener('wheel', function (e) {
                if (e.ctrlKey) { e.preventDefault(); }
            }, { passive: false });
            // Block Ctrl+Plus / Ctrl+Minus / Ctrl+0
            document.addEventListener('keydown', function (e) {
                if (e.ctrlKey && (e.key === '+' || e.key === '-' || e.key === '=' || e.key === '_' || e.key === '0')) {
                    e.preventDefault();
                }
            });
        })();
    </script>
</head>
<body class="bg-[#FAFAFA] min-h-dvh antialiased selection:bg-blue-200 dark:bg-[#121212] dark:text-[#E0E0E0]">
    <!-- Wrapper -->
    <main class="max-w-full px-4 py-4 sm:px-6 sm:py-6 space-y-4 sm:space-y-6">
        <!-- Header -->
        @include('layouts.header')
        <!-- end Header -->

        <!-- Main Content -->
        <section class="rounded-2xl sm:rounded-3xl p-4 sm:p-8 bg-whitesmoke inset-shadow-sm shadow-md dark:bg-[#1E1E1E] dark:shadow-none dark:border dark:border-white/10">
            @yield('content')
        </section>
        <!-- end Main Content -->
    </main>
</body>
</html>
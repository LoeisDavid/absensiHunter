<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover">
    <title>@yield('title', 'Absensi Hunter')</title>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
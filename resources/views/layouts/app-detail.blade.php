<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Absensi Hunter')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] min-h-dvh">
    <!-- Wrapper -->
    <main class="max-w-full px-4 py-4 sm:px-6 sm:py-6 space-y-4 sm:space-y-6">
        <!-- Header -->
        @include('layouts.header')
        <!-- end Header -->

        <!-- Main Content -->
        <section class="mt-8">
            @yield('content')
        </section>
        <!-- end Main Content -->
    </main>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Absensi Hunter')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] min-h-screen">
    <!-- Wrapper -->
    <main class="max-w-full mx-4 p-6 space-y-6">
        <!-- Header -->
        <header class="flex items-center justify-between font-title px-5">

            <!-- Logo -->
            <div class="flex items-center gap-4 text-logo">

                <img
                    src="{{ asset('img/logo/logo_tanpa_nama.png') }}"
                    alt="Logo"
                    class="w-24 h-24 object-contain"
                >

                <div>
                    <h1 class="text-3xl font-hunter tracking-wide text-center">
                        HUNTER
                    </h1>

                    <p class="text-lg font-community tracking-widest">
                        COMMUNITY
                    </p>
                </div>

            </div>

            <!-- Right Header -->
            <div class="flex items-center font-body gap-4">
                <!-- Qr -->
                <a href="{{ route('scan') }}" class="text-[#363636] hover:text-[#4d4d4d] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-12 h-12">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="currentColor" d="M3 4.5v5c0 .83.67 1.5 1.5 1.5h5c.83 0 1.5-.67 1.5-1.5v-5c0-.83-.67-1.5-1.5-1.5h-5C3.67 3 3 3.67 3 4.5M5 5h4v4H5zM3 19.5c0 .83.67 1.5 1.5 1.5h5c.83 0 1.5-.67 1.5-1.5v-5c0-.83-.67-1.5-1.5-1.5h-5c-.83 0-1.5.67-1.5 1.5zM5 15h4v4H5zM19.5 3h-5c-.83 0-1.5.67-1.5 1.5v5c0 .83.67 1.5 1.5 1.5h5c.83 0 1.5-.67 1.5-1.5v-5c0-.83-.67-1.5-1.5-1.5M19 9h-4V5h4zm-6 4h2v2h-2zm2 2h2v2h-2zm-2 2h2v2h-2zm4 0h2v2h-2zm2 2h2v2h-2zm-4 0h2v2h-2zm2-6h2v2h-2zm2 2h2v2h-2z" />
                    </svg>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="bg-[#363636] hover:bg-[#4d4d4d] transition text-white px-8 py-1 rounded-r-lg rounded-bl-lg shadow-sm font-bold cursor-pointer">
                        Log out
                    </button>
                </form>

            </div>

        </header>
        <!-- end Header -->

        <!-- Main Content -->
        <section class="rounded-3xl p-8 bg-[#F5F5F5] inset-shadow-sm shadow-md">
            @yield('content')
        </section>
        <!-- end Main Content -->
    </main>
</body>
</html>
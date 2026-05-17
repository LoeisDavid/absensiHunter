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
            <div class="flex items-center font-body">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="bg-[#363636] hover:bg-[#4d4d4d] transition text-white px-8 py-1 rounded-r-lg rounded-bl-lg shadow-sm font-bold">
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
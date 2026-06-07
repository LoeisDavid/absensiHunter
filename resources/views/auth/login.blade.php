<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Login Admin</title>
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function () {
            document.addEventListener('wheel', function (e) {
                if (e.ctrlKey) { e.preventDefault(); }
            }, { passive: false });
            document.addEventListener('keydown', function (e) {
                if (e.ctrlKey && (e.key === '+' || e.key === '-' || e.key === '=' || e.key === '_' || e.key === '0')) {
                    e.preventDefault();
                }
            });
        })();
    </script>
</head>
<body class="bg-cover bg-center bg-no-repeat min-h-dvh
    bg-[url('/public/img/login/background_mobile.png')]
    lg:bg-[url('/public/img/login/background.png')]
">
    <main class="grid lg:grid-cols-2 min-h-screen">

        <!-- MOBILE LOGO -->
        <div class="lg:hidden flex items-center justify-end mx-4">

            <div class="w-20 h-20 bg-white dark:bg-[#1e1e1e] dark:border dark:border-white/5 rounded-full shadow-xl flex items-center justify-center">

                <img
                    src="{{ asset('img/logo/logo_nama.png') }}"
                    alt="Logo"
                    class="w-12 object-contain"
                >

            </div>

        </div>

        <!-- LEFT -->
        <section class="hidden lg:flex items-center justify-center">
            <!-- Logo Circle -->
            <div class="bg-white dark:bg-[#1e1e1e] dark:border dark:border-white/5 rounded-full shadow-xl flex items-center justify-center" style="width: 450px; height: 450px;">
                <img
                    src="{{ asset('img/logo/logo_nama.png') }}"
                    alt="Logo"
                    class="w-72 object-contain"
                >
            </div>
        </section>
        
        <!-- Right -->
        <section class="flex items-center justify-center p-4 lg:mr-5 lg:p-8">
            <!-- Card -->
            <div class="max-w-md lg:max-w-2xl w-full rounded-2xl bg-[#FAFAFA] dark:bg-[#1e1e1e] dark:border dark:border-white/5 shadow-lg p-8 lg:p-16">
                <!-- Header -->
                <div class="font-title">

                    <h1 class="text-2xl lg:text-4xl font-bold text-font1 dark:text-white">
                        LOGIN ADMIN
                    </h1>

                    <p class="text-[#D91E2E] text-md lg:text-2xl mt-2 font-semibold lg:mt-6 opacity-75">
                        Hunter Attendance System
                    </p>

                </div>

                <!-- Form -->
                <form class="mt-8 lg:mt-16 lg:p-8 space-y-6" action="{{ route('login.post') }}" method="post">
                    @csrf
                    <!-- Username -->
                    <div>
                        <label class="block text-base lg:text-lg font-semibold text-font1 dark:text-white mb-4 font-title" for="username">
                            Your Username
                        </label>
                        <input
                            type="text"
                            class="w-full border-2 border-black dark:border-white/20 rounded-2xl px-4 py-3 text-xs lg:px-5 lg:py-4 lg:text-md outline-none bg-[#F5F5F5] dark:bg-[#252525] dark:text-white font-body"
                            placeholder="Input username"
                            name="username" id="username"
                            value="{{ old('username') }}"
                        >
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-base lg:text-lg font-semibold text-font1 dark:text-white mb-4 font-title" for="password">
                            Your Password
                        </label>
                        <input
                            type="password"
                            class="w-full border-2 border-black dark:border-white/20 rounded-2xl px-4 py-3 text-xs lg:px-5 lg:py-4 lg:text-md outline-none bg-[#F5F5F5] dark:bg-[#252525] dark:text-white font-body"
                            placeholder="Input password"
                            name="password" id="password"
                            value="{{ old('password') }}"
                        >
                    </div>

                    <!-- Button -->
                    <div class="flex justify-center pt-3 lg:pt-10 font-title">
                        <button
                            class="bg-[#363636] hover:bg-[#4d4d4d] dark:bg-[#D91E2E] dark:hover:bg-[#ff384b] transition text-white text-base lg:text-lg font-semibold px-14 py-2 lg:px-20 lg:py-2 rounded-2xl"
                            type="submit"
                        >
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cover bg-center bg-no-repeat min-h-screen" style="background-image: url('{{ asset('img/login/background.png') }}')">
    <main class="grid lg:grid-cols-2 min-h-screen">
        <!-- LEFT -->
        <section class="hidden lg:flex items-center justify-center">
            <!-- Logo Circle -->
            <div class="bg-white rounded-full shadow-xl flex items-center justify-center" style="width: 450px; height: 450px;">
                <img
                    src="{{ asset('img/logo/logo_nama.png') }}"
                    alt="Logo"
                    class="w-72 object-contain"
                >
            </div>
        </section>
        
        <!-- Right -->
        <section class="flex items-center justify-center p-8">
            <!-- Card -->
            <div class="max-w-full w-full rounded-2xl bg-[#FAFAFA] shadow-lg p-16">
                <!-- Header -->
                <div class="font-title">

                    <h1 class="text-4xl font-bold text-font1">
                        LOGIN ADMIN
                    </h1>

                    <p class="text-[#D91E2E] text-2xl font-semibold mt-6 opacity-75">
                        Hunter Attendance System
                    </p>

                </div>

                <!-- Form -->
                <form class="mt-15 p-8 space-y-5" action="{{ route('login.post') }}" method="post">
                    @csrf
                    <!-- Username -->
                    <div>
                        <label class="block text-lg font-semibold text-font1 mb-4 font-title" for="username">
                            Your Username
                        </label>
                        <input
                            type="text"
                            class="w-full border-2 border-black rounded-2xl px-4 py-4 text-md outline-none bg-[#F5F5F5] font-body"
                            placeholder="Input username"
                            name="username" id="username"
                            value="{{ old('username') }}"
                        >
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-lg font-semibold text-font1 mb-4 font-title" for="password">
                            Your Password
                        </label>
                        <input
                            type="password"
                            class="w-full border-2 border-black rounded-2xl px-4 py-4 text-md outline-none bg-[#F5F5F5] font-body"
                            placeholder="Input password"
                            name="password" id="password"
                            value="{{ old('password') }}"
                        >
                    </div>

                    <!-- Button -->
                    <div class="flex justify-center pt-10 font-title">
                        <button
                            class="bg-[#363636] hover:bg-[#4d4d4d] transition text-white text-lg font-semibold px-20 py-2 rounded-2xl"
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
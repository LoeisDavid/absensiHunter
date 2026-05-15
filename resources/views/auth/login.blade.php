<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Absensi Hunter</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex items-center justify-center p-4">

    <div class="w-full max-w-sm sm:max-w-md">

        {{-- Logo & Branding --}}
        <div class="flex flex-col items-center mb-8">
            <div class="mb-4">
                <svg width="56" height="56" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <polygon points="20,2 38,32 2,32" fill="#3b82f6" opacity="0.12"/>
                    <polygon points="20,5 10,30 20,25" fill="#ef4444"/>
                    <polygon points="20,5 30,30 20,25" fill="#22c55e"/>
                    <polygon points="10,30 30,30 20,25" fill="#3b82f6"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">HUNTER</h1>
            <p class="text-xs text-slate-400 tracking-[0.3em] font-medium">COMMUNITY</p>
            <p class="mt-3 text-slate-500 text-sm">Sistem Absensi Digital</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl shadow-blue-100/50 border border-slate-100 p-6 sm:p-8">

            <h2 class="text-xl font-bold text-slate-800 mb-1">Selamat Datang</h2>
            <p class="text-slate-500 text-sm mb-6">Masuk ke panel admin absensi</p>

            {{-- Alert Error --}}
            @if(session('error'))
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-sm">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-1.5">Username</label>
                    <input
                        type="text" id="username" name="username"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm
                               placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               transition-all @error('username') border-red-400 bg-red-50 @enderror"
                        required autofocus>
                    @error('username')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input
                            type="password" id="password" name="password"
                            placeholder="Masukkan password"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm
                                   placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   transition-all pr-11 @error('password') border-red-400 bg-red-50 @enderror"
                            required>
                        <button type="button" id="togglePassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold
                               py-3 px-4 rounded-xl transition-all shadow-md shadow-blue-200 hover:shadow-lg hover:shadow-blue-300
                               flex items-center justify-center gap-2 text-sm mt-2">
                    Masuk
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">© {{ date('Y') }} Hunter Community</p>
    </div>

    <script>
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        toggleBtn.addEventListener('click', () => {
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>
</html>

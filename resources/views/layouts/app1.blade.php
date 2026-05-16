<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Absensi Hunter')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-slate-50 font-sans min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 min-w-0">
                    <div class="flex-shrink-0">
                        <svg width="36" height="36" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <polygon points="20,2 38,32 2,32" fill="#3b82f6" opacity="0.15"/>
                            <polygon points="20,5 10,30 20,25" fill="#ef4444"/>
                            <polygon points="20,5 30,30 20,25" fill="#22c55e"/>
                            <polygon points="10,30 30,30 20,25" fill="#3b82f6"/>
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-bold text-slate-800 leading-tight">HUNTER</p>
                        <p class="text-xs text-slate-500 leading-tight tracking-widest">COMMUNITY</p>
                    </div>
                </a>

                {{-- Nav Links (Desktop) --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                              {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('absensi.peserta') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                              {{ request()->routeIs('absensi.peserta') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Peserta
                    </a>
                    <a href="{{ route('absensi.pengurus') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                              {{ request()->routeIs('absensi.pengurus') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Pengurus
                    </a>
                </div>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('scan') }}"
                       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-3 sm:px-4 py-2 rounded-lg transition-all shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        <span class="hidden sm:inline">Scan</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2 text-slate-600 hover:text-red-600 hover:bg-red-50 text-sm font-medium px-3 py-2 rounded-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Mobile Nav --}}
        <div class="md:hidden border-t border-slate-100 px-4 py-2 flex gap-1 overflow-x-auto">
            <a href="{{ route('dashboard') }}"
               class="whitespace-nowrap px-3 py-1.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100' }}">
                Dashboard
            </a>
            <a href="{{ route('absensi.peserta') }}"
               class="whitespace-nowrap px-3 py-1.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('absensi.peserta') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100' }}">
                Tabel Peserta
            </a>
            <a href="{{ route('absensi.pengurus') }}"
               class="whitespace-nowrap px-3 py-1.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('absensi.pengurus') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100' }}">
                Tabel Pengurus
            </a>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>

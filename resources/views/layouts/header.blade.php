<!-- Header -->
    <header class="flex items-center justify-between font-title sm:px-5 relative z-30">

        <div class="flex items-center gap-2 sm:gap-4 text-logo">
            <img
                src="{{ asset('img/logo/logo_tanpa_nama.png') }}"
                alt="Logo"
                class="w-14 h-14 sm:w-24 sm:h-24 object-contain"
            >
            <div>
                <h1 class="text-lg sm:text-3xl font-hunter tracking-wide text-center">
                    HUNTER
                </h1>
                <p class="text-sm sm:text-lg font-community tracking-widest">
                    COMMUNITY
                </p>
            </div>
        </div>

        <div class="hidden lg:flex items-center font-title gap-6 xl:gap-12 font-bold text-base xl:text-lg">
            <a href="{{ route('dashboard') }}" class="relative py-2">
                Beranda
                @if(request()->routeIs('dashboard'))
                    <div class="absolute bottom-0 left-0 w-full h-0.75 bg-body-text/75 rounded-full"></div>
                @endif
            </a>
            
            @php
                $isHadir = request()->routeIs(['absensi.peserta', 'absensi.pengurus']);
            @endphp
            <a href="{{ route('absensi.peserta') }}" class="relative py-2">
                Hadir
                @if($isHadir)
                    <div class="absolute bottom-0 left-0 w-full h-0.75 bg-body-text/75 rounded-full"></div>
                @endif
            </a>
            
            <a href="{{ route('jadwal.index') }}" class="relative py-2">
                Jadwal
                @if(request()->routeIs('jadwal.index'))
                    <div class="absolute bottom-0 left-0 w-full h-0.75 bg-body-text/75 rounded-full"></div>
                @endif
            </a>
            
            @php
                $isMember = request()->routeIs(['member.index', 'member.peserta', 'member.pengurus', 'member.show']);
            @endphp
            <a href="{{ route('member.index') }}" class="relative py-2">
                Anggota
                @if($isMember)
                    <div class="absolute bottom-0 left-0 w-full h-0.75 bg-body-text/75 rounded-full"></div>
                @endif
            </a>
            
            <a href="{{ route('detail.index') }}" class="relative py-2">
                Detail
                @if(request()->routeIs('detail.index'))
                    <div class="absolute bottom-0 left-0 w-full h-0.75 bg-body-text/75 rounded-full"></div>
                @endif
            </a>
        </div>

        <div class="flex items-center font-body">
            <div class="hidden lg:flex items-center gap-2 sm:gap-4">
                <a href="{{ route('scan') }}" class="shadow-md border-3 p-2 sm:px-6 sm:py-1 sm:bg-transparent sm:shadow-none text-graphite hover:text-[#4d4d4d] transition inline-flex items-center gap-2 font-bold font-title rounded-r-lg rounded-bl-lg text-lg">
                    <span>Scan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 shrink-0" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="currentColor" d="M9.5 6.5v3h-3v-3zM11 5H5v6h6zm-1.5 9.5v3h-3v-3zM11 13H5v6h6zm6.5-6.5v3h-3v-3zM19 5h-6v6h6zm-6 8h1.5v1.5H13zm1.5 1.5H16V16h-1.5zM16 13h1.5v1.5H16zm-3 3h1.5v1.5H13zm1.5 1.5H16V19h-1.5zM16 16h1.5v1.5H16zm1.5-1.5H19V16h-1.5zm0 3H19V19h-1.5zM22 7h-2V4h-3V2h5zm0 15v-5h-2v3h-3v2zM2 22h5v-2H4v-3H2zM2 2v5h2V4h3V2z" />
                    </svg>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-graphite hover:bg-[#4d4d4d] transition text-white p-2 sm:px-6 sm:py-3 rounded-r-lg rounded-bl-lg shadow-sm font-bold cursor-pointer inline-flex items-center gap-2">
                        <span class="hidden sm:block font-bold">Log out</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M14 8V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2" />
                                <path d="M9 12h12l-3-3m0 6l3-3" />
                            </g>
                        </svg>
                    </button>
                </form>
            </div>
            <div class="lg:hidden">
                <button id="mobile-menu-button" class="text-white bg-graphite p-2 rounded-lg cursor-pointer hover:bg-[#4d4d4d] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>
<!-- end Header -->

<!-- Mobile Sidebar -->
    <div id="mobile-overlay" class="hidden fixed inset-0 bg-body-text/75/20 backdrop-blur-xs z-40 transition-opacity duration-300 opacity-0"></div>

    <div id="mobile-sidebar" class="fixed top-0 right-0 h-full w-70 bg-whitesmoke border-l border-gray-200 z-50 p-6 flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-in-out font-title">
        
        <div class="flex flex-col gap-8">
            <a href="{{ route('scan') }}" class="w-full flex items-center justify-center gap-4 py-2.5 border-2 border-black rounded-xl bg-transparent text-gray-900 font-bold text-base transition hover:bg-gray-100">
                <span>Scan</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0 text-black" viewBox="0 0 24 24">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path fill="currentColor" d="M9.5 6.5v3h-3v-3zM11 5H5v6h6zm-1.5 9.5v3h-3v-3zM11 13H5v6h6zm6.5-6.5v3h-3v-3zM19 5h-6v6h6zm-6 8h1.5v1.5H13zm1.5 1.5H16V16h-1.5zM16 13h1.5v1.5H16zm-3 3h1.5v1.5H13zm1.5 1.5H16V19h-1.5zM16 16h1.5v1.5H16zm1.5-1.5H19V16h-1.5zm0 3H19V19h-1.5zM22 7h-2V4h-3V2h5zm0 15v-5h-2v3h-3v2zM2 22h5v-2H4v-3H2zM2 2v5h2V4h3V2z" />
                </svg>
            </a>

            <div class="flex flex-col gap-6 font-bold text-lg text-body-text pl-2">
                <a href="{{ route('dashboard') }}" class="relative self-start py-1">
                    Home
                    @if(request()->routeIs('dashboard'))
                        <div class="absolute bottom-0 left-0 w-full h-0.75 bg-body-text/75 rounded-full"></div>
                    @endif
                </a>

                <a href="{{ route('absensi.peserta') }}" class="relative self-start py-1">
                    Hadir
                    @if($isHadir)
                        <div class="absolute bottom-0 left-0 w-full h-0.75 bg-body-text/75 rounded-full"></div>
                    @endif
                </a>

                <a href="{{ route('jadwal.index') }}" class="relative self-start py-1">
                    Jadwal
                    @if(request()->routeIs('jadwal.index'))
                        <div class="absolute bottom-0 left-0 w-full h-0.75 bg-body-text/75 rounded-full"></div>
                    @endif
                </a>

                <a href="{{ route('member.index') }}" class="relative self-start py-1">
                    Anggota
                    @if($isMember)
                        <div class="absolute bottom-0 left-0 w-full h-0.75 bg-body-text/75 rounded-full"></div>
                    @endif
                </a>

                <a href="{{ route('detail.index') }}" class="relative self-start py-1">
                    Rincian
                    @if(request()->routeIs('detail.index'))
                        <div class="absolute bottom-0 left-0 w-full h-0.75 bg-body-text/75 rounded-full"></div>
                    @endif
                </a>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full bg-[#333333] hover:bg-body-text/75 transition text-white py-3 rounded-xl shadow-xs font-bold cursor-pointer flex items-center justify-center gap-3 text-base">
                <span>Log out</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-white" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M14 8V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2" />
                        <path d="M9 12h12l-3-3m0 6l3-3" />
                    </g>
                </svg>
            </button>
        </form>
    </div>
<!-- end Mobile Sidebar -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuBtn = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('mobile-overlay');

        function openSidebar() {
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                sidebar.classList.remove('translate-x-full');
            }, 10);
        }

        function closeSidebar() {
            sidebar.classList.add('translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
        }

        menuBtn.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);
    });
</script>

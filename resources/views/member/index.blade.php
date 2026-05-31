@extends('layouts.app')
@section('title', 'Anggota')

@section('content')
    <!-- Header -->
    <div class="flex flex-col gap-6">
        <!-- Back + Title -->
        <div class="flex items-center gap-3 sm:gap-6 font-title">

            <!-- Back Button -->
            <a
                href="{{ route('dashboard') }}"
                class="bg-[#363636] hover:bg-[#4d4d4d] transition text-white px-4 py-1 sm:px-8 sm:py-3 rounded-lg sm:rounded-2xl shadow-sm font-bold text-base sm:text-lg flex items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 9" class="w-6 h-6 sm:w-8 sm:h-8 shrink-0">
                    <path d="M0 0h16v9H0z" fill="none" />
                    <path fill="currentColor" d="M12.5 5h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5" />
                    <path fill="currentColor" d="M6 8.5a.47.47 0 0 1-.35-.15l-3.5-3.5c-.2-.2-.2-.51 0-.71L5.65.65c.2-.2.51-.2.71 0s.2.51 0 .71L3.21 4.51l3.15 3.15c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15Z" />
                </svg>

                <span class="hidden sm:block">Back</span>
            </a>

            <!-- Title -->
            <h1 class="text-xl sm:text-2xl font-bold text-body-text">
                Anggota
            </h1>

        </div>


        <!-- Tabs -->
        <div class="flex items-center font-title w-fit overflow-hidden rounded-2xl shadow-sm border border-gray-200 sm:mt-2">
            <!-- Semua -->
             <a
                href="#"
                class="px-5 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition bg-[#D91E2E] opacity-25 text-white pointer-events-none cursor-not-allowed shadow-2xl"
                disabled
            >
                Semua
            </a>
            <!-- Peserta -->
            <a
                href="{{ route('member.peserta') }}"
                class="px-5 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition border-r-gray-200 shadow-2xl"
            >
                Peserta
            </a>

            <!-- Panitia -->
            <a
                href="{{ route('member.pengurus') }}"
                class="px-5 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition"
            >
                Panitia
            </a>

        </div>
    </div>
    <!-- end Header -->

    <!-- Table Wrapper-->
    <div class="hidden lg:block mt-10 bg-white rounded-2xl shadow-sm p-8">

        <!-- Header -->
        <div class="grid grid-cols-5 pb-6 border-b border-gray-200 font-title text-body-text">

            <div class="text-xl font-bold">
                Nama
            </div>

            <div class="text-xl font-bold text-right">
                NIS
            </div>

            <div class="text-xl font-bold text-center">
                Divisi
            </div>

            <div class="text-xl font-bold text-center">
                Jabatan
            </div>

            <div class="text-xl font-bold text-center">
                Status
            </div>

        </div>



        <!-- Body -->
        <div class="divide-y divide-gray-100">

            <!-- Row -->
            
            <div class="grid grid-cols-5 items-center py-5 font-body text-body-text/75">

                <!-- Nama -->
                <div class="flex items-center gap-4">

                    <!-- Avatar -->
                    <img
                        src="https://i.pravatar.cc/150?img=12"
                        alt="Avatar"
                        class="w-12 h-12 rounded-full object-cover"
                    >

                    <!-- Info -->
                    <div>

                        <h3 class="font-medium text-base">
                            Muhammad Ibnu Dzaki
                        </h3>

                    </div>

                </div>


                <!-- NIS -->
                <div class="text-base font-medium text-right">
                    101.12345
                </div>


                <!-- Divisi -->
                <div class="flex justify-center">
                    tes
                </div>


                <!-- Jabatan -->
                <div class="flex justify-center">
                    LOL
                </div>

                <!-- Status -->
                <div class="flex justify-center">
                    Panitia
                </div>
            </div>
        </div>
    </div>
    <!-- end Table Wrapper -->
@endsection
@extends('layouts.app')
@section('title', 'Tabel Absensi Panitia')

@section('content')
<div class="flex flex-col gap-6">
        <!-- Back + Title -->
        <div class="flex items-center gap-6 font-title">

            <!-- Back Button -->
            <a
                href="{{ route('dashboard') }}"
                class="bg-[#363636] hover:bg-[#4d4d4d] transition text-white px-8 py-3 rounded-2xl shadow-sm font-bold text-lg"
            >
                Back
            </a>

            <!-- Title -->
            <h1 class="text-2xl font-bold text-body-text">
                Data Panitia
            </h1>

        </div>


        <!-- Tabs -->
        <div class="flex items-center font-title w-fit overflow-hidden rounded-2xl shadow-sm border border-gray-200 mt-2">

            <!-- Peserta -->
            <a
                href="{{ route('absensi.peserta') }}"
                class="px-10 py-3 text-xl font-bold transition"
            >
                Peserta
            </a>

            <!-- Panitia -->
            <a
                href="#"
                class="px-10 py-3 text-xl font-bold transition bg-[#D91E2E] opacity-25 text-white pointer-events-none cursor-not-allowed shadow-2xl"
                disabled
            >
                Panitia
            </a>

        </div>
</div>

    <!-- Table Wrapper -->
    <div class="mt-10 bg-white rounded-2xl shadow-sm p-8">

        <!-- Header -->
        <div class="grid grid-cols-4 pb-6 border-b border-gray-200 font-title text-body-text">

            <div class="text-xl font-bold">
                Nama
            </div>

            <div class="text-xl font-bold">
                NIS
            </div>

            <div class="text-xl font-bold text-center">
                Waktu hadir
            </div>

            <div class="text-xl font-bold text-center">
                Waktu keluar
            </div>

        </div>



        <!-- Body -->
        <div class="divide-y divide-gray-100">

            <!-- Row -->
            <div class="grid grid-cols-4 items-center py-5 font-body text-body-text">

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

                        <h3 class="font-semibold text-base">
                            Muhammad Nailul Fadhil
                        </h3>

                        <p class="text-sm text-gray-500">
                            Frontend Developer
                        </p>

                    </div>

                </div>


                <!-- NIS -->
                <div class="text-base font-medium">
                    101.01.2001
                </div>


                <!-- Waktu Hadir -->
                <div class="flex justify-center">

                    <p class="block bg-[#2DA635]/25 border-3 border-[#7AC77F] text-white font-bold px-10 py-2 rounded-xl shadow-sm text-center text-lg">
                        09:00
                    </p>

                </div>


                <!-- Waktu Keluar -->
                <div class="flex justify-center">

                    <p class="block bg-[#D91E2E]/25 border-3 border-[#EC7E8B] text-white font-bold px-10 py-2 rounded-xl shadow-sm text-center text-lg">
                        17:00
                    </p>

                </div>
            </div>
        </div>
    </div>



    <!-- Legend -->
    <div class="flex flex-wrap items-center gap-16 mt-10 font-title">
        <!-- Hadir -->
        <div class="flex items-center gap-4">

            <p class="block bg-[#2DA635]/25 border-3 border-[#7AC77F] text-white font-bold px-10 py-2 rounded-xl shadow-sm text-center text-lg">
                09:00
            </p>
            <span class="font-semibold text-body-text text-base">
                Waktu Hadir
            </span>
        </div>


        <!-- Keluar -->
        <div class="flex items-center gap-4">
            <div class="bg-[#D91E2E]/25 border-3 border-[#EC7E8B] text-white font-bold px-10 py-2 rounded-xl shadow-sm text-center text-lg">
                17:00
            </div>

            <span class="font-semibold text-body-text text-base">
                Waktu Keluar
            </span>
        </div>


        <!-- Belum Absen -->
        <div class="flex items-center gap-4">

            <div class="bg-[#0047C5]/25 border-3 border-[#7095DC] text-white font-bold px-10 py-2 rounded-xl shadow-sm text-center text-lg">
                -- : --
            </div>

            <span class="font-semibold text-body-text text-base">
                Belum Absen
            </span>

        </div>

    </div>
@endsection
@extends('layouts.app')
@section('title', 'Tabel Absensi Panitia')

@section('content')
<div class="flex flex-col gap-6">
        <!-- Back + Title -->
        <div class="flex items-center gap-3 sm:gap-6 font-title">

            <!-- Title -->
            <h1 class="text-xl sm:text-2xl font-bold text-body-text px-6">
                Data Panitia
            </h1>

        </div>


        <!-- Tabs -->
        <div class="flex items-center font-title w-fit overflow-hidden rounded-2xl shadow-sm border border-gray-200 dark:border-white/10 sm:mt-2">

            <!-- Peserta -->
            <a
                href="{{ route('absensi.peserta') }}"
                class="px-5 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition dark:text-[#E0E0E0] hover:dark:bg-white/5"
            >
                Peserta
            </a>

            <!-- Panitia -->
            <a
                href="#"
                class="px-5 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition bg-[#D91E2E] opacity-25 text-white pointer-events-none cursor-not-allowed shadow-2xl"
                disabled
            >
                Panitia
            </a>

        </div>
</div>

    <!-- Table Wrapper -->
    <div class="hidden lg:block mt-10 bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-2xl shadow-sm p-8">

        <!-- Header -->
        <div class="grid grid-cols-4 pb-6 border-b border-gray-200 dark:border-white/10 font-title text-body-text dark:text-white">

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
        <div class="divide-y divide-gray-100 dark:divide-white/5">

            <!-- Row -->
             @forelse($data as $i => $row)
            <div class="grid grid-cols-4 items-center py-5 font-body text-body-text dark:text-[#E0E0E0]">

                <!-- Nama -->
                <div class="flex items-center gap-4">

                    <!-- Avatar -->
                    @if(!empty($row['photo']) && file_exists(public_path($row['photo'])))
                        <img
                            src="{{ asset($row['photo']) }}"
                            alt="Avatar"
                            class="w-12 h-12 rounded-full object-cover shrink-0"
                        >
                    @else
                        <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-800 dark:bg-slate-700 dark:text-slate-200 font-bold text-xl flex items-center justify-center uppercase font-title shrink-0">
                            {{ substr($row['nama'] ?? '?', 0, 1) }}
                        </div>
                    @endif

                    <!-- Info -->
                    <div>

                        <h3 class="font-semibold text-base">
                            {{ $row['nama'] }}
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $row['divisi'] }}
                        </p>

                    </div>

                </div>


                <!-- NIS -->
                <div class="text-base font-medium">
                    {{ $row['nis'] }}
                </div>


                <!-- Waktu Hadir -->
                <div class="flex justify-center">

                    <p class="block bg-[#2DA635]/75 border-3 border-[#2DA635] text-white font-bold px-10 py-2 rounded-xl shadow-sm text-center text-lg">
                        {{ $row['waktu_datang'] }}
                    </p>

                </div>


                <!-- Waktu Keluar -->
                <div class="flex justify-center">
                    @if ($row['waktu_pulang'] === '-')
                        <p class="block bg-[#0047C5]/75 border-3 border-[#0047C5] text-white font-bold px-10 py-2 rounded-xl shadow-sm text-center text-lg">
                        -- : --
                        </p>

                    @else
                        <p class="block bg-[#D91E2E]/75 border-3 border-[#D91E2E] text-white font-bold px-10 py-2 rounded-xl shadow-sm text-center text-lg">
                        {{ $row['waktu_pulang'] }}
                        </p>
                    @endif

                </div>
            </div>
            @empty
            <div class="grid grid-cols-4 items-center py-5 font-body text-body-text">
                Tidak ada data
            </div>
            @endforelse
        </div>
    </div>
    <!-- end Table Wrapper -->

    <!-- Mobile Card -->
    <div class="lg:hidden mt-8 space-y-4">
        @forelse($data as $row)

        <details class="bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-2xl shadow-sm p-4 group">

            <!-- HEADER -->
            <summary class="list-none cursor-pointer flex items-center justify-between">

                <!-- Left -->
                <div class="flex items-center gap-3">

                    <!-- Avatar -->
                    @if(!empty($row['photo']) && file_exists(public_path($row['photo'])))
                        <img
                            src="{{ asset($row['photo']) }}"
                            alt="Avatar"
                            class="w-12 h-12 rounded-full object-cover shrink-0"
                        >
                    @else
                        <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-800 dark:bg-slate-700 dark:text-slate-200 font-bold text-xl flex items-center justify-center uppercase font-title shrink-0">
                            {{ substr($row['nama'] ?? '?', 0, 1) }}
                        </div>
                    @endif

                    <!-- Info -->
                    <div>

                        <h3 class="font-title font-semibold text-sm dark:text-white">
                            Nama : {{ $row['nama'] }}
                        </h3>

                        <p class="text-xs mt-1 font-body opacity-75">
                            {{ $row['divisi'] }}
                        </p>

                    </div>

                </div>


                <!-- Arrow -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-gray-500 transition group-open:rotate-180"
                    viewBox="0 0 24 24"
                >
                    <path
                        fill="currentColor"
                        d="M7 10l5 5l5-5z"
                    />
                </svg>

            </summary>


            <!-- CONTENT -->
            <div class="mt-5 border-t border-gray-100 dark:border-white/5 pt-4 font-body text-body-text dark:text-[#E0E0E0] space-y-4">

                <!-- NIS -->
                <div class="flex items-center justify-between text-sm opacity-75">

                    <span class="font-semibold">
                        NIS
                    </span>

                    <span>
                        {{ $row['nis'] }}
                    </span>

                </div>


                <!-- Waktu Hadir -->
                <div class="flex items-center justify-between text-sm">

                    <span class="font-semibold opacity-75">
                        Waktu Hadir
                    </span>

                    <p class="bg-[#2DA635]/75 border-2 border-[#2DA635]
                        text-white font-bold px-5 py-1 rounded-md shadow-sm text-xs">

                        {{ $row['waktu_datang'] }}

                    </p>

                </div>


                <!-- Waktu Keluar -->
                <div class="flex items-center justify-between text-sm">

                    <span class="font-semibold opacity-75">
                        Waktu Keluar
                    </span>

                    <p class="bg-[#D91E2E]/75 border-2 border-[#D91E2E]
                        text-white font-bold px-5 py-1 rounded-md shadow-sm text-xs">

                        {{ $row['waktu_pulang'] }}

                    </p>

                </div>

            </div>

        </details>

        @empty

        <div class="bg-white rounded-2xl shadow-sm p-6 text-center font-body text-body-text">
            Tidak ada data
        </div>

        @endforelse

    </div>
    <!-- end Mobile Card -->



    <!-- Legend -->
    <!-- <div class="flex flex-wrap items-center gap-16 mt-10 font-title"> -->
        <!-- Hadir -->
        <!-- <div class="flex items-center gap-4">

            <p class="block bg-[#2DA635]/25 border-3 border-[#7AC77F] text-white font-bold px-10 py-2 rounded-xl shadow-sm text-center text-lg">
                09:00
            </p>
            <span class="font-semibold text-body-text text-base">
                Waktu Hadir
            </span>
        </div> -->


        <!-- Keluar -->
        <!-- <div class="flex items-center gap-4">
            <div class="bg-[#D91E2E]/25 border-3 border-[#EC7E8B] text-white font-bold px-10 py-2 rounded-xl shadow-sm text-center text-lg">
                17:00
            </div>

            <span class="font-semibold text-body-text text-base">
                Waktu Keluar
            </span>
        </div> -->


        <!-- Belum Absen -->
        <!-- <div class="flex items-center gap-4">

            <div class="bg-[#0047C5]/25 border-3 border-[#7095DC] text-white font-bold px-10 py-2 rounded-xl shadow-sm text-center text-lg">
                -- : --
            </div>

            <span class="font-semibold text-body-text text-base">
                Belum Absen
            </span>

        </div>

    </div> -->
@endsection
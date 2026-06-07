@extends('layouts.app')
@section('title', 'Anggota')

@section('content')
    <!-- Header -->
    <div class="flex flex-col gap-6">
        <!-- Back + Title -->
        <div class="flex items-center gap-3 sm:gap-6 font-title">

            <!-- Title -->
            <h1 class="text-xl sm:text-2xl font-bold text-body-text dark:text-white px-6">
                Anggota
            </h1>

        </div>


        <!-- Tabs -->
        <div class="flex items-center font-title w-fit overflow-hidden rounded-2xl shadow-sm border border-gray-200 dark:border-white/10 sm:mt-2">
            <!-- Semua -->
            <a
                href="{{ route('member.index') }}"
                class="px-5 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition dark:text-[#E0E0E0] hover:dark:bg-white/5"
            >
                Semua
            </a>
            <!-- Peserta -->
            <a
                href="{{ route('member.peserta') }}"
                class="px-5 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition border-l-gray-200 shadow-md dark:text-[#E0E0E0] hover:dark:bg-white/5"
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
    <!-- end Header -->

    <!-- Table Wrapper-->
    <div class="hidden lg:block mt-10 bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-2xl shadow-sm p-8">

        <!-- Header -->
        <div class="grid grid-cols-5 pb-6 border-b border-gray-200 dark:border-white/10 font-title text-body-text dark:text-white">

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
        <div class="divide-y divide-gray-100 dark:divide-white/5">
            @forelse ($members as $row)
            <!-- Row -->
            <a href="{{ route('member.show', ['id' => $row['id']]) }}" class="block hover:bg-gray-100 dark:hover:bg-white/5 transition">
            <div class="grid grid-cols-5 items-center py-5 font-body text-body-text/75 dark:text-[#E0E0E0]">

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
                        <h3 class="font-medium text-base">
                            {{ $row['nama'] }}
                        </h3>
                    </div>

                </div>

                <!-- NIS -->
                <div class="text-base font-medium text-right font-mono">
                    {{ $row['nis'] }}
                </div>

                <!-- Divisi -->
                <div class="flex justify-center">
                    {{ $row['divisi'] }}
                </div>

                <!-- Jabatan -->
                <div class="flex justify-center">
                    {{ $row['jabatan'] }}
                </div>

                <!-- Status -->
                <div class="flex justify-center capitalize">
                    {{ $row['role'] === 'pengurus' ? 'Panitia' : 'Peserta' }}
                </div>
            </div>
            </a>
            @empty
            <div class="py-5 text-center text-gray-500 font-medium">
                Tidak ada data anggota.
            </div>
            @endforelse
        </div>
    </div>
    <!-- end Table Wrapper -->

    <!-- Mobile Card -->
    <div class="lg:hidden mt-8 space-y-4">
        @forelse($members as $row)
        <a href="{{ route('member.show', ['id' => $row['id']]) }}" class="block">
            <div class="bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-2xl shadow-sm p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-white/5 transition duration-150">
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
                        <h3 class="font-title font-semibold text-sm text-gray-900 dark:text-white">
                            {{ $row['nama'] }}
                        </h3>
                        <p class="text-xs mt-1 font-body text-gray-500 dark:text-gray-400">
                            {{ $row['divisi'] }} · {{ $row['jabatan'] }}
                        </p>
                    </div>
                </div>

                <!-- NIS and Status -->
                <div class="text-right">
                    <p class="text-xs font-mono font-bold text-gray-700 dark:text-[#E0E0E0]">
                        {{ $row['nis'] }}
                    </p>
                    <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-md mt-1.5
                        {{ $row['role'] === 'pengurus' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                        {{ $row['role'] === 'pengurus' ? 'Panitia' : 'Peserta' }}
                    </span>
                </div>
            </div>
        </a>
        @empty
        <div class="bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-2xl shadow-sm p-6 text-center font-body text-body-text dark:text-gray-400">
            Tidak ada data anggota.
        </div>
        @endforelse
    </div>
    <!-- end Mobile Card -->
@endsection
@extends('layouts.app')
@section('title', 'Anggota')

@section('content')
    <!-- Header -->
    <div class="flex flex-col gap-6">
        <!-- Back + Title -->
        <div class="flex items-center gap-3 sm:gap-6 font-title">

            <!-- Title -->
            <h1 class="text-xl sm:text-2xl font-bold text-body-text px-6">
                Anggota
            </h1>

        </div>


        <!-- Tabs -->
        <div class="flex items-center font-title w-fit overflow-hidden rounded-2xl shadow-sm border border-gray-200 sm:mt-2">
            <!-- Semua -->
             <a
                href="{{ route('member.index') }}"
                class="px-5 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition"
            >
                Semua
            </a>
            <!-- Peserta -->
            <a
                href="#"
                class="px-5 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition bg-[#D91E2E] opacity-25 text-white pointer-events-none cursor-not-allowed shadow-2xl"
                disabled
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
            @forelse ($members as $row)
            <!-- Row -->
            <a href="{{ route('member.show', ['id' => $row['id']]) }}" class="block hover:bg-gray-100 transition">
            <div class="grid grid-cols-5 items-center py-5 font-body text-body-text/75">

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
                        <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-800 font-bold text-xl flex items-center justify-center uppercase font-title shrink-0">
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
@endsection
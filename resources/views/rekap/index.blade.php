@extends('layouts.app')
@section('title', 'Rekap Absensi')

@section('content')
<div class="flex flex-col gap-6">
    <!-- Back + Title -->
    <div class="flex items-center gap-6 font-title">
        <!-- Back Button -->
        <a href="{{ route('dashboard') }}" class="bg-[#363636] hover:bg-[#4d4d4d] transition text-white px-8 py-3 rounded-2xl shadow-sm font-bold text-lg">
            Back
        </a>
        <!-- Title -->
        <h1 class="text-2xl font-bold text-body-text dark:text-white">
            Detail Absensi Bulanan
        </h1>
    </div>

    <!-- Tabs -->
    <div class="flex items-center font-title w-fit overflow-hidden rounded-2xl shadow-sm border border-gray-200 dark:border-white/10 mt-2 bg-white dark:bg-[#252525]">
        <!-- Peserta -->
        <a href="{{ route('rekap.index', ['role' => 'peserta']) }}" class="px-10 py-3 text-xl font-bold transition {{ $role === 'peserta' ? 'bg-[#D91E2E] text-white shadow-2xl' : 'opacity-50 text-gray-700 hover:opacity-100 dark:text-[#E0E0E0] hover:dark:bg-white/5' }}">
            Peserta
        </a>
        <!-- Panitia -->
        <a href="{{ route('rekap.index', ['role' => 'pengurus']) }}" class="px-10 py-3 text-xl font-bold transition {{ $role === 'pengurus' ? 'bg-[#D91E2E] text-white shadow-2xl' : 'opacity-50 text-gray-700 hover:opacity-100 dark:text-[#E0E0E0] hover:dark:bg-white/5' }}">
            Panitia
        </a>
    </div>
</div>

<!-- Table Wrapper -->
<div class="mt-10 bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-2xl shadow-sm p-4 sm:p-8">
    <!-- Header -->
    <div class="hidden sm:grid grid-cols-12 pb-6 border-b border-gray-200 dark:border-white/10 font-title text-body-text dark:text-white">
        <div class="col-span-5 text-xl font-bold">Nama</div>
        <div class="col-span-3 text-xl font-bold">NIS</div>
        <div class="col-span-4 text-xl font-bold text-center">Aksi</div>
    </div>

    <!-- Body -->
    <div class="divide-y divide-gray-100 dark:divide-white/5">
        @forelse($data as $row)
        <!-- Row -->
        <div class="grid grid-cols-1 sm:grid-cols-12 items-center py-5 font-body text-body-text dark:text-[#E0E0E0] gap-4 sm:gap-0">
            <!-- Nama -->
            <div class="col-span-1 sm:col-span-5 flex items-center gap-4">
                <!-- Avatar -->
                @if(!empty($row['photo']) && file_exists(public_path($row['photo'])))
                    <img src="{{ asset($row['photo']) }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover shrink-0">
                @else
                    <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-800 dark:bg-slate-700 dark:text-slate-200 font-bold text-xl flex items-center justify-center uppercase font-title shrink-0">
                        {{ substr($row['nama'] ?? '?', 0, 1) }}
                    </div>
                @endif
                <!-- Info -->
                <div>
                    <h3 class="font-semibold text-base dark:text-white">{{ $row['nama'] }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $row['divisi'] }}</p>
                </div>
            </div>

            <!-- NIS -->
            <div class="col-span-1 sm:col-span-3 text-base font-medium dark:text-white">
                <span class="sm:hidden text-gray-500 dark:text-gray-400 font-normal">NIS: </span>{{ $row['nis'] }}
            </div>

            <!-- Aksi -->
            <div class="col-span-1 sm:col-span-4 flex justify-start sm:justify-center">
                <a href="{{ route('rekap.show', $row['id']) }}" class="block bg-[#0047C5]/10 border-2 border-[#7095DC] text-[#0047C5] hover:bg-[#0047C5] hover:text-white dark:bg-[#0047C5]/20 dark:text-[#7095DC] dark:border-[#7095DC]/50 dark:hover:bg-[#0047C5] dark:hover:text-white transition font-bold px-6 py-2 rounded-xl text-center text-sm sm:text-base">
                    Lihat Detail
                </a>
            </div>
        </div>
        @empty
        <div class="py-5 font-body text-body-text dark:text-gray-400 text-center">
            Tidak Ada Data Anggota
        </div>
        @endforelse
    </div>
</div>
@endsection

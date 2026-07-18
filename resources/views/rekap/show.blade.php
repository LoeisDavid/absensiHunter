@extends('layouts.app')
@section('title', 'Detail Absensi - ' . $anggota['nama'])

@section('content')
<!-- Print Styles -->
<!-- Print Styles -->
<style>
    @media print {
        body { background-color: white !important; color: black !important; }
        .dark body { background-color: white !important; color: black !important; }
        .dark .bg-\[\#252525\] { background-color: white !important; color: black !important; }
        .dark .text-white { color: black !important; }
        .dark .text-\[\#E0E0E0\] { color: black !important; }
        .dark .text-gray-400 { color: #4b5563 !important; }
        .no-print { display: none !important; }
        .print-only { display: block !important; }
        .shadow-sm, .shadow-md, .inset-shadow-sm { box-shadow: none !important; border: 1px solid #e5e7eb; }
        .bg-[#F5F5F5] { background-color: white !important; }
        header { display: none !important; }
        main { padding: 0 !important; }
        section { padding: 0 !important; border: none !important; }
    }
</style>

<div class="flex flex-col gap-6">
    <!-- Back + Title -->
    <div class="flex flex-wrap items-center justify-between gap-6 font-title no-print">
        <div class="flex items-center gap-6">
            <!-- Back Button -->
            <a href="{{ route('rekap.index', ['role' => $anggota['role']]) }}" class="bg-[#363636] hover:bg-[#4d4d4d] transition text-white px-6 sm:px-8 py-2 sm:py-3 rounded-2xl shadow-sm font-bold text-base sm:text-lg">
                Back
            </a>
            <!-- Title -->
            <h1 class="text-xl sm:text-2xl font-bold text-body-text dark:text-white hidden sm:block">
                Detail Absensi
            </h1>
        </div>
        
        <div class="flex gap-3 items-center">
            <!-- Bulan Selector (Placeholder for manual update or form) -->
            <form action="{{ route('rekap.show', $anggota['id']) }}" method="GET" class="flex gap-2">
                <input type="month" name="month" value="{{ $month }}" class="border border-gray-300 dark:border-white/10 rounded-xl px-4 py-2 font-body text-sm bg-white dark:bg-[#252525] dark:text-white" onchange="this.form.submit()">
            </form>
            <!-- Print Button -->
            <button onclick="window.print()" class="bg-[#2DA635] hover:bg-[#238529] transition text-white px-6 py-2 rounded-xl shadow-sm font-bold text-base flex gap-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print
            </button>
        </div>
    </div>

    <!-- Print Header (Hidden on screen) -->
    <div class="hidden print-only text-center mb-6 border-b-2 border-black pb-4">
        <h1 class="text-3xl font-bold uppercase font-title">Laporan Kehadiran</h1>
        <p class="text-lg">Bulan: {{ date('F Y', strtotime($month . '-01')) }}</p>
    </div>

    <!-- Profile Summary -->
    <div class="bg-white dark:bg-[#252525] rounded-2xl shadow-sm p-6 sm:p-8 flex flex-col md:flex-row gap-8 items-start md:items-center justify-between border border-gray-100 dark:border-white/5">
        <!-- Profile Info -->
        <div class="flex items-center gap-6">
            @if(!empty($anggota['photo']) && file_exists(public_path($anggota['photo'])))
                <img src="{{ asset($anggota['photo']) }}" alt="Profile" class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover shadow-sm shrink-0">
            @else
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-slate-200 text-slate-800 dark:bg-slate-700 dark:text-slate-200 font-bold text-4xl flex items-center justify-center uppercase font-title shrink-0 shadow-sm">
                    {{ substr($anggota['nama'] ?? '?', 0, 1) }}
                </div>
            @endif
            <div class="font-body text-body-text dark:text-[#E0E0E0]">
                <h2 class="text-2xl sm:text-3xl font-bold font-title dark:text-white">{{ $anggota['nama'] }}</h2>
                <div class="grid grid-cols-2 gap-x-4 gap-y-1 mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">
                    <p class="font-semibold">NIS:</p>
                    <p>{{ $anggota['nis'] }}</p>
                    <p class="font-semibold">Divisi:</p>
                    <p>{{ $anggota['divisi'] }}</p>
                    <p class="font-semibold">Peran:</p>
                    <p class="capitalize">{{ $anggota['role'] }}</p>
                </div>
            </div>
        </div>

        <!-- Attendance Stats -->
        <div class="flex gap-4 sm:gap-6 w-full md:w-auto mt-4 md:mt-0 font-title">
            <!-- Hadir -->
            <div class="bg-[#2DA635]/10 border border-[#7AC77F] rounded-2xl p-4 flex-1 md:w-32 text-center">
                <p class="text-3xl sm:text-4xl font-bold text-[#2DA635]">{{ $totalHadir }}</p>
                <p class="text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 mt-1 uppercase tracking-wider">Hadir</p>
            </div>
            <!-- Tidak Hadir -->
            <div class="bg-[#D91E2E]/10 border border-[#EC7E8B] rounded-2xl p-4 flex-1 md:w-32 text-center">
                <p class="text-3xl sm:text-4xl font-bold text-[#D91E2E]">{{ $totalTidakHadir }}</p>
                <p class="text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 mt-1 uppercase tracking-wider">Tidak Hadir</p>
            </div>
            <!-- Total -->
            <div class="bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-900/50 rounded-2xl p-4 flex-1 md:w-32 text-center no-print">
                <p class="text-3xl sm:text-4xl font-bold text-blue-600 dark:text-blue-400">{{ count($jadwal) }}</p>
                <p class="text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 mt-1 uppercase tracking-wider">Jadwal</p>
            </div>
        </div>
    </div>

    <!-- Detail Table -->
    <div class="bg-white dark:bg-[#252525] rounded-2xl shadow-sm p-4 sm:p-8 border border-gray-100 dark:border-white/5">
        <h3 class="text-xl font-bold font-title text-body-text dark:text-white mb-6">Jadwal Kegiatan</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b-2 border-gray-200 dark:border-white/10 font-title text-gray-700 dark:text-white">
                        <th class="p-3 text-sm sm:text-base font-bold whitespace-nowrap">Tanggal</th>
                        <th class="p-3 text-sm sm:text-base font-bold">Kegiatan</th>
                        <th class="p-3 text-sm sm:text-base font-bold text-center">Status</th>
                        <th class="p-3 text-sm sm:text-base font-bold text-center">Datang</th>
                        <th class="p-3 text-sm sm:text-base font-bold text-center">Pulang</th>
                    </tr>
                </thead>
                <tbody class="font-body text-gray-600 dark:text-[#E0E0E0] divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($rekap as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="p-3 text-sm sm:text-base font-medium whitespace-nowrap">{{ date('d M Y', strtotime($row['tanggal'])) }}</td>
                        <td class="p-3 text-sm sm:text-base">{{ $row['kegiatan'] }}</td>
                        <td class="p-3 text-center">
                            @if($row['status'] === 'Hadir')
                                <span class="inline-block bg-[#2DA635]/20 text-[#238529] dark:text-[#7AC77F] font-bold px-3 py-1 rounded-lg text-xs sm:text-sm border border-[#7AC77F]/50">
                                    HADIR
                                </span>
                            @else
                                <span class="inline-block bg-[#D91E2E]/20 text-[#D91E2E] dark:text-[#EC7E8B] font-bold px-3 py-1 rounded-lg text-xs sm:text-sm border border-[#EC7E8B]/50">
                                    TIDAK HADIR
                                </span>
                            @endif
                        </td>
                        <td class="p-3 text-center font-semibold text-sm sm:text-base">{{ $row['waktu_datang'] }}</td>
                        <td class="p-3 text-center font-semibold text-sm sm:text-base">{{ $row['waktu_pulang'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500 dark:text-gray-400 font-medium bg-red-50 dark:bg-red-950/10">
                            Tidak ada jadwal untuk bulan ini ({{ $month }}).<br>
                            Peran (Role) Anggota ini: <b>{{ $anggota['role'] }}</b>.<br>
                            Pastikan di tab <b>jadwal</b> Google Sheet, terdapat data pada kolom `role` yang berisi `{{ $anggota['role'] }}` and tanggal yang sesuai dengan `{{ $month }}`.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

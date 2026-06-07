@extends('layouts.app-detail')
@section('title', 'Detail Absensi')

@section('content')
    <style>
    @media print {
        header,
        .no-print,
        .col-span-2,
        .md_col-span-4 {
            display: none !important;
        }
        .col-span-10,
        .md_col-span-8 {
            width: 100% !important;
            grid-column: span 12 / span 12 !important;
        }
        body {
            background: white !important;
            color: black !important;
        }
        .bg-[#F5F5F5] {
            background: transparent !important;
            padding: 0 !important;
            box-shadow: none !important;
        }
    }
    </style>

    <div class="grid grid-cols-12 gap-4 sm:gap-8">
        <!-- Sidebar PDF -->
        <div class="col-span-12 md:col-span-4 lg:col-span-3 no-print">
            <div class="md:sticky md:top-24 space-y-4">

            <!-- Back, Print, and Download Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-3 md:flex md:flex-col gap-3">
                <!-- Back Button -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center justify-center gap-2 bg-[#363636] hover:bg-[#4d4d4d] transition text-white px-4 py-3 rounded-lg shadow font-semibold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back</span>
                </a>

                <!-- Cetak / PDF Button -->
                <a href="{{ route('detail.print', ['month' => $selectedMonth, 'role' => $selectedRole]) }}" target="_blank"
                    class="flex items-center justify-center gap-2 bg-[#D91E2E] text-white px-4 py-3 rounded-lg shadow font-semibold text-sm hover:bg-[#b51825] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>Cetak / PDF</span>
                </a>

                <!-- Download PDF Button -->
                <a href="{{ route('detail.download', ['month' => $selectedMonth, 'role' => $selectedRole]) }}"
                    class="flex items-center justify-center gap-2 bg-[#D91E2E] text-white px-4 py-3 rounded-lg shadow font-semibold text-sm hover:bg-[#b51825] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Download PDF</span>
                </a>
            </div>

            <!-- Filter Form -->
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-150 font-title">
                <form method="GET" action="{{ route('detail.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 gap-4">
                    <!-- Month Filter -->
                    <div class="flex flex-col gap-1.5">
                        <label for="filter_month" class="font-bold text-xs text-gray-700">Pilih Bulan</label>
                        <input type="month" name="month" id="filter_month" value="{{ $selectedMonth }}" onchange="this.form.submit()"
                            class="w-full px-3 py-2 rounded-lg border-2 border-black focus:outline-none bg-whitesmoke text-xs font-semibold">
                    </div>

                    <!-- Role Filter -->
                    <div class="flex flex-col gap-1.5">
                        <label for="filter_role" class="font-bold text-xs text-gray-700">Peran (Role)</label>
                        <div class="relative">
                            <select name="role" id="filter_role" onchange="this.form.submit()"
                                class="w-full px-3 py-2 rounded-lg border-2 border-black bg-whitesmoke text-xs font-semibold appearance-none cursor-pointer outline-none">
                                <option value="all" {{ $selectedRole === 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="peserta" {{ $selectedRole === 'peserta' ? 'selected' : '' }}>Peserta</option>
                                <option value="pengurus" {{ $selectedRole === 'pengurus' ? 'selected' : '' }}>Panitia</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-3 h-3 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
        <!-- end Sidebar PDF -->

        <!-- Content -->
        <div class="col-span-12 md:col-span-8 lg:col-span-9">

            <!-- Card Abu -->
            <div class="bg-[#F5F5F5] rounded-2xl shadow-md p-4 sm:p-8 space-y-6 sm:space-y-10">

                @forelse ($pertemuanList as $pertemuan)
                <!-- Card Tanggal -->
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-10">

                    <div class="text-center mb-6 sm:mb-10">
                        <h2 class="text-lg sm:text-2xl font-title font-bold text-body-text px-2">
                            {{ \Carbon\Carbon::parse($pertemuan['tanggal'])->translatedFormat('l, d F Y') }}
                            <br class="sm:hidden">
                            <span class="text-sm sm:text-lg text-gray-500 font-semibold">
                                - {{ $pertemuan['kegiatan'] }} ({{ $pertemuan['role'] === 'pengurus' ? 'Panitia' : 'Peserta' }})
                            </span>
                        </h2>
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="w-full font-title">
                            <thead>
                                <tr class="bg-[#D9D9D9] text-white">
                                    <th class="px-6 py-5 text-left">Nama</th>
                                    <th class="px-6 py-5 text-center">NIS</th>
                                    <th class="px-6 py-5 text-center">Status</th>
                                    <th class="px-6 py-5 text-center">Jam hadir</th>
                                    <th class="px-6 py-5 text-center">Jam pulang</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($pertemuan['attendees'] as $row)
                                <tr class="bg-white">
                                    <td class="px-6 py-5">
                                        {{ $row['nama'] }}
                                    </td>

                                    <td class="px-6 py-5 text-center font-mono">
                                        {{ $row['nis'] }}
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @if ($row['status'] === 'Hadir')
                                            <span class="font-semibold text-[#2DA635]">
                                                Hadir
                                            </span>
                                        @else
                                            <span class="font-semibold text-[#D91E2E]">
                                                Tidak Hadir
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        {{ $row['waktu_datang'] }}
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        {{ $row['waktu_pulang'] }}
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white">
                                    <td colspan="5" class="px-6 py-5 text-center text-gray-500 font-medium">
                                        Tidak ada data anggota.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile List View -->
                    <div class="lg:hidden space-y-3">
                        @forelse ($pertemuan['attendees'] as $row)
                        <div class="bg-slate-50 rounded-xl p-4 border border-gray-150 space-y-3 font-title">
                            <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                                <span class="font-bold text-sm text-gray-900">{{ $row['nama'] }}</span>
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded-md
                                    {{ $row['status'] === 'Hadir' ? 'bg-[#2DA635]/15 text-[#2DA635]' : 'bg-[#D91E2E]/15 text-[#D91E2E]' }}">
                                    {{ $row['status'] }}
                                </span>
                            </div>
                            <div class="grid grid-cols-3 gap-2 text-xs font-body text-gray-600">
                                <div>
                                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">NIS</p>
                                    <p class="font-mono mt-0.5 text-gray-800 font-semibold">{{ $row['nis'] }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Jam Hadir</p>
                                    <p class="mt-0.5 text-gray-800 font-semibold">{{ $row['waktu_datang'] }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Jam Pulang</p>
                                    <p class="mt-0.5 text-gray-800 font-semibold">{{ $row['waktu_pulang'] }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-xs text-gray-500 py-3">Tidak ada data anggota.</p>
                        @endforelse
                    </div>

                </div>
                @empty
                <div class="bg-white rounded-xl shadow-sm p-6 sm:p-10 text-center font-title text-gray-500 font-semibold text-base sm:text-lg">
                    Tidak ada pertemuan/jadwal pada bulan ini.
                </div>
                @endforelse

                <!-- Card Total Kehadiran -->
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-10">

                    <div class="text-center mb-6 sm:mb-10">
                        <h2 class="text-lg sm:text-2xl font-title font-bold text-body-text px-2">
                            Tabel Total Kehadiran ({{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }})
                        </h2>
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="w-full font-title">
                            <thead>
                                <tr class="bg-[#D9D9D9] text-white">
                                    <th class="px-6 py-5 text-left">Nama</th>
                                    <th class="px-6 py-5 text-center">Hadir</th>
                                    <th class="px-6 py-5 text-center">Tidak Hadir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($summary as $row)
                                <tr class="bg-white">
                                    <td class="px-6 py-5">
                                        {{ $row['nama'] }}
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        {{ $row['hadir'] }}
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        {{ $row['tidak_hadir'] }}
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white">
                                    <td colspan="3" class="px-6 py-5 text-center text-gray-500 font-medium">
                                        Tidak ada data summary.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile List View -->
                    <div class="lg:hidden space-y-3">
                        @forelse ($summary as $row)
                        <div class="bg-slate-50 rounded-xl p-4 border border-gray-150 flex items-center justify-between font-title">
                            <div>
                                <h4 class="font-bold text-sm text-gray-900">{{ $row['nama'] }}</h4>
                            </div>
                            <div class="flex items-center gap-3 text-xs font-bold">
                                <span class="bg-green-50 text-green-700 px-2.5 py-1 rounded-lg">
                                    Hadir: {{ $row['hadir'] }}
                                </span>
                                <span class="bg-red-50 text-red-700 px-2.5 py-1 rounded-lg">
                                    Absen: {{ $row['tidak_hadir'] }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-xs text-gray-500 py-3">Tidak ada data summary.</p>
                        @endforelse
                    </div>

                </div>

            </div>
            <!-- End Card Abu -->

        </div>

    </div>
@endsection
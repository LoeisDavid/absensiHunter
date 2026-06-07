@extends('layouts.app')
@section('title', 'Detail Anggota')

@section('content')

<div class="flex flex-col gap-6">

    <!-- Back + Title -->
    <div class="flex items-center gap-6 font-title">

        <a
            href="{{ route('member.index') }}"
            class="bg-[#363636] hover:bg-[#4d4d4d] transition text-white px-8 py-3 rounded-2xl shadow-sm font-bold text-lg flex items-center gap-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 9" class="w-6 h-6">
                <path d="M0 0h16v9H0z" fill="none"/>
                <path fill="currentColor" d="M12.5 5h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5"/>
                <path fill="currentColor" d="M6 8.5a.47.47 0 0 1-.35-.15l-3.5-3.5c-.2-.2-.2-.51 0-.71L5.65.65c.2-.2.51-.2.71 0s.2.51 0 .71L3.21 4.51l3.15 3.15c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15Z"/>
            </svg>

            Back
        </a>

        <h1 class="text-2xl font-bold text-body-text">
            Profil Anggota
        </h1>

    </div>



    <!-- Profil -->
    <div class="flex flex-col lg:flex-row lg:justify-between items-center lg:items-start gap-8 lg:gap-16 mt-8">

        <!-- Kiri -->
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-12 w-full lg:w-auto">

            <!-- Foto -->
            @if(!empty($anggota['photo']) && file_exists(public_path($anggota['photo'])))
                <img
                    src="{{ asset($anggota['photo']) }}"
                    alt="Avatar"
                    class="w-32 h-32 sm:w-44 sm:h-44 rounded-full object-cover shrink-0"
                >
            @else
                <div class="w-32 h-32 sm:w-44 sm:h-44 rounded-full bg-slate-200 text-slate-800 font-bold text-5xl sm:text-7xl flex items-center justify-center uppercase font-title shrink-0">
                    {{ substr($anggota['nama'] ?? '?', 0, 1) }}
                </div>
            @endif

            <!-- Biodata -->
            <div class="space-y-4 sm:space-y-10 font-title text-body-text w-full">

                <div class="flex items-center">
                    <span class="font-bold text-lg sm:text-xl w-24 sm:w-32">Nama</span>
                    <span class="font-bold text-lg sm:text-xl mr-3 sm:mr-6">:</span>
                    <span class="text-lg sm:text-xl">
                        {{ $anggota['nama'] }}
                    </span>
                </div>

                <div class="flex items-center">
                    <span class="font-bold text-lg sm:text-xl w-24 sm:w-32">NIS</span>
                    <span class="font-bold text-lg sm:text-xl mr-3 sm:mr-6">:</span>
                    <span class="text-lg sm:text-xl font-mono">
                        {{ $anggota['nis'] }}
                    </span>
                </div>

                <div class="flex items-center">
                    <span class="font-bold text-lg sm:text-xl w-24 sm:w-32">Divisi</span>
                    <span class="font-bold text-lg sm:text-xl mr-3 sm:mr-6">:</span>
                    <span class="text-lg sm:text-xl">
                        {{ $anggota['divisi'] }}
                    </span>
                </div>

                <div class="flex items-start">
                    <span class="font-bold text-lg sm:text-xl w-24 sm:w-32 shrink-0">
                        Jabatan
                    </span>

                    <span class="font-bold text-lg sm:text-xl mr-3 sm:mr-6">
                        :
                    </span>

                    <span class="text-lg sm:text-xl">
                        {{ $anggota['jabatan'] }}
                    </span>
                </div>

            </div>

        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-5 font-title w-full lg:w-auto mt-4 lg:mt-0">

            <div class="bg-[#5C5C5C] text-white rounded-2xl p-4 sm:w-32 h-36 sm:h-48 flex flex-col justify-center items-center">
                <h3 class="text-3xl sm:text-5xl font-bold">
                    {{ $jumlahHadir }}
                </h3>

                <p class="text-center opacity-75 font-semibold text-sm sm:text-lg mt-2 sm:mt-4 leading-tight">
                    Jumlah
                    <br class="hidden sm:block">
                    hadir
                </p>
            </div>

            <div class="bg-[#5C5C5C] text-white rounded-2xl p-4 sm:w-32 h-36 sm:h-48 flex flex-col justify-center items-center">
                <h3 class="text-3xl sm:text-5xl font-bold">
                    {{ $jadwalHadir }}
                </h3>

                <p class="text-center opacity-75 font-semibold text-sm sm:text-lg mt-2 sm:mt-4 leading-tight">
                    Jadwal
                    <br class="hidden sm:block">
                    hadir
                </p>
            </div>

            <div class="bg-[#5C5C5C] text-white rounded-2xl p-4 sm:w-32 h-36 sm:h-48 flex flex-col justify-center items-center">
                <h3 class="text-3xl sm:text-5xl font-bold">
                    {{ $tidakHadir }}
                </h3>

                <p class="text-center opacity-75 font-semibold text-sm sm:text-lg mt-2 sm:mt-4 leading-tight">
                    Tidak
                    <br class="hidden sm:block">
                    hadir
                </p>
            </div>

            <div class="bg-[#5C5C5C] text-white rounded-3xl p-4 sm:w-32 h-36 sm:h-48 flex flex-col justify-center items-center">
                <h3 class="text-3xl sm:text-5xl font-bold">
                    {{ $extraHadir }}
                </h3>

                <p class="text-center opacity-75 font-semibold text-sm sm:text-lg mt-2 sm:mt-4 leading-tight">
                    Extra
                    <br class="hidden sm:block">
                    hadir
                </p>
            </div>

        </div>

    </div>



    <!-- Rincian Kehadiran -->
    <div class="mt-10">

        <h2 class="font-title text-3xl font-bold text-body-text mb-8">
            Rincian kehadiran
        </h2>

        <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-8 overflow-x-auto">

            <table class="w-full text-sm sm:text-lg">

                <thead>
                    <tr class="font-title text-lg sm:text-2xl text-body-text">

                        <th class="pb-4 sm:pb-8 text-center whitespace-nowrap">
                            Tanggal
                        </th>

                        <th class="pb-4 sm:pb-8 text-center whitespace-nowrap">
                            Waktu hadir
                        </th>

                        <th class="pb-4 sm:pb-8 text-center whitespace-nowrap">
                            Waktu keluar
                        </th>

                    </tr>
                </thead>

                <tbody class="font-body">
                    @forelse ($rincian as $row)
                    <tr class="border-b border-gray-200">
                        <td class="py-3 sm:py-5 text-center whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($row['tanggal'])->translatedFormat('l, d F Y') }}
                        </td>
                        <td class="py-3 sm:py-5 text-center">
                            @if ($row['waktu_datang'] === '-')
                            <span class="inline-block bg-[#0047C5]/75 border-3 border-[#0047C5] text-white font-bold px-6 py-1.5 sm:px-10 sm:py-2 rounded-xl shadow-sm text-sm sm:text-base">
                                -- : --
                            </span>
                            @else
                            <span class="inline-block bg-[#2DA635]/75 border-3 border-[#2DA635] text-white font-bold px-6 py-1.5 sm:px-10 sm:py-2 rounded-xl shadow-sm text-sm sm:text-base">
                                {{ $row['waktu_datang'] }}
                            </span>
                            @endif
                        </td>
                        <td class="py-3 sm:py-5 text-center">
                            @if ($row['waktu_pulang'] === '-')
                            <span class="inline-block bg-[#0047C5]/75 border-3 border-[#0047C5] text-white font-bold px-6 py-1.5 sm:px-10 sm:py-2 rounded-xl shadow-sm text-sm sm:text-base">
                                -- : --
                            </span>
                            @else
                            <span class="inline-block bg-[#D91E2E]/75 border-3 border-[#D91E2E] text-white font-bold px-6 py-1.5 sm:px-10 sm:py-2 rounded-xl shadow-sm text-sm sm:text-base">
                                {{ $row['waktu_pulang'] }}
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-5 text-center text-gray-500 font-semibold">
                            Belum ada riwayat kehadiran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

    </div>



    <!-- Legend -->
    <div class="flex flex-wrap items-center gap-6 sm:gap-20 mt-6 font-title">

        <div class="flex items-center gap-3">

            <span class="bg-[#2DA635]/75 border-3 border-[#2DA635] text-white font-bold px-6 py-1.5 sm:px-10 sm:py-2 rounded-xl shadow-sm text-sm sm:text-base">
                09:00
            </span>

            <span class="font-semibold text-sm sm:text-base">
                Waktu Hadir
            </span>

        </div>

        <div class="flex items-center gap-3">

            <span class="bg-[#D91E2E]/75 border-3 border-[#D91E2E] text-white font-bold px-6 py-1.5 sm:px-10 sm:py-2 rounded-xl shadow-sm text-sm sm:text-base">
                17:00
            </span>

            <span class="font-semibold text-sm sm:text-base">
                Waktu Keluar
            </span>

        </div>

        <div class="flex items-center gap-3">

            <span class="bg-[#0047C5]/75 border-3 border-[#0047C5] text-white font-bold px-6 py-1.5 sm:px-10 sm:py-2 rounded-xl shadow-sm text-sm sm:text-base">
                -- : --
            </span>

            <span class="font-semibold text-sm sm:text-base">
                Belum Absen
            </span>

        </div>

    </div>

</div>

@endsection
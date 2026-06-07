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
    <div class="flex justify-between items-start gap-16 mt-8">

        <!-- Kiri -->
        <div class="flex items-start gap-12">

            <!-- Foto -->
            @if(!empty($anggota['photo']) && file_exists(public_path($anggota['photo'])))
                <img
                    src="{{ asset($anggota['photo']) }}"
                    alt="Avatar"
                    class="w-44 h-44 rounded-full object-cover shrink-0"
                >
            @else
                <div class="w-44 h-44 rounded-full bg-slate-200 text-slate-800 font-bold text-7xl flex items-center justify-center uppercase font-title shrink-0">
                    {{ substr($anggota['nama'] ?? '?', 0, 1) }}
                </div>
            @endif

            <!-- Biodata -->
            <div class="space-y-10 font-title text-body-text">

                <div class="flex items-center">
                    <span class="font-bold text-xl w-32">Nama</span>
                    <span class="font-bold text-xl mr-6">:</span>
                    <span class="text-xl">
                        {{ $anggota['nama'] }}
                    </span>
                </div>

                <div class="flex items-center">
                    <span class="font-bold text-xl w-32">NIS</span>
                    <span class="font-bold text-xl mr-6">:</span>
                    <span class="text-xl font-mono">
                        {{ $anggota['nis'] }}
                    </span>
                </div>

                <div class="flex items-center">
                    <span class="font-bold text-xl w-32">Divisi</span>
                    <span class="font-bold text-xl mr-6">:</span>
                    <span class="text-xl">
                        {{ $anggota['divisi'] }}
                    </span>
                </div>

                <div class="flex items-start">
                    <span class="font-bold text-xl w-32 shrink-0">
                        Jabatan
                    </span>

                    <span class="font-bold text-xl mr-6">
                        :
                    </span>

                    <span class="text-xl">
                        {{ $anggota['jabatan'] }}
                    </span>
                </div>

            </div>

        </div>



        <!-- Statistik -->
        <div class="grid grid-cols-4 gap-5 shrink-0 font-title">

            <div class="bg-[#5C5C5C] text-white rounded-2xl w-32 h-48 flex flex-col justify-center items-center">
                <h3 class="text-5xl font-bold">
                    {{ $jumlahHadir }}
                </h3>

                <p class="text-center opacity-75 font-semibold text-lg mt-4">
                    Jumlah
                    <br>
                    hadir
                </p>
            </div>

            <div class="bg-[#5C5C5C] text-white rounded-2xl w-32 h-48 flex flex-col justify-center items-center">
                <h3 class="text-5xl font-bold">
                    {{ $jadwalHadir }}
                </h3>

                <p class="text-center opacity-75 font-semibold text-lg mt-4">
                    Jadwal
                    <br>
                    hadir
                </p>
            </div>

            <div class="bg-[#5C5C5C] text-white rounded-2xl w-32 h-48 flex flex-col justify-center items-center">
                <h3 class="text-5xl font-bold">
                    {{ $tidakHadir }}
                </h3>

                <p class="text-center opacity-75 font-semibold text-lg mt-4">
                    Tidak
                    <br>
                    hadir
                </p>
            </div>

            <div class="bg-[#5C5C5C] text-white rounded-3xl w-32 h-48 flex flex-col justify-center items-center">
                <h3 class="text-5xl font-bold">
                    {{ $extraHadir }}
                </h3>

                <p class="text-center opacity-75 font-semibold text-lg mt-4">
                    Extra
                    <br>
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

        <div class="bg-white rounded-2xl shadow-sm p-8">

            <table class="w-full">

                <thead>
                    <tr class="font-title text-2xl text-body-text">

                        <th class="pb-8 text-center">
                            Tanggal
                        </th>

                        <th class="pb-8 text-center">
                            Waktu hadir
                        </th>

                        <th class="pb-8 text-center">
                            Waktu keluar
                        </th>

                    </tr>
                </thead>

                <tbody class="font-body text-lg">
                    @forelse ($rincian as $row)
                    <tr class="border-b border-gray-200">
                        <td class="py-5 text-center">
                            {{ \Carbon\Carbon::parse($row['tanggal'])->translatedFormat('l, d F Y') }}
                        </td>
                        <td class="py-5 text-center">
                            @if ($row['waktu_datang'] === '-')
                            <span class="inline-block bg-[#0047C5]/75 border-3 border-[#0047C5] text-white font-bold px-10 py-2 rounded-xl shadow-sm">
                                -- : --
                            </span>
                            @else
                            <span class="inline-block bg-[#2DA635]/75 border-3 border-[#2DA635] text-white font-bold px-10 py-2 rounded-xl shadow-sm">
                                {{ $row['waktu_datang'] }}
                            </span>
                            @endif
                        </td>
                        <td class="py-5 text-center">
                            @if ($row['waktu_pulang'] === '-')
                            <span class="inline-block bg-[#0047C5]/75 border-3 border-[#0047C5] text-white font-bold px-10 py-2 rounded-xl shadow-sm">
                                -- : --
                            </span>
                            @else
                            <span class="inline-block bg-[#D91E2E]/75 border-3 border-[#D91E2E] text-white font-bold px-10 py-2 rounded-xl shadow-sm">
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
    <div class="flex items-center gap-20 mt-4 font-title">

        <div class="flex items-center gap-4">

            <span class="bg-[#2DA635]/75 border-3 border-[#2DA635] text-white font-bold px-10 py-2 rounded-xl shadow-sm">
                09:00
            </span>

            <span class="font-semibold">
                Waktu Hadir
            </span>

        </div>

        <div class="flex items-center gap-4">

            <span class="bg-[#D91E2E]/75 border-3 border-[#D91E2E] text-white font-bold px-10 py-2 rounded-xl shadow-sm">
                17:00
            </span>

            <span class="font-semibold">
                Waktu Keluar
            </span>

        </div>

        <div class="flex items-center gap-4">

            <span class="bg-[#0047C5]/75 border-3 border-[#0047C5] text-white font-bold px-10 py-2 rounded-xl shadow-sm">
                -- : --
            </span>

            <span class="font-semibold">
                Belum Absen
            </span>

        </div>

    </div>

</div>

@endsection
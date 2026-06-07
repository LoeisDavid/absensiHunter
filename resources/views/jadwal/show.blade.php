@extends('layouts.app')
@section('title', 'Detail Jadwal')

@section('content')
    <!-- Header -->
    <div class="flex flex-col gap-6">
        <!-- Back -->
        <div class="flex items-center gap-3 sm:gap-6 font-title">
            <a href="{{ route('jadwal.index') }}" class="bg-graphite hover:bg-[#4d4d4d] transition flex items-center gap-2 text-white px-8 py-3 rounded-2xl shadow-sm font-bold text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" viewBox="0 0 16 9">
                    <path d="M0 0h16v9H0z" fill="none" />
                    <path fill="currentColor" d="M12.5 5h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5" />
                    <path fill="currentColor" d="M6 8.5a.47.47 0 0 1-.35-.15l-3.5-3.5c-.2-.2-.2-.51 0-.71L5.65.65c.2-.2.51-.2.71 0s.2.51 0 .71L3.21 4.51l3.15 3.15c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15Z" />
                </svg>
                <span>Back</span>
            </a>
        </div>


        <!-- Title -->
        <div class="flex flex-col font-title text-body-text mt-4">
            <h1 class="text-xl sm:text-5xl font-bold">
                {{ $jadwal['kegiatan'] }} <span>({{ $jadwal['role'] === 'pengurus' ? 'Panitia' : 'Peserta' }})</span>
            </h1>
            <span class="text-sm sm:text-lg mt-6">{{ \Carbon\Carbon::parse($jadwal['tanggal'])->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>
    <!-- end Header -->

    <!-- Table -->
    <div class="w-full mt-10 bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-xs font-title">
        <table class="w-full border-collapse text-left my-4">
            <thead>
                <tr class="text-gray-900 border-none">
                    <th class="font-bold text-xl px-6 py-6 pl-12">Nama</th>
                    <th class="font-bold text-xl px-6 py-6">NIS</th>
                    <th class="font-bold text-xl px-6 py-6">Waktu hadir</th>
                    <th class="font-bold text-xl px-6 py-6">Waktu keluar</th>
                </tr>
            </thead>
            <tbody class="text-lg font-semibold font-body text-body-text/50">
                @forelse ($attendees as $row)
                <tr class="border-t border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 pl-12">
                        <div class="flex items-center gap-4">
                            @if(!empty($row['photo']) && file_exists(public_path($row['photo'])))
                                <img src="{{ asset($row['photo']) }}" class="w-12 h-12 rounded-full object-cover shrink-0" alt="Avatar">
                            @else
                                <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-800 font-bold text-xl flex items-center justify-center uppercase font-title shrink-0">
                                    {{ substr($row['nama'] ?? '?', 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-base text-body-text">{{ $row['nama'] }}</p>
                                <p class="text-sm font-medium text-gray-500">{{ $row['divisi'] }} - {{ $row['jabatan'] }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-base font-mono">{{ $row['nis'] }}</td>
                    <td class="px-6 py-4">
                        @if ($row['waktu_datang'] === '-- : --')
                        <div class="w-32 py-2 bg-[#0047C5]/75 border-3 border-[#0047C5] text-white font-bold rounded-xl shadow-md text-center text-lg tracking-wide">
                            -- : --
                        </div>
                        @else
                        <div class="w-32 py-2 bg-[#2DA635]/75 border-3 border-[#2DA635] text-white font-bold rounded-xl shadow-md text-center text-lg tracking-wide">
                            {{ $row['waktu_datang'] }}
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if ($row['waktu_pulang'] === '-- : --')
                        <div class="w-32 py-2 bg-[#0047C5]/75 border-3 border-[#0047C5] text-white font-bold rounded-xl shadow-md text-center text-lg tracking-wide">
                            -- : --
                        </div>
                        @else
                        <div class="w-32 py-2 bg-flagred/75 border-3 border-flagred text-white font-bold rounded-xl shadow-md text-center text-lg tracking-wide">
                            {{ $row['waktu_pulang'] }}
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 font-medium">
                        Tidak ada data anggota.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- end Table -->
@endsection
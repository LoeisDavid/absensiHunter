@extends('layouts.app')
@section('title', 'Detail Jadwal')

@section('content')
<!-- Header -->
    <div class="flex lg:flex-col gap-6">
        <div class="flex items-center gap-3 sm:gap-6 font-title">
            <a href="{{ route('jadwal.index') }}" class="bg-graphite hover:bg-[#4d4d4d] transition flex items-center gap-2 text-white px-4 py-2 sm:px-8 sm:py-3 rounded-lg sm:rounded-2xl shadow-sm font-bold text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" viewBox="0 0 16 9">
                    <path d="M0 0h16v9H0z" fill="none" />
                    <path fill="currentColor" d="M12.5 5h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5" />
                    <path fill="currentColor" d="M6 8.5a.47.47 0 0 1-.35-.15l-3.5-3.5c-.2-.2-.2-.51 0-.71L5.65.65c.2-.2.51-.2.71 0s.2.51 0 .71L3.21 4.51l3.15 3.15c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15Z" />
                </svg>
                <span class="hidden sm:block">Back</span>
            </a>
        </div>

        <div class="flex flex-col font-title text-body-text dark:text-white mt-4">
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-bold">
                {{ $jadwal['kegiatan'] }} <span>({{ $jadwal['role'] === 'pengurus' ? 'Panitia' : 'Peserta' }})</span>
            </h1>
            <span class="text-sm sm:text-lg mt-4 sm:mt-6">{{ \Carbon\Carbon::parse($jadwal['tanggal'])->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>
<!-- end Header -->

<!-- Table Dekstop -->
    <div class="hidden lg:block w-full mt-10 bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-3xl border border-gray-100 dark:border-white/10 overflow-hidden shadow-xs font-title">
        <table class="w-full border-collapse text-left my-4">
            <thead>
                <tr class="text-gray-900 dark:text-white border-none">
                    <th class="font-bold text-xl px-6 py-6 pl-12">Nama</th>
                    <th class="font-bold text-xl px-6 py-6">NIS</th>
                    <th class="font-bold text-xl px-6 py-6">Waktu hadir</th>
                    <th class="font-bold text-xl px-6 py-6">Waktu keluar</th>
                </tr>
            </thead>
            <tbody class="text-lg font-semibold font-body text-body-text/50 dark:text-[#E0E0E0]">
                @forelse ($attendees as $row)
                <tr class="border-t border-gray-50 dark:border-white/5 hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 pl-12">
                        <div class="flex items-center gap-4">
                            @if(!empty($row['photo']) && file_exists(public_path($row['photo'])))
                                <img src="{{ asset($row['photo']) }}" class="w-12 h-12 rounded-full object-cover shrink-0" alt="Avatar">
                            @else
                                <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-800 dark:bg-slate-700 dark:text-slate-200 font-bold text-xl flex items-center justify-center uppercase font-title shrink-0">
                                    {{ substr($row['nama'] ?? '?', 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-base text-body-text dark:text-white">{{ $row['nama'] }}</p>
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
<!-- end Table Dekstop -->

<!-- Table Mobile -->
    <div class="lg:hidden w-full mt-8 font-title flex flex-col gap-4">
        @forelse ($attendees as $row)
        <details class="group bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-2xl border border-gray-200 shadow-xs overflow-hidden text-body-text dark:text-white">
            <summary class="flex items-center justify-between p-5 cursor-pointer list-none select-none">
                <div class="flex items-center gap-4">
                    @if(!empty($row['photo']) && file_exists(public_path($row['photo'])))
                        <img src="{{ asset($row['photo']) }}" class="w-12 h-12 rounded-full object-cover shrink-0" alt="Avatar">
                    @else
                        <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-800 dark:bg-slate-700 dark:text-slate-200 font-bold text-lg flex items-center justify-center uppercase font-title shrink-0">
                            {{ substr($row['nama'] ?? '?', 0, 1) }}
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <h3 class="font-bold text-base md:text-lg">Nama : {{ $row['nama'] }}</h3>
                        <p class="text-xs opacity-75 font-medium">{{ $row['divisi'] }} - {{ $row['jabatan'] }}</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            
            <div class="px-7 pb-7 pt-2 border-t border-gray-50 dark:border-white/5 flex flex-col gap-4 text-base font-bold bg-white dark:bg-[#252525] text-body-text/75 dark:text-[#E0E0E0]">
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-4 text-gray-500 dark:text-gray-400 font-medium">NIS</span>
                    <span class="col-span-1 text-center text-gray-400 dark:text-gray-600">:</span>
                    <span class="col-span-7 text-right font-mono font-bold">{{ $row['nis'] }}</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-4 text-gray-500 dark:text-gray-400 font-medium">Waktu Hadir</span>
                    <span class="col-span-1 text-center text-gray-400 dark:text-gray-600">:</span>
                    <div class="col-span-7 flex justify-end text-center">
                        @if ($row['waktu_datang'] === '-- : --')
                            <span class="w-24 py-3 bg-[#0047C5]/75 text-white font-bold rounded-lg shadow-xs text-sm tracking-wide">-- : --</span>
                        @else
                            <span class="w-24 py-3 bg-[#2DA635]/75 text-white font-bold rounded-lg shadow-xs text-sm tracking-wide">{{ $row['waktu_datang'] }}</span>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-4 text-gray-500 dark:text-gray-400 font-medium">Waktu Keluar</span>
                    <span class="col-span-1 text-center text-gray-400 dark:text-gray-600">:</span>
                    <div class="col-span-7 flex justify-end text-center">
                        @if ($row['waktu_pulang'] === '-- : --')
                            <span class="w-24 py-3 bg-[#0047C5]/75 text-white font-bold rounded-lg shadow-xs text-sm tracking-wide">-- : --</span>
                        @else
                            <span class="w-24 py-3 bg-flagred/75 text-white font-bold rounded-lg shadow-xs text-sm tracking-wide">{{ $row['waktu_pulang'] }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </details>
        @empty
        <div class="bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-2xl shadow-sm p-6 text-center font-body text-body-text dark:text-gray-400">
            Tidak ada data anggota.
        </div>
        @endforelse
    </div>
<!-- end Table Mobile -->
@endsection

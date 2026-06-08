@extends('layouts.app')
@section('title', 'Jadwal')

@section('content')
<!-- Header -->
    <div class="flex flex-col gap-6">
        <div class="flex items-center justify-between font-title">

            <div class="flex items-center gap-3 sm:gap-6">
                <!-- Title -->
                <h1 class="text-xl sm:text-2xl font-bold text-body-text dark:text-white px-2 sm:px-6">
                    Tabel Jadwal
                </h1>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <button onclick="addSchedule.showModal()"
                    class="bg-flagred cursor-pointer transition text-white px-4 py-1 sm:px-8 sm:py-3 rounded-lg sm:rounded-2xl shadow-sm font-bold text-base sm:text-lg flex items-center gap-2"
                >
                    <span class="hidden sm:block">Add</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 shrink-0">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                    </svg>
                </button>

                <dialog id="addSchedule" class="m-auto rounded-[30px] sm:rounded-[40px] border-none p-0 shadow-2xl backdrop:bg-black/50 open:animate-in open:fade-in open:zoom-in duration-300 dark:bg-[#1A1A1A]">
                    <div class="w-[90vw] md:w-112.5 lg:w-125 xl:w-137.5 max-w-full bg-white dark:bg-[#1A1A1A] dark:text-white p-6 sm:p-12 flex flex-col relative">
                        
                        <div class="flex items-center gap-3 mb-8 sm:mb-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-7 h-7 sm:w-8 sm:h-8 shrink-0">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m-7-7h14" />
                            </svg>
                            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Tambah jadwal</h2>
                        </div>

                        <form action="{{ route('jadwal.store') }}" method="POST" class="flex flex-col gap-6 sm:gap-8">
                            @csrf
                            <div class="flex flex-col gap-2 sm:gap-3">
                                <label class="font-bold text-base sm:text-lg" for="activity">Activity</label>
                                <input type="text" name="activity" id="activity" placeholder="Contoh: Kelas Coding" 
                                    class="w-full px-5 py-3.5 sm:px-6 sm:py-4 rounded-xl sm:rounded-2xl border-2 border-black dark:border-white/20 focus:outline-none bg-whitesmoke dark:bg-[#252525] dark:text-white text-sm sm:text-base font-medium">
                            </div>

                            <div class="flex flex-col gap-2 sm:gap-3">
                                <label class="font-bold text-base sm:text-lg" for="date">Date (DD/MM/YYYY)</label>
                                <input type="date" name="date" id="date" placeholder="--/--/----" 
                                    class="w-full px-5 py-3.5 sm:px-6 sm:py-4 rounded-xl sm:rounded-2xl border-2 border-black dark:border-white/20 focus:outline-none bg-whitesmoke dark:bg-[#252525] dark:text-white text-sm sm:text-base font-medium">
                            </div>

                            <div class="flex flex-col gap-2 sm:gap-3">
                                <label class="font-bold text-base sm:text-lg text-gray-900 dark:text-white">Role</label>
                                <div class="relative">
                                    <select name="role" id="role" 
                                        class="w-full px-5 py-3.5 sm:px-6 sm:py-4 rounded-xl sm:rounded-2xl border-2 border-black dark:border-white/20 bg-whitesmoke dark:bg-[#252525] dark:text-white text-sm sm:text-base font-medium appearance-none cursor-pointer transition-all outline-none">
                                        <option value="" disabled selected>Pilih Role</option>
                                        <option value="peserta">Peserta</option>
                                        <option value="pengurus">Panitia</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-5 sm:pr-6 pointer-events-none">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-black dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2 flex justify-end gap-3">
                                <button type="button" onclick="addSchedule.close()"
                                    class="px-5 py-2.5 sm:px-6 sm:py-3 bg-body-text/75 text-white rounded-xl sm:rounded-2xl font-bold text-lg sm:text-xl cursor-pointer shadow-md text-center">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 sm:px-6 sm:py-3 bg-flagred text-white rounded-xl sm:rounded-2xl font-bold text-lg sm:text-xl cursor-pointer shadow-md text-center">
                                    Add
                                </button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>
            </div>
    </div>
<!-- end Header -->

<!-- Table Dekstop -->
    <div class="hidden lg:flex w-full mt-8 bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-3xl border border-gray-200 dark:border-white/10 overflow-hidden shadow-sm font-title flex-col items-center">
        <table class="w-full border-collapse text-center mt-4">
            <thead>
                <tr class="text-gray-900 dark:text-white">
                    <th class="font-bold text-xl px-6 py-6">Tanggal</th>
                    <th class="font-bold text-xl px-6 py-6">Kegiatan</th>
                    <th class="font-bold text-xl px-6 py-6">Total</th>
                    <th class="font-bold text-xl px-6 py-6">Peran</th>
                    <th class="font-bold text-xl px-6 py-6">Status</th>
                    <th class="font-bold text-xl px-6 py-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-body-text dark:text-[#E0E0E0] text-lg font-medium font-body">
                @forelse ($schedules as $row)
                <tr class="border-t border-gray-100 dark:border-white/5">
                    <td class="px-6 py-5">
                        {{ \Carbon\Carbon::parse($row['tanggal'])->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-6 py-5">{{ $row['kegiatan'] }}</td>
                    <td class="px-6 py-5">{{ $row['total_hadir'] }}</td>
                    <td class="px-6 py-5 capitalize">{{ $row['role'] === 'pengurus' ? 'Panitia' : 'Peserta' }}</td>
                    <td class="px-6 py-5">
                        @if ($row['status'] === 'Berlangsung')
                            <span class="text-blue-600 font-bold">Berlangsung</span>
                        @elseif ($row['status'] === 'Selesai')
                            <span class="text-[#2DA635] font-bold">Selesai</span>
                        @else
                            <span class="text-gray-400 font-bold">Segera</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        @if ($row['status'] === 'Segera')
                            <button disabled class="px-8 py-2 border-2 border-gray-200 dark:border-white/10 text-gray-300 dark:text-gray-600 rounded-xl font-bold text-lg bg-white dark:bg-[#252525] cursor-not-allowed">
                                Detail
                            </button>
                        @else
                            <a href="{{ route('jadwal.show', $row['id']) }}" class="inline-block px-8 py-2 bg-graphite/75 text-white rounded-xl font-bold text-lg shadow-sm transition hover:bg-graphite">
                                Detail
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-5 text-center text-gray-500 font-medium">
                        Belum ada jadwal terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
<!-- end Table Dekstop -->

<!-- Table Mobile -->
    <div class="lg:hidden w-full mt-6 font-title flex flex-col gap-4">
        @forelse ($schedules as $row)
        <details class="group bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
            <summary class="flex items-center justify-between p-5 cursor-pointer list-none select-none">
                <div class="flex flex-col gap-1">
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg">{{ $row['kegiatan'] }}</h3>
                    <p class="text-sm text-gray-400 dark:text-gray-500 font-medium">Tanggal : {{ \Carbon\Carbon::parse($row['tanggal'])->translatedFormat('d F Y') }}</p>
                </div>
                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            
            <div class="px-5 pb-5 pt-2 border-t border-gray-100 dark:border-white/5 flex flex-col gap-4 text-base font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#252525]">
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 dark:text-gray-400 font-medium">Total</span>
                    <span class="col-span-1 text-center text-gray-400 dark:text-gray-600">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900 dark:text-white">{{ $row['total_hadir'] }}</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 dark:text-gray-400 font-medium">Peran</span>
                    <span class="col-span-1 text-center text-gray-400 dark:text-gray-600">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900 dark:text-white capitalize">{{ $row['role'] === 'pengurus' ? 'Panitia' : 'Peserta' }}</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 dark:text-gray-400 font-medium">Status</span>
                    <span class="col-span-1 text-center text-gray-400 dark:text-gray-600">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900 dark:text-white">
                        @if ($row['status'] === 'Berlangsung')
                            <span class="text-blue-600 font-bold">Berlangsung</span>
                        @elseif ($row['status'] === 'Selesai')
                            <span class="text-[#2DA635] font-bold">Selesai</span>
                        @else
                            <span class="text-gray-400 font-bold">Segera</span>
                        @endif
                    </span>
                </div>
                <div class="mt-2">
                    @if ($row['status'] !== 'Segera')
                        <a href="{{ route('jadwal.show', $row['id']) }}" class="w-full flex items-center justify-center py-3 bg-[#666666] dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-bold rounded-xl text-base shadow-xs transition hover:bg-black">
                            Detail
                        </a>
                    @else
                        <button disabled class="w-full flex items-center justify-center py-3 border border-gray-200 dark:border-white/10 bg-white dark:bg-[#252525] text-gray-300 dark:text-gray-600 font-bold rounded-xl text-base cursor-not-allowed">
                            Detail
                        </button>
                    @endif
                </div>
            </div>
        </details>
        @empty
        <div class="bg-white dark:bg-[#252525] dark:border dark:border-white/5 rounded-2xl shadow-sm p-6 text-center font-body text-body-text dark:text-gray-400">
            Belum ada jadwal terdaftar.
        </div>
        @endforelse
    </div>
<!-- end Table Mobile -->

    @if ($schedules->hasPages())
        <div class="flex items-center justify-center gap-2 mt-6 mb-8 font-bold text-base sm:text-lg select-none font-title w-full">
            {{-- Previous Page Link --}}
            @if ($schedules->onFirstPage())
                <span class="w-9 h-9 flex items-center justify-center text-gray-300 cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </span>
            @else
                <a href="{{ $schedules->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center text-body-text dark:text-[#E0E0E0] hover:text-graphite dark:hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach (range(1, $schedules->lastPage()) as $page)
                @if ($page == $schedules->currentPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-200 text-gray-700">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $schedules->url($page) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-graphite/75 text-white hover:bg-graphite transition">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($schedules->hasMorePages())
                <a href="{{ $schedules->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center text-body-text dark:text-[#E0E0E0] hover:text-graphite dark:hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            @else
                <span class="w-9 h-9 flex items-center justify-center text-gray-300 cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
            @endif
        </div>
    @endif
@endsection
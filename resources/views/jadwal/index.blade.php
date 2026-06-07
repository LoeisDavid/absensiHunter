@extends('layouts.app')
@section('title', 'Jadwal')

@section('content')
<!-- Header -->
    <div class="flex flex-col gap-6">
        <div class="flex items-center justify-between font-title">

            <div class="flex items-center gap-3 sm:gap-6">
                <h1 class="text-xl sm:text-2xl font-bold text-body-text px-6">
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

                <dialog id="addSchedule" class="m-auto rounded-[30px] sm:rounded-[40px] border-none p-0 shadow-2xl backdrop:bg-black/50 open:animate-in open:fade-in open:zoom-in duration-300">
                    <div class="w-[90vw] md:w-112.5 lg:w-125 xl:w-137.5 max-w-full bg-white p-6 sm:p-12 flex flex-col relative">
                        
                        <div class="flex items-center gap-3 mb-8 sm:mb-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-7 h-7 sm:w-8 sm:h-8 shrink-0">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m-7-7h14" />
                            </svg>
                            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Tambah jadwal</h2>
                        </div>

                        <form action="#" method="POST" class="flex flex-col gap-6 sm:gap-8">
                            <div class="flex flex-col gap-2 sm:gap-3">
                                <label class="font-bold text-base sm:text-lg" for="activity">Activity</label>
                                <input type="text" id="activity" placeholder="Contoh: Kelas Coding" 
                                    class="w-full px-5 py-3.5 sm:px-6 sm:py-4 rounded-xl sm:rounded-2xl border-2 border-black focus:outline-none bg-whitesmoke text-sm sm:text-base font-medium">
                            </div>

                            <div class="flex flex-col gap-2 sm:gap-3">
                                <label class="font-bold text-base sm:text-lg" for="date">Date (DD/MM/YYYY)</label>
                                <input type="date" id="date" placeholder="--/--/----" 
                                    class="w-full px-5 py-3.5 sm:px-6 sm:py-4 rounded-xl sm:rounded-2xl border-2 border-black focus:outline-none bg-whitesmoke text-sm sm:text-base font-medium">
                            </div>

                            <div class="flex flex-col gap-2 sm:gap-3">
                                <label class="font-bold text-base sm:text-lg text-gray-900">Role</label>
                                <div class="relative">
                                    <select name="role" id="role" 
                                        class="w-full px-5 py-3.5 sm:px-6 sm:py-4 rounded-xl sm:rounded-2xl border-2 border-black bg-whitesmoke text-sm sm:text-base font-medium appearance-none cursor-pointer transition-all outline-none">
                                        <option value="" disabled selected>Pilih Role</option>
                                        <option value="peserta">Peserta</option>
                                        <option value="pengurus">Panitia</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-5 sm:pr-6 pointer-events-none">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    <div class="hidden lg:flex w-full mt-8 bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-sm font-title flex-col items-center">
        <table class="w-full border-collapse text-center mt-4">
            <thead>
                <tr class="text-gray-900">
                    <th class="font-bold text-xl px-6 py-6">Tanggal</th>
                    <th class="font-bold text-xl px-6 py-6">Kegiatan</th>
                    <th class="font-bold text-xl px-6 py-6">Total</th>
                    <th class="font-bold text-xl px-6 py-6">Peran</th>
                    <th class="font-bold text-xl px-6 py-6">Status</th>
                    <th class="font-bold text-xl px-6 py-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-body-text text-lg font-medium">
                <tr class="border-t border-gray-100">
                    <td class="px-6 py-5">06 Juni 2026</td>
                    <td class="px-6 py-5">Kelas coding Hunter</td>
                    <td class="px-6 py-5">10</td>
                    <td class="px-6 py-5">Panitia</td>
                    <td class="px-6 py-5">Berlangsung</td>
                    <td class="px-6 py-5">
                        <a href="{{ route('jadwal.show') }}" class="inline-block px-8 py-2 bg-graphite/75 text-white rounded-xl font-bold text-lg shadow-sm transition">
                            Detail
                        </a>
                    </td>
                </tr>
                <tr class="border-t border-gray-100">
                    <td class="px-6 py-5">08 Juni 2026</td>
                    <td class="px-6 py-5">Jam Kantor</td>
                    <td class="px-6 py-5">0</td>
                    <td class="px-6 py-5">Panitia</td>
                    <td class="px-6 py-5">Segera</td>
                    <td class="px-6 py-5">
                        <a href="#" disabled class="px-8 py-2 border-2 border-gray-200 text-gray-300 rounded-xl font-bold text-lg bg-white cursor-not-allowed">
                            Detail
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex items-center gap-2 mt-4 mb-8 font-bold text-lg select-none">
            <a href="#" class="w-9 h-9 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-200 text-gray-700 transition">1</a>
            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-graphite/75 text-white transition">2</a>
            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-graphite/75 text-white transition">3</a>
            <a href="#" class="w-9 h-9 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>
    </div>
<!-- end Table Dekstop -->

<!-- Table Mobile -->
    <div class="lg:hidden w-full mt-6 font-title flex flex-col gap-4">
        
        <details class="group bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden" open>
            <summary class="flex items-center justify-between p-5 cursor-pointer list-none select-none">
                <div class="flex flex-col gap-1">
                    <h3 class="font-bold text-gray-900 text-lg">Kelas coding Hunter</h3>
                    <p class="text-sm text-gray-400 font-medium">Tanggal : 6 Juni 2026</p>
                </div>
                <svg class="w-5 h-5 text-gray-700 transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            
            <div class="px-5 pb-5 pt-2 border-t border-gray-100 flex flex-col gap-4 text-base font-semibold text-gray-700 bg-white">
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 font-medium">Total</span>
                    <span class="col-span-1 text-center text-gray-400">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900">10</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 font-medium">Peran</span>
                    <span class="col-span-1 text-center text-gray-400">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900">Peserta</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 font-medium">Status</span>
                    <span class="col-span-1 text-center text-gray-400">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900">Berlangsung</span>
                </div>
                <div class="mt-2">
                    <a href="{{ route('jadwal.show') }}" class="w-full flex items-center justify-center py-3 bg-[#666666] text-white font-bold rounded-xl text-base shadow-xs transition hover:bg-black">
                        Detail
                    </a>
                </div>
            </div>
        </details>

        <details class="group bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
            <summary class="flex items-center justify-between p-5 cursor-pointer list-none select-none">
                <div class="flex flex-col gap-1">
                    <h3 class="font-bold text-gray-900 text-lg">Jam kantor</h3>
                    <p class="text-sm text-gray-400 font-medium">Tanggal : 7 Juni 2026</p>
                </div>
                <svg class="w-5 h-5 text-gray-700 transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            <div class="px-5 pb-5 pt-2 border-t border-gray-100 flex flex-col gap-4 text-base font-semibold text-gray-700 bg-white">
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 font-medium">Total</span>
                    <span class="col-span-1 text-center text-gray-400">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900">15</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 font-medium">Peran</span>
                    <span class="col-span-1 text-center text-gray-400">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900">Panitia</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 font-medium">Status</span>
                    <span class="col-span-1 text-center text-gray-400">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900">Berlangsung</span>
                </div>
                <div class="mt-2">
                    <a href="#" class="w-full flex items-center justify-center py-3 bg-[#666666] text-white font-bold rounded-xl text-base shadow-xs transition hover:bg-black">
                        Detail
                    </a>
                </div>
            </div>
        </details>

        <details class="group bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
            <summary class="flex items-center justify-between p-5 cursor-pointer list-none select-none">
                <div class="flex flex-col gap-1">
                    <h3 class="font-bold text-gray-900 text-lg">Jam kantor</h3>
                    <p class="text-sm text-gray-400 font-medium">Tanggal : 8 Juni 2026</p>
                </div>
                <svg class="w-5 h-5 text-gray-700 transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            <div class="px-5 pb-5 pt-2 border-t border-gray-100 flex flex-col gap-4 text-base font-semibold text-gray-700 bg-white">
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 font-medium">Total</span>
                    <span class="col-span-1 text-center text-gray-400">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900">0</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 font-medium">Peran</span>
                    <span class="col-span-1 text-center text-gray-400">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900">Panitia</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-3 text-gray-500 font-medium">Status</span>
                    <span class="col-span-1 text-center text-gray-400">:</span>
                    <span class="col-span-8 text-right font-bold text-gray-900">Segera</span>
                </div>
                <div class="mt-2">
                    <button disabled class="w-full flex items-center justify-center py-3 border border-gray-200 bg-white text-gray-300 font-bold rounded-xl text-base cursor-not-allowed">
                        Detail
                    </button>
                </div>
            </div>
        </details>

        <div class="flex items-center justify-center gap-2 mt-4 mb-8 font-bold text-base select-none">
            <a href="#" class="w-9 h-9 flex items-center justify-center text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-200 text-gray-700">1</a>
            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-400 text-white">2</a>
            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-400 text-white">3</a>
            <a href="#" class="w-9 h-9 flex items-center justify-center text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>
    </div>
<!-- end Table Mobile -->
@endsection
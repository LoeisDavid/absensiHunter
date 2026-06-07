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

        <div class="flex flex-col font-title text-body-text mt-4">
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-bold">
                Jam Kantor <span>( Peserta )</span>
            </h1>
            <span class="text-sm sm:text-lg mt-4">Senin, 6 Juni 2026</span>
        </div>
    </div>
<!-- end Header -->

<!-- Table Dekstop -->
    <div class="hidden lg:block w-full mt-10 bg-white rounded-3xl border border-gray-100 text-body-text overflow-hidden shadow-xs font-title">
        <table class="w-full border-collapse text-left my-4">
            <thead>
                <tr class="border-none">
                    <th class="font-bold text-xl px-6 py-6 pl-12">Nama</th>
                    <th class="font-bold text-xl px-6 py-6">NIS</th>
                    <th class="font-bold text-xl px-6 py-6">Waktu hadir</th>
                    <th class="font-bold text-xl px-6 py-6">Waktu keluar</th>
                </tr>
            </thead>
            <tbody class="text-lg font-semibold font-body text-body-text/50">
                <tr class="border-t border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 pl-12">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/150?img=12" class="w-12 h-12 rounded-full object-cover" alt="Avatar">
                            <div>
                                <p class="font-bold text-base">Muhammad Nailul Fadhil</p>
                                <p class="text-sm font-medium">Frontend Developer</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-base">101.01.2001</td>
                    <td class="px-6 py-4">
                        <div class="w-32 py-2 bg-mediumjungle/75 border-3 border-mediumjungle text-white font-bold rounded-xl shadow-md text-center text-lg tracking-wide">
                            09:00
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="w-32 py-2 bg-flagred/75 border-3 border-flagred text-white font-bold rounded-xl shadow-md text-center text-lg tracking-wide">
                            17:00
                        </div>
                    </td>
                </tr>
                <tr class="border-t border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 pl-12">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/150?img=13" class="w-12 h-12 rounded-full object-cover" alt="Avatar">
                            <div>
                                <p class="font-bold text-base">Muhammad Nabil Junior</p>
                                <p class="text-sm font-medium">Frontend Developer</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-base">101.01.2001</td>
                    <td class="px-6 py-4">
                        <div class="w-32 py-2 bg-mediumjungle/75 border-3 border-mediumjungle text-white font-bold rounded-xl shadow-md text-center text-lg tracking-wide">
                            09:00
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="w-32 py-2 bg-oceantwillight/75 border-3 border-oceantwillight text-white font-bold rounded-xl shadow-md text-center text-lg tracking-wide">
                            -- : --
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<!-- end Table Dekstop -->

<!-- Table Mobile -->
    <div class="lg:hidden w-full mt-8 font-title flex flex-col gap-4">
        
        <details class="group bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden text-body-text" open>
            <summary class="flex items-center justify-between p-5 cursor-pointer list-none select-none">
                <div class="flex items-center gap-4">
                    <img src="https://i.pravatar.cc/150?img=12" class="w-12 h-12 rounded-full object-cover" alt="Avatar">
                    <div class="flex flex-col">
                        <h3 class="font-bold text-base md:text-lg">Nama : Muhammad Nailul Fadhil</h3>
                        <p class="text-xs opacity-75 font-medium">Frontend Developer</p>
                    </div>
                </div>
                <svg class="w-5 h-5  transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            
            <div class="px-7 pb-7 pt-2 border-t border-gray-50 flex flex-col gap-4 text-base font-bold bg-white text-body-text/75">
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-4 ">NIS</span>
                    <span class="col-span-1 text-center">:</span>
                    <span class="col-span-7 text-right font-bold ">101.01.2001</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-4">Waktu Hadir</span>
                    <span class="col-span-1 text-center">:</span>
                    <div class="col-span-7 flex justify-end text-center">
                        <span class="w-24 py-3 bg-mediumjungle/75 text-white font-bold rounded-lg shadow-xs text-sm tracking-wide">09:00</span>
                    </div>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-4">Waktu Keluar</span>
                    <span class="col-span-1 text-center">:</span>
                    <div class="col-span-7 flex justify-end text-center">
                        <span class="w-24 py-3 bg-flagred/75 text-white font-bold rounded-lg shadow-xs text-sm tracking-wide">17:00</span>
                    </div>
                </div>
            </div>
        </details>

    </div>
<!-- end Table Mobile -->
    @endsection
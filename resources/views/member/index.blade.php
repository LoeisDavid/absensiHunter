@extends('layouts.app')
@section('title', 'Anggota')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex items-center gap-3 sm:gap-6 font-title">
            <h1 class="text-xl sm:text-2xl font-bold text-body-text px-6">
                Anggota
            </h1>
        </div>

        <div class="flex items-center font-title w-fit overflow-hidden rounded-lg sm:rounded-2xl shadow-sm border border-gray-200 sm:mt-2 bg-white">
            <a
                href="#"
                class="px-3 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition bg-flagred/25 text-white pointer-events-none cursor-not-allowed shadow-inner"
                disabled
            >
                Semua
            </a>
            <a
                href="{{ route('member.peserta') }}"
                class="px-3 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition border-r border-gray-200 hover:bg-gray-50 "
            >
                Peserta
            </a>
            <a
                href="{{ route('member.pengurus') }}"
                class="px-3 py-2 sm:px-10 sm:py-3 text-sm sm:text-xl font-bold transition hover:bg-gray-50 "
            >
                Panitia
            </a>
        </div>
    </div>
    <div class="hidden lg:block mt-10 bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-xs font-title">
        <table class="w-full border-collapse text-left">
            <thead>
                <tr class=" border-none bg-white">
                    <th class="font-bold text-xl px-8 py-6">Nama</th>
                    <th class="font-bold text-xl px-6 py-6 text-right">NIS</th>
                    <th class="font-bold text-xl px-6 py-6 text-center">Divisi</th>
                    <th class="font-bold text-xl px-6 py-6 text-center">Jabatan</th>
                    <th class="font-bold text-xl px-8 py-6 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="text-lg font-semibold font-body text-body-text/75 bg-white">
                
                <tr class="border-t border-gray-50 hover:bg-graphite/25 transition-colors cursor-pointer" onclick="window.location='{{ route('member.show') }}'">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/150?img=12" class="w-12 h-12 rounded-full object-cover" alt="Avatar">
                            <div>
                                <p class="font-bold text-base ">Muhammad Ibnu Dzaki</p>
                                <p class="text-sm font-medium ">Frontend Developer</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-right font-medium text-base ">101.12345</td>
                    <td class="px-6 py-5 text-center font-medium ">Core Team</td>
                    <td class="px-6 py-5 text-center font-medium ">LOL</td>
                    <td class="px-8 py-5 text-center  font-bold">Panitia</td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="lg:hidden w-full mt-6 font-title flex flex-col gap-4">
        
        <details class="group bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden text-body-text">
            <summary class="flex items-center justify-between p-5 cursor-pointer list-none select-none">
                <div class="flex items-center gap-4">
                    <img src="https://i.pravatar.cc/150?img=12" class="w-9 h-9 md:w-12 md:h-12 rounded-full object-cover" alt="Avatar">
                    <div class="flex flex-col">
                        <h3 class="font-bold text-sm sm:text-base">Nama : Muhammad Nailul Fadhil</h3>
                        <p class="text-xs opacity-75 font-semibold">Panitia</p>
                    </div>
                </div>
                <svg class="w-5 h-5  transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            
            <div class="px-5 pb-5 pt-2 border-t border-gray-50 flex flex-col gap-4 text-sm font-bold text-body-text/75 bg-white">
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-4  font-medium">NIS</span>
                    <span class="col-span-1 text-center">:</span>
                    <span class="col-span-7 text-right font-bold ">101.12345</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-4  font-medium">Divisi</span>
                    <span class="col-span-1 text-center">:</span>
                    <span class="col-span-7 text-right font-bold ">Core Team</span>
                </div>
                <div class="grid grid-cols-12 items-center">
                    <span class="col-span-4  font-medium">Jabatan</span>
                    <span class="col-span-1 text-center">:</span>
                    <span class="col-span-7 text-right font-bold ">LOL</span>
                </div>
                <div class="mt-2">
                    <a href="{{ route('member.show') }}" class="w-full flex items-center justify-center py-2.5 bg-[#4d4d4d] text-white font-bold rounded-xl text-sm shadow-xs transition hover:bg-black">
                        Lihat Profil
                    </a>
                </div>
            </div>
        </details>

    </div>
    @endsection
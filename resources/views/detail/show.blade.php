@extends('layouts.app')
@section('title', 'Detail Absensi')

@section('content')
    <div class="w-full mt-10 bg-white rounded-3xl border border-gray-200 p-6 sm:p-12 shadow-sm font-title flex flex-col items-center gap-12">
        <div class="flex flex-col gap-6 w-full">
            <div class="flex items-center gap-3 sm:gap-6 font-title self-start">
                <a href="{{ route('detail.index') }}" class="bg-graphite hover:bg-[#4d4d4d] transition flex items-center gap-2 text-white px-8 py-3 rounded-2xl shadow-sm font-bold text-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" viewBox="0 0 16 9">
                        <path d="M0 0h16v9H0z" fill="none" />
                        <path fill="currentColor" d="M12.5 5h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5" />
                        <path fill="currentColor" d="M6 8.5a.47.47 0 0 1-.35-.15l-3.5-3.5c-.2-.2-.2-.51 0-.71L5.65.65c.2-.2.51-.2.71 0s.2.51 0 .71L3.21 4.51l3.15 3.15c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15Z" />
                    </svg>
                    <span>Back</span>
                </a>
            </div>

            <div class="flex items-center justify-center font-title text-body-text mt-2">
                <h1 class="text-xl sm:text-3xl font-bold">
                    Laporan Kehadiran Bulan Mei
                </h1>
            </div>
        </div>
        <div class="w-full flex flex-col items-center gap-4">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Kamis, 6 Mei 2026</h2>
            
            <div class="w-full max-w-4xl overflow-hidden rounded-2xl border border-gray-200">
                <table class="w-full border-collapse text-center text-sm sm:text-base">
                    <thead>
                        <tr class="bg-whitesmoke font-bold">
                            <th class="px-4 py-4 font-semibold border-r border-gray-300/60 last:border-none">Nama</th>
                            <th class="px-4 py-4 font-semibold border-r border-gray-300/60 last:border-none">NIS</th>
                            <th class="px-4 py-4 font-semibold border-r border-gray-300/60 last:border-none">Status</th>
                            <th class="px-4 py-4 font-semibold border-r border-gray-300/60 last:border-none">Jam hadir</th>
                            <th class="px-4 py-4 font-semibold">Jam pulang</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-text font-medium bg-white">
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200">M.Nailul Fadhil</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">101.201.2007</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-mediumjungle font-bold">Hadir</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">09:23</td>
                            <td class="px-4 py-3.5">20:00</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200">M. Nabil Junior Y.</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-body-text">101.201.2008</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-mediumjungle font-bold">Hadir</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">09:45</td>
                            <td class="px-4 py-3.5">16:75</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200">Kezia Anggraini P.</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-body-text">101.201.2027</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-flagred font-bold">Tidak Hadir</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-gray-400">-</td>
                            <td class="px-4 py-3.5 text-gray-400">-</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200">Loeis David Julio</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-body-text">101.201.2027</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-mediumjungle font-bold">Hadir</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">09:23</td>
                            <td class="px-4 py-3.5">23:50</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200">Prana Sadina R.</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-body-text">101.201.2107</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-flagred font-bold">Tidak Hadir</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-gray-400">-</td>
                            <td class="px-4 py-3.5 text-gray-400">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-full flex flex-col items-center gap-4">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Jumat, 7 Mei 2026</h2>
            
            <div class="w-full max-w-4xl overflow-hidden rounded-2xl border border-gray-200">
                <table class="w-full border-collapse text-center text-sm sm:text-base">
                    <thead>
                        <tr class="bg-whitesmoke text-body-text font-bold">
                            <th class="px-4 py-4 font-semibold border-r border-gray-300/60 last:border-none">Nama</th>
                            <th class="px-4 py-4 font-semibold border-r border-gray-300/60 last:border-none">NIS</th>
                            <th class="px-4 py-4 font-semibold border-r border-gray-300/60 last:border-none">Status</th>
                            <th class="px-4 py-4 font-semibold border-r border-gray-300/60 last:border-none">Jam hadir</th>
                            <th class="px-4 py-4 font-semibold">Jam pulang</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-text font-medium bg-white">
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200">M.Nailul Fadhil</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-body-text">101.201.2007</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-mediumjungle font-bold">Hadir</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">09:23</td>
                            <td class="px-4 py-3.5">20:00</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200">M. Nabil Junior Y.</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-body-text">101.201.2008</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-mediumjungle font-bold">Hadir</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">09:45</td>
                            <td class="px-4 py-3.5">16:75</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200">Kezia Anggraini P.</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-body-text">101.201.2027</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-flagred font-bold">Tidak Hadir</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-gray-400">-</td>
                            <td class="px-4 py-3.5 text-gray-400">-</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200">Loeis David Julio</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-body-text">101.201.2207</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-mediumjungle font-bold">Hadir</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">09:23</td>
                            <td class="px-4 py-3.5">23:50</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200">Prana Sadina R.</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-body-text">101.201.2107</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-flagred font-bold">Tidak Hadir</td>
                            <td class="px-4 py-3.5 border-r border-gray-200 text-gray-400">-</td>
                            <td class="px-4 py-3.5 text-gray-400">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-full flex flex-col items-center gap-4 mt-4">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Tabel total kehadiran</h2>
            
            <div class="w-full max-w-4xl overflow-hidden rounded-2xl border border-gray-200">
                <table class="w-full border-collapse text-center text-sm sm:text-base">
                    <thead>
                        <tr class="bg-whitesmoke text-body-text font-bold">
                            <th class="px-4 py-4 font-semibold border-r border-gray-300/60 last:border-none w-1/3">Nama</th>
                            <th class="px-4 py-4 font-semibold border-r border-gray-300/60 last:border-none w-1/3">Hadir</th>
                            <th class="px-4 py-4 font-semibold w-1/3">Tidak hadir</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-text font-bold bg-white">
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200 text-left pl-8 text-body-text font-medium">Muhammad Nailul Fadhil</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">10</td>
                            <td class="px-4 py-3.5">10</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200 text-left pl-8 text-body-text font-medium">Muhammad Nabil Junior</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">10</td>
                            <td class="px-4 py-3.5">10</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200 text-left pl-8 text-body-text font-medium">Kezia Anggraini Paskah Raharjo</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">10</td>
                            <td class="px-4 py-3.5">10</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200 text-left pl-8 text-body-text font-medium">Loeis David Julio Bino</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">10</td>
                            <td class="px-4 py-3.5">10</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-3.5 border-r border-gray-200 text-left pl-8 text-body-text font-medium">Prana Sadina Rafif</td>
                            <td class="px-4 py-3.5 border-r border-gray-200">10</td>
                            <td class="px-4 py-3.5">10</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
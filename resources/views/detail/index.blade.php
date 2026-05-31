@extends('layouts.app-detail')
@section('title', 'Detail Absensi')

@section('content')
    <div class="grid grid-cols-12 gap-4 sm:gap-8">
        <!-- Sidebar PDF -->
        <div class="col-span-2">
            <div class="sticky space-y-4">

            <a href="#"
                class="flex items-center gap-2 bg-[#D91E2E] text-white px-4 py-3 rounded-lg shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 shrink-0" viewBox="0 0 24 24">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path fill="currentColor" d="M12 19c7.63 0 9.93-6.62 9.95-6.68c.07-.21.07-.43 0-.63c-.02-.07-2.32-6.68-9.95-6.68s-9.93 6.61-9.95 6.67c-.07.21-.07.43 0 .63c.02.07 2.32 6.68 9.95 6.68Zm0-10c1.64 0 3 1.36 3 3s-1.36 3-3 3s-3-1.36-3-3s1.36-3 3-3" />
                </svg>
                <span>View PDF</span>
            </a>

            <a href="#"
                class="flex items-center gap-2 bg-[#D91E2E] text-white px-4 py-3 rounded-lg shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 shrink-0" viewBox="0 0 24 24">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <g fill="none" fill-rule="evenodd">
                        <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                        <path fill="currentColor" d="M12 2v6.5a1.5 1.5 0 0 0 1.5 1.5H20v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm-.989 9.848a6.22 6.22 0 0 1-2.235 3.872c-.887.716-.076 2.121.988 1.712a6.22 6.22 0 0 1 4.471 0c1.064.41 1.875-.995.988-1.712a6.22 6.22 0 0 1-2.235-3.872c-.177-1.126-1.8-1.127-1.977 0M12 14.303l.806 1.394h-1.61zm2-12.26a2 2 0 0 1 1 .543L19.414 7a2 2 0 0 1 .543 1H14z" />
                    </g>
                </svg>
                <span>Download PDF</span>
            </a>
        </div>
        <!-- end Sidebar PDF -->
    </div>

    <!-- Content -->
    <div class="col-span-10">

        <!-- Card Abu -->
        <div class="bg-[#F5F5F5] rounded-2xl shadow-md p-8 space-y-10">

            <!-- Card Tanggal 1 -->
            <div class="bg-white rounded-xl shadow-sm p-10">

                <div class="text-center mb-10">
                    <h2 class="text-2xl font-title font-bold text-body-text">
                        Kamis, 6 Mei 2026
                    </h2>
                </div>

                <div class="overflow-x-auto">
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

                            <tr class="bg-white">
                                <td class="px-6 py-5">
                                    Nailul Fadhil
                                </td>

                                <td class="px-6 py-5 text-center">
                                    101.201.2007
                                </td>

                                <td class="px-6 py-5 text-center">
                                    <span class="font-semibold text-[#2DA635]">
                                        Hadir
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-center">
                                    09:23
                                </td>

                                <td class="px-6 py-5 text-center">
                                    20:00
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Card Total Kehadiran -->
            <div class="bg-white rounded-xl shadow-sm p-10">

                <div class="text-center mb-10">
                    <h2 class="text-2xl font-title font-bold text-body-text">
                        Tabel Total Kehadiran
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full font-title">
                        <thead>
                            <tr class="bg-[#D9D9D9] text-white">
                                <th class="px-6 py-5 text-left">Nama</th>
                                <th class="px-6 py-5 text-center">Hadir</th>
                                <th class="px-6 py-5 text-center">Tidak Hadir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="bg-white">
                                <td class="px-6 py-5">
                                    Nailul Fadhil
                                </td>

                                <td class="px-6 py-5 text-center">
                                    10
                                </td>

                                <td class="px-6 py-5 text-center">
                                    10
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <!-- End Card Abu -->

    </div>
@endsection
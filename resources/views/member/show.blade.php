@extends('layouts.app')
@section('title', 'Detail Anggota')

@section('content')

<div class="flex flex-col gap-6">
<!-- Header -->
    <div class="flex items-center gap-4 lg:gap-6 font-title">
        <a
            href="{{ route('member.index') }}"
            class="bg-graphite hover:bg-[#4d4d4d] transition text-white px-4 py-2 md:px-8 md:py-3 rounded-lg md:rounded-2xl shadow-sm font-bold text-lg flex items-center gap-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 9" class="w-6 h-6 shrink-0">
                <path d="M0 0h16v9H0z" fill="none"/>
                <path fill="currentColor" d="M12.5 5h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5"/>
                <path fill="currentColor" d="M6 8.5a.47.47 0 0 1-.35-.15l-3.5-3.5c-.2-.2-.2-.51 0-.71L5.65.65c.2-.2.51-.2.71 0s.2.51 0 .71L3.21 4.51l3.15 3.15c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15Z"/>
            </svg>
            <span class="md:block hidden">Back</span>
        </a>

        <h1 class="lg:text-2xl text-xl font-bold text-body-text">
            Profil anggota
        </h1>
    </div>
<!-- end Header -->

<!-- personality dekstop-->
    <div class="hidden lg:flex justify-between items-start lg:gap-6 xl:gap-16 mt-8">
        <div class="flex items-start lg:gap-6 xl:gap-12">
            <img
                src="https://i.pravatar.cc/200?img=12"
                alt="Avatar"
                class="xl:w-44 xl:h-44 lg:w-32 lg:h-32 rounded-full object-cover shrink-0"
            >

            <div class="flex flex-col lg:gap-4 xl:gap-6 font-title text-body-text w-full">
                <div class="grid grid-cols-12 items-center lg:text-base xl:text-xl">
                    <span class="col-span-3 xl:col-span-2 font-bold">Nama</span>
                    <span class="col-span-1 font-bold text-center">:</span>
                    <span class="col-span-8 xl:col-span-9 font-medium  wrap-break-words">
                        Muhammad Nailul Fadhil
                    </span>
                </div>
                <div class="grid grid-cols-12 items-center lg:text-base xl:text-xl">
                    <span class="col-span-3 xl:col-span-2 font-bold">NIS</span>
                    <span class="col-span-1 font-bold text-center">:</span>
                    <span class="col-span-8 xl:col-span-9 font-medium ">
                        001.101.2002
                    </span>
                </div>
                <div class="grid grid-cols-12 items-center lg:text-base xl:text-xl">
                    <span class="col-span-3 xl:col-span-2 font-bold">Divisi</span>
                    <span class="col-span-1 font-bold text-center">:</span>
                    <span class="col-span-8 xl:col-span-9 font-medium ">
                        Frontend Developer
                    </span>
                </div>
                <div class="grid grid-cols-12 items-start lg:text-base xl:text-xl">
                    <span class="col-span-3 xl:col-span-2 font-bold shrink-0">Jabatan</span>
                    <span class="col-span-1 font-bold text-center">:</span>
                    <span class="col-span-8 xl:col-span-9 font-medium  leading-relaxed">
                        Publikasi, dekorasi, dan documentation
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-4 lg:gap-3 xl:gap-5 shrink-0 font-title">
            <div class="bg-graphite text-white rounded-2xl xl:w-32 xl:h-48 lg:w-24 lg:h-36 flex flex-col justify-center items-center p-2">
                <h3 class="xl:text-5xl lg:text-3xl font-bold">5</h3>
                <p class="text-center opacity-75 font-semibold lg:text-xs xl:text-lg mt-2 lg:mt-3 leading-tight">Jumlah<br>hadir</p>
            </div>
            <div class="bg-graphite text-white rounded-2xl xl:w-32 xl:h-48 lg:w-24 lg:h-36 flex flex-col justify-center items-center p-2">
                <h3 class="xl:text-5xl lg:text-3xl font-bold">6</h3>
                <p class="text-center opacity-75 font-semibold lg:text-xs xl:text-lg mt-2 lg:mt-3 leading-tight">Jadwal<br>hadir</p>
            </div>
            <div class="bg-graphite text-white rounded-2xl xl:w-32 xl:h-48 lg:w-24 lg:h-36 flex flex-col justify-center items-center p-2">
                <h3 class="xl:text-5xl lg:text-3xl font-bold">1</h3>
                <p class="text-center opacity-75 font-semibold lg:text-xs xl:text-lg mt-2 lg:mt-3 leading-tight">Tidak<br>hadir</p>
            </div>
            <div class="bg-graphite text-white rounded-2xl xl:w-32 xl:h-48 lg:w-24 lg:h-36 flex flex-col justify-center items-center p-2">
                <h3 class="xl:text-5xl lg:text-3xl font-bold">1</h3>
                <p class="text-center opacity-75 font-semibold lg:text-xs xl:text-lg mt-2 lg:mt-3 leading-tight">Extra<br>hadir</p>
            </div>
        </div>
    </div>
<!-- end personality dekstop -->

<!-- personality mobile -->
    <div class="lg:hidden w-full mt-4 font-title flex flex-col items-center gap-6">
        <img
            src="https://i.pravatar.cc/200?img=12"
            alt="Avatar"
            class="w-40 h-40 rounded-full object-cover shadow-sm border border-gray-100"
        >

        <div class="w-full flex flex-col gap-3 text-sm font-semibold px-4">
            <div class="grid grid-cols-12">
                <span class="col-span-3  font-bold">Nama</span>
                <span class="col-span-1 text-center">:</span>
                <span class="col-span-8 font-medium ">Muhammad Nailul Fadhil</span>
            </div>
            <div class="grid grid-cols-12">
                <span class="col-span-3  font-bold">NIS</span>
                <span class="col-span-1 text-center">:</span>
                <span class="col-span-8 font-medium ">001.101.2002</span>
            </div>
            <div class="grid grid-cols-12">
                <span class="col-span-3  font-bold">Divisi</span>
                <span class="col-span-1 text-center">:</span>
                <span class="col-span-8 font-medium ">Frontend Developer</span>
            </div>
            <div class="grid grid-cols-12">
                <span class="col-span-3  font-bold">Jabatan</span>
                <span class="col-span-1 text-center">:</span>
                <span class="col-span-8 font-medium ">Publikasi, dekorasi, dan dokumentasi</span>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-2 w-full px-2">
            <div class="bg-graphite text-white rounded-xl py-4 flex flex-col justify-center items-center shadow-xs">
                <h4 class="text-3xl font-bold">5</h4>
                <p class="text-[10px] text-center opacity-70 font-bold mt-2 leading-tight">Jumlah<br>hadir</p>
            </div>
            <div class="bg-graphite text-white rounded-xl py-4 flex flex-col justify-center items-center shadow-xs">
                <h4 class="text-3xl font-bold">6</h4>
                <p class="text-[10px] text-center opacity-70 font-bold mt-2 leading-tight">Jadwal<br>hadir</p>
            </div>
            <div class="bg-graphite text-white rounded-xl py-4 flex flex-col justify-center items-center shadow-xs">
                <h4 class="text-3xl font-bold">1</h4>
                <p class="text-[10px] text-center opacity-70 font-bold mt-2 leading-tight">Tidak<br>hadir</p>
            </div>
            <div class="bg-graphite text-white rounded-xl py-4 flex flex-col justify-center items-center shadow-xs">
                <h4 class="text-3xl font-bold">1</h4>
                <p class="text-[10px] text-center opacity-70 font-bold mt-2 leading-tight">Extra<br>hadir</p>
            </div>
        </div>
    </div>
<!-- end personality mobile -->

<!-- table -->
    <div class="lg:mt-8 mt-4">
        <h2 class="font-title text-xl lg:text-3xl font-bold text-body-text mb-6">
            Rincian Kehadiran
        </h2>

    <!-- dekstop -->
        <div class="hidden lg:block bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
            <table class="w-full">
                <thead>
                    <tr class="font-title text-2xl text-body-text">
                        <th class="pb-8 text-center">Tanggal</th>
                        <th class="pb-8 text-center">Waktu hadir</th>
                        <th class="pb-8 text-center">Waktu keluar</th>
                    </tr>
                </thead>
                <tbody class="font-body text-lg ">
                    <tr class="border-b border-gray-200">
                        <td class="py-5 text-center">Saturday, 30 May 2026</td>
                        <td class="py-5 text-center">
                            <span class="inline-block bg-mediumjungle/75 border-3 border-mediumjungle text-white font-bold px-10 py-2 rounded-xl shadow-sm">09:00</span>
                        </td>
                        <td class="py-5 text-center">
                            <span class="inline-block bg-flagred/75 border-3 border-flagred text-white font-bold px-10 py-2 rounded-xl shadow-sm">17:00</span>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="py-5 text-center">Sunday, 31 May 2026</td>
                        <td class="py-5 text-center">
                            <span class="inline-block bg-mediumjungle/75 border-3 border-mediumjungle text-white font-bold px-10 py-2 rounded-xl shadow-sm">09:00</span>
                        </td>
                        <td class="py-5 text-center">
                            <span class="inline-block bg-flagred/75 border-3 border-flagred text-white font-bold px-10 py-2 rounded-xl shadow-sm">17:50</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <!-- end dekstop -->

    <!-- mobile -->
        <div class="lg:hidden w-full flex flex-col gap-3">
            <details class="group bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
                <summary class="flex items-center justify-between p-4 cursor-pointer list-none select-none font-semibold text-sm md:text-base">
                    <span>Saturday, 30 May 2026</span>
                    <svg class="w-4 h-4  transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </summary>
                <div class="px-4 pb-4 pt-1 border-t border-gray-50 flex flex-col gap-3 text-xs md:text-sm font-bold  bg-white">
                    <div class="grid grid-cols-12 items-center">
                        <span class="col-span-4 font-medium">Waktu Hadir</span>
                        <span class="col-span-1 text-center ">:</span>
                        <div class="col-span-7 flex justify-end text-center">
                            <span class="w-20 md:w-32 py-2 bg-mediumjungle text-white font-bold rounded-md shadow-xs">09:00</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 items-center">
                        <span class="col-span-4  font-medium">Waktu Keluar</span>
                        <span class="col-span-1 text-center ">:</span>
                        <div class="col-span-7 flex justify-end text-center">
                            <span class="w-20 md:w-32 py-2 bg-flagred text-white font-bold rounded-md shadow-xs">17:00</span>
                        </div>
                    </div>
                </div>
            </details>
        </div>
    <!-- end mobile -->
    </div>
<!-- end table -->

    <!-- <div class="hidden md:flex items-center gap-20 mt-4 font-title">
        <div class="flex items-center gap-4">
            <span class="bg-mediumjungle/75 border-3 border-mediumjungle text-white font-bold px-10 py-2 rounded-xl shadow-sm">09:00</span>
            <span class="font-semibold">Waktu Hadir</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="bg-flagred/75 border-3 border-flagred text-white font-bold px-10 py-2 rounded-xl shadow-sm">17:00</span>
            <span class="font-semibold">Waktu Keluar</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="bg-oceantwillight/75 border-3 border-oceantwillight text-white font-bold px-10 py-2 rounded-xl shadow-sm">-- : --</span>
            <span class="font-semibold">Belum Absen</span>
        </div>
    </div> -->

</div>

@endsection
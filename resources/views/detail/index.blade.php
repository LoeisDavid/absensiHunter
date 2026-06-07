@extends('layouts.app')
@section('title', 'Detail Absensi')

@section('content')
    <!-- Header -->
    <div class="flex flex-col gap-6">
        <!-- Back + Title -->
        <div class="flex items-center justify-between font-title">

            <div class="flex items-center gap-3 sm:gap-6">
                <!-- Title -->
                <h1 class="text-xl sm:text-2xl font-bold text-body-text px-6">
                    Tabel Detail
                </h1>
            </div>

            <!-- Button -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Fillter -->
                <div class="relative inline-block font-title">
                    <select name="filter_tahun" 
                        class="appearance-none pr-12 pl-6 py-2 border-2 border-body-text rounded-xl bg-white text-body-text font-bold text-lg cursor-pointer outline-none transition-colors hover:bg-gray-50">
                        <option value="semua">Semua</option>
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>

                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
                <!-- end Fillter -->
                
                <button onclick="addDetail.showModal()"
                    class="bg-flagred cursor-pointer transition text-white px-4 py-1 sm:px-6 sm:py-2 rounded-xl shadow-sm font-bold text-base sm:text-lg flex items-center gap-2"
                >
                    <span class="hidden sm:block">Add</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 shrink-0">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                    </svg>
                </button>

                <dialog id="addDetail" class="m-auto rounded-2xl border-none p-0 shadow-2xl backdrop:bg-black/50 open:animate-in open:fade-in open:zoom-in duration-300">
                    <div class="w-135 max-w-full bg-white p-12 flex flex-col relative">
                        
                        <div class="flex items-center gap-3 mb-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 shrink-0">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                            </svg>
                            <h2 class="text-3xl font-bold tracking-tight">Tambah Detail</h2>
                        </div>

                        <form action="#" method="POST" class="flex flex-col gap-8">
                            <div class="flex flex-col gap-3">
                                <label class="font-bold text-lg" for="tahun">Tahun</label>
                                <input type="text" id="tahun" placeholder="Contoh: 2023" 
                                    class="w-full px-6 py-4 rounded-2xl border-2 border-black focus:outline-none bg-whitesmoke text-base font-medium">
                            </div>

                            <div class="flex flex-col gap-3">
                                <label class="font-bold text-lg" for="bulan">Bulan</label>
                                <input type="text" id="bulan" placeholder="Contoh: Januari" 
                                    class="w-full px-6 py-4 rounded-2xl border-2 border-black focus:outline-none bg-whitesmoke text-base font-medium">
                            </div>

                            <div class="mt-8 flex justify-end gap-3">
                                <button type="button" onclick="addDetail.close()"
                                    class="px-6 py-3 bg-body-text/75 text-white rounded-2xl font-bold text-xl cursor-pointer shadow-md">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-flagred text-white rounded-2xl font-bold text-xl cursor-pointer shadow-md">
                                    Add
                                </button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>
            <!-- end Button -->
        </div>
    </div>
    <!-- end Header -->

    <!-- Table -->
    <div class="w-full mt-8 bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-sm font-title flex flex-col items-center">
        <table class="w-full border-collapse text-center mt-4">
            <thead>
                <tr class="text-gray-900">
                    <th class="font-bold text-xl px-6 py-6">Tahun</th>
                    <th class="font-bold text-xl px-6 py-6">Bulan</th>
                    <th class="font-bold text-xl px-6 py-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-body-text text-lg font-medium">
                <tr class="border-t border-gray-100">
                    <td class="px-6 py-5">2026</td>
                    <td class="px-6 py-5">Mei</td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center gap-2">
                            <a href="#" title="Detail" 
                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-graphite/75 text-white transition-colors shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>

                            <a href="#" title="Lihat PDF" 
                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-flagred/75 text-white transition-colors shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </a>

                            <a href="#" title="Download PDF" 
                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-flagred/75 text-white transition-colors shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex items-center gap-2 mt-4 mb-8 font-bold text-lg select-none">
            <a href="#" class="w-9 h-9 flex items-center justify-center ">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>

            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-200 text-gray-700 transition">
                1
            </a>

            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-graphite/75 text-white  transition">
                2
            </a>

            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-graphite/75 text-white  transition">
                3
            </a>

            <a href="#" class="w-9 h-9 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('title', 'Jadwal')

@section('content')
    <!-- Header -->
    <div class="flex flex-col gap-6">
        <!-- Back + Title -->
        <div class="flex items-center justify-between font-title">

            <div class="flex items-center gap-3 sm:gap-6">
                <!-- Title -->
                <h1 class="text-xl sm:text-2xl font-bold text-body-text px-6">
                    Tabel Jadwal
                </h1>
            </div>

            <!-- Button -->
            <div class="flex items-center gap-2 sm:gap-3">
                <button onclick="addSchedule.showModal()"
                    class="bg-[#D91E2E] cursor-pointer transition text-white px-4 py-1 sm:px-8 sm:py-3 rounded-lg sm:rounded-2xl shadow-sm font-bold text-base sm:text-lg flex items-center gap-2"
                >
                    <span class="hidden sm:block">Add</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 shrink-0">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                    </svg>
                </button>

                <dialog id="addSchedule" class="m-auto rounded-2xl border-none p-0 shadow-2xl backdrop:bg-black/50 open:animate-in open:fade-in open:zoom-in duration-300">
                    <div class="w-135 max-w-full bg-white p-12 flex flex-col relative">
                        
                        <div class="flex items-center gap-3 mb-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 shrink-0">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                            </svg>
                            <h2 class="text-3xl font-bold tracking-tight">Tambah jadwal</h2>
                        </div>

                        <form action="#" method="POST" class="flex flex-col gap-8">
                            <div class="flex flex-col gap-3">
                                <label class="font-bold text-lg">Date (DD/MM/YYYY)</label>
                                <input type="date" placeholder="--/--/----" 
                                    class="w-full px-6 py-4 rounded-2xl border-2 border-black focus:outline-none bg-[#F5F5F5] text-base font-medium">
                            </div>

                            <div class="flex flex-col gap-3">
                                <label class="font-bold text-lg text-gray-900">Role</label>
                                
                                <div class="relative">
                                    <select name="role" id="role" 
                                        class="w-full px-6 py-4 rounded-2xl border-2 border-black bg-[#F5F5F5] text-base font-medium appearance-none cursor-pointer transition-all outline-none">
                                        <option value="" disabled selected>Pilih Role</option>
                                        <option value="peserta">Peserta</option>
                                        <option value="pengurus">Panitia</option>
                                    </select>

                                    <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none">
                                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-end gap-3">
                                <button type="button" onclick="addSchedule.close()"
                                    class="px-6 py-3 bg-body-text/75 text-white rounded-2xl font-bold text-xl cursor-pointer shadow-md">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-[#D91E2E] text-white rounded-2xl font-bold text-xl cursor-pointer shadow-md">
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
    <div class="w-full mt-8 bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-sm font-title">
        <div class="grid grid-cols-12 p-6 bg-white border-b border-gray-100 font-bold text-gray-800 text-lg">
            <div class="col-span-6 text-center">Tanggal</div>
            <div class="col-span-6 text-center">Total Peserta & Panitia yang hadir</div>
        </div>

        <details class="group border-b border-gray-100 last:border-none font-body">
            <summary class="grid grid-cols-12 p-6 cursor-pointer items-center list-none hover:bg-gray-50 transition-colors">
                <div class="col-span-6 text-center text-gray-700 font-medium">
                    Jumat, 29 Mei 2026
                </div>

                <div class="col-span-6 flex items-center pr-4">
                    <span class="flex-1 text-center text-gray-700 font-medium">10</span>
                    
                    <svg class="w-5 h-5 transition-transform group-open:rotate-180 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </summary>

            <div class="p-6 bg-[#F8F9FA] grid grid-cols-2 gap-3">
                
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xl">
                    <h4 class="font-bold text-xl mb-6 font-title">Peserta yang hadir</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 pb-4 border-b border-gray-50 last:border-none">
                            <img src="https://i.pravatar.cc/150?img=12" class="w-12 h-12 rounded-full" alt="">
                            <div class="opacity-75">
                                <p class="font-bold text-sm">Muhammad Nailul Fadhil</p>
                                <p class="text-xs">Frontend Developer</p>
                            </div>
                        </div>
                        </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xl">
                    <h4 class="font-bold text-xl mb-6 font-title">Panitia yang hadir</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 pb-4 border-b border-gray-50 last:border-none">
                            <img src="https://i.pravatar.cc/150?img=12" class="w-12 h-12 rounded-full" alt="">
                            <div class="opacity-75">
                                <p class="font-bold text-sm">Muhammad Nabil Junior</p>
                                <p class= "text-xs">Frontend Developer</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </details>
    </div>
@endsection
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

                        <form action="{{ route('jadwal.store') }}" method="POST" class="flex flex-col gap-8">
                            @csrf
                            <div class="flex flex-col gap-3">
                                <label class="font-bold text-lg" for="activity">Activity</label>
                                <input type="text" id="activity" placeholder="Contoh: Kelas Coding" 
                                    class="w-full px-6 py-4 rounded-2xl border-2 border-black focus:outline-none bg-whitesmoke text-base font-medium">
                            </div>

                            <div class="flex flex-col gap-3">
                                <label class="font-bold text-lg" for="date">Date (DD/MM/YYYY)</label>
                                <input type="date" id="date" placeholder="--/--/----" 
                                    class="w-full px-6 py-4 rounded-2xl border-2 border-black focus:outline-none bg-whitesmoke text-base font-medium">
                            </div>

                            <div class="flex flex-col gap-3">
                                <label class="font-bold text-lg text-gray-900">Role</label>
                                
                                <div class="relative">
                                    <select name="role" id="role" 
                                        class="w-full px-6 py-4 rounded-2xl border-2 border-black bg-whitesmoke text-base font-medium appearance-none cursor-pointer transition-all outline-none">
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
                @forelse ($schedules as $row)
                <tr class="border-t border-gray-100">
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
                            <button disabled class="px-8 py-2 border-2 border-gray-200 text-gray-300 rounded-xl font-bold text-lg bg-white cursor-not-allowed">
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

    <!-- Mobile Card -->
    <div class="lg:hidden mt-8 space-y-4 w-full">
        @forelse ($schedules as $row)
        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-150 space-y-3 font-title">
            <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                <span class="font-bold text-sm text-gray-900">{{ $row['kegiatan'] }}</span>
                <span class="text-xs font-bold px-2.5 py-0.5 rounded-md border
                    @if ($row['status'] === 'Berlangsung') bg-blue-50 text-blue-700 border-blue-200
                    @elseif ($row['status'] === 'Selesai') bg-green-50 text-green-700 border-green-200
                    @else bg-gray-50 text-gray-500 border-gray-200
                    @endif">
                    {{ $row['status'] }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                <div>
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Tanggal</p>
                    <p class="mt-0.5 text-gray-800 font-semibold text-[11px]">{{ \Carbon\Carbon::parse($row['tanggal'])->translatedFormat('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Peran / Total Hadir</p>
                    <p class="mt-0.5 text-gray-800 font-semibold text-[11px] capitalize">{{ $row['role'] === 'pengurus' ? 'Panitia' : 'Peserta' }} ({{ $row['total_hadir'] }})</p>
                </div>
            </div>

            @if ($row['status'] !== 'Segera')
            <div class="pt-2">
                <a href="{{ route('jadwal.show', $row['id']) }}" class="block w-full text-center py-2 bg-graphite/75 text-white rounded-xl font-bold text-sm shadow-sm transition hover:bg-graphite">
                    Detail
                </a>
            </div>
            @else
            <div class="pt-2">
                <button disabled class="w-full text-center py-2 border-2 border-gray-200 text-gray-300 rounded-xl font-bold text-sm bg-white cursor-not-allowed">
                    Detail
                </button>
            </div>
            @endif
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-sm p-6 text-center font-body text-body-text">
            Belum ada jadwal terdaftar.
        </div>
        @endforelse
    </div>
    <!-- end Mobile Card -->
@endsection
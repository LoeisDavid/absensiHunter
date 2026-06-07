@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-12 lg:grid-cols-12 gap-4 sm:gap-8">
        <div class="col-span-12 lg:col-span-4">
            <!-- Greeting -->
            <div class="h-full flex flex-col justify-center font-title text-body-text py-2 sm:py-5">

                @php
                    $hour = now()->hour;
                    if ($hour >= 5 && $hour < 12) {
                        $greeting = 'GOOD MORNING';
                    } elseif ($hour >= 12 && $hour < 17) {
                        $greeting = 'GOOD AFTERNOON';
                    } elseif ($hour >= 17 && $hour < 19) {
                        $greeting = 'GOOD EVENING';
                    } else {
                        $greeting = 'GOOD NIGHT';
                    }
                @endphp
                <h1 class="text-2xl sm:text-4xl leading-tight font-bold">
                    {{ $greeting }},
                    <br class="hidden sm:block">
                    ADMIN
                </h1>

                <p class="mt-2 sm:mt-6 text-sm sm:text-lg">
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>

            </div>
            <!-- end Greeting -->
        </div>
        <!-- Card Peserta-->
        <div class="col-span-6 md:col-span-6 lg:col-span-4">
            <div class="bg-white rounded-2xl p-4 sm:p-8 shadow-sm h-full">
                <div class="flex items-center justify-between h-full text-font1">
                    <!-- left -->
                    <div class="font-title">
                        <h1 class="text-3xl sm:text-5xl font-title font-bold px-1 sm:px-2">
                            {{ $counts['peserta'] ?? 0 }}
                        </h1>

                        <p class="text-sm sm:text-lg font-bold mt-2 opacity-75">
                            Peserta hadir
                        </p>

                        <span class="hidden sm:block sm:text-md opacity-75">
                            Dari {{ count($all_peserta) }} peserta
                        </span>
                    </div>
                    <!-- end left -->

                    <!-- right -->
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-10 shrink-0 sm:size-24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                        </svg>
                    </div>
                    <!-- end right -->
                </div>
            </div>
        </div>
        <!-- end Card Peserta -->
         <!-- Card Panitia-->
        <div class="col-span-6 md:col-span-6 lg:col-span-4">
            <div class="bg-[#2DA635]/50 rounded-2xl p-4 sm:p-8 shadow-sm h-full">
                <div class="flex items-center justify-between h-full  text-font2">
                    <!-- left -->
                    <div class="font-title">
                        <h1 class="text-3xl sm:text-5xl font-bold px-1 sm:px-2">
                            {{ $counts['pengurus'] ?? 0 }}
                        </h1>

                        <p class="text-sm sm:text-lg font-bold mt-2">
                            Panitia hadir
                        </p>

                        <span class="hidden sm:block text-xs sm:text-md">
                            Dari {{ count($all_pengurus) }} peserta
                        </span>
                    </div>
                    <!-- end left -->

                    <!-- right -->
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="size-10 shrink-0 sm:size-24">
                        <path d="M0 0h640v640H0z" fill="none" />
                        <path fill="currentColor" d="M320 312c-66.3 0-120-53.7-120-120S253.7 72 320 72s120 53.7 120 120s-53.7 120-120 120m-30.5 56h61c9.7 0 17.5 7.8 17.5 17.5c0 4.2-1.5 8.2-4.2 11.4l-27.4 32l31 115.1h.6l34.6-138.5c2.2-8.7 11.1-14 19.5-10.8C484 418.3 528 478.3 528 548.5c0 15.1-12.3 27.4-27.4 27.4l-361.2.1c-15.1 0-27.4-12.3-27.4-27.4c0-70.2 44-130.2 105.9-153.8c8.4-3.2 17.3 2.1 19.5 10.8L272 544.1h.6l31-115.1l-27.4-32c-2.7-3.2-4.2-7.2-4.2-11.4c0-9.7 7.8-17.5 17.5-17.5z" />
                    </svg>
                    <!-- end right -->

                </div>
            </div>
        </div>
        <!-- end Card Panitia -->
    </div>

    <!-- Bottom Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4 sm:gap-8 sm:mt-8 text-body-text">

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-sm p-3 sm:p-6 font-title">
            <div class="flex items-center justify-between px-2 sm:px-4">
                <h2 class="text-base sm:text-lg font-semibold">Peserta yang hadir</h2>
                <a class="text-[10px] sm:text-xs text-[#D91E2E] font-semibold" href="{{ route('absensi.peserta') }}">See more...</a>
            </div>

            <!-- List Peserta -->
                <div class="mt-4 sm:mt-8 space-y-4">
                    @forelse($recentPeserta as $peserta)
                    <div class="flex items-center gap-3 px-2 sm:gap-4 sm:px-4 pb-4 border-b border-gray-100 font-body">
                        <!-- Photo -->
                            @if(!empty($peserta['photo']) && file_exists(public_path($peserta['photo'])))
                                <img
                                    src="{{ asset($peserta['photo']) }}"
                                    alt="Profile"
                                    class="w-10 h-10 sm:w-16 sm:h-16 rounded-full object-cover shrink-0"
                                >
                            @else
                                <div class="w-10 h-10 sm:w-16 sm:h-16 rounded-full bg-slate-200 text-slate-800 font-bold text-lg sm:text-2xl flex items-center justify-center uppercase font-title shrink-0">
                                    {{ substr($peserta['nama'] ?? '?', 0, 1) }}
                                </div>
                            @endif
                        <!-- Info -->
                            <div class="flex flex-col opacity-75">

                                <h3 class="text-sm font-semibold">
                                    {{ $peserta['nama'] }}
                                </h3>

                                <p class="text-xs">
                                    Peserta
                                </p>

                            </div>
                    </div>
                    @empty
                    <div class="flex items-center gap-3 px-2 sm:gap-4 sm:px-4 pb-4 border-b border-gray-100 font-body">
                        <p class="text-xs sm:text-sm font-semibold">
                            Belum ada peserta yang hadir
                        </p>
                    </div>
                    @endforelse
                </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-sm p-3 sm:p-6 font-title">
            <div class="flex items-center justify-between px-2 sm:px-4">
                <h2 class="text-base sm:text-lg font-semibold">Panitia yang hadir</h2>
                <a class="text-[10px] sm:text-xs text-[#D91E2E] font-semibold" href="{{ route('absensi.pengurus') }}">See more...</a>
            </div>
            <!-- List Peserta -->
                <div class="mt-4 sm:mt-8 space-y-4">
                    @forelse($recentPengurus as $pengurus)
                    <div class="flex items-center gap-3 px-2 sm:gap-4 sm:px-4 pb-4 border-b border-gray-100 font-body">
                        <!-- Photo -->
                            @if(!empty($pengurus['photo']) && file_exists(public_path($pengurus['photo'])))
                                <img
                                    src="{{ asset($pengurus['photo']) }}"
                                    alt="Profile"
                                    class="w-10 h-10 sm:w-16 sm:h-16 rounded-full object-cover shrink-0"
                                >
                            @else
                                <div class="w-10 h-10 sm:w-16 sm:h-16 rounded-full bg-slate-200 text-slate-800 font-bold text-lg sm:text-2xl flex items-center justify-center uppercase font-title shrink-0">
                                    {{ substr($pengurus['nama'] ?? '?', 0, 1) }}
                                </div>
                            @endif
                        <!-- Info -->
                            <div class="flex flex-col opacity-75">

                                <h3 class="text-sm font-semibold">
                                    {{ $pengurus['nama'] }}
                                </h3>

                                <p class="text-xs">
                                    Panitia
                                </p>

                            </div>
                    </div>
                    @empty
                    <div class="flex items-center gap-3 px-2 sm:gap-4 sm:px-4 pb-4 border-b border-gray-100 font-body">
                        <p class="text-xs sm:text-sm font-semibold">
                            Belum ada panitia yang hadir
                        </p>
                    </div>
                    @endforelse
                </div>
        </div>

    </div>
@endsection
@extends('layouts.app')

@section('title', 'Dashboard — Absensi Hunter')

@section('content')

{{-- Page Header --}}
<div class="mb-6 sm:mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Dashboard</h1>
    <p class="text-slate-500 text-sm mt-1">Rekap absensi hari ini, {{ now()->translatedFormat('l, d F Y') }}</p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8">

    {{-- Peserta Card --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center gap-5 hover:shadow-md transition-shadow">
        <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <div class="min-w-0">
            <p class="text-sm text-slate-500 font-medium">Peserta Hadir</p>
            <p class="text-4xl font-bold text-blue-600 leading-tight">{{ $counts['peserta'] ?? 0 }}</p>
            <p class="text-xs text-slate-400 mt-0.5">orang hari ini</p>
        </div>
    </div>

    {{-- Pengurus Card --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center gap-5 hover:shadow-md transition-shadow">
        <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <div class="min-w-0">
            <p class="text-sm text-slate-500 font-medium">Pengurus Hadir</p>
            <p class="text-4xl font-bold text-indigo-600 leading-tight">{{ $counts['pengurus'] ?? 0 }}</p>
            <p class="text-xs text-slate-400 mt-0.5">orang hari ini</p>
        </div>
    </div>
</div>

{{-- Recent Absensi --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- Section Header --}}
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="text-base font-semibold text-slate-800">Kehadiran Terbaru</h2>
            <p class="text-xs text-slate-400 mt-0.5">5 orang terakhir yang absen</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
            <span class="text-xs text-slate-500">Live</span>
        </div>
    </div>

    {{-- List --}}
    <div class="divide-y divide-slate-50">
        @forelse($recentList as $item)
        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                            {{ $item['role'] === 'pengurus' ? 'bg-indigo-100' : 'bg-blue-100' }}">
                    <span class="text-sm font-bold {{ $item['role'] === 'pengurus' ? 'text-indigo-600' : 'text-blue-600' }}">
                        {{ strtoupper(substr($item['nama'], 0, 1)) }}
                    </span>
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-slate-800 text-sm truncate">{{ $item['nama'] }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium mt-0.5
                                 {{ $item['role'] === 'pengurus' ? 'bg-indigo-50 text-indigo-700' : 'bg-blue-50 text-blue-700' }}">
                        {{ ucfirst($item['role']) }}
                    </span>
                </div>
            </div>
            <div class="text-right flex-shrink-0 ml-3">
                <p class="text-sm font-semibold text-slate-700">{{ $item['waktu_datang'] }}</p>
                <p class="text-xs text-slate-400">Jam Masuk</p>
            </div>
        </div>
        @empty
        <div class="px-6 py-12 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <p class="text-slate-500 text-sm font-medium">Belum ada kehadiran hari ini</p>
            <p class="text-slate-400 text-xs mt-1">Data akan muncul setelah anggota scan QR</p>
        </div>
        @endforelse
    </div>

    {{-- Footer See More --}}
    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
        <a href="{{ route('absensi.peserta') }}"
           class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold
                  py-2.5 px-4 rounded-xl transition-all shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Lihat Semua Peserta
        </a>
        <a href="{{ route('absensi.pengurus') }}"
           class="flex-1 flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold
                  py-2.5 px-4 rounded-xl transition-all shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Lihat Semua Pengurus
        </a>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('title', 'Tabel Absensi Peserta — Hunter')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 sm:mb-8">
    <div>
        <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Peserta</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Absensi Peserta</h1>
        <p class="text-slate-500 text-sm mt-1">Rekap kehadiran seluruh peserta</p>
    </div>
    <div class="flex items-center gap-2">
        <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-sm font-medium">
            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
            {{ count($data) }} record
        </span>
    </div>
</div>

{{-- Table Card --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- Search/Filter Bar --}}
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row gap-3">
        <input type="text" id="searchInput" placeholder="Cari nama atau NIS..."
               class="flex-1 px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800
                      placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
            </svg>
            Filter aktif
        </div>
    </div>

    {{-- Scrollable Table --}}
    <div class="overflow-x-auto">
        <table class="w-full min-w-[700px]">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">No</th>
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3">Nama</th>
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3">NIS</th>
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3">Divisi</th>
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3">Jabatan</th>
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3">Tanggal</th>
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3">Jam Masuk</th>
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 py-3">Jam Pulang</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="divide-y divide-slate-50">
                @forelse($data as $i => $row)
                <tr class="hover:bg-blue-50/40 transition-colors">
                    <td class="px-6 py-4 text-sm text-slate-400 font-mono">{{ $i + 1 }}</td>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-blue-600">{{ strtoupper(substr($row['nama'], 0, 1)) }}</span>
                            </div>
                            <span class="text-sm font-semibold text-slate-800">{{ $row['nama'] }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-sm text-slate-600 font-mono">{{ $row['nis'] }}</td>
                    <td class="px-4 py-4 text-sm text-slate-600">{{ $row['divisi'] }}</td>
                    <td class="px-4 py-4 text-sm text-slate-600">{{ $row['jabatan'] }}</td>
                    <td class="px-4 py-4 text-sm text-slate-600">{{ $row['tanggal'] }}</td>
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium
                                     {{ $row['waktu_datang'] !== '-' ? 'text-green-700' : 'text-slate-400' }}">
                            @if($row['waktu_datang'] !== '-')
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            @endif
                            {{ $row['waktu_datang'] }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium
                                     {{ $row['waktu_pulang'] !== '-' ? 'text-blue-700' : 'text-slate-400' }}">
                            @if($row['waktu_pulang'] !== '-')
                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                            @endif
                            {{ $row['waktu_pulang'] }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-16">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-slate-500 font-medium">Belum ada data absensi peserta</p>
                            <a href="{{ route('scan') }}" class="text-blue-600 text-sm hover:underline">Mulai scan sekarang</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    @if(count($data) > 0)
    <div class="px-6 py-3 bg-slate-50 border-t border-slate-100">
        <p class="text-xs text-slate-400">Menampilkan {{ count($data) }} data peserta</p>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const rows        = document.querySelectorAll('#tableBody tr');

    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });
</script>
@endpush

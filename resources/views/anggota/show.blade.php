@extends('layouts.dark')

@section('title', 'Data Diri — Absensi Hunter')

@section('content')
<div class="min-h-screen bg-black flex flex-col">

    {{-- Header --}}
    <div class="p-4 sm:p-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg width="36" height="36" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="20,2 38,32 2,32" fill="white" opacity="0.1"/>
                <polygon points="20,5 10,30 20,25" fill="#ef4444"/>
                <polygon points="20,5 30,30 20,25" fill="#22c55e"/>
                <polygon points="10,30 30,30 20,25" fill="#3b82f6"/>
            </svg>
            <div>
                <p class="text-sm font-bold text-white leading-tight tracking-wider">HUNTER</p>
                <p class="text-[10px] text-white/50 leading-tight tracking-[0.3em]">COMMUNITY</p>
            </div>
        </div>
        <a href="{{ route('scan') }}"
           class="flex items-center gap-2 text-white/70 hover:text-white text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="hidden sm:inline">Scan Lagi</span>
        </a>
    </div>

    {{-- Content --}}
    <div class="flex-1 flex items-center justify-center px-4 py-6">
        <div class="w-full max-w-sm sm:max-w-md">

            {{-- Card --}}
            <div class="bg-white dark:bg-[#1e1e1e] dark:border dark:border-white/5 rounded-2xl shadow-2xl overflow-hidden">

                {{-- Success Header --}}
                <div class="px-6 pt-8 pb-5 text-center">
                    {{-- Checkmark Icon --}}
                    <div class="w-14 h-14 bg-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-200 dark:shadow-green-950/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-green-600 dark:text-green-400">
                        {{ $status === 'pulang' ? 'Absen Pulang Berhasil' : 'Absen Berhasil' }}
                    </h2>
                </div>

                <div class="px-6 pb-8">
                    {{-- Divider with label --}}
                    <div class="flex items-center gap-3 mb-5">
                        <div class="h-px flex-1 bg-slate-200 dark:bg-white/10"></div>
                        <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Data Diri Peserta</span>
                        <div class="h-px flex-1 bg-slate-200 dark:bg-white/10"></div>
                    </div>

                    {{-- Data Rows --}}
                    <div class="space-y-3">
                        @php
                            $fields = [
                                'Nama'      => $anggota['nama']    ?? '-',
                                'NIS'       => $anggota['nis']     ?? '-',
                                'Divisi'    => $anggota['divisi']  ?? '-',
                                'Jabatan'   => $anggota['jabatan'] ?? '-',
                                'Jam Masuk' => $absensi['waktu_datang'] ?? '-',
                            ];
                            if ($status === 'pulang') {
                                $fields['Jam Pulang'] = $absensi['waktu_pulang'] ?? '-';
                            }
                        @endphp

                        @foreach($fields as $label => $value)
                        <div class="flex items-center justify-between py-2.5 border-b border-slate-100 dark:border-white/5 last:border-0">
                            <span class="text-sm text-slate-600 dark:text-slate-400 font-medium w-28 flex-shrink-0">{{ $label }}</span>
                            <span class="text-sm text-slate-400 dark:text-slate-600 flex-shrink-0 mx-2">:</span>
                            <span class="text-sm text-slate-800 dark:text-white font-semibold text-right">{{ $value }}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('scan') }}"
                           class="flex-1 flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 text-white text-sm font-semibold py-3 rounded-xl transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            Scan Lagi
                        </a>
                        <a href="{{ route('dashboard') }}"
                           class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white text-sm font-semibold py-3 rounded-xl transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>

            {{-- Auto redirect hint --}}
            <p class="text-center text-white/40 text-xs mt-4">
                Halaman akan otomatis kembali ke scan dalam <span id="countdown">10</span> detik
            </p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let count = 10;
    const el  = document.getElementById('countdown');
    const timer = setInterval(() => {
        count--;
        el.textContent = count;
        if (count <= 0) {
            clearInterval(timer);
            window.location.href = '{{ route("scan") }}';
        }
    }, 1000);
</script>
@endpush

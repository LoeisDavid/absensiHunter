@extends('layouts.dark')

@section('title', 'Scan QR — Absensi Hunter')

@push('head')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
@endpush

@section('content')
<div class="relative min-h-screen bg-black flex flex-col">

    {{-- Header --}}
    <div class="absolute top-0 left-0 right-0 z-20 p-4 sm:p-6 flex items-center justify-between">

        {{-- Logo --}}
        <div class="flex items-center gap-3">
            <img src="{{ asset('img/logo/logo_tanpa_nama.png') }}" alt="Logo" class="w-16 h-16 object-contain">
            <div>
                <p class="text-xl text-center text-white leading-tight tracking-wider font-hunter">HUNTER</p>
                <p class="text-base text-white leading-tight font-community">COMMUNITY</p>
            </div>
        </div>

        {{-- Back to Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-2 text-white/70 hover:text-white text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="hidden sm:inline">Dashboard</span>
        </a>
    </div>

    {{-- Camera Area --}}
    <div class="flex-1 flex flex-col items-center justify-center px-4 relative">

        {{-- Viewfinder Brackets --}}
        <div class="relative w-72 h-72 sm:w-80 sm:h-80 md:w-96 md:h-96">

            {{-- Camera feed container --}}
            <div id="qr-reader" class="absolute inset-0 overflow-hidden rounded-lg opacity-0 transition-opacity duration-500"></div>

            {{-- Corner Brackets --}}
            <div class="absolute inset-0 pointer-events-none z-10">
                {{-- Top Left --}}
                <div class="absolute top-0 left-0 w-10 h-10 border-t-[3px] border-l-[3px] border-white rounded-tl-sm"></div>
                {{-- Top Right --}}
                <div class="absolute top-0 right-0 w-10 h-10 border-t-[3px] border-r-[3px] border-white rounded-tr-sm"></div>
                {{-- Bottom Left --}}
                <div class="absolute bottom-0 left-0 w-10 h-10 border-b-[3px] border-l-[3px] border-white rounded-bl-sm"></div>
                {{-- Bottom Right --}}
                <div class="absolute bottom-0 right-0 w-10 h-10 border-b-[3px] border-r-[3px] border-white rounded-br-sm"></div>
            </div>

            {{-- Scan Line Animation --}}
            <div id="scanLine" class="absolute left-3 right-3 h-0.5 bg-gradient-to-r from-transparent via-blue-400 to-transparent z-20 opacity-0"
                 style="animation: scanMove 2s ease-in-out infinite; top: 12px;"></div>
        </div>

        {{-- Instruction --}}
        <p id="scanInstruction" class="text-white text-sm sm:text-base font-medium mt-8 text-center">
            Arahkan kamera ke QR Code pada kartu peserta
        </p>

        {{-- Loading State --}}
        <div id="loadingState" class="hidden mt-4 flex items-center gap-2 text-white/70 text-sm">
            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            Memproses...
        </div>

        {{-- Error State --}}
        <div id="errorState" class="hidden mt-4 px-4 py-3 bg-red-500/20 border border-red-500/40 rounded-xl text-red-400 text-sm text-center max-w-sm">
            <span id="errorMsg"></span>
        </div>

        {{-- Start Camera Button (fallback) --}}
        <button id="startBtn"
                class="mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition-all">
            Aktifkan Kamera
        </button>
    </div>
</div>

<style>
@keyframes scanMove {
    0%   { top: 12px; opacity: 0; }
    10%  { opacity: 1; }
    90%  { opacity: 1; }
    100% { top: calc(100% - 12px); opacity: 0; }
}
#qr-reader video { width: 100% !important; height: 100% !important; object-fit: cover; }
#qr-reader { border: none !important; }
</style>

@endsection

@push('scripts')
<script>
    const csrfToken  = document.querySelector('meta[name="csrf-token"]').content;
    const scanLine   = document.getElementById('scanLine');
    const instruction= document.getElementById('scanInstruction');
    const loading    = document.getElementById('loadingState');
    const errorState = document.getElementById('errorState');
    const errorMsg   = document.getElementById('errorMsg');
    const startBtn   = document.getElementById('startBtn');
    const qrReader   = document.getElementById('qr-reader');
    let   scanner    = null;
    let   scanning   = false;

    async function onScanSuccess(decodedText) {
        if (scanning) return;
        scanning = true;

        // Pause scanner
        if (scanner) scanner.pause(true);

        instruction.textContent = 'QR Code terdeteksi, memproses...';
        loading.classList.remove('hidden');
        errorState.classList.add('hidden');

        try {
            const res  = await fetch('/scan/absen', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ nis: decodedText }),
            });
            
            // Cek apakah response berupa JSON
            const contentType = res.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                const text = await res.text();
                throw new Error("Server mengembalikan non-JSON (Status " + res.status + ")");
            }

            const data = await res.json();

            if (data.success) {
                window.location.href = data.redirect;
            } else {
                errorMsg.textContent = data.message || 'NIS tidak ditemukan.';
                errorState.classList.remove('hidden');
                instruction.textContent = 'Arahkan kamera ke QR Code pada kartu peserta';
                loading.classList.add('hidden');
                scanning = false;
                setTimeout(() => {
                    errorState.classList.add('hidden');
                    if (scanner) scanner.resume();
                }, 3000);
            }
        } catch (e) {
            errorMsg.textContent = 'Gagal terhubung: ' + e.message;
            errorState.classList.remove('hidden');
            loading.classList.add('hidden');
            instruction.textContent = 'Arahkan kamera ke QR Code pada kartu peserta';
            scanning = false;
            setTimeout(() => { errorState.classList.add('hidden'); if (scanner) scanner.resume(); }, 5000);
        }
    }

    function startScanner() {
        startBtn.classList.add('hidden');
        scanner = new Html5Qrcode('qr-reader');
        scanner.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 450, height: 450 }, aspectRatio: 1.0 },
            onScanSuccess,
            () => {}
        ).then(() => {
            qrReader.style.opacity = '1';
            scanLine.style.opacity = '1';
        }).catch(err => {
            errorMsg.textContent = 'Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.';
            errorState.classList.remove('hidden');
            startBtn.classList.remove('hidden');
        });
    }

    startBtn.addEventListener('click', startScanner);

    // Auto-start on page load
    window.addEventListener('load', () => {
        setTimeout(startScanner, 500);
    });
</script>
@endpush

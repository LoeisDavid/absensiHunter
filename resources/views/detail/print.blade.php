<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Detail Absensi - {{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            .no-print {
                display: none !important;
            }
        }
        /* Explicit border rules for robust print styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #D9D9D9 !important;
        }
    </style>
</head>
<body class="bg-white text-black p-6 sm:p-10 font-title">

    <!-- Print / Close Controls (No Print) -->
    <div class="no-print flex items-center justify-between mb-8 bg-gray-100 p-4 rounded-xl border border-gray-200">
        <div class="flex items-center gap-2">
            <span class="text-sm font-semibold text-gray-700">Dokumen siap dicetak.</span>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print();" class="bg-[#D91E2E] hover:bg-[#b51825] transition text-white px-4 py-2 rounded-lg font-bold text-sm">
                Cetak / Simpan PDF
            </button>
            <button onclick="window.close();" class="bg-gray-500 hover:bg-gray-600 transition text-white px-4 py-2 rounded-lg font-bold text-sm">
                Tutup Halaman
            </button>
        </div>
    </div>

    <!-- Header Dokumen (Printed) -->
    <div class="flex items-center justify-center gap-4 mb-8 border-b-2 border-black pb-4 text-center">
        <img src="{{ asset('img/logo/logo_tanpa_nama.png') }}" alt="Logo" class="w-20 h-20 object-contain">
        <div class="text-left">
            <h1 class="text-2xl font-bold tracking-wide">HUNTER COMMUNITY</h1>
            <p class="text-sm uppercase tracking-wider font-semibold text-gray-600">Laporan Detail Absensi Bulanan</p>
            <p class="text-xs text-gray-500">Periode: {{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }} | Peran: {{ $selectedRole === 'all' ? 'Semua' : ($selectedRole === 'pengurus' ? 'Panitia' : 'Peserta') }}</p>
        </div>
    </div>

    <!-- Content -->
    <div class="space-y-8">
        @forelse ($pertemuanList as $pertemuan)
        <div class="bg-white p-4 border border-gray-300 rounded-lg break-inside-avoid">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-900 border-b pb-1">
                    {{ \Carbon\Carbon::parse($pertemuan['tanggal'])->translatedFormat('l, d F Y') }}
                    <span class="text-sm text-gray-500 font-semibold ml-2">
                        - {{ $pertemuan['kegiatan'] }} ({{ $pertemuan['role'] === 'pengurus' ? 'Panitia' : 'Peserta' }})
                    </span>
                </h2>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-2 text-left font-bold">Nama</th>
                        <th class="px-4 py-2 text-center font-bold">NIS</th>
                        <th class="px-4 py-2 text-center font-bold">Status</th>
                        <th class="px-4 py-2 text-center font-bold">Jam Hadir</th>
                        <th class="px-4 py-2 text-center font-bold">Jam Pulang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($pertemuan['attendees'] as $row)
                    <tr>
                        <td class="px-4 py-2">{{ $row['nama'] }}</td>
                        <td class="px-4 py-2 text-center font-mono text-xs">{{ $row['nis'] }}</td>
                        <td class="px-4 py-2 text-center font-semibold">
                            @if ($row['status'] === 'Hadir')
                                <span class="text-green-600">Hadir</span>
                            @else
                                <span class="text-red-600">Tidak Hadir</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center text-xs">{{ $row['waktu_datang'] }}</td>
                        <td class="px-4 py-2 text-center text-xs">{{ $row['waktu_pulang'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">Tidak ada data anggota.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500 font-semibold">
            Tidak ada pertemuan/jadwal pada bulan ini.
        </div>
        @endforelse

        <!-- Total Kehadiran -->
        <div class="bg-white p-4 border border-gray-300 rounded-lg break-inside-avoid">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-900 border-b pb-1">
                    Tabel Total Kehadiran ({{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }})
                </h2>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-2 text-left font-bold">Nama</th>
                        <th class="px-4 py-2 text-center font-bold">Hadir</th>
                        <th class="px-4 py-2 text-center font-bold">Tidak Hadir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($summary as $row)
                    <tr>
                        <td class="px-4 py-2">{{ $row['nama'] }}</td>
                        <td class="px-4 py-2 text-center font-semibold text-green-600">{{ $row['hadir'] }}</td>
                        <td class="px-4 py-2 text-center font-semibold text-red-600">{{ $row['tidak_hadir'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-center text-gray-500">Tidak ada data summary.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Auto-print script -->
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>

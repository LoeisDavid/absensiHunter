<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi - {{ $selectedMonth }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 4px 0 0 0;
            font-size: 11px;
            color: #666;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-green {
            color: #2da635;
            font-weight: bold;
        }
        .text-red {
            color: #d91e2e;
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>HUNTER COMMUNITY</h1>
        <p>Laporan Detail Absensi Bulanan</p>
        <p>Periode: {{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }} | Peran: {{ $selectedRole === 'all' ? 'Semua' : ($selectedRole === 'pengurus' ? 'Panitia' : 'Peserta') }}</p>
    </div>

    @forelse ($pertemuanList as $pertemuan)
    <div>
        <div class="section-title">
            {{ \Carbon\Carbon::parse($pertemuan['tanggal'])->translatedFormat('l, d F Y') }}
            <span style="font-weight: normal; font-size: 10px; color: #666;">
                - {{ $pertemuan['kegiatan'] }} ({{ $pertemuan['role'] === 'pengurus' ? 'Panitia' : 'Peserta' }})
            </span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th class="text-center" style="width: 15%;">NIS</th>
                    <th class="text-center" style="width: 15%;">Status</th>
                    <th class="text-center" style="width: 20%;">Jam Hadir</th>
                    <th class="text-center" style="width: 20%;">Jam Pulang</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pertemuan['attendees'] as $row)
                <tr>
                    <td>{{ $row['nama'] }}</td>
                    <td class="text-center">{{ $row['nis'] }}</td>
                    <td class="text-center">
                        @if ($row['status'] === 'Hadir')
                            <span class="text-green">Hadir</span>
                        @else
                            <span class="text-red">Tidak Hadir</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $row['waktu_datang'] }}</td>
                    <td class="text-center">{{ $row['waktu_pulang'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #999;">Tidak ada data anggota.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @empty
    <div class="text-center" style="padding: 15px 0; color: #666; font-weight: bold;">
        Tidak ada pertemuan/jadwal pada bulan ini.
    </div>
    @endforelse

    <!-- Page break before summary if there are meetings -->
    @if (count($pertemuanList) > 0)
    <div class="page-break"></div>
    @endif

    <div>
        <div class="section-title">
            Tabel Total Kehadiran ({{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }})
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th class="text-center" style="width: 25%;">Hadir</th>
                    <th class="text-center" style="width: 25%;">Tidak Hadir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($summary as $row)
                <tr>
                    <td>{{ $row['nama'] }}</td>
                    <td class="text-center" style="color: #2da635; font-weight: bold;">{{ $row['hadir'] }}</td>
                    <td class="text-center" style="color: #d91e2e; font-weight: bold;">{{ $row['tidak_hadir'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center" style="color: #999;">Tidak ada data summary.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>

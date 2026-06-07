<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\AnggotaModel;
use App\Models\JadwalModel;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    private function getDetailData($selectedMonth, $selectedRole)
    {
        $anggotaModel = new AnggotaModel();
        $absensiModel = new AbsensiModel();
        $jadwalModel = new JadwalModel();

        if ($selectedRole === 'peserta') {
            $members = $anggotaModel->getAllPeserta();
        } elseif ($selectedRole === 'pengurus') {
            $members = $anggotaModel->getAllPengurus();
        } else {
            $members = $anggotaModel->getAll();
        }

        $schedules = [];
        if ($selectedRole === 'all') {
            $schedules = array_merge(
                $jadwalModel->getByMonthAndRole($selectedMonth, 'peserta'),
                $jadwalModel->getByMonthAndRole($selectedMonth, 'pengurus')
            );
        } else {
            $schedules = $jadwalModel->getByMonthAndRole($selectedMonth, $selectedRole);
        }

        usort($schedules, function($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        $sheets = app(\App\Services\GoogleSheetsService::class);
        $absensiRows = $sheets->getAll('absensi', 'A:F');
        if (isset($absensiRows[0][0]) && strtolower(trim($absensiRows[0][0])) === 'id') {
            array_shift($absensiRows);
        }

        $absensiMap = [];
        foreach ($absensiRows as $row) {
            $rawDate = $row[3] ?? '';
            $ts = strtotime(str_replace('/', '-', $rawDate));
            if (!$ts) continue;

            $dateStr = date('Y-m-d', $ts);
            $ym = date('Y-m', $ts);
            if ($ym === $selectedMonth) {
                $anggotaId = (int)($row[1] ?? 0);
                if (!isset($absensiMap[$dateStr])) {
                    $absensiMap[$dateStr] = [];
                }
                $absensiMap[$dateStr][$anggotaId] = [
                    'waktu_datang' => $row[4] ?? '-',
                    'waktu_pulang' => (!empty($row[5]) && $row[5] !== '-') ? $row[5] : '-',
                ];
            }
        }

        $pertemuanList = [];
        foreach ($schedules as $j) {
            $dateStr = $j['tanggal'];
            
            $roleMembers = array_filter($members, function($m) use ($j) {
                return $m['role'] === $j['role'];
            });

            $attendees = [];
            foreach ($roleMembers as $m) {
                $absen = $absensiMap[$dateStr][$m['id']] ?? null;
                $attendees[] = [
                    'nama' => $m['nama'],
                    'nis' => $m['nis'],
                    'status' => $absen ? 'Hadir' : 'Tidak Hadir',
                    'waktu_datang' => $absen ? $absen['waktu_datang'] : '-',
                    'waktu_pulang' => $absen ? $absen['waktu_pulang'] : '-',
                ];
            }

            $pertemuanList[] = [
                'tanggal' => $dateStr,
                'kegiatan' => $j['kegiatan'],
                'role' => $j['role'],
                'attendees' => $attendees,
            ];
        }

        $summary = [];
        foreach ($members as $m) {
            $hadir = 0;
            $tidakHadir = 0;

            foreach ($schedules as $j) {
                if ($j['role'] === $m['role']) {
                    $dateStr = $j['tanggal'];
                    $hasAbsen = isset($absensiMap[$dateStr][$m['id']]);
                    if ($hasAbsen) {
                        $hadir++;
                    } else {
                        $tidakHadir++;
                    }
                }
            }

            $summary[] = [
                'nama' => $m['nama'],
                'hadir' => $hadir,
                'tidak_hadir' => $tidakHadir,
            ];
        }

        return [$pertemuanList, $summary];
    }

    public function index(Request $request)
    {
        $selectedMonth = $request->query('month', date('Y-m'));
        $selectedRole = $request->query('role', 'all');

        list($pertemuanList, $summary) = $this->getDetailData($selectedMonth, $selectedRole);

        return view('detail.index', compact('selectedMonth', 'selectedRole', 'pertemuanList', 'summary'));
    }

    public function print(Request $request)
    {
        $selectedMonth = $request->query('month', date('Y-m'));
        $selectedRole = $request->query('role', 'all');

        list($pertemuanList, $summary) = $this->getDetailData($selectedMonth, $selectedRole);

        return view('detail.print', compact('selectedMonth', 'selectedRole', 'pertemuanList', 'summary'));
    }

    public function download(Request $request)
    {
        $selectedMonth = $request->query('month', date('Y-m'));
        $selectedRole = $request->query('role', 'all');

        list($pertemuanList, $summary) = $this->getDetailData($selectedMonth, $selectedRole);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('detail.pdf', compact('selectedMonth', 'selectedRole', 'pertemuanList', 'summary'));
        
        $filename = 'Laporan_Absensi_' . $selectedMonth . '_' . $selectedRole . '.pdf';
        return $pdf->download($filename);
    }
}

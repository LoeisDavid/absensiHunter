<?php

namespace App\Http\Controllers;

use App\Models\AnggotaModel;
use App\Models\AbsensiModel;
use App\Models\JadwalModel;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $anggotaModel = new AnggotaModel();
        $members = $anggotaModel->getAll();
        return view('member.index', compact('members'));
    }

    public function peserta()
    {
        $anggotaModel = new AnggotaModel();
        $members = $anggotaModel->getAllPeserta();
        return view('member.peserta', compact('members'));
    }

    public function pengurus()
    {
        $anggotaModel = new AnggotaModel();
        $members = $anggotaModel->getAllPengurus();
        return view('member.pengurus', compact('members'));
    }

    public function show(Request $request)
    {
        $id = $request->query('id');
        if (!$id) {
            return redirect()->route('member.index');
        }

        $anggotaModel = new AnggotaModel();
        $anggota = $anggotaModel->findById((int)$id);

        if (!$anggota) {
            return redirect()->route('member.index')->with('error', 'Anggota tidak ditemukan.');
        }

        $absensiModel = new AbsensiModel();
        $allAbsensi = $absensiModel->getAllByRole($anggota['role']);
        
        $memberAbsensi = array_values(array_filter($allAbsensi, function ($absen) use ($anggota) {
            return $absen['anggota_id'] === $anggota['id'];
        }));

        $sheets = app(\App\Services\GoogleSheetsService::class);
        $rows = $sheets->getAll('jadwal', 'A:D');
        if (isset($rows[0][0]) && strtolower(trim($rows[0][0])) === 'id') {
            array_shift($rows);
        }
        
        $roleJadwal = [];
        foreach ($rows as $row) {
            $rowRole = strtolower(trim($row[3] ?? ''));
            if ($rowRole === $anggota['role']) {
                $rawDate = $row[1] ?? '';
                $ts = strtotime(str_replace('/', '-', $rawDate));
                if ($ts) {
                    $roleJadwal[] = [
                        'id' => (int)($row[0] ?? 0),
                        'tanggal' => date('Y-m-d', $ts),
                        'kegiatan' => $row[2] ?? '-',
                        'role' => $rowRole,
                    ];
                }
            }
        }

        $jumlahHadir = count($memberAbsensi);
        $jadwalHadir = count($roleJadwal);
        $absensiDates = array_column($memberAbsensi, 'tanggal');
        
        $tidakHadir = 0;
        $totalScheduledAttended = 0;
        foreach ($roleJadwal as $j) {
            if (in_array($j['tanggal'], $absensiDates)) {
                $totalScheduledAttended++;
            } else {
                $tidakHadir++;
            }
        }

        $extraHadir = max(0, $jumlahHadir - $totalScheduledAttended);

        $rincian = [];
        foreach ($memberAbsensi as $absen) {
            $kegiatan = '-';
            foreach ($roleJadwal as $j) {
                if ($j['tanggal'] === $absen['tanggal']) {
                    $kegiatan = $j['kegiatan'];
                    break;
                }
            }

            $rincian[] = [
                'tanggal' => $absen['tanggal'],
                'kegiatan' => $kegiatan,
                'waktu_datang' => $absen['waktu_datang'] ?: '-',
                'waktu_pulang' => $absen['waktu_pulang'] ?: '-',
            ];
        }

        usort($rincian, function ($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        return view('member.show', compact('anggota', 'jumlahHadir', 'jadwalHadir', 'tidakHadir', 'extraHadir', 'rincian'));
    }
}

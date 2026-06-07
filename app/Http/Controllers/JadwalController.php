<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\AnggotaModel;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $sheets = app(\App\Services\GoogleSheetsService::class);
        $rows = $sheets->getAll('jadwal', 'A:D');
        if (isset($rows[0][0]) && strtolower(trim($rows[0][0])) === 'id') {
            array_shift($rows);
        }

        $schedules = [];
        $absensiModel = new AbsensiModel();
        
        $allAbsensi = array_merge(
            $absensiModel->getAllByRole('peserta'),
            $absensiModel->getAllByRole('pengurus')
        );

        foreach ($rows as $row) {
            $rawDate = $row[1] ?? '';
            $ts = strtotime(str_replace('/', '-', $rawDate));
            if ($ts) {
                $tanggal = date('Y-m-d', $ts);
                $role = strtolower(trim($row[3] ?? ''));

                $totalHadir = count(array_filter($allAbsensi, function ($absen) use ($tanggal, $role) {
                    return $absen['tanggal'] === $tanggal && $absen['role'] === $role;
                }));

                $today = date('Y-m-d');
                if ($tanggal === $today) {
                    $status = 'Berlangsung';
                } elseif ($tanggal < $today) {
                    $status = 'Selesai';
                } else {
                    $status = 'Segera';
                }

                $schedules[] = [
                    'id' => (int)($row[0] ?? 0),
                    'tanggal' => $tanggal,
                    'kegiatan' => $row[2] ?? '-',
                    'role' => $role,
                    'total_hadir' => $totalHadir,
                    'status' => $status,
                ];
            }
        }

        usort($schedules, function ($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        return view('jadwal.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity' => 'required|string',
            'date' => 'required|date',
            'role' => 'required|string|in:peserta,pengurus',
        ]);

        try {
            $sheets = app(\App\Services\GoogleSheetsService::class);
            $id = $sheets->getNextId('jadwal');
            $rowNum = $id + 1;

            $formattedDate = date('d/m/Y', strtotime($request->date));

            $success = $sheets->updateRange("jadwal!A{$rowNum}:D{$rowNum}", [
                $id,
                $formattedDate,
                $request->activity,
                $request->role
            ]);

            if (!$success) {
                return back()->with('error', 'Gagal menambahkan jadwal.');
            }

            return back()->with('success', 'Jadwal berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $sheets = app(\App\Services\GoogleSheetsService::class);
        $rows = $sheets->getAll('jadwal', 'A:D');
        if (isset($rows[0][0]) && strtolower(trim($rows[0][0])) === 'id') {
            array_shift($rows);
        }

        $jadwal = null;
        foreach ($rows as $row) {
            if ((int)($row[0] ?? 0) === (int)$id) {
                $rawDate = $row[1] ?? '';
                $ts = strtotime(str_replace('/', '-', $rawDate));
                $jadwal = [
                    'id' => (int)$row[0],
                    'tanggal' => $ts ? date('Y-m-d', $ts) : $rawDate,
                    'kegiatan' => $row[2] ?? '-',
                    'role' => strtolower(trim($row[3] ?? 'peserta')),
                ];
                break;
            }
        }

        if (!$jadwal) {
            return redirect()->route('jadwal.index')->with('error', 'Jadwal tidak ditemukan.');
        }

        $anggotaModel = new AnggotaModel();
        if ($jadwal['role'] === 'pengurus') {
            $allMembers = $anggotaModel->getAllPengurus();
        } else {
            $allMembers = $anggotaModel->getAllPeserta();
        }

        $absensiModel = new AbsensiModel();
        $allAbsensi = $absensiModel->getAllByRole($jadwal['role']);
        
        $absensiMap = [];
        foreach ($allAbsensi as $absen) {
            if ($absen['tanggal'] === $jadwal['tanggal']) {
                $absensiMap[$absen['anggota_id']] = $absen;
            }
        }

        $attendees = [];
        foreach ($allMembers as $member) {
            $absen = $absensiMap[$member['id']] ?? null;
            $attendees[] = [
                'id' => $member['id'],
                'nama' => $member['nama'],
                'nis' => $member['nis'],
                'divisi' => $member['divisi'],
                'jabatan' => $member['jabatan'],
                'photo' => $member['photo'] ?? null,
                'waktu_datang' => $absen ? $absen['waktu_datang'] : '-- : --',
                'waktu_pulang' => ($absen && $absen['waktu_pulang'] !== '-') ? $absen['waktu_pulang'] : '-- : --',
            ];
        }

        return view('jadwal.show', compact('jadwal', 'attendees'));
    }
}

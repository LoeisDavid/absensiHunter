<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\AnggotaModel;

class AbsensiController extends Controller
{
    /**
     * Tabel absensi peserta.
     * 1 API call ambil absensi role=peserta
     * 1 batchGet API call JOIN dengan anggota
     * Total: 2 API calls.
     */
    public function peserta()
    {
        $data = $this->getTableData('peserta');
        return view('absensi.peserta', compact('data'));
    }

    /**
     * Tabel absensi pengurus.
     */
    public function pengurus()
    {
        $data = $this->getTableData('pengurus');
        return view('absensi.pengurus', compact('data'));
    }

    private function getTableData(string $role): array
    {
        try {
            $absensiModel = new AbsensiModel();
            $anggotaModel = new AnggotaModel();

            // 1. Ambil semua absensi by role
            $absensiList = $absensiModel->getAllByRole($role);

            // Filter agar hanya menyertakan data hari ini saja
            $today = now()->format('Y-m-d');
            $absensiList = array_values(array_filter($absensiList, function ($absen) use ($today) {
                return $absen['tanggal'] === $today;
            }));

            // 2. Kumpulkan unique anggota_id
            $ids = array_unique(array_filter(array_column($absensiList, 'anggota_id')));

            // 3. Batch fetch semua anggota sekaligus (1 API call)
            $anggotaMap = $anggotaModel->findByIds(array_values($ids));

            // 4. JOIN di PHP
            return array_map(function ($absen) use ($anggotaMap) {
                $anggota = $anggotaMap[$absen['anggota_id']] ?? [];
                return [
                    'id'            => $anggota['id']      ?? 0,
                    'nama'          => $anggota['nama']    ?? '-',
                    'nis'           => $anggota['nis']     ?? '-',
                    'divisi'        => $anggota['divisi']  ?? '-',
                    'jabatan'       => $anggota['jabatan'] ?? '-',
                    'tanggal'       => $absen['tanggal'],
                    'waktu_datang'  => $absen['waktu_datang'] ?: '-',
                    'waktu_pulang'  => $absen['waktu_pulang'] ?: '-',
                    'photo'         => $anggota['photo']   ?? null,
                ];
            }, $absensiList);

        } catch (\Exception $e) {
            return [];
        }
    }

    public function peserta2()
    {
        return view('absensi.peserta2');
    }

    public function pengurus2()
    {
        return view('absensi.pengurus2');
    }
}

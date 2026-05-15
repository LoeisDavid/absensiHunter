<?php

namespace App\Http\Controllers;

use App\Models\AnggotaModel;
use App\Models\AbsensiModel;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Tampilkan data diri setelah scan berhasil.
     * Menampilkan: nama, NIS, divisi, jabatan, jam masuk/pulang.
     */
    public function show(Request $request)
    {
        $nis    = $request->query('nis');
        $status = $request->query('status', 'datang');

        if (!$nis) {
            return redirect()->route('scan');
        }

        try {
            $anggotaModel = new AnggotaModel();
            $absensiModel = new AbsensiModel();

            $anggota = $anggotaModel->findByNis($nis);
            if (!$anggota) {
                return redirect()->route('scan')->with('error', 'Data tidak ditemukan.');
            }

            $today   = now()->format('Y-m-d');
            $record  = $absensiModel->findTodayRecord($anggota['id'], $today);
            $absensi = null;

            if ($record) {
                // Ambil data absensi hari ini langsung dari baris spesifik (O(1) ish)
                $absensiData = app(\App\Services\GoogleSheetsService::class)
                    ->getRow('absensi', $record['row'], 'F');
                $absensi = [
                    'waktu_datang' => $absensiData[4] ?? '-',
                    'waktu_pulang' => !empty($absensiData[5]) ? $absensiData[5] : '-',
                ];
            }

        } catch (\Exception $e) {
            return redirect()->route('scan')->with('error', 'Gagal mengambil data.');
        }

        return view('anggota.show', compact('anggota', 'absensi', 'status'));
    }
}

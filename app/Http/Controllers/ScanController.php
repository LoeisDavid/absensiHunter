<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\AnggotaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.index');
    }

    /**
     * POST /scan/absen
     * Alur scan QR:
     * 1. findByNis → 2 calls (cached setelah scan pertama)
     * 2. findTodayRow → 1 batchGet
     * 3. create/updatePulang → 1 append/update
     * Total: ~3 API calls (2 jika NIS sudah cached)
     */
    public function absen(Request $request)
    {
        $request->validate(['nis' => 'required|string']);
        $nis = trim($request->nis);

        try {
            $anggotaModel = new AnggotaModel();
            $absensiModel = new AbsensiModel();

            // 1. Cari anggota by NIS (cached 5 menit)
            $anggota = $anggotaModel->findByNis($nis);
            if (!$anggota) {
                return response()->json(['success' => false, 'message' => 'NIS tidak ditemukan dalam database.'], 404);
            }

            $today    = now()->format('Y-m-d');
            $waktuNow = now()->format('H:i');

            // 2. Cek sudah absen hari ini?
            $existingRecord = $absensiModel->findTodayRecord($anggota['id'], $today);

            if ($existingRecord) {
                // Jika waktu_pulang sudah diisi (bukan '-' atau kosong), tolak
                if (!empty($existingRecord['waktu_pulang']) && $existingRecord['waktu_pulang'] !== '-') {
                    return response()->json([
                        'success' => false, 
                        'message' => 'Belum ganti hari. Peserta sudah scan 2x (datang & pulang) hari ini.'
                    ], 400);
                }
                
                // Sudah datang tapi belum pulang → catat pulang (1 API call)
                $absensiModel->updatePulang($existingRecord['row'], $waktuNow);
                $status = 'pulang';
            } else {
                // Belum absen sama sekali → catat datang (1 API call)
                $absensiModel->create($anggota['id'], $anggota['role'], $today, $waktuNow);
                $status = 'datang';
            }

            // Invalidate cache dashboard supaya data terbaru muncul
            Cache::forget("dashboard_{$today}");

            return response()->json([
                'success'  => true,
                'status'   => $status,
                'redirect' => route('anggota.show', ['nis' => $nis, 'status' => $status]),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}

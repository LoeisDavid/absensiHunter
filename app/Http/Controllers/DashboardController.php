<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\AnggotaModel;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->format('Y-m-d');

        try {
            $absensiModel = new AbsensiModel();
            $anggotaModel = new AnggotaModel();

            /**
             * SEBELUM: 5 API calls sequential (countByRole×2 + getRecent×2 + batchGet)
             * SEKARANG: 2 API calls total:
             *   1. getForDashboard → 1 API call (seluruh absensi, proses di PHP)
             *   2. findByIds       → 1 batchGet (semua anggota sekaligus)
             *
             * + Cache 30 detik agar refresh cepat
             */
            $dashData = Cache::remember("dashboard_{$today}", 30, function () use ($absensiModel, $today) {
                return $absensiModel->getForDashboard($today, 5);
            });

            $counts = $dashData['counts'];
            $recent = $dashData['recent'];

            // Batch JOIN dengan anggota (cached per anggota)
            $anggotaIds = array_unique(array_filter(array_column($recent, 'anggota_id')));
            $anggotaMap = $anggotaModel->findByIds(array_values($anggotaIds));

            $recentList = array_map(function ($absen) use ($anggotaMap) {
                $anggota = $anggotaMap[$absen['anggota_id']] ?? null;
                return [
                    'nama'         => $anggota['nama'] ?? 'Unknown',
                    'role'         => $absen['role'],
                    'waktu_datang' => $absen['waktu_datang'],
                ];
            }, $recent);

            /**
            * Pisahkan berdasarkan role
            */
            $recentPeserta = array_filter($recentList, function ($item) {
                return strtolower($item['role']) === 'peserta';
            });

            $recentPengurus = array_filter($recentList, function ($item) {
                return strtolower($item['role']) === 'pengurus';
            });

        } catch (\Exception $e) {
            $counts     = ['peserta' => 0, 'pengurus' => 0];
            $recentList = [];
        }

        return view('dashboard.index', compact('counts', 'recentPeserta', 'recentPengurus'));
    }
}

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
             * ============================================================
             * DATA ANGGOTA TERDAFTAR
             * ============================================================
             *
             * Ini mengambil data dari sheet "anggota".
             * Data ini dipakai untuk:
             * - total peserta terdaftar
             * - total pengurus terdaftar
             *
             * Ini BUKAN data absensi.
             */
            $all_peserta = $anggotaModel->getAllPeserta();
            $all_pengurus = $anggotaModel->getAllPengurus();

            /**
             * Counts untuk dashboard.
             *
             * Penting:
             * counts ini berdasarkan anggota yang TERDAFTAR,
             * bukan berdasarkan yang absen.
             */
            $counts = [
                'peserta'  => count($all_peserta),
                'pengurus' => count($all_pengurus),
            ];

            /**
             * ============================================================
             * DATA ABSENSI HARI INI / RECENT
             * ============================================================
             *
             * Ini mengambil data dari sheet "absensi".
             * Data ini hanya dipakai untuk menampilkan daftar recent absensi.
             */
            $dashData = Cache::remember("dashboard_absensi_{$today}", 30, function () use ($absensiModel, $today) {
                /**
                 * Ambil lebih dari 5 supaya setelah dipisah role,
                 * peserta dan pengurus tetap punya kemungkinan dapat 5 data.
                 */
                return $absensiModel->getForDashboard($today, 20);
            });

            $recent = $dashData['recent'] ?? [];

            /**
             * Ambil anggota_id dari recent absensi.
             */
            $anggotaIds = array_unique(array_filter(array_column($recent, 'anggota_id')));

            /**
             * Join data absensi dengan data anggota.
             */
            $anggotaMap = $anggotaModel->findByIds(array_values($anggotaIds));

            $recentList = array_map(function ($absen) use ($anggotaMap) {
                $anggotaId = $absen['anggota_id'] ?? null;
                $anggota = $anggotaMap[$anggotaId] ?? null;

                return [
                    'nama'         => $anggota['nama'] ?? 'Unknown',
                    'role'         => strtolower(trim($absen['role'] ?? ($anggota['role'] ?? ''))),
                    'waktu_datang' => $absen['waktu_datang'] ?? '',
                    'photo'        => $anggota['photo'] ?? null,
                ];
            }, $recent);

            /**
             * Pisahkan recent absensi berdasarkan role.
             *
             * Ini adalah data yang absen / recent,
             * bukan semua anggota terdaftar.
             */
            $recentPeserta = array_values(array_filter($recentList, function ($item) {
                return strtolower(trim($item['role'] ?? '')) === 'peserta';
            }));

            $recentPengurus = array_values(array_filter($recentList, function ($item) {
                return strtolower(trim($item['role'] ?? '')) === 'pengurus';
            }));

            $counts     = ['peserta' => count($recentPeserta), 'pengurus' => count($recentPengurus)];

            /**
             * Limit tampilan recent absensi.
             */
            $recentPeserta = array_slice($recentPeserta, 0, 5);
            $recentPengurus = array_slice($recentPengurus, 0, 5);

        } catch (\Exception $e) {
            $counts = [
                'peserta'  => 0,
                'pengurus' => 0,
            ];

            $all_peserta = [];
            $all_pengurus = [];

            $recentPeserta = [];
            $recentPengurus = [];
        }

        return view('dashboard.index', compact(
            'counts',
            'all_peserta',
            'all_pengurus',
            'recentPeserta',
            'recentPengurus'
        ));
    }
}
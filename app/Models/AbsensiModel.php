<?php

namespace App\Models;

use App\Services\GoogleSheetsService;

/**
 * Sheet: absensi
 * Kolom: A=id | B=anggota_id | C=role | D=tanggal | E=waktu_datang | F=waktu_pulang
 */
class AbsensiModel
{
    private GoogleSheetsService $sheets;
    private string $sheet = 'absensi';

    public function __construct()
    {
        $this->sheets = app(GoogleSheetsService::class);
    }

    /**
     * Cek apakah anggota sudah absen hari ini.
     * Mengembalikan array dengan info row dan waktu_pulang, atau null.
     */
    public function findTodayRecord(int $anggotaId, string $tanggal): ?array
    {
        // Ambil kolom B (ID), D (Tanggal), dan F (Pulang)
        $results = $this->sheets->batchGet([
            "{$this->sheet}!B:B",
            "{$this->sheet}!D:D",
            "{$this->sheet}!F:F",
        ]);
        $ids     = $results[0] ?? [];
        $dates   = $results[1] ?? [];
        $pulangs = $results[2] ?? [];

        foreach ($ids as $i => $row) {
            if ($i === 0) continue; // skip header
            
            // Konversi tanggal dari Google Sheets yang mungkin berformat '15/05/2026' menjadi '2026-05-15'
            $rawDate = $dates[$i][0] ?? '';
            $ts = strtotime(str_replace('/', '-', $rawDate));
            $parsedDate = $ts ? date('Y-m-d', $ts) : $rawDate;

            if ((int)($row[0] ?? 0) === $anggotaId && $parsedDate === $tanggal) {
                return [
                    'row' => $i + 1, // 1-indexed row number
                    'waktu_pulang' => $pulangs[$i][0] ?? '-'
                ];
            }
        }
        return null;
    }

    /** Catat absensi datang secara presisi di row kosong terakhir */
    public function create(int $anggotaId, string $role, string $tanggal, string $waktuDatang): bool
    {
        $id = $this->sheets->getNextId($this->sheet);
        $rowNum = $id + 1; // Karena baris 1 adalah header
        return $this->sheets->updateRange("{$this->sheet}!A{$rowNum}:F{$rowNum}", [
            $id, $anggotaId, $role, $tanggal, $waktuDatang, '-'
        ]);
    }

    /** Update waktu pulang */
    public function updatePulang(int $rowNum, string $waktuPulang): bool
    {
        return $this->sheets->updateRange(
            "{$this->sheet}!F{$rowNum}",
            [$waktuPulang]
        );
    }

    /**
     * OPTIMASI UTAMA untuk Dashboard:
     * Load seluruh absensi (A:F) dalam 1 API call, lalu:
     * - Hitung counts hari ini di PHP
     * - Ambil N baris terbaru di PHP
     * Total: 1 API call (vs sebelumnya 4 API calls).
     *
     * Returns: ['counts' => [...], 'recent' => [...]]
     */
    public function getForDashboard(string $today, int $recentLimit = 5): array
    {
        $rows = $this->sheets->getRange("{$this->sheet}!A2:F");

        $counts = ['peserta' => 0, 'pengurus' => 0];
        $allMapped = [];

        foreach ($rows as $row) {
            $mapped = $this->map($row);
            $allMapped[] = $mapped;

            // Hitung kehadiran hari ini
            if ($mapped['tanggal'] === $today && isset($counts[$mapped['role']])) {
                $counts[$mapped['role']]++;
            }
        }

        // Ambil N terbaru (dari belakang)
        $recent = array_slice(array_reverse($allMapped), 0, $recentLimit);

        return compact('counts', 'recent');
    }

    /**
     * Ambil semua absensi berdasarkan role (untuk tabel).
     * 1 API call, filter di PHP.
     */
    public function getAllByRole(string $role): array
    {
        $rows = $this->sheets->getRange("{$this->sheet}!A2:F");
        $result = [];
        foreach ($rows as $row) {
            if (($row[2] ?? '') === $role) {
                $result[] = $this->map($row);
            }
        }
        return $result;
    }

    private function map(array $row): array
    {
        $rawDate = $row[3] ?? '';
        $ts = strtotime(str_replace('/', '-', $rawDate));
        $parsedDate = $ts ? date('Y-m-d', $ts) : $rawDate;

        return [
            'id'           => (int)($row[0] ?? 0),
            'anggota_id'   => (int)($row[1] ?? 0),
            'role'         => $row[2] ?? '',
            'tanggal'      => $parsedDate,
            'waktu_datang' => $row[4] ?? '',
            'waktu_pulang' => $row[5] ?? '',
        ];
    }
}

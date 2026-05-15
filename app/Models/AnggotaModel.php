<?php

namespace App\Models;

use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\Cache;

/**
 * Sheet: anggota
 * Kolom: A=id | B=nis | C=nama | D=divisi | E=jabatan | F=role
 *
 * PENTING: Row berurut sesuai ID!
 * Row 1 = header, Row 2 = ID 1, Row 3 = ID 2, dst.
 * Ini memungkinkan findById() → O(1) fetch langsung.
 */
class AnggotaModel
{
    private GoogleSheetsService $sheets;
    private string $sheet = 'anggota';

    // Cache NIS → anggota data selama 5 menit (scan berulang lebih cepat)
    private int $cacheSeconds = 300;

    public function __construct()
    {
        $this->sheets = app(GoogleSheetsService::class);
    }

    /**
     * Cari anggota by ID — O(1)!
     * Langsung fetch row ke-(id+1) karena row 1 = header.
     */
    public function findById(int $id): ?array
    {
        return Cache::remember("anggota_id_{$id}", $this->cacheSeconds, function () use ($id) {
            $rowNum = $id + 1;
            $row    = $this->sheets->getRow($this->sheet, $rowNum, 'F');
            if (empty($row) || (int)($row[0] ?? 0) !== $id) return null;
            return $this->map($row);
        });
    }

    /**
     * Cari anggota by NIS (dari barcode scan).
     * Di-cache selama 5 menit — scan orang yang sama berulang jauh lebih cepat.
     * API calls: load kolom B saja → 1 call, lalu fetch baris → 1 call. Total: 2 calls (cached).
     */
    public function findByNis(string $nis): ?array
    {
        return Cache::remember("anggota_nis_{$nis}", $this->cacheSeconds, function () use ($nis) {
            $rowNum = $this->sheets->findRowByValue($this->sheet, 'B', $nis);
            if ($rowNum === 0) return null;
            $row = $this->sheets->getRow($this->sheet, $rowNum, 'F');
            return $this->map($row);
        });
    }

    /**
     * Batch fetch anggota by IDs — 1 API call untuk semua IDs.
     * Sangat efisien untuk JOIN dengan absensi.
     * Returns: [id => anggotaData, ...]
     */
    public function findByIds(array $ids): array
    {
        if (empty($ids)) return [];

        // Cek cache dulu
        $result    = [];
        $missedIds = [];
        foreach ($ids as $id) {
            $cached = Cache::get("anggota_id_{$id}");
            if ($cached !== null) {
                $result[$id] = $cached;
            } else {
                $missedIds[] = $id;
            }
        }

        // Fetch yang belum di-cache dalam 1 batchGet
        if (!empty($missedIds)) {
            $ranges   = array_map(fn($id) => "anggota!A" . ($id + 1) . ":F" . ($id + 1), $missedIds);
            $rows     = $this->sheets->batchGetRows($ranges);
            foreach ($rows as $i => $row) {
                if (!empty($row)) {
                    $data = $this->map($row);
                    if ($data) {
                        Cache::put("anggota_id_{$data['id']}", $data, $this->cacheSeconds);
                        $result[$data['id']] = $data;
                    }
                }
            }
        }

        return $result;
    }

    private function map(array $row): ?array
    {
        if (empty($row)) return null;
        return [
            'id'      => (int)($row[0] ?? 0),
            'nis'     => $row[1] ?? '',
            'nama'    => $row[2] ?? '',
            'divisi'  => $row[3] ?? '',
            'jabatan' => $row[4] ?? '',
            'role'    => $row[5] ?? 'peserta',
        ];
    }
}

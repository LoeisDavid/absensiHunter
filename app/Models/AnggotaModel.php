<?php

namespace App\Models;

use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\Cache;

/**
 * Sheet: anggota
 * Kolom:
 * A = id
 * B = nis
 * C = nama
 * D = divisi
 * E = jabatan
 * F = role
 *
 * Row 1 = header
 * Row 2 = ID 1
 * Row 3 = ID 2
 * dst.
 */
class AnggotaModel
{
    private GoogleSheetsService $sheets;
    private string $sheet = 'anggota';

    private int $cacheSeconds = 300;

    public function __construct()
    {
        $this->sheets = app(GoogleSheetsService::class);
    }

    /**
     * Cari anggota berdasarkan ID.
     */
    public function findById(int $id): ?array
    {
        return Cache::remember("anggota_id_{$id}", $this->cacheSeconds, function () use ($id) {
            $rowNum = $id + 1;

            $row = $this->sheets->getRow($this->sheet, $rowNum, 'F');

            if (empty($row)) {
                return null;
            }

            if ((int)($row[0] ?? 0) !== $id) {
                return null;
            }

            return $this->map($row);
        });
    }

    /**
     * Cari anggota berdasarkan NIS.
     */
    public function findByNis(string $nis): ?array
    {
        return Cache::remember("anggota_nis_{$nis}", $this->cacheSeconds, function () use ($nis) {
            $rowNum = $this->sheets->findRowByValue($this->sheet, 'B', $nis);

            if ($rowNum === 0) {
                return null;
            }

            $row = $this->sheets->getRow($this->sheet, $rowNum, 'F');

            return $this->map($row);
        });
    }

    /**
     * Ambil banyak anggota berdasarkan banyak ID.
     *
     * Return:
     * [
     *   id => dataAnggota,
     *   id => dataAnggota
     * ]
     */
    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $ids = array_values(array_unique(array_filter($ids)));

        $result = [];
        $missedIds = [];

        foreach ($ids as $id) {
            $cached = Cache::get("anggota_id_{$id}");

            if ($cached !== null) {
                $result[$id] = $cached;
            } else {
                $missedIds[] = $id;
            }
        }

        if (!empty($missedIds)) {
            $ranges = array_map(function ($id) {
                return "{$this->sheet}!A" . ($id + 1) . ":F" . ($id + 1);
            }, $missedIds);

            $rows = $this->sheets->batchGetRows($ranges);

            foreach ($rows as $row) {
                if (empty($row)) {
                    continue;
                }

                $data = $this->map($row);

                if (!$data || $data['id'] === 0) {
                    continue;
                }

                Cache::put("anggota_id_{$data['id']}", $data, $this->cacheSeconds);

                $result[$data['id']] = $data;
            }
        }

        return $result;
    }

    /**
     * Ambil semua data anggota yang terdaftar di sheet anggota.
     *
     * Ini BUKAN data absensi.
     * Ini dipakai untuk total peserta dan total pengurus terdaftar.
     */
    public function getAll(): array
    {
        return Cache::remember("anggota_all", $this->cacheSeconds, function () {
            $rows = $this->sheets->getAll($this->sheet, 'A:F');

            if (empty($rows)) {
                return [];
            }

            /**
             * Buang header jika baris pertama adalah header.
             */
            if (isset($rows[0][0]) && strtolower(trim($rows[0][0])) === 'id') {
                array_shift($rows);
            }

            $data = [];

            foreach ($rows as $row) {
                $mapped = $this->map($row);

                if ($mapped && $mapped['id'] !== 0) {
                    $data[] = $mapped;
                }
            }

            return $data;
        });
    }

    /**
     * Ambil semua peserta terdaftar dari sheet anggota.
     */
    public function getAllPeserta(): array
    {
        $anggota = $this->getAll();

        return array_values(array_filter($anggota, function ($item) {
            return strtolower(trim($item['role'] ?? '')) === 'peserta';
        }));
    }

    /**
     * Ambil semua pengurus terdaftar dari sheet anggota.
     */
    public function getAllPengurus(): array
    {
        $anggota = $this->getAll();

        return array_values(array_filter($anggota, function ($item) {
            return strtolower(trim($item['role'] ?? '')) === 'pengurus';
        }));
    }

    /**
     * Mapping row sheet anggota ke array rapi.
     */
    private function map(array $row): ?array
    {
        if (empty($row)) {
            return null;
        }

        return [
            'id'      => (int)($row[0] ?? 0),
            'nis'     => $row[1] ?? '',
            'nama'    => $row[2] ?? '',
            'divisi'  => $row[3] ?? '',
            'jabatan' => $row[4] ?? '',
            'role'    => strtolower(trim($row[5] ?? 'peserta')),
        ];
    }
}
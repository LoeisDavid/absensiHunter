<?php

namespace App\Models;

use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\Cache;

/**
 * Sheet: jadwal
 * Kolom: A=id | B=tanggal | C=kegiatan | D=role
 */
class JadwalModel
{
    private GoogleSheetsService $sheets;
    private string $sheet = 'jadwal';
    private int $cacheSeconds = 300; // 5 minutes

    public function __construct()
    {
        $this->sheets = app(GoogleSheetsService::class);
    }

    /**
     * Ambil semua jadwal berdasarkan bulan (format Y-m) dan role.
     */
    public function getByMonthAndRole(string $yearMonth, string $role): array
    {
        return Cache::remember("jadwal_{$yearMonth}_{$role}", $this->cacheSeconds, function () use ($yearMonth, $role) {
            $rows = $this->sheets->getAll($this->sheet, 'A:D');
            
            $result = [];
            foreach ($rows as $i => $row) {
                if ($i === 0) continue; // Skip header

                $rowRole = strtolower(trim($row[3] ?? ''));
                $rawDate = $row[1] ?? '';
                
                // Konversi tanggal
                $ts = strtotime(str_replace('/', '-', $rawDate));
                if (!$ts) continue;

                $parsedDate = date('Y-m-d', $ts);
                $rowYearMonth = date('Y-m', $ts);

                if ($rowYearMonth === $yearMonth && $rowRole === strtolower($role)) {
                    $result[] = [
                        'id'       => (int)($row[0] ?? 0),
                        'tanggal'  => $parsedDate,
                        'kegiatan' => $row[2] ?? '-',
                        'role'     => $rowRole,
                    ];
                }
            }

            // Urutkan berdasarkan tanggal menaik
            usort($result, function($a, $b) {
                return strtotime($a['tanggal']) - strtotime($b['tanggal']);
            });

            return $result;
        });
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GoogleSheetsService
{
    private string $spreadsheetId;
    private string $credentialsPath;
    private string $baseUrl = 'https://sheets.googleapis.com/v4/spreadsheets';

    public function __construct()
    {
        $this->spreadsheetId   = config('google.spreadsheet_id');
        $this->credentialsPath = base_path(config('google.credentials_path'));
    }

    private function b64u(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function buildJwt(array $creds): string
    {
        $header  = $this->b64u(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $now     = time();

        $payload = $this->b64u(json_encode([
            'iss'   => $creds['client_email'],
            'scope' => 'https://www.googleapis.com/auth/spreadsheets',
            'aud'   => 'https://oauth2.googleapis.com/token',
            'iat'   => $now,
            'exp'   => $now + 3600,
        ]));

        $input = $header . '.' . $payload;

        openssl_sign($input, $sig, $creds['private_key'], OPENSSL_ALGO_SHA256);

        return $input . '.' . $this->b64u($sig);
    }

    /**
     * Access token di-cache 55 menit.
     */
    public function getAccessToken(): string
    {
        return Cache::remember('gsheets_token', 3300, function () {
            if (!file_exists($this->credentialsPath)) {
                throw new \RuntimeException('Google credentials not found: ' . $this->credentialsPath);
            }

            $creds = json_decode(file_get_contents($this->credentialsPath), true);
            $jwt   = $this->buildJwt($creds);

            $response = Http::timeout(10)->asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion'  => $jwt,
            ]);

            if (!$response->successful()) {
                throw new \RuntimeException('Token error: ' . $response->body());
            }

            return $response->json('access_token');
        });
    }

    private function colLetterToIndex(string $letter): int
    {
        $letter = strtoupper($letter);
        $index = 0;
        $len = strlen($letter);
        for ($i = 0; $i < $len; $i++) {
            $index = $index * 26 + (ord($letter[$i]) - 64);
        }
        return $index - 1;
    }

    private function parseRange(string $rangeStr): array
    {
        $sheet = $rangeStr;
        $startCol = 'A';
        $endCol = 'Z';
        $startRow = 1;
        $endRow = null;

        if (strpos($rangeStr, '!') !== false) {
            list($sheet, $cellPart) = explode('!', $rangeStr, 2);
            if (strpos($cellPart, ':') !== false) {
                list($start, $end) = explode(':', $cellPart, 2);
                
                preg_match('/([A-Z]+)([0-9]*)/i', $start, $startMatches);
                $startCol = $startMatches[1] ?? 'A';
                $startRow = !empty($startMatches[2]) ? (int)$startMatches[2] : 1;

                preg_match('/([A-Z]+)([0-9]*)/i', $end, $endMatches);
                $endCol = $endMatches[1] ?? 'Z';
                $endRow = !empty($endMatches[2]) ? (int)$endMatches[2] : null;
            } else {
                preg_match('/([A-Z]+)([0-9]*)/i', $cellPart, $matches);
                $startCol = $matches[1] ?? 'A';
                $endCol = $startCol;
                $startRow = !empty($matches[2]) ? (int)$matches[2] : 1;
                $endRow = $startRow;
            }
        }

        return [
            'sheet' => $sheet,
            'startCol' => $startCol,
            'endCol' => $endCol,
            'startRow' => $startRow,
            'endRow' => $endRow,
        ];
    }

    private function sliceRow(array $row, int $startIdx, int $endIdx): array
    {
        $sliced = [];
        for ($i = $startIdx; $i <= $endIdx; $i++) {
            $sliced[] = $row[$i] ?? '';
        }
        return $sliced;
    }

    public function preloadAllToSession(): void
    {
        $sheets = ['users', 'anggota', 'absensi', 'jadwal'];
        $data = [];
        session()->forget('sheets_data');
        foreach ($sheets as $sheet) {
            $data[$sheet] = $this->getRange("{$sheet}!A:Z");
        }
        session(['sheets_data' => $data]);
    }

    /**
     * Ambil satu range.
     *
     * Contoh:
     * anggota!A:F
     * absensi!A:G
     */
    public function getRange(string $range): array
    {
        if (session()->has('sheets_data')) {
            $parsed = $this->parseRange($range);
            $sheet = $parsed['sheet'];
            $sheetData = session("sheets_data.{$sheet}", []);
            
            $startColIdx = $this->colLetterToIndex($parsed['startCol']);
            $endColIdx = $this->colLetterToIndex($parsed['endCol']);
            $startRowIdx = $parsed['startRow'] - 1;
            $endRowIdx = $parsed['endRow'] !== null ? $parsed['endRow'] - 1 : count($sheetData) - 1;

            $result = [];
            for ($r = $startRowIdx; $r <= $endRowIdx; $r++) {
                if (isset($sheetData[$r])) {
                    $result[] = $this->sliceRow($sheetData[$r], $startColIdx, $endColIdx);
                } else {
                    $result[] = array_fill(0, $endColIdx - $startColIdx + 1, '');
                }
            }
            return $result;
        }

        $token = $this->getAccessToken();

        $response = Http::timeout(15)
            ->withToken($token)
            ->get("{$this->baseUrl}/{$this->spreadsheetId}/values/" . urlencode($range));

        return $response->successful() ? $response->json('values', []) : [];
    }

    /**
     * Ambil semua data dari sheet tertentu.
     *
     * Contoh:
     * getAll('anggota', 'A:F')
     * Hasil range:
     * anggota!A:F
     */
    public function getAll(string $sheet, string $range = 'A:Z'): array
    {
        return $this->getRange("{$sheet}!{$range}");
    }

    /**
     * BATCH GET: ambil beberapa range sekaligus dalam 1 HTTP call.
     *
     * Contoh:
     * batchGet(['absensi!B:B', 'absensi!D:D'])
     */
    public function batchGet(array $ranges): array
    {
        if (session()->has('sheets_data')) {
            $result = [];
            foreach ($ranges as $range) {
                $result[] = $this->getRange($range);
            }
            return $result;
        }

        if (empty($ranges)) {
            return [];
        }

        $token = $this->getAccessToken();

        $query = implode('&', array_map(function ($range) {
            return 'ranges=' . urlencode($range);
        }, $ranges));

        $response = Http::timeout(15)
            ->withToken($token)
            ->get("{$this->baseUrl}/{$this->spreadsheetId}/values:batchGet?{$query}");

        if (!$response->successful()) {
            return array_fill(0, count($ranges), []);
        }

        $result = [];

        foreach ($response->json('valueRanges', []) as $i => $item) {
            $result[$i] = $item['values'] ?? [];
        }

        return $result;
    }

    /**
     * Batch get khusus baris tunggal.
     *
     * Input:
     * [
     *   'anggota!A2:F2',
     *   'anggota!A5:F5'
     * ]
     *
     * Output:
     * [
     *   [1, 'nis', 'nama', 'divisi', 'jabatan', 'role'],
     *   [4, 'nis', 'nama', 'divisi', 'jabatan', 'role']
     * ]
     */
    public function batchGetRows(array $rowRanges): array
    {
        if (empty($rowRanges)) {
            return [];
        }

        $results = $this->batchGet($rowRanges);

        return array_map(function ($rangeResult) {
            return $rangeResult[0] ?? [];
        }, $results);
    }

    /**
     * Append satu row ke sheet.
     */
    public function appendRow(string $sheet, array $values): bool
    {
        $token = $this->getAccessToken();
        $range = urlencode("{$sheet}!A:A");

        $response = Http::timeout(15)
            ->withToken($token)
            ->post("{$this->baseUrl}/{$this->spreadsheetId}/values/{$range}:append?valueInputOption=RAW", [
                'values' => [$values],
            ]);

        if ($response->successful()) {
            if (session()->has('sheets_data')) {
                $sheetData = session("sheets_data.{$sheet}", []);
                $sheetData[] = array_map('strval', $values);
                session(["sheets_data.{$sheet}" => $sheetData]);
            }
            return true;
        }
        return false;
    }

    /**
     * Update satu cell atau range spesifik.
     */
    public function updateRange(string $range, array $values): bool
    {
        $token = $this->getAccessToken();

        $response = Http::timeout(15)
            ->withToken($token)
            ->put("{$this->baseUrl}/{$this->spreadsheetId}/values/" . urlencode($range) . "?valueInputOption=RAW", [
                'values' => [$values],
            ]);

        if ($response->successful()) {
            if (session()->has('sheets_data')) {
                $parsed = $this->parseRange($range);
                $sheet = $parsed['sheet'];
                $sheetData = session("sheets_data.{$sheet}", []);
                
                $startRowIdx = $parsed['startRow'] - 1;
                $startColIdx = $this->colLetterToIndex($parsed['startCol']);

                while (count($sheetData) <= $startRowIdx) {
                    $sheetData[] = [];
                }

                foreach ($values as $offset => $val) {
                    $colIdx = $startColIdx + $offset;
                    $sheetData[$startRowIdx][$colIdx] = (string)$val;
                }
                session(["sheets_data.{$sheet}" => $sheetData]);
            }
            return true;
        }
        return false;
    }

    /**
     * Cari baris berdasarkan nilai di satu kolom.
     *
     * Return:
     * - row number 1-indexed kalau ketemu
     * - 0 kalau tidak ketemu
     */
    public function findRowByValue(string $sheet, string $col, string $value): int
    {
        if (session()->has('sheets_data')) {
            $sheetData = session("sheets_data.{$sheet}", []);
            $colIdx = $this->colLetterToIndex($col);
            foreach ($sheetData as $i => $row) {
                if ($i === 0) {
                    continue;
                }

                if (isset($row[$colIdx]) && (string) $row[$colIdx] === (string) $value) {
                    return $i + 1;
                }
            }

            return 0;
        }

        $rows = $this->getRange("{$sheet}!{$col}:{$col}");

        foreach ($rows as $i => $row) {
            if ($i === 0) {
                continue;
            }

            if (isset($row[0]) && (string) $row[0] === (string) $value) {
                return $i + 1;
            }
        }

        return 0;
    }

    /**
     * Ambil satu baris spesifik berdasarkan row number.
     */
    public function getRow(string $sheet, int $rowNum, string $endCol = 'G'): array
    {
        if (session()->has('sheets_data')) {
            $sheetData = session("sheets_data.{$sheet}", []);
            $rowIndex = $rowNum - 1;
            if (isset($sheetData[$rowIndex])) {
                $endColIdx = $this->colLetterToIndex($endCol);
                return $this->sliceRow($sheetData[$rowIndex], 0, $endColIdx);
            }
            return [];
        }

        $rows = $this->getRange("{$sheet}!A{$rowNum}:{$endCol}{$rowNum}");

        return $rows[0] ?? [];
    }

    /**
     * Hitung jumlah baris data.
     * Header tidak dihitung.
     */
    public function getRowCount(string $sheet): int
    {
        if (session()->has('sheets_data')) {
            $sheetData = session("sheets_data.{$sheet}", []);
            return max(0, count($sheetData) - 1);
        }

        $rows = $this->getRange("{$sheet}!A:A");

        return max(0, count($rows) - 1);
    }

    /**
     * Ambil ID berikutnya.
     */
    public function getNextId(string $sheet): int
    {
        if (session()->has('sheets_data')) {
            return $this->getRowCount($sheet) + 1;
        }

        return $this->getRowCount($sheet) + 1;
    }

    /**
     * Hapus cache token Google Sheets.
     */
    public function clearTokenCache(): void
    {
        Cache::forget('gsheets_token');
    }
}
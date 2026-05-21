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

    /**
     * Ambil satu range.
     *
     * Contoh:
     * anggota!A:F
     * absensi!A:G
     */
    public function getRange(string $range): array
    {
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

        return $response->successful();
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

        return $response->successful();
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
        $rows = $this->getRange("{$sheet}!A{$rowNum}:{$endCol}{$rowNum}");

        return $rows[0] ?? [];
    }

    /**
     * Hitung jumlah baris data.
     * Header tidak dihitung.
     */
    public function getRowCount(string $sheet): int
    {
        $rows = $this->getRange("{$sheet}!A:A");

        return max(0, count($rows) - 1);
    }

    /**
     * Ambil ID berikutnya.
     */
    public function getNextId(string $sheet): int
    {
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
<?php

namespace App\Models;

use App\Services\GoogleSheetsService;

/**
 * Sheet: users
 * Kolom: A=id | B=username | C=password | D=nama | E=role
 *
 * Row N = ID N-1  (row 1 = header, row 2 = id 1, dst.)
 */
class UserModel
{
    private GoogleSheetsService $sheets;
    private string $sheet = 'users';

    public function __construct()
    {
        $this->sheets = app(GoogleSheetsService::class);
    }

    /**
     * Cari user by username.
     * Hanya load kolom B (username), lalu fetch baris spesifik → 2 API calls.
     */
    public function findByUsername(string $username): ?array
    {
        $rowNum = $this->sheets->findRowByValue($this->sheet, 'B', $username);
        if ($rowNum === 0) return null;
        $row = $this->sheets->getRow($this->sheet, $rowNum, 'E');
        return $this->map($row);
    }

    private function map(array $row): ?array
    {
        if (empty($row)) return null;
        return [
            'id'       => (int)($row[0] ?? 0),
            'username' => $row[1] ?? '',
            'password' => $row[2] ?? '',
            'nama'     => $row[3] ?? '',
            'role'     => $row[4] ?? 'admin',
        ];
    }
}

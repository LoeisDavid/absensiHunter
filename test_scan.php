<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sheets = app(\App\Services\GoogleSheetsService::class);
$absensi = new \App\Models\AbsensiModel();

// 1. Fetch current data in absensi
echo "--- ISI SHEET ABSENSI SEKARANG ---\n";
$allData = $sheets->getRange('absensi!A:F');
print_r($allData);

// 2. Simulate findTodayRecord logic
echo "\n--- TEST FIND TODAY RECORD (Anggota ID 1, Tanggal " . now()->format('Y-m-d') . ") ---\n";
$today = now()->format('Y-m-d');
$record = $absensi->findTodayRecord(1, $today);
var_dump($record);

echo "\n--- HASIL BATCH GET ---\n";
$results = $sheets->batchGet([
    "absensi!B:B",
    "absensi!D:D",
    "absensi!F:F",
]);
print_r($results);

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Spreadsheet ID
    |--------------------------------------------------------------------------
    | Salin dari URL spreadsheet kamu:
    | https://docs.google.com/spreadsheets/d/[ID_INI]/edit
    */
    'spreadsheet_id' => env('GOOGLE_SPREADSHEET_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Google Service Account Credentials Path
    |--------------------------------------------------------------------------
    | Path ke file credentials.json dari Google Cloud Console.
    | Simpan di: storage/app/google-credentials.json
    */
    'credentials_path' => env('GOOGLE_CREDENTIALS_PATH', 'storage/app/google-credentials.json'),

    /*
    |--------------------------------------------------------------------------
    | Sheet Names
    |--------------------------------------------------------------------------
    */
    'sheets' => [
        'users'    => 'users',
        'anggota'  => 'anggota',
        'absensi'  => 'absensi',
    ],
];

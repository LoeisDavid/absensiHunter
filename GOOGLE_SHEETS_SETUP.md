# 📋 Panduan Setup Google Sheets — Absensi Hunter

## Langkah 1: Buat Google Spreadsheet

1. Buka [Google Sheets](https://sheets.google.com)
2. Buat spreadsheet baru, beri nama **"Absensi Hunter"**
3. Salin **Spreadsheet ID** dari URL:
   ```
   https://docs.google.com/spreadsheets/d/[SPREADSHEET_ID_ADA_DISINI]/edit
   ```
4. Isi di `.env`:
   ```
   GOOGLE_SPREADSHEET_ID=spreadsheet_id_kamu
   ```

---

## Langkah 2: Buat Sheet (Tab) dengan Struktur Berikut

### Sheet 1: `users`
> Rename tab menjadi `users`

| A    | B        | C        | D         | E     |
|------|----------|----------|-----------|-------|
| id   | username | password | nama      | role  |
| 1    | admin    | admin123 | Admin     | admin |

**Catatan kolom:**
- `id` → Number (1, 2, 3, ...)
- `username` → String
- `password` → String (plain text)
- `nama` → String (nama lengkap admin)
- `role` → String (isi `admin`)

---

### Sheet 2: `anggota`
> Rename tab menjadi `anggota`

| A  | B           | C    | D      | E       | F       |
|----|-------------|------|--------|---------|---------|
| id | nis         | nama | divisi | jabatan | role    |
| 1  | 101.01.001  | Budi | RPL    | Anggota | peserta |

**⚠️ PENTING: ID HARUS BERURUTAN dan sesuai nomor baris!**
- ID 1 = Baris 2 (baris 1 = header)
- ID 2 = Baris 3
- dst.

**Catatan kolom:**
- `id` → Number (WAJIB urut dari 1)
- `nis` → String — **INI yang ada di dalam QR Code/Barcode**
- `nama` → String
- `divisi` → String (contoh: RPL, TKJ, MM)
- `jabatan` → String (contoh: Anggota, Sekretaris, Ketua)
- `role` → String — isi `peserta` atau `pengurus`

---

### Sheet 3: `absensi`
> Rename tab menjadi `absensi`

| A  | B          | C       | D          | E            | F            |
|----|------------|---------|------------|--------------|--------------|
| id | anggota_id | role    | tanggal    | waktu_datang | waktu_pulang |
| 1  | 3          | peserta | 2025-05-15 | 08:30        | 15:00        |

**Catatan kolom:**
- `id` → Number (auto-increment, diisi otomatis oleh sistem)
- `anggota_id` → Number (FK ke kolom A sheet `anggota`)
- `role` → String (`peserta` atau `pengurus`) — disalin dari anggota saat absen
- `tanggal` → String format `YYYY-MM-DD`
- `waktu_datang` → String format `HH:MM`
- `waktu_pulang` → String format `HH:MM` (kosong jika belum pulang)

> Baris pertama absen bisa dikosongkan (header), sistem akan append ke bawah.

---

## Langkah 3: Setup Google Cloud Service Account

1. Buka [Google Cloud Console](https://console.cloud.google.com)
2. Buat project baru atau pilih yang ada
3. Enable **Google Sheets API**:
   - Menu → APIs & Services → Library
   - Cari "Google Sheets API" → Enable
4. Buat Service Account:
   - Menu → APIs & Services → Credentials
   - Create Credentials → Service Account
   - Isi nama, klik Create and Continue
   - Klik Done
5. Download JSON credentials:
   - Klik service account yang dibuat
   - Tab Keys → Add Key → Create new key → JSON
   - File `.json` akan ter-download
6. Simpan file JSON di:
   ```
   c:\laragon\www\absensiHunter\storage\app\google-credentials.json
   ```

---

## Langkah 4: Share Spreadsheet ke Service Account

1. Buka spreadsheet kamu
2. Klik tombol **Share** (kanan atas)
3. Masukkan email service account (ada di file JSON, field `client_email`)
   - Contoh: `absensi-hunter@project-name.iam.gserviceaccount.com`
4. Set role sebagai **Editor**
5. Klik Send/Share

---

## Langkah 5: Isi .env

```env
GOOGLE_SPREADSHEET_ID=ganti_dengan_id_spreadsheet_kamu
GOOGLE_CREDENTIALS_PATH=storage/app/google-credentials.json
```

---

## Langkah 6: Jalankan Aplikasi

```bash
# Di terminal Laragon / CMD
php artisan serve
```

Akses di: `http://localhost:8000`

---

## Format QR Code / Barcode

Isi QR Code atau barcode dengan **NIS** anggota.

Contoh: jika NIS = `101.01.200`, maka QR Code berisi teks `101.01.200`

Bisa generate QR Code di: https://qr-code-generator.com

---

## Troubleshooting

| Error | Solusi |
|-------|--------|
| "Google credentials not found" | Periksa path file JSON di `storage/app/` |
| "NIS tidak ditemukan" | Pastikan NIS di QR Code sama persis dengan kolom B sheet `anggota` |
| "Failed to get Google access token" | Periksa koneksi internet dan validitas credentials.json |
| Data tidak tersimpan | Pastikan service account sudah punya akses Editor ke spreadsheet |

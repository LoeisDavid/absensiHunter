<?php

namespace App\Http\Controllers;

use App\Models\AnggotaModel;
use App\Models\AbsensiModel;
use App\Models\JadwalModel;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    /**
     * Menampilkan daftar semua anggota (bisa di-filter berdasarkan role peserta/pengurus).
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'peserta'); // default peserta
        
        $anggotaModel = new AnggotaModel();
        
        if ($role === 'pengurus') {
            $data = $anggotaModel->getAllPengurus();
        } else {
            $data = $anggotaModel->getAllPeserta();
        }

        return view('rekap.index', compact('data', 'role'));
    }

    /**
     * Menampilkan detail absensi untuk 1 anggota spesifik pada bulan tertentu.
     */
    public function show($id, Request $request)
    {
        $anggotaModel = new AnggotaModel();
        $anggota = $anggotaModel->findById((int)$id);

        if (!$anggota) {
            return redirect()->route('rekap.index')->with('error', 'Anggota tidak ditemukan.');
        }

        // Ambil bulan dari request, default bulan saat ini
        $month = $request->query('month', date('Y-m'));

        $jadwalModel = new JadwalModel();
        $absensiModel = new AbsensiModel();

        // 1. Ambil jadwal untuk role anggota ini di bulan terpilih
        $jadwal = $jadwalModel->getByMonthAndRole($month, $anggota['role']);

        // 2. Ambil semua data absensi untuk memfilter bulan ini
        // Menggunakan metode yang ada, kita panggil getAllByRole lalu filter id dan bulan.
        // Bisa dioptimasi kalau perlu, tapi sementara ambil getAllByRole sudah cukup.
        $allAbsensi = $absensiModel->getAllByRole($anggota['role']);
        
        $absensiBulanIni = [];
        foreach ($allAbsensi as $absen) {
            if ($absen['anggota_id'] === $anggota['id'] && strpos($absen['tanggal'], $month) === 0) {
                // Gunakan tanggal sebagai key untuk mempermudah pencarian
                $absensiBulanIni[$absen['tanggal']] = $absen;
            }
        }

        // 3. Gabungkan jadwal dengan absensi
        $rekap = [];
        $totalHadir = 0;
        $totalTidakHadir = 0;

        foreach ($jadwal as $j) {
            $tanggal = $j['tanggal'];
            $hadir = isset($absensiBulanIni[$tanggal]);
            
            if ($hadir) {
                $totalHadir++;
            } else {
                $totalTidakHadir++;
            }

            $rekap[] = [
                'tanggal'      => $tanggal,
                'kegiatan'     => $j['kegiatan'],
                'status'       => $hadir ? 'Hadir' : 'Tidak Hadir',
                'waktu_datang' => $hadir ? $absensiBulanIni[$tanggal]['waktu_datang'] : '-',
                'waktu_pulang' => $hadir ? $absensiBulanIni[$tanggal]['waktu_pulang'] : '-',
            ];
        }

        return view('rekap.show', compact('anggota', 'month', 'rekap', 'totalHadir', 'totalTidakHadir', 'jadwal'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;
use Auth;

class AbsensiController extends Controller
{
        public function index()
    {
        $today = now()->toDateString();
        $absen = Absensi::where('user_id', Auth::id())
                        ->where('tanggal', $today)
                        ->first();

        return view('absensi.karyawan', compact('absen'));
    }

    public function masuk()
{
    $today = now('Asia/Jakarta')->toDateString();

    // JAM KERJA MULAI
    $jam_mulai = "08:00";
    $batas_terlambat = "08:15";

    $nowTime = now('Asia/Jakarta')->format('H:i');

    $cek = Absensi::where('user_id', Auth::id())
                  ->where('tanggal', $today)
                  ->first();

    if ($cek) {
        return back()->with('error', 'Anda sudah melakukan absensi hari ini.');
    }

    // Tentukan status HADIR / TERLAMBAT
    if ($nowTime <= $batas_terlambat) {
        $status = "HADIR";
    } else {
        $status = "TERLAMBAT";
    }

    Absensi::create([
        'user_id' => Auth::id(),
        'tanggal' => $today,
        'jam_masuk' => now('Asia/Jakarta')->format('H:i:s'),
        'status' => $status,
        'verifikasi_owner' => "Belum Diverifikasi",
    ]);

    return back()->with('success', 'Absensi masuk berhasil!');
}



    public function keluar()
{
    $today = now('Asia/Jakarta')->toDateString();

    $absen = Absensi::where('user_id', Auth::id())
                    ->where('tanggal', $today)
                    ->first();

    if (!$absen) {
        return back()->with('error', 'Anda belum absen masuk.');
    }

    // Tidak boleh absen keluar sebelum disetujui owner
    if ($absen->verifikasi_owner !== 'Diverifikasi') {
        return back()->with('error', 'Absensi Anda belum diverifikasi oleh Owner.');
    }

    if ($absen->jam_keluar !== null) {
        return back()->with('error', 'Anda sudah absen keluar hari ini.');
    }

    $absen->update([
        'jam_keluar' => now('Asia/Jakarta')->format('H:i:s'),
    ]);

    return back()->with('success', 'Absensi keluar berhasil!');
}

    public function dashboardKasir()
    {
        $absen = Absensi::where('user_id', Auth::id())
                        ->where('tanggal', now()->toDateString())
                        ->first();

        return view('kasir.dashboard', compact('absen'));
    }


/// Fungsi Riwayat Absensi
// menampilkan riwayat absensi hanya untuk user yang sedang login
    public function riwayat(Request $request)
{
    $userId = Auth::id();
    $query = Absensi::where('user_id', $userId);

    if ($request->filled('from')) {
        $query->where('tanggal', '>=', $request->input('from'));
    }
    if ($request->filled('to')) {
        $query->where('tanggal', '<=', $request->input('to'));
    }

    $absensi = $query->orderBy('tanggal','desc')->orderBy('jam_masuk','desc')->paginate(20);

    return view('absensi.riwayat', compact('absensi'));
}



}

<?php

namespace App\Http\Controllers;

use App\Models\Absensi;

class OwnerAbsensiController extends Controller
{
    public function index()
{
    $data = Absensi::with('user')->orderBy('tanggal','desc')->get();
    return view('owner.verifikasi', compact('data'));
}

public function approve($id)
{
    $absen = Absensi::find($id);

    if ($absen->verifikasi_owner !== 'Belum Diverifikasi') {
        return back(); // sudah pernah divalidasi
    }

    $absen->update([
        'verifikasi_owner' => 'Diverifikasi'
    ]);

    return back();
}

public function reject($id)
{
    $absen = Absensi::find($id);

    if ($absen->verifikasi_owner !== 'Belum Diverifikasi') {
        return back(); // sudah pernah divalidasi
    }

    $absen->update([
        'verifikasi_owner' => 'Ditolak'
    ]);

    return back();
}

}

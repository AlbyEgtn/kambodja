<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Absensi;
use App\Models\Role;
use App\Models\User;

class KasirDashboardController extends Controller
{
    public function index()
    {
        $totalBahan = BahanBaku::count();
        $userId = auth()->id();
        $bahanHabis = BahanBaku::all()->filter(function ($b) {
            if ($b->satuan == 'pcs' && $b->stok <= 15) return true;
            if (in_array($b->satuan, ['gram','ml']) && $b->stok <= 1000) return true;
            if ($b->stok <= 5) return true;
            return false;
        });
        $absensi = Absensi::where('user_id', $userId)
        ->orderBy('tanggal', 'desc')
        ->limit(7)
        ->get();

        return view('kasir.beranda', compact('totalBahan', 'bahanHabis','absensi'));
    }
}

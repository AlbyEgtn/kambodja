<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\BahanBaku;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // ringkasan
        $totalUser     = User::count();
        $roleKaryawan = Role::where('nama', 'karyawan')->first();
        $totalKaryawan = User::whereHas('role', function($q){
            $q->whereIn('nama', ['karyawan','kasir']);
        })->count();

        $totalBahan    = BahanBaku::count();
        $metodePembayaran = Transaksi::selectRaw('metode_bayar, COUNT(*) as total')
                        ->groupBy('metode_bayar')
                        ->get();
        
        // bahan hampir habis (sesuaikan threshold jika perlu)
        $bahanHabis = BahanBaku::where(function($q){
            $q->where(function($q2){
                $q2->where('satuan','pcs')->where('stok','<=',15);
            })->orWhere(function($q3){
                $q3->whereIn('satuan',['gram','ml'])->where('stok','<=',1000);
            });
        })->get();

        // riwayat transaksi terbaru (mis. 10)
        $riwayat = Transaksi::orderBy('tanggal', 'desc')
                    ->take(3)
                    ->get();

        // data grafik: pendapatan per hari (tanggal, total)
        $from = request('from');
        $to   = request('to');

        $grafikQuery = Transaksi::selectRaw('DATE(tanggal) as tgl, SUM(total_harga) as total');

        if ($from) {
            $grafikQuery->whereDate('tanggal', '>=', $from);
        }

        if ($to) {
            $grafikQuery->whereDate('tanggal', '<=', $to);
        }

        $grafik = $grafikQuery
                    ->groupBy('tgl')
                    ->orderBy('tgl','ASC')
                    ->get();

            
        // kirim semua variabel ke view
        return view('owner.dashboard', compact(
            'totalUser','totalKaryawan','totalBahan','bahanHabis','riwayat','grafik','metodePembayaran'
    ));

    }
}


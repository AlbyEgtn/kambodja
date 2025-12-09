<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExcel;

class LaporanController extends Controller
{
    public function index(Request $req)
{
    $tanggal = $req->tanggal;  
    $bulan   = $req->bulan;    
    $metode  = $req->metode;   

    // =====================================
    // DETAIL TRANSAKSI (5 TERBARU)
    // =====================================
    $detailQuery = Transaksi::with('kasir');

    if ($tanggal) {
        $detailQuery->whereDate('tanggal', $tanggal);
    }

    if ($bulan) {
        $detailQuery->whereYear('tanggal', substr($bulan,0,4))
                    ->whereMonth('tanggal', substr($bulan,5,2));
    }

    if ($metode && $metode != 'semua') {
        $detailQuery->where('metode_bayar', $metode);
    }

    $transaksi = $detailQuery->orderBy('tanggal','DESC')
                             ->limit(5)
                             ->get();

    // =====================================
    // 1. TOTAL HARIAN = TRANSAKSI HARI INI
    // =====================================
    $today = now()->toDateString();  // YYYY-MM-DD

    $totalHarian = Transaksi::whereDate('tanggal', $today)
                             ->sum('total_harga');

    // =====================================
    // 2. TOTAL BULANAN = DEFAULT BULAN INI
    // =====================================
    if ($bulan) {
        // user memilih bulan
        $year  = substr($bulan, 0, 4);
        $month = substr($bulan, 5, 2);
    } else {
        // default buka bulan sekarang
        $year  = now()->year;
        $month = now()->month;
        $bulan = now()->format("Y-m");
    }

    $totalBulanan = Transaksi::whereYear('tanggal', $year)
                             ->whereMonth('tanggal', $month)
                             ->sum('total_harga');

    // =====================================
    // TOTAL TUNAI & NON TUNAI BERDASAR FILTER WAKTU BULAN/DATE
    // =====================================

    // TUNAI
    $tunaiQuery = Transaksi::where('metode_bayar', 'tunai')
                           ->whereYear('tanggal', $year)
                           ->whereMonth('tanggal', $month);

    if ($tanggal) {
        $tunaiQuery->whereDate('tanggal', $tanggal);
    }

    $totalTunai = $tunaiQuery->sum('total_harga');

    // NON TUNAI
    $nonTunaiQuery = Transaksi::whereIn('metode_bayar', ['qris'])
                              ->whereYear('tanggal', $year)
                              ->whereMonth('tanggal', $month);

    if ($tanggal) {
        $nonTunaiQuery->whereDate('tanggal', $tanggal);
    }

    $totalNonTunai = $nonTunaiQuery->sum('total_harga');

    // =====================================
    // REKAP BULANAN
    // =====================================
    $rekapBulanan = Transaksi::selectRaw('
            DATE_FORMAT(tanggal,"%Y-%m") as bulan,
            metode_bayar,
            COUNT(*) as jumlah,
            SUM(total_harga) as total
        ')
        ->groupBy('bulan','metode_bayar')
        ->orderBy('bulan','ASC')
        ->get();

    return view('owner.laporan-statistik', compact(
        'tanggal','bulan','metode',
        'transaksi',
        'totalHarian','totalBulanan',
        'totalTunai','totalNonTunai',
        'rekapBulanan'
    ));
}



}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class ExportController extends Controller
{
    public function exportCSV(Request $req)
    {
        $query = Transaksi::with('kasir');

        if ($req->tanggal) {
            $query->whereDate('tanggal', $req->tanggal);
        }

        if ($req->bulan) {
            $query->whereMonth('tanggal', substr($req->bulan, 5, 2))
                  ->whereYear('tanggal', substr($req->bulan, 0, 4));
        }

        if ($req->metode && $req->metode != 'semua') {
            $query->where('metode_bayar', $req->metode);
        }

        $data = $query->get();

        // Nama file
        $filename = "laporan-omzet-" . date('Ymd_His') . ".csv";

        // Header download
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename={$filename}");

        // buka output buffer
        $file = fopen('php://output', 'w');

        // Header kolom
        fputcsv($file, ['Tanggal', 'No Transaksi', 'Kasir', 'Metode', 'Total']);

        // Isi data
        foreach ($data as $t) {
            fputcsv($file, [
                $t->tanggal,
                $t->no_transaksi,
                $t->kasir->nama_lengkap ?? '-',
                strtoupper($t->metode_bayar),
                $t->total_harga
            ]);
        }

        fclose($file);
        exit;
    }
}

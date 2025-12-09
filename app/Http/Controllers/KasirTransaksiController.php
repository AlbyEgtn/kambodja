<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BahanBaku;
use App\Models\Resep;
use Illuminate\Support\Facades\DB;

class KasirTransaksiController extends Controller
{
    public function index()
{
    $menus = Menu::with('resep.bahan')->get();

    // cek menu yang tidak bisa dijual karena stok kurang
    foreach ($menus as $m) {
        $m->bisa_dijual = true;

        foreach ($m->resep as $r) {
            if ($r->bahan->stok < $r->jumlah_pakai) {
                $m->bisa_dijual = false;
                break;
            }
        }
    }

    return view('kasir.transaksi', compact('menus'));
}


    public function simpan(Request $request)
{
    DB::beginTransaction();

    try {

        $cart = json_decode($request->cart, true);

        if (!$cart || count($cart) == 0) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // ======================================================
        // 1. CEK STOK BAHAN BAKU (WAJIB CUKUP SEMUA)
        // ======================================================
        foreach ($cart as $item) {

            $resepList = Resep::where('menu_id', $item['id'])->get();

            foreach ($resepList as $r) {

                $bahan = BahanBaku::find($r->bahan_id);
                if (!$bahan) continue;

                $butuh = $r->jumlah_pakai * $item['qty'];   // total kebutuhan

                if ($bahan->stok < $butuh) {
                    // Batalkan dan beri pesan error
                return redirect()->back()->with('warning', 
                    'Stok bahan "' . $bahan->nama_bahan . '" tidak cukup untuk menu "' . $item['nama'] . '".'
                );
                }
            }
        }

        // ======================================================
        // 2. SIMPAN TRANSAKSI (Karena stok aman)
        // ======================================================
        $transaksi = Transaksi::create([
            'no_transaksi' => "TRX-" . date("YmdHis"),
            'kasir_id'     => auth()->id(),
            'tanggal'      => now(),
            'total_harga'  => $request->total,
            'metode_bayar' => $request->metode,
            'uang_pembeli' => $request->uang_pembeli ?? 0,
            'kembali'      => $request->kembali ?? 0,
        ]);

        // ======================================================
        // 3. SIMPAN DETAIL & KURANGI STOK
        // ======================================================
        foreach ($cart as $item) {

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'menu_id'      => $item['id'],
                'qty'          => $item['qty'],
                'harga'        => $item['harga'],
                'subtotal'     => $item['qty'] * $item['harga'],
            ]);

            $resepList = Resep::where('menu_id', $item['id'])->get();

            foreach ($resepList as $r) {
                $bahan = BahanBaku::find($r->bahan_id);
                if (!$bahan) continue;

                $pakai = $r->jumlah_pakai * $item['qty'];

                $bahan->stok -= $pakai;
                if ($bahan->stok < 0) $bahan->stok = 0;

                $bahan->save();
            }
        }

        DB::commit();
        return back()->with('success', 'Transaksi berhasil! Stok berkurang otomatis.');

    } catch (\Exception $e) {

        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}


    public function riwayat()
{
    // Ambil semua transaksi milik kasir login
    $transaksi = Transaksi::where('kasir_id', auth()->id())
        ->orderBy('tanggal', 'DESC')
        ->get();

    return view('kasir.riwayat', compact('transaksi'));
}


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $cart = json_decode($request->cart, true);

            if (!$cart || count($cart) == 0) {
                return back()->with('error', 'Keranjang kosong!');
            }

            // 1. SIMPAN TRANSAKSI
            $transaksi = Transaksi::create([
                'no_transaksi' => "TRX-" . date("YmdHis"),
                'kasir_id'     => auth()->id(),
                'tanggal'      => now(),
                'total_harga'  => $request->total,
                'metode_bayar' => $request->metode,
                'uang_pembeli' => $request->uang_pembeli ?? 0,
                'kembali'      => $request->kembali ?? 0,
            ]);

            // 2. SIMPAN DETAIL & KURANGI STOK
            foreach ($cart as $item) {

                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id'      => $item['id'],
                    'qty'          => $item['qty'],
                    'subtotal'     => $item['qty'] * $item['harga'],
                ]);

                // Ambil resep menu
                $resepList = Resep::where('menu_id', $item['id'])->get();

                foreach ($resepList as $r) {
                    $bahan = BahanBaku::find($r->bahan_id);

                    if (!$bahan) continue;

                    $pengurangan = $r->jumlah_pakai * $item['qty'];

                    $bahan->stok -= $pengurangan;

                    if ($bahan->stok < 0) $bahan->stok = 0;

                    $bahan->save();
                }
            }

            DB::commit();
            return back()->with('success', 'Transaksi berhasil! Stok terupdate.');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}




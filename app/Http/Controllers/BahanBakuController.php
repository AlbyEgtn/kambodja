<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;

class BahanBakuController extends Controller
{
    public function index()
    {
        $data = BahanBaku::orderBy('nama_bahan')->get();
        return view('owner.bahan.index', compact('data'));
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'nama_bahan' => 'required|string|max:100|not_regex:/<[^>]*>/',
        'stok'       => 'required|numeric|min:0',
        'satuan'     => 'required|string|max:20',
    ]);

    BahanBaku::create(array_merge($validated, [
        'dibuat_pada' => now('Asia/Jakarta'),
    ]));

    return back()->with('success', 'Bahan baku berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
{
    $bahan = BahanBaku::findOrFail($id);

    $validated = $request->validate([
        'nama_bahan' => 'required|string|max:100|not_regex:/<[^>]*>/',
        'stok'       => 'required|numeric|min:0',
        'satuan'     => 'required|string|max:20',
    ]);

    $bahan->update(array_merge($validated, [
        'diupdate_pada' => now('Asia/Jakarta'),
    ]));

    return back()->with('success', 'Bahan baku berhasil diperbarui.');
    }    

    public function destroy($id)
    {
    $bahan = BahanBaku::findOrFail($id);
    $bahan->delete();

    return back()->with('success', 'Bahan baku berhasil dihapus.');
    }

}

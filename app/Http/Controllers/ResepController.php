<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Resep;
use App\Models\BahanBaku;
use Illuminate\Http\Request;

class ResepController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['resep.bahan'])->get();
        $bahan = BahanBaku::all();

        return view('owner.resep.index', compact('menus', 'bahan'));
    }


    public function destroy($id)
    {
        Resep::findOrFail($id)->delete();

        return back()->with('success', 'Resep berhasil dihapus!');
    }
    public function destroyMenu($id)
{
    // Hapus semua resep
    Resep::where('menu_id', $id)->delete();

    // Hapus menu
    Menu::findOrFail($id)->delete();

    return back()->with('success', 'Menu dan semua resepnya telah dihapus.');
}

    public function storeMenu(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'kategori' => 'required|in:makanan,minuman',
            'bahan_id.*' => 'required|exists:bahan_baku,id',
            'jumlah_pakai.*' => 'required|numeric|min:0.1',
        ]);

        // SIMPAN MENU BARU
        $menu = Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
        ]);

        // SIMPAN RESEP (MULTIPLE)
        foreach ($request->bahan_id as $i => $bahanId) {
            Resep::create([
                'menu_id' => $menu->id,
                'bahan_id' => $bahanId,
                'jumlah_pakai' => $request->jumlah_pakai[$i],
            ]);
        }

        return back()->with('success', 'Menu dan resep berhasil ditambahkan!');
    }

    public function getResepJson($menuId)
{
    $menu = Menu::findOrFail($menuId);
    $resep = Resep::where('menu_id', $menuId)->with('bahan')->get();

    return response()->json([
        'menu' => $menu,
        'resep' => $resep
    ]);
}

    public function update(Request $request, $menuId)
{
    $request->validate([
        'nama_menu' => 'required|string|max:100',
        'harga' => 'required|numeric',
        'kategori' => 'required|in:makanan,minuman',
        'edit_bahan_id.*' => 'required|exists:bahan_baku,id',
        'edit_jumlah_pakai.*' => 'required|numeric|min:0.1',
    ]);

    $menu = Menu::findOrFail($menuId);

    // UPDATE MENU
    $menu->update([
        'nama_menu'  => $request->nama_menu,
        'harga'      => $request->harga,
        'kategori'   => $request->kategori,
    ]);

    // RESET & INSERT ULANG RESEP
    Resep::where('menu_id', $menuId)->delete();

    foreach ($request->edit_bahan_id as $i => $bahanId) {
        Resep::create([
            'menu_id' => $menuId,
            'bahan_id' => $bahanId,
            'jumlah_pakai' => $request->edit_jumlah_pakai[$i],
        ]);
    }

    return back()->with('success', 'Menu dan resep berhasil diperbarui!');
}



}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BahanBaku;

class BahanBakuSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['nama_bahan' => 'Biji Kopi Arabica', 'stok' => 5000, 'satuan' => 'gram'],
            ['nama_bahan' => 'Biji Kopi Robusta', 'stok' => 4000, 'satuan' => 'gram'],
            ['nama_bahan' => 'Susu Full Cream', 'stok' => 10000, 'satuan' => 'ml'],
            ['nama_bahan' => 'Susu Evaporasi', 'stok' => 5000, 'satuan' => 'ml'],
            ['nama_bahan' => 'Gula Pasir', 'stok' => 8000, 'satuan' => 'gram'],
            ['nama_bahan' => 'Sirup Vanilla', 'stok' => 1500, 'satuan' => 'ml'],
            ['nama_bahan' => 'Sirup Caramel', 'stok' => 1500, 'satuan' => 'ml'],
            ['nama_bahan' => 'Es Batu', 'stok' => 300, 'satuan' => 'pcs'],
            ['nama_bahan' => 'Air Mineral', 'stok' => 20000, 'satuan' => 'ml'],
            ['nama_bahan' => 'Teh Hitam', 'stok' => 2000, 'satuan' => 'gram'],
            ['nama_bahan' => 'Coklat Bubuk', 'stok' => 2500, 'satuan' => 'gram'],
            ['nama_bahan' => 'Whipped Cream', 'stok' => 1000, 'satuan' => 'gram'],
        ];

        foreach ($items as $i) {
            BahanBaku::create([
                'nama_bahan'  => $i['nama_bahan'],
                'stok'        => $i['stok'],
                'satuan'      => $i['satuan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

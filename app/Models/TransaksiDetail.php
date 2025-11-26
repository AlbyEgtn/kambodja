<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $table = 'transaksi_detail';

    protected $fillable = [
        'transaksi_id',
        'menu_id',
        'qty',
        'harga',
        'subtotal'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}

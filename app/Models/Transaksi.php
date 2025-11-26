<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'no_transaksi',
        'kasir_id',
        'tanggal',
        'total_harga',
        'metode_bayar',
        'created_at',
        'updated_at',
    ];

    public function detail()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }
}

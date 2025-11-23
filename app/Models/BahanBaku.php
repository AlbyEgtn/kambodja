<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $table = 'bahan_baku';

    public $timestamps = false;

    protected $fillable = [
        'nama_bahan',
        'stok',
        'satuan',
        'created_at',
        'updated_at'
    ];
}

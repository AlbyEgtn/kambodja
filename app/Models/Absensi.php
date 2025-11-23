<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    public $timestamps = false;

    protected $fillable = [
        'user_id', 
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'verifikasi_owner',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

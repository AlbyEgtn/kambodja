<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $table = 'resep';

    protected $fillable = ['menu_id', 'bahan_id', 'jumlah_pakai'];

    public $timestamps = false;

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_id');
    }
}

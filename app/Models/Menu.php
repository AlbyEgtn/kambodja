<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = ['nama_menu', 'harga', 'kategori', 'satuan'];

    public $timestamps = false;

    public function resep()
    {
        return $this->hasMany(Resep::class, 'menu_id');
    }
}

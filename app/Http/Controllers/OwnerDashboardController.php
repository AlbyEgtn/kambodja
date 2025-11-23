<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BahanBaku;
use Illuminate\Http\Request;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();

        $totalKaryawan = User::where('role_id', function($q){
            $q->select('id')
              ->from('roles')
              ->where('nama', 'Karyawan')
              ->limit(1);
        })->count();

        $totalBahan = BahanBaku::count();

        $bahanHabis = BahanBaku::all()->filter(function ($b) {
            if ($b->satuan == 'pcs' && $b->stok <= 15) return true;
            if (in_array($b->satuan, ['gram', 'ml']) && $b->stok <= 500) return true;
            if ($b->stok <= 5) return true;
            return false;
        });

        return view('owner.dashboard', compact(
            'totalUser',
            'totalKaryawan',
            'totalBahan',
            'bahanHabis'
        ));
    }
}


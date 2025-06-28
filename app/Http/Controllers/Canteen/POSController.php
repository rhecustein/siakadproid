<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\CanteenProduct;
use App\Models\CanteenProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class POSController extends Controller
{
   public function index()
{
    $user = Auth::user();
    $role = optional($user->canteens()->first())->pivot->role ?? 'admin';

    // Pilih kantin yang diakses
    $canteen = $role === 'admin'
        ? Canteen::first()
        : $user->canteens()->first();

    if (!$canteen) {
        abort(403, 'Tidak memiliki akses ke kantin manapun.');
    }

    // Ambil semua kategori (untuk filter dropdown)
    $categories = CanteenProductCategory::orderBy('name')->get();

    // Ambil semua produk aktif di kantin ini
    $products = CanteenProduct::with('category')
        ->where('canteen_id', $canteen->id)
        ->where('is_active', true)
        ->orderBy('name')
        ->get();

    return view('canteen.pos', compact(
        'canteen',
        'products',
        'categories',
        'role'
    ));
}


    public function scan(Request $request)
    {
        return response()->json([
            'message' => 'Simulasi scan fingerprint/RFID',
            'user' => [
                'name' => 'Ahmad Fauzan',
                'nis' => 'SAN123456',
                'saldo' => 150000,
            ]
        ]);
    }
}

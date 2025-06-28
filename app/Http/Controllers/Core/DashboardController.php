<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk user yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();
        return view('dashboard', compact('user'));
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\SessionLogin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = \App\Models\User::where('email', $request->email)->first();

        // Nonaktifkan sesi aktif sebelumnya
        SessionLogin::where('user_id', $user->id)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'logged_out_at' => now(),
            ]);

        // Proses autentikasi
        $request->authenticate();
        $request->session()->regenerate();

        // Catat login
        SessionLogin::create([
            'user_id'          => $user->id,
            'session_id'       => Session::getId(),
            'ip_address'       => $request->ip(),
            'user_agent'       => $request->userAgent(),
            'device'           => $this->detectDevice($request),
            'city'             => null,
            'province'         => null,
            'latitude'         => null,
            'longitude'        => null,
            'success'          => true,
            'logged_in_at'     => now(),
            'last_activity_at' => now(),
            'is_active'        => true,
        ]);

        // Langsung arahkan ke dashboard
        return redirect()->route('core.dashboard.index');
    }

    /**
     * Logout dan akhiri sesi login aktif.
     */
    public function destroy(Request $request): RedirectResponse
    {
        SessionLogin::where('user_id', Auth::id())
            ->where('session_id', Session::getId())
            ->update([
                'is_active' => false,
                'logged_out_at' => now(),
            ]);

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Deteksi tipe device berdasarkan User Agent.
     */
    private function detectDevice(Request $request): string
    {
        $agent = $request->userAgent();
        if (Str::contains($agent, ['iPhone', 'Android', 'Mobile'])) {
            return 'mobile';
        } elseif (Str::contains($agent, ['Windows', 'Macintosh', 'Linux'])) {
            return 'desktop';
        }
        return 'unknown';
    }
}

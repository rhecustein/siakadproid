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
use App\Models\User;

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
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $request->authenticate();
            return redirect()->route('login');
        }

        SessionLogin::where('user_id', $user->id)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'logged_out_at' => now(),
            ]);

        $request->authenticate();
        $request->session()->regenerate();

        $authenticatedUser = Auth::user();

        $authenticatedUser->tokens()->delete();

        $fullToken = $authenticatedUser->createToken('web_login_token', ['server:web'])->plainTextToken;
        $onlyToken = explode('|', $fullToken, 2)[1] ?? $fullToken;

        Session::flash('sanctum_token', $onlyToken);

        SessionLogin::create([
            'user_id'          => $authenticatedUser->id,
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

        return redirect()->intended(route('core.dashboard.index', absolute: false));
    }

    /**
     * Logout user dari sesi web dan nonaktifkan token Sanctum yang terkait.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Nonaktifkan entri SessionLogin yang aktif untuk sesi ini.
        SessionLogin::where('user_id', Auth::id())
            ->where('session_id', Session::getId())
            ->update([
                'is_active' => false,
                'logged_out_at' => now(),
            ]);

        // Opsional: Hapus token Sanctum yang sedang digunakan user saat logout.
        // Ini adalah praktik keamanan yang baik.
        // currentAccessToken() akan mengembalikan token yang sedang digunakan untuk request ini.
        if (Auth::check() && Auth::user()->currentAccessToken()) {
            Auth::user()->currentAccessToken()->delete();
        }

        // Logout user dari guard 'web'.
        Auth::guard('web')->logout();

        // Invalidate sesi user untuk menghapus semua data sesi.
        $request->session()->invalidate();

        // Regenerate CSRF token untuk mencegah serangan CSRF pada form berikutnya.
        $request->session()->regenerateToken();

        // Arahkan user ke halaman utama atau halaman login.
        return redirect('/');
    }

    /**
     * Helper method untuk mendeteksi tipe perangkat dari User Agent.
     */
    private function detectDevice(Request $request): string
    {
        $agent = $request->userAgent();
        if (Str::contains($agent, ['iPhone', 'Android', 'Mobile', 'iOS', 'Windows Phone'])) {
            return 'mobile';
        } elseif (Str::contains($agent, ['Windows', 'Macintosh', 'Linux', 'X11', 'CrOS', 'Ubuntu', 'Firefox/'])) {
            return 'desktop';
        }
        return 'unknown';
    }
}
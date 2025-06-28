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
        // Temukan user berdasarkan email yang dicoba login
        $user = User::where('email', $request->email)->first();

        // Jika user tidak ditemukan, biarkan authenticate() di bawah yang menangani error
        if (!$user) {
            $request->authenticate(); // Ini akan throw ValidationException jika kredensial salah
            return redirect()->route('login'); // Fallback jika validasi custom gagal sebelum authenticate
        }

        // Nonaktifkan sesi aktif sebelumnya untuk user ini
        SessionLogin::where('user_id', $user->id)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'logged_out_at' => now(),
            ]);

        // Proses autentikasi web
        $request->authenticate(); // Ini akan mencoba login dan mengatur Auth::user()
        $request->session()->regenerate(); // Regenerate sesi untuk keamanan

        // --- TAMBAHKAN PEMBUATAN TOKEN SANCTUM DI SINI ---
        // Hapus token lama user jika Anda hanya ingin satu token aktif per user (opsional, tapi disarankan)
        $user->tokens()->delete(); // Menghapus semua personal access token yang ada untuk user ini

        // Buat token Sanctum baru
        // Berikan nama token yang deskriptif, misalnya 'auth_token' atau 'web_login_token'
        $token = $user->createToken('web_login_token')->plainTextToken;

        // Anda bisa menyimpan token ini di session jika frontend Anda butuh mengambilnya
        // atau jika Anda ingin melewatkannya sebagai bagian dari respons JSON untuk SPA
        // Session::put('sanctum_token', $token);

        // Catat login baru
        SessionLogin::create([
            'user_id'          => $user->id,
            'session_id'       => Session::getId(),
            'ip_address'       => $request->ip(),
            'user_agent'       => $request->userAgent(),
            'device'           => $this->detectDevice($request),
            'city'             => null, // Sesuaikan jika Anda punya layanan geolokasi
            'province'         => null, // Sesuaikan
            'latitude'         => null, // Sesuaikan
            'longitude'        => null, // Sesuaikan
            'success'          => true,
            'logged_in_at'     => now(),
            'last_activity_at' => now(),
            'is_active'        => true,
        ]);

        // Langsung arahkan ke dashboard
        return redirect()->intended(route('core.dashboard.index', absolute: false)); // Menggunakan intended() lebih baik

    }

    /**
     * Logout dan akhiri sesi login aktif.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Nonaktifkan entri SessionLogin yang aktif untuk sesi ini
        SessionLogin::where('user_id', Auth::id())
            ->where('session_id', Session::getId())
            ->update([
                'is_active' => false,
                'logged_out_at' => now(),
            ]);

        // Hapus token Sanctum terkait sesi ini (opsional, tapi bagus untuk keamanan)
        // Jika token dibuat per sesi, Anda mungkin ingin menghapusnya saat logout
        // Auth::user()->tokens()->where('name', 'web_login_token')->delete();

        Auth::guard('web')->logout(); // Logout dari guard 'web'
        $request->session()->invalidate(); // Invalidate sesi
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/');
    }

    /**
     * Deteksi tipe device berdasarkan User Agent.
     */
    private function detectDevice(Request $request): string
    {
        $agent = $request->userAgent();
        if (Str::contains($agent, ['iPhone', 'Android', 'Mobile', 'iOS'])) { // Tambah iOS
            return 'mobile';
        } elseif (Str::contains($agent, ['Windows', 'Macintosh', 'Linux', 'X11', 'CrOS'])) { // Tambah Linux/ChromeOS
            return 'desktop';
        }
        return 'unknown';
    }
}

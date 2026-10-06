<?php

namespace App\Http\Controllers;

use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('reservasi.index');
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email atau Nomor WhatsApp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        // Cek login via email atau no_hp
        $loginField = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'no_hp';

        if (Auth::attempt([$loginField => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            return redirect()->intended(route('reservasi.index'))
                ->with('success', "Selamat datang kembali, {$user->name}!");
        }

        return back()->withErrors([
            'email' => 'Email / Nomor WhatsApp atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan form registrasi pelanggan baru.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('reservasi.index');
        }

        return view('auth.register');
    }

    /**
     * Proses pendaftaran akun pelanggan baru.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'no_hp' => ['required', 'string', 'max:20', 'unique:users,no_hp'],
            'password' => ['required', 'string', 'confirmed', Password::min(6)],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar. Silakan login.',
            'no_hp.required' => 'Nomor WhatsApp wajib diisi untuk konfirmasi jadwal.',
            'no_hp.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // Cari tier awal (Bronze)
        $defaultTier = MembershipTier::query()
            ->active()
            ->orderBy('min_reservasi', 'asc')
            ->first();

        // Standarisasi format nomor HP (jika dimulai dengan 0, ubah ke format konsisten)
        $noHp = preg_replace('/[^0-9]/', '', $validated['no_hp']);
        if (str_starts_with($noHp, '0')) {
            $noHp = '62'.substr($noHp, 1);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'no_hp' => $noHp,
            'password' => Hash::make($validated['password']),
            'role' => 'pelanggan',
            'alamat' => $validated['alamat'] ?? null,
            'membership_tier_id' => $defaultTier?->id,
            'total_reservasi_selesai' => 0,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $tierName = $defaultTier ? $defaultTier->nama_tier : 'Member';

        return redirect()->route('reservasi.index')
            ->with('success', "Akun berhasil didaftarkan! Selamat bergabung sebagai {$tierName} Member di Ratna Wedding.");
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')
            ->with('info', 'Anda telah berhasil keluar (logout).');
    }
}

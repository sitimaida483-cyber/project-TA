<?php

namespace App\Http\Controllers;

use App\Models\Kapster;
use App\Models\Layanan;
use App\Models\MembershipTier;
use Illuminate\Contracts\View\View;

class LandingController extends Controller
{
    /**
     * Menampilkan halaman utama (landing page) Ratna Wedding.
     */
    public function index(): View
    {
        $layanans = Layanan::query()
            ->active()
            ->orderBy('harga', 'asc')
            ->get();

        $kapsters = Kapster::query()
            ->active()
            ->with('user')
            ->get();

        $membershipTiers = MembershipTier::query()
            ->active()
            ->orderBy('min_reservasi', 'asc')
            ->get();

        $kategoris = $layanans->pluck('kategori')->filter()->unique()->values();

        return view('landing', compact('layanans', 'kapsters', 'membershipTiers', 'kategoris'));
    }
}

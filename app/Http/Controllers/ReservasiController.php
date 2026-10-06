<?php

namespace App\Http\Controllers;

use App\Models\Kapster;
use App\Models\Layanan;
use App\Models\MembershipTier;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReservasiController extends Controller
{
    /**
     * Menampilkan form halaman reservasi pelanggan.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $user?->load('membershipTier');

        $layanans = Layanan::query()
            ->active()
            ->orderBy('harga', 'asc')
            ->get();

        $kapsters = Kapster::query()
            ->active()
            ->get();

        // Selected service from query string (e.g. ?layanan=slug or ?layanan_id=1)
        $selectedLayananId = null;
        if ($request->has('layanan_id')) {
            $selectedLayananId = (int) $request->get('layanan_id');
        } elseif ($request->has('layanan')) {
            $layananFound = $layanans->firstWhere('slug', $request->get('layanan'));
            $selectedLayananId = $layananFound?->id;
        }

        $minDate = Carbon::today()->toDateString();
        $maxDate = Carbon::today()->addMonths(6)->toDateString();

        return view('reservasi.index', compact(
            'user',
            'layanans',
            'kapsters',
            'selectedLayananId',
            'minDate',
            'maxDate'
        ));
    }

    /**
     * Endpoint API / AJAX untuk mengecek ketersediaan jam pada tanggal tertentu.
     */
    public function checkSlots(Request $request): JsonResponse
    {
        $request->validate([
            'tanggal' => ['required', 'date_format:Y-m-d'],
            'kapster_id' => ['nullable', 'exists:kapsters,id'],
            'layanan_id' => ['nullable', 'exists:layanans,id'],
        ]);

        $tanggal = $request->get('tanggal');
        $kapsterId = $request->get('kapster_id');

        // Slot jam operasional salon (08:00 - 18:00)
        $defaultSlots = [
            '08:00',
            '09:00',
            '10:00',
            '11:00',
            '13:00',
            '14:00',
            '15:00',
            '16:00',
            '17:00',
            '18:00',
        ];

        // Ambil semua reservasi aktif pada tanggal tersebut (yang dikonfirmasi atau sedang dikerjakan)
        $query = Reservasi::query()
            ->whereDate('tanggal_reservasi', $tanggal)
            ->whereIn('status', ['dikonfirmasi', 'sedang_dikerjakan']);

        if ($kapsterId) {
            $query->where(function ($q) use ($kapsterId) {
                $q->where('kapster_id', $kapsterId)
                    ->orWhereNull('kapster_id');
            });
        }

        $bookedReservations = $query->get(['jam_mulai', 'jam_selesai', 'kapster_id', 'status']);

        $slotResults = [];
        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->format('H:i');

        foreach ($defaultSlots as $time) {
            $isBooked = false;
            $bookedDetail = null;

            // Jika tanggal adalah hari ini dan jam sudah lewat
            if ($tanggal === $today && $time <= $currentTime) {
                $isBooked = true;
                $bookedDetail = 'Waktu sudah lewat';
            } else {
                foreach ($bookedReservations as $res) {
                    $resStart = substr((string) $res->jam_mulai, 0, 5);
                    $resEnd = substr((string) $res->jam_selesai, 0, 5);

                    // Cek overlap waktu
                    if ($time >= $resStart && $time < $resEnd) {
                        $isBooked = true;
                        $bookedDetail = 'Sudah Terisi (Terkonfirmasi)';
                        break;
                    }
                }
            }

            $slotResults[] = [
                'time' => $time,
                'available' => ! $isBooked,
                'reason' => $bookedDetail,
            ];
        }

        return response()->json([
            'tanggal' => $tanggal,
            'slots' => $slotResults,
        ]);
    }

    /**
     * Menyimpan reservasi baru dari pelanggan.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'layanan_id' => ['required', 'exists:layanans,id'],
            'kapster_id' => ['nullable', 'exists:kapsters,id'],
            'tanggal_reservasi' => ['required', 'date', 'after_or_equal:today'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'layanan_id.required' => 'Pilih paket layanan yang Anda inginkan.',
            'tanggal_reservasi.required' => 'Tanggal reservasi wajib dipilih.',
            'tanggal_reservasi.after_or_equal' => 'Tanggal reservasi tidak boleh tanggal yang sudah lewat.',
            'jam_mulai.required' => 'Jam mulai reservasi wajib dipilih.',
        ]);

        $layanan = Layanan::findOrFail($validated['layanan_id']);
        $user = Auth::user();
        $user->load('membershipTier');

        // Hitung jam selesai berdasarkan durasi layanan (dalam menit)
        $jamMulai = Carbon::createFromFormat('H:i', $validated['jam_mulai']);
        $jamSelesai = (clone $jamMulai)->addMinutes((int) $layanan->durasi_menit);

        // Cek bentrok jadwal jika kapster dipilih atau slot penuh
        $conflictQuery = Reservasi::query()
            ->whereDate('tanggal_reservasi', $validated['tanggal_reservasi'])
            ->whereIn('status', ['dikonfirmasi', 'sedang_dikerjakan'])
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $start = $jamMulai->format('H:i:s');
                $end = $jamSelesai->format('H:i:s');

                $q->where(function ($sub) use ($start, $end) {
                    $sub->where('jam_mulai', '<', $end)
                        ->where('jam_selesai', '>', $start);
                });
            });

        if (! empty($validated['kapster_id'])) {
            $conflictQuery->where('kapster_id', $validated['kapster_id']);
        }

        if ($conflictQuery->exists()) {
            return back()->withInput()->withErrors([
                'jam_mulai' => 'Maaf, jadwal pada jam tersebut sudah terisi oleh pelanggan lain. Silakan pilih jam atau tanggal lain.',
            ]);
        }

        // Kalkulasi harga & diskon membership
        $hargaLayanan = (float) $layanan->harga;
        $tier = $user->membershipTier;
        $diskonPersen = $tier ? (float) $tier->diskon_persen : 0.00;
        $potonganDiskon = ($hargaLayanan * $diskonPersen) / 100;
        $totalBayar = $hargaLayanan - $potonganDiskon;
        $nominalDp = $totalBayar * 0.3; // Standar DP 30%

        // Generate Kode Reservasi Unik
        $kodeReservasi = 'RW-'.date('Ymd').'-'.strtoupper(Str::random(4));
        while (Reservasi::where('kode_reservasi', $kodeReservasi)->exists()) {
            $kodeReservasi = 'RW-'.date('Ymd').'-'.strtoupper(Str::random(4));
        }

        // Batas waktu pembayaran 24 jam
        $batasPembayaran = Carbon::now()->addHours(24);

        $reservasi = Reservasi::create([
            'kode_reservasi' => $kodeReservasi,
            'user_id' => $user->id,
            'layanan_id' => $layanan->id,
            'kapster_id' => $validated['kapster_id'] ?? null,
            'tanggal_reservasi' => $validated['tanggal_reservasi'],
            'jam_mulai' => $jamMulai->format('H:i:s'),
            'jam_selesai' => $jamSelesai->format('H:i:s'),
            'harga_layanan' => $hargaLayanan,
            'membership_tier_id' => $tier?->id,
            'diskon_persen' => $diskonPersen,
            'potongan_diskon' => $potonganDiskon,
            'total_bayar' => $totalBayar,
            'nominal_dp' => $nominalDp,
            'status' => 'menunggu_pembayaran',
            'batas_pembayaran' => $batasPembayaran,
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()->route('reservasi.show', $reservasi->kode_reservasi)
            ->with('success', "Reservasi berhasil dibuat dengan kode {$reservasi->kode_reservasi}! Silakan selesaikan pembayaran DP sebelum batas waktu berakhir.");
    }

    /**
     * Menampilkan detail faktur & status reservasi.
     */
    public function show(string $kode_reservasi): View
    {
        $reservasi = Reservasi::query()
            ->with(['user', 'layanan', 'kapster', 'membershipTier', 'konfirmator'])
            ->where('kode_reservasi', $kode_reservasi)
            ->firstOrFail();

        // Pastikan hanya pemilik reservasi atau admin yang dapat melihat
        $user = Auth::user();
        if ($user && ! $user->isAdmin() && $reservasi->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat reservasi ini.');
        }

        return view('reservasi.show', compact('reservasi'));
    }

    /**
     * Upload bukti transfer pembayaran DP oleh pelanggan.
     */
    public function uploadBukti(Request $request, string $kode_reservasi): RedirectResponse
    {
        $reservasi = Reservasi::where('kode_reservasi', $kode_reservasi)->firstOrFail();

        $user = Auth::user();
        if ($user && ! $user->isAdmin() && $reservasi->user_id !== $user->id) {
            abort(403, 'Akses tidak sah.');
        }

        $request->validate([
            'bukti_transfer' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ], [
            'bukti_transfer.required' => 'Pilih file foto bukti transfer.',
            'bukti_transfer.image' => 'File harus berupa gambar.',
            'bukti_transfer.max' => 'Ukuran file gambar maksimal 3MB.',
        ]);

        if ($request->hasFile('bukti_transfer')) {
            // Hapus file lama jika ada
            if ($reservasi->bukti_transfer && Storage::disk('public')->exists($reservasi->bukti_transfer)) {
                Storage::disk('public')->delete($reservasi->bukti_transfer);
            }

            $path = $request->file('bukti_transfer')->store('bukti-transfer', 'public');

            $reservasi->update([
                'bukti_transfer' => $path,
                'tanggal_upload_bukti' => Carbon::now(),
            ]);

            return back()->with('success', 'Bukti transfer DP berhasil diunggah! Admin Ratna Wedding akan segera memverifikasi pembayaran Anda.');
        }

        return back()->withErrors(['bukti_transfer' => 'Gagal mengunggah file bukti transfer.']);
    }

    /**
     * Menampilkan riwayat reservasi pelanggan yang sedang login.
     */
    public function riwayat(): View
    {
        $user = Auth::user();
        $user->load('membershipTier');

        $reservasis = Reservasi::query()
            ->with(['layanan', 'kapster', 'membershipTier'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        // Cari tier berikutnya untuk progress bar
        $nextTier = null;
        if ($user->membershipTier) {
            $nextTier = MembershipTier::query()
                ->active()
                ->where('min_reservasi', '>', $user->membershipTier->min_reservasi)
                ->orderBy('min_reservasi', 'asc')
                ->first();
        }

        return view('reservasi.riwayat', compact('user', 'reservasis', 'nextTier'));
    }
}

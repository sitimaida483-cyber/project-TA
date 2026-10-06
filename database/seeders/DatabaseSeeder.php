<?php

namespace Database\Seeders;

use App\Models\Kapster;
use App\Models\Layanan;
use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Membership Tiers
        $bronze = MembershipTier::create([
            'nama_tier' => 'Bronze',
            'slug' => 'bronze',
            'min_reservasi' => 0,
            'diskon_persen' => 0.00,
            'deskripsi' => 'Member Baru / Standar (Belum ada diskon khusus)',
            'warna_badge' => '#cd7f32',
            'is_active' => true,
        ]);

        $silver = MembershipTier::create([
            'nama_tier' => 'Silver',
            'slug' => 'silver',
            'min_reservasi' => 3,
            'diskon_persen' => 5.00,
            'deskripsi' => 'Member Silver (Diskon 5% untuk semua layanan setelah 3x reservasi selesai)',
            'warna_badge' => '#94a3b8',
            'is_active' => true,
        ]);

        $gold = MembershipTier::create([
            'nama_tier' => 'Gold',
            'slug' => 'gold',
            'min_reservasi' => 5,
            'diskon_persen' => 10.00,
            'deskripsi' => 'Member Gold (Diskon 10% untuk semua layanan setelah 5x reservasi selesai)',
            'warna_badge' => '#eab308',
            'is_active' => true,
        ]);

        $platinum = MembershipTier::create([
            'nama_tier' => 'Platinum',
            'slug' => 'platinum',
            'min_reservasi' => 10,
            'diskon_persen' => 15.00,
            'deskripsi' => 'Member VIP Platinum (Diskon 15% untuk semua layanan setelah 10x reservasi selesai)',
            'warna_badge' => '#6366f1',
            'is_active' => true,
        ]);

        // 2. Seed Users
        // Admin
        $admin = User::create([
            'name' => 'Ratna (Admin Owner)',
            'email' => 'admin@ratnawedding.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'role' => 'admin',
            'alamat' => 'Jl. Pengantin Cantik No. 10, Jakarta',
            'membership_tier_id' => null,
            'total_reservasi_selesai' => 0,
        ]);

        // Kapster User 1
        $userKapster1 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@ratnawedding.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567891',
            'role' => 'kapster',
            'alamat' => 'Jl. Melati No. 5',
            'membership_tier_id' => null,
            'total_reservasi_selesai' => 0,
        ]);

        // Kapster User 2
        $userKapster2 = User::create([
            'name' => 'Dewi Sartika',
            'email' => 'dewi@ratnawedding.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567892',
            'role' => 'kapster',
            'alamat' => 'Jl. Mawar No. 12',
            'membership_tier_id' => null,
            'total_reservasi_selesai' => 0,
        ]);

        // Pelanggan 1 (Baru)
        $pelanggan1 = User::create([
            'name' => 'Anisa Rahma',
            'email' => 'anisa@gmail.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567893',
            'role' => 'pelanggan',
            'alamat' => 'Jl. Kenanga No. 8',
            'membership_tier_id' => $bronze->id,
            'total_reservasi_selesai' => 0,
        ]);

        // Pelanggan 2 (Loyal Member - Gold)
        $pelanggan2 = User::create([
            'name' => 'Rini Anggraini',
            'email' => 'rini@gmail.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567894',
            'role' => 'pelanggan',
            'alamat' => 'Jl. Anggrek No. 20',
            'membership_tier_id' => $gold->id,
            'total_reservasi_selesai' => 6,
        ]);

        // 3. Seed Kapster Profiles
        Kapster::create([
            'user_id' => $userKapster1->id,
            'nama_kapster' => 'Siti Nurhaliza',
            'no_hp' => '081234567891',
            'spesialisasi' => 'Rias Pengantin Muslim, Modern Hijab Do & Flawless Glam',
            'bio' => 'Berpengalaman 6 tahun dalam tata rias pengantin modern dan hijab syar’i.',
            'is_active' => true,
        ]);

        Kapster::create([
            'user_id' => $userKapster2->id,
            'nama_kapster' => 'Dewi Sartika',
            'no_hp' => '081234567892',
            'spesialisasi' => 'Rias Pengantin Tradisional Solo Putri, Jogja Paes Ageng & Sunda Siger',
            'bio' => 'Spesialis riasan adat nusantara bersertifikat nasional dengan pengalaman lebih dari 8 tahun.',
            'is_active' => true,
        ]);

        // 4. Seed Layanan
        Layanan::create([
            'nama_layanan' => 'Paket Rias Akad & Resepsi Muslim Modern',
            'slug' => Str::slug('Paket Rias Akad & Resepsi Muslim Modern'),
            'kategori' => 'Rias Pengantin',
            'deskripsi' => 'Rias lengkap pengantin wanita untuk prosesi akad nikah dan resepsi, termasuk hijab styling dan retouch.',
            'durasi_menit' => 180,
            'harga' => 3500000.00,
            'is_active' => true,
        ]);

        Layanan::create([
            'nama_layanan' => 'Paket Rias Pengantin Adat Tradisional (Solo / Jogja / Sunda)',
            'slug' => Str::slug('Paket Rias Pengantin Adat Tradisional (Solo / Jogja / Sunda)'),
            'kategori' => 'Rias Pengantin',
            'deskripsi' => 'Riasan pengantin adat lengkap dengan paes, cunduk mentul, ronce melati asli, dan aksesori adat lengkap.',
            'durasi_menit' => 240,
            'harga' => 4500000.00,
            'is_active' => true,
        ]);

        Layanan::create([
            'nama_layanan' => 'Makeup Prewedding Outdoor / Studio',
            'slug' => Str::slug('Makeup Prewedding Outdoor / Studio'),
            'kategori' => 'Prewedding',
            'deskripsi' => 'Tata rias tahan lama khusus pemotretan prewedding outdoor atau indoor studio selama sesi foto.',
            'durasi_menit' => 120,
            'harga' => 1200000.00,
            'is_active' => true,
        ]);

        Layanan::create([
            'nama_layanan' => 'Makeup Wisuda / Pesta & Hijab Styling',
            'slug' => Str::slug('Makeup Wisuda / Pesta & Hijab Styling'),
            'kategori' => 'Event & Wisuda',
            'deskripsi' => 'Makeup natural glam untuk wisuda, pesta kelulusan, atau kondangan resmi.',
            'durasi_menit' => 60,
            'harga' => 350000.00,
            'is_active' => true,
        ]);

        Layanan::create([
            'nama_layanan' => 'Rias & Busana Ibu Pengantin (Besan)',
            'slug' => Str::slug('Rias & Busana Ibu Pengantin (Besan)'),
            'kategori' => 'Keluarga',
            'deskripsi' => 'Makeup dan sanggul / hijab do untuk kedua ibu mempelai pengantin.',
            'durasi_menit' => 90,
            'harga' => 600000.00,
            'is_active' => true,
        ]);
    }
}

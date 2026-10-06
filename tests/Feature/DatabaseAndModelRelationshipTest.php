<?php

namespace Tests\Feature;

use App\Models\Kapster;
use App\Models\Layanan;
use App\Models\Reservasi;
use App\Models\RiwayatNotifikasi;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseAndModelRelationshipTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_users_and_membership_tier_relationship(): void
    {
        $user = User::where('email', 'rini@gmail.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->isPelanggan());
        $this->assertNotNull($user->membershipTier);
        $this->assertEquals('Gold', $user->membershipTier->nama_tier);
        $this->assertEquals(10.00, (float) $user->membershipTier->diskon_persen);
    }

    public function test_kapster_and_user_relationship(): void
    {
        $kapster = Kapster::first();

        $this->assertNotNull($kapster);
        $this->assertNotNull($kapster->user);
        $this->assertEquals('siti@ratnawedding.com', $kapster->user->email);
        $this->assertTrue($kapster->user->isKapster());
    }

    public function test_reservasi_creation_and_relations(): void
    {
        $pelanggan = User::where('email', 'anisa@gmail.com')->first();
        $layanan = Layanan::first();
        $kapster = Kapster::first();

        $reservasi = Reservasi::create([
            'kode_reservasi' => 'RW-20261005-0001',
            'user_id' => $pelanggan->id,
            'layanan_id' => $layanan->id,
            'kapster_id' => $kapster->id,
            'tanggal_reservasi' => Carbon::tomorrow()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '12:00:00',
            'harga_layanan' => $layanan->harga,
            'membership_tier_id' => $pelanggan->membership_tier_id,
            'diskon_persen' => 0.00,
            'potongan_diskon' => 0.00,
            'total_bayar' => $layanan->harga,
            'nominal_dp' => $layanan->harga * 0.3,
            'status' => 'menunggu_pembayaran',
            'batas_pembayaran' => Carbon::now()->addHours(24),
            'catatan' => 'Mohon kapster datang tepat waktu.',
        ]);

        $this->assertNotNull($reservasi);
        $this->assertTrue($reservasi->isMenungguPembayaran());
        $this->assertEquals('Menunggu Pembayaran', $reservasi->status_label);
        $this->assertEquals($pelanggan->id, $reservasi->user->id);
        $this->assertEquals($layanan->id, $reservasi->layanan->id);
        $this->assertEquals($kapster->id, $reservasi->kapster->id);

        // Test RiwayatNotifikasi relation
        $notifikasi = RiwayatNotifikasi::create([
            'reservasi_id' => $reservasi->id,
            'user_id' => $pelanggan->id,
            'no_hp_tujuan' => $pelanggan->no_hp,
            'channel' => 'whatsapp',
            'jenis_notifikasi' => 'booking_baru_rekening',
            'pesan' => 'Halo Anisa, silahkan transfer DP ke BCA 1234567890 a.n Ratna Wedding.',
            'status' => 'sent',
            'sent_at' => Carbon::now(),
        ]);

        $this->assertCount(1, $reservasi->fresh()->riwayatNotifikasis);
        $this->assertEquals($notifikasi->id, $reservasi->riwayatNotifikasis->first()->id);
    }

    public function test_automatic_membership_tier_sync(): void
    {
        $pelanggan = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => bcrypt('password'),
            'no_hp' => '0899999999',
            'role' => 'pelanggan',
        ]);

        $layanan = Layanan::first();

        // 0 completed bookings -> Bronze
        $pelanggan->syncMembershipTier();
        $this->assertEquals('Bronze', $pelanggan->fresh()->membershipTier->nama_tier);

        // Create 3 completed bookings
        for ($i = 1; $i <= 3; $i++) {
            Reservasi::create([
                'kode_reservasi' => "RW-TEST-00{$i}",
                'user_id' => $pelanggan->id,
                'layanan_id' => $layanan->id,
                'tanggal_reservasi' => Carbon::now()->subDays($i)->toDateString(),
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '12:00:00',
                'harga_layanan' => $layanan->harga,
                'total_bayar' => $layanan->harga,
                'status' => 'selesai',
            ]);
        }

        // Sync again -> Should be Silver (min 3)
        $pelanggan->syncMembershipTier();
        $this->assertEquals('Silver', $pelanggan->fresh()->membershipTier->nama_tier);
        $this->assertEquals(3, $pelanggan->fresh()->total_reservasi_selesai);

        // Create 2 more completed bookings (total 5)
        for ($i = 4; $i <= 5; $i++) {
            Reservasi::create([
                'kode_reservasi' => "RW-TEST-00{$i}",
                'user_id' => $pelanggan->id,
                'layanan_id' => $layanan->id,
                'tanggal_reservasi' => Carbon::now()->subDays($i)->toDateString(),
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '12:00:00',
                'harga_layanan' => $layanan->harga,
                'total_bayar' => $layanan->harga,
                'status' => 'selesai',
            ]);
        }

        // Sync again -> Should be Gold (min 5)
        $pelanggan->syncMembershipTier();
        $this->assertEquals('Gold', $pelanggan->fresh()->membershipTier->nama_tier);
        $this->assertEquals(5, $pelanggan->fresh()->total_reservasi_selesai);
    }
}

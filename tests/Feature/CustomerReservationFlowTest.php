<?php

namespace Tests\Feature;

use App\Models\Kapster;
use App\Models\Layanan;
use App\Models\Reservasi;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomerReservationFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get(route('landing'));

        $response->assertStatus(200);
        $response->assertSee('Ratna Wedding');
        $response->assertSee('Paket Rias Akad &amp; Resepsi Muslim Modern', false);
        $response->assertSee('Skema Tier Membership');
        $response->assertSee('Siti Nurhaliza');
    }

    public function test_registration_creates_user_with_bronze_tier_and_logs_in(): void
    {
        $response = $this->post(route('register.post'), [
            'name' => 'Citra Kirana',
            'email' => 'citra@gmail.com',
            'no_hp' => '081299887766',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'alamat' => 'Jakarta Selatan',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('reservasi.index'));

        $user = User::where('email', 'citra@gmail.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('6281299887766', $user->no_hp);
        $this->assertEquals('pelanggan', $user->role);
        $this->assertNotNull($user->membershipTier);
        $this->assertEquals('Bronze', $user->membershipTier->nama_tier);
    }

    public function test_login_and_logout_flow(): void
    {
        $response = $this->post(route('login.post'), [
            'email' => 'anisa@gmail.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('reservasi.index'));

        $logoutResponse = $this->post(route('logout'));
        $this->assertGuest();
        $logoutResponse->assertRedirect(route('landing'));
    }

    public function test_reservation_page_requires_auth(): void
    {
        $guestResponse = $this->get(route('reservasi.index'));
        $guestResponse->assertRedirect(route('login'));

        $user = User::where('email', 'rini@gmail.com')->first();
        $authResponse = $this->actingAs($user)->get(route('reservasi.index'));
        $authResponse->assertStatus(200);
        $authResponse->assertSee('Pilih Layanan');
        $authResponse->assertSee('Gold Member');
    }

    public function test_check_slots_api_detects_occupied_slots(): void
    {
        $layanan = Layanan::first();
        $kapster = Kapster::first();
        $pelanggan = User::where('email', 'anisa@gmail.com')->first();
        $targetDate = Carbon::tomorrow()->toDateString();

        // Buat reservasi yang terkonfirmasi pada jam 10:00 - 13:00
        Reservasi::create([
            'kode_reservasi' => 'RW-OCCUPIED-01',
            'user_id' => $pelanggan->id,
            'layanan_id' => $layanan->id,
            'kapster_id' => $kapster->id,
            'tanggal_reservasi' => $targetDate,
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '13:00:00',
            'harga_layanan' => $layanan->harga,
            'total_bayar' => $layanan->harga,
            'status' => 'dikonfirmasi',
        ]);

        $response = $this->actingAs($pelanggan)->getJson(route('reservasi.checkSlots', [
            'tanggal' => $targetDate,
            'kapster_id' => $kapster->id,
        ]));

        $response->assertStatus(200);
        $slots = $response->json('slots');

        // Slot jam 08:00 dan 09:00 harus available
        $slot08 = collect($slots)->firstWhere('time', '08:00');
        $this->assertTrue($slot08['available']);

        // Slot jam 10:00 dan 11:00 harus unavailable (karena durasi overlap 10:00 - 13:00)
        $slot10 = collect($slots)->firstWhere('time', '10:00');
        $this->assertFalse($slot10['available']);

        $slot11 = collect($slots)->firstWhere('time', '11:00');
        $this->assertFalse($slot11['available']);
    }

    public function test_customer_can_submit_booking_and_see_invoice_with_member_discount(): void
    {
        // Gunakan pelanggan dengan Tier Gold (Diskon 10%)
        $user = User::where('email', 'rini@gmail.com')->first();
        $layanan = Layanan::first(); // Harga Rp 3.500.000
        $kapster = Kapster::first();
        $targetDate = Carbon::tomorrow()->toDateString();

        $response = $this->actingAs($user)->post(route('reservasi.store'), [
            'layanan_id' => $layanan->id,
            'kapster_id' => $kapster->id,
            'tanggal_reservasi' => $targetDate,
            'jam_mulai' => '14:00',
            'catatan' => 'Preferensi warna hijab pastel',
        ]);

        $reservasi = Reservasi::where('user_id', $user->id)->latest()->first();
        $this->assertNotNull($reservasi);
        $response->assertRedirect(route('reservasi.show', $reservasi->kode_reservasi));

        // Verifikasi kalkulasi diskon 10%
        $this->assertEquals(3500000.00, (float) $reservasi->harga_layanan);
        $this->assertEquals(10.00, (float) $reservasi->diskon_persen);
        $this->assertEquals(350000.00, (float) $reservasi->potongan_diskon);
        $this->assertEquals(3150000.00, (float) $reservasi->total_bayar);
        $this->assertEquals(945000.00, (float) $reservasi->nominal_dp); // 30% dari 3.150.000
        $this->assertEquals('menunggu_pembayaran', $reservasi->status);
        $this->assertNotNull($reservasi->batas_pembayaran);

        // Akses halaman faktur / show
        $showResponse = $this->actingAs($user)->get(route('reservasi.show', $reservasi->kode_reservasi));
        $showResponse->assertStatus(200);
        $showResponse->assertSee($reservasi->kode_reservasi);
        $showResponse->assertSee('Menunggu Pembayaran DP');
        $showResponse->assertSee('882-019-3829'); // Nomor rekening BCA
    }

    public function test_customer_can_upload_payment_proof(): void
    {
        Storage::fake('public');

        $user = User::where('email', 'anisa@gmail.com')->first();
        $layanan = Layanan::first();

        $reservasi = Reservasi::create([
            'kode_reservasi' => 'RW-PROOF-TEST',
            'user_id' => $user->id,
            'layanan_id' => $layanan->id,
            'tanggal_reservasi' => Carbon::tomorrow()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '12:00:00',
            'harga_layanan' => $layanan->harga,
            'total_bayar' => $layanan->harga,
            'nominal_dp' => $layanan->harga * 0.3,
            'status' => 'menunggu_pembayaran',
            'batas_pembayaran' => Carbon::now()->addHours(24),
        ]);

        $file = UploadedFile::fake()->image('bukti_transfer.jpg', 600, 800);

        $response = $this->actingAs($user)->post(route('reservasi.uploadBukti', $reservasi->kode_reservasi), [
            'bukti_transfer' => $file,
        ]);

        $response->assertRedirect();
        $reservasi->refresh();

        $this->assertNotNull($reservasi->bukti_transfer);
        $this->assertNotNull($reservasi->tanggal_upload_bukti);
        Storage::disk('public')->assertExists($reservasi->bukti_transfer);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_reservasi')->unique()->index();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('layanan_id')->constrained('layanans')->restrictOnDelete();
            $table->foreignId('kapster_id')->nullable()->constrained('kapsters')->nullOnDelete();
            $table->date('tanggal_reservasi')->index();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->decimal('harga_layanan', 12, 2);
            $table->foreignId('membership_tier_id')->nullable()->constrained('membership_tiers')->nullOnDelete();
            $table->decimal('diskon_persen', 5, 2)->default(0.00);
            $table->decimal('potongan_diskon', 12, 2)->default(0.00);
            $table->decimal('total_bayar', 12, 2);
            $table->decimal('nominal_dp', 12, 2)->nullable();
            $table->enum('status', [
                'menunggu_pembayaran',
                'dikonfirmasi',
                'sedang_dikerjakan',
                'selesai',
                'dibatalkan',
            ])->default('menunggu_pembayaran')->index();
            $table->dateTime('batas_pembayaran')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->dateTime('tanggal_upload_bukti')->nullable();
            $table->text('catatan')->nullable();
            $table->text('alasan_batal')->nullable();
            $table->string('google_calendar_event_id')->nullable();
            $table->foreignId('dikonfirmasi_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('dikonfirmasi_pada')->nullable();
            $table->dateTime('waktu_check_in')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->boolean('is_h1_reminder_sent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};

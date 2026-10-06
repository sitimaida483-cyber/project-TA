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
        Schema::create('riwayat_notifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_id')->nullable()->constrained('reservasis')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('no_hp_tujuan');
            $table->string('channel')->default('whatsapp');
            $table->string('jenis_notifikasi'); // booking_baru_rekening, notifikasi_admin_booking_baru, konfirmasi_pembayaran, pengingat_h1, pembatalan_otomatis
            $table->text('pesan');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending')->index();
            $table->longText('response_api')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_notifikasis');
    }
};

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
        Schema::create('membership_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tier');
            $table->string('slug')->unique();
            $table->unsignedInteger('min_reservasi')->default(0);
            $table->decimal('diskon_persen', 5, 2)->default(0.00);
            $table->text('deskripsi')->nullable();
            $table->string('warna_badge')->nullable()->default('#cd7f32');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_tiers');
    }
};

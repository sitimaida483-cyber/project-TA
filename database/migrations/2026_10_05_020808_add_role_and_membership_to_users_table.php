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
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_hp')->nullable()->after('email');
            $table->enum('role', ['admin', 'kapster', 'pelanggan'])->default('pelanggan')->after('no_hp')->index();
            $table->text('alamat')->nullable()->after('role');
            $table->string('foto_profil')->nullable()->after('alamat');
            $table->foreignId('membership_tier_id')->nullable()->after('foto_profil')->constrained('membership_tiers')->nullOnDelete();
            $table->unsignedInteger('total_reservasi_selesai')->default(0)->after('membership_tier_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['membership_tier_id']);
            $table->dropColumn([
                'no_hp',
                'role',
                'alamat',
                'foto_profil',
                'membership_tier_id',
                'total_reservasi_selesai',
            ]);
        });
    }
};

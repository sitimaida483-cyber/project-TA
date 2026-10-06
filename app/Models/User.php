<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_hp',
        'role',
        'alamat',
        'foto_profil',
        'membership_tier_id',
        'total_reservasi_selesai',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'total_reservasi_selesai' => 'integer',
        ];
    }

    /**
     * Relasi ke Membership Tier.
     */
    public function membershipTier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class, 'membership_tier_id');
    }

    /**
     * Relasi ke Reservasi (sebagai pelanggan).
     */
    public function reservasis(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'user_id');
    }

    /**
     * Relasi ke Reservasi yang dikonfirmasi (sebagai admin).
     */
    public function reservasiDikonfirmasi(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'dikonfirmasi_oleh');
    }

    /**
     * Relasi ke profil Kapster (jika user adalah staf/kapster).
     */
    public function kapster(): HasOne
    {
        return $this->hasOne(Kapster::class, 'user_id');
    }

    /**
     * Relasi ke Riwayat Notifikasi.
     */
    public function riwayatNotifikasis(): HasMany
    {
        return $this->hasMany(RiwayatNotifikasi::class, 'user_id');
    }

    /**
     * Check if user is Admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is Kapster.
     */
    public function isKapster(): bool
    {
        return $this->role === 'kapster';
    }

    /**
     * Check if user is Pelanggan/Member.
     */
    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }

    /**
     * Scope query for Admin.
     */
    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope query for Kapster.
     */
    public function scopeKapster(Builder $query): Builder
    {
        return $query->where('role', 'kapster');
    }

    /**
     * Scope query for Pelanggan.
     */
    public function scopePelanggan(Builder $query): Builder
    {
        return $query->where('role', 'pelanggan');
    }

    /**
     * Hitung ulang jumlah reservasi selesai dan sinkronisasi Membership Tier secara otomatis.
     */
    public function syncMembershipTier(): void
    {
        $completedCount = $this->reservasis()
            ->where('status', 'selesai')
            ->count();

        $tier = MembershipTier::query()
            ->where('is_active', true)
            ->where('min_reservasi', '<=', $completedCount)
            ->orderByDesc('min_reservasi')
            ->first();

        $this->update([
            'total_reservasi_selesai' => $completedCount,
            'membership_tier_id' => $tier?->id,
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipTier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_tier',
        'slug',
        'min_reservasi',
        'diskon_persen',
        'deskripsi',
        'warna_badge',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'min_reservasi' => 'integer',
            'diskon_persen' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi ke User / Pelanggan yang memiliki tier ini.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'membership_tier_id');
    }

    /**
     * Relasi ke Reservasi yang menggunakan tier ini.
     */
    public function reservasis(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'membership_tier_id');
    }

    /**
     * Scope untuk tier yang aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'layanans';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_layanan',
        'slug',
        'kategori',
        'deskripsi',
        'durasi_menit',
        'harga',
        'gambar',
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
            'durasi_menit' => 'integer',
            'harga' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi ke Reservasi.
     */
    public function reservasis(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'layanan_id');
    }

    /**
     * Scope untuk layanan aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope berdasarkan kategori.
     */
    public function scopeKategori(Builder $query, string $kategori): Builder
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Accessor harga terformat Rupiah.
     */
    public function getFormattedHargaAttribute(): string
    {
        return 'Rp '.number_format((float) $this->harga, 0, ',', '.');
    }

    /**
     * Accessor durasi terformat string.
     */
    public function getFormattedDurasiAttribute(): string
    {
        return "{$this->durasi_menit} menit";
    }
}

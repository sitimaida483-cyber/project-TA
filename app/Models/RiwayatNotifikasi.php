<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatNotifikasi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'riwayat_notifikasis';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reservasi_id',
        'user_id',
        'no_hp_tujuan',
        'channel',
        'jenis_notifikasi',
        'pesan',
        'status',
        'response_api',
        'sent_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke Reservasi terkait.
     */
    public function reservasi(): BelongsTo
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id');
    }

    /**
     * Relasi ke User / Penerima.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope notifikasi terkirim sukses.
     */
    public function scopeSent(Builder $query): Builder
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope notifikasi gagal.
     */
    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope notifikasi pending.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope berdasarkan jenis notifikasi.
     */
    public function scopeJenis(Builder $query, string $jenis): Builder
    {
        return $query->where('jenis_notifikasi', $jenis);
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservasi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reservasis';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode_reservasi',
        'user_id',
        'layanan_id',
        'kapster_id',
        'tanggal_reservasi',
        'jam_mulai',
        'jam_selesai',
        'harga_layanan',
        'membership_tier_id',
        'diskon_persen',
        'potongan_diskon',
        'total_bayar',
        'nominal_dp',
        'status',
        'batas_pembayaran',
        'bukti_transfer',
        'tanggal_upload_bukti',
        'catatan',
        'alasan_batal',
        'google_calendar_event_id',
        'dikonfirmasi_oleh',
        'dikonfirmasi_pada',
        'waktu_check_in',
        'waktu_selesai',
        'is_h1_reminder_sent',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_reservasi' => 'date',
            'harga_layanan' => 'decimal:2',
            'diskon_persen' => 'decimal:2',
            'potongan_diskon' => 'decimal:2',
            'total_bayar' => 'decimal:2',
            'nominal_dp' => 'decimal:2',
            'batas_pembayaran' => 'datetime',
            'tanggal_upload_bukti' => 'datetime',
            'dikonfirmasi_pada' => 'datetime',
            'waktu_check_in' => 'datetime',
            'waktu_selesai' => 'datetime',
            'is_h1_reminder_sent' => 'boolean',
        ];
    }

    /**
     * Relasi ke Pelanggan/User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Layanan.
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    /**
     * Relasi ke Kapster / Staf.
     */
    public function kapster(): BelongsTo
    {
        return $this->belongsTo(Kapster::class, 'kapster_id');
    }

    /**
     * Relasi ke Membership Tier yang digunakan saat reservasi.
     */
    public function membershipTier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class, 'membership_tier_id');
    }

    /**
     * Relasi ke Admin yang mengonfirmasi pembayaran reservasi.
     */
    public function konfirmator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dikonfirmasi_oleh');
    }

    /**
     * Relasi ke Riwayat Notifikasi.
     */
    public function riwayatNotifikasis(): HasMany
    {
        return $this->hasMany(RiwayatNotifikasi::class, 'reservasi_id');
    }

    /**
     * Status Helper Methods.
     */
    public function isMenungguPembayaran(): bool
    {
        return $this->status === 'menunggu_pembayaran';
    }

    public function isDikonfirmasi(): bool
    {
        return $this->status === 'dikonfirmasi';
    }

    public function isSedangDikerjakan(): bool
    {
        return $this->status === 'sedang_dikerjakan';
    }

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }

    public function isDibatalkan(): bool
    {
        return $this->status === 'dibatalkan';
    }

    public function isExpired(): bool
    {
        return $this->isMenungguPembayaran()
            && $this->batas_pembayaran
            && Carbon::now()->greaterThan($this->batas_pembayaran);
    }

    /**
     * Scopes.
     */
    public function scopeMenungguPembayaran(Builder $query): Builder
    {
        return $query->where('status', 'menunggu_pembayaran');
    }

    public function scopeDikonfirmasi(Builder $query): Builder
    {
        return $query->where('status', 'dikonfirmasi');
    }

    public function scopeSedangDikerjakan(Builder $query): Builder
    {
        return $query->where('status', 'sedang_dikerjakan');
    }

    public function scopeSelesai(Builder $query): Builder
    {
        return $query->where('status', 'selesai');
    }

    public function scopeDibatalkan(Builder $query): Builder
    {
        return $query->where('status', 'dibatalkan');
    }

    /**
     * Scope reservasi yang lewat batas pembayaran 24 jam dan masih menunggu pembayaran.
     */
    public function scopeExpiredPending(Builder $query): Builder
    {
        return $query->where('status', 'menunggu_pembayaran')
            ->whereNotNull('batas_pembayaran')
            ->where('batas_pembayaran', '<', Carbon::now());
    }

    /**
     * Scope reservasi terkonfirmasi untuk H-1 yang belum dikirim notifikasi pengingat.
     */
    public function scopeHMinus1Reminder(Builder $query): Builder
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        return $query->whereIn('status', ['dikonfirmasi'])
            ->where('tanggal_reservasi', $tomorrow)
            ->where('is_h1_reminder_sent', false);
    }

    /**
     * Accessor harga total terformat.
     */
    public function getFormattedTotalBayarAttribute(): string
    {
        return 'Rp '.number_format((float) $this->total_bayar, 0, ',', '.');
    }

    /**
     * Accessor nominal DP terformat.
     */
    public function getFormattedNominalDpAttribute(): string
    {
        return $this->nominal_dp
            ? 'Rp '.number_format((float) $this->nominal_dp, 0, ',', '.')
            : '-';
    }

    /**
     * Accessor label status dalam Bahasa Indonesia yang rapi.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'dikonfirmasi' => 'Dikonfirmasi',
            'sedang_dikerjakan' => 'Sedang Dikerjakan',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }
}

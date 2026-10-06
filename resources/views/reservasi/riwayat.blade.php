@extends('layouts.app')

@section('title', 'Riwayat Reservasi & Status Member - Ratna Wedding')

@section('content')
<div class="py-10 sm:py-16 px-4">
    <div class="max-w-5xl mx-auto space-y-8">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-rose-600 px-3 py-1 rounded-full bg-rose-50 border border-rose-200 inline-block mb-2">
                    Akun Pelanggan
                </span>
                <h1 class="text-3xl font-serif-heading font-bold text-slate-900">
                    Riwayat Reservasi & Status Member
                </h1>
                <p class="text-xs sm:text-sm text-slate-600">
                    Pantau status pengerjaan reservasi Anda dan progres tingkatan loyalitas member.
                </p>
            </div>

            <a href="{{ route('reservasi.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white text-xs font-bold px-5 py-3 rounded-full shadow-md shadow-rose-200 transition-all">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Buat Booking Baru</span>
            </a>
        </div>

        <!-- Membership Progress Card -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-rose-950/5 border border-white/80 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-2xl shadow-md" style="background-color: {{ $user->membershipTier->warna_badge ?? '#cd7f32' }};">
                        <i class="fa-solid fa-crown"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-lg font-bold text-slate-900">{{ $user->name }}</h2>
                            <span class="text-xs font-bold px-3 py-0.5 rounded-full text-white" style="background-color: {{ $user->membershipTier->warna_badge ?? '#cd7f32' }};">
                                {{ $user->membershipTier ? $user->membershipTier->nama_tier : 'Bronze' }} Member
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Diskon Aktif: <strong class="text-rose-600">{{ $user->membershipTier ? (float)$user->membershipTier->diskon_persen : 0 }}%</strong> setiap pemesanan layanan.
                        </p>
                    </div>
                </div>

                <div class="bg-rose-50/80 px-5 py-3 rounded-2xl border border-rose-100 text-right sm:text-right">
                    <span class="text-[10px] uppercase font-bold text-slate-500 block">Total Reservasi Selesai</span>
                    <span class="text-2xl font-extrabold text-rose-700">{{ $user->total_reservasi_selesai }}x</span>
                </div>
            </div>

            <!-- Progress to Next Tier -->
            @if($nextTier)
                <div class="space-y-2 pt-2 border-t border-rose-100">
                    <div class="flex justify-between text-xs font-semibold text-slate-700">
                        <span>Progres menuju <strong>{{ $nextTier->nama_tier }} Member</strong> (Diskon {{ (float)$nextTier->diskon_persen }}%)</span>
                        <span class="text-rose-600 font-bold">
                            {{ $user->total_reservasi_selesai }} / {{ $nextTier->min_reservasi }} Selesai
                        </span>
                    </div>

                    @php
                        $percent = min(100, round(($user->total_reservasi_selesai / max(1, $nextTier->min_reservasi)) * 100));
                    @endphp
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden p-0.5 border border-slate-200">
                        <div class="bg-gradient-to-r from-rose-500 to-amber-500 h-full rounded-full transition-all duration-500" style="width: {{ $percent }}%;"></div>
                    </div>
                    <p class="text-[11px] text-slate-500">
                        Selesaikan <strong>{{ max(0, $nextTier->min_reservasi - $user->total_reservasi_selesai) }} reservasi lagi</strong> untuk otomatis naik ke tier {{ $nextTier->nama_tier }}.
                    </p>
                </div>
            @else
                <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-200 text-xs text-emerald-800 flex items-center gap-2 font-bold">
                    <i class="fa-solid fa-gem text-emerald-600"></i>
                    <span>Selamat! Anda telah mencapai tingkatan Member Tertinggi (VIP Platinum) dengan benefit diskon maksimal!</span>
                </div>
            @endif
        </div>

        <!-- Reservations List Card -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-rose-950/5 border border-white/80 space-y-6">
            <h3 class="text-lg font-serif-heading font-bold text-slate-900 border-b border-rose-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-rose-500"></i>
                <span>Daftar Pemesanan Anda</span>
            </h3>

            @if($reservasis->count() > 0)
                <div class="space-y-4">
                    @foreach($reservasis as $res)
                        <div class="p-5 rounded-2xl bg-white border border-slate-200 hover:border-rose-300 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-2xs">
                            
                            <div class="space-y-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-bold text-slate-900 font-mono">#{{ $res->kode_reservasi }}</span>
                                    
                                    @if($res->isMenungguPembayaran())
                                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                            Menunggu Pembayaran
                                        </span>
                                    @elseif($res->isDikonfirmasi())
                                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1">
                                            <i class="fa-solid fa-check text-[9px]"></i> Dikonfirmasi
                                        </span>
                                    @elseif($res->isSedangDikerjakan())
                                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                            Sedang Dikerjakan
                                        </span>
                                    @elseif($res->isSelesai())
                                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 border border-purple-200">
                                            Selesai
                                        </span>
                                    @elseif($res->isDibatalkan())
                                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-red-100 text-red-800 border border-red-200">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </div>

                                <h4 class="text-base font-bold text-slate-900">{{ $res->layanan->nama_layanan }}</h4>
                                
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500">
                                    <span>
                                        <i class="fa-regular fa-calendar text-rose-400 mr-1"></i>
                                        {{ $res->tanggal_reservasi->translatedFormat('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="fa-regular fa-clock text-rose-400 mr-1"></i>
                                        {{ substr((string)$res->jam_mulai, 0, 5) }} - {{ substr((string)$res->jam_selesai, 0, 5) }} WIB
                                    </span>
                                    <span>
                                        <i class="fa-solid fa-user-check text-rose-400 mr-1"></i>
                                        Kapster: {{ $res->kapster ? $res->kapster->nama_kapster : 'Bebas' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col md:items-end gap-2 shrink-0 border-t md:border-t-0 pt-3 md:pt-0">
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block md:text-right">Total Biaya</span>
                                    <span class="text-base font-extrabold text-slate-900 md:text-right block">{{ $res->formatted_total_bayar }}</span>
                                </div>

                                <a href="{{ route('reservasi.show', $res->kode_reservasi) }}" class="inline-flex items-center justify-center gap-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs px-4 py-2 rounded-xl border border-rose-200 transition-colors">
                                    <span>Lihat Faktur & Bayar</span>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            </div>

                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="pt-4">
                        {{ $reservasis->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-12 text-slate-500 space-y-3">
                    <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-400 flex items-center justify-center mx-auto text-2xl">
                        <i class="fa-regular fa-calendar-xmark"></i>
                    </div>
                    <p class="text-xs">Anda belum pernah melakukan reservasi.</p>
                    <a href="{{ route('reservasi.index') }}" class="inline-flex items-center gap-2 bg-rose-600 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-md">
                        Mulai Booking Sekarang
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

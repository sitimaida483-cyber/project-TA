@extends('layouts.app')

@section('title', 'Detail Reservasi #' . $reservasi->kode_reservasi . ' - Ratna Wedding')

@section('content')
<div class="py-10 sm:py-16 px-4">
    <div class="max-w-4xl mx-auto space-y-8">

        <!-- Top Header & Status Banner -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-rose-950/5 border border-white/80">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-rose-100">
                <div>
                    <span class="text-xs uppercase tracking-widest text-slate-400 font-bold block">Faktur Reservasi</span>
                    <h1 class="text-2xl sm:text-3xl font-serif-heading font-extrabold text-slate-900 flex items-center gap-3">
                        <span>#{{ $reservasi->kode_reservasi }}</span>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $reservasi->kode_reservasi }}'); alert('Kode reservasi disalin!');" title="Salin Kode" class="text-slate-400 hover:text-rose-600 text-sm">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">
                        Dibuat pada: {{ $reservasi->created_at->translatedFormat('l, d F Y - H:i') }} WIB
                    </p>
                </div>

                <!-- Status Badge -->
                <div>
                    @if($reservasi->isMenungguPembayaran())
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-100 text-amber-800 font-bold text-xs border border-amber-300 shadow-xs">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                            <span>Menunggu Pembayaran DP</span>
                        </div>
                    @elseif($reservasi->isDikonfirmasi())
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs border border-emerald-300 shadow-xs">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i>
                            <span>Dikonfirmasi (Jadwal Terkunci)</span>
                        </div>
                    @elseif($reservasi->isSedangDikerjakan())
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-800 font-bold text-xs border border-blue-300 shadow-xs">
                            <i class="fa-solid fa-spinner fa-spin text-blue-600"></i>
                            <span>Sedang Dikerjakan</span>
                        </div>
                    @elseif($reservasi->isSelesai())
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-100 text-purple-800 font-bold text-xs border border-purple-300 shadow-xs">
                            <i class="fa-solid fa-star text-purple-600"></i>
                            <span>Selesai</span>
                        </div>
                    @elseif($reservasi->isDibatalkan())
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 text-red-800 font-bold text-xs border border-red-300 shadow-xs">
                            <i class="fa-solid fa-ban text-red-600"></i>
                            <span>Dibatalkan</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Countdown Timer & Alert for Pending Bookings -->
            @if($reservasi->isMenungguPembayaran() && $reservasi->batas_pembayaran)
                <div class="mt-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-200 text-amber-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold">Batas Waktu Pembayaran DP (24 Jam)</h4>
                            <p class="text-[11px] text-amber-700">
                                Harap transfer dan unggah bukti sebelum: <strong>{{ $reservasi->batas_pembayaran->translatedFormat('d M Y - H:i') }} WIB</strong>
                            </p>
                        </div>
                    </div>

                    <div class="text-center sm:text-right bg-white px-4 py-2 rounded-xl border border-amber-200 shadow-2xs">
                        <span class="text-[10px] uppercase font-bold text-amber-700 block">Sisa Waktu</span>
                        <span id="countdown-timer" class="text-sm font-extrabold text-amber-900 font-mono tracking-wider">
                            Memuat...
                        </span>
                    </div>
                </div>
            @endif

            <!-- Google Calendar Info for Confirmed Bookings -->
            @if($reservasi->isDikonfirmasi())
                <div class="mt-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-200 text-emerald-800 flex items-center justify-center shrink-0">
                        <i class="fa-brands fa-google text-lg"></i>
                    </div>
                    <div class="text-xs leading-relaxed">
                        <strong>Terintegrasi Google Calendar API:</strong> Jadwal Anda telah resmi terkunci di sistem dan tercatat pada Google Calendar Ratna Wedding. Kami akan mengirimkan notifikasi pengingat via WhatsApp pada H-1 acara.
                    </div>
                </div>
            @endif
        </div>

        <!-- Two Columns Layout: Details & Payment -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Column: Booking Summary & Customer Info -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Service & Schedule Card -->
                <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-lg shadow-rose-950/5 border border-white/80 space-y-5">
                    <h3 class="text-base font-serif-heading font-bold text-slate-900 border-b border-rose-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-spa text-rose-500"></i>
                        <span>Rincian Layanan & Waktu</span>
                    </h3>

                    <div class="space-y-4 text-xs">
                        <div class="flex justify-between items-start pb-3 border-b border-slate-100">
                            <div>
                                <span class="text-slate-400 block mb-0.5">Paket Layanan:</span>
                                <h4 class="text-sm font-bold text-slate-900">{{ $reservasi->layanan->nama_layanan }}</h4>
                                <span class="text-[11px] text-slate-500">Kategori: {{ $reservasi->layanan->kategori ?? 'Layanan Salon' }} • Durasi: {{ $reservasi->layanan->formatted_durasi }}</span>
                            </div>
                            <span class="font-bold text-slate-900 text-sm">
                                Rp {{ number_format((float)$reservasi->harga_layanan, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pb-3 border-b border-slate-100">
                            <div>
                                <span class="text-slate-400 block mb-0.5">Tanggal Reservasi:</span>
                                <p class="font-bold text-slate-900 text-sm">
                                    {{ $reservasi->tanggal_reservasi->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                            <div>
                                <span class="text-slate-400 block mb-0.5">Waktu Pengerjaan:</span>
                                <p class="font-bold text-slate-900 text-sm">
                                    {{ substr((string)$reservasi->jam_mulai, 0, 5) }} - {{ substr((string)$reservasi->jam_selesai, 0, 5) }} WIB
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                            <div>
                                <span class="text-slate-400 block mb-0.5">Kapster / Perias:</span>
                                <p class="font-bold text-slate-900 text-sm">
                                    {{ $reservasi->kapster ? $reservasi->kapster->nama_kapster : 'Bebas (Staff yang Tersedia)' }}
                                </p>
                            </div>
                            @if($reservasi->kapster)
                                <span class="text-[11px] text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full border border-rose-100">
                                    {{ $reservasi->kapster->spesialisasi }}
                                </span>
                            @endif
                        </div>

                        @if($reservasi->catatan)
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Catatan Pelanggan:</span>
                                <p class="text-slate-700 italic">{{ $reservasi->catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Price Breakdown Card -->
                <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-lg shadow-rose-950/5 border border-white/80 space-y-4">
                    <h3 class="text-base font-serif-heading font-bold text-slate-900 border-b border-rose-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-rose-500"></i>
                        <span>Rincian Pembayaran</span>
                    </h3>

                    <div class="space-y-2.5 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Harga Layanan Normal:</span>
                            <span class="font-semibold text-slate-900">Rp {{ number_format((float)$reservasi->harga_layanan, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between text-emerald-700 font-semibold">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-crown text-amber-500"></i>
                                Diskon Member ({{ (float)$reservasi->diskon_persen }}%):
                            </span>
                            <span>- Rp {{ number_format((float)$reservasi->potongan_diskon, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between text-sm font-extrabold text-slate-900 pt-3 border-t border-slate-200">
                            <span>Total Tagihan Akhir:</span>
                            <span class="text-rose-700 text-base">{{ $reservasi->formatted_total_bayar }}</span>
                        </div>

                        <div class="flex justify-between text-xs font-bold text-slate-800 bg-rose-50/80 p-3 rounded-xl border border-rose-200 mt-2">
                            <div>
                                <span class="block text-rose-900">Minimal Uang Muka (DP 30%):</span>
                                <span class="text-[10px] font-normal text-rose-600">Pelunasan sisa dapat dibayar saat hari H acara</span>
                            </div>
                            <span class="text-rose-700 text-sm font-extrabold self-center">{{ $reservasi->formatted_nominal_dp }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Payment Transfer & Proof Upload -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Bank Transfer Information Card -->
                <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-lg shadow-rose-950/5 border border-white/80 space-y-4">
                    <h3 class="text-base font-serif-heading font-bold text-slate-900 border-b border-rose-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-rose-500"></i>
                        <span>Rekening Pembayaran DP</span>
                    </h3>

                    <p class="text-xs text-slate-600 leading-relaxed">
                        Silakan lakukan transfer uang muka (DP) sebesar <strong>{{ $reservasi->formatted_nominal_dp }}</strong> ke salah satu rekening resmi Ratna Wedding di bawah ini:
                    </p>

                    <!-- Bank Accounts -->
                    <div class="space-y-3 pt-2">
                        <!-- BCA -->
                        <div class="p-3.5 rounded-2xl bg-white border border-slate-200 flex items-center justify-between shadow-2xs">
                            <div class="space-y-0.5">
                                <span class="text-[11px] font-extrabold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">BANK BCA</span>
                                <p class="text-sm font-mono font-bold text-slate-900">882-019-3829</p>
                                <span class="text-[10px] text-slate-500 block">a.n. Ratna Wedding Salon</span>
                            </div>
                            <button type="button" onclick="navigator.clipboard.writeText('8820193829'); alert('Nomor Rekening BCA disalin!');" class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors" title="Salin">
                                <i class="fa-regular fa-copy"></i>
                            </button>
                        </div>

                        <!-- MANDIRI -->
                        <div class="p-3.5 rounded-2xl bg-white border border-slate-200 flex items-center justify-between shadow-2xs">
                            <div class="space-y-0.5">
                                <span class="text-[11px] font-extrabold text-amber-700 bg-amber-50 px-2 py-0.5 rounded">BANK MANDIRI</span>
                                <p class="text-sm font-mono font-bold text-slate-900">137-00-1928374-1</p>
                                <span class="text-[10px] text-slate-500 block">a.n. Ratna Wedding Salon</span>
                            </div>
                            <button type="button" onclick="navigator.clipboard.writeText('1370019283741'); alert('Nomor Rekening Mandiri disalin!');" class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors" title="Salin">
                                <i class="fa-regular fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Upload Bukti Transfer -->
                <div class="glass-card rounded-3xl p-6 sm:p-7 shadow-lg shadow-rose-950/5 border border-white/80 space-y-4">
                    <h3 class="text-base font-serif-heading font-bold text-slate-900 border-b border-rose-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice-dollar text-rose-500"></i>
                        <span>Unggah Bukti Transfer DP</span>
                    </h3>

                    @if($reservasi->bukti_transfer)
                        <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 space-y-2">
                            <div class="flex items-center gap-2 font-bold">
                                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                <span>Bukti transfer telah terunggah</span>
                            </div>
                            <p class="text-[11px] text-emerald-700">
                                Diunggah pada: {{ $reservasi->tanggal_upload_bukti ? $reservasi->tanggal_upload_bukti->translatedFormat('d M Y - H:i') : '-' }} WIB
                            </p>
                            <a href="{{ asset('storage/' . $reservasi->bukti_transfer) }}" target="_blank" class="inline-flex items-center gap-1 font-bold text-rose-600 hover:underline text-[11px] pt-1">
                                <i class="fa-solid fa-up-right-from-square"></i> Lihat Bukti Foto
                            </a>
                        </div>
                    @endif

                    @if($reservasi->isMenungguPembayaran())
                        <form method="POST" action="{{ route('reservasi.uploadBukti', $reservasi->kode_reservasi) }}" enctype="multipart/form-data" class="space-y-4 pt-1">
                            @csrf
                            <div>
                                <label for="bukti_transfer" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    {{ $reservasi->bukti_transfer ? 'Ganti / Unggah Ulang Bukti Foto' : 'Pilih Foto Bukti Transfer' }} <span class="text-rose-500">*</span>
                                </label>
                                <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/*" required class="block w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 border border-slate-200 rounded-xl bg-white p-1">
                                <span class="text-[10px] text-slate-400 mt-1 block">Format: JPG, PNG, WEBP (Maksimal 3MB)</span>
                            </div>

                            <button type="submit" class="w-full bg-slate-900 hover:bg-rose-700 text-white font-bold text-xs py-3 px-4 rounded-xl shadow-md transition-all">
                                <i class="fa-solid fa-upload mr-1.5"></i>
                                <span>{{ $reservasi->bukti_transfer ? 'Update Bukti Transfer' : 'Kirim Bukti Pembayaran' }}</span>
                            </button>
                        </form>
                    @endif

                    <!-- WhatsApp Quick Contact Button -->
                    <div class="pt-4 border-t border-slate-100">
                        @php
                            $waMessage = urlencode("Halo Admin Ratna Wedding, saya ingin konfirmasi pembayaran DP untuk Kode Reservasi: {$reservasi->kode_reservasi} a.n {$reservasi->user->name}. Layanan: {$reservasi->layanan->nama_layanan} pada tanggal {$reservasi->tanggal_reservasi->format('d/m/Y')}. Mohon bantu dicek ya. Terima kasih!");
                        @endphp
                        <a href="https://wa.me/6281234567890?text={{ $waMessage }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 px-4 rounded-xl shadow-md shadow-emerald-200 transition-all">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                            <span>Konfirmasi ke Admin via WhatsApp</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@if($reservasi->isMenungguPembayaran() && $reservasi->batas_pembayaran)
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deadline = new Date("{{ $reservasi->batas_pembayaran->toIso8601String() }}").getTime();
        const timerEl = document.getElementById('countdown-timer');

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = deadline - now;

            if (distance < 0) {
                timerEl.innerHTML = "<span class='text-red-600'>Waktu Telah Habis</span>";
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            timerEl.innerHTML = `${String(hours).padStart(2, '0')}j ${String(minutes).padStart(2, '0')}m ${String(seconds).padStart(2, '0')}d`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
</script>
@endpush
@endif
@endsection

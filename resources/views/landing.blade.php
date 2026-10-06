@extends('layouts.app')

@section('title', 'Ratna Wedding - Rias Pengantin & Tata Rias Modern Terintegrasi')

@section('content')
<!-- Hero Section -->
<section id="beranda" class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28">
    <!-- Background Luxury Subtle Glow Decor -->
    <div class="absolute top-0 right-0 -mr-24 -mt-24 w-[480px] h-[480px] rounded-full bg-[#7A1F2B]/5 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-[480px] h-[480px] rounded-full bg-[#A8343F]/5 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-center">
            
            <!-- Left Text Content -->
            <div class="lg:col-span-7 space-y-7 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#F7ECE9] border border-[#EADBDB] text-[#7A1F2B] text-xs font-bold tracking-wider uppercase shadow-2xs">
                    <i class="fa-solid fa-sparkles text-[#A8343F]"></i>
                    <span>Sistem Reservasi Resmi • Ratna Wedding</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-[54px] font-serif-heading font-bold text-[#1A1210] leading-[1.18] tracking-tight">
                    Wujudkan Riasan <span class="text-[#7A1F2B] italic font-normal">Pengantin Impian</span> yang Anggun & Abadi
                </h1>

                <p class="text-base sm:text-lg text-[#5A4D4A] leading-relaxed max-w-2xl mx-auto lg:mx-0 font-normal">
                    Tata rias pengantin adat tradisional & modern dengan jadwal terintegrasi real-time. Bebas jadwal bentrok dengan sinkronisasi <strong>Google Calendar API</strong> dan notifikasi instan <strong>WhatsApp Gateway</strong>.
                </p>

                <!-- Action CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('reservasi.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-[#7A1F2B] hover:bg-[#5E1620] text-white font-bold text-base px-8 py-4 rounded-full shadow-lg shadow-[#7A1F2B]/25 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-calendar-check text-sm text-[#F7ECE9]"></i>
                        <span>Reservasi Jadwal Sekarang</span>
                    </a>
                    <a href="#layanan" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white hover:bg-[#FAF6F3] text-[#1A1210] hover:text-[#7A1F2B] font-bold text-base px-7 py-4 rounded-full border border-[#EADBDB] shadow-2xs transition-all">
                        <i class="fa-solid fa-eye text-[#7A1F2B]"></i>
                        <span>Lihat Paket Layanan</span>
                    </a>
                </div>

                <!-- 3 Feature Highlight Badges in Structured Small Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 pt-6 border-t border-[#EADBDB] max-w-2xl mx-auto lg:mx-0">
                    <!-- Feature Card 1 -->
                    <div class="bg-white/95 border border-[#EADBDB] hover:border-[#A8343F]/50 rounded-2xl p-3.5 shadow-2xs flex items-center gap-3 transition-colors text-left">
                        <div class="w-9 h-9 rounded-xl bg-[#F7ECE9] text-[#7A1F2B] flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-[#1A1210] block leading-tight">Notifikasi WA Otomatis</span>
                            <span class="text-[10px] text-[#705F5B]">WhatsApp Gateway</span>
                        </div>
                    </div>

                    <!-- Feature Card 2 -->
                    <div class="bg-white/95 border border-[#EADBDB] hover:border-[#A8343F]/50 rounded-2xl p-3.5 shadow-2xs flex items-center gap-3 transition-colors text-left">
                        <div class="w-9 h-9 rounded-xl bg-[#F7ECE9] text-[#7A1F2B] flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-brands fa-google"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-[#1A1210] block leading-tight">Google Calendar Sync</span>
                            <span class="text-[10px] text-[#705F5B]">Anti Jadwal Bentrok</span>
                        </div>
                    </div>

                    <!-- Feature Card 3 -->
                    <div class="bg-white/95 border border-[#EADBDB] hover:border-[#A8343F]/50 rounded-2xl p-3.5 shadow-2xs flex items-center gap-3 transition-colors text-left">
                        <div class="w-9 h-9 rounded-xl bg-[#F7ECE9] text-[#7A1F2B] flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-solid fa-crown text-[#A8343F]"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-[#1A1210] block leading-tight">Diskon Member Loyal</span>
                            <span class="text-[10px] text-[#705F5B]">Potongan Otomatis</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Hero Visual Card ("Studio Reservasi") -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <!-- Luxury Studio Reservation Card with Refined Spacing -->
                    <div class="glass-luxury-card rounded-3xl p-7 sm:p-9 shadow-xl shadow-[#1A1210]/10 border border-[#EADBDB] relative overflow-hidden space-y-6">
                        
                        <!-- Header of Card -->
                        <div class="flex items-center justify-between pb-5 border-b border-[#EADBDB]">
                            <div>
                                <span class="text-[11px] uppercase tracking-widest text-[#7A1F2B] font-bold block">Studio Reservasi</span>
                                <h3 class="text-xl font-serif-heading font-bold text-[#1A1210] mt-0.5">Jadwal Rias Pengantin</h3>
                            </div>
                            <span class="px-3.5 py-1.5 rounded-full bg-[#F7ECE9] text-[#7A1F2B] text-xs font-bold border border-[#EADBDB] flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#A8343F] animate-pulse"></span>
                                Slot Terbuka
                            </span>
                        </div>

                        <!-- Sample Highlight Items with Generous Padding -->
                        <div class="space-y-3.5">
                            <!-- Item 1 -->
                            <div class="p-4 rounded-2xl bg-white border border-[#EADBDB] hover:border-[#A8343F]/40 flex items-center justify-between shadow-2xs transition-colors">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-xl bg-[#F7ECE9] text-[#7A1F2B] flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-wand-magic-sparkles text-sm"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-[#1A1210]">Rias Muslim & Modern</h4>
                                        <p class="text-[11px] text-[#705F5B]">Durasi: 180 Menit • Lengkap</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-[#7A1F2B]">Rp 3.500.000</span>
                            </div>

                            <!-- Item 2 -->
                            <div class="p-4 rounded-2xl bg-white border border-[#EADBDB] hover:border-[#A8343F]/40 flex items-center justify-between shadow-2xs transition-colors">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-xl bg-[#F7ECE9] text-[#7A1F2B] flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-crown text-[#A8343F]"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-[#1A1210]">Rias Tradisional Paes</h4>
                                        <p class="text-[11px] text-[#705F5B]">Solo Putri / Jogja / Sunda</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-[#7A1F2B]">Rp 4.500.000</span>
                            </div>

                            <!-- Item 3: Member Perk Callout -->
                            <div class="p-4 rounded-2xl bg-[#F7ECE9] border border-[#EADBDB] flex items-center justify-between">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-xl bg-[#7A1F2B] text-white flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-tags text-sm text-[#F7ECE9]"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-[#1A1210]">Keuntungan Member</h4>
                                        <p class="text-[11px] text-[#7A1F2B] font-semibold">Diskon Otomatis s/d 15%</p>
                                    </div>
                                </div>
                                <span class="text-[11px] px-3 py-1 rounded-full bg-white text-[#7A1F2B] font-bold border border-[#EADBDB]">Aktif</span>
                            </div>
                        </div>

                        <!-- CTA inside Card -->
                        <div class="pt-2">
                            <a href="{{ route('reservasi.index') }}" class="block w-full text-center bg-[#1A1210] hover:bg-[#7A1F2B] text-white font-bold text-xs py-3.5 rounded-xl transition-all shadow-md">
                                Cek Ketersediaan Tanggal & Jam &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Section Katalog Layanan -->
<section id="layanan" class="py-20 bg-white/90 backdrop-blur-md relative border-y border-[#EADBDB]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-[#7A1F2B] px-3.5 py-1.5 rounded-full bg-[#F7ECE9] border border-[#EADBDB]">
                Pilihan Paket Rias
            </span>
            <h2 class="text-3xl sm:text-4xl font-serif-heading font-bold text-[#1A1210]">
                Layanan & Tata Rias Ratna Wedding
            </h2>
            <p class="text-sm sm:text-base text-[#5A4D4A]">
                Setiap paket dirancang dengan produk kosmetik premium berkualitas tinggi dan ditangani oleh kapster berpengalaman.
            </p>
        </div>

        <!-- Service Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($layanans as $layanan)
                <div class="bg-[#FAF6F3] rounded-3xl p-7 border border-[#EADBDB] shadow-md hover:shadow-xl hover:border-[#7A1F2B]/40 transition-all flex flex-col justify-between group">
                    <div>
                        <!-- Category Badge & Duration -->
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="inline-block px-3 py-1 rounded-full bg-white text-[#7A1F2B] text-[11px] font-bold border border-[#EADBDB] uppercase tracking-wider">
                                {{ $layanan->kategori ?? 'Layanan Salon' }}
                            </span>
                            <span class="text-xs font-medium text-[#705F5B] flex items-center gap-1.5 bg-white px-2.5 py-1 rounded-lg border border-[#EADBDB]">
                                <i class="fa-regular fa-clock text-[#7A1F2B]"></i>
                                {{ $layanan->formatted_durasi }}
                            </span>
                        </div>

                        <!-- Service Title -->
                        <h3 class="text-xl font-serif-heading font-bold text-[#1A1210] group-hover:text-[#7A1F2B] transition-colors mb-3">
                            {{ $layanan->nama_layanan }}
                        </h3>

                        <!-- Description -->
                        <p class="text-xs text-[#5A4D4A] leading-relaxed mb-6">
                            {{ $layanan->deskripsi }}
                        </p>
                    </div>

                    <div class="pt-6 border-t border-[#EADBDB] mt-4">
                        <div class="flex items-baseline justify-between mb-4">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-[#8A7975] block">Biaya Layanan</span>
                                <span class="text-2xl font-bold text-[#1A1210]">
                                    {{ $layanan->formatted_harga }}
                                </span>
                            </div>
                            <span class="text-[10px] text-[#7A1F2B] font-bold bg-[#F7ECE9] px-2.5 py-1 rounded-full border border-[#EADBDB]">
                                Diskon Member Berlaku
                            </span>
                        </div>

                        <a href="{{ route('reservasi.index', ['layanan_id' => $layanan->id]) }}" class="w-full inline-flex items-center justify-center gap-2 bg-[#7A1F2B] hover:bg-[#5E1620] text-white text-xs font-bold py-3.5 px-4 rounded-xl shadow-md transition-all">
                            <span>Pilih & Booking Jadwal</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-[#8A7975]">
                    <i class="fa-solid fa-sparkles text-4xl text-[#7A1F2B] mb-3 block"></i>
                    Belum ada data layanan yang tersedia.
                </div>
            @endforelse
        </div>

    </div>
</section>

<!-- Section Membership & Diskon Loyalitas -->
<section id="membership" class="py-20 bg-gradient-to-b from-transparent via-[#F7ECE9]/50 to-transparent relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-[#7A1F2B] px-3.5 py-1.5 rounded-full bg-[#F7ECE9] border border-[#EADBDB]">
                <i class="fa-solid fa-crown text-[#A8343F] mr-1"></i> Program Loyalitas Pelanggan
            </span>
            <h2 class="text-3xl sm:text-4xl font-serif-heading font-bold text-[#1A1210]">
                Skema Tier Membership & Diskon
            </h2>
            <p class="text-sm sm:text-base text-[#5A4D4A]">
                Sistem otomatis menghitung jumlah reservasi selesai Anda dan meningkatkan status member Anda dengan potongan harga otomatis.
            </p>
        </div>

        <!-- Tier Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($membershipTiers as $tier)
                <div class="bg-white rounded-3xl p-6 border-2 border-[#EADBDB] hover:border-[#7A1F2B] transition-all hover:scale-105 shadow-md flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-[#7A1F2B]/10"></div>
                    
                    <div>
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-xs mb-4 bg-[#7A1F2B]">
                            <i class="fa-solid fa-award"></i>
                        </div>

                        <h3 class="text-xl font-serif-heading font-bold text-[#1A1210] mb-1">
                            {{ $tier->nama_tier }}
                        </h3>

                        <div class="my-4">
                            <span class="text-3xl font-extrabold text-[#1A1210]">
                                {{ (float)$tier->diskon_persen }}%
                            </span>
                            <span class="text-xs font-bold text-[#7A1F2B] block">Potongan Diskon Otomatis</span>
                        </div>

                        <p class="text-xs text-[#5A4D4A] leading-relaxed mb-4">
                            {{ $tier->deskripsi }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-[#EADBDB]">
                        <span class="text-[11px] font-semibold text-[#705F5B] flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-[#7A1F2B] text-xs"></i>
                            Syarat: {{ $tier->min_reservasi == 0 ? 'Member Baru Terdaftar' : "Minimal {$tier->min_reservasi}x reservasi selesai" }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- Section Tim Kapster / Perias -->
<section id="kapster" class="py-20 bg-white/90 backdrop-blur-md border-t border-[#EADBDB]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-[#7A1F2B] px-3.5 py-1.5 rounded-full bg-[#F7ECE9] border border-[#EADBDB]">
                Staff Profesional
            </span>
            <h2 class="text-3xl sm:text-4xl font-serif-heading font-bold text-[#1A1210]">
                Tim Kapster & MUA Ratna Wedding
            </h2>
            <p class="text-sm sm:text-base text-[#5A4D4A]">
                Didukung oleh tenaga ahli tata rias bersertifikat nasional yang berdedikasi memberikan hasil riasan terbaik.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            @foreach($kapsters as $k)
                <div class="bg-[#FAF6F3] rounded-3xl p-7 border border-[#EADBDB] shadow-md flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-gradient-to-tr from-[#7A1F2B] via-[#942C39] to-[#1A1210] flex items-center justify-center text-[#FAF6F3] text-3xl font-serif-heading font-bold shadow-md shrink-0">
                        {{ substr($k->nama_kapster, 0, 1) }}
                    </div>

                    <div class="space-y-2 text-center sm:text-left flex-1">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                            <h3 class="text-lg font-bold text-[#1A1210]">{{ $k->nama_kapster }}</h3>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-[#7A1F2B] bg-[#F7ECE9] px-2.5 py-1 rounded-full border border-[#EADBDB]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#A8343F]"></span>
                                Siap Ditugaskan
                            </span>
                        </div>
                        <p class="text-xs font-bold text-[#7A1F2B]">
                            {{ $k->spesialisasi }}
                        </p>
                        <p class="text-xs text-[#5A4D4A] leading-relaxed">
                            {{ $k->bio }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- Section Alur Reservasi & Otomasi -->
<section class="py-20 bg-gradient-to-tr from-[#1A1210] via-[#2A1618] to-[#1A1210] text-[#FAF6F3] relative overflow-hidden border-t border-[#332420]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
            <span class="text-xs font-bold uppercase tracking-widest text-[#EADBDB] px-3.5 py-1.5 rounded-full bg-white/10 border border-white/20">
                Alur & Otomasi Sistem
            </span>
            <h2 class="text-3xl sm:text-4xl font-serif-heading font-bold text-[#FAF6F3]">
                4 Langkah Mudah Reservasi Online
            </h2>
            <p class="text-sm sm:text-base text-[#D8CCC8]">
                Proses cepat, transparan, dan terintegrasi otomatis dengan Google Calendar & WhatsApp.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Step 1 -->
            <div class="p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md space-y-3">
                <span class="text-3xl font-serif-heading font-extrabold text-[#EADBDB]">01</span>
                <h3 class="text-base font-bold text-[#FAF6F3]">Pilih Paket Layanan</h3>
                <p class="text-xs text-[#B5A5A0] leading-relaxed">
                    Pilih paket rias pengantin atau makeup sesuai kebutuhan Anda beserta estimasi durasinya.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md space-y-3">
                <span class="text-3xl font-serif-heading font-extrabold text-[#EADBDB]">02</span>
                <h3 class="text-base font-bold text-[#FAF6F3]">Pilih Jadwal Kosong</h3>
                <p class="text-xs text-[#B5A5A0] leading-relaxed">
                    Lihat kalender jadwal real-time untuk memilih tanggal dan jam mulai yang masih tersedia.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md space-y-3">
                <span class="text-3xl font-serif-heading font-extrabold text-[#EADBDB]">03</span>
                <h3 class="text-base font-bold text-[#FAF6F3]">Transfer DP & Notifikasi WA</h3>
                <p class="text-xs text-[#B5A5A0] leading-relaxed">
                    Sistem otomatis mengirim info rekening via WhatsApp. Unggah bukti bayar dalam 24 jam.
                </p>
            </div>

            <!-- Step 4 -->
            <div class="p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md space-y-3">
                <span class="text-3xl font-serif-heading font-extrabold text-[#EADBDB]">04</span>
                <h3 class="text-base font-bold text-[#FAF6F3]">Konfirmasi & Google Calendar</h3>
                <p class="text-xs text-[#B5A5A0] leading-relaxed">
                    Admin verifikasi DP &rarr; sistem mengunci tanggal dan membuat event Google Calendar resmi!
                </p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('reservasi.index') }}" class="inline-flex items-center gap-3 bg-[#7A1F2B] hover:bg-[#5E1620] text-white font-bold text-sm px-8 py-4 rounded-full shadow-xl transition-all transform hover:scale-105">
                <i class="fa-solid fa-calendar-plus text-[#F7ECE9]"></i>
                <span>Mulai Reservasi Jadwal</span>
            </a>
        </div>

    </div>
</section>
@endsection

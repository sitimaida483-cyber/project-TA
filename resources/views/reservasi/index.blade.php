@extends('layouts.app')

@section('title', 'Form Reservasi Jadwal - Ratna Wedding')

@section('content')
<div class="py-10 sm:py-16 px-4">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header Banner -->
        <div class="text-center space-y-3 mb-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-100 text-rose-800 text-xs font-bold uppercase tracking-wider">
                <i class="fa-solid fa-calendar-days text-rose-600"></i>
                <span>Reservasi Online Mandiri</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-serif-heading font-bold text-slate-900">
                Pilih Layanan & Jadwal Rias
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 max-w-xl mx-auto">
                Silakan pilih paket, kapster, dan tanggal yang diinginkan. Sistem akan menampilkan jam yang masih tersedia secara real-time.
            </p>
        </div>

        <!-- Member Tier Banner if logged in -->
        @auth
            @if(Auth::user()->membershipTier)
                <div class="mb-8 p-4 sm:p-5 rounded-3xl bg-gradient-to-r from-rose-500 via-pink-600 to-amber-500 text-white shadow-lg shadow-rose-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-2xl shrink-0">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-base">{{ Auth::user()->name }}</span>
                                <span class="text-[11px] font-extrabold uppercase px-2.5 py-0.5 rounded-full bg-white text-rose-700 shadow-xs">
                                    {{ Auth::user()->membershipTier->nama_tier }} Member
                                </span>
                            </div>
                            <p class="text-xs text-rose-100 mt-0.5">
                                Anda berhak mendapatkan <strong>potongan diskon {{ (float)Auth::user()->membershipTier->diskon_persen }}%</strong> pada pemesanan ini!
                            </p>
                        </div>
                    </div>

                    <div class="text-center sm:text-right shrink-0 bg-white/10 px-4 py-2 rounded-2xl backdrop-blur-md">
                        <span class="text-[10px] uppercase font-bold text-rose-200 block">Total Reservasi Selesai</span>
                        <span class="text-xl font-extrabold text-white">{{ Auth::user()->total_reservasi_selesai }}x</span>
                    </div>
                </div>
            @endif
        @endauth

        <!-- Main Booking Form Card -->
        <form id="booking-form" method="POST" action="{{ route('reservasi.store') }}" class="glass-card rounded-3xl p-6 sm:p-10 shadow-2xl shadow-rose-950/10 border border-white/80 space-y-8">
            @csrf

            <!-- STEP 1: Pilih Layanan -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 border-b border-rose-100 pb-3">
                    <span class="w-7 h-7 rounded-full bg-rose-600 text-white text-xs font-bold flex items-center justify-center">1</span>
                    <h3 class="text-lg font-serif-heading font-bold text-slate-900">
                        Pilih Paket Layanan Rias
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="layanan-grid">
                    @foreach($layanans as $layanan)
                        <label class="layanan-card relative flex flex-col justify-between p-4 rounded-2xl border-2 cursor-pointer transition-all {{ ($selectedLayananId == $layanan->id || (!old('layanan_id') && $loop->first && !$selectedLayananId) || old('layanan_id') == $layanan->id) ? 'border-rose-500 bg-rose-50/50 shadow-md ring-2 ring-rose-200' : 'border-slate-200 hover:border-rose-200 bg-white' }}">
                            <input type="radio" name="layanan_id" value="{{ $layanan->id }}" data-price="{{ $layanan->harga }}" data-duration="{{ $layanan->durasi_menit }}" data-name="{{ $layanan->nama_layanan }}" class="sr-only layanan-radio" {{ ($selectedLayananId == $layanan->id || (!old('layanan_id') && $loop->first && !$selectedLayananId) || old('layanan_id') == $layanan->id) ? 'checked' : '' }}>
                            
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] uppercase font-bold text-rose-600 bg-rose-100 px-2 py-0.5 rounded-md">
                                        {{ $layanan->kategori ?? 'Paket' }}
                                    </span>
                                    <span class="text-xs font-medium text-slate-500">
                                        <i class="fa-regular fa-clock mr-1 text-rose-400"></i>{{ $layanan->formatted_durasi }}
                                    </span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 mb-1">{{ $layanan->nama_layanan }}</h4>
                                <p class="text-xs text-slate-500 line-clamp-2">{{ $layanan->deskripsi }}</p>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-sm font-extrabold text-slate-900">{{ $layanan->formatted_harga }}</span>
                                <span class="check-icon text-rose-600 text-sm {{ ($selectedLayananId == $layanan->id || (!old('layanan_id') && $loop->first && !$selectedLayananId) || old('layanan_id') == $layanan->id) ? 'opacity-100' : 'opacity-0' }}">
                                    <i class="fa-solid fa-circle-check"></i>
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- STEP 2: Pilih Kapster (Opsional) -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 border-b border-rose-100 pb-3">
                    <span class="w-7 h-7 rounded-full bg-rose-600 text-white text-xs font-bold flex items-center justify-center">2</span>
                    <h3 class="text-lg font-serif-heading font-bold text-slate-900">
                        Preferensi Kapster / Staf Perias (Opsional)
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Opsi Bebas / Siapa Saja -->
                    <label class="kapster-card relative p-4 rounded-2xl border-2 cursor-pointer transition-all {{ !old('kapster_id') ? 'border-rose-500 bg-rose-50/50 shadow-md ring-2 ring-rose-200' : 'border-slate-200 bg-white' }}">
                        <input type="radio" name="kapster_id" value="" class="sr-only kapster-radio" {{ !old('kapster_id') ? 'checked' : '' }}>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-sm font-bold shrink-0">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">Bebas / Tersedia</h4>
                                <p class="text-[10px] text-slate-500">Kapster yang siap</p>
                            </div>
                        </div>
                    </label>

                    @foreach($kapsters as $kapster)
                        <label class="kapster-card relative p-4 rounded-2xl border-2 cursor-pointer transition-all {{ old('kapster_id') == $kapster->id ? 'border-rose-500 bg-rose-50/50 shadow-md ring-2 ring-rose-200' : 'border-slate-200 bg-white' }}">
                            <input type="radio" name="kapster_id" value="{{ $kapster->id }}" class="sr-only kapster-radio" {{ old('kapster_id') == $kapster->id ? 'checked' : '' }}>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-rose-400 to-pink-500 text-white flex items-center justify-center text-sm font-bold shrink-0">
                                    {{ substr($kapster->nama_kapster, 0, 1) }}
                                </div>
                                <div class="truncate">
                                    <h4 class="text-xs font-bold text-slate-900 truncate">{{ $kapster->nama_kapster }}</h4>
                                    <p class="text-[10px] text-rose-600 truncate">{{ $kapster->spesialisasi }}</p>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- STEP 3: Pilih Tanggal & Kalender Jam Tersedia -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 border-b border-rose-100 pb-3">
                    <span class="w-7 h-7 rounded-full bg-rose-600 text-white text-xs font-bold flex items-center justify-center">3</span>
                    <h3 class="text-lg font-serif-heading font-bold text-slate-900">
                        Pilih Tanggal & Jam Reservasi
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <!-- Date Input -->
                    <div class="md:col-span-5 space-y-2">
                        <label for="tanggal_reservasi" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Tanggal Reservasi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="date" name="tanggal_reservasi" id="tanggal_reservasi" min="{{ $minDate }}" max="{{ $maxDate }}" value="{{ old('tanggal_reservasi', $minDate) }}" required class="w-full px-4 py-3 text-sm font-semibold bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 shadow-xs">
                        </div>
                        <p class="text-[11px] text-slate-500 flex items-center gap-1">
                            <i class="fa-solid fa-circle-info text-rose-500"></i>
                            Pilih tanggal untuk memuat slot jam real-time.
                        </p>
                    </div>

                    <!-- Time Slots Grid -->
                    <div class="md:col-span-7 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Pilih Jam Mulai <span class="text-rose-500">*</span>
                            </label>
                            <span id="slot-loading" class="hidden text-xs text-rose-600 font-semibold items-center gap-1">
                                <i class="fa-solid fa-spinner fa-spin"></i> Memuat jadwal...
                            </span>
                        </div>

                        <!-- Slots Container -->
                        <div id="slots-container" class="grid grid-cols-3 sm:grid-cols-4 gap-2.5 pt-1">
                            <!-- Populated via JS -->
                        </div>
                        <input type="hidden" name="jam_mulai" id="selected_jam_mulai" value="{{ old('jam_mulai') }}" required>

                        <!-- Slot Legend -->
                        <div class="flex items-center gap-4 pt-3 text-[11px] text-slate-500">
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-rose-50 border border-rose-300"></span>
                                Tersedia
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-slate-200 border border-slate-300"></span>
                                Sudah Terisi (Kunci)
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-rose-600"></span>
                                Pilihan Anda
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 4: Catatan & Kalkulasi Total -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 border-b border-rose-100 pb-3">
                    <span class="w-7 h-7 rounded-full bg-rose-600 text-white text-xs font-bold flex items-center justify-center">4</span>
                    <h3 class="text-lg font-serif-heading font-bold text-slate-900">
                        Rincian Biaya & Catatan Tambahan
                    </h3>
                </div>

                <!-- Catatan Textarea -->
                <div>
                    <label for="catatan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Catatan Tambahan (Opsional)
                    </label>
                    <textarea name="catatan" id="catatan" rows="2" placeholder="Contoh: Lokasi rias di rumah, preferensi hijab warna rose gold, dll." class="w-full px-4 py-3 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 shadow-xs">{{ old('catatan') }}</textarea>
                </div>

                <!-- Live Price Calculation Box -->
                <div class="p-6 rounded-2xl bg-gradient-to-br from-rose-50 via-pink-50 to-amber-50 border border-rose-200/80 space-y-3">
                    <h4 class="text-xs uppercase font-bold text-slate-700 tracking-wider">
                        Ringkasan Pembayaran
                    </h4>

                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Layanan yang Dipilih:</span>
                            <span id="calc-layanan-name" class="font-bold text-slate-900">-</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Estimasi Durasi:</span>
                            <span id="calc-durasi" class="font-semibold text-slate-800">-</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Harga Standar Layanan:</span>
                            <span id="calc-harga-asli" class="font-semibold text-slate-800">Rp 0</span>
                        </div>
                        
                        <div class="flex justify-between text-emerald-700 font-semibold pt-1 border-t border-rose-200/60">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-crown text-amber-500 text-xs"></i>
                                Diskon Member (<span id="calc-diskon-persen">{{ Auth::user()->membershipTier ? (float)Auth::user()->membershipTier->diskon_persen : 0 }}</span>%):
                            </span>
                            <span id="calc-potongan-diskon">- Rp 0</span>
                        </div>

                        <div class="flex justify-between text-base font-extrabold text-slate-900 pt-2 border-t border-rose-300">
                            <span>Total Biaya Akhir:</span>
                            <span id="calc-total-bayar" class="text-rose-700 text-lg">Rp 0</span>
                        </div>

                        <div class="flex justify-between text-xs font-bold text-slate-700 bg-white/70 p-2.5 rounded-xl border border-rose-200">
                            <span>Nominal DP (Down Payment 30%):</span>
                            <span id="calc-nominal-dp" class="text-rose-600 font-extrabold">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" id="btn-submit-booking" class="w-full bg-gradient-to-r from-rose-600 via-pink-600 to-rose-700 hover:from-rose-700 hover:to-pink-700 text-white font-bold text-base py-4 px-6 rounded-2xl shadow-xl shadow-rose-300 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                    <i class="fa-solid fa-check-circle text-lg"></i>
                    <span>Konfirmasi & Buat Reservasi</span>
                </button>
                <p class="text-center text-[11px] text-slate-500 mt-2">
                    Setelah booking dibuat, status berstatus "Menunggu Pembayaran". Anda memiliki 24 jam untuk transfer DP sebelum tanggal kembali terbuka untuk pelanggan lain.
                </p>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userDiscountPercent = {{ Auth::user()->membershipTier ? (float)Auth::user()->membershipTier->diskon_persen : 0 }};
        const tanggalInput = document.getElementById('tanggal_reservasi');
        const slotsContainer = document.getElementById('slots-container');
        const slotLoading = document.getElementById('slot-loading');
        const selectedJamInput = document.getElementById('selected_jam_mulai');
        
        // Layanan selection handler
        const layananRadios = document.querySelectorAll('.layanan-radio');
        const layananCards = document.querySelectorAll('.layanan-card');

        function updatePriceCalculation() {
            const checkedLayanan = document.querySelector('.layanan-radio:checked');
            if (!checkedLayanan) return;

            const price = parseFloat(checkedLayanan.dataset.price || 0);
            const duration = checkedLayanan.dataset.duration || 60;
            const name = checkedLayanan.dataset.name || '';

            const discountAmount = (price * userDiscountPercent) / 100;
            const finalPrice = price - discountAmount;
            const dpAmount = finalPrice * 0.3;

            document.getElementById('calc-layanan-name').textContent = name;
            document.getElementById('calc-durasi').textContent = duration + ' Menit';
            document.getElementById('calc-harga-asli').textContent = 'Rp ' + price.toLocaleString('id-ID');
            document.getElementById('calc-potongan-diskon').textContent = '- Rp ' + discountAmount.toLocaleString('id-ID');
            document.getElementById('calc-total-bayar').textContent = 'Rp ' + finalPrice.toLocaleString('id-ID');
            document.getElementById('calc-nominal-dp').textContent = 'Rp ' + dpAmount.toLocaleString('id-ID');
        }

        layananRadios.forEach((radio, index) => {
            radio.addEventListener('change', function() {
                layananCards.forEach(c => {
                    c.classList.remove('border-rose-500', 'bg-rose-50/50', 'shadow-md', 'ring-2', 'ring-rose-200');
                    c.classList.add('border-slate-200', 'bg-white');
                    const icon = c.querySelector('.check-icon');
                    if (icon) icon.classList.replace('opacity-100', 'opacity-0');
                });

                if (this.checked) {
                    const parentCard = this.closest('.layanan-card');
                    parentCard.classList.remove('border-slate-200', 'bg-white');
                    parentCard.classList.add('border-rose-500', 'bg-rose-50/50', 'shadow-md', 'ring-2', 'ring-rose-200');
                    const icon = parentCard.querySelector('.check-icon');
                    if (icon) icon.classList.replace('opacity-0', 'opacity-100');
                }

                updatePriceCalculation();
                fetchAvailableSlots();
            });
        });

        // Kapster selection handler
        const kapsterRadios = document.querySelectorAll('.kapster-radio');
        const kapsterCards = document.querySelectorAll('.kapster-card');

        kapsterRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                kapsterCards.forEach(c => {
                    c.classList.remove('border-rose-500', 'bg-rose-50/50', 'shadow-md', 'ring-2', 'ring-rose-200');
                    c.classList.add('border-slate-200', 'bg-white');
                });
                if (this.checked) {
                    const parent = this.closest('.kapster-card');
                    parent.classList.remove('border-slate-200', 'bg-white');
                    parent.classList.add('border-rose-500', 'bg-rose-50/50', 'shadow-md', 'ring-2', 'ring-rose-200');
                }
                fetchAvailableSlots();
            });
        });

        // Fetch slots via AJAX
        function fetchAvailableSlots() {
            const tanggal = tanggalInput.value;
            if (!tanggal) return;

            const kapsterChecked = document.querySelector('.kapster-radio:checked');
            const kapsterId = kapsterChecked ? kapsterChecked.value : '';

            slotLoading.classList.remove('hidden');
            slotLoading.classList.add('inline-flex');

            const url = `{{ route('reservasi.checkSlots') }}?tanggal=${tanggal}&kapster_id=${kapsterId}`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    slotLoading.classList.add('hidden');
                    slotLoading.classList.remove('inline-flex');
                    renderSlots(data.slots);
                })
                .catch(err => {
                    slotLoading.classList.add('hidden');
                    slotLoading.classList.remove('inline-flex');
                    console.error('Gagal mengambil slot:', err);
                });
        }

        function renderSlots(slots) {
            slotsContainer.innerHTML = '';
            const currentSelected = selectedJamInput.value;

            if (!slots || slots.length === 0) {
                slotsContainer.innerHTML = '<p class="col-span-4 text-xs text-slate-400 py-3">Tidak ada jadwal operasional pada tanggal ini.</p>';
                return;
            }

            slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = `p-2.5 rounded-xl text-xs font-bold border transition-all text-center flex flex-col items-center justify-center `;

                if (slot.available) {
                    if (currentSelected === slot.time) {
                        btn.className += 'bg-rose-600 text-white border-rose-600 shadow-md ring-2 ring-rose-300';
                    } else {
                        btn.className += 'bg-white hover:bg-rose-50 text-slate-800 border-slate-200 hover:border-rose-300 shadow-2xs';
                    }

                    btn.innerHTML = `<span>${slot.time}</span><span class="text-[9px] font-normal text-emerald-600">Tersedia</span>`;

                    btn.addEventListener('click', function() {
                        selectedJamInput.value = slot.time;
                        renderSlots(slots);
                    });
                } else {
                    btn.disabled = true;
                    btn.className += 'bg-slate-100 text-slate-400 border-slate-200 cursor-not-allowed opacity-60';
                    btn.innerHTML = `<span>${slot.time}</span><span class="text-[9px] font-normal text-slate-400">Penuh</span>`;
                    btn.title = slot.reason || 'Jadwal telah terisi';
                }

                slotsContainer.appendChild(btn);
            });
        }

        tanggalInput.addEventListener('change', fetchAvailableSlots);

        // Initial setup
        updatePriceCalculation();
        fetchAvailableSlots();
    });
</script>
@endpush
@endsection

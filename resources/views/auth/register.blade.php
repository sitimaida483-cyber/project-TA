@extends('layouts.app')

@section('title', 'Daftar Member Baru - Ratna Wedding')

@section('content')
<div class="py-12 sm:py-16 px-4">
    <div class="max-w-xl mx-auto">
        
        <!-- Register Card -->
        <div class="glass-luxury-card rounded-3xl p-8 sm:p-10 shadow-2xl shadow-[#1A1210]/10 border border-[#EADBDB]">
            <div class="text-center space-y-2 mb-8">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#7A1F2B] via-[#942C39] to-[#1A1210] text-white flex items-center justify-center mx-auto shadow-md shadow-[#7A1F2B]/20">
                    <i class="fa-solid fa-crown text-xl text-[#F7ECE9]"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-serif-heading font-bold text-[#1A1210]">
                    Daftar Member Ratna Wedding
                </h1>
                <p class="text-xs sm:text-sm text-[#5A4D4A]">
                    Daftar sekarang untuk kemudahan reservasi jadwal & nikmati diskon loyalitas otomatis hingga 15%.
                </p>
            </div>

            <!-- Loyalty Benefit Alert in Terracotta/Copper tone -->
            <div class="mb-6 p-4 rounded-2xl bg-[#F7ECE9] border border-[#EADBDB] flex items-start gap-3">
                <i class="fa-solid fa-gift text-[#7A1F2B] text-lg mt-0.5"></i>
                <div class="text-xs text-[#5E1620] leading-relaxed">
                    <strong>Keuntungan Member:</strong> Setiap reservasi selesai dihitung otomatis oleh sistem untuk menaikkan tier membership Anda (Silver, Gold, Platinum) dengan diskon langsung!
                </div>
            </div>

            <!-- Form Registrasi -->
            <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[#1A1210] mb-1.5">
                        Nama Lengkap <span class="text-[#7A1F2B]">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#8A7975]">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Nama Lengkap Anda" class="w-full pl-10 pr-4 py-3 text-sm bg-white border border-[#EADBDB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7A1F2B] focus:border-[#7A1F2B] shadow-2xs transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#1A1210] mb-1.5">
                            Alamat Email <span class="text-[#7A1F2B]">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#8A7975]">
                                <i class="fa-solid fa-envelope text-sm"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="contoh@gmail.com" class="w-full pl-10 pr-4 py-3 text-sm bg-white border border-[#EADBDB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7A1F2B] focus:border-[#7A1F2B] shadow-2xs transition-all">
                        </div>
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div>
                        <label for="no_hp" class="block text-xs font-bold uppercase tracking-wider text-[#1A1210] mb-1.5">
                            Nomor WhatsApp <span class="text-[#7A1F2B]">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#7A1F2B]">
                                <i class="fa-brands fa-whatsapp text-base"></i>
                            </div>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required placeholder="08123456789" class="w-full pl-10 pr-4 py-3 text-sm bg-white border border-[#EADBDB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7A1F2B] focus:border-[#7A1F2B] shadow-2xs transition-all">
                        </div>
                        <span class="text-[10px] text-[#705F5B] mt-1 block">Untuk notifikasi rekening DP & pengingat jadwal</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#1A1210] mb-1.5">
                            Password <span class="text-[#7A1F2B]">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#8A7975]">
                                <i class="fa-solid fa-key text-sm"></i>
                            </div>
                            <input type="password" name="password" id="password" required placeholder="Minimal 6 karakter" class="w-full pl-10 pr-4 py-3 text-sm bg-white border border-[#EADBDB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7A1F2B] focus:border-[#7A1F2B] shadow-2xs transition-all">
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-[#1A1210] mb-1.5">
                            Ulangi Password <span class="text-[#7A1F2B]">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#8A7975]">
                                <i class="fa-solid fa-shield-check text-sm"></i>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi password" class="w-full pl-10 pr-4 py-3 text-sm bg-white border border-[#EADBDB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7A1F2B] focus:border-[#7A1F2B] shadow-2xs transition-all">
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-xs font-bold uppercase tracking-wider text-[#1A1210] mb-1.5">
                        Alamat Domisili (Opsional)
                    </label>
                    <textarea name="alamat" id="alamat" rows="2" placeholder="Nama jalan, nomor rumah, kota..." class="w-full px-4 py-2.5 text-sm bg-white border border-[#EADBDB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7A1F2B] focus:border-[#7A1F2B] shadow-2xs transition-all">{{ old('alamat') }}</textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#7A1F2B] hover:bg-[#5E1620] text-white font-bold text-sm py-3.5 px-4 rounded-xl shadow-lg shadow-[#7A1F2B]/20 transition-all transform hover:-translate-y-0.5 mt-2">
                    Daftar Akun Member &rarr;
                </button>
            </form>

            <!-- Footer Card Link -->
            <div class="mt-6 text-center text-xs text-[#5A4D4A]">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-bold text-[#7A1F2B] hover:text-[#5E1620] underline underline-offset-2">
                    Masuk ke Akun
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

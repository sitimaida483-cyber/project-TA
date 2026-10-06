@extends('layouts.app')

@section('title', 'Masuk Akun - Ratna Wedding')

@section('content')
<div class="py-14 sm:py-20 px-4">
    <div class="max-w-md mx-auto">
        
        <!-- Login Card -->
        <div class="glass-luxury-card rounded-3xl p-8 sm:p-10 shadow-2xl shadow-[#1A1210]/10 border border-[#EADBDB]">
            <div class="text-center space-y-2 mb-8">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#7A1F2B] via-[#942C39] to-[#1A1210] text-white flex items-center justify-center mx-auto shadow-md shadow-[#7A1F2B]/20">
                    <i class="fa-solid fa-lock text-xl text-[#F7ECE9]"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-serif-heading font-bold text-[#1A1210]">
                    Masuk ke Akun
                </h1>
                <p class="text-xs sm:text-sm text-[#5A4D4A]">
                    Silakan masuk untuk melakukan reservasi atau melihat riwayat jadwal Anda.
                </p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <!-- Email / No HP -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#1A1210] mb-1.5">
                        Email atau No. WhatsApp
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#8A7975]">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </div>
                        <input type="text" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="contoh@gmail.com / 08123456789" class="w-full pl-10 pr-4 py-3 text-sm bg-white border border-[#EADBDB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7A1F2B] focus:border-[#7A1F2B] shadow-2xs transition-all">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#1A1210] mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#8A7975]">
                            <i class="fa-solid fa-key text-sm"></i>
                        </div>
                        <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full pl-10 pr-4 py-3 text-sm bg-white border border-[#EADBDB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7A1F2B] focus:border-[#7A1F2B] shadow-2xs transition-all">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 text-[#5A4D4A] cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#7A1F2B] focus:ring-[#7A1F2B] border-[#EADBDB]">
                        <span>Ingat saya</span>
                    </label>
                    <span class="text-[#8A7975]">Keamanan terenkripsi</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#7A1F2B] hover:bg-[#5E1620] text-white font-bold text-sm py-3.5 px-4 rounded-xl shadow-lg shadow-[#7A1F2B]/20 transition-all transform hover:-translate-y-0.5">
                    Masuk Sekarang &rarr;
                </button>
            </form>

            <!-- Quick Demo Accounts Helper -->
            <div class="mt-8 pt-6 border-t border-[#EADBDB]">
                <p class="text-[11px] uppercase font-bold text-[#8A7975] text-center tracking-wider mb-3">
                    Akses Cepat Pengujian Role (Demo)
                </p>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <button type="button" onclick="fillLogin('admin@ratnawedding.com', 'password')" class="p-2.5 rounded-xl bg-[#F7ECE9] hover:bg-[#EFE0DC] text-[#7A1F2B] font-semibold border border-[#EADBDB] text-left flex items-center gap-2.5 transition-colors">
                        <i class="fa-solid fa-user-shield text-[#7A1F2B]"></i>
                        <div>
                            <span class="block text-[11px] font-bold">Admin / Owner</span>
                            <span class="text-[9px] text-[#705F5B]">Akses Penuh</span>
                        </div>
                    </button>

                    <button type="button" onclick="fillLogin('siti@ratnawedding.com', 'password')" class="p-2.5 rounded-xl bg-[#F7ECE9] hover:bg-[#EFE0DC] text-[#7A1F2B] font-semibold border border-[#EADBDB] text-left flex items-center gap-2.5 transition-colors">
                        <i class="fa-solid fa-wand-magic text-[#7A1F2B]"></i>
                        <div>
                            <span class="block text-[11px] font-bold">Kapster / Staff</span>
                            <span class="text-[9px] text-[#705F5B]">Check-in & Status</span>
                        </div>
                    </button>

                    <button type="button" onclick="fillLogin('rini@gmail.com', 'password')" class="p-2.5 rounded-xl bg-[#F7ECE9] hover:bg-[#EFE0DC] text-[#7A1F2B] font-semibold border border-[#EADBDB] text-left flex items-center gap-2.5 transition-colors">
                        <i class="fa-solid fa-crown text-[#A8343F]"></i>
                        <div>
                            <span class="block text-[11px] font-bold">Member Gold</span>
                            <span class="text-[9px] text-[#705F5B]">Diskon 10%</span>
                        </div>
                    </button>

                    <button type="button" onclick="fillLogin('anisa@gmail.com', 'password')" class="p-2.5 rounded-xl bg-white hover:bg-[#FAF6F3] text-[#1A1210] font-semibold border border-[#EADBDB] text-left flex items-center gap-2.5 transition-colors">
                        <i class="fa-solid fa-user text-[#705F5B]"></i>
                        <div>
                            <span class="block text-[11px] font-bold">Pelanggan Baru</span>
                            <span class="text-[9px] text-[#705F5B]">Tier Bronze</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Footer Card Link -->
            <div class="mt-6 text-center text-xs text-[#5A4D4A]">
                Belum memiliki akun?
                <a href="{{ route('register') }}" class="font-bold text-[#7A1F2B] hover:text-[#5E1620] underline underline-offset-2">
                    Daftar Member Sekarang
                </a>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function fillLogin(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endpush
@endsection

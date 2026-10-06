<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ratna Wedding - Rias Pengantin & Tata Busana')</title>

    <!-- Google Fonts: Cormorant Garamond, Playfair Display & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-bg-ivory: #FAF6F3;
            --color-maroon: #7A1F2B;
            --color-maroon-dark: #5E1620;
            --color-text-heading: #1A1210;
            --color-copper: #A8343F;
            --color-copper-light: #F7ECE9;
            --color-border-subtle: #EADBDB;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAF6F3;
            color: #2D2422;
        }

        .font-serif-heading {
            font-family: 'Playfair Display', 'Cormorant Garamond', Georgia, serif;
        }

        .font-cormorant {
            font-family: 'Cormorant Garamond', 'Playfair Display', Georgia, serif;
        }

        .bg-ivory-gradient {
            background: linear-gradient(180deg, #FAF6F3 0%, #F5EDE8 50%, #FAF6F3 100%);
        }

        .glass-luxury-card {
            background: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(122, 31, 43, 0.12);
        }

        .btn-maroon {
            background-color: #7A1F2B;
            color: #FFFFFF;
            transition: all 0.25s ease;
        }
        .btn-maroon:hover {
            background-color: #5E1620;
            box-shadow: 0 10px 25px -5px rgba(122, 31, 43, 0.35);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-ivory-gradient antialiased min-h-screen flex flex-col selection:bg-[#7A1F2B] selection:text-white">

    <!-- Header & Navigation -->
    <header class="sticky top-0 z-50 bg-[#FAF6F3]/95 backdrop-blur-md border-b border-[#EADBDB] shadow-xs transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo & Brand Name -->
                <a href="{{ route('landing') }}" class="flex items-center gap-3.5 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#7A1F2B] via-[#942C39] to-[#1A1210] flex items-center justify-center text-white shadow-md shadow-[#7A1F2B]/20 group-hover:scale-105 transition-transform duration-300">
                        <i class="fa-solid fa-gem text-lg text-[#F7ECE9]"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-serif-heading font-bold text-[#1A1210] tracking-tight group-hover:text-[#7A1F2B] transition-colors">
                            Ratna Wedding
                        </span>
                        <p class="text-[10px] uppercase tracking-widest text-[#7A1F2B] font-bold -mt-1">
                            Bridal & Beauty Studio
                        </p>
                    </div>
                </a>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden md:flex items-center gap-7">
                    <a href="{{ route('landing') }}#beranda" class="text-sm font-semibold text-[#2D2422] hover:text-[#7A1F2B] transition-colors">
                        Beranda
                    </a>
                    <a href="{{ route('landing') }}#layanan" class="text-sm font-semibold text-[#2D2422] hover:text-[#7A1F2B] transition-colors">
                        Paket Layanan
                    </a>
                    <a href="{{ route('landing') }}#membership" class="text-sm font-semibold text-[#2D2422] hover:text-[#7A1F2B] transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-crown text-[#A8343F] text-xs"></i>
                        Membership
                    </a>
                    <a href="{{ route('landing') }}#kapster" class="text-sm font-semibold text-[#2D2422] hover:text-[#7A1F2B] transition-colors">
                        Tim Perias
                    </a>
                    <a href="{{ route('landing') }}#kontak" class="text-sm font-semibold text-[#2D2422] hover:text-[#7A1F2B] transition-colors">
                        Kontak & Lokasi
                    </a>
                </nav>

                <!-- Auth / Action Buttons -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <!-- Member Profile & Action Pill -->
                        <div class="flex items-center gap-3 bg-white/90 border border-[#EADBDB] rounded-full pl-3.5 pr-1.5 py-1.5 shadow-2xs">
                            <div class="text-right">
                                <div class="text-xs font-bold text-[#1A1210] flex items-center justify-end gap-1.5">
                                    {{ Auth::user()->name }}
                                    @if(Auth::user()->membershipTier)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full text-white bg-[#7A1F2B]">
                                            <i class="fa-solid fa-star text-[8px] text-[#F7ECE9]"></i>
                                            {{ Auth::user()->membershipTier->nama_tier }}
                                        </span>
                                    @endif
                                </div>
                                <span class="text-[10px] text-stone-500 block">
                                    {{ Auth::user()->role === 'admin' ? 'Administrator' : (Auth::user()->role === 'kapster' ? 'Staff Perias' : (Auth::user()->membershipTier ? 'Diskon ' . (float)Auth::user()->membershipTier->diskon_persen . '%' : 'Pelanggan')) }}
                                </span>
                            </div>

                            <a href="{{ route('reservasi.riwayat') }}" title="Riwayat Reservasi & Status Member" class="w-9 h-9 rounded-full bg-[#FAF6F3] text-[#7A1F2B] hover:bg-[#7A1F2B] hover:text-white flex items-center justify-center transition-colors border border-[#EADBDB]">
                                <i class="fa-solid fa-calendar-check text-xs"></i>
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" title="Keluar / Logout" class="w-9 h-9 rounded-full bg-[#FAF6F3] text-stone-400 hover:text-red-700 hover:bg-red-50 flex items-center justify-center transition-colors border border-[#EADBDB]">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                </button>
                            </form>
                        </div>

                        <a href="{{ route('reservasi.index') }}" class="inline-flex items-center gap-2 btn-maroon text-sm font-semibold px-5 py-2.5 rounded-full shadow-md transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-calendar-plus text-xs"></i>
                            <span>Booking Jadwal</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-[#1A1210] hover:text-[#7A1F2B] px-4 py-2 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-bold text-[#7A1F2B] bg-[#F7ECE9] hover:bg-[#EFE0DC] border border-[#EADBDB] px-4 py-2 rounded-full transition-colors">
                            Daftar Member
                        </a>
                        <a href="{{ route('reservasi.index') }}" class="inline-flex items-center gap-2 btn-maroon text-sm font-semibold px-5 py-2.5 rounded-full shadow-md transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-calendar-plus text-xs"></i>
                            <span>Reservasi</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" id="mobile-menu-btn" class="p-2 rounded-xl text-[#1A1210] hover:text-[#7A1F2B] hover:bg-[#F7ECE9] transition-colors" aria-label="Buka Menu">
                        <i class="fa-solid fa-bars-staggered text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-[#EADBDB] bg-[#FAF6F3]/98 backdrop-blur-lg px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('landing') }}#beranda" class="block text-sm font-medium text-[#1A1210] hover:text-[#7A1F2B] py-2 border-b border-[#EADBDB]/50">
                <i class="fa-solid fa-house text-[#7A1F2B] w-5"></i> Beranda
            </a>
            <a href="{{ route('landing') }}#layanan" class="block text-sm font-medium text-[#1A1210] hover:text-[#7A1F2B] py-2 border-b border-[#EADBDB]/50">
                <i class="fa-solid fa-spa text-[#7A1F2B] w-5"></i> Paket Layanan
            </a>
            <a href="{{ route('landing') }}#membership" class="block text-sm font-medium text-[#1A1210] hover:text-[#7A1F2B] py-2 border-b border-[#EADBDB]/50">
                <i class="fa-solid fa-crown text-[#A8343F] w-5"></i> Loyalty Membership
            </a>
            <a href="{{ route('landing') }}#kapster" class="block text-sm font-medium text-[#1A1210] hover:text-[#7A1F2B] py-2 border-b border-[#EADBDB]/50">
                <i class="fa-solid fa-wand-magic-sparkles text-[#7A1F2B] w-5"></i> Tim Perias
            </a>
            <a href="{{ route('landing') }}#kontak" class="block text-sm font-medium text-[#1A1210] hover:text-[#7A1F2B] py-2 border-b border-[#EADBDB]/50">
                <i class="fa-solid fa-phone text-[#7A1F2B] w-5"></i> Kontak & Lokasi
            </a>

            @auth
                <div class="pt-2 border-t border-[#EADBDB]">
                    <div class="text-xs font-semibold text-[#1A1210] py-1">
                        {{ Auth::user()->name }} 
                        @if(Auth::user()->membershipTier)
                            <span class="text-[10px] px-2 py-0.5 rounded-full text-white bg-[#7A1F2B] ml-1">
                                {{ Auth::user()->membershipTier->nama_tier }}
                            </span>
                        @endif
                    </div>
                    <a href="{{ route('reservasi.riwayat') }}" class="block text-sm font-medium text-[#7A1F2B] py-2">
                        <i class="fa-solid fa-clock-rotate-left w-5"></i> Riwayat Reservasi
                    </a>
                    <a href="{{ route('reservasi.index') }}" class="block text-center btn-maroon text-white text-sm font-semibold py-2.5 rounded-xl mt-2">
                        Booking Sekarang
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left text-sm font-medium text-red-700 py-2">
                            <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="pt-2 border-t border-[#EADBDB] flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="text-center text-sm font-bold text-[#1A1210] border border-[#EADBDB] py-2 rounded-xl bg-white">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-center text-sm font-bold text-[#7A1F2B] bg-[#F7ECE9] border border-[#EADBDB] py-2 rounded-xl">
                        Daftar Member Baru
                    </a>
                    <a href="{{ route('reservasi.index') }}" class="text-center btn-maroon text-white text-sm font-semibold py-2.5 rounded-xl shadow-md">
                        Reservasi Jadwal
                    </a>
                </div>
            @endauth
        </div>
    </header>

    <!-- Flash Notification Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-[#F7ECE9] border border-[#A8343F]/30 text-[#5E1620] shadow-sm animate-fade-in" role="alert">
                <div class="w-8 h-8 rounded-full bg-[#7A1F2B] flex items-center justify-center shrink-0 text-white">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="text-sm font-medium flex-1">
                    {{ session('success') }}
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-[#7A1F2B] hover:text-[#1A1210] p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-900 shadow-sm" role="alert">
                <div class="w-8 h-8 rounded-full bg-red-700 flex items-center justify-center shrink-0 text-white">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <div class="text-sm font-medium flex-1">
                    {{ session('error') }}
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-950 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-stone-100 border border-stone-200 text-[#1A1210] shadow-sm" role="alert">
                <div class="w-8 h-8 rounded-full bg-[#7A1F2B] flex items-center justify-center shrink-0 text-white">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="text-sm font-medium flex-1">
                    {{ session('info') }}
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-stone-500 hover:text-stone-800 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-[#F7ECE9] border border-[#A8343F]/40 text-[#5E1620] shadow-sm" role="alert">
                <div class="flex items-center gap-2 text-sm font-bold text-[#7A1F2B] mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-[#A8343F]"></i>
                    Perhatian: Terdapat kesalahan input
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-stone-700 pl-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content Body -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#1A1210] text-[#D8CCC8] mt-20 border-t border-[#332420]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                
                <!-- Col 1: About Ratna Wedding -->
                <div class="md:col-span-1 space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#7A1F2B] to-[#A8343F] flex items-center justify-center text-white">
                            <i class="fa-solid fa-gem"></i>
                        </div>
                        <span class="text-xl font-serif-heading font-bold text-[#FAF6F3]">
                            Ratna Wedding
                        </span>
                    </div>
                    <p class="text-xs text-[#B5A5A0] leading-relaxed">
                        Jasa rias pengantin, tata rias busana adat & modern, prewedding, dan rias wisuda profesional dengan sistem jadwal terintegrasi.
                    </p>
                    <div class="flex items-center gap-3 pt-2 text-[#EADBDB]">
                        <span class="w-8 h-8 rounded-lg bg-[#2D201C] flex items-center justify-center hover:bg-[#7A1F2B] hover:text-white transition-colors cursor-pointer">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </span>
                        <span class="w-8 h-8 rounded-lg bg-[#2D201C] flex items-center justify-center hover:bg-[#7A1F2B] hover:text-white transition-colors cursor-pointer">
                            <i class="fa-brands fa-tiktok text-sm"></i>
                        </span>
                        <span class="w-8 h-8 rounded-lg bg-[#2D201C] flex items-center justify-center hover:bg-[#7A1F2B] hover:text-white transition-colors cursor-pointer">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </span>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="text-sm font-semibold text-[#FAF6F3] uppercase tracking-wider mb-4 border-b border-[#332420] pb-2">
                        Navigasi Cepat
                    </h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('landing') }}#beranda" class="hover:text-[#F7ECE9] transition-colors">Beranda Utama</a></li>
                        <li><a href="{{ route('landing') }}#layanan" class="hover:text-[#F7ECE9] transition-colors">Katalog Paket Layanan</a></li>
                        <li><a href="{{ route('landing') }}#membership" class="hover:text-[#F7ECE9] transition-colors">Tingkatan Membership & Diskon</a></li>
                        <li><a href="{{ route('landing') }}#kapster" class="hover:text-[#F7ECE9] transition-colors">Profil Kapster & Perias</a></li>
                        <li><a href="{{ route('reservasi.index') }}" class="hover:text-[#F7ECE9] transition-colors font-semibold text-[#A8343F]">Reservasi Jadwal Online</a></li>
                    </ul>
                </div>

                <!-- Col 3: Fitur & Integrasi Sistem -->
                <div>
                    <h4 class="text-sm font-semibold text-[#FAF6F3] uppercase tracking-wider mb-4 border-b border-[#332420] pb-2">
                        Teknologi & Keamanan
                    </h4>
                    <ul class="space-y-2.5 text-xs text-[#B5A5A0]">
                        <li class="flex items-center gap-2">
                            <i class="fa-brands fa-google text-[#A8343F]"></i>
                            <span>Google Calendar API Sync</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-[#A8343F]"></i>
                            <span>WhatsApp Gateway (Fonnte)</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-bolt text-[#A8343F]"></i>
                            <span>Auto-Cancel 24 Jam via Cronjob</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-[#A8343F]"></i>
                            <span>Anti-Jadwal Bentrok Real-Time</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Lokasi & Kontak -->
                <div>
                    <h4 class="text-sm font-semibold text-[#FAF6F3] uppercase tracking-wider mb-4 border-b border-[#332420] pb-2">
                        Studio Ratna Wedding
                    </h4>
                    <div class="space-y-2 text-xs text-[#B5A5A0]">
                        <p class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-[#A8343F] mt-0.5"></i>
                            <span>Jl. Pengantin Cantik No. 10, Jakarta Selatan</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-[#A8343F]"></i>
                            <span>+62 812-3456-7890</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-[#A8343F]"></i>
                            <span>info@ratnawedding.com</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fa-regular fa-clock text-[#A8343F]"></i>
                            <span>Buka Setiap Hari: 08.00 - 18.00 WIB</span>
                        </p>
                    </div>
                </div>

            </div>

            <div class="mt-12 pt-6 border-t border-[#332420] text-center text-xs text-[#8A7975] flex flex-col sm:flex-row justify-between items-center gap-3">
                <p>&copy; {{ date('Y') }} Ratna Wedding. Tugas Akhir Sistem Informasi Reservasi & Manajemen Jadwal.</p>
                <p class="text-[#705F5B]">Built with Laravel & MySQL</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            if (menuBtn && menu) {
                menuBtn.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

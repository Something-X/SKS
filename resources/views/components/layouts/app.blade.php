<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Sewa Kamera SBY' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#F8F9FA] text-gray-900 antialiased selection:bg-black selection:text-white">
    
    <!-- DESKTOP TOP NAVBAR (Sembunyi di HP) -->
    <header class="hidden md:flex bg-[#F8F9FA] py-6 px-10 justify-between items-center z-50">
        <div class="flex items-center gap-2">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <div class="flex flex-col text-[11px] font-black uppercase leading-[1.1] tracking-[0.2em] text-black text-left">
                <span>Sewa</span>
                <span>Kamera</span>
                <span>Sby</span>
            </div>
        </div>
        <nav class="flex gap-10 text-gray-500 font-medium text-sm">
            <a href="#" class="text-black font-semibold border-b-2 border-black pb-1">Beranda</a>
            <a href="#" class="hover:text-black transition-colors pb-1">Kategori</a>
            <a href="#" class="hover:text-black transition-colors pb-1">Favorit</a>
        </nav>
        <button class="bg-black text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-gray-800 transition-all shadow-md">
            Akun Saya
        </button>
    </header>

    <!-- MOBILE TOP BAR (Sembunyi di PC) -->
    <header class="md:hidden flex justify-between items-center px-6 py-5 bg-[#F8F9FA] sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden border-2 border-white shadow-sm">
                <img src="https://ui-avatars.com/api/?name=User&background=random" alt="User" class="w-full h-full object-cover">
            </div>
            <div>
                <p class="text-[10px] text-gray-500">Hi, Selamat Datang!</p>
                <p class="text-xs font-bold text-gray-900">Guest User</p>
            </div>
        </div>
        <button class="text-black relative p-2 bg-white rounded-full shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            <span class="absolute top-1.5 right-2 bg-black text-white text-[8px] font-bold w-3 h-3 rounded-full flex items-center justify-center border border-white">2</span>
        </button>
    </header>

    <div class="md:hidden px-6 pb-2 pt-2 flex justify-center">
        <div class="flex items-center gap-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <div class="flex flex-col text-[9px] font-black uppercase leading-[1.1] tracking-[0.2em] text-black text-left">
                <span>Sewa</span>
                <span>Kamera</span>
                <span>Sby</span>
            </div>
        </div>
    </div>

    <!-- KONTEN UTAMA -->
    <main class="w-full max-w-7xl mx-auto pb-28 md:pb-12 pt-4 min-h-screen">
        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#111111] text-white py-12 px-6 mt-12 pb-32 md:pb-12 text-center md:text-left rounded-t-3xl md:rounded-none">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center justify-center md:justify-start gap-2 mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div class="flex flex-col text-[10px] font-black uppercase leading-[1.1] tracking-[0.2em] text-white text-left">
                        <span>Sewa</span>
                        <span>Kamera</span>
                        <span>Sby</span>
                    </div>
                </div>
                <p class="text-gray-400 text-sm max-w-xs mx-auto md:mx-0">Pusat penyewaan kamera dan perlengkapan studio terbaik di Surabaya. Tangkap setiap momen berharga Anda dengan kualitas terbaik.</p>
            </div>
            <div class="flex flex-col gap-2 text-sm text-gray-400">
                <h4 class="text-white font-bold mb-2">Tautan</h4>
                <a href="#" class="hover:text-white transition-colors">Tentang Kami</a>
                <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-white transition-colors">Hubungi Kami</a>
            </div>
            <div class="flex flex-col gap-2 text-sm text-gray-400">
                <h4 class="text-white font-bold mb-2">Kontak</h4>
                <p>Jl. Mawar No. 123, Surabaya</p>
                <p>WA: 0812-3456-7890</p>
                <p>IG: @sewakamerasby</p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-gray-800 text-gray-500 text-xs text-center">
            &copy; {{ date('Y') }} Sewa Kamera SBY. All rights reserved.
        </div>
    </footer>

    <!-- MOBILE BOTTOM NAVIGATION (Sembunyi di PC) - Floating Black Pill -->
    <nav class="md:hidden fixed bottom-6 left-6 right-6 bg-[#111111] text-gray-400 rounded-[2rem] flex justify-between px-8 py-4 shadow-2xl z-50 items-center border border-gray-800">
        <button class="flex flex-col items-center text-white transition-colors">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" /><path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" /></svg>
        </button>
        <button class="flex flex-col items-center hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
        </button>
        <button class="flex flex-col items-center hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </button>
        <button class="flex flex-col items-center hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </button>
    </nav>

    @livewireScripts
</body>
</html>
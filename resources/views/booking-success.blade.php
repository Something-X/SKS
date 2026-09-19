<x-layouts.app>
    <div class="max-w-xl mx-auto bg-slate-800 border border-slate-700 p-8 rounded-2xl text-center shadow-xl">
        <div class="w-16 h-16 bg-green-500/20 text-green-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">✓</div>
        <h2 class="text-2xl font-bold text-white mb-2">Reservasi Berhasil!</h2>
        <p class="text-slate-400 text-sm mb-6">Kode Booking Anda: <span class="text-cyan-400 font-mono font-bold text-lg">{{ $booking->booking_code }}</span></p>

        <div class="bg-slate-900 p-4 rounded-xl text-left text-sm space-y-2 mb-6 border border-slate-800">
            <div class="flex justify-between"><span class="text-slate-400">Kamera:</span> <span class="text-white font-semibold">{{ $booking->product->name }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Tanggal:</span> <span class="text-white">{{ $booking->start_date }} s/d {{ $booking->end_date }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Jam Ambil:</span> <span class="text-white">{{ $booking->pickup_time }} WIB</span></div>
            <div class="flex justify-between border-t border-slate-800 pt-2 font-bold"><span class="text-slate-300">Total Harga:</span> <span class="text-cyan-400">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span></div>
        </div>

        @php
            $waMessage = urlencode("Halo Admin SKS, saya ingin konfirmasi booking:\n\n*Kode:* {$booking->booking_code}\n*Nama:* {$booking->customer_name}\n*Unit:* {$booking->product->name}\n*Tgl:* {$booking->start_date} - {$booking->end_date}\n*Jam Ambil:* {$booking->pickup_time}\n\nMohon bantuannya untuk diproses.");
        @endphp

        <a href="https://wa.me/6281234567890?text={{ $waMessage }}" target="_blank" 
           class="block w-full bg-green-600 hover:bg-green-500 text-white font-bold py-3 rounded-xl transition mb-3">
            💬 Konfirmasi via WhatsApp Admin
        </a>
        <a href="{{ url('/') }}" class="text-sm text-slate-400 hover:text-white">← Kembali ke Beranda</a>
    </div>
</x-layouts.app>
<div class="max-w-md mx-auto bg-white shadow-xl overflow-hidden">

    <!-- Hero Image -->
    <div class="relative w-full h-72 bg-gradient-to-b from-slate-600 to-white-100 flex items-center justify-center">
        <a href="{{ route('home') }}" wire:navigate
            class="absolute top-4 left-4 w-9 h-9 aspect-square flex-shrink-0 rounded-full bg-white/90 backdrop-blur flex items-center justify-center shadow-sm hover:bg-white transition">
            <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        @if($product->thumbnail)
        <img src="{{ asset('storage/'.$product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-8">
        @else
        <span class="text-slate-500 text-xs">No Image</span>
        @endif
    </div>

    <!-- Content -->
    <div class="p-6">

        <!-- Nama & Kategori -->
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900 leading-tight">{{ $product->name }}</h2>
                <p class="text-xs text-gray-400 mt-1">{{ $product->brand?->name ?? 'Kamera' }} {{ $product->category?->name ? '· '.$product->category->name : '' }}</p>
            </div>
        </div>

        @if(!empty($product->description))
        <div class="mb-6">
            <h3 class="text-sm font-bold text-gray-900 mb-1.5">Description</h3>
            <p class="text-xs text-gray-400 leading-relaxed">{{ $product->description }}</p>
        </div>
        @endif

        <!-- Tanggal Sewa -->
        <div class="space-y-4 mb-6">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tgl Mulai</label>
                    <input wire:model.live="start_date" type="date" min="{{ date('Y-m-d') }}"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm px-3 py-2.5 focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tgl Selesai</label>
                    <input wire:model.live="end_date" type="date" min="{{ $start_date ?: date('Y-m-d') }}"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm px-3 py-2.5 focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition">
                </div>
            </div>
            @error('start_date') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
            @error('end_date') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror

            @if($total_days > 0)
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-2xl">
                <div class="flex justify-between text-xs text-gray-500 mb-1">
                    <span>Durasi: {{ $total_days }} Hari</span>
                    <span>Total Biaya</span>
                </div>
                <div class="text-xl font-extrabold text-black text-right">Rp {{ number_format($total_price, 0, ',', '.') }}</div>
            </div>
            @endif
        </div>

        <form wire:submit.prevent="submit" class="space-y-4">

            <!-- Peringatan KTP/SIM Fisik -->
            <div class="bg-amber-50 border-l-4 border-amber-400 p-3 rounded-r-xl flex gap-2 items-start">
                <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-xs text-amber-700">Wajib membawa KTP/SIM Asli atas nama pemesan saat pengambilan unit di toko.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nama Lengkap</label>
                <input wire:model="customer_name" type="text" placeholder="Sesuai KTP"
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm px-3 py-2.5 placeholder-gray-400 focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition">
                @error('customer_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nomor WhatsApp</label>
                <div class="relative">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.52 3.48A11.9 11.9 0 0012.06 0C5.5 0 .2 5.3.2 11.86c0 2.09.55 4.13 1.6 5.93L0 24l6.36-1.66a11.86 11.86 0 005.7 1.45h.01c6.56 0 11.86-5.3 11.86-11.86 0-3.17-1.23-6.15-3.41-8.45zM12.07 21.6a9.7 9.7 0 01-4.95-1.36l-.35-.21-3.77.99 1-3.67-.23-.38a9.7 9.7 0 01-1.49-5.16c0-5.37 4.37-9.74 9.75-9.74a9.7 9.7 0 016.9 2.86 9.68 9.68 0 012.85 6.89c0 5.38-4.38 9.78-9.71 9.78z" />
                    </svg>
                    <input wire:model="wa_number" type="tel" placeholder="08xxxxxxxxxx"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm pl-9 pr-3 py-2.5 placeholder-gray-400 focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition">
                </div>
                @error('wa_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Jam Ambil</label>
                    <input wire:model="pickup_time" type="time"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm px-3 py-2.5 focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Pembayaran</label>
                    <select wire:model="payment_method"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm px-3 py-2.5 focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition">
                        <option value="PAY_AT_STORE">Bayar di Toko</option>
                        <option value="DP_QRIS">TF BCA</option>
                    </select>
                </div>
            </div>

            <label class="flex items-start space-x-2 text-xs text-gray-500 pt-1">
                <input wire:model="agree_terms" type="checkbox" class="mt-0.5 rounded border-gray-300 text-black focus:ring-black">
                <span>Saya setuju dengan syarat & ketentuan sewa.</span>
            </label>
            @error('agree_terms') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror

            <!-- Harga & Tombol -->
            <div class="flex items-center justify-between pt-2 border-t border-gray-100 mt-2">
                <div>
                    <p class="text-[10px] text-gray-400">Price</p>
                    <p class="text-base font-extrabold text-gray-900">
                        Rp {{ number_format($product->price_per_day, 0, ',', '.') }}
                        <span class="text-xs font-medium text-gray-400">/ Day</span>
                    </p>
                </div>

                <button type="submit" wire:loading.attr="disabled" wire:target="submit"
                    class="bg-black hover:bg-gray-800 disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-3 rounded-2xl font-bold text-sm transition flex items-center gap-2">
                    <svg wire:loading wire:target="submit" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="submit">Booking Sekarang</span>
                    <span wire:loading wire:target="submit">Memproses...</span>
                </button>
            </div>
        </form>
    </div>
</div>
<div class="px-6 md:px-10 max-w-lg mx-auto md:max-w-none">

    <!-- Header / Logo -->
    <div class="flex items-center justify-between mb-6 pt-2">
        <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-2">
            <div class="w-19 h-19 rounded-xl flex items-center justify-center overflow-hidden">
                <img src="{{ asset('images/logo.png') }}" alt="KameraRent Logo" class="w-full h-full object-contain">
            </div>
        </a>

        <button class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition">
            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </button>
    </div>

    <!-- This week Offers Section -->
    @if(isset($promos) && count($promos) > 0)
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-900">This week Offers</h2>
        <a href="#" class="text-[10px] font-semibold text-gray-400 hover:text-black transition-colors">View All</a>
    </div>

    <div 
        x-data="{
            init() {
                setInterval(() => {
                    if (!this.$el) return;
                    let maxScroll = this.$el.scrollWidth - this.$el.clientWidth;
                    let currentScroll = this.$el.scrollLeft;
                    if (currentScroll >= maxScroll - 10) {
                        this.$el.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        this.$el.scrollBy({ left: this.$el.clientWidth, behavior: 'smooth' });
                    }
                }, 5000);
            }
        }"
        class="flex gap-4 overflow-x-auto hide-scrollbar pb-6 mb-2 snap-x snap-mandatory scroll-smooth"
    >
        @foreach($promos as $promo)
        @if($promo->product)
        <a href="{{ route('product.book', $promo->product->slug) }}" wire:navigate class="w-full min-w-full h-40 md:h-56 bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition relative group block flex-shrink-0 snap-center">
        @else
        <div class="w-full min-w-full h-40 md:h-56 bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition relative group block flex-shrink-0 snap-center">
        @endif
            @if($promo->image)
            <img src="{{ Storage::url($promo->image) }}" alt="{{ $promo->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 font-medium">
                {{ $promo->title }}
            </div>
            @endif
        @if($promo->product)
        </a>
        @else
        </div>
        @endif
        @endforeach
    </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-8">
        <div class="relative flex items-center">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search your products..."
                class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-2xl pl-5 pr-14 py-3.5 focus:outline-none focus:border-black focus:ring-1 focus:ring-black shadow-sm transition-all">
            <button class="absolute right-2 top-2 bottom-2 bg-black text-white rounded-xl w-10 flex items-center justify-center hover:bg-gray-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Products Section Title -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-900">Products</h2>
        <a href="#" class="text-xs font-semibold text-gray-400 hover:text-black underline decoration-2 underline-offset-4 decoration-transparent hover:decoration-black transition-all">View All</a>
    </div>

    <!-- Kategori Pills -->
    <div class="mb-8">
        <div class="flex gap-3 overflow-x-auto hide-scrollbar pb-2">

            <!-- Tombol "Semua" -->
            <button wire:click="$set('selectedCategory', null)" class="px-5 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-colors {{ is_null($selectedCategory) ? 'bg-black text-white' : 'bg-white text-gray-500 hover:bg-gray-100' }}">
                All
            </button>

            <!-- Loop Kategori -->
            @foreach($categories as $cat)
            <button wire:click="$set('selectedCategory', {{ $cat->id }})" class="px-5 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-colors {{ $selectedCategory == $cat->id ? 'bg-black text-white' : 'bg-white text-gray-500 hover:bg-gray-100' }}">
                {{ $cat->name }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        @forelse($products as $product)
        <a href="{{ route('product.book', $product->slug) }}" wire:navigate class="bg-white rounded-[1.25rem] p-3 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col justify-between hover:shadow-lg transition-all duration-300 group block relative">

            <!-- Gambar -->
            <div class="w-full h-32 md:h-44 flex items-center justify-center p-3 mb-2 bg-white rounded-xl">
                @if($product->thumbnail)
                <img src="{{ asset('storage/'.$product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="text-gray-300 text-xs w-full h-full flex items-center justify-center">No Image</div>
                @endif
            </div>

            <!-- Info Produk -->
            <div class="px-1">
                <h3 class="text-sm font-bold text-gray-900 leading-tight mb-1 truncate">{{ $product->name }}</h3>
                <p class="text-[10px] text-gray-400 truncate mb-3">{{ $product->brand?->name ?? 'Kamera' }} {{ $product->category?->name ?? '' }}</p>

                <div class="flex items-center">
                    <span class="text-sm font-extrabold text-black">Rp {{ number_format($product->price_per_day/1000, 0, ',', '.') }}K</span>
                    <span class="text-[10px] text-gray-400 font-medium ml-1">/ Day</span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-16">
            <span class="text-gray-300 mb-3 inline-block">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </span>
            <p class="text-gray-900 text-sm font-bold">Produk tidak ditemukan</p>
            <p class="text-gray-400 text-xs mt-1">Coba cari dengan kata kunci lain.</p>
        </div>
        @endforelse
    </div>


    <!-- Pagination -->
    <div class="mt-8 mb-10">
        {{ $products->links() }}
    </div>

    <!-- Footer -->
    <!-- Footer -->
    <!-- Footer -->
    <footer class="mt-4 mb-8 pt-6 border-t border-gray-100">

        <!-- Logo -->
        <div class="w-14 h-14 rounded-xl flex items-center justify-center overflow-hidden mb-5">
            <img src="{{ asset('images/logo.png') }}" alt="KameraRent Logo" class="w-full h-full object-contain">
        </div>

        <!-- Alamat & Sosial Media -->
        <div class="grid grid-cols-2 gap-6">

            <!-- Alamat -->
            <div class="flex items-start gap-2 text-xs text-gray-400">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>
                    Prapen Indah Blok S8<br>
                    <a href="https://share.google/5bgHD9kIg3LmJq2GS" target="_blank" rel="noopener" class="underline hover:text-black transition-colors">
                        Lihat lokasi di Google Maps
                    </a>
                </span>
            </div>

            <!-- Sosial Media -->
            <div class="flex justify-end gap-3">
                <!-- WhatsApp -->
                <a href="https://wa.me/62812xxxxxxxx" target="_blank" rel="noopener"
                    class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition">
                    <svg class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.52 3.48A11.9 11.9 0 0012.06 0C5.5 0 .2 5.3.2 11.86c0 2.09.55 4.13 1.6 5.93L0 24l6.36-1.66a11.86 11.86 0 005.7 1.45h.01c6.56 0 11.86-5.3 11.86-11.86 0-3.17-1.23-6.15-3.41-8.45zM12.07 21.6a9.7 9.7 0 01-4.95-1.36l-.35-.21-3.77.99 1-3.67-.23-.38a9.7 9.7 0 01-1.49-5.16c0-5.37 4.37-9.74 9.75-9.74a9.7 9.7 0 016.9 2.86 9.68 9.68 0 012.85 6.89c0 5.38-4.38 9.78-9.71 9.78zm5.34-7.3c-.29-.15-1.73-.85-2-.95-.27-.1-.46-.15-.66.15-.2.29-.76.95-.93 1.15-.17.19-.34.22-.63.07-.29-.15-1.23-.45-2.34-1.44-.86-.77-1.44-1.72-1.61-2.01-.17-.29-.02-.45.13-.6.13-.13.29-.34.44-.51.15-.17.19-.29.29-.49.1-.19.05-.36-.02-.51-.07-.15-.66-1.58-.9-2.17-.24-.57-.48-.49-.66-.5h-.56c-.19 0-.51.07-.78.36-.27.29-1.02 1-1.02 2.44s1.05 2.83 1.19 3.02c.15.19 2.06 3.15 5 4.41.7.3 1.24.48 1.67.62.7.22 1.34.19 1.84.11.56-.08 1.73-.71 1.98-1.39.24-.68.24-1.27.17-1.39-.07-.12-.26-.19-.55-.34z" />
                    </svg>
                </a>
                <!-- Instagram -->
                <a href="https://instagram.com/kamerarent" target="_blank" rel="noopener"
                    class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition">
                    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="2" />
                        <circle cx="12" cy="12" r="4" stroke-width="2" />
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                    </svg>
                </a>
                <!-- TikTok -->
                <a href="https://tiktok.com/@kamerarent" target="_blank" rel="noopener"
                    class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition">
                    <svg class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16.6 5.82c-1.02-1-1.6-2.36-1.6-3.82h-3.07v13.44c0 1.53-1.24 2.77-2.77 2.77a2.77 2.77 0 01-2.77-2.77 2.77 2.77 0 012.77-2.77c.28 0 .54.04.79.11V9.7a5.9 5.9 0 00-.79-.05A5.85 5.85 0 003 15.5 5.85 5.85 0 008.85 21.35 5.85 5.85 0 0014.7 15.5V8.33a8.5 8.5 0 004.96 1.59V6.87a5.3 5.3 0 01-3.06-1.05z" />
                    </svg>
                </a>
            </div>
        </div>

        <p class="text-[10px] text-gray-300 mt-6 text-center md:text-left">
            &copy; {{ date('Y') }} Sewa Kamera Surabaya. All rights reserved.
        </p>
    </footer>
</div>
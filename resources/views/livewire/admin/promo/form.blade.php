<div>
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.promos.index') }}" class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">{{ $promo ? 'Edit Promo' : 'Tambah Promo Baru' }}</h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form wire:submit="save" class="p-6 md:p-8">
            <div class="grid grid-cols-1 gap-6 max-w-2xl">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Promo <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="title" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 transition" placeholder="Contoh: Promo Akhir Tahun">
                    @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Product Link (Searchable) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tautkan ke Produk (Opsional)</label>
                    
                    <div x-data="{ open: false }" class="relative">
                        <!-- Input for searching -->
                        @if($product_id)
                            <div class="flex items-center justify-between w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50">
                                <span class="text-gray-800">{{ $selectedProductName }}</span>
                                <button type="button" wire:click="clearProduct" class="text-gray-400 hover:text-red-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @else
                            <input 
                                type="text" 
                                wire:model.live.debounce.300ms="searchProduct" 
                                @focus="open = true" 
                                @click.away="open = false" 
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 transition bg-white" 
                                placeholder="Cari nama produk..."
                            >
                            
                            <!-- Dropdown Results -->
                            <div x-show="open" style="display: none;" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                                @forelse($products as $product)
                                    <div 
                                        wire:click="selectProduct({{ $product->id }}, '{{ addslashes($product->name) }}')" 
                                        @click="open = false" 
                                        class="px-4 py-2.5 hover:bg-purple-50 cursor-pointer text-sm border-b border-gray-50 last:border-0"
                                    >
                                        {{ $product->name }}
                                    </div>
                                @empty
                                    <div class="px-4 py-3 text-sm text-gray-500 text-center">
                                        {{ $searchProduct ? 'Produk tidak ditemukan.' : 'Ketik untuk mencari produk...' }}
                                    </div>
                                @endforelse
                            </div>
                        @endif
                    </div>
                    @error('product_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Promo <span class="text-red-500">{{ $promo ? '' : '*' }}</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl relative hover:bg-gray-50 transition">
                        <div class="space-y-1 text-center">
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" class="mx-auto h-32 object-contain mb-4">
                            @elseif ($existingImage)
                                <img src="{{ Storage::url($existingImage) }}" class="mx-auto h-32 object-contain mb-4">
                            @else
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @endif
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none">
                                    <span>Upload file</span>
                                    <input id="file-upload" wire:model="image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                        <div wire:loading wire:target="image" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center rounded-xl">
                            <span class="text-purple-600 font-semibold">Mengunggah...</span>
                        </div>
                    </div>
                    @error('image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Status Aktif -->
                <div>
                    <label class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" wire:model="is_active" class="sr-only">
                            <div class="block bg-gray-200 w-10 h-6 rounded-full transition {{ $is_active ? 'bg-purple-600' : 'bg-gray-200' }}"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition transform {{ $is_active ? 'translate-x-4' : '' }}"></div>
                        </div>
                        <div class="ml-3 text-sm font-semibold text-gray-700">
                            Aktif (Tampilkan di halaman utama)
                        </div>
                    </label>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex gap-3">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm transition flex items-center justify-center min-w-[120px]">
                    <span wire:loading.remove wire:target="save">Simpan</span>
                    <span wire:loading wire:target="save">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
                <a href="{{ route('admin.promos.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-6 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

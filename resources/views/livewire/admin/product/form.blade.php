<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $product ? 'Edit Produk' : 'Tambah Produk Baru' }}</h2>
            <p class="text-gray-500 text-sm mt-1">Isi form di bawah untuk {{ $product ? 'memperbarui' : 'menambahkan' }} produk.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-purple-600 transition font-medium">
            &larr; Kembali
        </a>
    </div>

    <form wire:submit="save" class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 md:p-8 space-y-6">
                
                <!-- Nama & Slug -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                        <input wire:model.live="name" type="text" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('name') border-red-500 @enderror" placeholder="Contoh: Sony A7 IV">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Slug <span class="text-red-500">*</span></label>
                        <input wire:model="slug" type="text" class="w-full px-4 py-2 border border-gray-200 rounded-xl bg-gray-50 focus:ring-purple-500 focus:border-purple-500 @error('slug') border-red-500 @enderror" placeholder="sony-a7-iv" readonly>
                        @error('slug') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Kategori & Brand -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select wire:model="category_id" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('category_id') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Brand <span class="text-red-500">*</span></label>
                        <select wire:model="brand_id" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('brand_id') border-red-500 @enderror">
                            <option value="">Pilih Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Harga & Deposit & Stok -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga / Hari (Rp) <span class="text-red-500">*</span></label>
                        <input wire:model="price_per_day" type="number" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('price_per_day') border-red-500 @enderror">
                        @error('price_per_day') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deposit (Rp) <span class="text-red-500">*</span></label>
                        <input wire:model="deposit_amount" type="number" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('deposit_amount') border-red-500 @enderror">
                        @error('deposit_amount') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Stok (Unit) <span class="text-red-500">*</span></label>
                        <input wire:model="stock_quantity" type="number" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('stock_quantity') border-red-500 @enderror">
                        @error('stock_quantity') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea wire:model="description" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('description') border-red-500 @enderror"></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Spesifikasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Spesifikasi</label>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        @if(count($specifications) > 0)
                            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-2">
                                @foreach($specifications as $key => $value)
                                    <div class="flex items-center justify-between bg-white px-3 py-2 border border-gray-100 rounded-lg shadow-sm">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-gray-500 uppercase">{{ $key }}</span>
                                            <span class="text-sm text-gray-800">{{ $value }}</span>
                                        </div>
                                        <button type="button" wire:click="removeSpecification('{{ $key }}')" class="text-red-400 hover:text-red-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="flex flex-col md:flex-row gap-3">
                            <input wire:model="newSpecKey" type="text" placeholder="Nama Spesifikasi (Cth: Resolusi)" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-purple-500 focus:border-purple-500">
                            <input wire:model="newSpecValue" type="text" placeholder="Nilai (Cth: 33 MP)" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-purple-500 focus:border-purple-500">
                            <button type="button" wire:click="addSpecification" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Thumbnail -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Thumbnail</label>
                    <div class="flex items-start gap-6">
                        <div class="w-32 h-32 bg-gray-100 border border-gray-200 rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center">
                            @if ($thumbnail)
                                <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif ($existingThumbnail)
                                <img src="{{ Storage::url($existingThumbnail) }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input wire:model="thumbnail" type="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 transition" accept="image/*">
                            <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                            @error('thumbnail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="border-t border-gray-100 pt-6">
                    <div class="flex items-center gap-8">
                        <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" wire:model="is_active" class="sr-only">
                                <div class="w-10 h-6 bg-gray-200 rounded-full shadow-inner transition-colors {{ $is_active ? 'bg-purple-500' : '' }}"></div>
                                <div class="dot absolute w-4 h-4 bg-white rounded-full shadow left-1 top-1 transition-transform {{ $is_active ? 'transform translate-x-4' : '' }}"></div>
                            </div>
                            <div class="ml-3 text-sm font-semibold text-gray-700">Aktif (Ditampilkan)</div>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" wire:model="is_featured" class="sr-only">
                                <div class="w-10 h-6 bg-gray-200 rounded-full shadow-inner transition-colors {{ $is_featured ? 'bg-amber-500' : '' }}"></div>
                                <div class="dot absolute w-4 h-4 bg-white rounded-full shadow left-1 top-1 transition-transform {{ $is_featured ? 'transform translate-x-4' : '' }}"></div>
                            </div>
                            <div class="ml-3 text-sm font-semibold text-gray-700">Unggulan (Featured)</div>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-100 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-xl text-sm font-semibold hover:bg-purple-700 transition flex items-center gap-2">
                    <span wire:loading.remove wire:target="save">Simpan Produk</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </form>
</div>

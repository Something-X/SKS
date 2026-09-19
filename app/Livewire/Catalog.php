<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promo;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use WithPagination;

    public $search = '';

    public $selectedCategory = null;

    public $selectedBrand = null;

    // Reset pagination ketika filter berubah
    public function updated($property)
    {
        if (in_array($property, ['search', 'selectedCategory', 'selectedBrand'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        // Mengambil data produk berdasarkan filter pencarian
        $products = Product::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->selectedCategory, fn ($q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->selectedBrand, fn ($q) => $q->where('brand_id', $this->selectedBrand))
            ->paginate(12);

        // Variabel $products dikirim ke view resources/views/livewire/catalog.blade.php
        return view('livewire.catalog', [
            'promos' => Promo::with('product')->where('is_active', true)->latest()->get(),
            'products' => $products,
            'categories' => Category::all(),
            'brands' => Brand::all(),
        ]);
    }
}

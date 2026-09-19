<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(Product $product)
    {
        $product->delete();
        session()->flash('success', 'Produk berhasil dihapus.');
    }

    public function render()
    {
        $products = Product::with(['category', 'brand'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('slug', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.product.index', [
            'products' => $products,
        ]);
    }
}

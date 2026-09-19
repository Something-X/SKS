<?php

namespace App\Livewire\Admin\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class Form extends Component
{
    use WithFileUploads;

    public ?Product $product = null;

    public $category_id = '';

    public $brand_id = '';

    public $name = '';

    public $slug = '';

    public $description = '';

    public $price_per_day = '';

    public $deposit_amount = '';

    public $stock_quantity = 1;

    public $is_active = true;

    public $is_featured = false;

    public $specifications = [];

    public $newSpecKey = '';

    public $newSpecValue = '';

    public $thumbnail;

    public $existingThumbnail = null;

    public function mount(?Product $product = null)
    {
        if ($product && $product->exists) {
            $this->product = $product;
            $this->category_id = $product->category_id;
            $this->brand_id = $product->brand_id;
            $this->name = $product->name;
            $this->slug = $product->slug;
            $this->description = $product->description;
            $this->price_per_day = $product->price_per_day;
            $this->deposit_amount = $product->deposit_amount;
            $this->stock_quantity = $product->stock_quantity;
            $this->is_active = $product->is_active;
            $this->is_featured = $product->is_featured;
            $this->specifications = $product->specifications ?? [];
            $this->existingThumbnail = $product->thumbnail;
        }
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function addSpecification()
    {
        if (! empty($this->newSpecKey) && ! empty($this->newSpecValue)) {
            $this->specifications[$this->newSpecKey] = $this->newSpecValue;
            $this->newSpecKey = '';
            $this->newSpecValue = '';
        }
    }

    public function removeSpecification($key)
    {
        unset($this->specifications[$key]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,'.($this->product ? $this->product->id : 'NULL'),
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price_per_day' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048', // max 2MB
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'price_per_day' => $this->price_per_day,
            'deposit_amount' => $this->deposit_amount,
            'stock_quantity' => $this->stock_quantity,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'specifications' => $this->specifications,
        ];

        if ($this->thumbnail) {
            $path = $this->thumbnail->store('products', 'public');
            $data['thumbnail'] = $path;
        }

        if ($this->product && $this->product->exists) {
            $this->product->update($data);
            session()->flash('success', 'Produk berhasil diperbarui.');
        } else {
            Product::create($data);
            session()->flash('success', 'Produk berhasil ditambahkan.');
        }

        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        return view('livewire.admin.product.form', [
            'categories' => Category::orderBy('name')->get(),
            'brands' => Brand::orderBy('name')->get(),
        ]);
    }
}

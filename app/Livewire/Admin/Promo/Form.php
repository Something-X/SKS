<?php

namespace App\Livewire\Admin\Promo;

use App\Models\Product;
use App\Models\Promo;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class Form extends Component
{
    use WithFileUploads;

    public ?Promo $promo = null;

    public $title = '';

    public $product_id = '';

    public $is_active = true;

    public $image;

    public $existingImage = null;

    public $searchProduct = '';

    public $selectedProductName = '';

    public function mount(?Promo $promo = null)
    {
        if ($promo && $promo->exists) {
            $this->promo = $promo;
            $this->title = $promo->title;
            $this->product_id = $promo->product_id;
            $this->is_active = $promo->is_active;
            $this->existingImage = $promo->image;
            if ($this->product_id) {
                $this->selectedProductName = Product::find($this->product_id)?->name ?? '';
            }
        }
    }

    public function selectProduct($id, $name)
    {
        $this->product_id = $id;
        $this->selectedProductName = $name;
        $this->searchProduct = '';
    }

    public function clearProduct()
    {
        $this->product_id = '';
        $this->selectedProductName = '';
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'image' => $this->promo && $this->promo->exists ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        $data = [
            'title' => $this->title,
            'product_id' => $this->product_id ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            $path = $this->image->store('promos', 'public');
            $data['image'] = $path;
        }

        if ($this->promo && $this->promo->exists) {
            $this->promo->update($data);
            session()->flash('success', 'Promo berhasil diperbarui.');
        } else {
            Promo::create($data);
            session()->flash('success', 'Promo berhasil ditambahkan.');
        }

        return redirect()->route('admin.promos.index');
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->searchProduct, function ($query) {
                $query->where('name', 'like', '%'.$this->searchProduct.'%');
            })
            ->orderBy('name')
            ->take(20)
            ->get();

        return view('livewire.admin.promo.form', [
            'products' => $products,
        ]);
    }
}

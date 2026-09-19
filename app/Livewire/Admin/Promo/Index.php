<?php

namespace App\Livewire\Admin\Promo;

use App\Models\Promo;
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

    public function delete(Promo $promo)
    {
        $promo->delete();
        session()->flash('success', 'Promo berhasil dihapus.');
    }

    public function toggleActive(Promo $promo)
    {
        $promo->update(['is_active' => ! $promo->is_active]);
        session()->flash('success', 'Status promo berhasil diubah.');
    }

    public function render()
    {
        $promos = Promo::with('product')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.promo.index', [
            'promos' => $promos,
        ]);
    }
}

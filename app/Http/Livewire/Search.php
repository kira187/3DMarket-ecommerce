<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class Search extends Component
{
    public $search, $open = false;

    public function render()
    {
        if ($this->search) {
            $products = Product::where('name', 'LIKE', '%' . $this->search . '%')
                                ->where('status', 2)
                                ->take(8)
                                ->get();
        } else {
            $products = [];
        }

        return view('livewire.search', compact('products'));
    }

    public function updatedSearch($value)
    {
        if ($value) {
            $this->open = true;
        } else {
            $this->open = false;
        }
    }
}

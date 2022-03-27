<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Size;

class AddCartItemSize extends Component
{
    public $product, $sizes, $qty = 1, $stock = 0;
    public $size_selected = "";
    public $color_selected = "";
    public $colors = [];

    public function mount()
    {
        $this->sizes = $this->product->sizes;
    }

    public function render()
    {
        return view('livewire.add-cart-item-size');
    }

    public function updatedSizeSelected($value)
    {
        $size = Size::find($value);
        $this->colors = $size->colors;
    }

    public function updatedColorSelected($value)
    {
        $this->stock = 10;
        // $size = Size::find($this->size_selected); 
        // $this->stock = $size->colors->find($value)->pivot->quantity;
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItemColor extends Component
{
    public $product, $colors, $color_selected = "";
    public $qty = 1;
    public $stock = 0;

    public function mount()
    {
        $this->colors = $this->product->colors;
    }

    public function render()
    {
        return view('livewire.add-cart-item-color');
    }

    public function updatedColorSelected($value)
    {
        $this->stock = $this->product->colors->find($value)->pivot->quantity;
    }

    public function decrement(){
        $this->qty = $this->qty - 1;
    }

    public function increment(){
        $this->qty = $this->qty + 1;
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItem extends Component
{
    public $product, $qty = 1, $stock;

    public function mount()
    {
        $this->stock = $this->product->quantity;
    }

    public function render()
    {
        return view('livewire.add-cart-item');
    }

    public function increment()
    {
        $this->qty = $this->qty + 1;
    }

    public function decrement()
    {
        $this->qty = $this->qty - 1;
    }
}

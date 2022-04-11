<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShoppingCart extends Component
{
    protected $listeners = ['render'];

    public function destroyCart()
    {
        Cart::destroy();
        $this->emitTo('dropdown-cart', 'render');
    }

    public function deleteItem($rowId)
    {
        Cart::remove($rowId);
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.shopping-cart');
    }
}

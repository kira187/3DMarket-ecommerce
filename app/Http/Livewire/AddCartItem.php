<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AddCartItem extends Component
{
    public $product, $qty = 1, $stock;
    public $options = [
        'color_id' => null,
        'size_id' => null
    ];

    public function mount()
    {
        $this->stock = stock_available($this->product->id);
        $this->options['image'] = Storage::url($this->product->images->first()->url);
    }

    public function increment()
    {
        $this->qty = $this->qty + 1;
    }
    
    public function decrement()
    {
        $this->qty = $this->qty - 1;
    }
    
    public function addItem()
    {
        Cart::add([
            'id' => $this->product->id, 
            'name' => $this->product->name, 
            'qty' => $this->qty, 
            'price' => $this->product->price, 
            'weight' => 550,
            'options' => $this->options
        ]);
        
        $this->stock = stock_available($this->product->id);
        $this->reset('qty');
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item');
    }
}

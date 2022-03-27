<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AddCartItemColor extends Component
{
    public $product, $colors, $color_selected = "";
    public $qty = 1, $stock = 0;
    public $options = [ 'size_id' => null ];

    public function mount()
    {
        $this->colors = $this->product->colors;
        $this->options['image'] = Storage::url($this->product->images->first()->url);
    }

    public function updatedColorSelected($value)
    {
        $color = $this->product->colors->find($value);
        $this->stock = stock_available($this->product->id, $color->id);
        $this->options['color'] = $color->name;
    }
    
    public function decrement(){
        $this->qty = $this->qty - 1;
    }
    
    public function increment(){
        $this->qty = $this->qty + 1;
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
        
        $this->stock = stock_available($this->product->id, $this->color_selected);
        $this->reset('qty');
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item-color');
    }
}

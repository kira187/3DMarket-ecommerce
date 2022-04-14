<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Size;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AddCartItemSize extends Component
{
    public $product, $sizes, $qty = 1, $stock = 0;
    public $size_selected = "", $color_selected = "";
    public $colors = [], $options = [];

    public function mount()
    {
        $this->sizes = $this->product->sizes;
        $this->options['image'] = Storage::url($this->product->images->first()->url);
    }

    public function updatedSizeSelected($value)
    {
        $size = Size::find($value);
        $this->colors = $size->colors;
        $this->options['size'] = $size->name;
        $this->options['size_id'] = $size->id;
    }

    public function updatedColorSelected($value)
    {
        $size = Size::find($this->size_selected);
        $color = $size->colors->find($value);
        $this->stock = stock_available($this->product->id, $color->id, $size->id);
        $this->options['color'] = $color->name;
        $this->options['color_id'] = $color->id;
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
        
        $this->stock = stock_available($this->product->id, $this->color_selected, $this->size_selected);
        $this->reset('qty');
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item-size');
    }
}

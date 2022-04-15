<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Size;

class SizeProduct extends Component
{
    public $name, $product, $openModal = false;
    public $size, $name_edit;

    protected $rules = [
        'name' => 'required',
    ];

    protected $listeners = ['delete'];

    public function save()
    {
        $this->validate();
        $this->product->sizes()->create([
            'name' => $this->name
        ]);

        $this->reset('name');
        $this->product = $this->product->fresh();
    }

    public function delete(Size $size)
    {
        $size->delete();
        $this->product = $this->product->fresh();
    }

    public function edit(Size $size)
    {
        $this->openModal = true;
        $this->name_edit = $size->name;
        $this->size = $size;
    }

    public function update()
    {
        $this->validate([
            'name_edit' => 'required'
        ]);

        $this->size->name = $this->name_edit;
        $this->size->save();
        $this->product = $this->product->fresh();
        $this->openModal = false;
    }

    public function render()
    {
        $sizes = $this->product->sizes;

        return view('livewire.admin.size-product', compact('sizes'));
    }
}

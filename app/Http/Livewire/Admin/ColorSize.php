<?php

namespace App\Http\Livewire\Admin;

use App\Models\Color;
use App\Models\ColorSize as Pivot;
use Livewire\Component;

class ColorSize extends Component
{
    public $size, $colors, $color_id, $quantity, $pivot, $openModal = false;
    public $pivot_color_id, $pivot_quantity;

    protected $rules = [
        'color_id' => 'required',
        'quantity' => 'required|numeric',
    ];

    public function mount()
    {
        $this->colors = Color::all();
    }

    public function save()
    {
        $this->validate();
        $this->size->colors()->attach([
            $this->color_id => [
                'quantity' => $this->quantity
            ]
        ]);

        $this->reset(['color_id', 'quantity']);
        $this->emit('saved');
        $this->size = $this->size->fresh();
    }

    public function edit(Pivot $pivot)
    {
        $this->openModal = true;
        $this->pivot = $pivot;
        $this->pivot_color_id = $this->pivot->color_id;
        $this->pivot_quantity = $this->pivot->quantity;
    }

    public function update()
    {
        $this->pivot->color_id = $this->pivot_color_id;
        $this->pivot->quantity = $this->pivot_quantity;
        $this->pivot->save();

        $this->size = $this->size->fresh();
        $this->openModal = false;
    }

    public function render()
    {
        $size_colors = $this->size->colors;

        return view('livewire.admin.color-size', compact('size_colors'));
    }
}

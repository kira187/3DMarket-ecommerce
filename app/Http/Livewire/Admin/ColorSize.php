<?php

namespace App\Http\Livewire\Admin;

use App\Models\Color;
use App\Models\ColorSize as Pivot;
use Livewire\Component;

class ColorSize extends Component
{
    public $size, $colors, $color_id, $quantity, $pivot, $openModal = false;
    public $pivot_color_id, $pivot_quantity, $confirmingPivotDeletion = false, $deleteId = '';

    protected $listeners = ['delete'];

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

        $pivot = Pivot::where('color_id', $this->color_id)
                    ->where('size_id', $this->size->id)
                    ->first();

        if ($pivot) {
            $pivot->quantity = $pivot->quantity + $this->quantity;
            $pivot->save();
        } else {
            $this->size->colors()->attach([
                $this->color_id => [
                    'quantity' => $this->quantity
                ]
            ]);
        }

        $this->reset(['color_id', 'quantity']);
        $this->size = $this->size->fresh();        
        $this->emit('saved');
        $this->emitToast('Exito', 'success', 'Articulo '. ($pivot ? 'actualizado' : 'creado') .' exitosamente');
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
        
        $this->emitToast('Exito', 'success', 'Articulo actualizado exitosamente');
    }

    public function deletePivotId($id)
    {
        $this->confirmingPivotDeletion = true;
        $this->deleteId = $id;
    }
    
    public function delete()
    {
        Pivot::find($this->deleteId)->delete();
        $this->deleteId = '';
        $this->size = $this->size->fresh();
        $this->confirmingPivotDeletion = false;
        $this->dispatchBrowserEvent('alert',
            [ 'title' => 'Exito' ?? '', 'type' => 'success',  'message' => 'Producto eliminado correctamente']);
    }

    public function emitToast($title = null, $type, $message)
    {
        $this->dispatchBrowserEvent('alert',
            [ 'title' => $title ?? '', 'type' => $type,  'message' => $message]);
    }

    public function render()
    {
        $size_colors = $this->size->colors;

        return view('livewire.admin.color-size', compact('size_colors'));
    }
}

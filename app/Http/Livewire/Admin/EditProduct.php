<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class EditProduct extends Component
{
    public $product, $categories;
    public $category_id, $subcategories, $brands, $slug;

    protected $listeners = ['refreshProduct', 'deleteImage'];

    protected $rules = [
        'category_id' => 'required',
        'product.subcategory_id' => 'required',
        'product.brand_id' => 'required',
        'product.name' => 'required',
        'slug' => 'required|unique:products,slug',
        'product.description' => 'required',
        'product.price' => 'required',
        'product.quantity' => 'numeric',
    ];
    
    public function mount(Product $product)
    {
        $this->product = $product;    
        $this->categories = Category::all();
        $this->category_id = $product->subcategory->category->id;
        $this->subcategories = Subcategory::where('category_id', $this->category_id)->get();
        $this->slug = $this->product->slug;
        $this->brands = Brand::whereHas('categories', function(Builder $query){
            $query->where('category_id', $this->category_id);
        })->get();
    }

    public function updatedCategoryId($value)
    {
        $this->subcategories = Subcategory::where('category_id', $value)->get();
        $this->brands = Brand::whereHas('categories', function(Builder $query) use ($value){
            $query->where('category_id', $value);        
        })->get();

        $this->product->subcategory_id = "";
        $this->product->brand_id = "";
    }
    
    public function updatedProductName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $rules = $this->rules;
        $rules['slug'] = 'required|unique:products,slug,' . $this->product->id;

        if ($this->product->subcategory_id) {
            if (!$this->subcategory->color && !$this->subcategory->size) {
                $rules['product.quantity'] = 'required|numeric';
            }
        }

        $this->validate($rules);
        $this->product->slug = $this->slug;
        $this->product->save();
        $this->emit('updated');
        $this->dispatchBrowserEvent('alert',
        [ 'title' => 'Exito', 'type' => 'success',  'message' => 'Producto actualizado satisfactoriamente']);
    }

    public function deleteImage(Image $image)
    {
        Storage::delete([$image->url]);
        $image->delete();
        $this->product = $this->product->fresh();

        $this->dispatchBrowserEvent('alert',
            [ 'title' => 'Exito', 'type' => 'success',  'message' => 'Imagen eliminada satisfactoriamente']);
    }

    public function refreshProduct()
    {
        $this->product = $this->product->fresh();
        $this->dispatchBrowserEvent('alert',
            [ 'title' => 'Exito', 'type' => 'success',  'message' => 'Imagenes subidas satisfactoriamente']);
    }

    public function getSubcategoryProperty()
    {
        return Subcategory::find($this->product->subcategory_id);
    }

    public function render()
    {
        return view('livewire.admin.edit-product')->layout('layouts.adminv2');
    }
}

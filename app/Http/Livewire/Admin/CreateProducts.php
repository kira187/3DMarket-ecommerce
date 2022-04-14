<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Illuminate\Support\Str;

class CreateProducts extends Component
{
    public $categories, $subcategories = [], $brands = [];
    public  $category_id = "", $subcategory_id = "", $brand_id = "";
    public $name, $slug, $description;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function updatedCategoryId($value)
    {
        $this->subcategories = Subcategory::where('category_id', $value)->get();
        $this->brands = Brand::whereHas('categories', function(Builder $query) use ($value){
            $query->where('category_id', $value);        
        })->get();
        $this->reset(['subcategory_id', 'brand_id']);
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function render()
    {
        return view('livewire.admin.create-products')->layout('layouts.admin');
    }
}
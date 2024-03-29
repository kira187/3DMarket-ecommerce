<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;
    
    const BORRADOR = 1;
    const PUBLICADO = 2;

    protected $fillable = ['name', 'slug', 'description', 'price', 'subcategory_id', 'brand_id', 'quantity'];

    // Accesors
    public function getStockAttribute()
    {
        if ($this->subcategory->size) {
            return ColorSize::whereHas('size.product', function(Builder $query){
                $query->where('id', $this->id);
            })->sum('quantity');
        } elseif($this->subcategory->color) {
            return ColorProduct::whereHas('product', function(Builder $query){
                $query->where('id', $this->id);
            })->sum('quantity');
        } else {
            $this->quantity;
        }   
    }

    // Relationship 1:m
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    // Relationship 1:m inverse
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Relationship 1:m inverse
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // Relationship m:n
    public function colors()
    {
        return $this->belongsToMany(Color::class)->withPivot('quantity', 'id');
    }

    // Relationship polymorph
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    //Friendly url's
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

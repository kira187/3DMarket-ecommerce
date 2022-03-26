<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'image'];

    //Relationship 1:n
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    //Relationship m:m
    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    // Relationship 1:m
    public function products()
    {
        return $this->hasManyThrough(Product::class, SubCategory::class);
    }

    //Friendly url's
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

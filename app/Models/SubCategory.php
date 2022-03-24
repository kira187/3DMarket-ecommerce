<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'color', 'size', 'category_id'];

    //Relationship 1:m
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relationship 1:m inverse
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

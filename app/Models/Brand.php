<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    // Relationship n:m
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Relationship 1:m
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}

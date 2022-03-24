<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'product_id'];


    // Relationship 1:m inverse
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function colores()
    {
        return $this->belongsToMany(Color::class);
    }
}

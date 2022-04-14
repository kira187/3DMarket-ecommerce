<?php

use App\Models\Product;
use App\Models\Size;
use Gloudemans\Shoppingcart\Facades\Cart;

function stock($product_id, $color_id = null, $size_id = null)
{
    $product = Product::find($product_id);

    if ($size_id) {
        $size = Size::find($size_id);
        $stock = $size->colors->find($color_id)->pivot->quantity;
    } elseif ($color_id) {
        $stock = $product->colors->find($color_id)->pivot->quantity;
    }else {
        $stock = $product->quantity;
    }

    return $stock;
}

function qty_added($product_id, $color_id = null, $size_id = null)
{
    $cart = Cart::content();

    $item = $cart->where('id', $product_id)
        ->where('options.color_id', $color_id)
        ->where('options.size_id', $size_id)
        ->first();

    if ($item) {
        return $item->qty;
    } else {
        return 0;
    }
}

function stock_available($product_id, $color_id = null, $size_id = null)
{
    return stock($product_id, $color_id, $size_id) - qty_added($product_id, $color_id, $size_id);
}

function discount_stock($item)
{
    $product = Product::find($item->id);
    $stock_available = stock_available($item->id, $item->options->color_id, $item->options->size_id);

    if ($item->options->size_id) {

        $size = Size::find($item->options->size_id);
        $size->colors()->updateExistingPivot(
            $item->options->color_id , ['quantity'=> $stock_available]
        );

    } elseif ($item->options->color_id) {

        $product->colors()->updateExistingPivot(
            $item->options->color_id , ['quantity'=> $stock_available]
        );

    } else {
        
        $product->quantity = $stock_available;
        $product->save();

    }
}

function recovery_stock($item)
{
    $product = Product::find($item->id);
    $stock = stock($item->id, $item->options->color_id, $item->options->size_id) + $item->qty;

    if ($item->options->size_id) {

        $size = Size::find($item->options->size_id);
        $size->colors()->updateExistingPivot(
            $item->options->color_id , ['quantity'=> $stock]
        );

    } elseif ($item->options->color_id) {

        $product->colors()->updateExistingPivot(
            $item->options->color_id , ['quantity'=> $stock]
        );

    } else {
        
        $product->quantity = $stock;
        $product->save();

    }
}
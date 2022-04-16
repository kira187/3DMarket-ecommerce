<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Admin\ShowProducts;
use App\Http\Livewire\Admin\CreateProducts;
use App\Http\Livewire\Admin\EditProduct;
use App\Http\Controllers\Admin\ProductController;

Route::get('/', ShowProducts::class)->name('admin.products.index');
Route::get('product/create', CreateProducts::class)->name('admin.products.create');
Route::get('product/{product}/edit', EditProduct::class)->name('admin.products.edit');
Route::post('products/{product}/files', [ProductController::class, 'files'])->name('admin.products.files');
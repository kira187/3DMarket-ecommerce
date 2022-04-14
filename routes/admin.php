<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\ShowProducts;
use App\Http\Livewire\Admin\CreateProducts;

Route::get('/', ShowProducts::class)->name('admin.products.index');
Route::get('product/create', CreateProducts::class)->name('admin.products.create');
Route::get('product/{product}/edit', ShowProducts::class)->name('admin.products.edit');